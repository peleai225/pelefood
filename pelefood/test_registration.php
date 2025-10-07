<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST D'INSCRIPTION ===\n";

// Simuler une requête d'inscription
$requestData = [
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => 'password123',
    'password_confirmation' => 'password123',
    'account_type' => 'restaurant',
    'terms' => 'on'
];

echo "Données de test:\n";
print_r($requestData);

// Vérifier si l'utilisateur existe déjà
$existingUser = \App\Models\User::where('email', 'test@example.com')->first();
if ($existingUser) {
    echo "\nUtilisateur existant trouvé, suppression...\n";
    $existingUser->delete();
}

echo "\n=== CRÉATION D'UN NOUVEAU UTILISATEUR ===\n";

try {
    $user = \App\Models\User::create([
        'name' => $requestData['name'],
        'email' => $requestData['email'],
        'password' => \Illuminate\Support\Facades\Hash::make($requestData['password']),
        'role' => $requestData['account_type'],
        'status' => 'active',
        'is_active' => true,
        'email_verified_at' => now(),
    ]);
    
    echo "✅ Utilisateur créé avec succès!\n";
    echo "ID: " . $user->id . "\n";
    echo "Nom: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Rôle: " . $user->role . "\n";
    echo "Actif: " . ($user->is_active ? 'Oui' : 'Non') . "\n";
    
    // Tester la connexion
    echo "\n=== TEST DE CONNEXION ===\n";
    \Illuminate\Support\Facades\Auth::login($user);
    $connectedUser = \Illuminate\Support\Facades\Auth::user();
    
    if ($connectedUser) {
        echo "✅ Connexion réussie!\n";
        echo "Utilisateur connecté: " . $connectedUser->name . "\n";
        echo "Rôle: " . $connectedUser->role . "\n";
        
        // Tester les méthodes de rôle
        echo "\n=== TEST DES MÉTHODES DE RÔLE ===\n";
        echo "isSuperAdmin(): " . ($user->isSuperAdmin() ? 'Oui' : 'Non') . "\n";
        echo "isAdmin(): " . ($user->isAdmin() ? 'Oui' : 'Non') . "\n";
        echo "isRestaurantAdmin(): " . ($user->isRestaurantAdmin() ? 'Oui' : 'Non') . "\n";
        echo "isCustomer(): " . ($user->isCustomer() ? 'Oui' : 'Non') . "\n";
        
    } else {
        echo "❌ Échec de la connexion!\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Erreur lors de la création: " . $e->getMessage() . "\n";
    echo "Fichier: " . $e->getFile() . "\n";
    echo "Ligne: " . $e->getLine() . "\n";
}

echo "\n=== FIN DU TEST ===\n";

