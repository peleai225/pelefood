<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Notifications\BulkNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    /**
     * Afficher la page des notifications
     */
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(20);
        $unreadCount = auth()->user()->unreadNotifications()->count();
        
        return view('admin.notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        
        return response()->json(['success' => true]);
    }

    /**
     * Supprimer une notification
     */
    public function destroy($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();
        
        return response()->json(['success' => true]);
    }

    /**
     * Afficher le formulaire de notification en masse
     */
    public function createBulk()
    {
        return view('admin.notifications.create-bulk');
    }

    /**
     * Envoyer une notification en masse
     */
    public function sendBulk(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:announcement,promotion,maintenance,update',
            'channels' => 'required|array',
            'channels.*' => 'in:database,mail,slack,nexmo',
            'target_roles' => 'required|array',
            'target_roles.*' => 'in:super_admin,admin,restaurant,customer,driver',
        ]);

        $users = User::whereIn('role', $request->target_roles)->get();
        
        if ($users->isEmpty()) {
            return back()->with('error', 'Aucun utilisateur trouvé pour les rôles sélectionnés.');
        }

        $notification = new BulkNotification(
            $request->title,
            $request->message,
            $request->type,
            $request->channels
        );

        // Envoyer la notification à tous les utilisateurs
        Notification::send($users, $notification);

        return back()->with('success', 
            'Notification envoyée à ' . $users->count() . ' utilisateur(s) avec succès !'
        );
    }

    /**
     * Obtenir les notifications non lues (pour AJAX)
     */
    public function getUnread()
    {
        $notifications = auth()->user()->unreadNotifications()
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'data' => $notification->data,
                    'created_at' => $notification->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => auth()->user()->unreadNotifications()->count(),
        ]);
    }

    /**
     * Tester une notification (pour les admins)
     */
    public function test(Request $request)
    {
        $request->validate([
            'type' => 'required|in:order,announcement',
            'channels' => 'required|array',
        ]);

        $user = auth()->user();

        if ($request->type === 'order') {
            // Créer une commande de test
            $order = \App\Models\Order::first();
            if ($order) {
                $user->notify(new \App\Notifications\NewOrderNotification($order, 'new_order'));
            }
        } else {
            // Notification de test
            $user->notify(new BulkNotification(
                'Test de notification',
                'Ceci est une notification de test pour vérifier le bon fonctionnement du système.',
                'announcement',
                $request->channels
            ));
        }

        return back()->with('success', 'Notification de test envoyée !');
    }
}
