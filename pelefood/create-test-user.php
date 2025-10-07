<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "👤 CRÉATION D'UN UTILISATEUR DE TEST\n";
echo "====================================\n\n";

try {
    // Vérifier si l'utilisateur de test existe déjà
    $testEmail = 'test@pelefood.com';
    $existingUser = \App\Models\User::where('email', $testEmail)->first();
    
    if ($existingUser) {
        echo "1️⃣ Utilisateur de test existant trouvé...\n";
        echo "   Email: " . $existingUser->email . "\n";
        echo "   Nom: " . $existingUser->name . "\n";
        echo "   Rôle: " . $existingUser->role . "\n";
        
        // Mettre à jour le mot de passe
        $existingUser->update([
            'password' => \Hash::make('test123')
        ]);
        echo "   ✅ Mot de passe mis à jour: test123\n";
        
    } else {
        echo "1️⃣ Création d'un nouvel utilisateur de test...\n";
        
        $user = \App\Models\User::create([
            'name' => 'Utilisateur Test',
            'email' => $testEmail,
            'password' => \Hash::make('test123'),
            'role' => 'customer',
            'status' => 'active'
        ]);
        
        echo "   ✅ Utilisateur créé: " . $user->email . "\n";
        
        // Assigner le rôle
        $role = \Spatie\Permission\Models\Role::where('name', 'customer')->first();
        if ($role) {
            $user->assignRole($role);
            echo "   ✅ Rôle 'customer' assigné\n";
        }
    }
    
    // Créer aussi un utilisateur restaurant de test
    echo "\n2️⃣ Création d'un utilisateur restaurant de test...\n";
    
    $restaurantEmail = 'restaurant@pelefood.com';
    $existingRestaurant = \App\Models\User::where('email', $restaurantEmail)->first();
    
    if ($existingRestaurant) {
        echo "   Utilisateur restaurant existant trouvé\n";
        $existingRestaurant->update([
            'password' => \Hash::make('restaurant123')
        ]);
        echo "   ✅ Mot de passe mis à jour: restaurant123\n";
        
    } else {
        $restaurantUser = \App\Models\User::create([
            'name' => 'Restaurant Test',
            'email' => $restaurantEmail,
            'password' => \Hash::make('restaurant123'),
            'role' => 'admin',
            'status' => 'active'
        ]);
        
        echo "   ✅ Restaurant créé: " . $restaurantUser->email . "\n";
        
        // Assigner le rôle
        $restaurantRole = \Spatie\Permission\Models\Role::where('name', 'admin')->first();
        if ($restaurantRole) {
            $restaurantUser->assignRole($restaurantRole);
            echo "   ✅ Rôle 'admin' assigné\n";
        }
    }
    
    echo "\n🎯 UTILISATEURS DE TEST CRÉÉS\n";
    echo "==============================\n";
    echo "👤 Client: test@pelefood.com / test123\n";
    echo "🏪 Restaurant: restaurant@pelefood.com / restaurant123\n";
    echo "\nVous pouvez maintenant tester la connexion avec ces identifiants !\n";
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "Fichier: " . $e->getFile() . "\n";
    echo "Ligne: " . $e->getLine() . "\n";
}

echo "\n🎯 SCRIPT TERMINÉ\n";
?> 