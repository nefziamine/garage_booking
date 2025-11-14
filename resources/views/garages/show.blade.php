<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $garage->name }} | GarageBooking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/buttons.css') }}" rel="stylesheet">
    <style>
        :root {
            --tunisian-red: #E70013;
            --tunisian-white: #FFFFFF;
            --tunisian-yellow: #FFD600;
            --tunisian-gold: #D4AF37;
            --tunisian-blue: #1E3A8A;
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, var(--tunisian-white) 0%, #F8FAFC 100%);
            min-height: 100vh;
        }
        
        .tunisian-header {
            background: linear-gradient(135deg, var(--tunisian-red) 0%, #C53030 100%);
            border-bottom: 3px solid var(--tunisian-yellow);
        }
        
        .tunisian-card {
            background: var(--tunisian-white);
            border: 2px solid var(--tunisian-yellow);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(255, 214, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .tunisian-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(255, 214, 0, 0.2);
            border-color: var(--tunisian-red);
        }
        
        .tunisian-accent {
            color: var(--tunisian-red);
        }
        
        .tunisian-yellow-text {
            color: var(--tunisian-yellow);
        }
        
        .tunisian-star {
            color: var(--tunisian-yellow);
            text-shadow: 0 0 10px rgba(255, 214, 0, 0.5);
        }
        
        .service-tag {
            background: var(--tunisian-blue);
            color: var(--tunisian-white);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-block;
            margin: 2px;
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .slide-up {
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="tunisian-header text-white py-4">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center">
                        <span class="text-red-600 font-bold text-xl">G</span>
                    </div>
                    <h1 class="text-2xl font-bold">GarageBooking</h1>
                </div>
                <nav class="hidden md:flex space-x-6">
                    <a href="/" class="hover:text-yellow-300 transition-colors">Accueil</a>
                    <a href="{{ route('garages.index') }}" class="hover:text-yellow-300 transition-colors">Garages</a>
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-1 hover:text-yellow-300 transition-colors">
                                <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                                    <span class="text-red-600 font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <span>{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border-2 border-yellow-400">
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-red-600 transition-colors">
                                    <span class="tunisian-star">★</span> Mon Profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                                        <span class="tunisian-star">★</span> Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-yellow-300 transition-colors">Connexion</a>
                        <a href="{{ route('register.choice') }}" class="hover:text-yellow-300 transition-colors">S'inscrire</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Breadcrumb -->
            <nav class="mb-8">
                <a href="{{ route('garages.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Retour aux garages
                </a>
            </nav>

            <div class="tunisian-card p-8 slide-up">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">
                            <span class="tunisian-accent">{{ $garage->name }}</span>
                        </h2>
                        <p class="text-gray-600 text-lg">{{ $garage->address }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="tunisian-star text-2xl">★</span>
                        <span class="text-lg font-semibold text-gray-900">{{ $garage->rating ?? 0 }}/5</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <!-- Contact Information -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">
                            <span class="tunisian-star">★</span> Informations de contact
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Téléphone</span>
                                    <p class="text-gray-900 font-medium">{{ $garage->phone }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Email</span>
                                    <p class="text-gray-900 font-medium">{{ $garage->email ?? 'Non spécifié' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">
                            <span class="tunisian-star">★</span> Services proposés
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @if($garage->services && count($garage->services) > 0)
                                @php $services = collect($garage->services); @endphp
                                @foreach($services as $service)
                                <span class="service-tag">
                                    {{ $service->name ?? $service }}
                                </span>
                                @endforeach
                            @else
                                <span class="text-gray-500 italic">Aucun service listé</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($garage->description)
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">
                        <span class="tunisian-star">★</span> Description
                    </h3>
                    <p class="text-gray-700 leading-relaxed">{{ $garage->description }}</p>
                </div>
                @endif

                <!-- Horaires -->
                @if($garage->opening_hours && (is_array($garage->opening_hours) ? count($garage->opening_hours) > 0 : !empty($garage->opening_hours)))
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">
                        <span class="tunisian-star">★</span> Horaires d'ouverture
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php
                            $openingHours = is_array($garage->opening_hours) ? $garage->opening_hours : [];
                        @endphp
                        @foreach($openingHours as $jour => $horaire)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="font-medium text-gray-700">{{ $jour }}</span>
                            <span class="text-gray-900 font-medium">{{ $horaire }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                    @auth
                        @if($garage->user_id !== auth()->id())
                            <a href="{{ route('bookings.create', $garage) }}" class="btn-tunisian-primary btn-tunisian-lg flex-1 text-center">
                                <span class="tunisian-star">★</span> Réserver un créneau
                            </a>
                        @else
                            <div class="flex-1 bg-gray-100 text-gray-500 py-3 px-6 rounded-lg text-center font-medium">
                                <span class="tunisian-star">★</span> Votre garage
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-tunisian-primary btn-tunisian-lg flex-1 text-center">
                            <span class="tunisian-star">★</span> Se connecter pour réserver
                        </a>
                    @endauth

                    <a href="tel:{{ $garage->phone }}" class="btn-tunisian-secondary btn-tunisian-lg flex-1 text-center">
                        <span class="tunisian-star">★</span> Contacter le garage
                    </a>

                    <a href="{{ route('garages.index') }}" class="btn-tunisian-secondary btn-tunisian-lg flex-1 text-center">
                        <span class="tunisian-star">★</span> Voir d'autres garages
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-yellow-200 py-8 mt-16">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-600">
                © 2024 GarageBooking - Tous droits réservés | 
                <span class="tunisian-star">★</span> Made in Tunisia 
                <span class="tunisian-star">★</span>
            </p>
        </div>
    </footer>
</body>
</html> 