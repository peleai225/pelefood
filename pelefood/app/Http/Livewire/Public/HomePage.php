<?php

namespace App\Http\Livewire\Public;

use Livewire\Component;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Order;

class HomePage extends Component
{
    public $stats = [
        'restaurants' => 0,
        'users' => 0,
        'orders' => 0,
        'revenue' => 0
    ];
    
    public $features = [
        [
            'icon' => 'fas fa-utensils',
            'title' => 'Gestion de Menu',
            'description' => 'Créez et gérez facilement vos menus avec des catégories personnalisées et des prix dynamiques.',
            'color' => 'from-red-500 to-red-600'
        ],
        [
            'icon' => 'fas fa-shopping-cart',
            'title' => 'Commandes en Temps Réel',
            'description' => 'Recevez et gérez les commandes instantanément avec des notifications push et un suivi en direct.',
            'color' => 'from-blue-400 to-purple-500'
        ],
        [
            'icon' => 'fas fa-credit-card',
            'title' => 'Paiements Sécurisés',
            'description' => 'Intégration avec les principales passerelles de paiement pour des transactions sécurisées.',
            'color' => 'from-green-400 to-teal-500'
        ],
        [
            'icon' => 'fas fa-chart-line',
            'title' => 'Analytics Avancés',
            'description' => 'Analysez vos performances avec des tableaux de bord détaillés et des rapports personnalisés.',
            'color' => 'from-purple-400 to-pink-500'
        ],
        [
            'icon' => 'fas fa-mobile-alt',
            'title' => 'Application Mobile',
            'description' => 'Application mobile native pour gérer votre restaurant depuis n\'importe où.',
            'color' => 'from-indigo-400 to-blue-500'
        ],
        [
            'icon' => 'fas fa-users',
            'title' => 'Gestion des Clients',
            'description' => 'Base de données clients complète avec historique des commandes et préférences.',
            'color' => 'from-yellow-400 to-orange-500'
        ]
    ];
    
    public $testimonials = [
        [
            'name' => 'Marie Dubois',
            'restaurant' => 'Le Bistrot Parisien',
            'content' => 'PeleFood a transformé notre restaurant ! Nos commandes en ligne ont augmenté de 300% en 6 mois. C\'est vraiment le Shopify de la restauration !',
            'rating' => 5,
            'avatar' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80'
        ],
        [
            'name' => 'Ahmed Hassan',
            'restaurant' => 'Restaurant Aladin',
            'content' => 'Interface intuitive, paiements fluides, analytics détaillés. PeleFood nous a permis de moderniser complètement notre service.',
            'rating' => 5,
            'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80'
        ],
        [
            'name' => 'Sophie Martin',
            'restaurant' => 'Café des Arts',
            'content' => 'Support exceptionnel et fonctionnalités complètes. Nos clients adorent l\'expérience de commande. Un investissement qui se rentabilise rapidement !',
            'rating' => 5,
            'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80'
        ]
    ];
    
    public $pricingPlans = [
        [
            'name' => 'Starter',
            'price' => '29',
            'period' => 'mois',
            'description' => 'Parfait pour les petits restaurants',
            'features' => [
                'Jusqu\'à 50 produits',
                '100 commandes/mois',
                'Support email',
                'Paiements en ligne',
                'Analytics de base'
            ],
            'color' => 'from-red-400 to-red-500',
            'popular' => false
        ],
        [
            'name' => 'Professional',
            'price' => '79',
            'period' => 'mois',
            'description' => 'Idéal pour les restaurants moyens',
            'features' => [
                'Produits illimités',
                'Commandes illimitées',
                'Support prioritaire',
                'Application mobile',
                'Analytics avancés',
                'Gestion multi-restaurants'
            ],
            'color' => 'from-red-500 to-red-600',
            'popular' => true
        ],
        [
            'name' => 'Enterprise',
            'price' => '149',
            'period' => 'mois',
            'description' => 'Pour les grandes chaînes',
            'features' => [
                'Tout du Professional',
                'API personnalisée',
                'Support dédié 24/7',
                'Formation personnalisée',
                'Intégrations avancées',
                'SLA garantie'
            ],
            'color' => 'from-red-600 to-red-700',
            'popular' => false
        ]
    ];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->stats = [
            'restaurants' => Restaurant::count(),
            'users' => User::count(),
            'orders' => Order::count(),
            'revenue' => Order::where('status', 'delivered')->sum('total_amount')
        ];
    }

    public function render()
    {
        return view('livewire.public.home-page')
            ->layout('layouts.saas-livewire');
    }
}
