<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Garage - GarageBooking</title>
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

        .input-focus {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.15);
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

        .progress-step {
            transition: all 0.3s ease;
        }

        .progress-step.active {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
        }

        .checkbox-custom {
            position: relative;
            transition: all 0.2s ease;
        }

        .checkbox-custom:hover {
            transform: scale(1.05);
        }

        .btn-enhanced {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-enhanced::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-enhanced:hover::before {
            left: 100%;
        }

        .icon-container {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .icon-container:hover {
            transform: scale(1.1) rotate(5deg);
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
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium">Connexion</a>
                    <a href="{{ route('register.choice') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">S'inscrire</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Professional Hero Section -->
    <section class="hero-bg py-24 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto">
                <div class="text-center animate-fade-in">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white text-3xl font-bold shadow-lg hover-glow">
                        🔧
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4 text-shadow">
                        Inscription
                        <span class="gradient-text">Garage</span>
                    </h2>
                    <p class="text-xl text-gray-600 mb-8">
                        Rejoignez notre réseau de garagistes professionnels en Tunisie
                    </p>
                </div>

                <!-- Progress Indicator -->
                <div class="mb-8 animate-fade-in">
                    <div class="flex items-center justify-center space-x-4 mb-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">1</div>
                            <span class="ml-2 text-sm font-medium text-blue-600">Propriétaire</span>
                        </div>
                        <div class="w-8 h-0.5 bg-gray-300"></div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">2</div>
                            <span class="ml-2 text-sm font-medium text-blue-600">Garage</span>
                        </div>
                        <div class="w-8 h-0.5 bg-gray-300"></div>
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold text-sm">3</div>
                            <span class="ml-2 text-sm font-medium text-gray-600">Sécurité</span>
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-500" style="width: 66%"></div>
                    </div>
                </div>

                <div class="professional-card p-8 rounded-2xl shadow-2xl animate-slide-up">
                <form method="POST" action="{{ route('register.garage') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Informations du propriétaire -->
                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <h3 class="text-xl font-semibold mb-4 text-blue-600 flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <span class="text-blue-600 text-lg">👤</span>
                            </div>
                            Informations du propriétaire
                        </h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Prénom
                                </label>
                                <input
                                    id="first_name"
                                    name="first_name"
                                    type="text"
                                    required
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Votre prénom"
                                    value="{{ old('first_name') }}"
                                >
                                @error('first_name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nom
                                </label>
                                <input
                                    id="last_name"
                                    name="last_name"
                                    type="text"
                                    required
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent input-focus"
                                    placeholder="Votre nom"
                                    value="{{ old('last_name') }}"
                                >
                                @error('last_name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Adresse e-mail
                                </label>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    required
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent input-focus"
                                    placeholder="votre@email.com"
                                    value="{{ old('email') }}"
                                >
                                @error('email')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Téléphone
                                </label>
                                <input
                                    id="phone"
                                    name="phone"
                                    type="tel"
                                    required
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="+216 XX XXX XXX"
                                    value="{{ old('phone') }}"
                                >
                                @error('phone')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informations du garage -->
                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <h3 class="text-xl font-semibold mb-4 text-blue-600 flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 icon-container">
                                <span class="text-blue-600 text-lg">🏪</span>
                            </div>
                            Informations du garage
                        </h3>
                        
                        <div>
                            <label for="garage_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom du garage
                            </label>
                            <input
                                id="garage_name"
                                name="garage_name"
                                type="text"
                                required
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Ex: Garage Auto Tunis"
                                value="{{ old('garage_name') }}"
                            >
                            @error('garage_name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                    Ville
                                </label>
                                <select name="city" id="city" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    <option value="">Choisissez votre ville</option>
                                    <option value="Tunis" {{ old('city') == 'Tunis' ? 'selected' : '' }}>Tunis</option>
                                    <option value="Ariana" {{ old('city') == 'Ariana' ? 'selected' : '' }}>Ariana</option>
                                    <option value="Ben Arous" {{ old('city') == 'Ben Arous' ? 'selected' : '' }}>Ben Arous</option>
                                    <option value="La Manouba" {{ old('city') == 'La Manouba' ? 'selected' : '' }}>La Manouba</option>
                                    <option value="Zaghouan" {{ old('city') == 'Zaghouan' ? 'selected' : '' }}>Zaghouan</option>
                                    <option value="Nabeul" {{ old('city') == 'Nabeul' ? 'selected' : '' }}>Nabeul</option>
                                    <option value="Hammamet" {{ old('city') == 'Hammamet' ? 'selected' : '' }}>Hammamet</option>
                                    <option value="Bizerte" {{ old('city') == 'Bizerte' ? 'selected' : '' }}>Bizerte</option>
                                    <option value="Béja" {{ old('city') == 'Béja' ? 'selected' : '' }}>Béja</option>
                                    <option value="Jendouba" {{ old('city') == 'Jendouba' ? 'selected' : '' }}>Jendouba</option>
                                    <option value="Le Kef" {{ old('city') == 'Le Kef' ? 'selected' : '' }}>Le Kef</option>
                                    <option value="Siliana" {{ old('city') == 'Siliana' ? 'selected' : '' }}>Siliana</option>
                                    <option value="Kairouan" {{ old('city') == 'Kairouan' ? 'selected' : '' }}>Kairouan</option>
                                    <option value="Kasserine" {{ old('city') == 'Kasserine' ? 'selected' : '' }}>Kasserine</option>
                                    <option value="Sidi Bouzid" {{ old('city') == 'Sidi Bouzid' ? 'selected' : '' }}>Sidi Bouzid</option>
                                    <option value="Sousse" {{ old('city') == 'Sousse' ? 'selected' : '' }}>Sousse</option>
                                    <option value="Monastir" {{ old('city') == 'Monastir' ? 'selected' : '' }}>Monastir</option>
                                    <option value="Mahdia" {{ old('city') == 'Mahdia' ? 'selected' : '' }}>Mahdia</option>
                                    <option value="Sfax" {{ old('city') == 'Sfax' ? 'selected' : '' }}>Sfax</option>
                                    <option value="Gabès" {{ old('city') == 'Gabès' ? 'selected' : '' }}>Gabès</option>
                                    <option value="Médenine" {{ old('city') == 'Médenine' ? 'selected' : '' }}>Médenine</option>
                                    <option value="Tataouine" {{ old('city') == 'Tataouine' ? 'selected' : '' }}>Tataouine</option>
                                    <option value="Gafsa" {{ old('city') == 'Gafsa' ? 'selected' : '' }}>Gafsa</option>
                                    <option value="Tozeur" {{ old('city') == 'Tozeur' ? 'selected' : '' }}>Tozeur</option>
                                    <option value="Kebili" {{ old('city') == 'Kebili' ? 'selected' : '' }}>Kebili</option>
                                </select>
                                @error('city')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Adresse complète
                                </label>
                                <input
                                    id="address"
                                    name="address"
                                    type="text"
                                    required
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Rue, quartier, code postal"
                                    value="{{ old('address') }}"
                                >
                                @error('address')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="specialties" class="block text-sm font-medium text-gray-700 mb-2">
                                    Marques spécialisées
                                </label>
                                <select name="specialties[]" id="specialties" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    <option value="" {{ !old('specialties') ? 'selected' : '' }}>Choisissez</option>
                                    <option value="Renault" {{ old('specialties') && in_array('Renault', old('specialties')) ? 'selected' : '' }}>Renault</option>
                                    <option value="Peugeot" {{ old('specialties') && in_array('Peugeot', old('specialties')) ? 'selected' : '' }}>Peugeot</option>
                                    <option value="Citroën" {{ old('specialties') && in_array('Citroën', old('specialties')) ? 'selected' : '' }}>Citroën</option>
                                    <option value="Fiat" {{ old('specialties') && in_array('Fiat', old('specialties')) ? 'selected' : '' }}>Fiat</option>
                                    <option value="Volkswagen" {{ old('specialties') && in_array('Volkswagen', old('specialties')) ? 'selected' : '' }}>Volkswagen</option>
                                    <option value="Toyota" {{ old('specialties') && in_array('Toyota', old('specialties')) ? 'selected' : '' }}>Toyota</option>
                                    <option value="Hyundai" {{ old('specialties') && in_array('Hyundai', old('specialties')) ? 'selected' : '' }}>Hyundai</option>
                                    <option value="Kia" {{ old('specialties') && in_array('Kia', old('specialties')) ? 'selected' : '' }}>Kia</option>
                                    <option value="Nissan" {{ old('specialties') && in_array('Nissan', old('specialties')) ? 'selected' : '' }}>Nissan</option>
                                    <option value="Honda" {{ old('specialties') && in_array('Honda', old('specialties')) ? 'selected' : '' }}>Honda</option>
                                    <option value="Mazda" {{ old('specialties') && in_array('Mazda', old('specialties')) ? 'selected' : '' }}>Mazda</option>
                                    <option value="Ford" {{ old('specialties') && in_array('Ford', old('specialties')) ? 'selected' : '' }}>Ford</option>
                                    <option value="Opel" {{ old('specialties') && in_array('Opel', old('specialties')) ? 'selected' : '' }}>Opel</option>
                                    <option value="BMW" {{ old('specialties') && in_array('BMW', old('specialties')) ? 'selected' : '' }}>BMW</option>
                                    <option value="Mercedes" {{ old('specialties') && in_array('Mercedes', old('specialties')) ? 'selected' : '' }}>Mercedes</option>
                                    <option value="Audi" {{ old('specialties') && in_array('Audi', old('specialties')) ? 'selected' : '' }}>Audi</option>
                                    <option value="Skoda" {{ old('specialties') && in_array('Skoda', old('specialties')) ? 'selected' : '' }}>Skoda</option>
                                    <option value="Seat" {{ old('specialties') && in_array('Seat', old('specialties')) ? 'selected' : '' }}>Seat</option>
                                    <option value="Dacia" {{ old('specialties') && in_array('Dacia', old('specialties')) ? 'selected' : '' }}>Dacia</option>
                                    <option value="Chevrolet" {{ old('specialties') && in_array('Chevrolet', old('specialties')) ? 'selected' : '' }}>Chevrolet</option>
                                    <option value="Toutes marques" {{ old('specialties') && in_array('Toutes marques', old('specialties')) ? 'selected' : '' }}>Toutes marques</option>
                                </select>
                                @error('specialties')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="experience_years" class="block text-sm font-medium text-gray-700 mb-2">
                                    Années d'expérience
                                </label>
                                <select name="experience_years" id="experience_years" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    <option value="">Choisissez</option>
                                    <option value="1-3" {{ old('experience_years') == '1-3' ? 'selected' : '' }}>1-3 ans</option>
                                    <option value="4-7" {{ old('experience_years') == '4-7' ? 'selected' : '' }}>4-7 ans</option>
                                    <option value="8-15" {{ old('experience_years') == '8-15' ? 'selected' : '' }}>8-15 ans</option>
                                    <option value="15+" {{ old('experience_years') == '15+' ? 'selected' : '' }}>Plus de 15 ans</option>
                                </select>
                                @error('experience_years')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Services proposés -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Services proposés
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                <label class="flex items-center space-x-2 checkbox-custom">
                                    <input type="checkbox" name="services[]" value="Vidange" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">Vidange</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="services[]" value="Réparation moteur" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">Réparation moteur</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="services[]" value="Pneus" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">Pneus</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="services[]" value="Électricité" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">Électricité</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="services[]" value="Climatisation" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">Climatisation</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="services[]" value="Carrosserie" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">Carrosserie</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="services[]" value="Diagnostic" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">Diagnostic</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="services[]" value="Freins" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">Freins</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="services[]" value="Entretien" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm">Entretien</span>
                                </label>
                            </div>
                            @error('services')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Autres spécialités -->
                        <div class="mt-6" x-data="{ customSpecialties: [] }">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Autres spécialités (optionnel)
                            </label>
                            <div class="space-y-2">
                                <div class="flex space-x-2">
                                    <input
                                        type="text"
                                        x-model="newSpecialty"
                                        placeholder="Ex: Réparation transmission, Peinture personnalisée..."
                                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent flex-1"
                                    >
                                    <button
                                        type="button"
                                        @click="if(newSpecialty.trim()) { customSpecialties.push(newSpecialty.trim()); newSpecialty = ''; }"
                                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm"
                                    >
                                        Ajouter
                                    </button>
                                </div>
                                
                                <div class="space-y-1">
                                    <template x-for="(specialty, index) in customSpecialties" :key="index">
                                        <div class="flex items-center space-x-2 bg-yellow-50 p-2 rounded">
                                            <span x-text="specialty" class="text-sm"></span>
                                            <input type="hidden" name="custom_specialties[]" :value="specialty">
                                            <button 
                                                type="button" 
                                                @click="customSpecialties.splice(index, 1)"
                                                class="text-red-600 hover:text-red-800"
                                            >
                                                ×
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sécurité -->
                    <div>
                        <h3 class="text-xl font-semibold mb-4 text-blue-600 flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <span class="text-blue-600 text-lg">🔒</span>
                            </div>
                            Sécurité
                        </h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Mot de passe
                                </label>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    required
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Votre mot de passe"
                                >
                                @error('password')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirmer le mot de passe
                                </label>
                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    required
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Confirmez votre mot de passe"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input
                            id="terms"
                            name="terms"
                            type="checkbox"
                            required
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        >
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            J'accepte les 
                            <a href="#" class="text-blue-600 hover:text-blue-700 transition-colors">
                                conditions d'utilisation
                            </a>
                            et la
                            <a href="#" class="text-blue-600 hover:text-blue-700 transition-colors">
                                politique de confidentialité
                            </a>
                        </label>
                    </div>

                    <button type="submit" class="w-full beautiful-button text-white py-3 px-6 rounded-lg font-semibold hover-scale btn-enhanced">
                        Créer mon compte garage
                    </button>

                    <div class="text-center">
                        <p class="text-gray-600">
                            Vous êtes client ? 
                            <a href="{{ route('register.client') }}" class="text-blue-600 hover:text-blue-700 transition-colors font-semibold">
                                Inscription Client
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Additional Info -->
            <div class="text-center text-sm text-gray-500 mt-8">
                 <p>
                     Développez votre activité avec notre plateforme tunisienne
                 </p>
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