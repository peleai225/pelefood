<?php

namespace App\Http\Livewire\Public;

use Livewire\Component;

class PricingPage extends Component
{
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
                'Analytics de base',
                '1 restaurant'
            ],
            'color' => 'from-gray-400 to-gray-600',
            'popular' => false,
            'cta' => 'Commencer'
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
                'Gestion multi-restaurants',
                'Intégrations API',
                'Formation incluse'
            ],
            'color' => 'from-orange-400 to-red-500',
            'popular' => true,
            'cta' => 'Commencer'
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
                'SLA garantie',
                'Développements sur mesure',
                'Gestionnaire de compte dédié'
            ],
            'color' => 'from-purple-400 to-indigo-500',
            'popular' => false,
            'cta' => 'Nous contacter'
        ]
    ];
    
    public $faqs = [
        [
            'question' => 'Puis-je changer de plan à tout moment ?',
            'answer' => 'Oui, vous pouvez passer à un plan supérieur ou inférieur à tout moment. Les changements sont appliqués immédiatement et les factures sont ajustées proportionnellement.'
        ],
        [
            'question' => 'Y a-t-il des frais d\'installation ?',
            'answer' => 'Non, il n\'y a aucun frais d\'installation ou de configuration. Nous vous accompagnons gratuitement dans la mise en place de votre compte.'
        ],
        [
            'question' => 'Puis-je essayer PeleFood gratuitement ?',
            'answer' => 'Oui, nous offrons un essai gratuit de 14 jours sans engagement. Aucune carte de crédit n\'est requise pour commencer.'
        ],
        [
            'question' => 'Quels moyens de paiement acceptez-vous ?',
            'answer' => 'Nous acceptons toutes les cartes de crédit principales (Visa, Mastercard, American Express) ainsi que les virements bancaires pour les plans Enterprise.'
        ],
        [
            'question' => 'Proposez-vous des remises pour les contrats annuels ?',
            'answer' => 'Oui, nous offrons 2 mois gratuits pour tout paiement annuel, soit une réduction de 16,7% sur votre facture.'
        ],
        [
            'question' => 'Que se passe-t-il si j\'annule mon abonnement ?',
            'answer' => 'Vous pouvez annuler votre abonnement à tout moment. Vous conservez l\'accès à votre compte jusqu\'à la fin de la période de facturation en cours.'
        ]
    ];

    public function render()
    {
        return view('livewire.public.pricing-page')
            ->layout('layouts.saas-livewire');
    }
}
