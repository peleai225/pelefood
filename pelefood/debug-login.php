<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔍 DÉBOGAGE COMPLET DE LA CONNEXION\n";
echo "===================================\n\n";

try {
    // 1. Vérifier la configuration de session
    echo "1️⃣ Configuration de session...\n";
    $config = config('session');
    echo "   Driver: " . $config['driver'] . "\n";
    echo "   Lifetime: " . $config['lifetime'] . " minutes\n";
    echo "   Domain: " . $config['domain'] . "\n";
    echo "   Secure: " . ($config['secure'] ? 'Oui' : 'Non') . "\n";
    
    // 2. Démarrer une session
    echo "\n2️⃣ Démarrage de session...\n";
    $session = $app->make('session');
    $session->start();
    echo "   ✅ Session démarrée\n";
    echo "   ID de session: " . $session->getId() . "\n";
    
    // 3. Générer un token CSRF
    echo "\n3️⃣ Génération du token CSRF...\n";
    $token = $session->token();
    echo "   ✅ Token CSRF généré: " . substr($token, 0, 20) . "...\n";
    
    // 4. Vérifier l'utilisateur de test
    echo "\n4️⃣ Vérification de l'utilisateur test...\n";
    $user = \App\Models\User::where('email', 'test@pelefood.com')->first();
    if ($user) {
        echo "   ✅ Utilisateur trouvé\n";
        echo "   ID: " . $user->id . "\n";
        echo "   Email: " . $user->email . "\n";
        echo "   Rôle: " . $user->role . "\n";
        echo "   Status: " . $user->status . "\n";
        
        // Vérifier le mot de passe
        if (\Hash::check('test123', $user->password)) {
            echo "   ✅ Mot de passe correct\n";
        } else {
            echo "   ❌ Mot de passe incorrect\n";
        }
    } else {
        echo "   ❌ Utilisateur non trouvé\n";
    }
    
    // 5. Test de connexion étape par étape
    echo "\n5️⃣ Test de connexion étape par étape...\n";
    
    // 5.1 Créer la requête
    $request = \Illuminate\Http\Request::create('/login', 'POST', [
        'email' => 'test@pelefood.com',
        'password' => 'test123',
        '_token' => $token
    ]);
    
    // 5.2 Ajouter les headers
    $request->headers->set('Accept', 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8');
    $request->headers->set('Accept-Language', 'fr,fr-fr;q=0.8,en-us;q=0.5,en;q=0.3');
    $request->headers->set('Accept-Encoding', 'gzip, deflate');
    $request->headers->set('Connection', 'keep-alive');
    $request->headers->set('Upgrade-Insecure-Requests', '1');
    $request->headers->set('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    
    echo "   ✅ Requête créée avec headers\n";
    
    // 5.3 Traiter la requête
    echo "   🔄 Traitement de la requête...\n";
    $response = $app->handle($request);
    echo "   ✅ Réponse reçue\n";
    
    // 5.4 Analyser la réponse
    echo "\n6️⃣ Analyse de la réponse...\n";
    echo "   Status: " . $response->getStatusCode() . "\n";
    echo "   Content-Type: " . $response->headers->get('Content-Type') . "\n";
    
    if ($response->getStatusCode() === 302) {
        echo "   ✅ Redirection (connexion réussie)\n";
        $location = $response->headers->get('Location');
        echo "   Redirection vers: " . $location . "\n";
        
        // Vérifier l'authentification
        if (\Auth::check()) {
            $authUser = \Auth::user();
            echo "   ✅ Utilisateur authentifié: " . $authUser->email . "\n";
        } else {
            echo "   ❌ Utilisateur non authentifié\n";
        }
        
    } else {
        echo "   ⚠️ Pas de redirection\n";
        
        // Analyser le contenu
        $content = $response->getContent();
        echo "   Taille du contenu: " . strlen($content) . " caractères\n";
        
        if (strlen($content) > 0) {
            echo "   Début du contenu: " . substr($content, 0, 300) . "...\n";
        }
        
        // Chercher des erreurs
        if (strpos($content, 'Les identifiants fournis ne correspondent pas') !== false) {
            echo "   ❌ Erreur d'identifiants\n";
        } elseif (strpos($content, 'Une erreur est survenue') !== false) {
            echo "   ❌ Erreur générale\n";
        } elseif (strpos($content, 'CSRF token mismatch') !== false) {
            echo "   ❌ Erreur CSRF\n";
        }
    }
    
    // 6. Vérifier les logs Laravel
    echo "\n7️⃣ Vérification des logs...\n";
    $logFile = storage_path('logs/laravel.log');
    if (file_exists($logFile)) {
        $logContent = file_get_contents($logFile);
        $lines = explode("\n", $logContent);
        $recentLines = array_slice($lines, -20); // Dernières 20 lignes
        
        echo "   Dernières lignes du log:\n";
        foreach ($recentLines as $line) {
            if (strpos($line, 'LoginController') !== false || 
                strpos($line, 'handleLogin') !== false ||
                strpos($line, 'Auth') !== false) {
                echo "   📝 " . trim($line) . "\n";
            }
        }
    } else {
        echo "   ⚠️ Fichier de log non trouvé\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "Fichier: " . $e->getFile() . "\n";
    echo "Ligne: " . $e->getLine() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n🎯 DÉBOGAGE TERMINÉ\n";
?> 