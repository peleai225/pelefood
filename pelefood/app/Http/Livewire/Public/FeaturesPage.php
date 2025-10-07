<?php

namespace App\Http\Livewire\Public;

use Livewire\Component;

class FeaturesPage extends Component
{
    public $features = [
        [
            'icon' => 'fas fa-utensils',
            'title' => 'Gestion de Menu',
            'description' => 'Créez et gérez facilement vos menus avec des catégories personnalisées et des prix dynamiques.',
            'details' => [
                'Création de produits illimitée',
                'Catégories personnalisables',
                'Gestion des prix et promotions',
                'Images haute qualité',
                'Disponibilité en temps réel'
            ],
            'color' => 'from-orange-400 to-red-500'
        ],
        [
            'icon' => 'fas fa-shopping-cart',
            'title' => 'Commandes en Temps Réel',
            'description' => 'Recevez et gérez les commandes instantanément avec des notifications push et un suivi en direct.',
            'details' => [
                'Notifications push instantanées',
                'Suivi des commandes en temps réel',
                'Statuts automatiques',
                'Gestion des modifications',
                'Historique complet'
            ],
            'color' => 'from-blue-400 to-purple-500'
        ],
        [
            'icon' => 'fas fa-credit-card',
            'title' => 'Paiements Sécurisés',
            'description' => 'Intégration avec les principales passerelles de paiement pour des transactions sécurisées.',
            'details' => [
                'Stripe, PayPal, Mobile Money',
                'Paiements sécurisés SSL',
                'Gestion des remboursements',
                'Facturation automatique',
                'Rapports financiers'
            ],
            'color' => 'from-green-400 to-teal-500'
        ],
        [
            'icon' => 'fas fa-chart-line',
            'title' => 'Analytics Avancés',
            'description' => 'Analysez vos performances avec des tableaux de bord détaillés et des rapports personnalisés.',
            'details' => [
                'Tableaux de bord personnalisés',
                'Rapports de ventes détaillés',
                'Analyse des tendances',
                'Métriques de performance',
                'Export des données'
            ],
            'color' => 'from-purple-400 to-pink-500'
        ],
        [
            'icon' => 'fas fa-mobile-alt',
            'title' => 'Application Mobile',
            'description' => 'Application mobile native pour gérer votre restaurant depuis n\'importe où.',
            'details' => [
                'Application iOS et Android',
                'Interface intuitive',
                'Notifications push',
                'Mode hors ligne',
                'Synchronisation automatique'
            ],
            'color' => 'from-indigo-400 to-blue-500'
        ],
        [
            'icon' => 'fas fa-users',
            'title' => 'Gestion des Clients',
            'description' => 'Base de données clients complète avec historique des commandes et préférences.',
            'details' => [
                'Base de données clients',
                'Historique des commandes',
                'Préférences personnalisées',
                'Programme de fidélité',
                'Communication ciblée'
            ],
            'color' => 'from-yellow-400 to-orange-500'
        ],
        [
            'icon' => 'fas fa-truck',
            'title' => 'Gestion de Livraison',
            'description' => 'Optimisez vos livraisons avec un système de suivi en temps réel et de géolocalisation.',
            'details' => [
                'Suivi GPS en temps réel',
                'Optimisation des trajets',
                'Gestion des livreurs',
                'Notifications clients',
                'Évaluation des performances'
            ],
            'color' => 'from-teal-400 to-green-500'
        ],
        [
            'icon' => 'fas fa-cog',
            'title' => 'Intégrations Avancées',
            'description' => 'Connectez PeleFood avec vos outils existants grâce à notre API robuste.',
            'details' => [
                'API REST complète',
                'Webhooks personnalisés',
                'Intégrations tierces',
                'Synchronisation automatique',
                'Documentation complète'
            ],
            'color' => 'from-gray-400 to-slate-500'
        ]
    ];

    public function render()
    {
        return view('livewire.public.features-page')
            ->layout('layouts.saas-livewire');
    }
}
