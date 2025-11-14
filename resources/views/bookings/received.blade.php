@extends('layouts.app')

@section('title', 'Réservations Reçues - GarageBooking')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Réservations Reçues</h1>
                    <p class="text-gray-600 mt-1">{{ $bookings->count() }} réservation{{ $bookings->count() > 1 ? 's' : '' }}</p>
                </div>
                <a href="{{ route('profile') }}" class="beautiful-button px-6 py-3 text-white rounded-lg font-medium hover-scale">
                    🏪 Mon profil garage
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <span class="text-green-500 mr-2">✓</span>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <span class="text-red-500 mr-2">⚠</span>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if($bookings->count() > 0)
            <!-- Filter Tabs -->
            <div class="mb-6">
                <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg w-fit">
                    <a href="{{ route('bookings.received') }}"
                       class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ !request('status') ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                        Toutes
                    </a>
                    <a href="{{ route('bookings.received', ['status' => 'pending']) }}"
                       class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ request('status') === 'pending' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                        En attente
                    </a>
                    <a href="{{ route('bookings.received', ['status' => 'confirmed']) }}"
                       class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ request('status') === 'confirmed' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                        Confirmées
                    </a>
                    <a href="{{ route('bookings.received', ['status' => 'completed']) }}"
                       class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ request('status') === 'completed' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                        Terminées
                    </a>
                </div>
            </div>

            <!-- Bookings List -->
            <div class="space-y-6">
                @foreach($bookings as $booking)
                <div class="professional-card p-6 hover-scale">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <!-- Booking Info -->
                        <div class="flex-1">
                            <div class="flex items-start space-x-4 mb-4">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <span class="text-green-600 text-xl">👤</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $booking->user->name }}</h3>
                                    <p class="text-gray-600 text-sm mb-2">{{ $booking->user->email }}</p>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span>📞 {{ $booking->user->phone ?? 'Non spécifié' }}</span>
                                        <span>📍 {{ $booking->user->city ?? 'Non spécifiée' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Service</span>
                                    <p class="text-gray-900 font-medium">{{ $booking->service->name ?? 'Service non spécifié' }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Date & Heure</span>
                                    <p class="text-gray-900 font-medium">
                                        {{ $booking->booking_date->format('d/m/Y') }} à {{ $booking->booking_time->format('H:i') }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Prix</span>
                                    <p class="text-green-600 font-bold text-lg">{{ $booking->total_price }} DT</p>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Statut</span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($booking->status === 'confirmed') bg-blue-100 text-blue-800
                                        @elseif($booking->status === 'completed') bg-green-100 text-green-800
                                        @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        @if($booking->status === 'pending') ⏳ En attente
                                        @elseif($booking->status === 'confirmed') ✅ Confirmée
                                        @elseif($booking->status === 'completed') 🎉 Terminée
                                        @elseif($booking->status === 'cancelled') ❌ Annulée
                                        @else {{ ucfirst($booking->status) }}
                                        @endif
                                    </span>
                                </div>
                            </div>

                            @if($booking->notes)
                                <div class="mb-4">
                                    <span class="text-sm font-medium text-gray-500">Notes du client</span>
                                    <p class="text-gray-700 bg-gray-50 p-3 rounded-lg">{{ $booking->notes }}</p>
                                </div>
                            @endif

                            @if($booking->vehicle_info)
                                <div class="mb-4">
                                    <span class="text-sm font-medium text-gray-500">Véhicule</span>
                                    <p class="text-gray-700">
                                        @if(is_array($booking->vehicle_info))
                                            {{ $booking->vehicle_info['brand'] ?? '' }} {{ $booking->vehicle_info['model'] ?? '' }}
                                            @if(isset($booking->vehicle_info['year'])) ({{ $booking->vehicle_info['year'] }}) @endif
                                        @else
                                            {{ $booking->vehicle_info }}
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col space-y-3 lg:min-w-[200px]">
                            <a href="{{ route('bookings.show', $booking) }}"
                               class="bg-gray-100 text-gray-700 py-2 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors text-center">
                                Voir détails
                            </a>

                            @if($booking->status === 'pending')
                                <form method="POST" action="{{ route('bookings.confirm', $booking) }}" class="w-full">
                                    @csrf
                                    <button type="submit"
                                            class="w-full bg-blue-100 text-blue-700 py-2 px-4 rounded-lg font-medium hover:bg-blue-200 transition-colors">
                                        Confirmer
                                    </button>
                                </form>
                            @endif

                            @if($booking->status === 'confirmed')
                                <form method="POST" action="{{ route('bookings.complete', $booking) }}" class="w-full">
                                    @csrf
                                    <button type="submit"
                                            class="w-full bg-green-100 text-green-700 py-2 px-4 rounded-lg font-medium hover:bg-green-200 transition-colors">
                                        Marquer terminée
                                    </button>
                                </form>
                            @endif

                            @if($booking->status === 'confirmed')
                                <div class="text-center">
                                    <div class="text-sm text-gray-500 mb-2">
                                        @if($booking->payment_status === 'paid')
                                            Confirmée automatiquement (paiement effectué)
                                        @else
                                            Code de confirmation
                                        @endif
                                    </div>
                                    <div class="font-mono text-lg font-bold text-blue-600 bg-blue-50 p-2 rounded">
                                        {{ $booking->confirmation_code ?? 'GB-' . $booking->id }}
                                    </div>
                                    @if($booking->payment_status === 'paid')
                                        <div class="text-xs text-green-600 mt-2">
                                            💳 Paiement reçu - Prêt à commencer le travail
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($bookings->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $bookings->links() }}
            </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-gray-400 text-4xl">📋</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune réservation reçue</h3>
                <p class="text-gray-600 mb-8">Vous n'avez pas encore reçu de réservations. Continuez à promouvoir votre garage !</p>
                <a href="{{ route('profile.edit') }}" class="beautiful-button px-8 py-4 text-white rounded-lg font-semibold hover-scale">
                    ✏️ Modifier mon profil
                </a>
            </div>
        @endif
    </div>
</div>
@endsection