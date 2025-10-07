<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Test du système de profil:\n";

// Test 1: Vérifier la structure de la table users
echo "1. Vérification des colonnes de la table users:\n";
$columns = DB::select("SHOW COLUMNS FROM users");
foreach ($columns as $column) {
    echo "   - " . $column->Field . " (" . $column->Type . ")\n";
}

// Test 2: Vérifier un utilisateur
echo "\n2. Test d'un utilisateur:\n";
$user = App\Models\User::first();
if ($user) {
    echo "   Utilisateur trouvé: " . $user->name . "\n";
    echo "   Email: " . $user->email . "\n";
    echo "   Avatar: " . ($user->avatar ?? 'null') . "\n";
    echo "   Bio: " . ($user->bio ?? 'null') . "\n";
} else {
    echo "   Aucun utilisateur trouvé\n";
}

// Test 3: Vérifier le dossier storage
echo "\n3. Test du dossier storage:\n";
$storagePath = storage_path('app/public/avatars');
if (is_dir($storagePath)) {
    echo "   Dossier avatars existe: " . $storagePath . "\n";
    $files = scandir($storagePath);
    echo "   Fichiers dans le dossier: " . count($files) - 2 . " (excluant . et ..)\n";
} else {
    echo "   Dossier avatars n'existe pas\n";
}

// Test 4: Vérifier le lien symbolique
echo "\n4. Test du lien symbolique:\n";
$publicPath = public_path('storage');
if (is_link($publicPath)) {
    echo "   Lien symbolique existe: " . $publicPath . "\n";
    echo "   Pointe vers: " . readlink($publicPath) . "\n";
} else {
    echo "   Lien symbolique n'existe pas\n";
}

echo "\nTest terminé.\n";
