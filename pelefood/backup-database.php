<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== SAUVEGARDE DE LA BASE DE DONNÉES ===\n\n";

// Configuration de la base de données
$host = env('DB_HOST', '127.0.0.1');
$port = env('DB_PORT', '3306');
$database = env('DB_DATABASE', 'pelefood');
$username = env('DB_USERNAME', 'root');
$password = env('DB_PASSWORD', '');

echo "Configuration de la base de données:\n";
echo "Host: $host\n";
echo "Port: $port\n";
echo "Database: $database\n";
echo "Username: $username\n\n";

// Créer le dossier de sauvegarde
$backupDir = 'backups';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
    echo "Dossier de sauvegarde créé: $backupDir\n";
}

// Nom du fichier de sauvegarde
$timestamp = date('Y-m-d_H-i-s');
$backupFile = "$backupDir/pelefood_backup_$timestamp.sql";

echo "Création de la sauvegarde: $backupFile\n";

// Commande mysqldump
$command = "mysqldump -h $host -P $port -u $username";
if (!empty($password)) {
    $command .= " -p$password";
}
$command .= " $database > $backupFile";

echo "Exécution de la commande: $command\n\n";

// Exécuter la commande
$output = [];
$returnCode = 0;
exec($command, $output, $returnCode);

if ($returnCode === 0) {
    echo "✅ Sauvegarde créée avec succès!\n";
    echo "Fichier: $backupFile\n";
    
    // Vérifier la taille du fichier
    if (file_exists($backupFile)) {
        $fileSize = filesize($backupFile);
        echo "Taille: " . number_format($fileSize / 1024, 2) . " KB\n";
    }
} else {
    echo "❌ Erreur lors de la création de la sauvegarde\n";
    echo "Code de retour: $returnCode\n";
    echo "Sortie: " . implode("\n", $output) . "\n";
}

echo "\n=== SAUVEGARDE TERMINÉE ===\n";
