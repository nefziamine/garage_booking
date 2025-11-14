<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la réservation - GarageBooking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/buttons.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary: #1e40af;
            --secondary: #f59e0b;
            --accent: #dc2626;
            --neutral: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
        }

        .hero-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 30%, #cbd5e1 70%, #f1f5f9 100%);
            position: relative;
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                         radial-gradient(circle at 80% 20%, rgba(16, 185, 129, 0.1) 0%, transparent 50%);
        }

        .professional-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(229, 231, 235, 0.8);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .professional-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.15), 0 15px 20px -10px rgba(0, 0, 0, 0.1);
        }

        .gradient-text {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .beautiful-button {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            position: relative;
            overflow: hidden;
        }

        .beautiful-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .beautiful-button:hover::before {
            left: 100%;
        }

        .animate-fade-in {
            animation: fadeIn 1s ease-out;
        }

        .animate-slide-up {
            animation: slideUp 0.8s ease-out;
        }

        .animate-bounce-in {
            animation: bounceIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .hover-scale {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-scale:hover {
            transform: scale(1.05) translateY(-5px);
        }

        .section-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(229, 231, 235, 0.8);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .section-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15);
            border-color: rgba(59, 130, 246, 0.2);
        }

        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }

        .status-confirmed {
            background-color: #D1FAE5;
            color: #065F46;
        }

        .status-completed {
            background-color: #DBEAFE;
            color: #1E40AF;
        }

        .status-cancelled {
            background-color: #FEE2E2;
            color: #991B1B;
        }
    </style>
