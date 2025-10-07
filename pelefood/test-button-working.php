<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔍 ANALYSE DU BOUTON QUI FONCTIONNE\n";
echo "==================================\n\n";

try {
    // Test 1: Charger la page ultra-simple
    echo "1️⃣ Chargement de la page ultra-simple...\n";
    
    $getRequest = \Illuminate\Http\Request::create('/login-ultra-simple', 'GET');
    $getResponse = $app->handle($getRequest);
    
    if ($getResponse->getStatusCode() === 200) {
        echo "   ✅ Page chargée (Status 200)\n";
        
        $content = $getResponse->getContent();
        
        // Analyser les 3 formulaires
        echo "\n2️⃣ Analyse des 3 formulaires...\n";
        
        // Formulaire 1 (bouton button type="submit")
        if (strpos($content, 'Formulaire 1') !== false) {
            echo "   📋 Formulaire 1 (button type='submit'):\n";
            
            // Extraire le formulaire 1
            preg_match('/<!-- Test 1: Formulaire normal -->(.*?)<!-- Test 2:/s', $content, $matches);
            if (!empty($matches[1])) {
                $form1 = $matches[1];
                
                // Vérifier le bouton
                if (strpos($form1, 'type="submit"') !== false) {
                    echo "     ✅ Bouton a type='submit'\n";
                } else {
                    echo "     ❌ Bouton n'a PAS type='submit'\n";
                }
                
                if (strpos($form1, '<button') !== false) {
                    echo "     ✅ Utilise une balise <button>\n";
                } else {
                    echo "     ❌ N'utilise PAS une balise <button>\n";
                }
                
                // Vérifier l'action
                if (strpos($form1, 'action="{{ route(\'login.post\') }}"') !== false) {
                    echo "     ✅ Action correcte: login.post\n";
                } else {
                    echo "     ❌ Action incorrecte\n";
                }
                
            } else {
                echo "     ❌ Formulaire 1 non extrait\n";
            }
        }
        
        // Formulaire 2 (bouton bleu qui fonctionne - input type="submit")
        if (strpos($content, 'Formulaire 2') !== false) {
            echo "\n   📋 Formulaire 2 (input type='submit' - BOUTON QUI FONCTIONNE):\n";
            
            // Extraire le formulaire 2
            preg_match('/<!-- Test 2: Formulaire avec bouton simple -->(.*?)<!-- Test 3:/s', $content, $matches);
            if (!empty($matches[1])) {
                $form2 = $matches[1];
                
                // Vérifier le bouton
                if (strpos($form2, 'type="submit"') !== false) {
                    echo "     ✅ Bouton a type='submit'\n";
                } else {
                    echo "     ❌ Bouton n'a PAS type='submit'\n";
                }
                
                if (strpos($form2, '<input') !== false) {
                    echo "     ✅ Utilise une balise <input>\n";
                } else {
                    echo "     ❌ N'utilise PAS une balise <input>\n";
                }
                
                // Vérifier l'action
                if (strpos($form2, 'action="{{ route(\'login.post\') }}"') !== false) {
                    echo "     ✅ Action correcte: login.post\n";
                } else {
                    echo "     ❌ Action incorrecte\n";
                }
                
                // Vérifier les classes CSS
                if (strpos($form2, 'bg-blue-600') !== false) {
                    echo "     ✅ Couleur bleue détectée\n";
                } else {
                    echo "     ❌ Couleur bleue NON détectée\n";
                }
                
            } else {
                echo "     ❌ Formulaire 2 non extrait\n";
            }
        }
        
        // Formulaire 3 (bouton vert)
        if (strpos($content, 'Formulaire 3') !== false) {
            echo "\n   📋 Formulaire 3 (input type='submit'):\n";
            
            // Extraire le formulaire 3
            preg_match('/<!-- Test 3: Formulaire avec bouton sans style -->(.*?)<!-- Comptes de test -->/s', $content, $matches);
            if (!empty($matches[1])) {
                $form3 = $matches[1];
                
                // Vérifier le bouton
                if (strpos($form3, 'type="submit"') !== false) {
                    echo "     ✅ Bouton a type='submit'\n";
                } else {
                    echo "     ❌ Bouton n'a PAS type='submit'\n";
                }
                
                if (strpos($form3, '<input') !== false) {
                    echo "     ✅ Utilise une balise <input>\n";
                } else {
                    echo "     ❌ N'utilise PAS une balise <input>\n";
                }
                
                // Vérifier l'action
                if (strpos($form3, 'action="{{ route(\'login.post\') }}"') !== false) {
                    echo "     ✅ Action correcte: login.post\n";
                } else {
                    echo "     ❌ Action incorrecte\n";
                }
                
                // Vérifier les classes CSS
                if (strpos($form3, 'bg-green-600') !== false) {
                    echo "     ✅ Couleur verte détectée\n";
                } else {
                    echo "     ❌ Couleur verte NON détectée\n";
                }
                
            } else {
                echo "     ❌ Formulaire 3 non extrait\n";
            }
        }
        
        // Test 3: Comparaison des différences
        echo "\n3️⃣ Analyse des différences...\n";
        
        // Vérifier si tous les formulaires ont la même structure
        $forms = [];
        preg_match_all('/<form[^>]*>.*?<\/form>/s', $content, $forms);
        
        if (!empty($forms[0])) {
            echo "   📝 Nombre de formulaires trouvés: " . count($forms[0]) . "\n";
            
            foreach ($forms[0] as $index => $form) {
                echo "   Formulaire " . ($index + 1) . ":\n";
                echo "     Taille: " . strlen($form) . " caractères\n";
                echo "     Contient @csrf: " . (strpos($form, '@csrf') !== false ? 'Oui' : 'Non') . "\n";
                echo "     Contient method='POST': " . (strpos($form, "method='POST'") !== false ? 'Oui' : 'Non') . "\n";
                echo "     Contient action: " . (strpos($form, 'action=') !== false ? 'Oui' : 'Non') . "\n";
                
                // Vérifier le type de bouton
                if (strpos($form, '<button type="submit"') !== false) {
                    echo "     Type de bouton: <button type='submit'>\n";
                } elseif (strpos($form, '<input type="submit"') !== false) {
                    echo "     Type de bouton: <input type='submit'>\n";
                } else {
                    echo "     Type de bouton: Autre\n";
                }
            }
        }
        
        // Test 4: Vérification des routes
        echo "\n4️⃣ Vérification des routes...\n";
        
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
            echo "     Action: " . $loginRoute->getActionName() . "\n";
            echo "     Middlewares: " . implode(', ', $loginRoute->middleware()) . "\n";
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

echo "\n🎯 ANALYSE TERMINÉE\n";
echo "\n💡 CONCLUSION: Le bouton bleu (input type='submit') fonctionne,\n";
echo "   donc le problème vient probablement de la différence entre\n";
echo "   <button type='submit'> et <input type='submit'>\n";
?> 