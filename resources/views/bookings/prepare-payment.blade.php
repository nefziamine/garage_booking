@extends('layouts.app')

@section('title', 'Préparation du paiement - GarageBooking')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center space-x-4">
                <a href="{{ route('garages.show', $garage) }}" class="flex items-center space-x-2 text-gray-600 hover:text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span>Retour au garage</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">💳 Préparation du paiement</h1>
            <p class="text-gray-600">Vérifiez votre réservation et ajoutez des services complémentaires</p>
        </div>

        <!-- Booking Summary -->
        <div class="professional-card p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">📋 Récapitulatif de la réservation</h2>

            <div class="space-y-4">
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $service->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $garage->name }}</p>
                        <p class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($request->booking_date)->format('d/m/Y') }} à {{ $request->booking_time }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-blue-600">{{ $service->price }} DT</p>
                        <p class="text-sm text-gray-500">{{ $service->duration ?? 60 }} min</p>
                    </div>
                </div>
            </div>

            <div class="border-t pt-4 mt-4">
                <div class="flex justify-between items-center text-lg font-bold">
                    <span class="text-gray-900">Sous-total:</span>
                    <span class="text-blue-600" id="subtotal">{{ $service->price }} DT</span>
                </div>
            </div>
        </div>

        <!-- Recommended Services -->
        @if($recommendedServices && $recommendedServices->count() > 0)
        <div class="professional-card p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">💡 Services recommandés</h2>
            <p class="text-gray-600 mb-4">
                Basé sur votre véhicule et historique, nous vous suggérons ces services complémentaires :
            </p>

            <div class="space-y-3" id="recommended-services">
                @foreach($recommendedServices as $recService)
                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-100">
                    <div class="flex-1">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   name="additional_services[]"
                                   value="{{ $recService->id }}"
                                   id="service_{{ $recService->id }}"
                                   class="additional-service-checkbox mr-3 text-blue-600 focus:ring-blue-500">
                            <label for="service_{{ $recService->id }}" class="flex-1 cursor-pointer">
                                <div class="font-semibold text-gray-900">{{ $recService->name }}</div>
                                <div class="text-sm text-gray-600">{{ $recService->description ?? 'Service complémentaire' }}</div>
                            </label>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-blue-600">{{ $recService->price }} DT</div>
                        <div class="text-sm text-gray-500">
                            @if(method_exists($recService, 'getFormattedDurationAttribute'))
                                {{ $recService->getFormattedDurationAttribute() }}
                            @else
                                {{ $recService->duration ?? 60 }} min
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="border-t pt-4 mt-4">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-blue-700">Total des services supplémentaires:</span>
                    <span class="font-semibold text-blue-900" id="additional-total">0 DT</span>
                </div>
                <div class="flex justify-between items-center text-xl font-bold mt-2">
                    <span class="text-gray-900">Total à payer:</span>
                    <span class="text-blue-600" id="total">{{ $service->price }} DT</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Vehicle Info -->
        <div class="professional-card p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">🚗 Informations du véhicule</h2>

            <div class="grid md:grid-cols-3 gap-4">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-blue-600 text-2xl">🏷️</span>
                    </div>
                    <span class="font-semibold text-gray-700 block mb-2">Marque</span>
                    <p class="text-gray-900 text-lg">{{ $request->vehicle_info['brand'] }}</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-green-600 text-2xl">🚙</span>
                    </div>
                    <span class="font-semibold text-gray-700 block mb-2">Modèle</span>
                    <p class="text-gray-900 text-lg">{{ $request->vehicle_info['model'] }}</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-purple-600 text-2xl">📅</span>
                    </div>
                    <span class="font-semibold text-gray-700 block mb-2">Année</span>
                    <p class="text-gray-900 text-lg">{{ $request->vehicle_info['year'] }}</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="professional-card p-6">
            <form method="POST" action="{{ route('bookings.store', $garage) }}" id="payment-form">
                @csrf
                <input type="hidden" name="service_id" value="{{ $request->service_id }}">
                <input type="hidden" name="booking_date" value="{{ $request->booking_date }}">
                <input type="hidden" name="booking_time" value="{{ $request->booking_time }}">
                <input type="hidden" name="notes" value="{{ $request->notes }}">
                <input type="hidden" name="vehicle_info[brand]" value="{{ $request->vehicle_info['brand'] }}">
                <input type="hidden" name="vehicle_info[model]" value="{{ $request->vehicle_info['model'] }}">
                <input type="hidden" name="vehicle_info[year]" value="{{ $request->vehicle_info['year'] }}">

                <div class="flex space-x-4">
                    <a href="{{ route('bookings.create', $garage) }}" class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition-colors text-center">
                        ← Modifier la réservation
                    </a>
                    <button type="submit" class="flex-1 beautiful-button text-white py-3 px-6 rounded-lg font-semibold hover-scale">
                        💳 Procéder au paiement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Update totals when additional services are selected
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.additional-service-checkbox');
        const additionalTotalElement = document.getElementById('additional-total');
        const totalElement = document.getElementById('total');
        const subtotalElement = document.getElementById('subtotal');
        const originalTotal = {{ $service->price }};

        function updateTotals() {
            let additionalTotal = 0;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const serviceElement = checkbox.closest('.bg-blue-50');
                    const priceText = serviceElement.querySelector('.font-bold').textContent;
                    const price = parseFloat(priceText.replace(' DT', ''));
                    additionalTotal += price;
                }
            });

            additionalTotalElement.textContent = additionalTotal.toFixed(2) + ' DT';
            totalElement.textContent = (originalTotal + additionalTotal).toFixed(2) + ' DT';
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateTotals);
        });

        // Handle form submission to add selected services
        document.getElementById('payment-form').addEventListener('submit', function(e) {
            // Add selected additional services to form data
            const selectedServices = document.querySelectorAll('.additional-service-checkbox:checked');
            selectedServices.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'additional_services[]';
                input.value = checkbox.value;
                this.appendChild(input);
            });
        });
    });
</script>
@endsection