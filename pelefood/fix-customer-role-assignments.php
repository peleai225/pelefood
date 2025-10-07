<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CORRECTION DES ASSIGNATIONS DE RÔLES ===\n\n";

// 1. Identifier les assignations incorrectes
echo "1. Assignations incorrectes trouvées:\n";
$incorrectAssignments = \DB::table('model_has_roles')
    ->join('users', 'model_has_roles.model_id', '=', 'users.id')
    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
    ->where('users.role', 'customer')
    ->where('roles.name', 'restaurant')
    ->get();

foreach ($incorrectAssignments as $assignment) {
    $user = \App\Models\User::find($assignment->model_id);
    echo "   - User: {$user->email} (customer) a le rôle 'restaurant' - INCORRECT\n";
}

// 2. Supprimer les assignations incorrectes
echo "\n2. Suppression des assignations incorrectes:\n";
$deletedCount = \DB::table('model_has_roles')
    ->join('users', 'model_has_roles.model_id', '=', 'users.id')
    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
    ->where('users.role', 'customer')
    ->where('roles.name', 'restaurant')
    ->delete();

echo "   Supprimées: $deletedCount assignations incorrectes\n";

// 3. Vérifier les assignations restantes
echo "\n3. Assignations restantes:\n";
$remainingAssignments = \DB::table('model_has_roles')
    ->join('users', 'model_has_roles.model_id', '=', 'users.id')
    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
    ->get();

foreach ($remainingAssignments as $assignment) {
    echo "   - User: {$assignment->email} ({$assignment->role}) -> Rôle: {$assignment->name}\n";
}

// 4. Vérifier la cohérence
echo "\n4. Vérification de la cohérence:\n";
$users = \App\Models\User::all();
foreach ($users as $user) {
    $spatieRoles = \DB::table('model_has_roles')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->where('model_has_roles.model_id', $user->id)
        ->pluck('roles.name')
        ->toArray();
    
    echo "   - {$user->email} ({$user->role}) -> Spatie: [" . implode(', ', $spatieRoles) . "]\n";
}

echo "\n✅ Correction des assignations terminée!\n";
echo "\n=== CORRECTION TERMINÉE ===\n";
