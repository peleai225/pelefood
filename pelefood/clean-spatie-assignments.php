<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== NETTOYAGE DES ASSIGNATIONS SPATIE ===\n\n";

// 1. Lister les assignations actuelles
echo "1. Assignations de rôles actuelles:\n";
$assignments = \DB::table('model_has_roles')->get();
foreach ($assignments as $assignment) {
    $user = \App\Models\User::find($assignment->model_id);
    $role = \DB::table('roles')->where('id', $assignment->role_id)->first();
    if ($user && $role) {
        echo "   - User: {$user->email} ({$user->role}) -> Rôle: {$role->name}\n";
    } else {
        echo "   - User ID: {$assignment->model_id} -> Rôle ID: {$assignment->role_id} (ORPHELIN)\n";
    }
}

// 2. Supprimer les assignations orphelines
echo "\n2. Suppression des assignations orphelines:\n";
$userIds = \App\Models\User::pluck('id')->toArray();
$orphanedAssignments = \DB::table('model_has_roles')->whereNotIn('model_id', $userIds)->get();

if ($orphanedAssignments->count() > 0) {
    echo "   Assignations orphelines trouvées: {$orphanedAssignments->count()}\n";
    \DB::table('model_has_roles')->whereNotIn('model_id', $userIds)->delete();
    echo "   Supprimées: {$orphanedAssignments->count()} assignations\n";
} else {
    echo "   Aucune assignation orpheline trouvée.\n";
}

// 3. Vérifier les assignations restantes
echo "\n3. Assignations restantes:\n";
$remainingAssignments = \DB::table('model_has_roles')->get();
foreach ($remainingAssignments as $assignment) {
    $user = \App\Models\User::find($assignment->model_id);
    $role = \DB::table('roles')->where('id', $assignment->role_id)->first();
    if ($user && $role) {
        echo "   - User: {$user->email} ({$user->role}) -> Rôle: {$role->name}\n";
    }
}

// 4. Nettoyer les permissions orphelines
echo "\n4. Nettoyage des permissions orphelines:\n";
$orphanedPermissions = \DB::table('model_has_permissions')->whereNotIn('model_id', $userIds)->count();
if ($orphanedPermissions > 0) {
    \DB::table('model_has_permissions')->whereNotIn('model_id', $userIds)->delete();
    echo "   Supprimées: $orphanedPermissions permissions orphelines\n";
} else {
    echo "   Aucune permission orpheline trouvée.\n";
}

echo "\n✅ Nettoyage des assignations terminé!\n";
echo "\n=== NETTOYAGE TERMINÉ ===\n";
