<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Promotion;
use App\Models\Restaurant;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurants = Restaurant::all();

        foreach ($restaurants as $restaurant) {
            // Promotion 1: Réduction de 20% sur tous les plats
            Promotion::create([
                'restaurant_id' => $restaurant->id,
                'title' => 'Offre spéciale -20%',
                'description' => 'Profitez d\'une réduction de 20% sur tous nos plats !',
                'discount_type' => 'percentage',
                'discount_value' => 20,
                'minimum_order_amount' => 5000,
                'max_uses' => 100,
                'code' => 'PROMO20',
                'start_date' => now(),
                'end_date' => now()->addDays(30),
                'is_active' => true,
                'is_featured' => true,
            ]);

            // Promotion 2: Livraison gratuite
            Promotion::create([
                'restaurant_id' => $restaurant->id,
                'title' => 'Livraison gratuite',
                'description' => 'Livraison gratuite pour toute commande supérieure à 10 000 FCFA',
                'discount_type' => 'fixed',
                'discount_value' => 1000,
                'minimum_order_amount' => 10000,
                'max_uses' => 50,
                'code' => 'LIVRAISON',
                'start_date' => now(),
                'end_date' => now()->addDays(15),
                'is_active' => true,
                'is_featured' => false,
            ]);

            // Promotion 3: Menu du midi
            Promotion::create([
                'restaurant_id' => $restaurant->id,
                'title' => 'Menu du midi à -15%',
                'description' => 'Réduction de 15% sur tous nos menus du midi',
                'discount_type' => 'percentage',
                'discount_value' => 15,
                'minimum_order_amount' => 3000,
                'max_uses' => 200,
                'code' => 'MIDI15',
                'start_date' => now(),
                'end_date' => now()->addDays(60),
                'is_active' => true,
                'is_featured' => false,
            ]);
        }

        $this->command->info('Promotions créées avec succès !');
    }
}
