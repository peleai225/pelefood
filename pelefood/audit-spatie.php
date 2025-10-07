<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== AUDIT SPATIE PERMISSION ===\n\n";

// 1. Vérifier si Spatie est installé
echo "1. Vérification du package Spatie:\n";
if (class_exists('Spatie\Permission\PermissionServiceProvider')) {
    echo "   - Package Spatie Permission: INSTALLÉ\n";
} else {
    echo "   - Package Spatie Permission: NON INSTALLÉ\n";
}

// 2. Vérifier les tables Spatie
echo "\n2. Vérification des tables Spatie:\n";
$spatieTables = ['roles', 'permissions', 'model_has_roles', 'model_has_permissions'];
foreach ($spatieTables as $table) {
    try {
        $exists = \DB::select("SHOW TABLES LIKE '$table'");
        if (count($exists) > 0) {
            $count = \DB::table($table)->count();
            echo "   - Table '$table': EXISTE ($count enregistrements)\n";
        } else {
            echo "   - Table '$table': N'EXISTE PAS\n";
        }
    } catch (Exception $e) {
        echo "   - Table '$table': ERREUR - " . $e->getMessage() . "\n";
    }
}

// 3. Vérifier le modèle User
echo "\n3. Vérification du modèle User:\n";
$userModel = new \App\Models\User();
if (method_exists($userModel, 'hasRole')) {
    echo "   - Trait HasRoles: PRÉSENT\n";
} else {
    echo "   - Trait HasRoles: ABSENT\n";
}

// 4. Vérifier les rôles existants dans Spatie
echo "\n4. Rôles existants dans Spatie:\n";
try {
    $roles = \DB::table('roles')->get();
    if ($roles->count() > 0) {
        foreach ($roles as $role) {
            echo "   - {$role->name} (ID: {$role->id})\n";
        }
    } else {
        echo "   - Aucun rôle dans Spatie\n";
    }
} catch (Exception $e) {
    echo "   - Erreur: " . $e->getMessage() . "\n";
}

// 5. Vérifier les permissions existantes
echo "\n5. Permissions existantes dans Spatie:\n";
try {
    $permissions = \DB::table('permissions')->get();
    if ($permissions->count() > 0) {
        foreach ($permissions as $permission) {
            echo "   - {$permission->name} (ID: {$permission->id})\n";
        }
    } else {
        echo "   - Aucune permission dans Spatie\n";
    }
} catch (Exception $e) {
    echo "   - Erreur: " . $e->getMessage() . "\n";
}

// 6. Vérifier les assignations de rôles
echo "\n6. Assignations de rôles existantes:\n";
try {
    $assignations = \DB::table('model_has_roles')->get();
    if ($assignations->count() > 0) {
        foreach ($assignations as $assignation) {
            echo "   - User ID {$assignation->model_id} a le rôle ID {$assignation->role_id}\n";
        }
    } else {
        echo "   - Aucune assignation de rôle\n";
    }
} catch (Exception $e) {
    echo "   - Erreur: " . $e->getMessage() . "\n";
}

echo "\n=== AUDIT SPATIE TERMINÉ ===\n";
