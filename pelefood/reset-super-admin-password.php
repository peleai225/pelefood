<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== RÉINITIALISATION DU MOT DE PASSE SUPER ADMIN ===\n\n";

// Récupérer le super admin
$superAdmin = \App\Models\User::whereHas('roles', function($query) {
    $query->where('name', 'super_admin');
})->first();

if ($superAdmin) {
    // Nouveau mot de passe
    $newPassword = 'admin123';
    
    // Mettre à jour le mot de passe
    $superAdmin->password = \Illuminate\Support\Facades\Hash::make($newPassword);
    $superAdmin->save();
    
    echo "✅ Mot de passe du Super Admin réinitialisé !\n\n";
    echo "📧 Email : {$superAdmin->email}\n";
    echo "🔑 Nouveau mot de passe : {$newPassword}\n";
    echo "👤 Nom : {$superAdmin->name}\n";
    
    echo "\n🌐 URLs de connexion :\n";
    echo "- Page principale : http://127.0.0.1:8000/login\n";
    echo "- Page de debug : http://127.0.0.1:8000/login-debug\n";
    echo "- Page corrigée : http://127.0.0.1:8000/login-fixed\n";
    
    echo "\n📋 Instructions de connexion :\n";
    echo "1. Aller sur http://127.0.0.1:8000/login\n";
    echo "2. Saisir l'email : {$superAdmin->email}\n";
    echo "3. Saisir le mot de passe : {$newPassword}\n";
    echo "4. Cliquer sur 'Se connecter'\n";
    echo "5. Redirection vers le dashboard super admin\n";
    
    echo "\n🔐 Rôles et permissions :\n";
    echo "- Rôle : super_admin\n";
    echo "- Toutes les permissions système\n";
    echo "- Accès complet à l'administration\n";
    
} else {
    echo "❌ Aucun super admin trouvé.\n";
}

echo "\n=== FIN DE LA RÉINITIALISATION ===\n";
