<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Restaurant;

class RestaurantAccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $restaurant;
    public $temporaryPassword;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Restaurant $restaurant, string $temporaryPassword)
    {
        $this->user = $user;
        $this->restaurant = $restaurant;
        $this->temporaryPassword = $temporaryPassword;
    }

    /**
     * Get the message envelope.
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Votre compte restaurant PeleFood a été créé',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content()
    {
        return new Content(
            view: 'emails.restaurant-account-created',
        );
    }

    /**
     * Get the attachments.
     */
    public function attachments()
    {
        return [];
    }
}