<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔍 TEST DE LA ROUTE D'INSCRIPTION\n";
echo "=================================\n\n";

try {
    // Test de la route GET /register
    echo "1️⃣ Test de la route GET /register...\n";
    
    $request = \Illuminate\Http\Request::create('/register', 'GET');
    $response = $app->handle($request);
    
    echo "   Status: " . $response->getStatusCode() . "\n";
    
    if ($response->getStatusCode() === 200) {
        echo "   ✅ Route GET /register accessible\n";
        
        // Vérifier le contenu
        $content = $response->getContent();
        if (strpos($content, 'Créez votre compte') !== false) {
            echo "   ✅ Contenu de la page d'inscription trouvé\n";
        } else {
            echo "   ⚠️ Contenu de la page d'inscription non trouvé\n";
        }
        
        // Vérifier le token CSRF
        if (preg_match('/name="_token" value="([^"]+)"/', $content, $matches)) {
            echo "   ✅ Token CSRF trouvé\n";
        } else {
            echo "   ❌ Token CSRF non trouvé\n";
        }
        
    } else {
        echo "   ❌ Route GET /register non accessible\n";
        
        // Vérifier s'il y a une redirection
        if ($response->getStatusCode() === 302) {
            $location = $response->headers->get('Location');
            echo "   Redirection vers: " . $location . "\n";
        }
    }
    
    // Test de la route POST /register
    echo "\n2️⃣ Test de la route POST /register...\n";
    
    $postRequest = \Illuminate\Http\Request::create('/register', 'POST', [
        'name' => 'Test User',
        'email' => 'test' . time() . '@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'account_type' => 'customer'
    ]);
    
    $postResponse = $app->handle($postRequest);
    echo "   Status: " . $postResponse->getStatusCode() . "\n";
    
    if ($postResponse->getStatusCode() === 419) {
        echo "   ⚠️ Erreur CSRF (normal sans token)\n";
    } elseif ($postResponse->getStatusCode() === 302) {
        echo "   ✅ Inscription réussie avec redirection\n";
        $location = $postResponse->headers->get('Location');
        echo "   Redirection vers: " . $location . "\n";
    } else {
        echo "   ℹ️ Autre status: " . $postResponse->getStatusCode() . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "Fichier: " . $e->getFile() . "\n";
    echo "Ligne: " . $e->getLine() . "\n";
}

echo "\n🎯 TEST TERMINÉ\n";
?> 