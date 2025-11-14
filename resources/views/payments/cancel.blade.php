@extends('layouts.app')

@section('title', 'Paiement annulé - GarageBooking')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center space-x-4">
                <a href="{{ route('bookings.show', $booking) }}" class="flex items-center space-x-2 text-gray-600 hover:text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span>Retour à la réservation</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Cancel Content -->
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="professional-card p-8 text-center">
            <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="text-yellow-600 text-4xl">⚠️</span>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">Paiement annulé</h1>
            <p class="text-lg text-gray-600 mb-8">
                Le paiement a été annulé. Votre réservation est toujours en attente et vous pouvez réessayer le paiement à tout moment.
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
                        <span class="font-medium text-gray-700">Montant:</span>
                        <span class="text-blue-600 font-semibold">{{ $booking->total_price }} DT</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700">Statut:</span>
                        <span class="text-yellow-600 font-semibold">{{ $booking->getStatusLabelAttribute() }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-4">
                <a href="{{ route('payments.checkout', $booking) }}" class="beautiful-button inline-block w-full py-3 px-6 text-white text-lg font-semibold rounded-lg hover-scale">
                    💳 Réessayer le paiement
                </a>

                <div class="flex space-x-4">
                    <a href="{{ route('bookings.show', $booking) }}" class="flex-1 bg-gray-200 text-gray-800 py-3 px-6 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                        Voir la réservation
                    </a>
                    <a href="{{ route('bookings.index') }}" class="flex-1 bg-blue-100 text-blue-800 py-3 px-6 rounded-lg hover:bg-blue-200 transition-colors font-medium">
                        Mes réservations
                    </a>
                </div>
            </div>

            <!-- Help Notice -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center">
                    <span class="text-blue-600 mr-2">💡</span>
                    <div class="text-left">
                        <h4 class="text-sm font-semibold text-blue-900">Besoin d'aide ?</h4>
                        <p class="text-sm text-blue-700">Si vous avez rencontré un problème lors du paiement, contactez notre support ou réessayez plus tard.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection