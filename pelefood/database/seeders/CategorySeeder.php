<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Restaurant;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Récupérer le restaurant PeleFood
        $restaurant = Restaurant::where('slug', 'pelefood')->first();
        
        if (!$restaurant) {
            $this->command->error('Restaurant PeleFood non trouvé. Exécutez d\'abord RestaurantSeeder.');
            return;
        }

        $categories = [
            [
                'name' => 'Entrées',
                'slug' => 'entrees',
                'description' => 'Délicieuses entrées africaines traditionnelles',
                'sort_order' => 1,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Plats Principaux',
                'slug' => 'plats-principaux',
                'description' => 'Plats traditionnels africains authentiques',
                'sort_order' => 2,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Accompagnements',
                'slug' => 'accompagnements',
                'description' => 'Riz, plantains, légumes et plus encore',
                'sort_order' => 3,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'Desserts',
                'slug' => 'desserts',
                'description' => 'Desserts sucrés et délicieux',
                'sort_order' => 4,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'Boissons',
                'slug' => 'boissons',
                'description' => 'Jus naturels, sodas et boissons traditionnelles',
                'sort_order' => 5,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'Spécialités',
                'slug' => 'specialites',
                'description' => 'Nos plats signature uniques',
                'sort_order' => 6,
                'is_active' => true,
                'is_featured' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create(array_merge($categoryData, [
                'restaurant_id' => $restaurant->id
            ]));
        }

        $this->command->info('Catégories créées avec succès pour le restaurant PeleFood !');
    }
}
