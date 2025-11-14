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
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="professional-card p-8 text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="text-green-600 text-4xl">✅</span>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">Paiement réussi !</h1>
            <p class="text-lg text-gray-600 mb-8">
                Votre réservation a été confirmée avec succès. Vous recevrez bientôt une confirmation par email.
            </p>

            <!-- Booking Details -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Détails de la réservation</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Service:</span>
                        <span class="text-gray-900">{{ $booking->service->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Garage:</span>
                        <span class="text-gray-900">{{ $booking->garage->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Date:</span>
                        <span class="text-gray-900">{{ $booking->booking_date->format('d/m/Y') }} à {{ $booking->booking_time->format('H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Montant payé:</span>
                        <span class="text-green-600 font-semibold">{{ $booking->paid_amount }} DT</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Statut:</span>
                        <span class="text-green-600 font-semibold">{{ $booking->getStatusLabelAttribute() }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-4">
                <a href="{{ route('bookings.show', $booking) }}" class="beautiful-button inline-block w-full py-3 px-6 text-white text-lg font-semibold rounded-lg hover-scale">
                    📋 Voir les détails complets
                </a>

                <div class="flex space-x-4">
                    <a href="{{ route('bookings.index') }}" class="flex-1 bg-gray-200 text-gray-800 py-3 px-6 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                        Mes réservations
                    </a>
                    <a href="{{ route('garages.index') }}" class="flex-1 bg-blue-100 text-blue-800 py-3 px-6 rounded-lg hover:bg-blue-200 transition-colors font-medium">
                        Réserver un autre service
                    </a>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="mt-8 text-center text-sm text-gray-500">
                <div class="flex items-center justify-center space-x-4">
                    <span>🔒 Transaction sécurisée</span>
                    <span>🛡️ SSL chiffré</span>
                    <span>💳 Paiement Stripe</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection