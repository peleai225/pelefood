<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginFormWorking extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;
    public $isLoading = false;
    public $message = '';
    public $showPassword = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'email.required' => 'L\'adresse email est obligatoire.',
        'email.email' => 'Veuillez saisir une adresse email valide.',
        'password.required' => 'Le mot de passe est obligatoire.',
        'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function togglePasswordVisibility()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function testButton()
    {
        $this->message = "Bouton de test Livewire cliqué - Pas d'erreur côté serveur";
        session()->flash('success', 'Test Livewire réussi !');
    }

    public function login()
    {
        $this->message = "Début de la connexion...";
        $this->validate();
        $this->isLoading = true;
        $this->message = "Validation réussie, tentative de connexion...";

        try {
            if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
                $this->message = "Connexion réussie !";
                session()->regenerate();
                
                $user = Auth::user();
                $this->message = "Utilisateur connecté: {$user->name}";
                
                // Redirection basée sur le rôle
                if ($user->isSuperAdmin()) {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->isAdmin()) {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->isRestaurant()) {
                    return redirect()->route('restaurant.dashboard');
                } else {
                    return redirect()->route('dashboard');
                }
            } else {
                $this->message = "Identifiants incorrects";
                $this->isLoading = false;
                throw ValidationException::withMessages([
                    'email' => 'Les identifiants fournis ne correspondent à aucun compte.',
                ]);
            }
        } catch (ValidationException $e) {
            $this->message = "Erreur de validation: " . implode(', ', $e->errors()['email'] ?? []);
            $this->isLoading = false;
            throw $e;
        } catch (\Exception $e) {
            $this->message = "Erreur: " . $e->getMessage();
            $this->isLoading = false;
            throw ValidationException::withMessages([
                'email' => 'Une erreur est survenue lors de la connexion.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.login-form-working');
    }
}
