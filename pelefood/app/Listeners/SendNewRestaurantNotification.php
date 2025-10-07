<?php

namespace App\Listeners;

use App\Events\NewRestaurantRegistered;
use App\Notifications\AdminNotification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewRestaurantNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewRestaurantRegistered $event): void
    {
        // Notifier tous les administrateurs
        $admins = User::where('role', 'super_admin')->get();
        
        foreach ($admins as $admin) {
            $admin->notify(new AdminNotification(
                'Nouveau restaurant inscrit !',
                "Nouveau restaurant '{$event->restaurant->name}' inscrit par {$event->user->name} ({$event->user->email})",
                'info',
                [
                    'restaurant_id' => $event->restaurant->id,
                    'restaurant_name' => $event->restaurant->name,
                    'user_id' => $event->user->id,
                    'user_name' => $event->user->name,
                    'user_email' => $event->user->email,
                ]
            ));
        }
    }
}