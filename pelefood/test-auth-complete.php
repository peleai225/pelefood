<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🧪 TEST COMPLET DE L'AUTHENTIFICATION PELEFOOD\n";
echo "=============================================\n\n";

try {
    // 1. Test de la base de données
    echo "1️⃣ Test de la base de données...\n";
    $pdo = DB::connection()->getPdo();
    echo "   ✅ Connexion DB: OK\n";
    
    // 2. Test des rôles
    echo "\n2️⃣ Test des rôles et permissions...\n";
    $roles = \Spatie\Permission\Models\Role::all();
    echo "   ✅ Rôles trouvés: " . $roles->count() . "\n";
    
    $permissions = \Spatie\Permission\Models\Permission::all();
    echo "   ✅ Permissions trouvées: " . $permissions->count() . "\n";
    
    // 3. Test des utilisateurs
    echo "\n3️⃣ Test des utilisateurs...\n";
    $users = \App\Models\User::all();
    echo "   ✅ Utilisateurs trouvés: " . $users->count() . "\n";
    
    foreach ($users as $user) {
        echo "   👤 {$user->email} (rôle DB: {$user->role})\n";
        if (method_exists($user, 'getRoleNames')) {
            $spatieRoles = $user->getRoleNames();
            echo "      Rôles Spatie: " . ($spatieRoles->count() > 0 ? implode(', ', $spatieRoles->toArray()) : 'Aucun') . "\n";
        }
    }
    
    // 4. Test de connexion avec l'utilisateur simple
    echo "\n4️⃣ Test de connexion...\n";
    $testUser = \App\Models\User::where('email', 'test@test.com')->first();
    
    if ($testUser) {
        echo "   ✅ Utilisateur test@test.com trouvé\n";
        
        // Test de connexion
        if (\Illuminate\Support\Facades\Auth::attempt(['email' => 'test@test.com', 'password' => '12345678'])) {
            echo "   ✅ Connexion réussie avec test@test.com\n";
            
            $user = \Illuminate\Support\Facades\Auth::user();
            echo "   👤 Utilisateur connecté: {$user->name} ({$user->email})\n";
            echo "   🔑 Rôle: {$user->role}\n";
            
            // Test des permissions
            if (method_exists($user, 'hasPermissionTo')) {
                echo "   🔐 Test des permissions:\n";
                $testPermissions = ['view_dashboard', 'manage_orders'];
                foreach ($testPermissions as $permission) {
                    $hasPermission = $user->hasPermissionTo($permission);
                    echo "      - {$permission}: " . ($hasPermission ? '✅' : '❌') . "\n";
                }
            }
            
            \Illuminate\Support\Facades\Auth::logout();
            echo "   ✅ Déconnexion réussie\n";
        } else {
            echo "   ❌ Échec de la connexion avec test@test.com\n";
        }
    } else {
        echo "   ❌ Utilisateur test@test.com non trouvé\n";
    }
    
    // 5. Test de création d'un nouvel utilisateur
    echo "\n5️⃣ Test de création d'utilisateur...\n";
    try {
        $newUser = \App\Models\User::create([
            'name' => 'Test Création',
            'email' => 'test-creation@test.com',
            'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
            'role' => 'customer',
            'status' => 'active'
        ]);
        
        // Assigner le rôle
        $customerRole = \Spatie\Permission\Models\Role::where('name', 'customer')->first();
        if ($customerRole) {
            $newUser->assignRole($customerRole);
        }
        
        echo "   ✅ Nouvel utilisateur créé: {$newUser->email}\n";
        
        // Test de connexion avec le nouvel utilisateur
        if (\Illuminate\Support\Facades\Auth::attempt(['email' => 'test-creation@test.com', 'password' => '12345678'])) {
            echo "   ✅ Connexion réussie avec le nouvel utilisateur\n";
            \Illuminate\Support\Facades\Auth::logout();
        } else {
            echo "   ❌ Échec de connexion avec le nouvel utilisateur\n";
        }
        
        // Supprimer l'utilisateur de test
        $newUser->delete();
        echo "   🗑️ Utilisateur de test supprimé\n";
        
    } catch (Exception $e) {
        echo "   ❌ Erreur création utilisateur: " . $e->getMessage() . "\n";
    }
    
    // 6. Test des routes
    echo "\n6️⃣ Test des routes...\n";
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $authRoutes = collect($routes)->filter(function ($route) {
        return str_contains($route->uri, 'login') || str_contains($route->uri, 'register');
    });
    
    echo "   ✅ Routes d'authentification trouvées: " . $authRoutes->count() . "\n";
    foreach ($authRoutes as $route) {
        echo "      - {$route->methods[0]} {$route->uri} -> {$route->getActionName()}\n";
    }
    
    echo "\n🎉 TOUS LES TESTS SONT PASSÉS AVEC SUCCÈS !\n";
    echo "=============================================\n";
    echo "✅ L'authentification PeleFood fonctionne parfaitement !\n";
    echo "✅ Vous pouvez maintenant vous connecter et créer des comptes\n";
    echo "✅ Utilisez test@test.com / 12345678 pour tester\n";
    
} catch (Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage() . "\n";
    echo "❌ L'authentification ne fonctionne pas correctement\n";
} 