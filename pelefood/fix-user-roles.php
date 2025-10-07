<?php
// Script pour corriger les rôles des utilisateurs
require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\Restaurant;
use Spatie\Permission\Models\Role;

// Démarrer Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔧 Correction des rôles des utilisateurs\n";
echo "======================================\n\n";

// 1. Créer le rôle restaurant s'il n'existe pas
$restaurantRole = Role::firstOrCreate(['name' => 'restaurant']);
echo "✅ Rôle 'restaurant' créé/vérifié\n";

// 2. Trouver tous les utilisateurs avec un restaurant
$usersWithRestaurant = User::whereHas('restaurant')->get();

echo "👥 Utilisateurs avec restaurant trouvés: " . $usersWithRestaurant->count() . "\n\n";

foreach ($usersWithRestaurant as $user) {
    echo "🔄 Traitement de: " . $user->name . " (ID: " . $user->id . ")\n";
    echo "   - Rôle actuel: " . $user->role . "\n";
    echo "   - Restaurant: " . ($user->restaurant ? $user->restaurant->name : 'Aucun') . "\n";
    
    // Assigner le rôle restaurant
    if (!$user->hasRole('restaurant')) {
        $user->assignRole('restaurant');
        echo "   ✅ Rôle 'restaurant' assigné\n";
    } else {
        echo "   ℹ️  Rôle 'restaurant' déjà assigné\n";
    }
    
    // Mettre à jour le champ role dans la base de données
    $user->update(['role' => 'restaurant']);
    echo "   ✅ Champ 'role' mis à jour vers 'restaurant'\n";
    
    echo "\n";
}

echo "✅ Correction terminée!\n";
