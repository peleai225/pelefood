<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ResetPasswordForm extends Component
{
    public $token;
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $showPassword = false;
    public $showPasswordConfirmation = false;
    public $isLoading = false;
    public $showSuccessMessage = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ];

    protected $messages = [
        'email.required' => 'L\'adresse email est obligatoire.',
        'email.email' => 'Veuillez saisir une adresse email valide.',
        'password.required' => 'Le mot de passe est obligatoire.',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        'password.confirmed' => 'Les mots de passe ne correspondent pas.',
    ];

    public function mount($token)
    {
        $this->token = $token;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function togglePasswordVisibility()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function togglePasswordConfirmationVisibility()
    {
        $this->showPasswordConfirmation = !$this->showPasswordConfirmation;
    }

    public function resetPassword()
    {
        $this->validate();

        $this->isLoading = true;

        // Réinitialiser le mot de passe
        $status = Password::reset([
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'token' => $this->token,
        ], function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            Auth::login($user);
        });

        if ($status === Password::PASSWORD_RESET) {
            $this->showSuccessMessage = true;
            $this->dispatch('password-reset-success');
            
            return redirect()->route('restaurant.dashboard');
        } else {
            $this->addError('email', 'Le token de réinitialisation est invalide ou a expiré.');
        }

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.auth.reset-password-form')
            ->layout('layouts.app');
    }
}
