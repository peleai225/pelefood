<?php
// Test complet des paramètres du restaurant
require_once 'vendor/autoload.php';

use App\Models\Restaurant;
use App\Models\User;

// Démarrer Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔍 Analyse complète des paramètres du restaurant\n";
echo "===============================================\n\n";

// 1. Trouver un restaurant
$restaurant = Restaurant::first();
if (!$restaurant) {
    echo "❌ Aucun restaurant trouvé\n";
    exit(1);
}

echo "✅ Restaurant trouvé: " . $restaurant->name . "\n\n";

// 2. Informations générales
echo "📋 INFORMATIONS GÉNÉRALES:\n";
echo "   - Nom: " . ($restaurant->name ?: '❌ Manquant') . "\n";
echo "   - Slug: " . ($restaurant->slug ?: '❌ Manquant') . "\n";
echo "   - Description: " . ($restaurant->description ?: '❌ Manquante') . "\n";
echo "   - Slogan: " . ($restaurant->slogan ?: '❌ Manquant') . "\n";
echo "   - Site web: " . ($restaurant->website ?: '❌ Manquant') . "\n\n";

// 3. Informations de contact
echo "📞 INFORMATIONS DE CONTACT:\n";
echo "   - Téléphone: " . ($restaurant->phone ?: '❌ Manquant') . "\n";
echo "   - Email: " . ($restaurant->email ?: '❌ Manquant') . "\n";
echo "   - Adresse: " . ($restaurant->address ?: '❌ Manquante') . "\n";
echo "   - Ville: " . ($restaurant->city ?: '❌ Manquante') . "\n";
echo "   - Code postal: " . ($restaurant->postal_code ?: '❌ Manquant') . "\n";
echo "   - Pays: " . ($restaurant->country ?: '❌ Manquant') . "\n\n";

// 4. Images
echo "🖼️ IMAGES:\n";
echo "   - Logo: " . ($restaurant->logo ?: '❌ Manquant') . "\n";
echo "   - Image de couverture: " . ($restaurant->cover_image ?: '❌ Manquante') . "\n";
echo "   - Bannière: " . ($restaurant->banner_image ?: '❌ Manquante') . "\n";
echo "   - Galerie: " . (count($restaurant->gallery_images ?? []) . ' images') . "\n\n";

// 5. Paramètres de livraison
echo "🚚 PARAMÈTRES DE LIVRAISON:\n";
echo "   - Type de livraison: " . ($restaurant->delivery_type ?: '❌ Manquant') . "\n";
echo "   - Frais de livraison: " . ($restaurant->delivery_fee . ' ' . $restaurant->currency) . "\n";
echo "   - Délai de livraison: " . ($restaurant->delivery_time ?: '❌ Manquant') . " minutes\n";
echo "   - Rayon de livraison: " . ($restaurant->delivery_radius ?: '❌ Manquant') . " km\n";
echo "   - Temps de préparation: " . ($restaurant->preparation_time ?: '❌ Manquant') . " minutes\n";
echo "   - Commande minimum: " . ($restaurant->minimum_order . ' ' . $restaurant->currency) . "\n\n";

// 6. Zones de livraison
echo "🗺️ ZONES DE LIVRAISON:\n";
if ($restaurant->delivery_zones && count($restaurant->delivery_zones) > 0) {
    foreach ($restaurant->delivery_zones as $index => $zone) {
        echo "   Zone " . ($index + 1) . ":\n";
        echo "     - Nom: " . ($zone['name'] ?? '❌ Manquant') . "\n";
        echo "     - Frais: " . ($zone['fee'] ?? '❌ Manquant') . " " . $restaurant->currency . "\n";
        echo "     - Délai: " . ($zone['delivery_time'] ?? '❌ Manquant') . " minutes\n";
    }
} else {
    echo "   ❌ Aucune zone de livraison définie\n";
}
echo "\n";

