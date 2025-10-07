<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== NETTOYAGE DES RESTAURANTS ORPHELINS ===\n\n";

// 1. Lister tous les restaurants
echo "1. Restaurants existants:\n";
$restaurants = \App\Models\Restaurant::all();
foreach ($restaurants as $restaurant) {
    echo "   - ID: {$restaurant->id}, Nom: {$restaurant->name}, User ID: {$restaurant->user_id}\n";
}

// 2. Vérifier les restaurants orphelins
echo "\n2. Vérification des restaurants orphelins:\n";
$orphanedRestaurants = \App\Models\Restaurant::whereNotIn('user_id', \App\Models\User::pluck('id'))->get();
foreach ($orphanedRestaurants as $restaurant) {
    echo "   - Restaurant orphelin: ID {$restaurant->id}, Nom: {$restaurant->name}, User ID: {$restaurant->user_id}\n";
}

// 3. Supprimer les restaurants orphelins
if ($orphanedRestaurants->count() > 0) {
    echo "\n3. Suppression des restaurants orphelins:\n";
    $deletedCount = $orphanedRestaurants->count();
    foreach ($orphanedRestaurants as $restaurant) {
        echo "   - Suppression du restaurant: {$restaurant->name}\n";
        $restaurant->delete();
    }
    echo "   Supprimés: $deletedCount restaurants\n";
} else {
    echo "\n3. Aucun restaurant orphelin trouvé.\n";
}

// 4. Vérifier le résultat
echo "\n4. Restaurants restants:\n";
$remainingRestaurants = \App\Models\Restaurant::all();
foreach ($remainingRestaurants as $restaurant) {
    echo "   - ID: {$restaurant->id}, Nom: {$restaurant->name}, User ID: {$restaurant->user_id}\n";
}

echo "\n✅ Nettoyage des restaurants terminé!\n";
echo "\n=== NETTOYAGE TERMINÉ ===\n";
