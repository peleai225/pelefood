<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔍 TEST DE LA RÉPONSE DE CONNEXION\n";
echo "==================================\n\n";

try {
    // Simuler une session de navigateur
    echo "1️⃣ Création d'une session...\n";
    
    $session = $app->make('session');
    $session->start();
    
    // Générer un token CSRF
    $token = $session->token();
    echo "   ✅ Token CSRF généré: " . substr($token, 0, 20) . "...\n";
    
    // Test de connexion avec test@pelefood.com
    echo "\n2️⃣ Test de connexion avec test@pelefood.com...\n";
    
    $postRequest = \Illuminate\Http\Request::create('/login', 'POST', [
        'email' => 'test@pelefood.com',
        'password' => 'test123',
        '_token' => $token
    ]);
    
    // Ajouter les headers d'une vraie requête AJAX
    $postRequest->headers->set('Accept', 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8');
    $postRequest->headers->set('Accept-Language', 'fr,fr-fr;q=0.8,en-us;q=0.5,en;q=0.3');
    $postRequest->headers->set('Accept-Encoding', 'gzip, deflate');
    $postRequest->headers->set('Connection', 'keep-alive');
    $postRequest->headers->set('Upgrade-Insecure-Requests', '1');
    $postRequest->headers->set('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    $postRequest->headers->set('X-Requested-With', 'XMLHttpRequest'); // Important pour AJAX
    
    echo "   ✅ Requête créée avec headers AJAX\n";
    
    // Traiter la requête
    echo "   🔄 Traitement de la requête...\n";
    $postResponse = $app->handle($postRequest);
    echo "   ✅ Réponse reçue\n";
    
    // Analyser la réponse
    echo "\n3️⃣ Analyse de la réponse...\n";
    echo "   Status: " . $postResponse->getStatusCode() . "\n";
    echo "   Content-Type: " . $postResponse->headers->get('Content-Type') . "\n";
    
    if ($postResponse->getStatusCode() === 302) {
        echo "   ✅ Redirection (connexion réussie)\n";
        $location = $postResponse->headers->get('Location');
        echo "   Redirection vers: " . $location . "\n";
        
        // Vérifier l'authentification
        if (\Auth::check()) {
            $authUser = \Auth::user();
            echo "   ✅ Utilisateur authentifié: " . $authUser->email . "\n";
        } else {
            echo "   ❌ Utilisateur non authentifié\n";
        }
        
    } else {
        echo "   ⚠️ Pas de redirection (Status: " . $postResponse->getStatusCode() . ")\n";
        
        // Analyser le contenu de la réponse
        $content = $postResponse->getContent();
        echo "   Taille du contenu: " . strlen($content) . " caractères\n";
        
        if (strlen($content) > 0) {
            echo "   Début du contenu (200 premiers caractères):\n";
            echo "   " . str_replace("\n", "\n   ", substr($content, 0, 200)) . "...\n";
            
            // Chercher des éléments spécifiques
            if (strpos($content, 'Les identifiants fournis ne correspondent pas') !== false) {
                echo "   ❌ Erreur d'identifiants détectée\n";
            } elseif (strpos($content, 'Une erreur est survenue') !== false) {
                echo "   ❌ Erreur générale détectée\n";
            } elseif (strpos($content, 'CSRF token mismatch') !== false) {
                echo "   ❌ Erreur CSRF détectée\n";
            } elseif (strpos($content, 'dashboard') !== false) {
                echo "   ✅ Contenu dashboard détecté\n";
            } elseif (strpos($content, 'redirect') !== false) {
                echo "   ✅ Redirection détectée dans le contenu\n";
            } else {
                echo "   ℹ️ Aucun élément spécifique détecté\n";
            }
        } else {
            echo "   ❌ Contenu vide\n";
        }
    }
    
    // Vérifier les logs Laravel
    echo "\n4️⃣ Vérification des logs...\n";
    $logFile = storage_path('logs/laravel.log');
    if (file_exists($logFile)) {
        $logContent = file_get_contents($logFile);
        $lines = explode("\n", $logContent);
        $recentLines = array_slice($lines, -10); // Dernières 10 lignes
        
        echo "   Dernières lignes du log:\n";
        foreach ($recentLines as $line) {
            if (strpos($line, 'LoginController') !== false || 
                strpos($line, 'handleLogin') !== false ||
                strpos($line, 'Auth') !== false ||
                strpos($line, 'test@pelefood.com') !== false) {
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
}

echo "\n🎯 TEST TERMINÉ\n";
?> 