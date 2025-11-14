@extends('layouts.app')

@section('title', 'Modifier mon profil garage - GarageBooking')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center space-x-4">
                <a href="{{ route('profile') }}" class="flex items-center space-x-2 text-gray-600 hover:text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span>Retour au profil</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <span class="text-green-500 mr-2">✓</span>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="professional-card p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Modifier mon profil garage</h1>
                <p class="text-gray-600">Mettez à jour les informations de votre garage</p>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Personal Information -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <span class="text-blue-600 mr-2">👤</span>
                        Informations personnelles
                    </h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Prénom
                            </label>
                            <input
                                id="first_name"
                                name="first_name"
                                type="text"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('first_name', $user->first_name) }}"
                            >
                            @error('first_name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom
                            </label>
                            <input
                                id="last_name"
                                name="last_name"
                                type="text"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('last_name', $user->last_name) }}"
                            >
                            @error('last_name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('email', $user->email) }}"
                            >
                            @error('email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Téléphone
                            </label>
                            <input
                                id="phone"
                                name="phone"
                                type="tel"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('phone', $user->phone) }}"
                            >
                            @error('phone')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Garage Information -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <span class="text-blue-600 mr-2">🏪</span>
                        Informations du garage
                    </h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="garage_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom du garage
                            </label>
                            <input
                                id="garage_name"
                                name="garage_name"
                                type="text"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('garage_name', $user->garage_name) }}"
                            >
                            @error('garage_name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                Ville
                            </label>
                            <input
                                id="city"
                                name="city"
                                type="text"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ old('city', $user->city) }}"
                            >
                            @error('city')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                Adresse complète
                            </label>
                            <textarea
                                id="address"
                                name="address"
                                rows="3"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Specialties -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <span class="text-blue-600 mr-2">🔧</span>
                        Spécialités
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @php
                            $availableSpecialties = ['Réparation moteur', 'Vidange', 'Freins', 'Électricité', 'Carrosserie', 'Climatisation', 'Pneus', 'Diagnostic'];
                            $currentSpecialties = old('specialties', $user->specialties ?? []);
                        @endphp

                        @foreach($availableSpecialties as $specialty)
                            <label class="flex items-center space-x-2">
                                <input
                                    type="checkbox"
                                    name="specialties[]"
                                    value="{{ $specialty }}"
                                    {{ in_array($specialty, $currentSpecialties) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                >
                                <span class="text-sm text-gray-700">{{ $specialty }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('specialties')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Experience -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <span class="text-blue-600 mr-2">📈</span>
                        Expérience
                    </h3>
                    <div>
                        <label for="experience_years" class="block text-sm font-medium text-gray-700 mb-2">
                            Années d'expérience
                        </label>
                        <select
                            id="experience_years"
                            name="experience_years"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            <option value="">Sélectionnez votre expérience</option>
                            <option value="1-2" {{ old('experience_years', $user->experience_years) == '1-2' ? 'selected' : '' }}>1-2 ans</option>
                            <option value="3-5" {{ old('experience_years', $user->experience_years) == '3-5' ? 'selected' : '' }}>3-5 ans</option>
                            <option value="6-10" {{ old('experience_years', $user->experience_years) == '6-10' ? 'selected' : '' }}>6-10 ans</option>
                            <option value="10+" {{ old('experience_years', $user->experience_years) == '10+' ? 'selected' : '' }}>Plus de 10 ans</option>
                        </select>
                        @error('experience_years')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password Change -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <span class="text-blue-600 mr-2">🔒</span>
                        Changer le mot de passe
                    </h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Nouveau mot de passe
                            </label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Laisser vide pour ne pas changer"
                            >
                            @error('password')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirmer le mot de passe
                            </label>
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Confirmer le nouveau mot de passe"
                            >
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6 border-t border-gray-200">
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('profile') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Annuler
                        </a>
                        <button type="submit" class="beautiful-button px-6 py-3 text-white rounded-lg hover-scale">
                            💾 Sauvegarder les modifications
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection