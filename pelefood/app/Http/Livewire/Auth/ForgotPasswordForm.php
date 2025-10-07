<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;

class ForgotPasswordForm extends Component
{
    public $email = '';
    public $isLoading = false;
    public $showSuccessMessage = false;
    public $successMessage = '';

    protected $rules = [
        'email' => 'required|email',
    ];

    protected $messages = [
        'email.required' => 'L\'adresse email est obligatoire.',
        'email.email' => 'Veuillez saisir une adresse email valide.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function sendResetLink()
    {
        $this->validate();

        $this->isLoading = true;

        // Rate limiting
        $key = 'forgot-password.' . request()->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('email', "Trop de tentatives. Réessayez dans {$seconds} secondes.");
            $this->isLoading = false;
            return;
        }

        // Envoyer le lien de réinitialisation
        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->showSuccessMessage = true;
            $this->successMessage = 'Un lien de réinitialisation a été envoyé à votre adresse email.';
            $this->email = '';
        } else {
            $this->addError('email', 'Cette adresse email n\'est pas associée à un compte.');
        }

        RateLimiter::hit($key, 300); // 5 minutes
        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.auth.forgot-password-form')
            ->layout('layouts.app');
    }
}
