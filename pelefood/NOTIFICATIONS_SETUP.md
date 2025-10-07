# 🔔 Configuration du Système de Notifications PeleFood

## 📋 Vue d'ensemble

Le système de notifications PeleFood est un système multi-canaux complet qui permet d'envoyer des notifications via :
- **Database** : Stockage en base de données
- **Broadcast** : Temps réel via Pusher/Laravel Echo
- **Email** : Avec templates personnalisés et PDF
- **SMS** : Via Nexmo/Vonage ou Twilio
- **Slack** : Notifications équipe
- **Push** : Notifications mobiles via Firebase

## 🚀 Installation et Configuration

### 1. Variables d'environnement requises

Ajoutez ces variables à votre fichier `.env` :

```env
# Broadcasting (Temps réel)
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=mt1

# Email
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@pelefood.com
MAIL_FROM_NAME="PeleFood"

# SMS (Nexmo/Vonage)
NEXMO_API_KEY=your_nexmo_key
NEXMO_API_SECRET=your_nexmo_secret
NEXMO_FROM=PeleFood

# SMS (Twilio - Alternative)
TWILIO_SID=your_twilio_sid
TWILIO_TOKEN=your_twilio_token
TWILIO_FROM=+1234567890

# Slack
SLACK_WEBHOOK_URL=your_slack_webhook_url
SLACK_CHANNEL=#notifications
SLACK_USERNAME=PeleFood Bot

# Firebase (Push notifications)
FIREBASE_SERVER_KEY=your_firebase_server_key
FIREBASE_PROJECT_ID=your_firebase_project_id

# Notifications
NOTIFICATIONS_DATABASE=true
NOTIFICATIONS_BROADCAST=true
NOTIFICATIONS_MAIL=true
NOTIFICATIONS_SMS=false
NOTIFICATIONS_SLACK=false
NOTIFICATIONS_PUSH=false
```

### 2. Installation des dépendances

```bash
# Packages déjà installés
composer require barryvdh/laravel-dompdf
composer require laravel/slack-notification-channel
composer require laravel/nexmo-notification-channel

# Pour le temps réel (optionnel)
npm install laravel-echo pusher-js
```

### 3. Configuration des canaux

