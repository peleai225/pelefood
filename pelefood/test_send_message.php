<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Notifications\BulkNotification;

// Créer un message de test
$users = User::take(2)->get();

foreach ($users as $index => $user) {
    $user->notify(new BulkNotification(
        'Test Message System ' . ($index + 1),
        'Ceci est un message de test pour vérifier que le système de messagerie fonctionne correctement. Vous pouvez maintenant envoyer des messages à vos utilisateurs via le backoffice !'
    ));
}

echo "Messages de test créés pour " . $users->count() . " utilisateurs.\n";
echo "Total notifications: " . Illuminate\Notifications\DatabaseNotification::count() . "\n";
echo "Vous pouvez maintenant accéder à http://127.0.0.1:8000/admin/send-notification pour envoyer des messages !\n";
