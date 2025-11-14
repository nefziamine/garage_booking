@extends('layouts.app')

@section('title', 'Choisir votre inscription - GarageBooking')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 hover-glow">
                <span class="text-white font-bold text-3xl">👥</span>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Choisissez votre type de compte
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Rejoignez GarageBooking selon votre profil et commencez dès aujourd'hui
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Client Card -->
            <div class="professional-card p-8 hover-scale cursor-pointer group" onclick="window.location.href='{{ route('register.client') }}'">
                <div class="text-center">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-blue-200 transition-colors">
                        <span class="text-blue-600 text-3xl">👤</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        Compte Client
                    </h3>
                    <p class="text-gray-600 mb-6">
                        Vous cherchez un garagiste pour réparer votre véhicule ?
                        Créez votre compte client pour bénéficier de :
                    </p>
                    <ul class="text-left space-y-3 mb-8">
                        <li class="flex items-center">
                            <span class="text-blue-500 mr-3">✓</span>
                            <span class="text-gray-700">Recherche de garages par localisation</span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-blue-500 mr-3">✓</span>
                            <span class="text-gray-700">Comparaison des prix et services</span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-blue-500 mr-3">✓</span>
                            <span class="text-gray-700">Réservation de rendez-vous en ligne</span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-blue-500 mr-3">✓</span>
                            <span class="text-gray-700">Système d'avis et commentaires</span>
                        </li>
                    </ul>
                    <button class="beautiful-button w-full text-white py-3 px-6 rounded-lg font-semibold hover-scale">
                        Créer un compte client
                    </button>
                </div>
            </div>

            <!-- Garage Card -->
            <div class="professional-card p-8 hover-scale cursor-pointer group" onclick="window.location.href='{{ route('register.garage') }}'">
                <div class="text-center">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-green-200 transition-colors">
                        <span class="text-green-600 text-3xl">🔧</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        Compte Garage
                    </h3>
                    <p class="text-gray-600 mb-6">
                        Vous êtes garagiste et voulez développer votre activité ?
                        Créez votre compte professionnel pour :
                    </p>
                    <ul class="text-left space-y-3 mb-8">
                        <li class="flex items-center">
                            <span class="text-green-500 mr-3">✓</span>
                            <span class="text-gray-700">Présentation de votre garage</span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-3">✓</span>
                            <span class="text-gray-700">Gestion des rendez-vous en ligne</span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-3">✓</span>
                            <span class="text-gray-700">Augmentation de votre clientèle</span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-green-500 mr-3">✓</span>
                            <span class="text-gray-700">Outils de gestion professionnelle</span>
                        </li>
                    </ul>
                    <button class="w-full bg-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 transition-colors hover-scale">
                        Créer un compte garage
                    </button>
                </div>
            </div>
        </div>

        <!-- Benefits Section -->
        <div class="mt-16 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">
                Pourquoi créer un compte GarageBooking ?
            </h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="professional-card p-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <span class="text-blue-600">🔒</span>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Sécurisé</h4>
                    <p class="text-gray-600 text-sm">Vos données sont protégées par des standards de sécurité élevés</p>
                </div>
                <div class="professional-card p-6">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <span class="text-green-600">⚡</span>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Rapide</h4>
                    <p class="text-gray-600 text-sm">Inscription gratuite en moins de 2 minutes</p>
                </div>
                <div class="professional-card p-6">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <span class="text-purple-600">🎯</span>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Efficace</h4>
                    <p class="text-gray-600 text-sm">Outils conçus pour optimiser votre activité</p>
                </div>
            </div>
        </div>

        <!-- Login Link -->
        <div class="text-center mt-12">
            <p class="text-gray-600">
                Déjà un compte ?
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 transition-colors font-semibold">
                    Se connecter
                </a>
            </p>
        </div>
    </div>
</div>
@endsection