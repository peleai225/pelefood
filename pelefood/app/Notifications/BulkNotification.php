<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class BulkNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $title;
    protected $message;
    protected $type;
    protected $channels;

    /**
     * Create a new notification instance.
     *
     * @param string $title
     * @param string $message
     * @param string $type
     * @param array $channels
     */
    public function __construct($title, $message, $type = 'announcement', $channels = ['database', 'mail'])
    {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
        $this->channels = $channels;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->channels;
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
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
            'icon' => $this->getIcon(),
            'color' => $this->getColor(),
            'is_bulk' => true,
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
                'title' => $this->title,
                'message' => $this->message,
                'icon' => $this->getIcon(),
                'color' => $this->getColor(),
                'time' => now()->diffForHumans(),
                'is_bulk' => true,
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
        return (new MailMessage)
            ->subject('🎉 ' . $this->title)
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line($this->message)
            ->action('Voir les détails', url('/'))
            ->line('Merci pour votre confiance !');
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
            ->content('📢 ' . $this->title)
            ->attachment(function ($attachment) {
                $attachment->title($this->message)
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
            ->content('🍽️ PeleFood - ' . $this->title . ' - ' . $this->message);
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
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
        ];
    }

    /**
     * Get notification icon
     */
    private function getIcon()
    {
        switch ($this->type) {
            case 'promotion':
                return '🎉';
            case 'announcement':
                return '📢';
            case 'maintenance':
                return '🔧';
            case 'update':
                return '🆕';
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
            case 'promotion':
                return 'green';
            case 'announcement':
                return 'blue';
            case 'maintenance':
                return 'orange';
            case 'update':
                return 'purple';
            default:
                return 'gray';
        }
    }
}
