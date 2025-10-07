<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🌐 TEST D'AUTHENTIFICATION SIMULANT UN NAVIGATEUR\n";
echo "================================================\n\n";

try {
    // Simuler une session de navigateur
    echo "1️⃣ Création d'une session...\n";
    
    $session = $app->make('session');
    $session->start();
    
    // Générer un token CSRF
    $token = $session->token();
    echo "   ✅ Token CSRF généré: " . substr($token, 0, 20) . "...\n";
    
    // Simuler une requête GET pour obtenir la page de connexion
    echo "\n2️⃣ Test de la page de connexion (GET)...\n";
    
    $getRequest = \Illuminate\Http\Request::create('/login', 'GET');
    $getResponse = $app->handle($getRequest);
    
    if ($getResponse->getStatusCode() === 200) {
        echo "   ✅ Page de connexion accessible (GET)\n";
        
        // Extraire le token CSRF de la réponse
        $content = $getResponse->getContent();
        if (preg_match('/name="_token" value="([^"]+)"/', $content, $matches)) {
            $csrfToken = $matches[1];
            echo "   ✅ Token CSRF trouvé dans la page: " . substr($csrfToken, 0, 20) . "...\n";
        } else {
            echo "   ⚠️ Token CSRF non trouvé dans la page\n";
        }
    } else {
        echo "   ❌ Page de connexion non accessible (GET)\n";
    }
    
    // Simuler une vraie requête POST avec le bon token CSRF
    echo "\n3️⃣ Test de connexion (POST) avec token CSRF valide...\n";
    
    $postRequest = \Illuminate\Http\Request::create('/login', 'POST', [
        'email' => 'admin@restaurant-test.ci',
        'password' => 'password',
        '_token' => $token
    ]);
    
    // Ajouter les headers appropriés
    $postRequest->headers->set('Accept', 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8');
    $postRequest->headers->set('Accept-Language', 'fr,fr-fr;q=0.8,en-us;q=0.5,en;q=0.3');
    $postRequest->headers->set('Accept-Encoding', 'gzip, deflate');
    $postRequest->headers->set('Connection', 'keep-alive');
    $postRequest->headers->set('Upgrade-Insecure-Requests', '1');
    
    $postResponse = $app->handle($postRequest);
    echo "   ✅ Requête POST traitée\n";
    echo "   Status: " . $postResponse->getStatusCode() . "\n";
    
    if ($postResponse->getStatusCode() === 302) {
        echo "   ✅ Redirection après connexion réussie\n";
        $location = $postResponse->headers->get('Location');
        echo "   Redirection vers: " . $location . "\n";
    } else {
        echo "   ⚠️ Pas de redirection (Status: " . $postResponse->getStatusCode() . ")\n";
        
        // Vérifier le contenu de la réponse
        $content = $postResponse->getContent();
        if (strpos($content, 'Les identifiants fournis ne correspondent pas') !== false) {
            echo "   ❌ Erreur d'identifiants\n";
        } elseif (strpos($content, 'Une erreur est survenue') !== false) {
            echo "   ❌ Erreur générale\n";
        } else {
            echo "   ℹ️ Contenu de la réponse: " . substr($content, 0, 200) . "...\n";
        }
    }
    
    // Test de la page d'inscription
    echo "\n4️⃣ Test de la page d'inscription (GET)...\n";
    
    $registerGetRequest = \Illuminate\Http\Request::create('/register', 'GET');
    $registerGetResponse = $app->handle($registerGetRequest);
    
    if ($registerGetResponse->getStatusCode() === 200) {
        echo "   ✅ Page d'inscription accessible (GET)\n";
    } else {
        echo "   ❌ Page d'inscription non accessible (GET)\n";
    }
    
    // Test d'inscription (POST)
    echo "\n5️⃣ Test d'inscription (POST)...\n";
    
    $registerPostRequest = \Illuminate\Http\Request::create('/register', 'POST', [
        'name' => 'Test User',
        'email' => 'test' . time() . '@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'account_type' => 'customer',
        '_token' => $token
    ]);
    
    $registerPostResponse = $app->handle($registerPostRequest);
    echo "   ✅ Requête d'inscription traitée\n";
    echo "   Status: " . $registerPostResponse->getStatusCode() . "\n";
    
    if ($registerPostResponse->getStatusCode() === 302) {
        echo "   ✅ Redirection après inscription réussie\n";
        $location = $registerPostResponse->headers->get('Location');
        echo "   Redirection vers: " . $location . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "Fichier: " . $e->getFile() . "\n";
    echo "Ligne: " . $e->getLine() . "\n";
}

echo "\n🎯 TEST TERMINÉ\n";
?> 