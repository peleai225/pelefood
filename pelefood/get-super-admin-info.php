<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== INFORMATIONS DE CONNEXION SUPER ADMIN ===\n\n";

// Récupérer le super admin
$superAdmin = \App\Models\User::whereHas('roles', function($query) {
    $query->where('name', 'super_admin');
})->first();

if ($superAdmin) {
    echo "✅ Super Admin trouvé :\n";
    echo "📧 Email : {$superAdmin->email}\n";
    echo "👤 Nom : {$superAdmin->name}\n";
    echo "🆔 ID : {$superAdmin->id}\n";
    echo "📅 Créé le : {$superAdmin->created_at}\n";
    echo "🔄 Modifié le : {$superAdmin->updated_at}\n";
    
    echo "\n🔐 Rôles :\n";
    foreach ($superAdmin->roles as $role) {
        echo "- {$role->name}\n";
    }
    
    echo "\n🛡️ Permissions :\n";
    foreach ($superAdmin->getAllPermissions() as $permission) {
        echo "- {$permission->name}\n";
    }
    
    echo "\n🌐 URLs de connexion :\n";
    echo "- Page principale : http://127.0.0.1:8000/login\n";
    echo "- Page de debug : http://127.0.0.1:8000/login-debug\n";
    echo "- Page corrigée : http://127.0.0.1:8000/login-fixed\n";
    
    echo "\n📋 Instructions de connexion :\n";
    echo "1. Aller sur http://127.0.0.1:8000/login\n";
    echo "2. Saisir l'email : {$superAdmin->email}\n";
    echo "3. Saisir le mot de passe (demander au développeur)\n";
    echo "4. Cliquer sur 'Se connecter'\n";
    echo "5. Redirection vers le dashboard super admin\n";
    
} else {
    echo "❌ Aucun super admin trouvé.\n";
    echo "Création d'un super admin...\n";
    
    // Créer un super admin
    $superAdmin = \App\Models\User::create([
        'name' => 'Super Admin',
        'email' => 'superadmin@pelefood.ci',
        'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        'tenant_id' => 1, // Assumer qu'il y a un tenant par défaut
    ]);
    
    // Assigner le rôle super_admin
    $superAdmin->assignRole('super_admin');
    
    echo "✅ Super Admin créé :\n";
    echo "📧 Email : {$superAdmin->email}\n";
    echo "🔑 Mot de passe : password123\n";
    echo "👤 Nom : {$superAdmin->name}\n";
}

echo "\n=== FIN DES INFORMATIONS ===\n";