#### Pusher (Temps réel)
1. Créez un compte sur [Pusher](https://pusher.com)
2. Créez une nouvelle app
3. Copiez les clés dans votre `.env`

#### Nexmo/Vonage (SMS)
1. Créez un compte sur [Vonage](https://vonage.com)
2. Obtenez vos clés API
3. Ajoutez-les dans votre `.env`

#### Slack
1. Créez un webhook sur Slack
2. Ajoutez l'URL dans votre `.env`

#### Firebase (Push)
1. Configurez Firebase pour votre projet
2. Obtenez la clé serveur
3. Ajoutez-la dans votre `.env`

## 🎯 Utilisation

### Service de notifications unifié

```php
use App\Services\NotificationService;

$notificationService = new NotificationService();

// Notification à un utilisateur
$notificationService->sendToUser($user, 'Titre', 'Message', 'info');

// Notification à un rôle
$notificationService->sendToRole('restaurant', 'Titre', 'Message', 'warning');

// Notification à tous les restaurants
$notificationService->sendToAllRestaurants('Annonce', 'Nouvelle fonctionnalité disponible');

// Notification à tous les admins
$notificationService->sendToAllAdmins('Alerte', 'Action requise');
```

### Notifications automatiques

Le système déclenche automatiquement des notifications pour :
- **Nouvelles commandes** : Notifie le restaurant et les admins
- **Nouveaux restaurants** : Notifie les admins
- **Abonnements expirants** : Notifie les utilisateurs
- **Paiements** : Confirmation et échecs

### Interface utilisateur

#### Restaurant
- **Page** : `/restaurant/notifications`
- **Badge** : Dans la sidebar et header
- **Dropdown** : Notifications en temps réel

#### Super Admin
- **Page** : `/admin/notifications`
- **Notifications en masse** : `/admin/notifications/create-bulk`
- **Gestion complète** : CRUD des notifications

## 🛠️ Commandes Artisan

### Gestion des notifications

```bash
# Afficher les statistiques
php artisan notifications:manage stats

# Nettoyer les anciennes notifications (30 jours par défaut)
php artisan notifications:manage cleanup --days=30

# Envoyer une notification
php artisan notifications:manage send --role=restaurant --title="Test" --message="Message de test"

# Tester le système
php artisan notifications:manage test
```

### Configuration du temps réel

```bash
# Vider le cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# Redémarrer les workers de queue
php artisan queue:restart
```

## 📊 Types de notifications

### Types disponibles
- **info** : Informations générales (bleu)
- **success** : Confirmations, succès (vert)
- **warning** : Avertissements (jaune)
- **error** : Erreurs, problèmes (rouge)

### Canaux par défaut
- **Database** : Toujours activé
- **Broadcast** : Pour les admins et restaurants
- **Email** : Pour les clients et confirmations importantes
- **SMS** : Pour les clients (commandes, livraisons)
- **Slack** : Pour l'équipe (nouvelles inscriptions, problèmes)

## 🔧 Personnalisation

### Templates email

Les templates se trouvent dans `resources/views/emails/` :
- `order-receipt.blade.php` : Reçu de commande
- `order-confirmation.blade.php` : Confirmation de commande
- `subscription-reminder.blade.php` : Rappel d'abonnement

### Configuration avancée

Modifiez `config/notifications.php` pour :
- Ajouter de nouveaux types de notifications
- Configurer les canaux par défaut
- Personnaliser les templates
- Gérer la limitation de débit

### Styles des notifications

Les styles sont dans :
- `resources/views/restaurant/notifications/index.blade.php`
- `resources/views/admin/notifications/index.blade.php`
- `resources/views/restaurant/partials/notification-dropdown.blade.php`

## 🚨 Dépannage

### Notifications ne s'affichent pas
1. Vérifiez que `BROADCAST_DRIVER` est configuré
2. Vérifiez les clés Pusher
3. Vérifiez que Laravel Echo est configuré côté client

### Emails non envoyés
1. Vérifiez la configuration SMTP
2. Vérifiez les logs : `storage/logs/laravel.log`
3. Testez avec `php artisan tinker`

### SMS non envoyés
1. Vérifiez les clés Nexmo/Twilio
2. Vérifiez que `NOTIFICATIONS_SMS=true`
3. Vérifiez les crédits du compte

### Slack non fonctionnel
1. Vérifiez l'URL du webhook
2. Vérifiez que `NOTIFICATIONS_SLACK=true`
3. Testez l'URL du webhook manuellement

## 📈 Monitoring

### Logs
- Notifications : `storage/logs/laravel.log`
- Queue : `storage/logs/laravel.log`

### Métriques
- Statistiques via la commande `notifications:manage stats`
- Dashboard admin avec compteurs en temps réel

### Nettoyage automatique
Configurez un cron job pour nettoyer les anciennes notifications :

```bash
# Ajoutez à votre crontab
0 2 * * * cd /path/to/project && php artisan notifications:manage cleanup
```

## 🎉 Fonctionnalités avancées

### Notifications conditionnelles
```php
// Envoyer seulement si l'utilisateur est actif
if ($user->is_active) {
    $notificationService->sendToUser($user, 'Titre', 'Message');
}
```

### Notifications programmées
```php
// Utiliser Laravel Scheduler pour les rappels
Schedule::call(function () {
    $notificationService->notifySubscriptionExpiring($user, 7);
})->daily();
```

### Notifications avec actions
```php
$notification = new AdminNotification(
    'Commande prête',
    'Votre commande est prête à être récupérée',
    'success',
    '/restaurant/orders/123'
);
```

## 🔐 Sécurité

- Toutes les notifications sont validées
- Les URLs sont vérifiées
- Les données sensibles sont filtrées
- Rate limiting activé par défaut

## 📞 Support

Pour toute question ou problème :
- Consultez les logs : `storage/logs/laravel.log`
- Utilisez `php artisan notifications:manage test`
- Vérifiez la configuration dans `config/notifications.php`

---

**Le système de notifications PeleFood est maintenant entièrement opérationnel !** 🎊
