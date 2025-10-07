<?php
// Test de l'état d'authentification
require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

// Démarrer Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔐 Test de l'état d'authentification\n";
echo "===================================\n\n";

// 1. Vérifier les utilisateurs avec restaurant
$usersWithRestaurant = User::whereHas('restaurant')->get();
echo "👥 Utilisateurs avec restaurant: " . $usersWithRestaurant->count() . "\n";

foreach ($usersWithRestaurant as $user) {
    echo "   - " . $user->name . " (ID: " . $user->id . ", Email: " . $user->email . ")\n";
    echo "     Restaurant: " . ($user->restaurant ? $user->restaurant->name : 'Aucun') . "\n";
    echo "     Rôle: " . $user->role . "\n";
}

echo "\n";

// 2. Vérifier les restaurants
$restaurants = Restaurant::with('user')->get();
echo "🏪 Restaurants: " . $restaurants->count() . "\n";

foreach ($restaurants as $restaurant) {
    echo "   - " . $restaurant->name . " (ID: " . $restaurant->id . ")\n";
    echo "     Propriétaire: " . ($restaurant->user ? $restaurant->user->name : 'Aucun') . "\n";
    echo "     Catégories: " . $restaurant->categories()->count() . "\n";
}

echo "\n";

// 3. Tester la connexion d'un utilisateur
if ($usersWithRestaurant->count() > 0) {
    $user = $usersWithRestaurant->first();
    echo "🔑 Test de connexion pour: " . $user->name . "\n";
    
    // Simuler une connexion
    Auth::login($user);
    
    if (Auth::check()) {
        echo "   ✅ Utilisateur connecté\n";
        echo "   - ID: " . Auth::id() . "\n";
        echo "   - Nom: " . Auth::user()->name . "\n";
        echo "   - Restaurant: " . (Auth::user()->restaurant ? Auth::user()->restaurant->name : 'Aucun') . "\n";
        
        // Tester l'accès aux catégories
        if (Auth::user()->restaurant) {
            $categories = Auth::user()->restaurant->categories()->get();
            echo "   - Catégories disponibles: " . $categories->count() . "\n";
        }
    } else {
        echo "   ❌ Échec de la connexion\n";
    }
} else {
    echo "❌ Aucun utilisateur avec restaurant trouvé\n";
}

echo "\n✅ Test terminé!\n";
