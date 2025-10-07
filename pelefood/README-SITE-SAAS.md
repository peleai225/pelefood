# 🚀 PeleFood - Site SaaS pour Restaurants

## Vue d'ensemble

PeleFood est un **SaaS innovant pour la gestion de restaurants**, conçu comme le "Shopify des restaurants". Il modernise l'expérience à la fois des clients et des restaurateurs avec un design élégant et des fonctionnalités complètes adaptées au secteur alimentaire.

## 🎯 Positionnement

**"Le Shopify pour les Restaurants"** - Une plateforme tout-en-un qui transforme votre restaurant en plateforme digitale moderne.

## ✨ Fonctionnalités Principales

### 🍽️ Gestion Complète du Restaurant
- **Menu numérique** avec photos et descriptions
- **Commandes en temps réel** avec notifications push
- **Paiements intégrés** (cartes, mobile money)
- **Analytics avancés** avec tableaux de bord
- **Application mobile** native
- **Gestion du personnel** et des rôles

### 🎨 Design Moderne
- **Couleurs harmonisées** avec le backoffice Super Admin
- **Gradient rouge dégradé** (#dc2626 → #ef4444)
- **Animations fluides** avec Alpine.js
- **Interface responsive** et moderne
- **Effets de verre** (glassmorphism)

## 🛠️ Technologies Utilisées

### Frontend
- **Livewire** pour l'interactivité
- **Tailwind CSS** (local, optimisé)
- **Alpine.js** pour les animations
- **Font Awesome** pour les icônes

### Backend
- **Laravel** avec Livewire
- **MySQL** pour la base de données
- **Composants Livewire** pour chaque page

## 📱 Pages du Site

### 1. Page d'Accueil (`/`)
- **Hero section** avec message "Shopify des restaurants"
- **Statistiques dynamiques** (restaurants, utilisateurs, commandes, CA)
- **Fonctionnalités clés** avec icônes et descriptions
- **Témoignages clients** avec photos et étoiles
- **Plans tarifaires** avec mise en avant du plan populaire

### 2. Fonctionnalités (`/features`)
- **Détail complet** de toutes les fonctionnalités
- **Organisation claire** par catégories
- **Design attractif** avec cartes et animations

### 3. Tarifs (`/pricing`)
- **3 plans** : Starter (Gratuit), Professional (49€), Enterprise (Sur devis)
- **Comparaison détaillée** des fonctionnalités
- **FAQ interactive** avec Alpine.js
- **Mise en avant** du plan populaire

### 4. Contact (`/contact`)
- **Formulaire complet** avec validation Livewire
- **Informations de contact** avec icônes
- **Design moderne** avec cartes et effets

## 🎨 Palette de Couleurs

```css
/* Couleurs principales */
Primary: #dc2626 (rouge-600)
Secondary: #ef4444 (rouge-500)
Accent: #b91c1c (rouge-700)

/* Gradients */
Primary: linear-gradient(135deg, #dc2626 0%, #ef4444 100%)
Secondary: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%)
```

## 🚀 Optimisations Production

### Assets Optimisés
- **Tailwind CSS local** (150.79 KB minifié)
- **Alpine.js local** (1.34 KB)
- **Plus de CDN** pour de meilleures performances
- **Build optimisé** avec Vite

### Performance
- **Lazy loading** des images
- **Animations optimisées** avec CSS
- **Code minifié** pour la production
- **Service Worker** prêt pour PWA

## 📊 Contenu Dynamique

### Statistiques en Temps Réel
```php
$stats = [
    'restaurants' => Restaurant::count(),
    'users' => User::count(),
    'orders' => Order::count(),
    'revenue' => Order::where('status', 'delivered')->sum('total_amount')
];
```

### Témoignages Clients
- **3 témoignages** avec photos professionnelles
- **Étoiles** et avis détaillés
- **Focus** sur l'aspect "Shopify des restaurants"

## 🎯 Messages Clés

1. **"Le Shopify pour les Restaurants"**
2. **"Transformez votre restaurant en plateforme digitale"**
3. **"SaaS innovant qui révolutionne la gestion des restaurants"**
4. **"Comme Shopify transforme le e-commerce, PeleFood révolutionne la restauration"**

## 🔧 Configuration

### Installation
```bash
# Installer les dépendances
npm install

# Compiler les assets
npm run build-css-prod

# Démarrer le serveur
php artisan serve
```

### URLs de Test
- **Accueil** : http://127.0.0.1:8000/
- **Fonctionnalités** : http://127.0.0.1:8000/features
- **Tarifs** : http://127.0.0.1:8000/pricing
- **Contact** : http://127.0.0.1:8000/contact

## 📈 Résultats Attendus

- **Site moderne et attractif** qui reflète l'innovation
- **Conversion optimisée** avec CTA clairs
- **Performance excellente** sans CDN
- **Expérience utilisateur** fluide et professionnelle
- **Positionnement clair** comme leader du secteur

---

**PeleFood** - Révolutionnant la gestion des restaurants avec la technologie SaaS moderne ! 🚀
