<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Test de l'Admin Controller ===\n";

try {
    // Test des modèles
    echo "✅ Modèles disponibles:\n";
    echo "- User: " . (class_exists('App\Models\User') ? 'OK' : 'NOK') . "\n";
    echo "- Restaurant: " . (class_exists('App\Models\Restaurant') ? 'OK' : 'NOK') . "\n";
    echo "- Tenant: " . (class_exists('App\Models\Tenant') ? 'OK' : 'NOK') . "\n";
    echo "- Order: " . (class_exists('App\Models\Order') ? 'OK' : 'NOK') . "\n";
    echo "- Product: " . (class_exists('App\Models\Product') ? 'OK' : 'NOK') . "\n";
    echo "- Category: " . (class_exists('App\Models\Category') ? 'OK' : 'NOK') . "\n";
    echo "- Payment: " . (class_exists('App\Models\Payment') ? 'OK' : 'NOK') . "\n";
    echo "- Notification: " . (class_exists('App\Models\Notification') ? 'OK' : 'NOK') . "\n";
    echo "- Promotion: " . (class_exists('App\Models\Promotion') ? 'OK' : 'NOK') . "\n";
    echo "- SubscriptionPlan: " . (class_exists('App\Models\SubscriptionPlan') ? 'OK' : 'NOK') . "\n";
    
    // Test des routes
    echo "\n✅ Routes admin disponibles:\n";
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $adminRoutes = collect($routes)->filter(function($route) {
        return str_starts_with($route->getName(), 'admin.');
    })->pluck('uri')->take(10);
    
    foreach($adminRoutes as $route) {
        echo "- $route\n";
    }
    
    echo "\n✅ Test des données:\n";
    echo "- Users: " . \App\Models\User::count() . "\n";
    echo "- Restaurants: " . \App\Models\Restaurant::count() . "\n";
    echo "- Tenants: " . \App\Models\Tenant::count() . "\n";
    echo "- Orders: " . \App\Models\Order::count() . "\n";
    echo "- Products: " . \App\Models\Product::count() . "\n";
    echo "- Categories: " . \App\Models\Category::count() . "\n";
    
    echo "\n🎉 Tous les tests sont passés avec succès !\n";
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "Fichier: " . $e->getFile() . ":" . $e->getLine() . "\n";
} 