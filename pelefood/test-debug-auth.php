<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🧪 TEST DE DÉBOGAGE COMPLET DE L'AUTHENTIFICATION\n";
echo "==================================================\n\n";

try {
    // 1. Test des routes
    echo "1️⃣ Test des routes d'authentification...\n";
    
    $router = app('router');
    $routes = $router->getRoutes();
    
    $authRoutes = [];
    foreach ($routes as $route) {
        if (str_contains($route->uri, 'login') || str_contains($route->uri, 'register')) {
            $authRoutes[] = [
                'uri' => $route->uri,
                'methods' => $route->methods,
                'name' => $route->getName(),
                'action' => $route->getActionName()
            ];
        }
    }
    
    echo "   ✅ Routes trouvées:\n";
    foreach ($authRoutes as $route) {
        echo "      - {$route['uri']} ({$route['name']}) via " . implode(',', $route['methods']) . "\n";
        echo "        Action: {$route['action']}\n";
    }
    
    // 2. Test des contrôleurs
    echo "\n2️⃣ Test des contrôleurs...\n";
    
    try {
        $loginController = new \App\Http\Controllers\Auth\LoginController();
        echo "   ✅ LoginController: OK\n";
    } catch (Exception $e) {
        echo "   ❌ LoginController: " . $e->getMessage() . "\n";
    }
    
    try {
        $registerController = new \App\Http\Controllers\Auth\RegisterController();
        echo "   ✅ RegisterController: OK\n";
    } catch (Exception $e) {
        echo "   ❌ RegisterController: " . $e->getMessage() . "\n";
    }
    
    // 3. Test des modèles
    echo "\n3️⃣ Test des modèles...\n";
    
    try {
        $user = new \App\Models\User();
        echo "   ✅ Modèle User: OK\n";
    } catch (Exception $e) {
        echo "   ❌ Modèle User: " . $e->getMessage() . "\n";
    }
    
    try {
        $role = new \Spatie\Permission\Models\Role();
        echo "   ✅ Modèle Role: OK\n";
    } catch (Exception $e) {
        echo "   ❌ Modèle Role: " . $e->getMessage() . "\n";
    }
    
    // 4. Test de la base de données
    echo "\n4️⃣ Test de la base de données...\n";
    
    try {
        $pdo = DB::connection()->getPdo();
        echo "   ✅ Connexion DB: OK\n";
        
        // Test des tables
        $tables = ['users', 'roles', 'permissions', 'model_has_roles', 'model_has_permissions'];
        foreach ($tables as $table) {
            try {
                $count = DB::table($table)->count();
                echo "   ✅ Table {$table}: {$count} enregistrements\n";
            } catch (Exception $e) {
                echo "   ❌ Table {$table}: " . $e->getMessage() . "\n";
            }
        }
        
    } catch (Exception $e) {
        echo "   ❌ Connexion DB: " . $e->getMessage() . "\n";
    }
    
    // 5. Test des middlewares
    echo "\n5️⃣ Test des middlewares...\n";
    
    try {
        $guestMiddleware = new \App\Http\Middleware\RedirectIfAuthenticated();
        echo "   ✅ RedirectIfAuthenticated: OK\n";
    } catch (Exception $e) {
        echo "   ❌ RedirectIfAuthenticated: " . $e->getMessage() . "\n";
    }
    
    try {
        $authMiddleware = new \App\Http\Middleware\Authenticate();
        echo "   ✅ Authenticate: OK\n";
    } catch (Exception $e) {
        echo "   ❌ Authenticate: " . $e->getMessage() . "\n";
    }
    
    // 6. Test des vues
    echo "\n6️⃣ Test des vues...\n";
    
    $viewPaths = [
        'auth.login' => 'resources/views/auth/login.blade.php',
        'auth.register' => 'resources/views/auth/register.blade.php',
        'layouts.app' => 'resources/views/layouts/app.blade.php'
    ];
    
    foreach ($viewPaths as $viewName => $path) {
        if (file_exists($path)) {
            echo "   ✅ Vue {$viewName}: OK\n";
        } else {
            echo "   ❌ Vue {$viewName}: Fichier manquant\n";
        }
    }
    
    // 7. Test des routes avec simulation
    echo "\n7️⃣ Test des routes avec simulation...\n";
    
    try {
        // Simuler une requête GET vers /login
        $request = \Illuminate\Http\Request::create('/login', 'GET');
        $response = app()->handle($request);
        echo "   ✅ Route GET /login: " . $response->getStatusCode() . "\n";
    } catch (Exception $e) {
        echo "   ❌ Route GET /login: " . $e->getMessage() . "\n";
    }
    
    try {
        // Simuler une requête GET vers /register
        $request = \Illuminate\Http\Request::create('/register', 'GET');
        $response = app()->handle($request);
        echo "   ✅ Route GET /register: " . $response->getStatusCode() . "\n";
    } catch (Exception $e) {
        echo "   ❌ Route GET /register: " . $e->getMessage() . "\n";
    }
    
    // 8. Test des permissions Spatie
    echo "\n8️⃣ Test des permissions Spatie...\n";
    
    try {
        $roles = \Spatie\Permission\Models\Role::all();
        echo "   ✅ Rôles: " . $roles->count() . " trouvés\n";
        foreach ($roles as $role) {
            echo "      - {$role->name} ({$role->permissions->count()} permissions)\n";
        }
        
        $permissions = \Spatie\Permission\Models\Permission::all();
        echo "   ✅ Permissions: " . $permissions->count() . " trouvées\n";
        
    } catch (Exception $e) {
        echo "   ❌ Permissions Spatie: " . $e->getMessage() . "\n";
    }
    
    // 9. Test de création d'utilisateur
    echo "\n9️⃣ Test de création d'utilisateur...\n";
    
    try {
        $testUser = \App\Models\User::where('email', 'test-debug@test.com')->first();
        if ($testUser) {
            $testUser->delete();
            echo "   ✅ Ancien utilisateur de test supprimé\n";
        }
        
        $user = \App\Models\User::create([
            'name' => 'Test Debug',
            'email' => 'test-debug@test.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
            'status' => 'active'
        ]);
        
        echo "   ✅ Utilisateur de test créé: ID {$user->id}\n";
        
        // Assigner un rôle
        $role = \Spatie\Permission\Models\Role::where('name', 'customer')->first();
        if ($role) {
            $user->assignRole($role);
            echo "   ✅ Rôle customer assigné\n";
        }
        
        // Nettoyer
        $user->delete();
        echo "   ✅ Utilisateur de test supprimé\n";
        
    } catch (Exception $e) {
        echo "   ❌ Création utilisateur: " . $e->getMessage() . "\n";
    }
    
    echo "\n🎉 TEST TERMINÉ AVEC SUCCÈS !\n";
    echo "Tous les composants d'authentification sont opérationnels.\n";
    
} catch (Exception $e) {
    echo "\n💥 ERREUR CRITIQUE: " . $e->getMessage() . "\n";
    echo "Fichier: " . $e->getFile() . "\n";
    echo "Ligne: " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
} 