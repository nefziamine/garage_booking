<!-- Payment Modal Content -->
<div class="space-y-6">
    <!-- Booking Summary -->
    <div class="bg-gray-50 rounded-lg p-4">
        <h4 class="text-lg font-semibold text-gray-900 mb-3">📋 Récapitulatif de la réservation</h4>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-600">Service:</span>
                <span class="font-medium">{{ $service->name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Garage:</span>
                <span class="font-medium">{{ $garage->name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Date & Heure:</span>
                <span class="font-medium">{{ \Carbon\Carbon::parse($request->booking_date)->format('d/m/Y') }} à {{ $request->booking_time }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Véhicule:</span>
                <span class="font-medium">{{ $request->vehicle_info['brand'] }} {{ $request->vehicle_info['model'] }} ({{ $request->vehicle_info['year'] }})</span>
            </div>
            <div class="flex justify-between border-t pt-2">
                <span class="text-gray-900 font-semibold">Prix du service:</span>
                <span class="font-bold text-blue-600">{{ $service->price }} DT</span>
            </div>
        </div>
    </div>

    <!-- Recommended Services -->
    @if($recommendedServices && $recommendedServices->count() > 0)
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-center mb-3">
            <span class="text-blue-600 mr-2">💡</span>
            <h4 class="text-sm font-semibold text-blue-900">Services recommandés pour votre véhicule</h4>
        </div>
        <p class="text-sm text-blue-700 mb-3">
            Basé sur votre véhicule et historique, nous suggérons ces services complémentaires :
        </p>

        <div class="space-y-3" id="recommended-services">
            @foreach($recommendedServices as $recService)
            <div class="flex items-center justify-between bg-white rounded-lg p-3 border border-blue-100">
                <div class="flex-1">
                    <div class="flex items-center">
                        <input type="checkbox"
                               name="additional_services[]"
                               value="{{ $recService->id }}"
                               id="modal_service_{{ $recService->id }}"
                               class="additional-service-checkbox mr-3 text-blue-600 focus:ring-blue-500">
                        <label for="modal_service_{{ $recService->id }}" class="flex-1 cursor-pointer">
                            <div class="font-medium text-gray-900">{{ $recService->name }}</div>
                            <div class="text-sm text-gray-600">{{ $recService->description ?? 'Service complémentaire' }}</div>
                        </label>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-semibold text-blue-600">{{ $recService->price }} DT</div>
                    <div class="text-sm text-gray-500">{{ $recService->getFormattedDurationAttribute() }}</div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4 pt-4 border-t border-blue-200">
            <div class="flex justify-between items-center text-sm">
                <span class="text-blue-700">Total des services supplémentaires:</span>
                <span class="font-semibold text-blue-900" id="modal_additional_total">0 DT</span>
            </div>
            <div class="flex justify-between items-center text-lg font-bold mt-2">
                <span class="text-blue-900">Total à payer:</span>
                <span class="text-blue-600" id="modal_total">{{ $service->price }} DT</span>
            </div>
        </div>
    </div>
    @endif

    <!-- Payment Form -->
    <form id="modal-payment-form" method="POST" action="{{ route('bookings.store', $garage) }}">
        @csrf
        <input type="hidden" name="service_id" value="{{ $request->service_id }}">
        <input type="hidden" name="booking_date" value="{{ $request->booking_date }}">
        <input type="hidden" name="booking_time" value="{{ $request->booking_time }}">
        <input type="hidden" name="notes" value="{{ $request->notes }}">
        <input type="hidden" name="vehicle_info[brand]" value="{{ $request->vehicle_info['brand'] }}">
        <input type="hidden" name="vehicle_info[model]" value="{{ $request->vehicle_info['model'] }}">
        <input type="hidden" name="vehicle_info[year]" value="{{ $request->vehicle_info['year'] }}">

        @if($isTestMode)
        <!-- Test Mode Notice -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
            <div class="flex items-center">
                <span class="text-yellow-600 mr-2">🧪</span>
                <div>
                    <h4 class="text-sm font-semibold text-yellow-900">Mode de test activé</h4>
                    <p class="text-sm text-yellow-700">Aucun paiement réel ne sera effectué.</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Payment Buttons -->
        <div class="flex space-x-3">
            <button type="button" onclick="closePaymentModal()" class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition-colors">
                ❌ Annuler
            </button>
            <button type="submit" id="modal-submit-btn" class="flex-1 beautiful-button text-white py-3 px-6 rounded-lg font-semibold hover-scale">
                @if($isTestMode)
                    🧪 Payer en mode test
                @else
                    💳 Payer maintenant
                @endif
            </button>
        </div>
    </form>
</div>

<script>
    // Update totals when additional services are selected
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.additional-service-checkbox');
        const additionalTotalElement = document.getElementById('modal_additional_total');
        const totalElement = document.getElementById('modal_total');
        const originalTotal = {{ $service->price }};

        function updateTotals() {
            let additionalTotal = 0;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const serviceElement = checkbox.closest('.bg-white');
                    const priceText = serviceElement.querySelector('.font-semibold').textContent;
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
    });
</script>