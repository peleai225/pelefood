<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔍 TEST ULTRA-SIMPLE DU BOUTON\n";
echo "==============================\n\n";

try {
    // Test 1: Vérifier que le formulaire HTML est généré correctement
    echo "1️⃣ Test de génération du formulaire HTML...\n";
    
    $getRequest = \Illuminate\Http\Request::create('/login-debug', 'GET');
    $getResponse = $app->handle($getRequest);
    
    if ($getResponse->getStatusCode() === 200) {
        echo "   ✅ Page chargée (Status 200)\n";
        
        $content = $getResponse->getContent();
        
        // Vérifier la présence du bouton
        if (strpos($content, 'id="submitBtn"') !== false) {
            echo "   ✅ Bouton submit trouvé avec id='submitBtn'\n";
        } else {
            echo "   ❌ Bouton submit NON trouvé\n";
        }
        
        // Vérifier le type du bouton
        if (strpos($content, 'type="submit"') !== false) {
            echo "   ✅ Bouton a bien type='submit'\n";
        } else {
            echo "   ❌ Bouton n'a PAS type='submit'\n";
        }
        
        // Vérifier que le bouton est dans le formulaire
        if (strpos($content, '<form') !== false && strpos($content, '</form>') !== false) {
            echo "   ✅ Formulaire HTML valide\n";
            
            // Extraire le formulaire pour analyse
            preg_match('/<form[^>]*>.*?<\/form>/s', $content, $matches);
            if (!empty($matches[0])) {
                $form = $matches[0];
                echo "   📝 Formulaire extrait:\n";
                echo "   " . str_replace("\n", "\n   ", substr($form, 0, 300)) . "...\n";
            }
        } else {
            echo "   ❌ Formulaire HTML invalide\n";
        }
        
        // Vérifier les attributs du bouton
        if (strpos($content, 'disabled') !== false) {
            echo "   ⚠️ Bouton a l'attribut 'disabled'\n";
        } else {
            echo "   ✅ Bouton n'est pas désactivé\n";
        }
        
        // Vérifier les classes CSS du bouton
        if (strpos($content, 'class=') !== false) {
            echo "   ✅ Bouton a des classes CSS\n";
        } else {
            echo "   ⚠️ Bouton n'a pas de classes CSS\n";
        }
        
    } else {
        echo "   ❌ Page non chargée (Status: " . $getResponse->getStatusCode() . ")\n";
    }
    
    // Test 2: Vérifier que le JavaScript est bien chargé
    echo "\n2️⃣ Test du JavaScript...\n";
    
    if (strpos($content, '<script>') !== false) {
        echo "   ✅ Balise script trouvée\n";
        
        // Vérifier la présence des fonctions JavaScript
        if (strpos($content, 'addEventListener') !== false) {
            echo "   ✅ addEventListener trouvé\n";
        } else {
            echo "   ❌ addEventListener NON trouvé\n";
        }
        
        if (strpos($content, 'preventDefault') !== false) {
            echo "   ✅ preventDefault trouvé\n";
        } else {
            echo "   ❌ preventDefault NON trouvé\n";
        }
        
        if (strpos($content, 'fetch(') !== false) {
            echo "   ✅ fetch() trouvé\n";
        } else {
            echo "   ❌ fetch() NON trouvé\n";
        }
        
    } else {
        echo "   ❌ Aucune balise script trouvée\n";
    }
    
    // Test 3: Vérifier les routes
    echo "\n3️⃣ Test des routes...\n";
    
    $routes = $app['router']->getRoutes();
    $loginRoute = null;
    $loginDebugRoute = null;
    
    foreach ($routes as $route) {
        if ($route->uri() === 'login' && in_array('POST', $route->methods())) {
            $loginRoute = $route;
        }
        if ($route->uri() === 'login-debug' && in_array('GET', $route->methods())) {
            $loginDebugRoute = $route;
        }
    }
    
    if ($loginRoute) {
        echo "   ✅ Route POST /login trouvée\n";
        echo "     Action: " . $loginRoute->getActionName() . "\n";
    } else {
        echo "   ❌ Route POST /login NON trouvée\n";
    }
    
    if ($loginDebugRoute) {
        echo "   ✅ Route GET /login-debug trouvée\n";
    } else {
        echo "   ❌ Route GET /login-debug NON trouvée\n";
    }
    
    // Test 4: Vérifier la structure du DOM
    echo "\n4️⃣ Analyse de la structure du DOM...\n";
    
    // Vérifier que le bouton est bien dans le formulaire
    if (strpos($content, 'id="debugForm"') !== false) {
        echo "   ✅ Formulaire avec id='debugForm' trouvé\n";
        
        // Vérifier la séquence: form -> button
        $formStart = strpos($content, 'id="debugForm"');
        $buttonStart = strpos($content, 'id="submitBtn"');
        
        if ($formStart !== false && $buttonStart !== false) {
            if ($buttonStart > $formStart) {
                echo "   ✅ Bouton est bien après le formulaire (structure correcte)\n";
            } else {
                echo "   ❌ Bouton est AVANT le formulaire (structure incorrecte)\n";
            }
        }
        
    } else {
        echo "   ❌ Formulaire avec id='debugForm' NON trouvé\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "Fichier: " . $e->getFile() . "\n";
    echo "Ligne: " . $e->getLine() . "\n";
}

echo "\n🎯 TEST TERMINÉ\n";
?> 