@extends('layouts.app')

@section('title', 'Connexion - GarageBooking')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 hover-glow">
                <span class="text-white font-bold text-3xl">🔐</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Connexion à votre compte
            </h2>
            <p class="text-gray-600 mb-8">
                Accédez à votre espace GarageBooking
            </p>
        </div>

        <div class="professional-card p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse e-mail
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                        placeholder="votre@email.com"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Mot de passe
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                        placeholder="Votre mot de passe"
                    >
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember"
                            name="remember"
                            type="checkbox"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        >
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Se souvenir de moi
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="text-blue-600 hover:text-blue-800 transition-colors">
                            Mot de passe oublié ?
                        </a>
                    </div>
                </div>

                <button type="submit" class="beautiful-button w-full text-white py-3 px-6 rounded-lg font-semibold hover-scale">
                    Se connecter
                </button>

                <div class="text-center">
                    <p class="text-gray-600">
                        Pas encore de compte ?
                        <a href="{{ route('register.choice') }}" class="text-blue-600 hover:text-blue-800 transition-colors font-semibold">
                            Créer un compte
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Trust Indicators -->
        <div class="text-center">
            <div class="flex justify-center space-x-8 text-sm text-gray-500">
                <div class="flex items-center">
                    <span class="text-green-500 mr-2">✓</span>
                    Connexion sécurisée
                </div>
                <div class="flex items-center">
                    <span class="text-green-500 mr-2">✓</span>
                    Support 24/7
                </div>
            </div>
        </div>
    </div>
</div>
@endsection