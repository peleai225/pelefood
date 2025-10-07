<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔐 TEST DE CONNEXION AVEC L'UTILISATEUR TEST\n";
echo "============================================\n\n";

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
        
        // Vérifier que l'utilisateur est bien connecté
        if (\Auth::check()) {
            $user = \Auth::user();
            echo "   ✅ Utilisateur connecté: " . $user->email . " (rôle: " . $user->role . ")\n";
        } else {
            echo "   ❌ Utilisateur non connecté\n";
        }
        
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
    
    // Vérifier que l'utilisateur existe et que le mot de passe est correct
    echo "\n3️⃣ Vérification de l'utilisateur test@pelefood.com...\n";
    
    $user = \App\Models\User::where('email', 'test@pelefood.com')->first();
    if ($user) {
        echo "   ✅ Utilisateur trouvé: " . $user->email . " (rôle: " . $user->role . ")\n";
        
        // Vérifier le hash du mot de passe
        if (\Hash::check('test123', $user->password)) {
            echo "   ✅ Mot de passe correct\n";
        } else {
            echo "   ❌ Mot de passe incorrect\n";
            echo "   Hash stocké: " . $user->password . "\n";
            echo "   Hash du mot de passe 'test123': " . \Hash::make('test123') . "\n";
        }
    } else {
        echo "   ❌ Utilisateur non trouvé: test@pelefood.com\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "Fichier: " . $e->getFile() . "\n";
    echo "Ligne: " . $e->getLine() . "\n";
}

echo "\n🎯 TEST TERMINÉ\n";
?> 