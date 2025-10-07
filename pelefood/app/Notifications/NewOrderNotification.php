<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;
    protected $type;

    /**
     * Create a new notification instance.
     *
     * @param Order $order
     * @param string $type
     */
    public function __construct(Order $order, $type = 'new_order')
    {
        $this->order = $order;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = ['database'];
        
        // Pour l'admin : broadcast seulement (slack désactivé temporairement)
        if ($notifiable->role === 'super_admin' || $notifiable->role === 'admin') {
            $channels[] = 'broadcast';
            // $channels[] = 'slack'; // Désactivé temporairement
        }
        
        // Pour le client : mail + sms
        if ($notifiable->role === 'customer') {
            $channels[] = 'mail';
            $channels[] = 'nexmo';
        }
        
        return $channels;
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'amount' => $this->order->total_amount,
            'customer_name' => $this->order->user->name ?? 'N/A',
            'restaurant_name' => $this->order->restaurant->name ?? 'N/A',
            'type' => $this->type,
            'message' => $this->getMessage(),
            'icon' => $this->getIcon(),
            'color' => $this->getColor(),
        ];
    }

    /**
     * Get the broadcast representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'type' => $this->type,
            'data' => [
                'order_id' => $this->order->id,
                'order_number' => $this->order->order_number,
                'amount' => $this->order->total_amount,
                'customer_name' => $this->order->user->name ?? 'N/A',
                'restaurant_name' => $this->order->restaurant->name ?? 'N/A',
                'message' => $this->getMessage(),
                'icon' => $this->getIcon(),
                'color' => $this->getColor(),
                'time' => now()->diffForHumans(),
            ],
        ]);
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $pdf = $this->generateReceiptPdf();
        
        return (new MailMessage)
            ->subject('🎉 Votre commande #' . $this->order->order_number . ' a été confirmée !')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Votre commande a été confirmée avec succès.')
            ->line('**Numéro de commande :** #' . $this->order->order_number)
            ->line('**Restaurant :** ' . ($this->order->restaurant->name ?? 'N/A'))
            ->line('**Montant total :** ' . \App\Helpers\SettingsHelper::formatAmount($this->order->total_amount))
            ->line('**Statut :** ' . ucfirst($this->order->status))
            ->action('Voir ma commande', route('orders.show', $this->order->id))
            ->line('Merci pour votre confiance !')
            ->attachData($pdf, 'receipt-' . $this->order->order_number . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->success()
            ->content('🔔 Nouvelle commande reçue !')
            ->attachment(function ($attachment) {
                $attachment->title('Commande #' . $this->order->order_number)
                    ->fields([
                        'Client' => $this->order->user->name ?? 'N/A',
                        'Restaurant' => $this->order->restaurant->name ?? 'N/A',
                        'Montant' => \App\Helpers\SettingsHelper::formatAmount($this->order->total_amount),
                        'Statut' => ucfirst($this->order->status),
                        'Heure' => $this->order->created_at->format('H:i'),
                    ])
                    ->color('good');
            });
    }

    /**
     * Get the Nexmo/SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content('🍽️ PeleFood - Votre commande #' . $this->order->order_number . ' est confirmée ! Montant: ' . \App\Helpers\SettingsHelper::formatAmount($this->order->total_amount) . '. Merci !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'amount' => $this->order->total_amount,
            'type' => $this->type,
        ];
    }

    /**
     * Generate PDF receipt
     */
    private function generateReceiptPdf()
    {
        $pdf = Pdf::loadView('receipts.order', [
            'order' => $this->order,
            'customer' => $this->order->user,
            'restaurant' => $this->order->restaurant,
        ]);
        
        return $pdf->output();
    }

    /**
     * Get notification message
     */
    private function getMessage()
    {
        switch ($this->type) {
            case 'new_order':
                return 'Nouvelle commande #' . $this->order->order_number . ' reçue !';
            case 'order_confirmed':
                return 'Commande #' . $this->order->order_number . ' confirmée !';
            case 'order_ready':
                return 'Commande #' . $this->order->order_number . ' prête !';
            case 'order_delivered':
                return 'Commande #' . $this->order->order_number . ' livrée !';
            default:
                return 'Notification concernant la commande #' . $this->order->order_number;
        }
    }

    /**
     * Get notification icon
     */
    private function getIcon()
    {
        switch ($this->type) {
            case 'new_order':
                return '🛒';
            case 'order_confirmed':
                return '✅';
            case 'order_ready':
                return '🍽️';
            case 'order_delivered':
                return '🚚';
            default:
                return '🔔';
        }
    }

    /**
     * Get notification color
     */
    private function getColor()
    {
        switch ($this->type) {
            case 'new_order':
                return 'blue';
            case 'order_confirmed':
                return 'green';
            case 'order_ready':
                return 'orange';
            case 'order_delivered':
                return 'purple';
            default:
                return 'gray';
        }
    }
}
