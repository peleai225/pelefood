<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Tenant;

class RestaurantTestSeeder extends Seeder
{
    public function run()
    {
        // Créer un tenant de test
        $tenant = Tenant::create([
            'name' => 'Restaurant Test',
            'company_name' => 'Restaurant Test SARL',
            'email' => 'contact@restaurant-test.ci',
            'phone' => '+225 27 22 49 50 00',
            'address' => '123 Boulevard de la Corniche',
            'city' => 'Abidjan',
            'country' => 'Côte d\'Ivoire',
            'timezone' => 'Africa/Abidjan',
            'currency' => 'XOF',
            'language' => 'fr',
            'domain' => 'restaurant-test',
            'subdomain' => 'restaurant-test',
            'is_active' => true,
        ]);

        // Créer un utilisateur admin
        $user = User::create([
            'name' => 'Admin Restaurant',
            'email' => 'admin@restaurant-test.ci',
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

        // Créer les catégories
        $categories = [
            [
                'name' => 'Entrées',
                'description' => 'Délicieuses entrées pour commencer votre repas',
                'slug' => 'entrees',
                'sort_order' => 1,
            ],
            [
                'name' => 'Plats principaux',
                'description' => 'Nos spécialités et plats signature',
                'slug' => 'plats-principaux',
                'sort_order' => 2,
            ],
            [
                'name' => 'Pizzas',
                'description' => 'Pizzas artisanales cuites au feu de bois',
                'slug' => 'pizzas',
                'sort_order' => 3,
            ],
            [
                'name' => 'Burgers',
                'description' => 'Burgers gourmets avec des ingrédients frais',
                'slug' => 'burgers',
                'sort_order' => 4,
            ],
            [
                'name' => 'Desserts',
                'description' => 'Desserts maison pour terminer en beauté',
                'slug' => 'desserts',
                'sort_order' => 5,
            ],
            [
                'name' => 'Boissons',
                'description' => 'Boissons fraîches et cocktails',
                'slug' => 'boissons',
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $catData) {
            Category::create([
                'restaurant_id' => $restaurant->id,
                'name' => $catData['name'],
                'description' => $catData['description'],
                'slug' => $catData['slug'],
                'sort_order' => $catData['sort_order'],
                'is_active' => true,
            ]);
        }

        // Récupérer les catégories créées
        $entrees = Category::where('slug', 'entrees')->first();
        $plats = Category::where('slug', 'plats-principaux')->first();
        $pizzas = Category::where('slug', 'pizzas')->first();
        $burgers = Category::where('slug', 'burgers')->first();
        $desserts = Category::where('slug', 'desserts')->first();
        $boissons = Category::where('slug', 'boissons')->first();

        // Créer les produits
        $products = [
            // Entrées
            [
                'category_id' => $entrees->id,
                'name' => 'Salade César',
                'description' => 'Laitue romaine, parmesan, croûtons, sauce césar maison',
                'price' => 3500,
                'is_popular' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $entrees->id,
                'name' => 'Bruschetta',
                'description' => 'Pain grillé, tomates, basilic, huile d\'olive',
                'price' => 2500,
                'is_popular' => false,
                'is_featured' => true,
            ],
            [
                'category_id' => $entrees->id,
                'name' => 'Soupe à l\'oignon',
                'description' => 'Soupe traditionnelle française gratinée',
                'price' => 3000,
                'is_popular' => false,
                'is_featured' => false,
            ],

            // Plats principaux
            [
                'category_id' => $plats->id,
                'name' => 'Poulet Braisé',
                'description' => 'Poulet braisé aux herbes avec accompagnement',
                'price' => 8500,
                'is_popular' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $plats->id,
                'name' => 'Poisson Braisé',
                'description' => 'Poisson frais braisé avec légumes',
                'price' => 9500,
                'is_popular' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $plats->id,
                'name' => 'Attieke Poisson',
                'description' => 'Attieke avec poisson grillé et sauce tomate',
                'price' => 7500,
                'is_popular' => false,
                'is_featured' => true,
            ],

            // Pizzas
            [
                'category_id' => $pizzas->id,
                'name' => 'Pizza Margherita',
                'description' => 'Sauce tomate, mozzarella, basilic frais',
                'price' => 6500,
                'is_popular' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $pizzas->id,
                'name' => 'Pizza Quatre Fromages',
                'description' => 'Mozzarella, gorgonzola, parmesan, chèvre',
                'price' => 7500,
                'is_popular' => false,
                'is_featured' => true,
            ],
            [
                'category_id' => $pizzas->id,
                'name' => 'Pizza Hawaïenne',
                'description' => 'Jambon, ananas, mozzarella',
                'price' => 7000,
                'is_popular' => false,
                'is_featured' => false,
            ],

            // Burgers
            [
                'category_id' => $burgers->id,
                'name' => 'Burger Classic',
                'description' => 'Steak haché, salade, tomate, oignon, fromage',
                'price' => 5500,
                'is_popular' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $burgers->id,
                'name' => 'Burger Deluxe',
                'description' => 'Double steak, bacon, cheddar, sauce spéciale',
                'price' => 7500,
                'is_popular' => false,
                'is_featured' => true,
            ],
            [
                'category_id' => $burgers->id,
                'name' => 'Burger Végétarien',
                'description' => 'Steak végétal, avocat, salade, sauce tahini',
                'price' => 6000,
                'is_popular' => false,
                'is_featured' => false,
            ],

            // Desserts
            [
                'category_id' => $desserts->id,
                'name' => 'Tiramisu',
                'description' => 'Dessert italien classique au café',
                'price' => 3500,
                'is_popular' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $desserts->id,
                'name' => 'Crème Brûlée',
                'description' => 'Crème vanille avec caramel croquant',
                'price' => 3000,
                'is_popular' => false,
                'is_featured' => true,
            ],
            [
                'category_id' => $desserts->id,
                'name' => 'Fondant au Chocolat',
                'description' => 'Gâteau au chocolat coulant avec glace vanille',
                'price' => 4000,
                'is_popular' => true,
                'is_featured' => false,
            ],

            // Boissons
            [
                'category_id' => $boissons->id,
                'name' => 'Coca-Cola',
                'description' => 'Soda 33cl',
                'price' => 800,
                'is_popular' => false,
                'is_featured' => false,
            ],
            [
                'category_id' => $boissons->id,
                'name' => 'Jus d\'Ananas',
                'description' => 'Jus d\'ananas frais pressé',
                'price' => 1200,
                'is_popular' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $boissons->id,
                'name' => 'Cocktail Pina Colada',
                'description' => 'Rhum, lait de coco, jus d\'ananas',
                'price' => 3500,
                'is_popular' => false,
                'is_featured' => true,
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