<?php

namespace App\Listeners;

use App\Events\NewOrderReceived;
use App\Notifications\AdminNotification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewOrderNotification implements ShouldQueue
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
    public function handle(NewOrderReceived $event): void
    {
        // Notifier tous les administrateurs
        $admins = User::where('role', 'super_admin')->get();
        
        foreach ($admins as $admin) {
            $admin->notify(new AdminNotification(
                'Nouvelle commande reçue !',
                "Nouvelle commande #{$event->order->id} de {$event->order->customer_name} pour {$event->restaurant->name} - Montant: " . number_format($event->order->total, 0, ',', ' ') . ' FCFA',
                'success',
                [
                    'order_id' => $event->order->id,
                    'restaurant_id' => $event->restaurant->id,
                    'restaurant_name' => $event->restaurant->name,
                    'order_total' => $event->order->total,
                    'customer_name' => $event->order->customer_name,
                ]
            ));
        }
    }
}