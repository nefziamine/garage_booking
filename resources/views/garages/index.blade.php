@extends('layouts.app')

@section('title', 'Garages - GarageBooking')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Search and Filter Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Garages Disponibles</h1>
                    <p class="text-gray-600 mt-1">{{ $garages->count() }} garages trouvés</p>
                </div>

                <!-- Search Form -->
                <form action="{{ route('garages.search') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <input
                        type="text"
                        name="q"
                        placeholder="Rechercher un garage..."
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="{{ request('q') }}"
                    >
                    <select name="city" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Toutes les villes</option>
                        <option value="Tunis" {{ request('city') == 'Tunis' ? 'selected' : '' }}>Tunis</option>
                        <option value="Sfax" {{ request('city') == 'Sfax' ? 'selected' : '' }}>Sfax</option>
                        <option value="Sousse" {{ request('city') == 'Sousse' ? 'selected' : '' }}>Sousse</option>
                        <option value="Monastir" {{ request('city') == 'Monastir' ? 'selected' : '' }}>Monastir</option>
                        <option value="Gabès" {{ request('city') == 'Gabès' ? 'selected' : '' }}>Gabès</option>
                    </select>
                    <button type="submit" class="beautiful-button px-6 py-2 text-white rounded-lg font-medium hover-scale">
                        🔍 Rechercher
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($garages->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($garages as $garage)
                <div class="professional-card p-6 hover-scale">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $garage->name }}</h3>
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <span class="text-yellow-400 mr-1">★★★★★</span>
                                <span>{{ number_format($garage->rating ?? 4.5, 1) }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $garage->reviews_count ?? rand(10, 50) }} avis</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="text-blue-600 text-xl">🏪</span>
                        </div>
                    </div>

                    <div class="space-y-3 mb-4">
                        <div class="flex items-start space-x-2">
                            <span class="text-gray-400 mt-0.5">📍</span>
                            <span class="text-gray-600 text-sm">{{ $garage->address }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-gray-400">📞</span>
                            <span class="text-gray-600 text-sm">{{ $garage->phone }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-gray-400">🕒</span>
                            <span class="text-gray-600 text-sm">{{ is_array($garage->opening_hours) ? ($garage->opening_hours['Lundi-Vendredi'] ?? '8h-18h') : ($garage->opening_hours ?? '8h-18h') }}</span>
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="mb-4">
                        <div class="flex flex-wrap gap-2">
                            @if($garage->services && count($garage->services) > 0)
                                @php
                                    $services = collect($garage->services);
                                    $displayServices = $services->take(3);
                                @endphp
                                @foreach($displayServices as $service)
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full font-medium">
                                    {{ $service->name ?? $service }}
                                </span>
                                @endforeach
                                @if($services->count() > 3)
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full font-medium">
                                    +{{ $services->count() - 3 }} autres
                                </span>
                                @endif
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full font-medium">
                                    Services multiples
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm text-gray-600">
                            À partir de <span class="font-semibold text-green-600">{{ $garage->min_price ?? rand(50, 200) }} DT</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span>
                            Ouvert
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <a href="{{ route('garages.show', $garage->id) }}"
                           class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg font-medium hover:bg-gray-200 transition-colors text-center">
                            Voir détails
                        </a>
                        @auth
                            @if($garage->user_id !== auth()->id())
                                <a href="{{ route('bookings.create', $garage->id) }}"
                                   class="beautiful-button flex-1 text-white py-2 px-4 rounded-lg font-medium hover-scale text-center">
                                    Réserver
                                </a>
                            @else
                                <div class="flex-1 bg-gray-100 text-gray-500 py-2 px-4 rounded-lg font-medium text-center">
                                    Votre garage
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                               class="beautiful-button flex-1 text-white py-2 px-4 rounded-lg font-medium hover-scale text-center">
                                Réserver
                            </a>
                        @endauth
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($garages->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $garages->links() }}
            </div>
            @endif
        @else
            <!-- No Results -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-gray-400 text-4xl">🔍</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun garage trouvé</h3>
                <p class="text-gray-600 mb-6">Essayez de modifier vos critères de recherche</p>
                <a href="{{ route('garages.index') }}" class="beautiful-button px-6 py-3 text-white rounded-lg font-medium hover-scale">
                    Voir tous les garages
                </a>
            </div>
        @endif
    </div>
</div>
@endsection