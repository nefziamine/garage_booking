<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir le mode de paiement - GarageBooking</title>
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

        .payment-option {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .payment-option:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .payment-option.selected {
            border-color: #1e40af;
            background: linear-gradient(145deg, #eff6ff 0%, #dbeafe 100%);
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

    <!-- Hero Section -->
    <section class="hero-bg py-16 relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto">
                <div class="text-center animate-fade-in">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-3xl font-bold shadow-lg">
                        💳
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        Choisir le mode de
                        <span class="gradient-text">paiement</span>
                    </h2>
                    <p class="text-xl text-gray-600 mb-8">
                        Sélectionnez votre méthode de paiement préférée
                    </p>
                </div>

                <!-- Payment Method Selection -->
                <div class="professional-card p-8 animate-fade-in">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Détails de la réservation</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Service:</span>
                                <span class="text-gray-900">{{ $booking->service->name ?? 'Service' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Garage:</span>
                                <span class="text-gray-900">{{ $booking->garage->name }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Date:</span>
                                <span class="text-gray-900">{{ $booking->booking_date->format('d/m/Y') }} à {{ $booking->booking_time->format('H:i') }}</span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="font-medium text-gray-700">Montant total:</span>
                                <span class="text-2xl font-bold text-blue-600">{{ $booking->total_price }} DT</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Méthodes de paiement disponibles</h3>

                        <form id="payment-method-form" action="{{ route('payments.checkout', $booking) }}" method="GET">
                            @csrf

                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Bank Card Payment -->
                                <div class="payment-option professional-card p-6 border-2 border-gray-200 rounded-lg" data-method="stripe">
                                    <div class="flex items-center mb-4">
                                        <input type="radio" id="stripe" name="payment_method" value="stripe" class="mr-3 text-blue-600 focus:ring-blue-500" checked>
                                        <label for="stripe" class="flex-1 cursor-pointer">
                                            <div class="flex items-center">
                                                <span class="text-2xl mr-3">💳</span>
                                                <div>
                                                    <div class="font-semibold text-gray-900">Carte bancaire</div>
                                                    <div class="text-sm text-gray-600">Visa, MasterCard, etc.</div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <p>Paiement sécurisé via Stripe. Toutes les cartes bancaires acceptées.</p>
                                    </div>
                                </div>

                                <!-- D17 Tunisian Payment -->
                                <div class="payment-option professional-card p-6 border-2 border-gray-200 rounded-lg" data-method="d17">
                                    <div class="flex items-center mb-4">
                                        <input type="radio" id="d17" name="payment_method" value="d17" class="mr-3 text-blue-600 focus:ring-blue-500">
                                        <label for="d17" class="flex-1 cursor-pointer">
                                            <div class="flex items-center">
                                                <span class="text-2xl mr-3">📱</span>
                                                <div>
                                                    <div class="font-semibold text-gray-900">D17 Tunisien</div>
                                                    <div class="text-sm text-gray-600">Paiement mobile</div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <p>Paiement rapide et sécurisé via D17. Idéal pour les Tunisiens.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8">
                                <button type="submit" class="w-full beautiful-button text-white py-4 px-6 rounded-lg font-semibold hover-scale">
                                    Continuer vers le paiement
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('bookings.show', $booking) }}" class="text-gray-600 hover:text-blue-600 transition-colors">
                            ← Retour aux détails de la réservation
                        </a>
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="text-center text-sm text-gray-500 mt-8">
                    <div class="flex items-center justify-center space-x-4">
                        <span>🔒 Paiement sécurisé</span>
                        <span>🛡️ SSL chiffré</span>
                        <span>💳 Toutes cartes acceptées</span>
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

    <script>
        // Payment method selection functionality
        document.addEventListener('DOMContentLoaded', function() {
            const paymentOptions = document.querySelectorAll('.payment-option');
            const radioButtons = document.querySelectorAll('input[name="payment_method"]');

            paymentOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selected class from all options
                    paymentOptions.forEach(opt => opt.classList.remove('selected'));

                    // Add selected class to clicked option
                    this.classList.add('selected');

                    // Check the radio button
                    const radio = this.querySelector('input[type="radio"]');
                    radio.checked = true;
                });
            });

            // Also handle radio button changes
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    paymentOptions.forEach(opt => opt.classList.remove('selected'));
                    const selectedOption = document.querySelector(`[data-method="${this.value}"]`);
                    if (selectedOption) {
                        selectedOption.classList.add('selected');
                    }
                });
            });

            // Set initial selection
            const initialSelected = document.querySelector('input[name="payment_method"]:checked');
            if (initialSelected) {
                const selectedOption = document.querySelector(`[data-method="${initialSelected.value}"]`);
                if (selectedOption) {
                    selectedOption.classList.add('selected');
                }
            }
        });
    </script>
</body>
</html>