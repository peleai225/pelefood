<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "=== Debug de la session dans le navigateur ===\n\n";

// Récupérer l'utilisateur eva kone
$user = User::where('email', 'eva@gmail.com')->first();
if (!$user) {
    echo "❌ Utilisateur eva@gmail.com non trouvé\n";
    exit;
}

echo "=== Utilisateur trouvé ===\n";
echo "Nom: {$user->name}\n";
echo "Email: {$user->email}\n";
echo "Rôle: {$user->role}\n";
echo "ID: {$user->id}\n";

// Vérifier l'état de l'authentification
echo "\n=== État de l'authentification ===\n";
if (Auth::check()) {
    $connectedUser = Auth::user();
    echo "✅ Utilisateur connecté: {$connectedUser->name}\n";
    echo "   Rôle: {$connectedUser->role}\n";
    echo "   ID: {$connectedUser->id}\n";
} else {
    echo "❌ Aucun utilisateur connecté\n";
    echo "🔑 Tentative de connexion...\n";
    Auth::login($user);
    echo "✅ Utilisateur connecté\n";
}

// Vérifier les rôles Spatie
echo "\n=== Vérification des rôles Spatie ===\n";
echo "hasRole('restaurant'): " . ($user->hasRole('restaurant') ? 'OUI' : 'NON') . "\n";
echo "hasRole('admin'): " . ($user->hasRole('admin') ? 'OUI' : 'NON') . "\n";
echo "hasRole('super_admin'): " . ($user->hasRole('super_admin') ? 'OUI' : 'NON') . "\n";

// Tester le middleware CheckUserRole
echo "\n=== Test du middleware CheckUserRole ===\n";
$middleware = new \App\Http\Middleware\CheckUserRole();
$allowedRoles = 'restaurant,admin,super_admin';

echo "Rôles autorisés: {$allowedRoles}\n";
echo "Rôle de l'utilisateur: '{$user->role}'\n";

$rolesArray = explode(',', $allowedRoles);
$rolesArray = array_map('trim', $rolesArray);

if (in_array($user->role, $rolesArray)) {
    echo "✅ Rôle autorisé par le middleware CheckUserRole\n";
} else {
    echo "❌ Rôle NON autorisé par le middleware CheckUserRole\n";
    echo "Rôles autorisés: " . json_encode($rolesArray) . "\n";
    echo "Rôle utilisateur: " . json_encode($user->role) . "\n";
}

// Vérifier s'il y a un middleware Spatie qui interfère
echo "\n=== Vérification des middlewares Spatie ===\n";
if (class_exists('Spatie\Permission\Middlewares\RoleMiddleware')) {
    echo "✅ Middleware Spatie RoleMiddleware disponible\n";
    
    // Tester le middleware Spatie
    try {
        $spatieMiddleware = new \Spatie\Permission\Middlewares\RoleMiddleware();
        echo "✅ Middleware Spatie instancié\n";
        
        // Vérifier si l'utilisateur a le rôle requis
        if (method_exists($user, 'hasRole')) {
            echo "hasRole('restaurant'): " . ($user->hasRole('restaurant') ? 'OUI' : 'NON') . "\n";
        }
    } catch (Exception $e) {
        echo "❌ Erreur instanciation middleware Spatie: " . $e->getMessage() . "\n";
    }
} else {
    echo "❌ Middleware Spatie RoleMiddleware non disponible\n";
}

// Vérifier les routes
echo "\n=== Vérification des routes ===\n";
try {
    $url = route('restaurant.restaurants.create');
    echo "✅ URL générée: {$url}\n";
} catch (Exception $e) {
    echo "❌ Erreur génération URL: " . $e->getMessage() . "\n";
}

echo "\n=== Instructions de test ===\n";
echo "1. Allez sur http://127.0.0.1:8000/login\n";
echo "2. Connectez-vous avec eva@gmail.com\n";
echo "3. Mot de passe: Wondercoder2022@\n";
echo "4. Allez sur http://127.0.0.1:8000/restaurant/restaurants/create\n";
echo "5. Vérifiez si l'erreur 403 persiste\n";

echo "\n=== Test terminé ===\n";
