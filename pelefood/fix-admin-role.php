<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use Spatie\Permission\Models\Role;

// Initialiser Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CORRECTION DU RÔLE SUPER ADMIN ===\n\n";

// Vérifier que le rôle super_admin existe
$superAdminRole = Role::where('name', 'super_admin')->first();

if (!$superAdminRole) {
    echo "❌ Le rôle 'super_admin' n'existe pas\n";
    echo "   Création du rôle...\n";
    $superAdminRole = Role::create(['name' => 'super_admin']);
    echo "   ✅ Rôle 'super_admin' créé\n";
} else {
    echo "✅ Rôle 'super_admin' trouvé\n";
}

// Trouver le Super Admin
$superAdmin = User::where('email', 'admin@pelefood.ci')->first();

if ($superAdmin) {
    echo "✅ Super Admin trouvé: {$superAdmin->name}\n";
    
    // Supprimer tous les rôles existants
    $superAdmin->syncRoles([]);
    echo "   🔄 Rôles existants supprimés\n";
    
    // Assigner le rôle super_admin
    $superAdmin->assignRole($superAdminRole);
    echo "   ✅ Rôle 'super_admin' assigné\n";
    
    // Vérifier
    $roles = $superAdmin->roles->pluck('name')->implode(', ');
    echo "   📋 Rôles actuels: {$roles}\n";
    
} else {
    echo "❌ Super Admin non trouvé\n";
}

echo "\n=== FIN DE LA CORRECTION ===\n"; 