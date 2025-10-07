<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🧪 TEST D'INSCRIPTION EN TEMPS RÉEL\n";
echo "====================================\n\n";

try {
    // 1. Vérifier que le serveur fonctionne
    echo "1️⃣ Test de connexion au serveur...\n";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/register');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        echo "   ✅ Serveur accessible (HTTP $httpCode)\n";
    } else {
        echo "   ❌ Serveur inaccessible (HTTP $httpCode)\n";
        exit(1);
    }
    
    // 2. Extraire le token CSRF
    echo "\n2️⃣ Extraction du token CSRF...\n";
    
    preg_match('/<input type="hidden" name="_token" value="([^"]+)">/', $response, $matches);
    if (isset($matches[1])) {
        $csrfToken = $matches[1];
        echo "   ✅ Token CSRF trouvé: " . substr($csrfToken, 0, 10) . "...\n";
    } else {
        echo "   ❌ Token CSRF non trouvé\n";
        exit(1);
    }
    
    // 3. Test d'inscription
    echo "\n3️⃣ Test d'inscription...\n";
    
    $postData = [
        'name' => 'Test User Debug',
        'email' => 'test-debug-' . time() . '@test.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'account_type' => 'customer',
        'terms' => 'on',
        '_token' => $csrfToken
    ];
    
    echo "   📝 Données à envoyer:\n";
    foreach ($postData as $key => $value) {
        if ($key !== '_token') {
            echo "      - $key: $value\n";
        } else {
            echo "      - _token: " . substr($value, 0, 10) . "...\n";
        }
    }
    
    // Envoyer la requête POST
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/register');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
        'User-Agent: Test-Script/1.0'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    
    echo "\n   📡 Réponse du serveur:\n";
    echo "      - Code HTTP: $httpCode\n";
    echo "      - URL finale: $finalUrl\n";
    
    // Analyser la réponse
    if ($httpCode === 302 || $httpCode === 200) {
        echo "   ✅ Inscription réussie (redirection ou succès)\n";
        
        // Vérifier si l'utilisateur a été créé en base
        $user = \App\Models\User::where('email', $postData['email'])->first();
        if ($user) {
            echo "   ✅ Utilisateur créé en base de données:\n";
            echo "      - ID: {$user->id}\n";
            echo "      - Nom: {$user->name}\n";
            echo "      - Email: {$user->email}\n";
            echo "      - Rôle: {$user->role}\n";
            echo "      - Statut: {$user->status}\n";
            
            // Vérifier les rôles Spatie
            if ($user->hasRole('customer')) {
                echo "   ✅ Rôle customer assigné correctement\n";
            } else {
                echo "   ❌ Rôle customer non assigné\n";
            }
            
            // Nettoyer
            $user->delete();
            echo "   🧹 Utilisateur de test supprimé\n";
            
        } else {
            echo "   ❌ Utilisateur non trouvé en base de données\n";
        }
        
    } else {
        echo "   ❌ Échec de l'inscription\n";
        
        // Extraire les erreurs de validation
        if (preg_match('/<div class="text-red-600[^>]*>([^<]+)<\/div>/', $response, $errorMatches)) {
            echo "   ❌ Erreur: " . trim($errorMatches[1]) . "\n";
        }
        
        // Afficher la réponse complète pour debug
        echo "\n   📄 Réponse complète:\n";
        echo "   " . str_repeat("-", 50) . "\n";
        echo substr($response, 0, 1000) . "\n";
        if (strlen($response) > 1000) {
            echo "... (tronqué)\n";
        }
        echo "   " . str_repeat("-", 50) . "\n";
    }
    
    // 4. Vérifier les logs Laravel
    echo "\n4️⃣ Vérification des logs...\n";
    
    $logFile = storage_path('logs/laravel.log');
    if (file_exists($logFile)) {
        $logs = file_get_contents($logFile);
        $recentLogs = array_slice(explode("\n", $logs), -20);
        
        echo "   📋 Derniers logs (20 dernières lignes):\n";
        foreach ($recentLogs as $log) {
            if (trim($log) && (strpos($log, 'RegisterController') !== false || strpos($log, 'User') !== false)) {
                echo "      " . trim($log) . "\n";
            }
        }
    } else {
        echo "   ❌ Fichier de log non trouvé\n";
    }
    
    echo "\n🎉 TEST TERMINÉ !\n";
    
} catch (Exception $e) {
    echo "\n💥 ERREUR: " . $e->getMessage() . "\n";
    echo "Fichier: " . $e->getFile() . "\n";
    echo "Ligne: " . $e->getLine() . "\n";
} 