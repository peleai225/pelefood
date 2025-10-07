<?php

require_once __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

// Configuration de base
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Tenant;
use App\Models\Restaurant;

echo "🔍 Test des boutons de connexion...\n\n";

try {
    // Vérifier l'utilisateur de test
    $user = User::where('email', 'test@pelefood.com')->first();
    if (!$user) {
        echo "❌ Utilisateur test@pelefood.com introuvable\n";
        exit;
    }

    echo "✅ Utilisateur trouvé: {$user->name}\n";
    echo "📧 Email: {$user->email}\n";
    echo "👤 Rôles: " . implode(', ', $user->getRoleNames()->toArray()) . "\n";

    // Test de vérification du mot de passe
    if (Hash::check('password123', $user->password)) {
        echo "✅ Mot de passe correct\n";
    } else {
        echo "❌ Mot de passe incorrect\n";
    }

    // Test de connexion simulé
    echo "\n🧪 Test de connexion simulé :\n";
    
    // Simuler Auth::attempt
    $credentials = ['email' => 'test@pelefood.com', 'password' => 'password123'];
    $attemptResult = Hash::check('password123', $user->password);
    
    if ($attemptResult) {
        echo "✅ Auth::attempt simulé réussi\n";
        echo "✅ Utilisateur connecté: {$user->name}\n";
        echo "✅ Rôles disponibles: " . implode(', ', $user->getRoleNames()->toArray()) . "\n";
        
        // Test des redirections
        if ($user->hasRole('restaurant')) {
            echo "✅ Redirection vers: restaurant.dashboard\n";
        } elseif ($user->hasRole('admin')) {
            echo "✅ Redirection vers: admin.dashboard\n";
        } else {
            echo "✅ Redirection vers: dashboard\n";
        }
    } else {
        echo "❌ Auth::attempt simulé échoué\n";
    }

    echo "\n📋 URLs de test disponibles :\n";
    echo "- Debug: http://127.0.0.1:8000/login-debug\n";
    echo "- Ultra Simple: http://127.0.0.1:8000/login-ultra-simple\n";
    echo "- Test: http://127.0.0.1:8000/login-test\n";
    echo "- Principal: http://127.0.0.1:8000/login\n";

    echo "\n🎯 Instructions de test :\n";
    echo "1. Aller sur http://127.0.0.1:8000/login-debug\n";
    echo "2. Saisir: test@pelefood.com\n";
    echo "3. Saisir: password123\n";
    echo "4. Cliquer sur 'Se connecter'\n";
    echo "5. Observer les messages de debug\n";

} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "📍 Fichier: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
