<?php

namespace App\Services;

use App\Models\User;
use App\Models\Restaurant;
use App\Models\Order;
use App\Notifications\AdminNotification;
use App\Notifications\BulkNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class NotificationService
{
    /**
     * Envoyer une notification à un utilisateur spécifique
     */
    public function sendToUser(User $user, string $title, string $message, string $type = 'info', string $url = null, array $data = [])
    {
        try {
            $notification = new AdminNotification($title, $message, $type, $url, $data);
            $user->notify($notification);
            
            Log::info('Notification envoyée à l\'utilisateur', [
                'user_id' => $user->id,
                'title' => $title,
                'type' => $type
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de notification à l\'utilisateur', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Envoyer une notification à tous les utilisateurs d'un rôle
     */
    public function sendToRole(string $role, string $title, string $message, string $type = 'info', string $url = null, array $data = [])
    {
        try {
            $users = User::where('role', $role)->get();
            
            if ($users->isEmpty()) {
                Log::warning('Aucun utilisateur trouvé pour le rôle', ['role' => $role]);
                return false;
            }

            $notification = new BulkNotification($title, $message, $type, ['database', 'broadcast']);
            
            Notification::send($users, $notification);
            
            Log::info('Notification envoyée au rôle', [
                'role' => $role,
                'user_count' => $users->count(),
                'title' => $title
            ]);
            
            return $users->count();
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de notification au rôle', [
                'role' => $role,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Envoyer une notification à tous les restaurants
     */
    public function sendToAllRestaurants(string $title, string $message, string $type = 'info', string $url = null, array $data = [])
    {
        return $this->sendToRole('restaurant', $title, $message, $type, $url, $data);
    }

    /**
     * Envoyer une notification à tous les admins
     */
    public function sendToAllAdmins(string $title, string $message, string $type = 'info', string $url = null, array $data = [])
    {
        $adminCount = $this->sendToRole('admin', $title, $message, $type, $url, $data);
        $superAdminCount = $this->sendToRole('super_admin', $title, $message, $type, $url, $data);
        
        return $adminCount + $superAdminCount;
    }

    /**
     * Notification de nouvelle commande
     */
    public function notifyNewOrder(Order $order)
    {
        $restaurant = $order->restaurant;
        $restaurantUser = $restaurant->user;
        
        $title = 'Nouvelle commande reçue';
        $message = "Commande #{$order->order_number} - " . number_format($order->total_amount, 0, ',', ' ') . " FCFA";
        $data = [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'order_total' => $order->total_amount,
            'customer_name' => $order->customer_name,
        ];
        
        // Notifier le restaurant
        $this->sendToUser($restaurantUser, $title, $message, 'success', "/restaurant/orders/{$order->id}", $data);
        
        // Notifier les admins
        $this->sendToAllAdmins($title, $message, 'info', "/admin/orders/{$order->id}", $data);
        
        return true;
    }

    /**
     * Notification de nouveau restaurant
     */
    public function notifyNewRestaurant(Restaurant $restaurant, User $user)
    {
        $title = 'Nouveau restaurant inscrit';
        $message = "{$restaurant->name} s'est inscrit sur la plateforme";
        $data = [
            'restaurant_id' => $restaurant->id,
            'restaurant_name' => $restaurant->name,
            'user_name' => $user->name,
            'user_email' => $user->email,
        ];
        
        $this->sendToAllAdmins($title, $message, 'info', "/admin/restaurants/{$restaurant->id}", $data);
        
        return true;
    }

    /**
     * Notification d'abonnement expirant
     */
    public function notifySubscriptionExpiring(User $user, int $daysLeft)
    {
        $title = 'Abonnement expire bientôt';
        $message = "Votre abonnement expire dans {$daysLeft} jour(s). Renouvelez maintenant !";
        
        return $this->sendToUser($user, $title, $message, 'warning', '/restaurant/subscription/manage');
    }

    /**
     * Notification d'abonnement expiré
     */
    public function notifySubscriptionExpired(User $user)
    {
        $title = 'Abonnement expiré';
        $message = 'Votre abonnement a expiré. Renouvelez pour continuer à utiliser le service.';
        
        return $this->sendToUser($user, $title, $message, 'error', '/restaurant/subscription/select');
    }

    /**
     * Notification de maintenance
     */
    public function notifyMaintenance(string $date, string $time, string $description = null)
    {
        $title = 'Maintenance programmée';
        $message = "Une maintenance est programmée le {$date} à {$time}";
        if ($description) {
            $message .= " - {$description}";
        }
        
        return $this->sendToAllRestaurants($title, $message, 'warning');
    }

    /**
     * Notification de mise à jour
     */
    public function notifyUpdate(string $version, string $description)
    {
        $title = 'Mise à jour disponible';
        $message = "Version {$version} disponible : {$description}";
        
        return $this->sendToAllRestaurants($title, $message, 'info');
    }

    /**
     * Obtenir les statistiques des notifications
     */
    public function getStatistics()
    {
        return Cache::remember('notification_statistics', 300, function () {
            return [
                'total_notifications' => \App\Models\User::all()->sum(function ($user) {
                    return $user->notifications()->count();
                }),
                'unread_notifications' => \App\Models\User::all()->sum(function ($user) {
                    return $user->unreadNotifications()->count();
                }),
                'notifications_today' => \App\Models\User::all()->sum(function ($user) {
                    return $user->notifications()->whereDate('created_at', today())->count();
                }),
                'notifications_this_week' => \App\Models\User::all()->sum(function ($user) {
                    return $user->notifications()->whereBetween('created_at', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ])->count();
                }),
            ];
        });
    }

    /**
     * Nettoyer les anciennes notifications
     */
    public function cleanupOldNotifications(int $days = 30)
    {
        try {
            $cutoffDate = now()->subDays($days);
            $deletedCount = 0;
            
            User::chunk(100, function ($users) use ($cutoffDate, &$deletedCount) {
                foreach ($users as $user) {
                    $deletedCount += $user->notifications()
                        ->where('created_at', '<', $cutoffDate)
                        ->delete();
                }
            });
            
            Log::info('Nettoyage des anciennes notifications terminé', [
                'deleted_count' => $deletedCount,
                'cutoff_date' => $cutoffDate->toDateString()
            ]);
            
            return $deletedCount;
        } catch (\Exception $e) {
            Log::error('Erreur lors du nettoyage des notifications', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Marquer toutes les notifications comme lues pour un utilisateur
     */
    public function markAllAsRead(User $user)
    {
        try {
            $user->unreadNotifications->markAsRead();
            
            Log::info('Toutes les notifications marquées comme lues', [
                'user_id' => $user->id
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Erreur lors du marquage des notifications', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
