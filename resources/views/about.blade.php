@extends('layouts.app')

@section('title', 'À propos - GarageBooking')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Header Section -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">À propos de GarageBooking</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                La plateforme de référence pour la réservation de services automobiles en Tunisie
            </p>
        </div>

        <!-- Mission Section -->
        <div class="professional-card p-8 mb-12">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Notre Mission</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        GarageBooking révolutionne l'industrie automobile en Tunisie en connectant les automobilistes
                        avec des garages de confiance. Notre plateforme facilite la réservation de services automobiles
                        de qualité, garantissant transparence, fiabilité et satisfaction client.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white text-sm">✓</span>
                            </div>
                            <span class="text-gray-700">Connexion directe avec garages certifiés</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white text-sm">✓</span>
                            </div>
                            <span class="text-gray-700">Réservation instantanée 24h/24</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white text-sm">✓</span>
                            </div>
                            <span class="text-gray-700">Prix transparents et garantis</span>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="w-32 h-32 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-6xl">🚗</span>
                    </div>
                    <div class="text-4xl font-bold text-blue-600">500+</div>
                    <div class="text-gray-600">Garages partenaires</div>
                </div>
            </div>
        </div>

        <!-- Values Section -->
        <div class="grid md:grid-cols-3 gap-8 mb-12">
            <div class="professional-card p-6 text-center">
                <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4 text-white text-2xl">
                    🛡️
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Fiabilité</h3>
                <p class="text-gray-600">
                    Tous nos garages partenaires sont rigoureusement sélectionnés et régulièrement contrôlés
                    pour garantir des services de qualité supérieure.
                </p>
            </div>

            <div class="professional-card p-6 text-center">
                <div class="w-16 h-16 bg-green-600 rounded-xl flex items-center justify-center mx-auto mb-4 text-white text-2xl">
                    💰
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Transparence</h3>
                <p class="text-gray-600">
                    Prix clairs et sans surprises. Consultez les tarifs avant de réserver et payez
                    en ligne ou sur place selon vos préférences.
                </p>
            </div>

            <div class="professional-card p-6 text-center">
                <div class="w-16 h-16 bg-orange-600 rounded-xl flex items-center justify-center mx-auto mb-4 text-white text-2xl">
                    ⚡
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Rapidité</h3>
                <p class="text-gray-600">
                    Réservation en quelques clics, confirmation instantanée et service disponible
                    24h/24 et 7j/7 pour répondre à vos besoins urgents.
                </p>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="professional-card p-8 mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">GarageBooking en chiffres</h2>
            <div class="grid md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold text-blue-600 mb-2">500+</div>
                    <div class="text-gray-600">Garages partenaires</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-green-600 mb-2">24/7</div>
                    <div class="text-gray-600">Service disponible</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-orange-600 mb-2">50k+</div>
                    <div class="text-gray-600">Clients satisfaits</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-purple-600 mb-2">4.8/5</div>
                    <div class="text-gray-600">Note moyenne</div>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Notre Équipe</h2>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                Une équipe passionnée d'experts automobiles et de développeurs travaillant ensemble
                pour révolutionner l'expérience de réparation automobile en Tunisie.
            </p>
            <div class="flex justify-center">
                <a href="{{ route('contact') }}" class="beautiful-button px-8 py-4 text-white rounded-lg font-semibold text-lg shadow-lg hover-scale">
                    Nous contacter
                </a>
            </div>
        </div>
    </div>
</div>
@endsection