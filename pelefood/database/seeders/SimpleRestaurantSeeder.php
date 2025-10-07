<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Tenant;

class SimpleRestaurantSeeder extends Seeder
{
    public function run()
    {
        // Créer un tenant simple
        $tenant = Tenant::create([
            'name' => 'Restaurant Demo',
            'company_name' => 'Restaurant Demo SARL',
            'email' => 'contact@restaurant-demo.ci',
            'phone' => '+225 27 22 49 50 00',
            'address' => '123 Boulevard de la Corniche',
            'city' => 'Abidjan',
            'country' => 'Côte d\'Ivoire',
            'timezone' => 'Africa/Abidjan',
            'currency' => 'XOF',
            'language' => 'fr',
            'domain' => 'restaurant-demo',
            'subdomain' => 'restaurant-demo',
            'is_active' => true,
        ]);

        // Créer un utilisateur admin
        $user = User::create([
            'name' => 'Admin Restaurant',
            'email' => 'admin@restaurant-demo.ci',
            'password' => bcrypt('password'),
            'tenant_id' => $tenant->id,
        ]);

        // Assigner le rôle admin
        $user->assignRole('admin');

        // Créer le restaurant
        $restaurant = Restaurant::create([
            'tenant_id' => $tenant->id,
            'name' => 'Le Gourmet d\'Abidjan',
            'slug' => 'le-gourmet-abidjan',
            'description' => 'Une expérience culinaire exceptionnelle au cœur d\'Abidjan. Découvrez nos spécialités locales et internationales préparées avec passion.',
            'email' => 'contact@legourmet.ci',
            'phone' => '+225 27 22 49 50 00',
            'address' => '123 Boulevard de la Corniche',
            'city' => 'Abidjan',
            'postal_code' => '225',
            'opening_time' => '11:00',
            'closing_time' => '23:00',
            'is_open' => true,
            'accepts_delivery' => true,
            'accepts_takeaway' => true,
            'is_active' => true,
            'theme_colors' => [
                'primary' => '#f97316',
                'secondary' => '#dc2626',
                'accent' => '#f59e0b'
            ],
            'settings' => [
                'notifications' => [
                    'email' => true,
                    'sms' => true,
                    'push' => true,
                ],
                'orders' => [
                    'auto_accept' => false,
                    'notify_new' => true,
                ],
                'reviews' => [
                    'moderate' => true,
                    'notify' => true,
                ],
                'currency' => 'XOF',
                'timezone' => 'Africa/Abidjan',
                'language' => 'fr',
                'date_format' => 'd/m/Y',
                'security' => [
                    'two_factor' => false,
                    'login_notifications' => true,
                ],
            ],
        ]);

        // Créer quelques catégories simples
        $categories = [
            ['name' => 'Entrées', 'description' => 'Délicieuses entrées', 'slug' => 'entrees'],
            ['name' => 'Plats principaux', 'description' => 'Nos spécialités', 'slug' => 'plats'],
            ['name' => 'Desserts', 'description' => 'Desserts maison', 'slug' => 'desserts'],
        ];

        foreach ($categories as $catData) {
            Category::create([
                'restaurant_id' => $restaurant->id,
                'name' => $catData['name'],
                'description' => $catData['description'],
                'slug' => $catData['slug'],
                'sort_order' => 1,
                'is_active' => true,
            ]);
        }

        // Récupérer les catégories
        $entrees = Category::where('slug', 'entrees')->first();
        $plats = Category::where('slug', 'plats')->first();
        $desserts = Category::where('slug', 'desserts')->first();

        // Créer quelques produits simples
        $products = [
            [
                'category_id' => $entrees->id,
                'name' => 'Salade César',
                'description' => 'Laitue romaine, parmesan, croûtons',
                'price' => 3500,
                'is_popular' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $plats->id,
                'name' => 'Poulet Braisé',
                'description' => 'Poulet braisé aux herbes',
                'price' => 8500,
                'is_popular' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $desserts->id,
                'name' => 'Tiramisu',
                'description' => 'Dessert italien classique',
                'price' => 3500,
                'is_popular' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($products as $prodData) {
            Product::create([
                'restaurant_id' => $restaurant->id,
                'category_id' => $prodData['category_id'],
                'name' => $prodData['name'],
                'description' => $prodData['description'],
                'price' => $prodData['price'],
                'is_available' => true,
                'is_popular' => $prodData['is_popular'],
                'is_featured' => $prodData['is_featured'],
                'has_stock_management' => false,
                'stock_quantity' => 100,
                'sort_order' => 0,
            ]);
        }

        $this->command->info('Restaurant de test créé avec succès !');
        $this->command->info('URL: http://127.0.0.1:8000/restaurant/le-gourmet-abidjan');
        $this->command->info('Email admin: admin@restaurant-test.ci');
        $this->command->info('Mot de passe: password');
    }
} 