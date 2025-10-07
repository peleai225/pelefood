<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;
use App\Models\User;
use App\Models\Restaurant;

class NotificationManagementCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:manage 
                            {action : Action à effectuer (cleanup|stats|send|test)}
                            {--days=30 : Nombre de jours pour le nettoyage}
                            {--role= : Rôle cible pour l\'envoi}
                            {--title= : Titre de la notification}
                            {--message= : Message de la notification}
                            {--type=info : Type de notification (info|success|warning|error)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gérer les notifications du système PeleFood';

    protected $notificationService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'cleanup':
                return $this->cleanupNotifications();
            case 'stats':
                return $this->showStatistics();
            case 'send':
                return $this->sendNotification();
            case 'test':
                return $this->testNotifications();
            default:
                $this->error("Action non reconnue : {$action}");
                $this->line("Actions disponibles : cleanup, stats, send, test");
                return 1;
        }
    }

    /**
     * Nettoyer les anciennes notifications
     */
    protected function cleanupNotifications()
    {
        $days = (int) $this->option('days');
        
        $this->info("🧹 Nettoyage des notifications de plus de {$days} jours...");
        
        $deletedCount = $this->notificationService->cleanupOldNotifications($days);
        
        if ($deletedCount !== false) {
            $this->info("✅ {$deletedCount} notifications supprimées avec succès");
            return 0;
        } else {
            $this->error("❌ Erreur lors du nettoyage des notifications");
            return 1;
        }
    }

    /**
     * Afficher les statistiques des notifications
     */
    protected function showStatistics()
    {
        $this->info("📊 Statistiques des notifications");
        $this->line("================================");
        
        $stats = $this->notificationService->getStatistics();
        
        $this->table(
            ['Métrique', 'Valeur'],
            [
                ['Total des notifications', number_format($stats['total_notifications'])],
                ['Notifications non lues', number_format($stats['unread_notifications'])],
                ['Notifications aujourd\'hui', number_format($stats['notifications_today'])],
                ['Notifications cette semaine', number_format($stats['notifications_this_week'])],
            ]
        );

        // Statistiques par utilisateur
        $this->line("\n👥 Notifications par utilisateur :");
        $users = User::withCount(['notifications', 'unreadNotifications'])->get();
        
        $userStats = [];
        foreach ($users as $user) {
            $userStats[] = [
                $user->name,
                $user->role,
                $user->notifications_count,
                $user->unread_notifications_count
            ];
        }
        
        $this->table(
            ['Nom', 'Rôle', 'Total', 'Non lues'],
            $userStats
        );

        return 0;
    }

    /**
     * Envoyer une notification
     */
    protected function sendNotification()
    {
        $role = $this->option('role');
        $title = $this->option('title');
        $message = $this->option('message');
        $type = $this->option('type');

        if (!$role || !$title || !$message) {
            $this->error("❌ Les options --role, --title et --message sont requises");
            return 1;
        }

        $this->info("📤 Envoi d'une notification {$type} au rôle {$role}");
        $this->line("Titre : {$title}");
        $this->line("Message : {$message}");

        $sentCount = $this->notificationService->sendToRole($role, $title, $message, $type);
        
        if ($sentCount) {
            $this->info("✅ Notification envoyée à {$sentCount} utilisateur(s)");
            return 0;
        } else {
            $this->error("❌ Aucune notification envoyée");
            return 1;
        }
    }

    /**
     * Tester le système de notifications
     */
    protected function testNotifications()
    {
        $this->info("🧪 Test du système de notifications");
        $this->line("==================================");

        // Test 1: Notification simple
        $this->line("\n📨 Test 1 : Notification simple");
        $user = User::where('role', 'restaurant')->first();
        
        if (!$user) {
            $this->error("❌ Aucun utilisateur restaurant trouvé pour le test");
            return 1;
        }

        $result = $this->notificationService->sendToUser(
            $user,
            'Test de notification',
            'Ceci est un test du système de notifications',
            'info'
        );

        if ($result) {
            $this->info("✅ Test 1 réussi");
        } else {
            $this->error("❌ Test 1 échoué");
        }

        // Test 2: Notification en masse
        $this->line("\n📢 Test 2 : Notification en masse");
        $count = $this->notificationService->sendToAllRestaurants(
            'Test de notification en masse',
            'Ceci est un test de notification en masse',
            'info'
        );

        if ($count) {
            $this->info("✅ Test 2 réussi - {$count} utilisateur(s) notifié(s)");
        } else {
            $this->error("❌ Test 2 échoué");
        }

        // Test 3: Statistiques
        $this->line("\n📊 Test 3 : Statistiques");
        $stats = $this->notificationService->getStatistics();
        
        if ($stats['total_notifications'] > 0) {
            $this->info("✅ Test 3 réussi - Statistiques disponibles");
            $this->line("   Total : {$stats['total_notifications']}");
            $this->line("   Non lues : {$stats['unread_notifications']}");
        } else {
            $this->error("❌ Test 3 échoué - Aucune statistique disponible");
        }

        $this->line("\n🎉 Tests terminés !");
        return 0;
    }
}