</head>
<body>
    <!-- Professional Navigation -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">G</span>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-gray-900">GarageBooking</span>
                        <p class="text-xs text-gray-500">Tunisie</p>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('welcome') }}" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Accueil</a>
                    <a href="{{ route('garages.index') }}" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Garages</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Contact</a>
                    @auth
                        <a href="{{ route('bookings.index') }}" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Mes réservations</a>
                        @if(auth()->user()->user_type === 'garage')
                            <a href="{{ route('bookings.received') }}" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Réservations reçues</a>
                        @endif
                        <a href="{{ route('profile') }}" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Profil</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Déconnexion</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium">Connexion</a>
                        <a href="{{ route('register.choice') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">S'inscrire</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Professional Hero Section -->
    <section class="hero-bg py-16 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="text-center animate-fade-in">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-3xl font-bold shadow-lg">
                        📋
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        Détails de la
                        <span class="gradient-text">réservation</span>
                    </h2>
                    <p class="text-xl text-gray-600 mb-8">
                        Consultez les informations complètes de votre réservation
                    </p>
                </div>

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 animate-slide-up">
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

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-slide-up">
                    <!-- Détails de la réservation -->
                    <div class="section-card p-8">
                        <h3 class="text-2xl font-bold mb-6 text-gray-900">
                            📋 Détails de la réservation
                        </h3>

                        <div class="space-y-6">
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="font-semibold text-gray-700">Numéro de réservation:</span>
                                <span class="text-gray-900 font-mono text-lg">#{{ $booking->id }}</span>
                            </div>

                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="font-semibold text-gray-700">Statut:</span>
                                <span class="px-4 py-2 rounded-full text-sm font-semibold status-{{ $booking->status }}">
                                    @switch($booking->status)
                                        @case('pending')
                                            En attente
                                            @break
                                        @case('confirmed')
                                            Confirmée
                                            @break
                                        @case('completed')
                                            Terminée
                                            @break
                                        @case('cancelled')
                                            Annulée
                                            @break
                                        @default
                                            {{ ucfirst($booking->status) }}
                                    @endswitch
                                </span>
                            </div>

                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="font-semibold text-gray-700">Date:</span>
                                <span class="text-gray-900">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}</span>
                            </div>

                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="font-semibold text-gray-700">Heure:</span>
                                <span class="text-gray-900">{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</span>
                            </div>

                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="font-semibold text-gray-700">Service:</span>
                                <span class="text-gray-900">{{ $booking->service->name ?? 'Service non spécifié' }}</span>
                            </div>

                            <div class="flex justify-between items-center py-3">
                                <span class="font-semibold text-gray-700">Prix total:</span>
                                <span class="text-gray-900 font-bold text-xl">{{ $booking->total_price }} DT</span>
                            </div>

                            @if($booking->notes)
                                <div class="pt-4 border-t border-gray-200">
                                    <span class="font-semibold text-gray-700 block mb-2">Notes:</span>
                                    <p class="text-gray-700 bg-gray-50 p-3 rounded-lg">{{ $booking->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Informations du garage -->
                    <div class="section-card p-8">
                        <h3 class="text-2xl font-bold mb-6 text-gray-900">
                            🏪 Informations du garage
                        </h3>

                        <div class="space-y-6">
                            <div class="py-3 border-b border-gray-100">
                                <span class="font-semibold text-gray-700">Nom:</span>
                                <p class="text-gray-900 text-lg mt-1">{{ $booking->garage->name }}</p>
                            </div>

                            <div class="py-3 border-b border-gray-100">
                                <span class="font-semibold text-gray-700">Adresse:</span>
                                <p class="text-gray-900 mt-1">{{ $booking->garage->address }}, {{ $booking->garage->city }}</p>
                            </div>

                            <div class="py-3 border-b border-gray-100">
                                <span class="font-semibold text-gray-700">Téléphone:</span>
                                <p class="text-gray-900 mt-1">{{ $booking->garage->phone }}</p>
                            </div>

                            @if($booking->garage->email)
                                <div class="py-3">
                                    <span class="font-semibold text-gray-700">Email:</span>
                                    <p class="text-gray-900 mt-1">{{ $booking->garage->email }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Informations du véhicule -->
                <div class="section-card p-8 animate-bounce-in">
                    <h3 class="text-2xl font-bold mb-6 text-gray-900">
                        🚗 Informations du véhicule
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-blue-600 text-2xl">🏷️</span>
                            </div>
                            <span class="font-semibold text-gray-700 block mb-2">Marque</span>
                            <p class="text-gray-900 text-lg">
                                @if(is_array($booking->vehicle_info))
                                    {{ $booking->vehicle_info['brand'] ?? 'Non spécifiée' }}
                                @else
                                    {{ $booking->vehicle_info ?? 'Non spécifiée' }}
                                @endif
                            </p>
                        </div>

                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-green-600 text-2xl">🚙</span>
                            </div>
                            <span class="font-semibold text-gray-700 block mb-2">Modèle</span>
                            <p class="text-gray-900 text-lg">
                                @if(is_array($booking->vehicle_info))
                                    {{ $booking->vehicle_info['model'] ?? 'Non spécifié' }}
                                @else
                                    {{ $booking->vehicle_info ?? 'Non spécifié' }}
                                @endif
                            </p>
                        </div>

                        <div class="text-center">
                            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-purple-600 text-2xl">📅</span>
                            </div>
                            <span class="font-semibold text-gray-700 block mb-2">Année</span>
                            <p class="text-gray-900 text-lg">
                                @if(is_array($booking->vehicle_info))
                                    {{ $booking->vehicle_info['year'] ?? 'Non spécifiée' }}
                                @else
                                    {{ $booking->vehicle_info ?? 'Non spécifiée' }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="section-card p-8">
                    <h3 class="text-2xl font-bold mb-6 text-gray-900">
                        ⚡ Actions
                    </h3>

                    <div class="flex flex-col sm:flex-row gap-4">
                        @if($booking->status === 'pending')
                            <form method="POST" action="{{ route('bookings.cancel', $booking) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full bg-red-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-red-700 transition-colors hover-scale"
                                        onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                    ❌ Annuler la réservation
                                </button>
                            </form>
                        @endif

                        @if(($booking->status === 'pending' || $booking->status === 'confirmed') && $booking->payment_status === 'pending')
                            <a href="{{ route('payments.method', $booking) }}" class="flex-1 bg-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 transition-colors hover-scale text-center">
                                💳 Payer maintenant
                            </a>
                        @endif

                        @if($booking->status === 'confirmed' && $booking->payment_status === 'paid')
                            <div class="flex-1 bg-green-50 text-green-700 py-3 px-6 rounded-lg text-center font-medium">
                                ✓ Paiement effectué
                            </div>
                        @endif

                        <a href="{{ route('bookings.index') }}" class="beautiful-button flex-1 text-white py-3 px-6 rounded-lg font-semibold hover-scale text-center">
                            📋 Mes réservations
                        </a>

                        <a href="{{ route('garages.show', $booking->garage) }}" class="flex-1 bg-amber-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-amber-600 transition-colors hover-scale text-center">
                            🏪 Voir le garage
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">G</span>
                        </div>
                        <span class="text-xl font-bold">GarageBooking</span>
                    </div>
                    <p class="text-gray-400 mb-4">
                        La plateforme de référence pour la réservation de services automobiles en Tunisie
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">📘 Facebook</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">📷 Instagram</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">🐦 Twitter</a>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Services</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Réparation moteur</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Vidange & entretien</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Diagnostic électronique</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Carrosserie & peinture</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Entreprise</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">À propos</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Carrières</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Presse</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Centre d'aide</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Politique de confidentialité</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Conditions d'utilisation</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Cookies</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">
                    © 2024 GarageBooking - Tous droits réservés |
                    <span class="text-blue-400">Made in Tunisia 🇹🇳</span>
                </p>
            </div>
        </div>
    </footer>
</body>
</html>