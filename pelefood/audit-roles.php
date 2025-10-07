<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== AUDIT DES RÔLES ACTUELS ===\n\n";

// 1. Lister les rôles existants
echo "1. Rôles actuels dans la table users:\n";
$roles = \App\Models\User::select('role')->distinct()->pluck('role');
foreach ($roles as $role) {
    echo "   - $role\n";
}

echo "\n2. Nombre d'utilisateurs par rôle:\n";
$roleCounts = \App\Models\User::select('role', \DB::raw('count(*) as count'))
    ->groupBy('role')
    ->get();
foreach ($roleCounts as $roleCount) {
    echo "   - {$roleCount->role}: {$roleCount->count} utilisateurs\n";
}

echo "\n3. Vérification de la structure de la table users:\n";
$columns = \DB::select("DESCRIBE users");
foreach ($columns as $column) {
    if ($column->Field === 'role') {
        echo "   - Champ 'role' trouvé: {$column->Type}\n";
        break;
    }
}

echo "\n4. Vérification des tables Spatie:\n";
$spatieTables = ['roles', 'permissions', 'model_has_roles', 'model_has_permissions'];
foreach ($spatieTables as $table) {
    try {
        $exists = \DB::select("SHOW TABLES LIKE '$table'");
        if (count($exists) > 0) {
            echo "   - Table '$table': EXISTE\n";
        } else {
            echo "   - Table '$table': N'EXISTE PAS\n";
        }
    } catch (Exception $e) {
        echo "   - Table '$table': ERREUR - " . $e->getMessage() . "\n";
    }
}

echo "\n5. Vérification du modèle User:\n";
$userModel = new \App\Models\User();
if (method_exists($userModel, 'hasRole')) {
    echo "   - Trait HasRoles: PRÉSENT\n";
} else {
    echo "   - Trait HasRoles: ABSENT\n";
}

echo "\n6. Vérification de la table restaurants:\n";
try {
    $restaurants = \DB::table('restaurants')->count();
    echo "   - Table 'restaurants': EXISTE ($restaurants restaurants)\n";
} catch (Exception $e) {
    echo "   - Table 'restaurants': N'EXISTE PAS\n";
}

echo "\n7. Vérification des colonnes de la table users:\n";
$userColumns = \DB::select("DESCRIBE users");
foreach ($userColumns as $column) {
    if (in_array($column->Field, ['restaurant_id', 'plan', 'subscription_status'])) {
        echo "   - {$column->Field}: {$column->Type}\n";
    }
}

echo "\n=== AUDIT TERMINÉ ===\n";
