<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-red.svg" alt="Laravel 11">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue.svg" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/MySQL-8.0+-orange.svg" alt="MySQL 8.0+">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.0+-blue.svg" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Stripe-Payments-635bff.svg" alt="Stripe">
  <img src="https://img.shields.io/badge/D17-Tunisia-0066cc.svg" alt="D17 Tunisia">
</p>

<p align="center">
  <img src="https://img.shields.io/github/repo-size/nefziamine/GarageBooking" alt="Repo Size">
  <img src="https://img.shields.io/github/languages/count/nefziamine/GarageBooking" alt="Languages">
  <img src="https://img.shields.io/github/last-commit/nefziamine/GarageBooking" alt="Last Commit">
  <img src="https://img.shields.io/badge/Made_in-Tunisia 🇹🇳-green" alt="Made in Tunisia">
</p>

<h1 align="center">🚗 GarageBooking</h1>

<p align="center">
  <strong>Plateforme de Réservation de Services Automobiles en Tunisie</strong><br>
  Connectez les clients tunisiens avec les meilleurs garages - Paiements multiples intégrés
</p>

<p align="center">
  <a href="#-démarrage-rapide">Démarrage Rapide</a> •
  <a href="#-fonctionnalités">Fonctionnalités</a> •
  <a href="#-technologies">Technologies</a> •
  <a href="#-installation">Installation</a> •
  <a href="#-paiements">Paiements</a> •
  <a href="#-contributing">Contributing</a>
</p>

---

## 🌟 À propos du projet

**GarageBooking** est une plateforme web moderne développée avec Laravel qui révolutionne la façon dont les Tunisiens réservent des services automobiles. Notre plateforme connecte les clients avec les garages de confiance, offrant une expérience de réservation fluide avec un système de paiement intégré supportant les cartes bancaires internationales et le paiement mobile tunisien D17.

### 🎯 Mission
Simplifier l'accès aux services automobiles de qualité en Tunisie tout en offrant des solutions de paiement adaptées au marché local.

---

## ✨ Fonctionnalités

### 👥 Gestion des utilisateurs
- **Inscription double** : Clients et Garages
- **Profils personnalisés** avec informations détaillées
- **Authentification sécurisée** avec Laravel Sanctum
- **Gestion des rôles** et permissions

### 🏪 Système de garages
- **Catalogue complet** des garages tunisiens
- **Services personnalisables** par garage
- **Horaires de travail** flexibles
- **Géolocalisation** et recherche avancée
- **Système de notation** et avis clients

### 📅 Réservations intelligentes
- **Réservation en ligne** 24/7
- **Calendrier interactif** avec disponibilités
- **Confirmation instantanée** par email/SMS
- **Historique complet** des réservations
- **Annulation flexible** selon les politiques

### 💳 Paiements multiples
- **Cartes bancaires internationales** (Visa, MasterCard) via Stripe
- **Paiement mobile tunisien** D17 pour les utilisateurs locaux
- **Mode test** pour le développement
- **Sécurité SSL 256-bit** garantie
- **Confirmation de paiement** en temps réel

### 🎨 Interface moderne
- **Design responsive** adapté mobile/desktop
- **Interface intuitive** en français/arabe
- **Animations fluides** et UX optimisée
- **Accessibilité** WCAG compliant

---

## 🛠️ Technologies

