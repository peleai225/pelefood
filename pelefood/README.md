# 🍽️ PeleFood - Plateforme de Gestion de Restaurants

## 📋 Description

PeleFood est une plateforme complète de gestion de restaurants permettant aux restaurateurs de digitaliser leurs opérations : gestion des commandes, menus, clients, et paiements en ligne.

## ✨ Fonctionnalités Principales

### 🔐 Authentification
- Connexion/Inscription sécurisées
- Gestion des rôles (super_admin, admin, restaurant, customer)
- Interface moderne avec animations

### 🏪 Gestion Restaurant
- Dashboard administrateur
- Gestion des menus et catégories
- Suivi des commandes en temps réel
- Analytics et rapports

### 💳 Paiements
- Intégration Stripe et PayPal
- Gestion des abonnements
- Facturation automatique

### 📱 Interface
- Design responsive et moderne
- Animations CSS avancées
- Interface utilisateur intuitive

## 🚀 Installation

### Prérequis
- PHP 8.1+
- Composer
- MySQL 8.0+
- Node.js 16+

### 1. Cloner le projet
```bash
git clone [url-du-repo]
cd pelefood
```

### 2. Installer les dépendances
```bash
composer install
npm install
```

### 3. Configuration
```bash
cp .env.example .env
# Configurer la base de données dans .env
```

### 4. Base de données
```bash
php artisan migrate
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=AssignSuperAdminRoleSeeder
```

### 5. Compiler les assets
```bash
npm run dev
```

### 6. Démarrer le serveur
```bash
php artisan serve
```

## 🔑 Accès Admin

- **URL** : http://localhost:8000/admin
- **Email** : admin@pelefood.com
- **Mot de passe** : password

## 📁 Structure du Projet

```
pelefood/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Contrôleurs admin
│   │   ├── Auth/           # Authentification
│   │   ├── Restaurant/     # Gestion restaurant
│   │   └── Public/         # Pages publiques
│   ├── Models/             # Modèles Eloquent
│   └── Providers/          # Fournisseurs de services
├── resources/
│   ├── views/
│   │   ├── admin/          # Vues admin
│   │   ├── auth/           # Pages d'auth
│   │   ├── landing/        # Pages publiques
│   │   └── layouts/        # Layouts
│   ├── css/                # Styles Tailwind
│   └── js/                 # JavaScript
├── routes/
│   ├── web.php             # Routes web
│   └── api.php             # Routes API
└── database/
    ├── migrations/          # Migrations DB
    └── seeders/            # Seeders
```

## 🎨 Technologies Utilisées

- **Backend** : Laravel 10
- **Frontend** : Tailwind CSS v4, Alpine.js
- **Base de données** : MySQL
- **Authentification** : Spatie Laravel Permission
- **Paiements** : Stripe, PayPal (Omnipay)

## 🔧 Configuration

### Variables d'environnement importantes
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pelefood
DB_USERNAME=root
DB_PASSWORD=

STRIPE_KEY=your_stripe_key
STRIPE_SECRET=your_stripe_secret
PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_SECRET=your_paypal_secret
```

## 📱 Routes Principales

- **Accueil** : `/`
- **Connexion** : `/login`
- **Inscription** : `/register`
- **Admin** : `/admin/dashboard`
- **Restaurant** : `/restaurant/dashboard`

## 🧪 Tests

```bash
php artisan test
```

## 📊 Performance

- **Lighthouse Score** : 95+
- **Core Web Vitals** : Excellents
- **Mobile First** : 100% responsive

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature
3. Commit les changements
4. Push vers la branche
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence MIT.

## 📞 Support

Pour toute question ou support, contactez l'équipe de développement.

---

**PeleFood** - Digitalisez votre restaurant ! 🚀✨
