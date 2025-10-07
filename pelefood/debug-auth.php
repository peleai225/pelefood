<?php

require_once __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// Configuration de base
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Tenant;
use App\Models\Restaurant;

echo "🔍 Diagnostic des problèmes d'authentification...\n\n";

try {
    // Vérifier les rôles
    echo "1. Vérification des rôles :\n";
    $roles = ['super_admin', 'admin', 'restaurant', 'customer'];
    foreach ($roles as $roleName) {
        $role = Role::where('name', $roleName)->first();
        if ($role) {
            echo "   ✅ Rôle '$roleName' existe\n";
        } else {
            echo "   ❌ Rôle '$roleName' manquant\n";
        }
    }

    // Vérifier l'utilisateur de test
    echo "\n2. Vérification de l'utilisateur de test :\n";
    $user = User::where('email', 'test@pelefood.com')->first();
    if ($user) {
        echo "   ✅ Utilisateur test@pelefood.com existe\n";
        echo "   📧 Email: {$user->email}\n";
        echo "   👤 Nom: {$user->name}\n";
        echo "   🏢 Tenant ID: {$user->tenant_id}\n";
        echo "   👤 Rôles: " . implode(', ', $user->getRoleNames()->toArray()) . "\n";
        
        // Test de connexion
        if (Hash::check('password123', $user->password)) {
            echo "   ✅ Mot de passe correct\n";
        } else {
            echo "   ❌ Mot de passe incorrect\n";
        }
    } else {
        echo "   ❌ Utilisateur test@pelefood.com introuvable\n";
    }

    // Vérifier le tenant
    echo "\n3. Vérification du tenant :\n";
    if ($user && $user->tenant_id) {
        $tenant = Tenant::find($user->tenant_id);
        if ($tenant) {
            echo "   ✅ Tenant trouvé: {$tenant->name}\n";
            echo "   🌐 Domaine: {$tenant->domain}\n";
            echo "   📧 Email: {$tenant->email}\n";
        } else {
            echo "   ❌ Tenant introuvable\n";
        }
    }

    // Vérifier le restaurant
    echo "\n4. Vérification du restaurant :\n";
    if ($user && $user->tenant_id) {
        $restaurant = Restaurant::where('tenant_id', $user->tenant_id)->first();
        if ($restaurant) {
            echo "   ✅ Restaurant trouvé: {$restaurant->name}\n";
            echo "   📞 Téléphone: {$restaurant->phone}\n";
            echo "   📍 Ville: {$restaurant->city}\n";
            echo "   ✅ Actif: " . ($restaurant->is_active ? 'Oui' : 'Non') . "\n";
        } else {
            echo "   ❌ Restaurant introuvable\n";
        }
    }

    // Vérifier les routes
    echo "\n5. Vérification des routes :\n";
    $routes = [
        'login' => '/login',
        'register' => '/register',
        'restaurant.dashboard' => '/restaurant/dashboard',
        'admin.dashboard' => '/admin/dashboard',
        'super-admin.dashboard' => '/super-admin/dashboard'
    ];

    foreach ($routes as $name => $path) {
        try {
            $url = route($name);
            echo "   ✅ Route '$name' : $url\n";
        } catch (Exception $e) {
            echo "   ❌ Route '$name' : Erreur - {$e->getMessage()}\n";
        }
    }

    // Test de connexion simulé
    echo "\n6. Test de connexion simulé :\n";
    if ($user) {
        try {
            // Simuler la vérification des identifiants
            if (Hash::check('password123', $user->password)) {
                echo "   ✅ Vérification des identifiants réussie\n";
                
                // Vérifier les rôles
                if ($user->hasRole('restaurant')) {
                    echo "   ✅ Rôle restaurant confirmé\n";
                    echo "   🎯 Redirection vers: restaurant.dashboard\n";
                } elseif ($user->hasRole('admin')) {
                    echo "   ✅ Rôle admin confirmé\n";
                    echo "   🎯 Redirection vers: admin.dashboard\n";
                } elseif ($user->hasRole('super_admin')) {
                    echo "   ✅ Rôle super_admin confirmé\n";
                    echo "   🎯 Redirection vers: super-admin.dashboard\n";
                } else {
                    echo "   ⚠️  Aucun rôle spécifique trouvé\n";
                    echo "   🎯 Redirection vers: dashboard\n";
                }
            } else {
                echo "   ❌ Vérification des identifiants échouée\n";
            }
        } catch (Exception $e) {
            echo "   ❌ Erreur lors du test de connexion: {$e->getMessage()}\n";
        }
    }

    echo "\n🎉 Diagnostic terminé !\n";
    echo "\n📋 Résumé :\n";
    echo "- Utilisateur: test@pelefood.com\n";
    echo "- Mot de passe: password123\n";
    echo "- URL de test: http://127.0.0.1:8000/login\n";

} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "📍 Fichier: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
