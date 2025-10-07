<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Restaurant;
use App\Models\SubscriptionPlan;
use App\Models\PaymentGateway;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SuperAdminTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🌱 Création des données de test pour le SuperAdmin...');

        // Créer les plans d'abonnement
        $this->createSubscriptionPlans();

        // Créer les passerelles de paiement
        $this->createPaymentGateways();

        // Créer les locataires
        $this->createTenants();

        // Créer les utilisateurs
        $this->createUsers();

        // Créer les restaurants
        $this->createRestaurants();

        // Créer les catégories et produits
        $this->createCategoriesAndProducts();

        // Créer les commandes
        $this->createOrders();

        // Créer les transactions de paiement
        $this->createPaymentTransactions();

        $this->command->info('✅ Données de test créées avec succès !');
    }

    private function createSubscriptionPlans(): void
    {
        $this->command->info('📋 Vérification des plans d\'abonnement...');

        // Vérifier si les plans existent déjà
        if (SubscriptionPlan::count() > 0) {
            $this->command->info('✅ Les plans d\'abonnement existent déjà');
            return;
        }

        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Parfait pour les petits restaurants qui débutent',
                'price' => 29.99,
                'billing_cycle' => 'monthly',
                'duration_days' => 30,
                'currency' => 'XOF',
                'trial_days' => 7,
                'is_active' => true,
                'is_popular' => false,
                'max_restaurants' => 1,
                'max_orders_per_month' => 100,
                'max_products' => 50,
                'max_categories' => 10,
                'allows_customization' => false,
                'allows_analytics' => false,
                'allows_api' => false,
                'allows_export' => false,
                'allows_integrations' => false,
                'support_level' => 'email',
                'has_analytics' => false,
                'has_chatbot' => false,
                'has_custom_domain' => false,
                'has_priority_support' => false,
                'features' => json_encode(['Gestion des commandes', 'Menu basique', 'Support email']),
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Solution complète pour les restaurants en croissance',
                'price' => 79.99,
                'billing_cycle' => 'monthly',
                'duration_days' => 30,
                'currency' => 'XOF',
                'trial_days' => 14,
                'is_active' => true,
                'is_popular' => true,
                'max_restaurants' => 3,
                'max_orders_per_month' => 500,
                'max_products' => 200,
                'max_categories' => 25,
                'allows_customization' => true,
                'allows_analytics' => true,
                'allows_api' => false,
                'allows_export' => true,
                'allows_integrations' => true,
                'support_level' => 'chat',
                'has_analytics' => true,
                'has_chatbot' => true,
                'has_custom_domain' => false,
                'has_priority_support' => false,
                'features' => json_encode(['Analytics avancés', 'Chatbot IA', 'Intégrations', 'Support chat']),
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Plateforme avancée pour les chaînes de restaurants',
                'price' => 199.99,
                'billing_cycle' => 'monthly',
                'duration_days' => 30,
                'currency' => 'XOF',
                'trial_days' => 30,
                'is_active' => true,
                'is_popular' => false,
                'max_restaurants' => 10,
                'max_orders_per_month' => 2000,
                'max_products' => 1000,
                'max_categories' => 50,
                'allows_customization' => true,
                'allows_analytics' => true,
                'allows_api' => true,
                'allows_export' => true,
                'allows_integrations' => true,
                'support_level' => 'phone',
                'has_analytics' => true,
                'has_chatbot' => true,
                'has_custom_domain' => true,
                'has_priority_support' => true,
                'features' => json_encode(['API complète', 'Domaine personnalisé', 'Support prioritaire', 'Toutes les fonctionnalités']),
            ],
            [
                'name' => 'Professional Annuel',
                'slug' => 'professional-annuel',
                'description' => 'Plan Professional avec 20% de réduction',
                'price' => 767.90,
                'billing_cycle' => 'yearly',
                'duration_days' => 365,
                'currency' => 'XOF',
                'trial_days' => 14,
                'is_active' => true,
                'is_popular' => false,
                'max_restaurants' => 3,
                'max_orders_per_month' => 500,
                'max_products' => 200,
                'max_categories' => 25,
                'allows_customization' => true,
                'allows_analytics' => true,
                'allows_api' => false,
                'allows_export' => true,
                'allows_integrations' => true,
                'support_level' => 'chat',
                'has_analytics' => true,
                'has_chatbot' => true,
                'has_custom_domain' => false,
                'has_priority_support' => false,
                'features' => json_encode(['Analytics avancés', 'Chatbot IA', 'Intégrations', 'Support chat', 'Économie annuelle']),
            ],
        ];

        foreach ($plans as $planData) {
            SubscriptionPlan::create($planData);
        }

        $this->command->info('✅ ' . count($plans) . ' plans d\'abonnement créés');
    }

    private function createPaymentGateways(): void
    {
        $this->command->info('💳 Vérification des passerelles de paiement...');

        // Vérifier si les passerelles existent déjà
        if (PaymentGateway::count() > 0) {
            $this->command->info('✅ Les passerelles de paiement existent déjà');
            return;
        }

        $gateways = [
            [
                'name' => 'Stripe',
                'provider' => 'stripe',
                'description' => 'Solution de paiement en ligne leader mondiale',
                'is_active' => true,
                'test_mode' => true,
                'credentials' => json_encode([
                    'api_key' => 'pk_test_...',
                    'secret_key' => 'sk_test_...',
                ]),
                'settings' => json_encode([
                    'transaction_fee_percentage' => 0.029,
                    'transaction_fee_fixed' => 0.30,
                    'supported_currencies' => ['EUR', 'USD', 'GBP'],
                    'supported_countries' => ['FR', 'US', 'GB', 'DE', 'IT', 'ES'],
                ]),
                'webhook_url' => 'https://pelefood.com/webhooks/stripe',
                'webhook_secret' => 'whsec_test_secret...',
            ],
            [
                'name' => 'PayPal',
                'provider' => 'paypal',
                'description' => 'Paiement sécurisé et reconnu mondialement',
                'is_active' => true,
                'test_mode' => true,
                'credentials' => json_encode([
                    'client_id' => 'test_client_id...',
                    'client_secret' => 'test_client_secret...',
                ]),
                'settings' => json_encode([
                    'transaction_fee_percentage' => 0.0349,
                    'transaction_fee_fixed' => 0.35,
                    'supported_currencies' => ['EUR', 'USD', 'GBP'],
                    'supported_countries' => ['FR', 'US', 'GB', 'DE', 'IT', 'ES'],
                ]),
                'webhook_url' => 'https://pelefood.com/webhooks/paypal',
                'webhook_secret' => 'whsec_paypal_test...',
            ],
            [
                'name' => 'Mollie',
                'provider' => 'mollie',
                'description' => 'Solution de paiement européenne avec support multilingue',
                'is_active' => true,
                'test_mode' => true,
                'credentials' => json_encode([
                    'api_key' => 'test_api_key...',
                ]),
                'settings' => json_encode([
                    'transaction_fee_percentage' => 0.025,
                    'transaction_fee_fixed' => 0.25,
                    'supported_currencies' => ['EUR'],
                    'supported_countries' => ['FR', 'DE', 'IT', 'ES', 'NL', 'BE'],
                ]),
                'webhook_url' => 'https://pelefood.com/webhooks/mollie',
                'webhook_secret' => 'whsec_mollie_test...',
            ],
        ];

        foreach ($gateways as $gatewayData) {
            PaymentGateway::create($gatewayData);
        }

        $this->command->info('✅ ' . count($gateways) . ' passerelles de paiement créées');
    }

    private function createTenants(): void
    {
        $this->command->info('🏢 Vérification des locataires...');

        // Vérifier si les locataires existent déjà
        if (Tenant::count() > 0) {
            $this->command->info('✅ Les locataires existent déjà');
            return;
        }

        $plans = SubscriptionPlan::all();
        
        $tenants = [
            [
                'name' => 'RestoGroup',
                'domain' => 'restogroup.pelefood.com',
                'subdomain' => 'restogroup',
                'company_name' => 'RestoGroup SARL',
                'email' => 'contact@restogroup.com',
                'phone' => '+33 1 23 45 67 89',
                'address' => '123 Avenue des Champs-Élysées, 75008 Paris',
                'city' => 'Paris',
                'country' => 'France',
                'timezone' => 'Europe/Paris',
                'currency' => 'XOF',
                'language' => 'fr',
                'is_active' => true,
                'is_verified' => true,
                'trial_ends_at' => Carbon::now()->addDays(7),
                'subscription_ends_at' => Carbon::now()->addMonths(6),
                'settings' => json_encode([
                    'subscription_plan_id' => $plans->where('name', 'Professional')->first()->id,
                    'tax_id' => 'FR12345678901',
                ]),
            ],
            [
                'name' => 'FoodChain',
                'domain' => 'foodchain.pelefood.com',
                'subdomain' => 'foodchain',
                'company_name' => 'FoodChain International',
                'email' => 'info@foodchain.com',
                'phone' => '+33 4 56 78 90 12',
                'address' => '456 Rue de la Paix, 69001 Lyon',
                'city' => 'Lyon',
                'country' => 'France',
                'timezone' => 'Europe/Paris',
                'currency' => 'XOF',
                'language' => 'fr',
                'is_active' => true,
                'is_verified' => true,
                'trial_ends_at' => Carbon::now()->addDays(14),
                'subscription_ends_at' => Carbon::now()->addMonths(9),
                'settings' => json_encode([
                    'subscription_plan_id' => $plans->where('name', 'Enterprise')->first()->id,
                    'tax_id' => 'FR98765432109',
                ]),
            ],
            [
                'name' => 'BistroLocal',
                'domain' => 'bistrolocal.pelefood.com',
                'subdomain' => 'bistrolocal',
                'company_name' => 'BistroLocal',
                'email' => 'hello@bistrolocal.com',
                'phone' => '+33 5 67 89 01 23',
                'address' => '789 Place du Marché, 33000 Bordeaux',
                'city' => 'Bordeaux',
                'country' => 'France',
                'timezone' => 'Europe/Paris',
                'currency' => 'XOF',
                'language' => 'fr',
                'is_active' => true,
                'is_verified' => true,
                'trial_ends_at' => Carbon::now()->addDays(7),
                'subscription_ends_at' => Carbon::now()->addMonths(11),
                'settings' => json_encode([
                    'subscription_plan_id' => $plans->where('name', 'Starter')->first()->id,
                    'tax_id' => 'FR45678901234',
                ]),
            ],
            [
                'name' => 'PizzaExpress',
                'domain' => 'pizzaexpress.pelefood.com',
                'subdomain' => 'pizzaexpress',
                'company_name' => 'PizzaExpress Franchise',
                'email' => 'franchise@pizzaexpress.com',
                'phone' => '+33 6 78 90 12 34',
                'address' => '321 Boulevard Saint-Germain, 13001 Marseille',
                'city' => 'Marseille',
                'country' => 'France',
                'timezone' => 'Europe/Paris',
                'currency' => 'XOF',
                'language' => 'fr',
                'is_active' => false,
                'is_verified' => true,
                'trial_ends_at' => null,
                'subscription_ends_at' => Carbon::now()->subDays(15),
                'settings' => json_encode([
                    'subscription_plan_id' => $plans->where('name', 'Professional')->first()->id,
                    'tax_id' => 'FR78901234567',
                ]),
            ],
        ];

        foreach ($tenants as $tenantData) {
            Tenant::create($tenantData);
        }

        $this->command->info('✅ ' . count($tenants) . ' locataires créés');
    }

    private function createUsers(): void
    {
        $this->command->info('👥 Vérification des utilisateurs...');

        // Vérifier si les utilisateurs existent déjà
        if (User::count() > 0) {
            $this->command->info('✅ Les utilisateurs existent déjà');
            return;
        }

        $tenants = Tenant::all();
        
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@pelefood.com',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now(),
                'role' => 'super_admin',
                'tenant_id' => null,
            ],
            [
                'name' => 'Jean Dupont',
                'email' => 'jean.dupont@restogroup.com',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now(),
                'role' => 'admin',
                'tenant_id' => $tenants->where('name', 'RestoGroup')->first()->id,
            ],
            [
                'name' => 'Marie Martin',
                'email' => 'marie.martin@foodchain.com',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now(),
                'role' => 'admin',
                'tenant_id' => $tenants->where('name', 'FoodChain')->first()->id,
            ],
            [
                'name' => 'Pierre Durand',
                'email' => 'pierre.durand@bistrolocal.com',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now(),
                'role' => 'manager',
                'tenant_id' => $tenants->where('name', 'BistroLocal')->first()->id,
            ],
            [
                'name' => 'Sophie Bernard',
                'email' => 'sophie.bernard@restogroup.com',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now(),
                'role' => 'staff',
                'tenant_id' => $tenants->where('name', 'RestoGroup')->first()->id,
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        $this->command->info('✅ ' . count($users) . ' utilisateurs créés');
    }

    private function createRestaurants(): void
    {
        $this->command->info('🍽️ Vérification des restaurants...');

        // Vérifier si les restaurants existent déjà
        if (Restaurant::count() > 0) {
            $this->command->info('✅ Les restaurants existent déjà');
            return;
        }

        $tenants = Tenant::all();
        
        $restaurants = [
            [
                'name' => 'Le Gourmet Parisien',
                'description' => 'Restaurant gastronomique au cœur de Paris',
                'address' => '123 Avenue des Champs-Élysées, 75008 Paris',
                'phone' => '+33 1 23 45 67 89',
                'email' => 'contact@legourmetparisien.com',
                'cuisine_type' => 'Française',
                'price_range' => '€€€',
                'is_active' => true,
                'tenant_id' => $tenants->where('name', 'RestoGroup')->first()->id,
            ],
            [
                'name' => 'Pizza Bella',
                'description' => 'Pizzeria traditionnelle italienne',
                'address' => '456 Rue de la Paix, 69001 Lyon',
                'phone' => '+33 4 56 78 90 12',
                'email' => 'info@pizzabella.com',
                'cuisine_type' => 'Italienne',
                'price_range' => '€€',
                'is_active' => true,
                'tenant_id' => $tenants->where('name', 'FoodChain')->first()->id,
            ],
            [
                'name' => 'Bistro du Marché',
                'description' => 'Bistrot traditionnel avec produits locaux',
                'address' => '789 Place du Marché, 33000 Bordeaux',
                'phone' => '+33 5 67 89 01 23',
                'email' => 'hello@bistrodumarche.com',
                'cuisine_type' => 'Française',
                'price_range' => '€€',
                'is_active' => true,
                'tenant_id' => $tenants->where('name', 'BistroLocal')->first()->id,
            ],
            [
                'name' => 'Sushi Express',
                'description' => 'Restaurant japonais rapide et authentique',
                'address' => '321 Boulevard Saint-Germain, 13001 Marseille',
                'phone' => '+33 6 78 90 12 34',
                'email' => 'franchise@sushiexpress.com',
                'cuisine_type' => 'Japonaise',
                'price_range' => '€€',
                'is_active' => false,
                'tenant_id' => $tenants->where('name', 'PizzaExpress')->first()->id,
            ],
        ];

        foreach ($restaurants as $restaurantData) {
            Restaurant::create($restaurantData);
        }

        $this->command->info('✅ ' . count($restaurants) . ' restaurants créés');
    }

    private function createCategoriesAndProducts(): void
    {
        $this->command->info('📂 Vérification des catégories et produits...');

        // Vérifier si les catégories et produits existent déjà
        if (Category::count() > 0 || Product::count() > 0) {
            $this->command->info('✅ Les catégories et produits existent déjà');
            return;
        }

        $restaurants = Restaurant::all();
        
        // Créer des catégories pour le restaurant existant
        $restaurant = Restaurant::first();
        
        if ($restaurant) {
            $categories = [
                'Entrées',
                'Plats principaux',
                'Desserts',
                'Boissons',
                'Apéritifs',
            ];

            foreach ($categories as $categoryName) {
                Category::create([
                    'restaurant_id' => $restaurant->id,
                    'name' => $categoryName,
                    'slug' => strtolower(str_replace(' ', '-', $categoryName)),
                    'description' => 'Catégorie ' . $categoryName,
                    'sort_order' => 0,
                    'is_active' => true,
                    'is_featured' => false,
                ]);
            }
        }

        // Créer des produits pour le restaurant existant
        $restaurant = Restaurant::first();
        
        if ($restaurant) {
            $products = [
                [
                    'name' => 'Salade César',
                    'description' => 'Laitue romaine, parmesan, croûtons, sauce césar',
                    'price' => 12.50,
                    'category_id' => Category::where('name', 'Entrées')->where('restaurant_id', $restaurant->id)->first()->id,
                    'restaurant_id' => $restaurant->id,
                    'is_available' => true,
                ],
                [
                    'name' => 'Steak Frites',
                    'description' => 'Steak de bœuf, frites maison, salade verte',
                    'price' => 24.90,
                    'category_id' => Category::where('name', 'Plats principaux')->where('restaurant_id', $restaurant->id)->first()->id,
                    'restaurant_id' => $restaurant->id,
                    'is_available' => true,
                ],
                [
                    'name' => 'Pizza Margherita',
                    'description' => 'Sauce tomate, mozzarella, basilic frais',
                    'price' => 16.90,
                    'category_id' => Category::where('name', 'Entrées')->where('restaurant_id', $restaurant->id)->first()->id,
                    'restaurant_id' => $restaurant->id,
                    'is_available' => true,
                ],
                [
                    'name' => 'Tiramisu',
                    'description' => 'Dessert italien traditionnel',
                    'price' => 8.90,
                    'category_id' => Category::where('name', 'Desserts')->where('restaurant_id', $restaurant->id)->first()->id,
                    'restaurant_id' => $restaurant->id,
                    'is_available' => true,
                ],
            ];
        }

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('✅ ' . count($categories) . ' catégories et ' . count($products) . ' produits créés');
    }

    private function createOrders(): void
    {
        $this->command->info('📦 Vérification des commandes...');

        // Vérifier si les commandes existent déjà
        if (Order::count() > 0) {
            $this->command->info('✅ Les commandes existent déjà');
            return;
        }

        $restaurants = Restaurant::all();
        $users = User::where('role', '!=', 'super_admin')->get();
        
        $restaurant = Restaurant::first();
        
        if ($restaurant && $users->count() > 0) {
            $orders = [
                [
                    'order_number' => 'ORD-001',
                    'restaurant_id' => $restaurant->id,
                    'user_id' => $users->first()->id,
                    'status' => 'delivered',
                    'type' => 'delivery',
                    'subtotal' => 42.00,
                    'delivery_fee' => 3.30,
                    'tax_amount' => 0.00,
                    'discount_amount' => 0.00,
                    'total_amount' => 45.30,
                    'currency' => 'XOF',
                    'customer_name' => 'Jean Dupont',
                    'customer_phone' => '+33 1 23 45 67 89',
                    'customer_email' => 'jean.dupont@restogroup.com',
                    'delivery_address' => json_encode(['address' => '123 Avenue des Champs-Élysées, 75008 Paris']),
                    'special_instructions' => 'Livraison à l\'entrée principale',
                    'payment_method' => 'card',
                    'payment_status' => 'paid',
                    'created_at' => Carbon::now()->subDays(2),
                ],
                [
                    'order_number' => 'ORD-002',
                    'restaurant_id' => $restaurant->id,
                    'user_id' => $users->count() > 1 ? $users[1]->id : $users->first()->id,
                    'status' => 'preparing',
                    'type' => 'delivery',
                    'subtotal' => 30.00,
                    'delivery_fee' => 2.80,
                    'tax_amount' => 0.00,
                    'discount_amount' => 0.00,
                    'total_amount' => 32.80,
                    'currency' => 'XOF',
                    'customer_name' => 'Marie Martin',
                    'customer_phone' => '+33 4 56 78 90 12',
                    'customer_email' => 'marie.martin@foodchain.com',
                    'delivery_address' => json_encode(['address' => '456 Rue de la Paix, 69001 Lyon']),
                    'special_instructions' => 'Sans oignons sur la pizza',
                    'payment_method' => 'card',
                    'payment_status' => 'paid',
                    'created_at' => Carbon::now()->subHours(1),
                ],
                [
                    'order_number' => 'ORD-003',
                    'restaurant_id' => $restaurant->id,
                    'user_id' => $users->count() > 2 ? $users[2]->id : $users->first()->id,
                    'status' => 'pending',
                    'type' => 'delivery',
                    'subtotal' => 18.00,
                    'delivery_fee' => 0.90,
                    'tax_amount' => 0.00,
                    'discount_amount' => 0.00,
                    'total_amount' => 18.90,
                    'currency' => 'XOF',
                    'customer_name' => 'Pierre Durand',
                    'customer_phone' => '+33 5 67 89 01 23',
                    'customer_email' => 'pierre.durand@bistrolocal.com',
                    'delivery_address' => json_encode(['address' => '789 Place du Marché, 33000 Bordeaux']),
                    'special_instructions' => 'Livraison rapide si possible',
                    'payment_method' => 'cash',
                    'payment_status' => 'pending',
                    'created_at' => Carbon::now()->subMinutes(30),
                ],
            ];
        }

        foreach ($orders as $orderData) {
            Order::create($orderData);
        }

        $this->command->info('✅ ' . count($orders) . ' commandes créées');
    }

    private function createPaymentTransactions(): void
    {
        $this->command->info('💰 Vérification des transactions de paiement...');

        // Vérifier si les transactions existent déjà
        if (PaymentTransaction::count() > 0) {
            $this->command->info('✅ Les transactions de paiement existent déjà');
            return;
        }

        $orders = Order::all();
        $gateways = PaymentGateway::all();
        
        $orders = Order::all();
        $gateways = PaymentGateway::all();
        
        if ($orders->count() > 0 && $gateways->count() > 0) {
            $transactions = [
                [
                    'order_id' => $orders->where('order_number', 'ORD-001')->first()->id,
                    'payment_gateway_id' => $gateways->where('name', 'Stripe')->first()->id,
                    'amount' => 45.30,
                    'currency' => 'XOF',
                    'status' => 'completed',
                    'transaction_id' => 'txn_stripe_001',
                    'payment_method' => 'card',
                    'created_at' => Carbon::now()->subDays(2),
                ],
                [
                    'order_id' => $orders->where('order_number', 'ORD-002')->first()->id,
                    'payment_gateway_id' => $gateways->where('name', 'PayPal')->first()->id,
                    'amount' => 32.80,
                    'currency' => 'XOF',
                    'status' => 'pending',
                    'transaction_id' => 'txn_paypal_001',
                    'payment_method' => 'paypal',
                    'created_at' => Carbon::now()->subHours(1),
                ],
                [
                    'order_id' => $orders->where('order_number', 'ORD-003')->first()->id,
                    'payment_gateway_id' => $gateways->where('name', 'Stripe')->first()->id,
                    'amount' => 18.90,
                    'currency' => 'XOF',
                    'status' => 'processing',
                    'transaction_id' => 'txn_stripe_002',
                    'payment_method' => 'card',
                    'created_at' => Carbon::now()->subMinutes(30),
                ],
            ];
        }

        foreach ($transactions as $transactionData) {
            PaymentTransaction::create($transactionData);
        }

        $this->command->info('✅ ' . count($transactions) . ' transactions de paiement créées');
    }
}
