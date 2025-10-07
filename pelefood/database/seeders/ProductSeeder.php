<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Restaurant;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Récupérer le restaurant PeleFood
        $restaurant = Restaurant::where('slug', 'pelefood')->first();
        
        if (!$restaurant) {
            $this->command->error('Restaurant PeleFood non trouvé. Exécutez d\'abord RestaurantSeeder.');
            return;
        }

        $products = [
            // Entrées
            [
                'name' => 'Alloco',
                'slug' => 'alloco',
                'description' => 'Plantains mûrs frits à la perfection, servis avec une sauce piquante traditionnelle.',
                'price' => 1500,
                'category_slug' => 'entrees',
                'is_available' => true,
                'is_featured' => true,
                'is_popular' => true,
                'preparation_time' => 15,
                'sort_order' => 1,
            ],
            [
                'name' => 'Kedjenou de Poulet',
                'slug' => 'kedjenou-poulet',
                'description' => 'Poulet mijoté avec des légumes et des épices traditionnelles.',
                'price' => 2500,
                'category_slug' => 'entrees',
                'is_available' => true,
                'is_featured' => false,
                'is_popular' => true,
                'preparation_time' => 20,
                'sort_order' => 2,
            ],

            // Plats Principaux
            [
                'name' => 'Attieke Poisson',
                'slug' => 'attieke-poisson',
                'description' => 'Semoule de manioc avec poisson grillé, accompagné de légumes frais.',
                'price' => 3500,
                'category_slug' => 'plats-principaux',
                'is_available' => true,
                'is_featured' => true,
                'is_popular' => true,
                'preparation_time' => 25,
                'sort_order' => 3,
            ],
            [
                'name' => 'Mafé de Bœuf',
                'slug' => 'mafe-boeuf',
                'description' => 'Bœuf mijoté dans une sauce à base d\'arachide et d\'épices.',
                'price' => 4000,
                'category_slug' => 'plats-principaux',
                'is_available' => true,
                'is_featured' => true,
                'is_popular' => false,
                'preparation_time' => 30,
                'sort_order' => 4,
            ],
            [
                'name' => 'Thiéboudienne',
                'slug' => 'thieboudienne',
                'description' => 'Riz au poisson avec légumes, plat national du Sénégal.',
                'price' => 3800,
                'category_slug' => 'plats-principaux',
                'is_available' => true,
                'is_featured' => false,
                'is_popular' => true,
                'preparation_time' => 35,
                'sort_order' => 5,
            ],

            // Accompagnements
            [
                'name' => 'Riz Basmati',
                'slug' => 'riz-basmati',
                'description' => 'Riz basmati parfumé cuit à la perfection.',
                'price' => 800,
                'category_slug' => 'accompagnements',
                'is_available' => true,
                'is_featured' => false,
                'is_popular' => true,
                'preparation_time' => 20,
                'sort_order' => 6,
            ],
            [
                'name' => 'Plantains Verts',
                'slug' => 'plantains-verts',
                'description' => 'Plantains verts frits, parfaits pour accompagner vos plats.',
                'price' => 600,
                'category_slug' => 'accompagnements',
                'is_available' => true,
                'is_featured' => false,
                'is_popular' => false,
                'preparation_time' => 15,
                'sort_order' => 7,
            ],

            // Desserts
            [
                'name' => 'Bissap',
                'slug' => 'bissap',
                'description' => 'Sorbet à base de fleurs d\'hibiscus, rafraîchissant et naturel.',
                'price' => 1200,
                'category_slug' => 'desserts',
                'is_available' => true,
                'is_featured' => true,
                'is_popular' => true,
                'preparation_time' => 10,
                'sort_order' => 8,
            ],
            [
                'name' => 'Beignets de Banane',
                'slug' => 'beignets-banane',
                'description' => 'Beignets moelleux aux bananes mûres, saupoudrés de sucre glace.',
                'price' => 1000,
                'category_slug' => 'desserts',
                'is_available' => true,
                'is_featured' => false,
                'is_popular' => false,
                'preparation_time' => 12,
                'sort_order' => 9,
            ],

            // Boissons
            [
                'name' => 'Jus de Bissap',
                'slug' => 'jus-bissap',
                'description' => 'Jus naturel d\'hibiscus, sans conservateurs, très rafraîchissant.',
                'price' => 800,
                'category_slug' => 'boissons',
                'is_available' => true,
                'is_featured' => false,
                'is_popular' => true,
                'preparation_time' => 5,
                'sort_order' => 10,
            ],
            [
                'name' => 'Coca-Cola',
                'slug' => 'coca-cola',
                'description' => 'Soda classique, disponible en format 33cl.',
                'price' => 500,
                'category_slug' => 'boissons',
                'is_available' => true,
                'is_featured' => false,
                'is_popular' => true,
                'preparation_time' => 1,
                'sort_order' => 11,
            ],

            // Spécialités
            [
                'name' => 'Yassa Poulet',
                'slug' => 'yassa-poulet',
                'description' => 'Poulet mariné dans une sauce à base d\'oignons et de citron, spécialité casamançaise.',
                'price' => 4500,
                'category_slug' => 'specialites',
                'is_available' => true,
                'is_featured' => true,
                'is_popular' => true,
                'preparation_time' => 40,
                'sort_order' => 12,
            ],
            [
                'name' => 'Mouton Braisé',
                'slug' => 'mouton-braise',
                'description' => 'Mouton braisé aux épices traditionnelles, servi avec des légumes grillés.',
                'price' => 5500,
                'category_slug' => 'specialites',
                'is_available' => true,
                'is_featured' => true,
                'is_popular' => false,
                'preparation_time' => 45,
                'sort_order' => 13,
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('slug', $productData['category_slug'])->first();
            
            if ($category) {
                unset($productData['category_slug']);
                Product::create(array_merge($productData, [
                    'restaurant_id' => $restaurant->id,
                    'category_id' => $category->id
                ]));
            }
        }

        $this->command->info('Produits créés avec succès pour le restaurant PeleFood !');
    }
}
