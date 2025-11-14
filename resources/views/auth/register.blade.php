<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - GarageBooking</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        
        .tunisian-input {
            border: 2px solid var(--tunisian-yellow);
            border-radius: 8px;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }
        
        .tunisian-input:focus {
            border-color: var(--tunisian-red);
            outline: none;
            box-shadow: 0 0 0 3px rgba(231, 0, 19, 0.1);
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
                    <a href="#" class="hover:text-yellow-300 transition-colors">Garages</a>
                    <a href="#" class="hover:text-yellow-300 transition-colors">Contact</a>
                    <a href="{{ route('login') }}" class="hover:text-yellow-300 transition-colors">Connexion</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center fade-in">
                <div class="w-20 h-20 bg-yellow-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-red-600 font-bold text-3xl">G</span>
                </div>
                <h2 class="text-3xl font-bold mb-2">
                    <span class="tunisian-accent">Inscription</span> à 
                    <span class="tunisian-yellow-text">GarageBooking</span>
                </h2>
                <p class="text-gray-600">
                    Créez votre compte pour accéder à tous nos services
                </p>
            </div>

            <div class="tunisian-card p-8 slide-up">
                <form method="POST" action="{{ route('register.choice') }}" class="space-y-6">
                    @csrf
                    
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
                                class="tunisian-input w-full"
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
                                class="tunisian-input w-full"
                                placeholder="Votre nom"
                                value="{{ old('last_name') }}"
                            >
                            @error('last_name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Adresse e-mail
                        </label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            required 
                            class="tunisian-input w-full"
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
                            class="tunisian-input w-full"
                            placeholder="+216 XX XXX XXX"
                            value="{{ old('phone') }}"
                        >
                        @error('phone')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Mot de passe
                        </label>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            required 
                            class="tunisian-input w-full"
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
                            class="tunisian-input w-full"
                            placeholder="Confirmez votre mot de passe"
                        >
                    </div>

                    <div class="flex items-center">
                        <input 
                            id="terms" 
                            name="terms" 
                            type="checkbox" 
                            required
                            class="h-4 w-4 text-red-600 focus:ring-red-500 border-yellow-400 rounded"
                        >
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            J'accepte les 
                            <a href="#" class="tunisian-accent hover:text-red-700 transition-colors">
                                conditions d'utilisation
                            </a> 
                            et la 
                            <a href="#" class="tunisian-accent hover:text-red-700 transition-colors">
                                politique de confidentialité
                            </a>
                        </label>
                    </div>

                    <div class="btn-group-tunisian">
                        <button type="submit" class="btn-tunisian-primary btn-tunisian-lg w-full">
                            <span class="tunisian-star">★</span> Créer mon compte
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="text-gray-600">
                            Déjà un compte ? 
                            <a href="{{ route('login') }}" class="tunisian-accent hover:text-red-700 transition-colors font-semibold">
                                Se connecter
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Additional Info -->
            <div class="text-center text-sm text-gray-500">
                <p>
                    <span class="tunisian-star">★</span> 
                    Rejoignez la communauté des garagistes tunisiens 
                    <span class="tunisian-star">★</span>
                </p>
            </div>
        </div>
    </div>

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