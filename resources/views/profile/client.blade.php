@extends('layouts.app')

@section('title', 'Mon Profil - GarageBooking')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Profile Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 hover-glow">
                    <span class="text-blue-600 text-3xl">👤</span>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Mon Profil Client</h1>
                <p class="text-gray-600">Bienvenue, {{ $user->name }} !</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <span class="text-green-500 mr-2">✓</span>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Profile Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Info Card -->
                <div class="professional-card p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="text-blue-600 mr-2">👤</span>
                        Informations Personnelles
                    </h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nom complet</label>
                                <p class="text-gray-900 font-medium">{{ $user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                                <p class="text-gray-900">{{ $user->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Téléphone</label>
                                <p class="text-gray-900">{{ is_array($user->phone) ? implode(', ', $user->phone) : ($user->phone ?? 'Non spécifié') }}</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Ville</label>
                                <p class="text-gray-900">{{ is_array($user->city) ? implode(', ', $user->city) : ($user->city ?? 'Non spécifiée') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Membre depuis</label>
                                <p class="text-gray-900">{{ $user->created_at->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Dernière connexion</label>
                                <p class="text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="professional-card p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="text-blue-600 mr-2">📅</span>
                        Mes Dernières Réservations
                    </h2>
                    @if($user->bookings && $user->bookings->count() > 0)
                        <div class="space-y-4">
                            @php $recentBookings = collect($user->bookings)->take(3); @endphp
                            @foreach($recentBookings as $booking)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <span class="text-blue-600 text-sm">🏪</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $booking->garage->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $booking->booking_date->format('d/m/Y') }} à {{ $booking->booking_time->format('H:i') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($booking->status === 'confirmed') bg-blue-100 text-blue-800
                                        @elseif($booking->status === 'completed') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        @if($booking->status === 'pending') En attente
                                        @elseif($booking->status === 'confirmed') Confirmée
                                        @elseif($booking->status === 'completed') Terminée
                                        @else {{ ucfirst($booking->status) }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('bookings.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Voir toutes mes réservations →
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-gray-400 text-2xl">📅</span>
                            </div>
                            <p class="text-gray-600 mb-4">Vous n'avez pas encore de réservations</p>
                            <a href="{{ route('garages.index') }}" class="beautiful-button px-6 py-2 text-white rounded-lg font-medium hover-scale">
                                Réserver maintenant
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="professional-card p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Actions Rapides</h3>
                    <div class="space-y-3">
                        <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <span class="text-blue-600">✏️</span>
                            <span class="text-gray-900 font-medium">Modifier mon profil</span>
                        </a>
                        <a href="{{ route('garages.index') }}" class="flex items-center space-x-3 p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <span class="text-green-600">🔍</span>
                            <span class="text-gray-900 font-medium">Chercher un garage</span>
                        </a>
                        <a href="{{ route('bookings.index') }}" class="flex items-center space-x-3 p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <span class="text-purple-600">📋</span>
                            <span class="text-gray-900 font-medium">Mes réservations</span>
                        </a>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="professional-card p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Mes Statistiques</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="text-blue-600">📋</span>
                                <span class="text-gray-700">Réservations</span>
                            </div>
                            <span class="font-bold text-blue-600">{{ $user->bookings ? collect($user->bookings)->count() : 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="text-green-600">⭐</span>
                                <span class="text-gray-700">Avis donnés</span>
                            </div>
                            <span class="font-bold text-green-600">0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="text-purple-600">🏪</span>
                                <span class="text-gray-700">Garages visités</span>
                            </div>
                            <span class="font-bold text-purple-600">{{ $user->bookings ? collect($user->bookings)->unique('garage_id')->count() : 0 }}</span>
                        </div>
                    </div>
                </div>

                <!-- Support -->
                <div class="professional-card p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Support</h3>
                    <div class="space-y-3">
                        <a href="#" class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <span class="text-gray-600">📞</span>
                            <span class="text-gray-900 font-medium">Centre d'aide</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <span class="text-gray-600">💬</span>
                            <span class="text-gray-900 font-medium">Contact</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection