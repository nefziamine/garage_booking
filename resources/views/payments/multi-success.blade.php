@extends('layouts.app')

@section('title', 'Paiement réussi - GarageBooking')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center space-x-4">
                <a href="{{ route('bookings.index') }}" class="flex items-center space-x-2 text-gray-600 hover:text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span>Mes réservations</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Success Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="professional-card p-8 text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="text-green-600 text-4xl">✅</span>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">Paiement réussi !</h1>
            <p class="text-lg text-gray-600 mb-8">
                Toutes vos réservations ont été confirmées avec succès. Vous recevrez bientôt une confirmation par email.
            </p>

            @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <span class="text-green-400 text-xl">✓</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="space-y-4">
                <a href="{{ route('bookings.index') }}" class="beautiful-button inline-block w-full py-3 px-6 text-white text-lg font-semibold rounded-lg hover-scale">
                    📋 Voir mes réservations
                </a>

                <div class="flex space-x-4">
                    <a href="{{ route('garages.index') }}" class="flex-1 bg-blue-100 text-blue-800 py-3 px-6 rounded-lg hover:bg-blue-200 transition-colors font-medium text-center">
                        Réserver un autre service
                    </a>
                    <a href="{{ route('welcome') }}" class="flex-1 bg-gray-100 text-gray-800 py-3 px-6 rounded-lg hover:bg-gray-200 transition-colors font-medium text-center">
                        Retour à l'accueil
                    </a>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="mt-8 text-center text-sm text-gray-500">
                <div class="flex items-center justify-center space-x-4">
                    <span>🔒 Transaction sécurisée</span>
                    <span>🛡️ SSL chiffré</span>
                    <span>💳 Toutes cartes acceptées</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection