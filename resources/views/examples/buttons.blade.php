<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemples de Boutons - GarageBooking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/buttons.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 100%);
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .example-section {
            margin-bottom: 40px;
            padding: 20px;
            border: 2px solid #FFD600;
            border-radius: 12px;
            background: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-4xl font-bold text-center mb-8" style="color: #E70013;">
            🇹🇳 Exemples de Boutons Tunisians
        </h1>

        <!-- Boutons Primaires -->
        <div class="example-section">
            <h2 class="text-2xl font-bold mb-4" style="color: #E70013;">Boutons Primaires</h2>
            <div class="btn-group-tunisian">
                <button class="btn-tunisian-primary">Bouton Primaire</button>
                <button class="btn-tunisian-primary btn-tunisian-sm">Petit Bouton</button>
                <button class="btn-tunisian-primary btn-tunisian-lg">Grand Bouton</button>
                <button class="btn-tunisian-primary btn-tunisian-star">Bouton avec Étoile</button>
            </div>
        </div>

        <!-- Boutons Secondaires -->
        <div class="example-section">
            <h2 class="text-2xl font-bold mb-4" style="color: #E70013;">Boutons Secondaires</h2>
            <div class="btn-group-tunisian">
                <button class="btn-tunisian-secondary">Bouton Secondaire</button>
                <button class="btn-tunisian-secondary btn-tunisian-sm">Petit Bouton</button>
                <button class="btn-tunisian-secondary btn-tunisian-lg">Grand Bouton</button>
            </div>
        </div>

        <!-- Boutons Jaunes -->
        <div class="example-section">
            <h2 class="text-2xl font-bold mb-4" style="color: #E70013;">Boutons Jaunes</h2>
            <div class="btn-group-tunisian">
                <button class="btn-tunisian-yellow">Bouton Jaune</button>
                <button class="btn-tunisian-yellow btn-tunisian-sm">Petit Bouton</button>
                <button class="btn-tunisian-yellow btn-tunisian-lg">Grand Bouton</button>
            </div>
        </div>

        <!-- Boutons Désactivés -->
        <div class="example-section">
            <h2 class="text-2xl font-bold mb-4" style="color: #E70013;">Boutons Désactivés</h2>
            <div class="btn-group-tunisian">
                <button class="btn-tunisian-primary" disabled>Bouton Désactivé</button>
                <button class="btn-tunisian-secondary" disabled>Bouton Désactivé</button>
                <button class="btn-tunisian-yellow" disabled>Bouton Désactivé</button>
            </div>
        </div>

        <!-- Exemples d'Utilisation -->
        <div class="example-section">
            <h2 class="text-2xl font-bold mb-4" style="color: #E70013;">Exemples d'Utilisation</h2>
            
            <h3 class="text-xl font-semibold mb-3">Formulaire de Connexion</h3>
            <div class="btn-group-tunisian">
                <button class="btn-tunisian-primary">Se Connecter</button>
                <button class="btn-tunisian-secondary">Mot de Passe Oublié</button>
            </div>

            <h3 class="text-xl font-semibold mb-3 mt-6">Actions de Garage</h3>
            <div class="btn-group-tunisian">
                <button class="btn-tunisian-primary btn-tunisian-star">Réserver un Rendez-vous</button>
                <button class="btn-tunisian-yellow">Voir les Tarifs</button>
                <button class="btn-tunisian-secondary">Contacter le Garage</button>
            </div>

            <h3 class="text-xl font-semibold mb-3 mt-6">Actions Administratives</h3>
            <div class="btn-group-tunisian">
                <button class="btn-tunisian-primary">Enregistrer</button>
                <button class="btn-tunisian-secondary">Annuler</button>
                <button class="btn-tunisian-yellow">Modifier</button>
            </div>
        </div>

        <!-- Code d'Utilisation -->
        <div class="example-section">
            <h2 class="text-2xl font-bold mb-4" style="color: #E70013;">Comment Utiliser</h2>
            <div class="bg-gray-100 p-4 rounded-lg">
                <h3 class="font-semibold mb-2">1. Inclure le CSS :</h3>
                <code class="block bg-white p-2 rounded mb-4">
                    &lt;link href="{{ asset('css/buttons.css') }}" rel="stylesheet"&gt;
                </code>

                <h3 class="font-semibold mb-2">2. Classes Disponibles :</h3>
                <ul class="list-disc list-inside space-y-1">
                    <li><code>btn-tunisian-primary</code> - Bouton principal (rouge)</li>
                    <li><code>btn-tunisian-secondary</code> - Bouton secondaire (contour rouge)</li>
                    <li><code>btn-tunisian-yellow</code> - Bouton jaune</li>
                    <li><code>btn-tunisian-sm</code> - Bouton petit</li>
                    <li><code>btn-tunisian-lg</code> - Bouton grand</li>
                    <li><code>btn-tunisian-star</code> - Ajoute une étoile ★</li>
                    <li><code>btn-group-tunisian</code> - Groupe de boutons</li>
                </ul>

                <h3 class="font-semibold mb-2 mt-4">3. Exemple d'Utilisation :</h3>
                <code class="block bg-white p-2 rounded">
                    &lt;button class="btn-tunisian-primary btn-tunisian-lg btn-tunisian-star"&gt;Mon Bouton&lt;/button&gt;
                </code>
            </div>
        </div>
    </div>
</body>
</html> 