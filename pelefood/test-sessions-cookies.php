<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔍 TEST DES SESSIONS ET COOKIES\n";
echo "================================\n\n";

try {
    // Test 1: Configuration des sessions
    echo "1️⃣ Configuration des sessions...\n";
    
    $sessionConfig = config('session');
    echo "   Driver: " . $sessionConfig['driver'] . "\n";
    echo "   Lifetime: " . $sessionConfig['lifetime'] . " minutes\n";
    echo "   Expire on close: " . ($sessionConfig['expire_on_close'] ? 'Oui' : 'Non') . "\n";
    echo "   Secure cookies: " . ($sessionConfig['secure'] ? 'Oui' : 'Non') . "\n";
    echo "   Same site: " . $sessionConfig['same_site'] . "\n";
    
    // Test 2: Test de création de session
    echo "\n2️⃣ Test de création de session...\n";
    
    $session = $app->make('session');
    $session->start();
    
    $sessionId = $session->getId();
    echo "   ✅ Session créée avec ID: " . substr($sessionId, 0, 20) . "...\n";
    
    // Test 3: Test des cookies
    echo "\n3️⃣ Test des cookies...\n";
    
    $cookieJar = $app->make('cookie');
    $sessionCookie = $cookieJar->get('laravel_session');
    
    if ($sessionCookie) {
        echo "   ✅ Cookie laravel_session trouvé: " . substr($sessionCookie, 0, 20) . "...\n";
    } else {
        echo "   ❌ Cookie laravel_session NON trouvé\n";
    }
    
    // Test 4: Test de stockage en session
    echo "\n4️⃣ Test de stockage en session...\n";
    
    $testValue = 'test_' . time();
    $session->put('test_key', $testValue);
    $retrievedValue = $session->get('test_key');
    
    if ($retrievedValue === $testValue) {
        echo "   ✅ Stockage et récupération en session OK\n";
    } else {
        echo "   ❌ Problème de stockage en session\n";
        echo "   Stocké: " . $testValue . "\n";
        echo "   Récupéré: " . $retrievedValue . "\n";
    }
    
    // Test 5: Test de l'authentification
    echo "\n5️⃣ Test de l'authentification...\n";
    
    if (\Auth::check()) {
        $user = \Auth::user();
        echo "   ✅ Utilisateur déjà connecté: " . $user->email . "\n";
    } else {
        echo "   ℹ️ Aucun utilisateur connecté\n";
        
        // Test de connexion manuelle
        echo "   🔄 Test de connexion manuelle...\n";
        
        $credentials = [
            'email' => 'test@pelefood.com',
            'password' => 'test123'
        ];
        
        if (\Auth::attempt($credentials)) {
            echo "   ✅ Connexion réussie avec test@pelefood.com\n";
            
            $user = \Auth::user();
            echo "   Utilisateur: " . $user->email . "\n";
            echo "   ID: " . $user->id . "\n";
            echo "   Rôles: " . implode(', ', $user->getRoleNames()->toArray()) . "\n";
            
            // Vérifier la session après connexion
            $newSessionId = $session->getId();
            echo "   Nouvelle session ID: " . substr($newSessionId, 0, 20) . "...\n";
            
            // Déconnexion
            \Auth::logout();
            echo "   ✅ Déconnexion effectuée\n";
            
        } else {
            echo "   ❌ Échec de la connexion avec test@pelefood.com\n";
        }
    }
    
    // Test 6: Vérification des permissions
    echo "\n6️⃣ Test des permissions...\n";
    
    try {
        $user = \App\Models\User::where('email', 'test@pelefood.com')->first();
        if ($user) {
            echo "   ✅ Utilisateur test@pelefood.com trouvé en base\n";
            echo "   Rôles: " . implode(', ', $user->getRoleNames()->toArray()) . "\n";
            
            // Vérifier les permissions
            $permissions = $user->getAllPermissions();
            echo "   Permissions: " . implode(', ', $permissions->pluck('name')->toArray()) . "\n";
            
        } else {
            echo "   ❌ Utilisateur test@pelefood.com NON trouvé en base\n";
        }
    } catch (Exception $e) {
        echo "   ❌ Erreur lors de la vérification des permissions: " . $e->getMessage() . "\n";
    }
    
    // Test 7: Vérification des middlewares
    echo "\n7️⃣ Test des middlewares...\n";
    
    $middlewareGroups = config('app.middleware_groups');
    if (isset($middlewareGroups['web'])) {
        echo "   ✅ Middleware web configuré\n";
        echo "   Middlewares: " . implode(', ', $middlewareGroups['web']) . "\n";
    } else {
        echo "   ❌ Middleware web NON configuré\n";
    }
    
    // Test 8: Vérification de la configuration CSRF
    echo "\n8️⃣ Test de la configuration CSRF...\n";
    
    $csrfConfig = config('session');
    echo "   CSRF enabled: " . (config('app.debug') ? 'Vérifié' : 'Non vérifié') . "\n";
    
    $token = $session->token();
    echo "   Token CSRF généré: " . substr($token, 0, 20) . "...\n";
    
    // Test 9: Vérification de la base de données des sessions
    echo "\n9️⃣ Vérification de la base de données des sessions...\n";
    
    try {
        $db = \DB::connection();
        $pdo = $db->getPdo();
        echo "   ✅ Connexion à la base de données OK\n";
        
        // Vérifier si la table sessions existe
        $tables = $db->select("SHOW TABLES LIKE 'sessions'");
        if (!empty($tables)) {
            echo "   ✅ Table sessions trouvée\n";
            
            // Compter les sessions
            $sessionCount = $db->table('sessions')->count();
            echo "   Nombre de sessions en base: " . $sessionCount . "\n";
            
        } else {
            echo "   ⚠️ Table sessions NON trouvée\n";
        }
        
    } catch (Exception $e) {
        echo "   ❌ Erreur base de données: " . $e->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "Fichier: " . $e->getFile() . "\n";
    echo "Ligne: " . $e->getLine() . "\n";
}

echo "\n🎯 TEST TERMINÉ\n";
?> 