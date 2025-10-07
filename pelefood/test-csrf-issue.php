<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔍 DIAGNOSTIC DU PROBLÈME CSRF\n";
echo "==============================\n\n";

try {
    // Test 1: Charger la page ultra-simple
    echo "1️⃣ Chargement de la page ultra-simple...\n";
    
    $getRequest = \Illuminate\Http\Request::create('/login-ultra-simple', 'GET');
    $getResponse = $app->handle($getRequest);
    
    if ($getResponse->getStatusCode() === 200) {
        echo "   ✅ Page chargée (Status 200)\n";
        
        $content = $getResponse->getContent();
        
        // Analyser le formulaire 1 spécifiquement
        echo "\n2️⃣ Analyse du Formulaire 1 (bouton orange qui ne marche pas)...\n";
        
        // Extraire le formulaire 1
        preg_match('/<!-- Test 1: Formulaire normal -->(.*?)<!-- Test 2:/s', $content, $matches);
        if (!empty($matches[1])) {
            $form1 = $matches[1];
            echo "   📝 Formulaire 1 extrait:\n";
            echo "   " . str_replace("\n", "\n   ", substr($form1, 0, 500)) . "...\n";
            
            // Vérifier la présence de @csrf
            if (strpos($form1, '@csrf') !== false) {
                echo "   ✅ @csrf trouvé dans le formulaire\n";
            } else {
                echo "   ❌ @csrf MANQUANT dans le formulaire\n";
            }
            
            // Vérifier method="POST"
            if (strpos($form1, 'method="POST"') !== false) {
                echo "   ✅ method='POST' trouvé\n";
            } else {
                echo "   ❌ method='POST' MANQUANT\n";
            }
            
            // Vérifier l'action
            if (strpos($form1, 'action="{{ route(\'login.post\') }}"') !== false) {
                echo "   ✅ action correcte trouvée\n";
            } else {
                echo "   ❌ action incorrecte ou manquante\n";
            }
            
            // Vérifier le bouton
            if (strpos($form1, '<button type="submit"') !== false) {
                echo "   ✅ Bouton button type='submit' trouvé\n";
            } else {
                echo "   ❌ Bouton button type='submit' MANQUANT\n";
            }
            
        } else {
            echo "   ❌ Formulaire 1 non extrait\n";
        }
        
        // Comparer avec le formulaire 2 qui fonctionne
        echo "\n3️⃣ Comparaison avec le Formulaire 2 (bouton bleu qui marche)...\n";
        
        preg_match('/<!-- Test 2: Formulaire avec bouton simple -->(.*?)<!-- Test 3:/s', $content, $matches);
        if (!empty($matches[1])) {
            $form2 = $matches[1];
            
            // Vérifier la présence de @csrf
            if (strpos($form2, '@csrf') !== false) {
                echo "   ✅ @csrf trouvé dans le formulaire 2\n";
            } else {
                echo "   ❌ @csrf MANQUANT dans le formulaire 2\n";
            }
            
            // Vérifier method="POST"
            if (strpos($form2, 'method="POST"') !== false) {
                echo "   ✅ method='POST' trouvé dans le formulaire 2\n";
            } else {
                echo "   ❌ method='POST' MANQUANT dans le formulaire 2\n";
            }
            
            // Vérifier l'action
            if (strpos($form2, 'action="{{ route(\'login.post\') }}"') !== false) {
                echo "   ✅ action correcte trouvée dans le formulaire 2\n";
            } else {
                echo "   ❌ action incorrecte ou manquante dans le formulaire 2\n";
            }
            
            // Vérifier le bouton
            if (strpos($form2, '<input type="submit"') !== false) {
                echo "   ✅ Bouton input type='submit' trouvé dans le formulaire 2\n";
            } else {
                echo "   ❌ Bouton input type='submit' MANQUANT dans le formulaire 2\n";
            }
            
        } else {
            echo "   ❌ Formulaire 2 non extrait\n";
        }
        
        // Test 4: Vérifier la génération des tokens CSRF
        echo "\n4️⃣ Test de génération des tokens CSRF...\n";
        
        $session = $app->make('session');
        $session->start();
        
        $token1 = $session->token();
        echo "   ✅ Token CSRF 1 généré: " . substr($token1, 0, 20) . "...\n";
        
        // Simuler une nouvelle session
        $session->regenerate();
        $token2 = $session->token();
        echo "   ✅ Token CSRF 2 généré: " . substr($token2, 0, 20) . "...\n";
        
        if ($token1 !== $token2) {
            echo "   ✅ Tokens différents (régénération OK)\n";
        } else {
            echo "   ❌ Tokens identiques (problème de régénération)\n";
        }
        
        // Test 5: Vérifier la configuration CSRF
        echo "\n5️⃣ Configuration CSRF...\n";
        
        $csrfConfig = config('session');
        echo "   Driver: " . $csrfConfig['driver'] . "\n";
        echo "   Lifetime: " . $csrfConfig['lifetime'] . " minutes\n";
        echo "   Expire on close: " . ($csrfConfig['expire_on_close'] ? 'Oui' : 'Non') . "\n";
        
        // Test 6: Vérifier les middlewares
        echo "\n6️⃣ Middlewares de la route login...\n";
        
        $routes = $app['router']->getRoutes();
        $loginRoute = null;
        
        foreach ($routes as $route) {
            if ($route->uri() === 'login' && in_array('POST', $route->methods())) {
                $loginRoute = $route;
                break;
            }
        }
        
        if ($loginRoute) {
            echo "   ✅ Route POST /login trouvée\n";
            echo "   Middlewares: " . implode(', ', $loginRoute->middleware()) . "\n";
            
            // Vérifier si VerifyCsrfToken est présent
            if (in_array('web', $loginRoute->middleware())) {
                echo "   ✅ Middleware 'web' présent (inclut CSRF)\n";
            } else {
                echo "   ❌ Middleware 'web' MANQUANT\n";
            }
            
        } else {
            echo "   ❌ Route POST /login NON trouvée\n";
        }
        
    } else {
        echo "   ❌ Page non chargée (Status: " . $getResponse->getStatusCode() . ")\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "Fichier: " . $e->getFile() . "\n";
    echo "Ligne: " . $e->getLine() . "\n";
}

echo "\n🎯 DIAGNOSTIC TERMINÉ\n";
echo "\n💡 L'erreur 419 indique un problème CSRF.\n";
echo "   Vérifions que tous les formulaires ont @csrf et method='POST'.\n";
?> 