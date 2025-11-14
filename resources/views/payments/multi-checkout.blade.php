<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Multiple - GarageBooking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://js.stripe.com/v3/"></script>
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

        .professional-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(229, 231, 235, 0.8);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
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

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Paiement Multiple</h1>
            <p class="text-gray-600">Confirmer vos réservations en une seule transaction</p>
        </div>

        <!-- Bookings Summary -->
        <div class="professional-card p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">📋 Récapitulatif des réservations</h2>

            <div class="space-y-4">
                @foreach($bookings as $booking)
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $booking->service->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $booking->garage->name }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $booking->booking_date->format('d/m/Y') }} à {{ $booking->booking_time->format('H:i') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-blue-600">{{ $booking->total_price }} DT</p>
                        <p class="text-sm text-gray-500">{{ $booking->estimated_duration }} min</p>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="border-t pt-4 mt-4">
                <div class="flex justify-between items-center text-xl font-bold">
                    <span class="text-gray-900">Total à payer:</span>
                    <span class="text-blue-600">{{ $totalAmount }} DT</span>
                </div>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="professional-card p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">💳 Informations de paiement</h2>

            @if(session('test_mode'))
            <!-- Test Mode -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <span class="text-yellow-600 mr-2">🧪</span>
                    <div>
                        <h4 class="text-sm font-semibold text-yellow-900">Mode de test activé</h4>
                        <p class="text-sm text-yellow-700">Aucun paiement réel ne sera effectué.</p>
                    </div>
                </div>
            </div>
            @else
            <!-- Stripe Payment Form -->
            <div id="card-element" class="p-4 border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent mb-4">
                <!-- Stripe Elements will be inserted here -->
            </div>
            <div id="card-errors" class="text-red-600 text-sm mb-4" role="alert"></div>
            @endif

            <form id="multi-payment-form">
                @csrf
                <div class="flex space-x-4">
                    <button type="button" onclick="history.back()" class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition-colors">
                        ← Retour
                    </button>
                    <button type="submit" id="multi-submit-btn" class="flex-1 beautiful-button text-white py-3 px-6 rounded-lg font-semibold hover-scale">
                        @if(session('test_mode'))
                            🧪 Payer en mode test ({{ $totalAmount }} DT)
                        @else
                            💳 Payer maintenant ({{ $totalAmount }} DT)
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        @if(!session('test_mode'))
        // Stripe configuration
        const stripe = Stripe('{{ config("services.stripe.key") }}');
        const elements = stripe.elements();

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

        cardElement.on('change', (event) => {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
        @endif

        // Form submission
        document.getElementById('multi-payment-form').addEventListener('submit', async (event) => {
            event.preventDefault();

            const submitBtn = document.getElementById('multi-submit-btn');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Traitement en cours...';

            @if(session('test_mode'))
            // Test mode - simulate payment
            setTimeout(() => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("payments.multi_process") }}';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                const paymentIntentId = document.createElement('input');
                paymentIntentId.type = 'hidden';
                paymentIntentId.name = 'payment_intent_id';
                paymentIntentId.value = '{{ $paymentIntent->id }}';
                form.appendChild(paymentIntentId);

                const paymentMethodId = document.createElement('input');
                paymentMethodId.type = 'hidden';
                paymentMethodId.name = 'payment_method_id';
                paymentMethodId.value = 'test_pm_' + Date.now();
                form.appendChild(paymentMethodId);

                document.body.appendChild(form);
                form.submit();
            }, 2000);
            @else
            // Production mode with Stripe
            try {
                const { error, paymentIntent } = await stripe.confirmCardPayment(
                    '{{ $paymentIntent->client_secret }}',
                    {
                        payment_method: {
                            card: cardElement,
                        },
                    }
                );

                if (error) {
                    document.getElementById('card-errors').textContent = error.message;
                    submitBtn.disabled = false;
                    submitBtn.textContent = '💳 Payer maintenant ({{ $totalAmount }} DT)';
                } else if (paymentIntent && paymentIntent.status === 'succeeded') {
                    // Create form to submit payment data
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("payments.multi_process") }}';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const paymentIntentId = document.createElement('input');
                    paymentIntentId.type = 'hidden';
                    paymentIntentId.name = 'payment_intent_id';
                    paymentIntentId.value = paymentIntent.id;
                    form.appendChild(paymentIntentId);

                    const paymentMethodId = document.createElement('input');
                    paymentMethodId.type = 'hidden';
                    paymentMethodId.name = 'payment_method_id';
                    paymentMethodId.value = paymentIntent.payment_method;
                    form.appendChild(paymentMethodId);

                    document.body.appendChild(form);
                    form.submit();
                }
            } catch (error) {
                document.getElementById('card-errors').textContent = 'Une erreur est survenue. Veuillez réessayer.';
                submitBtn.disabled = false;
                submitBtn.textContent = '💳 Payer maintenant ({{ $totalAmount }} DT)';
            }
            @endif
        });
    </script>
</body>
</html>