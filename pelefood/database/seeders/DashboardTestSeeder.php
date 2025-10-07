<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;

class DashboardTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un plan d'abonnement ou utiliser l'existant
        $plan = SubscriptionPlan::firstOrCreate(
            ['slug' => 'plan-premium'],
            [
                'name' => 'Plan Premium',
                'description' => 'Plan premium avec toutes les fonctionnalités',
                'price' => 15000,
                'currency' => 'XOF',
                'billing_cycle' => 'monthly',
                'trial_days' => 7,
                'is_active' => true,
                'is_popular' => true,
                'features' => ['Analytics', 'Chatbot', 'Custom Domain', 'Priority Support'],
                'max_orders_per_month' => 10000,
                'max_products' => 500,
                'has_analytics' => true,
                'has_chatbot' => true,
                'has_custom_domain' => true,
                'has_priority_support' => true,
            ]
        );

        // Mettre à jour le restaurant existant
        $restaurant = Restaurant::first();
        if ($restaurant) {
            $restaurant->update([
                'subscription_plan_id' => $plan->id,
                'subscription_status' => 'active',
                'subscription_expires_at' => Carbon::now()->addDays(30),
                'is_active' => true,
            ]);
        }

        // Créer des catégories
        $categories = [
            ['name' => 'Plats principaux', 'description' => 'Plats principaux du restaurant'],
            ['name' => 'Entrées', 'description' => 'Entrées et apéritifs'],
            ['name' => 'Desserts', 'description' => 'Desserts et pâtisseries'],
            ['name' => 'Boissons', 'description' => 'Boissons et rafraîchissements'],
        ];

        foreach ($categories as $catData) {
            Category::firstOrCreate(
                [
                    'restaurant_id' => $restaurant->id,
                    'slug' => \Illuminate\Support\Str::slug($catData['name'])
                ],
                [
                    'name' => $catData['name'],
                    'description' => $catData['description'],
                ]
            );
        }

        // Créer des produits
        $products = [
            ['name' => 'Poulet Braisé', 'description' => 'Poulet braisé traditionnel', 'price' => 2500, 'category_id' => 1],
            ['name' => 'Poisson Braisé', 'description' => 'Poisson frais braisé', 'price' => 3000, 'category_id' => 1],
            ['name' => 'Salade César', 'description' => 'Salade fraîche et croquante', 'price' => 1500, 'category_id' => 2],
            ['name' => 'Tiramisu', 'description' => 'Dessert italien classique', 'price' => 1200, 'category_id' => 3],
            ['name' => 'Jus d\'Orange', 'description' => 'Jus d\'orange frais', 'price' => 800, 'category_id' => 4],
        ];

        foreach ($products as $prodData) {
            Product::firstOrCreate(
                [
                    'restaurant_id' => $restaurant->id,
                    'slug' => \Illuminate\Support\Str::slug($prodData['name'])
                ],
                [
                    'name' => $prodData['name'],
                    'description' => $prodData['description'],
                    'price' => $prodData['price'],
                    'category_id' => $prodData['category_id'],
                    'is_available' => true,
                ]
            );
        }

        // Créer des commandes de test
        $users = User::take(3)->get();
        
        for ($i = 1; $i <= 10; $i++) {
            $orderNumber = 'TEST-' . str_pad($i, 6, '0', STR_PAD_LEFT);
            
            $order = Order::firstOrCreate(
                ['order_number' => $orderNumber],
                [
                    'restaurant_id' => $restaurant->id,
                    'user_id' => $users->random()->id,
                    'status' => ['pending', 'confirmed', 'preparing', 'delivered', 'cancelled'][array_rand(['pending', 'confirmed', 'preparing', 'delivered', 'cancelled'])],
                    'type' => ['delivery', 'takeaway', 'on_site'][array_rand(['delivery', 'takeaway', 'on_site'])],
                    'subtotal' => 0,
                    'delivery_fee' => 500,
                    'tax_amount' => 0,
                    'discount_amount' => 0,
                    'total_amount' => 0,
                    'currency' => 'FCFA',
                    'customer_name' => 'Client Test ' . $i,
                    'customer_phone' => '+22501234567',
                    'customer_email' => 'client' . $i . '@test.com',
                    'delivery_address' => ['address' => 'Adresse Test ' . $i, 'city' => 'Abidjan'],
                    'payment_method' => 'cash',
                    'payment_status' => 'paid',
                    'created_at' => Carbon::now()->subDays(rand(0, 30)),
                ]
            );

            // Ajouter des items à la commande
            $product = Product::inRandomOrder()->first();
            $quantity = rand(1, 3);
            $unitPrice = $product->price;
            $totalPrice = $unitPrice * $quantity;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'unit_price' => $unitPrice,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
            ]);

            // Mettre à jour le total de la commande
            $order->update([
                'subtotal' => $totalPrice,
                'total_amount' => $totalPrice + $order->delivery_fee,
            ]);
        }

        // Les statistiques du restaurant sont calculées dynamiquement
        $this->command->info('📊 Restaurant ID: ' . $restaurant->id);

        $this->command->info('✅ Données de test du dashboard créées avec succès !');
        $this->command->info('📊 ' . Order::count() . ' commandes créées');
        $this->command->info('🍽️ ' . Product::count() . ' produits créés');
        $this->command->info('📁 ' . Category::count() . ' catégories créées');
    }
} 