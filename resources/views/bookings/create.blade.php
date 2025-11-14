@extends('layouts.app')

@section('title', 'Réserver - ' . $garage->name . ' - GarageBooking')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center space-x-4">
                <a href="{{ route('garages.show', $garage->id) }}" class="flex items-center space-x-2 text-gray-600 hover:text-blue-600">
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
        <!-- Garage Info Header -->
        <div class="professional-card p-6 mb-8">
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                    <span class="text-blue-600 text-2xl">🏪</span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $garage->name }}</h1>
                    <p class="text-gray-600">{{ $garage->address }}</p>
                    <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                        <span>📞 {{ $garage->phone }}</span>
                        <span>⭐ {{ number_format($garage->rating ?? 4.5, 1) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="professional-card p-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Réserver un rendez-vous</h2>
                <p class="text-gray-600">Choisissez votre service et planifiez votre visite</p>
            </div>

            <form method="POST" action="{{ route('bookings.prepare_payment') }}" class="space-y-8">
                @csrf
                <input type="hidden" name="garage_id" value="{{ $garage->id }}">

                <!-- Service Selection -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <span class="text-blue-600 mr-2">🔧</span>
                        Service souhaité
                    </h3>
                    <div>
                        <label for="service_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Sélectionnez un service
                        </label>
                        <select name="service_id" id="service_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="">Choisissez un service</option>
                            @if($services && $services->count() > 0)
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" data-price="{{ $service->price }}" data-duration="{{ $service->duration }}">
                                        {{ $service->name }} - {{ $service->price }} DT ({{ $service->duration }} min)
                                    </option>
                                @endforeach
                            @else
                                <option value="" disabled>Aucun service disponible</option>
                            @endif
                        </select>
                        @error('service_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Vehicle Information -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <span class="text-blue-600 mr-2">🚗</span>
                        Informations du véhicule
                    </h3>
                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label for="vehicle_brand" class="block text-sm font-medium text-gray-700 mb-2">
                                Marque
                            </label>
                            <input
                                id="vehicle_brand"
                                name="vehicle_info[brand]"
                                type="text"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Ex: Renault"
                                value="{{ old('vehicle_info.brand') }}"
                            >
                            @error('vehicle_info.brand')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="vehicle_model" class="block text-sm font-medium text-gray-700 mb-2">
                                Modèle
                            </label>
                            <input
                                id="vehicle_model"
                                name="vehicle_info[model]"
                                type="text"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Ex: Clio"
                                value="{{ old('vehicle_info.model') }}"
                            >
                            @error('vehicle_info.model')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="vehicle_year" class="block text-sm font-medium text-gray-700 mb-2">
                                Année
                            </label>
                            <input
                                id="vehicle_year"
                                name="vehicle_info[year]"
                                type="number"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Ex: 2020"
                                min="1900"
                                max="{{ date('Y') + 1 }}"
                                value="{{ old('vehicle_info.year') }}"
                            >
                            @error('vehicle_info.year')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Date and Time -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <span class="text-blue-600 mr-2">📅</span>
                        Date et heure
                    </h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Date de rendez-vous
                            </label>
                            <input
                                id="booking_date"
                                name="booking_date"
                                type="date"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                value="{{ old('booking_date') }}"
                            >
                            @error('booking_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="booking_time" class="block text-sm font-medium text-gray-700 mb-2">
                                Heure de rendez-vous
                            </label>
                            <input
                                id="booking_time"
                                name="booking_time"
                                type="time"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                min="08:00"
                                max="18:00"
                                value="{{ old('booking_time') }}"
                            >
                            @error('booking_time')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Notes -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <span class="text-blue-600 mr-2">📝</span>
                        Notes supplémentaires
                    </h3>
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Informations complémentaires (optionnel)
                        </label>
                        <textarea
                            id="notes"
                            name="notes"
                            rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Décrivez le problème ou ajoutez des informations importantes..."
                        >{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Service Recommendations -->
                @php
                    $recommendedServices = [];
                    if ($garage && isset($services)) {
                        // Simple recommendation logic for booking creation
                        $allServices = $services;
                        if (old('vehicle_info.year')) {
                            $vehicleAge = date('Y') - old('vehicle_info.year');
                            if ($vehicleAge >= 5) {
                                $recommendedServices = $allServices->filter(function ($service) {
                                    $name = strtolower($service->name ?? '');
                                    return str_contains($name, 'vidange') ||
                                           str_contains($name, 'entretien') ||
                                           str_contains($name, 'diagnostic');
                                })->take(2)->toArray();
                            }
                        }
                    }
                @endphp

                @if(!empty($recommendedServices))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center mb-3">
                        <span class="text-green-600 mr-2">💡</span>
                        <h4 class="text-sm font-semibold text-green-900">Services recommandés pour votre véhicule</h4>
                    </div>
                    <p class="text-sm text-green-700 mb-3">Basé sur l'âge de votre véhicule, nous vous suggérons ces services complémentaires :</p>
                    <div class="space-y-2">
                        @foreach($recommendedServices as $service)
                        <div class="flex items-center justify-between bg-white rounded p-2 border border-green-100">
                            <span class="text-sm font-medium text-gray-900">{{ $service->name ?? 'Service' }}</span>
                            <span class="text-sm text-green-600 font-semibold">{{ $service->price ?? 0 }} DT</span>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-green-600 mt-2">💳 Ces services pourront être ajoutés lors du paiement</p>
                </div>
                @endif

                <!-- Payment Notice -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <span class="text-blue-600 mr-2">💳</span>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-900">Mode de paiement sécurisé</h4>
                            <p class="text-sm text-blue-700">Le paiement sera effectué en toute sécurité avec possibilité d'ajouter des services complémentaires.</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6 border-t border-gray-200">
                    <button type="submit" class="beautiful-button w-full py-4 px-6 text-white text-lg font-semibold rounded-lg hover-scale">
                        💳 Procéder au paiement sécurisé
                    </button>
                    <p class="text-sm text-gray-600 text-center mt-2">
                        Paiement 100% sécurisé • Possibilité d'ajouter des services complémentaires
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection