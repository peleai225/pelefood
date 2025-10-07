<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST BOUTON DE CONNEXION ===\n\n";

// Test de connexion avec les identifiants
$email = 'admin@pelefood.ci';
$password = 'admin123';

echo "🔐 Test de connexion avec :\n";
echo "- Email : {$email}\n";
echo "- Mot de passe : {$password}\n\n";

// Vérifier si l'utilisateur existe
$user = \App\Models\User::where('email', $email)->first();

if ($user) {
    echo "✅ Utilisateur trouvé :\n";
    echo "- Nom : {$user->name}\n";
    echo "- Email : {$user->email}\n";
    echo "- Rôle : {$user->role}\n";
    echo "- ID : {$user->id}\n";
    
    // Vérifier le mot de passe
    if (\Illuminate\Support\Facades\Hash::check($password, $user->password)) {
        echo "✅ Mot de passe correct\n";
        
        // Tenter la connexion
        if (\Illuminate\Support\Facades\Auth::attempt(['email' => $email, 'password' => $password])) {
            echo "✅ Connexion réussie !\n";
            echo "✅ Utilisateur connecté : " . \Illuminate\Support\Facades\Auth::user()->name . "\n";
            
            // Vérifier les rôles
            $authUser = \Illuminate\Support\Facades\Auth::user();
            echo "\n🔍 Rôles et permissions :\n";
            echo "- Rôle principal : {$authUser->role}\n";
            echo "- hasRole('super_admin') : " . ($authUser->hasRole('super_admin') ? 'OUI' : 'NON') . "\n";
            echo "- hasRole('admin') : " . ($authUser->hasRole('admin') ? 'OUI' : 'NON') . "\n";
            echo "- hasRole('restaurant') : " . ($authUser->hasRole('restaurant') ? 'OUI' : 'NON') . "\n";
            
            // Vérifier les conditions de la navbar
            echo "\n🎯 Conditions navbar :\n";
            if (method_exists($authUser, 'isSuperAdmin')) {
                echo "- isSuperAdmin() : " . ($authUser->isSuperAdmin() ? 'OUI' : 'NON') . "\n";
            } else {
                echo "- isSuperAdmin() : MÉTHODE N'EXISTE PAS\n";
            }
            echo "- role === 'admin' : " . ($authUser->role === 'admin' ? 'OUI' : 'NON') . "\n";
            echo "- role === 'restaurant' : " . ($authUser->role === 'restaurant' ? 'OUI' : 'NON') . "\n";
            
            // Déconnexion
            \Illuminate\Support\Facades\Auth::logout();
            echo "\n🚪 Déconnexion effectuée\n";
            
        } else {
            echo "❌ Échec de la connexion\n";
        }
    } else {
        echo "❌ Mot de passe incorrect\n";
    }
} else {
    echo "❌ Utilisateur non trouvé\n";
}

echo "\n=== FIN DU TEST ===\n";