// 7. Horaires d'ouverture
echo "🕒 HORAIRES D'OUVERTURE:\n";
if ($restaurant->opening_hours && count($restaurant->opening_hours) > 0) {
    $days = ['monday' => 'Lundi', 'tuesday' => 'Mardi', 'wednesday' => 'Mercredi', 
             'thursday' => 'Jeudi', 'friday' => 'Vendredi', 'saturday' => 'Samedi', 'sunday' => 'Dimanche'];
    
    foreach ($days as $key => $dayName) {
        if (isset($restaurant->opening_hours[$key])) {
            $hours = $restaurant->opening_hours[$key];
            $status = $hours['is_open'] ? 'Ouvert' : 'Fermé';
            $time = $hours['is_open'] ? $hours['open'] . ' - ' . $hours['close'] : '';
            echo "   - $dayName: $status $time\n";
        } else {
            echo "   - $dayName: ❌ Non défini\n";
        }
    }
} else {
    echo "   ❌ Aucun horaire défini\n";
}
echo "\n";

// 8. Devise et localisation
echo "💰 DEVISE ET LOCALISATION:\n";
echo "   - Devise: " . ($restaurant->currency ?: '❌ Manquante') . "\n";
echo "   - Fuseau horaire: " . ($restaurant->timezone ?: '❌ Manquant') . "\n";
echo "   - Langue: " . ($restaurant->language ?: '❌ Manquante') . "\n";
echo "   - Latitude: " . ($restaurant->latitude ?: '❌ Manquante') . "\n";
echo "   - Longitude: " . ($restaurant->longitude ?: '❌ Manquante') . "\n\n";

// 9. Couleurs de thème
echo "🎨 COULEURS DE THÈME:\n";
if ($restaurant->theme_colors && count($restaurant->theme_colors) > 0) {
    foreach ($restaurant->theme_colors as $color => $value) {
        echo "   - " . ucfirst($color) . ": " . ($value ?: '❌ Manquante') . "\n";
    }
} else {
    echo "   ❌ Aucune couleur de thème définie\n";
}
echo "\n";

// 10. Paramètres de notifications
echo "🔔 PARAMÈTRES DE NOTIFICATIONS:\n";
if ($restaurant->settings && isset($restaurant->settings['notifications'])) {
    $notifications = $restaurant->settings['notifications'];
    echo "   - Commandes: " . ($notifications['orders'] ? '✅ Activé' : '❌ Désactivé') . "\n";
    echo "   - Annulations: " . ($notifications['cancellations'] ? '✅ Activé' : '❌ Désactivé') . "\n";
    echo "   - Avis: " . ($notifications['reviews'] ? '✅ Activé' : '❌ Désactivé') . "\n";
    echo "   - Stock: " . ($notifications['stock'] ? '✅ Activé' : '❌ Désactivé') . "\n";
    
    if (isset($restaurant->settings['notification_methods'])) {
        $methods = $restaurant->settings['notification_methods'];
        echo "   - Push: " . ($methods['push'] ? '✅ Activé' : '❌ Désactivé') . "\n";
        echo "   - SMS: " . ($methods['sms'] ? '✅ Activé' : '❌ Désactivé') . "\n";
        echo "   - Email: " . ($methods['email'] ? '✅ Activé' : '❌ Désactivé') . "\n";
    }
} else {
    echo "   ❌ Aucun paramètre de notification défini\n";
}
echo "\n";

// 11. Statut et vérification
echo "✅ STATUT:\n";
echo "   - Actif: " . ($restaurant->is_active ? '✅ Oui' : '❌ Non') . "\n";
echo "   - Vérifié: " . ($restaurant->is_verified ? '✅ Oui' : '❌ Non') . "\n";
echo "   - Mis en avant: " . ($restaurant->is_featured ? '✅ Oui' : '❌ Non') . "\n";
echo "   - Ouvert: " . ($restaurant->is_open ? '✅ Oui' : '❌ Non') . "\n\n";

// 12. Réseaux sociaux
echo "📱 RÉSEAUX SOCIAUX:\n";
echo "   - Facebook: " . ($restaurant->facebook_url ?: '❌ Manquant') . "\n";
echo "   - Instagram: " . ($restaurant->instagram_url ?: '❌ Manquant') . "\n";
echo "   - Site web: " . ($restaurant->website_url ?: '❌ Manquant') . "\n\n";

echo "🎯 ANALYSE TERMINÉE!\n";
