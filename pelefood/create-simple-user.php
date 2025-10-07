<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "🔧 Création d'un utilisateur simple...\n\n";
    
    // Créer un utilisateur très simple
    $simpleUser = \App\Models\User::create([
        'name' => 'Test User',
        'email' => 'test@test.com',
        'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
        'role' => 'customer',
        'status' => 'active'
    ]);
    
    // Assigner le rôle customer
    $customerRole = \Spatie\Permission\Models\Role::where('name', 'customer')->first();
    if ($customerRole) {
        $simpleUser->assignRole($customerRole);
    }
    
    echo "✅ Utilisateur créé avec succès !\n";
    echo "📧 Email: test@test.com\n";
    echo "🔑 Mot de passe: 12345678\n";
    echo "👤 Rôle: " . $simpleUser->role . "\n";
    
    // Test de connexion
    if (\Illuminate\Support\Facades\Auth::attempt(['email' => 'test@test.com', 'password' => '12345678'])) {
        echo "✅ Test de connexion réussi !\n";
        \Illuminate\Support\Facades\Auth::logout();
    } else {
        echo "❌ Test de connexion échoué !\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
} 