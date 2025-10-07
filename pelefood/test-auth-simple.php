<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔐 TEST D'AUTHENTIFICATION SIMPLE\n";
echo "=================================\n\n";

try {
    // Test de connexion avec un utilisateur existant
    echo "1️⃣ Test de connexion avec un utilisateur existant...\n";
    
    $email = 'admin@restaurant-test.ci';
    $password = 'password'; // Mot de passe par défaut
    
    // Vérifier si l'utilisateur existe
    $user = \App\Models\User::where('email', $email)->first();
    if ($user) {
        echo "   ✅ Utilisateur trouvé: {$user->email} (rôle: {$user->role})\n";
        
        // Vérifier le hash du mot de passe
        if (\Hash::check($password, $user->password)) {
            echo "   ✅ Mot de passe correct\n";
        } else {
            echo "   ❌ Mot de passe incorrect\n";
            echo "   Hash stocké: " . $user->password . "\n";
            echo "   Hash du mot de passe 'password': " . \Hash::make($password) . "\n";
        }
    } else {
        echo "   ❌ Utilisateur non trouvé: {$email}\n";
    }
    
    // Test de création d'un nouvel utilisateur
    echo "\n2️⃣ Test de création d'un nouvel utilisateur...\n";
    
    try {
        $newUser = \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'test' . time() . '@example.com',
            'password' => \Hash::make('password123'),
            'role' => 'customer',
            'status' => 'active'
        ]);
        
        echo "   ✅ Nouvel utilisateur créé: {$newUser->email}\n";
        
        // Assigner le rôle
        $role = \Spatie\Permission\Models\Role::where('name', 'customer')->first();
        if ($role) {
            $newUser->assignRole($role);
            echo "   ✅ Rôle 'customer' assigné\n";
        }
        
        // Supprimer l'utilisateur de test
        $newUser->delete();
        echo "   🗑️ Utilisateur de test supprimé\n";
        
    } catch (Exception $e) {
        echo "   ❌ Erreur lors de la création: " . $e->getMessage() . "\n";
    }
    
    // Test des routes d'authentification
    echo "\n3️⃣ Test des routes d'authentification...\n";
    
    try {
        $request = \Illuminate\Http\Request::create('/login', 'POST', [
            'email' => 'admin@restaurant-test.ci',
            'password' => 'password',
            '_token' => csrf_token()
        ]);
        
        $response = $app->handle($request);
        echo "   ✅ Route POST /login accessible\n";
        echo "   Status: " . $response->getStatusCode() . "\n";
        
    } catch (Exception $e) {
        echo "   ❌ Erreur route POST /login: " . $e->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur générale: " . $e->getMessage() . "\n";
    echo "Fichier: " . $e->getFile() . "\n";
    echo "Ligne: " . $e->getLine() . "\n";
}

echo "\n🎯 TEST TERMINÉ\n";
?> 