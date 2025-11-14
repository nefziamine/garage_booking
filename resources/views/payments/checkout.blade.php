<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement - GarageBooking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @if(!session('test_mode'))
    <script src="https://js.stripe.com/v3/"></script>
    @endif
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto">
                <div class="text-center animate-fade-in">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-3xl font-bold shadow-lg">
                        💳
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        Paiement
                        <span class="gradient-text">Sécurisé</span>
                    </h2>
                    <p class="text-xl text-gray-600 mb-8">
                        Effectuez votre paiement en toute sécurité
                    </p>
                </div>

                <!-- Payment Form -->
                <div class="professional-card p-8 animate-fade-in">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Détails du paiement</h3>
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

                    <!-- Recommended Services -->
                    @if($recommendedServices && $recommendedServices->count() > 0)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <span class="text-blue-600 mr-2">💡</span>
                            <h3 class="text-lg font-semibold text-blue-900">Services recommandés pour votre véhicule</h3>
                        </div>
                        <p class="text-sm text-blue-700 mb-4">
                            Basé sur les informations de votre véhicule et votre historique, nous vous suggérons ces services complémentaires :
                        </p>

                        <div class="space-y-3">
                            @foreach($recommendedServices as $service)
                            <div class="flex items-center justify-between bg-white rounded-lg p-3 border border-blue-100">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                               name="additional_services[]"
                                               value="{{ $service->id }}"
                                               id="service_{{ $service->id }}"
                                               class="additional-service-checkbox mr-3 text-blue-600 focus:ring-blue-500">
                                        <label for="service_{{ $service->id }}" class="flex-1 cursor-pointer">
                                            <div class="font-medium text-gray-900">{{ $service->name }}</div>
                                            <div class="text-sm text-gray-600">{{ $service->description ?? 'Service complémentaire' }}</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-semibold text-blue-600">{{ $service->price }} DT</div>
                                    <div class="text-sm text-gray-500">{{ $service->getFormattedDurationAttribute() }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-4 pt-4 border-t border-blue-200">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-blue-700">Total des services supplémentaires:</span>
                                <span class="font-semibold text-blue-900" id="additional-total">0 DT</span>
                            </div>
                            <div class="flex justify-between items-center text-lg font-bold mt-2">
                                <span class="text-blue-900">Nouveau total:</span>
                                <span class="text-blue-600" id="new-total">{{ $booking->total_price }} DT</span>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                        <div class="flex items-center">
                            <span class="text-gray-600 mr-2">ℹ️</span>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900">Aucun service complémentaire disponible</h4>
                                <p class="text-sm text-gray-700">Tous les services disponibles sont déjà inclus dans votre réservation.</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Payment Form -->
                    <form id="payment-form" class="space-y-6">
                        @csrf

                        @if(isset($paymentMethod) && $paymentMethod === 'd17')
                        <!-- D17 Payment Form -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <span class="text-green-600 mr-2 text-2xl">📱</span>
                                <h4 class="text-lg font-semibold text-green-900">Paiement D17 Tunisien</h4>
                            </div>
                            <p class="text-sm text-green-700 mb-6">
                                Remplissez les informations de votre carte D17 pour effectuer le paiement.
                            </p>

                            <div class="space-y-4">
                                <!-- D17 Phone Number -->
                                <div>
                                    <label for="d17_phone" class="block text-sm font-medium text-gray-700">
                                        📱 Numéro de téléphone D17 *
                                    </label>
                                    <input type="tel"
                                           id="d17_phone"
                                           name="d17_phone"
                                           placeholder="+216 XX XXX XXX"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white"
                                           required>
                                    <p class="text-xs text-gray-500">Votre numéro D17 actif</p>
                                </div>

                                <!-- D17 Card Number -->
                                <div>
                                    <label for="d17_card_number" class="block text-sm font-medium text-gray-700">
                                        💳 Numéro de carte D17 *
                                    </label>
                                    <input type="text"
                                           id="d17_card_number"
                                           name="d17_card_number"
                                           placeholder="1234 5678 9012 3456"
                                           maxlength="19"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white"
                                           required>
                                    <p class="text-xs text-gray-500">16 chiffres de votre carte D17</p>
                                </div>

                                <!-- CVC and Expiry -->
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="d17_cvc" class="block text-sm font-medium text-gray-700">
                                            🔢 Code CVC *
                                        </label>
                                        <input type="text"
                                               id="d17_cvc"
                                               name="d17_cvc"
                                               placeholder="1234"
                                               maxlength="4"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white"
                                               required>
                                        <p class="text-xs text-gray-500">4 chiffres au verso</p>
                                    </div>

                                    <div>
                                        <label for="d17_expiry" class="block text-sm font-medium text-gray-700">
                                            📅 Date d'expiration *
                                        </label>
                                        <input type="text"
                                               id="d17_expiry"
                                               name="d17_expiry"
                                               placeholder="MM/YY"
                                               maxlength="5"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white"
                                               required>
                                        <p class="text-xs text-gray-500">Ex: 12/25</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Amount Display -->
                            <div class="mt-6 bg-green-100 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="text-green-600 mr-2 text-lg">💰</span>
                                        <span class="text-sm font-medium text-green-900">Montant total à payer</span>
                                    </div>
                                    <span class="text-xl font-bold text-green-800">{{ $booking->total_price }} DT</span>
                                </div>
                            </div>

                            <!-- Security Notice -->
                            <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                                <p class="text-xs text-green-700 flex items-center">
                                    <span class="mr-2">🔒</span>
                                    Vos informations D17 sont chiffrées et sécurisées
                                </p>
                            </div>
                        </div>


                        @elseif(session('test_mode'))
                        <!-- Test Mode Payment -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <span class="text-yellow-600 mr-2 text-2xl">🧪</span>
                                <h4 class="text-lg font-semibold text-yellow-900">Mode de Test</h4>
                            </div>
                            <p class="text-sm text-yellow-700 mb-4">
                                Ceci est un paiement de test. Aucun paiement réel ne sera effectué.
                            </p>
                            <div class="bg-white p-4 rounded border border-yellow-200">
                                <p class="text-sm text-gray-600">
                                    <strong>ID de paiement test :</strong> {{ $paymentIntent->id }}
                                </p>
                            </div>
                        </div>

                        @else
                        <!-- Banking Card Payment Form -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <span class="text-blue-600 mr-2 text-2xl">💳</span>
                                <h4 class="text-lg font-semibold text-blue-900">Paiement par Carte Bancaire</h4>
                            </div>
                            <p class="text-sm text-blue-700 mb-6">
                                Entrez les informations de votre carte bancaire pour effectuer le paiement.
                            </p>

                            <div class="space-y-4">
                                <!-- Card Information -->
                                <div>
                                    <label for="card-element" class="block text-sm font-medium text-gray-700 mb-2">
                                        💳 Informations de carte bancaire *
                                    </label>
                                    <div id="card-element" class="p-4 border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent bg-white">
                                        <!-- Stripe Elements will be inserted here -->
                                    </div>
                                    <div id="card-errors" class="text-red-600 text-sm mt-2" role="alert"></div>
                                </div>

                                <!-- Amount Display -->
                                <div class="bg-blue-100 border border-blue-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <span class="text-blue-600 mr-2 text-lg">💰</span>
                                            <span class="text-sm font-medium text-blue-900">Montant total à payer</span>
                                        </div>
                                        <span class="text-xl font-bold text-blue-800">{{ $booking->total_price }} DT</span>
                                    </div>
                                </div>

                                <!-- Security Notice -->
                                <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                    <p class="text-xs text-blue-700 flex items-center">
                                        <span class="mr-2">🔒</span>
                                        Paiement sécurisé SSL 256-bit | Toutes cartes acceptées
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <button type="submit" id="submit-button" class="w-full beautiful-button text-white py-4 px-6 rounded-lg font-semibold hover-scale">
                            @if(isset($paymentMethod) && $paymentMethod === 'd17')
                                📱 Payer avec D17 - {{ $booking->total_price }} DT
                            @elseif(session('test_mode'))
                                🧪 Effectuer le paiement de test
                            @else
                                💳 Payer {{ $booking->total_price }} DT
                            @endif
                        </button>
                    </form>

                    <div class="mt-6 text-center">
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
        // Service recommendation functionality
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.additional-service-checkbox');
            const additionalTotalElement = document.getElementById('additional-total');
            const newTotalElement = document.getElementById('new-total');
            const originalTotal = {{ $booking->total_price }};

            function updateTotals() {
                let additionalTotal = 0;
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const serviceElement = checkbox.closest('.bg-white');
                        const priceText = serviceElement.querySelector('.font-semibold').textContent;
                        const price = parseFloat(priceText.replace(' DT', ''));
                        additionalTotal += price;
                    }
                });

                additionalTotalElement.textContent = additionalTotal.toFixed(2) + ' DT';
                newTotalElement.textContent = (originalTotal + additionalTotal).toFixed(2) + ' DT';
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateTotals);
            });

            // D17 form enhancements
            @if(isset($paymentMethod) && $paymentMethod === 'd17')
            // Format card number input
            const cardNumberInput = document.getElementById('d17_card_number');
            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\s/g, '');
                    if (value.length > 16) value = value.slice(0, 16);
                    value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
                    e.target.value = value;
                });
            }

            // Format expiry date input
            const expiryInput = document.getElementById('d17_expiry');
            if (expiryInput) {
                expiryInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length >= 2) {
                        value = value.slice(0, 2) + '/' + value.slice(2, 4);
                    }
                    e.target.value = value;
                });
            }

            // Format CVC input (only numbers)
            const cvcInput = document.getElementById('d17_cvc');
            if (cvcInput) {
                cvcInput.addEventListener('input', function(e) {
                    e.target.value = e.target.value.replace(/\D/g, '');
                });
            }

            // Format phone input
            const phoneInput = document.getElementById('d17_phone');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 8) value = value.slice(0, 8);
                    if (value.length >= 2) {
                        value = value.slice(0, 2) + ' ' + value.slice(2, 5) + ' ' + value.slice(5);
                    }
                    e.target.value = '+216 ' + value;
                });
            }
            @endif
        });

        @if(isset($paymentMethod) && $paymentMethod === 'd17')
        // D17 mode - no Stripe
        const stripe = null;
        const elements = null;
        const cardElement = null;
        @elseif(session('test_mode'))
        // Test mode - no Stripe
        const stripe = null;
        const elements = null;
        const cardElement = null;
        @else
        // Stripe configuration
        const stripe = Stripe('{{ config("services.stripe.key") }}');
        const elements = stripe.elements();

        // Create card element
        const cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#32325d',
                    fontFamily: '"Inter", sans-serif',
                    '::placeholder': {
                        color: '#aab7c4',
                    },
                },
            },
        });

        cardElement.mount('#card-element');
        @endif

        // Handle form submission
        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-button');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            submitButton.disabled = true;

            @if(isset($paymentMethod) && $paymentMethod === 'd17')
            // D17 mode - basic validation
            const requiredFields = ['d17_phone', 'd17_card_number', 'd17_cvc', 'd17_expiry'];
            const emptyField = requiredFields.find(field => !document.getElementById(field).value.trim());

            if (emptyField) {
                alert('Veuillez remplir tous les champs du formulaire D17.');
                submitButton.disabled = false;
                return;
            }

            submitButton.textContent = '🔄 Traitement du paiement D17...';
            form.submit();
            @elseif(session('test_mode'))
            // Test mode - simulate processing
            submitButton.textContent = '🔄 Traitement en cours...';
            setTimeout(() => form.submit(), 1500);
            @else
            // Stripe mode - handle payment confirmation
            submitButton.textContent = '🔄 Traitement en cours...';
            try {
                const { error, paymentIntent } = await stripe.confirmCardPayment(
                    '{{ $paymentIntent->client_secret }}',
                    { payment_method: { card: cardElement } }
                );

                if (error) {
                    document.getElementById('card-errors').textContent = error.message;
                    submitButton.disabled = false;
                    submitButton.textContent = '💳 Payer {{ $booking->total_price }} DT';
                } else if (paymentIntent?.status === 'succeeded') {
                    // Add payment data and submit
                    const paymentIntentInput = document.createElement('input');
                    paymentIntentInput.type = 'hidden';
                    paymentIntentInput.name = 'payment_intent_id';
                    paymentIntentInput.value = paymentIntent.id;
                    form.appendChild(paymentIntentInput);

                    const paymentMethodInput = document.createElement('input');
                    paymentMethodInput.type = 'hidden';
                    paymentMethodInput.name = 'payment_method_id';
                    paymentMethodInput.value = paymentIntent.payment_method;
                    form.appendChild(paymentMethodInput);

                    form.submit();
                }
            } catch (error) {
                document.getElementById('card-errors').textContent = 'Une erreur est survenue. Veuillez réessayer.';
                submitButton.disabled = false;
                submitButton.textContent = '💳 Payer {{ $booking->total_price }} DT';
            }
            @endif
        });

        @if(!session('test_mode'))
        // Handle card element errors
        cardElement.on('change', (event) => {
            if (event.error) {
                cardErrors.textContent = event.error.message;
            } else {
                cardErrors.textContent = '';
            }
        });
        @endif
    </script>
</body>
</html>