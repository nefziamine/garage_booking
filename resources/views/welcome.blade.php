<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GarageBooking - Réservation Professionnelle de Garages en Tunisie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

        .stats-card {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #2563eb 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            transition: all 0.3s ease;
        }

        .stats-card:hover::before {
            animation: shimmer 1.5s ease-in-out;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .feature-icon {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .feature-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .feature-icon:hover::before {
            left: 100%;
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

        .animate-float {
            animation: float 3s ease-in-out infinite;
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

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .hover-scale {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-scale:hover {
            transform: scale(1.05) translateY(-5px);
        }

        .hover-glow {
            transition: all 0.3s ease;
        }

        .hover-glow:hover {
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.3);
        }

        .text-shadow {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .glass-effect {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="text-gray-900">
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
                    <a href="#services" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Services</a>
                    <a href="{{ route('about') }}" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">À propos</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">Contact</a>
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <span class="font-medium">{{ auth()->user()->name }}</span>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 border">
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Mon Profil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="w-full text-left px-4 py-2 text-gray-700 hover:bg-red-50">Déconnexion</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium">Connexion</a>
                        <a href="{{ route('register.choice') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">S'inscrire</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Professional Hero Section -->
    <section class="hero-bg py-24 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="animate-fade-in">
                    <div class="inline-flex items-center px-4 py-2 glass-effect text-blue-800 rounded-full text-sm font-medium mb-6 hover-glow">
                        <span class="w-2 h-2 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full mr-2 animate-pulse"></span>
                        <span class="gradient-text font-semibold">Plateforme de réservation #1 en Tunisie</span>
                    </div>
                    <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight text-shadow">
                        Réservation de
                        <span class="gradient-text">garages</span>
                        professionnelle
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Connectez-vous avec les meilleurs garages de Tunisie.
                        <span class="font-semibold text-blue-600">Réservation instantanée</span>,
                        tarifs transparents, et service de qualité garantie.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 mb-8">
                        <a href="{{ route('garages.index') }}" class="beautiful-button text-white px-8 py-4 rounded-lg font-semibold text-lg shadow-lg hover-scale">
                            🔍 Trouver un garage
                        </a>
                        <a href="{{ route('register.choice') }}" class="glass-effect text-blue-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-blue-50 transition-colors hover-glow">
                            📅 Réserver maintenant
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="flex items-center space-x-6 text-sm text-gray-500">
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Garages certifiés
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Paiement sécurisé
                        </div>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-2">✓</span>
                            Support 24/7
                        </div>
                    </div>
                </div>

                <div class="animate-slide-up">
                    <div class="professional-card rounded-2xl p-8 shadow-2xl">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Réservation rapide</h3>

                        <form action="{{ route('garages.search') }}" method="GET" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">🏙️ Ville</label>
                                <select name="city" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Sélectionner une ville</option>
                                    <option value="Tunis">Tunis</option>
                                    <option value="Sfax">Sfax</option>
                                    <option value="Sousse">Sousse</option>
                                    <option value="Monastir">Monastir</option>
                                    <option value="Gabès">Gabès</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">🔧 Service requis</label>
                                <select name="service" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Choisir un service</option>
                                    <option value="Réparation moteur">Réparation moteur</option>
                                    <option value="Vidange">Vidange</option>
                                    <option value="Diagnostic">Diagnostic électronique</option>
                                    <option value="Pneus">Changement pneus</option>
                                    <option value="Carrosserie">Carrosserie</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">📅 Date souhaitée</label>
                                <input type="date" name="date" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <button type="submit" class="w-full beautiful-button text-white py-3 px-6 rounded-lg font-semibold hover-scale">
                                🔍 Rechercher des garages
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional Stats Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="stats-card p-8 rounded-xl text-center hover-scale hover-glow animate-bounce-in">
                    <div class="text-4xl font-bold mb-2 text-shadow">500+</div>
                    <div class="text-blue-100 font-medium">Garages partenaires</div>
                </div>
                <div class="stats-card p-8 rounded-xl text-center hover-scale hover-glow animate-bounce-in" style="animation-delay: 0.1s;">
                    <div class="text-4xl font-bold mb-2 text-shadow">24/7</div>
                    <div class="text-blue-100 font-medium">Service disponible</div>
                </div>
                <div class="stats-card p-8 rounded-xl text-center hover-scale hover-glow animate-bounce-in" style="animation-delay: 0.2s;">
                    <div class="text-4xl font-bold mb-2 text-shadow">50k+</div>
                    <div class="text-blue-100 font-medium">Clients satisfaits</div>
                </div>
                <div class="stats-card p-8 rounded-xl text-center hover-scale hover-glow animate-bounce-in" style="animation-delay: 0.3s;">
                    <div class="text-4xl font-bold mb-2 text-shadow">4.8/5</div>
                    <div class="text-blue-100 font-medium">Note moyenne</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional Services Section -->
    <section id="services" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Services professionnels
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Tous vos besoins automobiles couverts par des experts certifiés
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="professional-card p-8 rounded-xl hover-scale animate-fade-in">
                    <div class="w-16 h-16 feature-icon rounded-xl flex items-center justify-center mb-6 hover-glow">
                        <span class="text-2xl">🔧</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Réparation moteur</h3>
                    <p class="text-gray-600 mb-4">Réparation complète de moteurs toutes marques avec pièces d'origine</p>
                    <div class="gradient-text font-semibold text-lg">À partir de 150 DT</div>
                </div>

                <div class="professional-card p-8 rounded-xl hover-scale animate-fade-in" style="animation-delay: 0.1s;">
                    <div class="w-16 h-16 feature-icon rounded-xl flex items-center justify-center mb-6 hover-glow">
                        <span class="text-2xl">🛢️</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Vidange & entretien</h3>
                    <p class="text-gray-600 mb-4">Vidange complète avec filtres et contrôle technique inclus</p>
                    <div class="gradient-text font-semibold text-lg">À partir de 80 DT</div>
                </div>

                <div class="professional-card p-8 rounded-xl hover-scale animate-fade-in" style="animation-delay: 0.2s;">
                    <div class="w-16 h-16 feature-icon rounded-xl flex items-center justify-center mb-6 hover-glow">
                        <span class="text-2xl">🔍</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Diagnostic électronique</h3>
                    <p class="text-gray-600 mb-4">Diagnostic complet avec rapport détaillé et recommandations</p>
                    <div class="gradient-text font-semibold text-lg">À partir de 50 DT</div>
                </div>

                <div class="professional-card p-8 rounded-xl hover-scale animate-fade-in" style="animation-delay: 0.3s;">
                    <div class="w-16 h-16 feature-icon rounded-xl flex items-center justify-center mb-6 hover-glow">
                        <span class="text-2xl">🚗</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Carrosserie & peinture</h3>
                    <p class="text-gray-600 mb-4">Réparation et peinture carrosserie avec finition professionnelle</p>
                    <div class="gradient-text font-semibold text-lg">Devis sur demande</div>
                </div>

                <div class="professional-card p-8 rounded-xl hover-scale animate-fade-in" style="animation-delay: 0.4s;">
                    <div class="w-16 h-16 feature-icon rounded-xl flex items-center justify-center mb-6 hover-glow">
                        <span class="text-2xl">🔋</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Électricité auto</h3>
                    <p class="text-gray-600 mb-4">Réparation système électrique et électronique du véhicule</p>
                    <div class="gradient-text font-semibold text-lg">À partir de 100 DT</div>
                </div>

                <div class="professional-card p-8 rounded-xl hover-scale animate-fade-in" style="animation-delay: 0.5s;">
                    <div class="w-16 h-16 feature-icon rounded-xl flex items-center justify-center mb-6 hover-glow">
                        <span class="text-2xl">🛞</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Pneus & jantes</h3>
                    <p class="text-gray-600 mb-4">Changement, réparation et équilibrage de pneus toutes marques</p>
                    <div class="gradient-text font-semibold text-lg">À partir de 60 DT</div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Comment réserver votre garage en 3 étapes
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Processus simple et rapide pour trouver le garage parfait
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center animate-float">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-2xl font-bold shadow-lg hover-glow">
                        1
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">🔍 Choisir un garage</h3>
                    <p class="text-gray-600">Parcourez notre réseau de garages certifiés dans toute la Tunisie selon vos besoins</p>
                </div>

                <div class="text-center animate-float" style="animation-delay: 0.2s;">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-2xl font-bold shadow-lg hover-glow">
                        2
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">📅 Réserver un créneau</h3>
                    <p class="text-gray-600">Sélectionnez la date et l'heure qui vous conviennent, 24h/24 et 7j/7</p>
                </div>

                <div class="text-center animate-float" style="animation-delay: 0.4s;">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-2xl font-bold shadow-lg hover-glow">
                        3
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">✅ Confirmer & payer</h3>
                    <p class="text-gray-600">Recevez une confirmation instantanée et payez en ligne ou sur place</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Garages Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Garages partenaires recommandés
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Découvrez nos garages les mieux notés à travers la Tunisie
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="professional-card p-6 rounded-xl hover-scale">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-green-600 text-xl">🏆</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Garage Central Tunis</h3>
                            <div class="flex items-center text-sm text-gray-600">
                                <span class="text-yellow-400 mr-1">★★★★★</span>
                                <span>4.9 (127 avis)</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">Spécialiste Renault & Peugeot - Réparation moteur & vidange</p>
                    <div class="flex justify-between items-center">
                        <span class="text-blue-600 font-semibold">Tunis Centre</span>
                        <span class="text-green-600 font-semibold">À partir de 80 DT</span>
                    </div>
                </div>

                <div class="professional-card p-6 rounded-xl hover-scale">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-blue-600 text-xl">🔧</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Auto Plus Sfax</h3>
                            <div class="flex items-center text-sm text-gray-600">
                                <span class="text-yellow-400 mr-1">★★★★★</span>
                                <span>4.8 (89 avis)</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">Toutes marques - Diagnostic électronique & carrosserie</p>
                    <div class="flex justify-between items-center">
                        <span class="text-blue-600 font-semibold">Sfax</span>
                        <span class="text-green-600 font-semibold">À partir de 60 DT</span>
                    </div>
                </div>

                <div class="professional-card p-6 rounded-xl hover-scale">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-orange-600 text-xl">🚗</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Garage Moderne Sousse</h3>
                            <div class="flex items-center text-sm text-gray-600">
                                <span class="text-yellow-400 mr-1">★★★★★</span>
                                <span>4.7 (156 avis)</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">Spécialiste asiatiques - Pneus & amortisseurs</p>
                    <div class="flex justify-between items-center">
                        <span class="text-blue-600 font-semibold">Sousse</span>
                        <span class="text-green-600 font-semibold">À partir de 50 DT</span>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('garages.index') }}" class="beautiful-button text-white px-8 py-4 rounded-lg font-semibold text-lg shadow-lg hover-scale">
                    Voir tous les garages →
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Ce que disent nos clients
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Des milliers de clients satisfaits de nos services de réservation
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="professional-card p-8 rounded-xl">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-blue-600 font-bold">A</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Ahmed Ben Ali</h4>
                            <div class="text-yellow-400 text-sm">★★★★★</div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic mb-4">"Service exceptionnel ! J'ai trouvé un garage près de chez moi en 2 minutes et la réservation s'est faite instantanément."</p>
                    <div class="text-sm text-gray-500">Réparation moteur - Tunis</div>
                </div>

                <div class="professional-card p-8 rounded-xl">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-green-600 font-bold">S</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Sarra Trabelsi</h4>
                            <div class="text-yellow-400 text-sm">★★★★★</div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic mb-4">"Très pratique pour les urgences. Prix transparents et garages professionnels. Je recommande vivement !"</p>
                    <div class="text-sm text-gray-500">Vidange - Sfax</div>
                </div>

                <div class="professional-card p-8 rounded-xl">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-purple-600 font-bold">M</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Mohamed Jaziri</h4>
                            <div class="text-yellow-400 text-sm">★★★★★</div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic mb-4">"Application parfaite ! J'ai pu réserver un diagnostic en quelques clics. Service rapide et efficace."</p>
                    <div class="text-sm text-gray-500">Diagnostic - Sousse</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose GarageBooking Section -->
    <section class="py-20 bg-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Pourquoi choisir GarageBooking ?
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    La plateforme de réservation de garages la plus fiable de Tunisie
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center mx-auto mb-6 text-white text-2xl">
                        🛡️
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Garantie qualité</h3>
                    <p class="text-gray-600">Tous nos garages partenaires sont certifiés et régulièrement contrôlés</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-green-600 rounded-xl flex items-center justify-center mx-auto mb-6 text-white text-2xl">
                        💰
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Prix transparents</h3>
                    <p class="text-gray-600">Pas de surprises, consultez les tarifs avant de réserver</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-600 rounded-xl flex items-center justify-center mx-auto mb-6 text-white text-2xl">
                        ⚡
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Réservation instantanée</h3>
                    <p class="text-gray-600">Réservez votre créneau 24h/24, 7j/7 en quelques clics</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-600 rounded-xl flex items-center justify-center mx-auto mb-6 text-white text-2xl">
                        📱
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Support client</h3>
                    <p class="text-gray-600">Équipe disponible pour vous accompagner à chaque étape</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Demo Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Réservation simplifiée en ligne
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Découvrez comment notre plateforme facilite vos réservations de garage
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Interface intuitive de réservation</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">1</div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Sélection du service</h4>
                                <p class="text-gray-600">Choisissez parmi nos catégories de services automobiles</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">2</div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Choix du garage</h4>
                                <p class="text-gray-600">Parcourez les garages disponibles avec avis et tarifs</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">3</div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Réservation du créneau</h4>
                                <p class="text-gray-600">Sélectionnez date et heure selon vos disponibilités</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">4</div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Confirmation & paiement</h4>
                                <p class="text-gray-600">Recevez une confirmation et payez en ligne ou sur place</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="professional-card p-8 rounded-xl shadow-2xl">
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="font-semibold text-gray-900">Garage Central Tunis</span>
                            <div class="flex items-center">
                                <span class="text-yellow-400 mr-1">★★★★★</span>
                                <span class="text-sm text-gray-600">4.9</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Service:</span>
                                <span class="font-semibold">Vidange complète</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date:</span>
                                <span class="font-semibold">15 Décembre 2024</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Heure:</span>
                                <span class="font-semibold">14:00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Prix estimé:</span>
                                <span class="font-semibold text-green-600">85 DT</span>
                            </div>
                        </div>
                    </div>
                    <button class="w-full beautiful-button text-white py-3 px-6 rounded-lg font-semibold hover-scale">
                        Confirmer la réservation
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional CTA Section -->
    <section class="py-20 bg-blue-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-6">
                Prêt à réserver votre service ?
            </h2>
            <p class="text-xl mb-8 text-blue-100">
                Rejoignez des milliers de clients satisfaits en Tunisie
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register.choice') }}" class="glass-effect text-blue-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white transition-colors shadow-lg hover-glow">
                    Créer un compte gratuit
                </a>
                <a href="{{ route('garages.index') }}" class="beautiful-button text-white px-8 py-4 rounded-lg font-semibold text-lg shadow-lg hover-scale">
                    Explorer les garages
                </a>
            </div>
        </div>
    </section>

    <!-- Professional Footer -->
    <footer class="bg-gray-900 text-white py-12">
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
                        <li><a href="#" class="hover:text-white transition-colors">À propos</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Carrières</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Presse</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
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

    <!-- Cookie Consent -->
    <div id="cookie-consent" class="fixed bottom-4 left-4 right-4 md:left-4 md:right-auto md:w-96 professional-card p-4 rounded-lg shadow-lg">
        <div class="flex items-start space-x-3">
            <div class="text-2xl">🍪</div>
            <div class="flex-1">
                <h4 class="font-semibold mb-2 text-gray-900">Cookies</h4>
                <p class="text-sm text-gray-600 mb-3">
                    Nous utilisons des cookies pour améliorer votre expérience sur GarageBooking.
                </p>
                <div class="flex gap-2">
                    <button onclick="handleCookieChoice(true)" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Accepter</button>
                    <button onclick="handleCookieChoice(false)" class="border border-gray-300 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-50">Refuser</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleCookieChoice(accepted) {
            localStorage.setItem('cookieConsent', accepted ? 'accepted' : 'rejected');
            document.getElementById('cookie-consent').style.display = 'none';
        }

        window.addEventListener('DOMContentLoaded', () => {
            const consent = localStorage.getItem('cookieConsent');
            if (consent) {
                document.getElementById('cookie-consent').style.display = 'none';
            }
        });
    </script>
</body>
</html>
