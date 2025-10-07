<?php
// Test pour vérifier l'affichage de l'image de couverture
require_once 'vendor/autoload.php';

use App\Models\Restaurant;

// Démarrer Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🖼️ Test de l'image de couverture\n";
echo "================================\n\n";

// 1. Trouver un restaurant
$restaurant = Restaurant::first();
if (!$restaurant) {
    echo "❌ Aucun restaurant trouvé\n";
    exit(1);
}

echo "✅ Restaurant trouvé: " . $restaurant->name . "\n";

// 2. Vérifier l'image de couverture
echo "📸 Image de couverture:\n";
echo "   - Nom du fichier: " . ($restaurant->cover_image ?: 'Aucune') . "\n";
echo "   - URL complète: " . $restaurant->cover_image_url . "\n";

// 3. Vérifier si le fichier existe
if ($restaurant->cover_image) {
    $filePath = storage_path('app/public/' . $restaurant->cover_image);
    if (file_exists($filePath)) {
        echo "   - Fichier existe: ✅ Oui\n";
        echo "   - Taille: " . number_format(filesize($filePath) / 1024, 2) . " KB\n";
    } else {
        echo "   - Fichier existe: ❌ Non (chemin: $filePath)\n";
    }
} else {
    echo "   - Aucune image définie\n";
}

// 4. Tester l'URL publique
$publicUrl = $restaurant->cover_image_url;
echo "   - URL publique: $publicUrl\n";

// 5. Vérifier les autres images
echo "\n🖼️ Autres images:\n";
echo "   - Logo: " . ($restaurant->logo ?: 'Aucun') . "\n";
echo "   - Bannière: " . ($restaurant->banner_image ?: 'Aucune') . "\n";

echo "\n✅ Test terminé!\n";
