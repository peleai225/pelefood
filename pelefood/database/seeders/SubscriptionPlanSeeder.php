<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprimer tous les plans existants
        SubscriptionPlan::query()->delete();

        // Plan Mensuel - 30.000 FCFA
        SubscriptionPlan::create([
            'name' => 'Plan Mensuel',
            'slug' => 'plan-mensuel',
            'description' => 'Abonnement mensuel pour votre restaurant',
            'price' => 30000,
            'currency' => 'XOF',
            'billing_cycle' => 'monthly',
            'trial_days' => 0,
            'max_products' => null, // Illimité
            'max_categories' => null, // Illimité
            'max_restaurants' => 1,
            'allows_customization' => true,
            'allows_analytics' => true,
            'allows_api' => false,
            'allows_export' => true,
            'allows_integrations' => false,
            'support_level' => 'priority',
            'features' => 'Produits illimités, Catégories illimitées, Gestion des commandes, Site web personnalisé, Analytics et rapports, Export de données, Support prioritaire, Promotions et offres, Gestion des avis clients',
            'is_active' => true,
            'is_popular' => false,
        ]);

        // Plan Annuel - 30.000 FCFA (avec réduction de 30.000 FCFA)
        SubscriptionPlan::create([
            'name' => 'Plan Annuel',
            'slug' => 'plan-annuel',
            'description' => 'Abonnement annuel avec économie de 30.000 FCFA',
            'price' => 30000, // Prix affiché (après réduction)
            'currency' => 'XOF',
            'billing_cycle' => 'yearly',
            'trial_days' => 0,
            'max_products' => null, // Illimité
            'max_categories' => null, // Illimité
            'max_restaurants' => 1,
            'allows_customization' => true,
            'allows_analytics' => true,
            'allows_api' => false,
            'allows_export' => true,
            'allows_integrations' => false,
            'support_level' => 'priority',
            'features' => 'Tout du plan mensuel, Économie de 30.000 FCFA, Facturation annuelle, Prix garanti pendant 1 an',
            'is_active' => true,
            'is_popular' => true, // Marquer comme populaire pour la réduction
        ]);

        $this->command->info('Nouveaux plans d\'abonnement créés avec succès !');
        $this->command->info('- Plan Mensuel: 30.000 FCFA/mois');
        $this->command->info('- Plan Annuel: 30.000 FCFA/an (économisez 30.000 FCFA)');
    }
}
