@extends('layouts.app')

@section('title', 'Contact - GarageBooking')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Header Section -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Contactez-nous</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Notre équipe est là pour vous aider. N'hésitez pas à nous contacter pour toute question
                ou assistance concernant nos services.
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="professional-card p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Envoyez-nous un message</h2>

                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Prénom *
                            </label>
                            <input
                                type="text"
                                id="first_name"
                                name="first_name"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Votre prénom"
                            >
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom *
                            </label>
                            <input
                                type="text"
                                id="last_name"
                                name="last_name"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Votre nom"
                            >
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email *
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="votre@email.com"
                        >
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Téléphone
                        </label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="+216 XX XXX XXX"
                        >
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                            Sujet *
                        </label>
                        <select
                            id="subject"
                            name="subject"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            <option value="">Sélectionnez un sujet</option>
                            <option value="support">Support technique</option>
                            <option value="partnership">Partenariat garage</option>
                            <option value="complaint">Réclamation</option>
                            <option value="suggestion">Suggestion</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Message *
                        </label>
                        <textarea
                            id="message"
                            name="message"
                            rows="6"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                            placeholder="Décrivez votre demande..."
                        ></textarea>
                    </div>

                    <button
                        type="submit"
                        class="w-full beautiful-button text-white py-3 px-6 rounded-lg font-semibold hover-scale"
                    >
                        Envoyer le message
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
                <!-- Contact Details -->
                <div class="professional-card p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Informations de contact</h2>

                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-blue-600 text-xl">📍</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Adresse</h3>
                                <p class="text-gray-600">
                                    123 Avenue Habib Bourguiba<br>
                                    Tunis, Tunisie 1000
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-green-600 text-xl">📞</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Téléphone</h3>
                                <p class="text-gray-600">
                                    +216 71 123 456<br>
                                    +216 98 765 432
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-orange-600 text-xl">✉️</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Email</h3>
                                <p class="text-gray-600">
                                    contact@garagebooking.tn<br>
                                    support@garagebooking.tn
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-purple-600 text-xl">🕒</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Horaires d'ouverture</h3>
                                <p class="text-gray-600">
                                    Lundi - Vendredi: 8h00 - 18h00<br>
                                    Samedi: 9h00 - 16h00<br>
                                    Dimanche: Fermé
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="professional-card p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Questions fréquentes</h2>

                    <div class="space-y-4">
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Comment réserver un service ?</h3>
                            <p class="text-gray-600 text-sm">
                                Créez un compte, recherchez un garage et réservez en ligne en quelques clics.
                            </p>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Puis-je annuler ma réservation ?</h3>
                            <p class="text-gray-600 text-sm">
                                Oui, vous pouvez annuler gratuitement jusqu'à 24h avant le rendez-vous.
                            </p>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Les garages sont-ils certifiés ?</h3>
                            <p class="text-gray-600 text-sm">
                                Tous nos garages partenaires sont rigoureusement sélectionnés et contrôlés.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="professional-card p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Suivez-nous</h2>

                    <div class="flex space-x-4">
                        <a href="#" class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center text-white hover:bg-blue-700 transition-colors">
                            <span class="text-xl">📘</span>
                        </a>
                        <a href="#" class="w-12 h-12 bg-pink-600 rounded-lg flex items-center justify-center text-white hover:bg-pink-700 transition-colors">
                            <span class="text-xl">📷</span>
                        </a>
                        <a href="#" class="w-12 h-12 bg-blue-400 rounded-lg flex items-center justify-center text-white hover:bg-blue-500 transition-colors">
                            <span class="text-xl">🐦</span>
                        </a>
                        <a href="#" class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center text-white hover:bg-red-700 transition-colors">
                            <span class="text-xl">📺</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection