<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\User;

class RestaurantSeeder extends Seeder
{
    public function run()
    {
        // Créer un restaurant de test
        $restaurant = Restaurant::create([
            'name' => 'Restaurant PeleFood',
            'slug' => 'pelefood',
            'description' => 'Restaurant spécialisé dans la cuisine africaine traditionnelle, offrant des plats authentiques et savoureux.',
            'slogan' => 'La cuisine africaine authentique',
            'address' => '123 Avenue des Champs',
            'city' => 'Abidjan',
            'postal_code' => '225',
            'country' => 'Côte d\'Ivoire',
            'phone' => '+225 07 12 34 56 78',
            'email' => 'contact@pelefood.com',
            'website' => 'https://pelefood.com',
            'currency' => 'XOF',
            'timezone' => 'Africa/Abidjan',
            'language' => 'fr',
            'minimum_order' => 5000,
            'delivery_fee' => 500,
            'delivery_radius' => 15,
            'preparation_time' => 30,
            'is_active' => true,
            'user_id' => User::where('email', 'pelefood1@gmail.com')->first()->id ?? 1,
        ]);

        // Créer un autre restaurant pour tester
        Restaurant::create([
            'name' => 'Cuisine Africaine Express',
            'slug' => 'cuisine-africaine-express',
            'description' => 'Restaurant rapide spécialisé dans les plats africains traditionnels.',
            'slogan' => 'Rapidité et authenticité',
            'address' => '456 Boulevard Vridi',
            'city' => 'Abidjan',
            'postal_code' => '225',
            'country' => 'Côte d\'Ivoire',
            'phone' => '+225 08 98 76 54 32',
            'email' => 'contact@cuisine-express.com',
            'website' => 'https://cuisine-express.com',
            'currency' => 'XOF',
            'timezone' => 'Africa/Abidjan',
            'language' => 'fr',
            'minimum_order' => 3000,
            'delivery_fee' => 400,
            'delivery_radius' => 10,
            'preparation_time' => 20,
            'is_active' => true,
            'user_id' => User::where('email', 'pelefood1@gmail.com')->first()->id ?? 1,
        ]);

        $this->command->info('Restaurants créés avec succès !');
        $this->command->info('URLs disponibles :');
        $this->command->info('- http://127.0.0.1:8000/restaurant/pelefood');
        $this->command->info('- http://127.0.0.1:8000/restaurant/cuisine-africaine-express');
    }
} 