### Backend
- **[Laravel 11](https://laravel.com/)** - Framework PHP robuste et élégant
- **[PHP 8.2+](https://php.net/)** - Langage de programmation moderne
- **[MySQL 8.0+](https://mysql.com/)** - Base de données relationnelle

### Frontend
- **[Tailwind CSS](https://tailwindcss.com/)** - Framework CSS utilitaire
- **JavaScript Vanilla** - Interactions dynamiques
- **[Blade Templates](https://laravel.com/docs/blade)** - Moteur de templates Laravel

### Paiements
- **[Stripe](https://stripe.com/)** - Gateway de paiement international
- **[D17 Tunisia](https://d17.tn/)** - Paiement mobile tunisien

### Outils de développement
- **Composer** - Gestionnaire de dépendances PHP
- **NPM** - Gestionnaire de packages JavaScript
- **Vite** - Outil de build rapide
- **Git** - Contrôle de version

---

## 🚀 Démarrage rapide

### Prérequis
- PHP 8.2 ou supérieur
- Composer
- Node.js & NPM
- MySQL 8.0+
- Git

### Installation

1. **Cloner le repository**
   ```bash
   git clone https://github.com/nefziamine/GarageBooking.git
   cd GarageBooking
   ```

2. **Installer les dépendances PHP**
   ```bash
   composer install
   ```

3. **Installer les dépendances JavaScript**
   ```bash
   npm install
   ```

4. **Configuration de l'environnement**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configuration de la base de données**
   ```bash
   # Modifier .env avec vos credentials MySQL
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=garagebooking
   DB_USERNAME=votre_username
   DB_PASSWORD=votre_password
   ```

6. **Migration et seeding**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Configuration des paiements**
   ```bash
   # Dans .env, ajouter vos clés Stripe
   STRIPE_KEY=pk_test_...
   STRIPE_SECRET=sk_test_...

   # Configuration D17 (optionnel pour production)
   D17_API_KEY=votre_cle_d17
   D17_API_URL=https://api.d17.tn
   ```

8. **Build des assets**
   ```bash
   npm run build
   # ou pour le développement
   npm run dev
   ```

9. **Démarrer le serveur**
   ```bash
   php artisan serve
   ```

   L'application sera accessible sur `http://localhost:8000`

---

## 💳 Configuration des paiements

### Stripe (Cartes bancaires)
1. Créer un compte sur [Stripe.com](https://stripe.com)
2. Récupérer vos clés API (Publishable Key & Secret Key)
3. Les ajouter dans le fichier `.env`

### D17 Tunisia (Paiement mobile)
1. S'inscrire auprès de [D17](https://d17.tn/)
2. Obtenir votre clé API
3. Configurer dans `.env` :
   ```env
   D17_API_KEY=votre_cle_api
   D17_API_URL=https://api.d17.tn
   ```

### Mode test
Pour le développement, le mode test est activé par défaut avec des données fictives.

---

## 📁 Structure du projet

```
GarageBooking/
├── app/                    # Code de l'application Laravel
│   ├── Http/Controllers/   # Contrôleurs
│   ├── Models/            # Modèles Eloquent
│   ├── Policies/          # Politiques d'autorisation
│   └── Providers/         # Service Providers
├── database/              # Migrations et seeders
│   ├── migrations/        # Schémas de base de données
│   └── seeders/          # Données de test
├── public/               # Assets publics
├── resources/            # Views et assets
│   ├── css/             # Styles CSS
│   ├── js/              # JavaScript
│   └── views/           # Templates Blade
├── routes/               # Définition des routes
└── tests/               # Tests automatisés
```

---

## 🧪 Tests

```bash
# Exécuter tous les tests
php artisan test

# Tests avec couverture
php artisan test --coverage
```

---

## 📊 Base de données

Le schéma de base de données inclut :

- **Users** : Clients et propriétaires de garages
- **Garages** : Informations des garages
- **Garage Services** : Services offerts par garage
- **Bookings** : Réservations avec statut de paiement
- **Reviews** : Système d'avis et notation

### Migration principale
```bash
php artisan migrate
```

---

## 🔒 Sécurité

- **Chiffrement des mots de passe** avec bcrypt
- **Protection CSRF** sur tous les formulaires
- **Validation des données** côté serveur
- **Authentification sécurisée** avec Laravel
- **Paiements SSL** certifiés

---

## 🌍 Déploiement

### Prérequis serveur
- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js
- Serveur web (Apache/Nginx)

### Commandes de déploiement
```bash
# Installation des dépendances
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Base de données
php artisan migrate --force
php artisan db:seed --class=ProductionSeeder
```

---

## 🤝 Contributing

Nous accueillons les contributions ! Voici comment contribuer :

1. **Fork** le projet
2. **Créer** une branche feature (`git checkout -b feature/AmazingFeature`)
3. **Commit** vos changements (`git commit -m 'Add some AmazingFeature'`)
4. **Push** vers la branche (`git push origin feature/AmazingFeature`)
5. **Ouvrir** une Pull Request

### Standards de code
- Respecter PSR-12 pour PHP
- Utiliser ESLint pour JavaScript
- Tests unitaires requis
- Documentation des nouvelles fonctionnalités

---

## 📝 License

Ce projet est sous licence MIT - voir le fichier [LICENSE](LICENSE) pour plus de détails.

---

## 👥 Équipe

- **Développeur principal** : [Nefzi Amine](https://github.com/nefziamine)
- **Technologies** : Laravel, PHP, MySQL, Tailwind CSS
- **Localisation** : Tunis, Tunisie 🇹🇳

---

## 📞 Support

Pour support technique ou questions :
- 📧 Email : dev@garagebooking.tn
- 🐛 Issues : [GitHub Issues](https://github.com/nefziamine/GarageBooking/issues)
- 📖 Documentation : [Wiki](https://github.com/nefziamine/GarageBooking/wiki)

---

<p align="center">
  <strong>Fait avec ❤️ en Tunisie 🇹🇳</strong><br>
  <em>Simplifiant l'accès aux services automobiles depuis 2024</em>
</p>

<p align="center">
  <a href="https://laravel.com/">Laravel</a> •
  <a href="https://stripe.com/">Stripe</a> •
  <a href="https://d17.tn/">D17 Tunisia</a> •
  <a href="https://tailwindcss.com/">Tailwind CSS</a>
</p>

