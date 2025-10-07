<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginFormPeleFood extends Component
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
        $this->message = "Champ mis à jour: $propertyName";
    }

    public function togglePasswordVisibility()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function login()
    {
        $this->message = "Début de la connexion...";
        $this->validate();

        $this->isLoading = true;
        $this->message = "Connexion en cours...";

        try {
            if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
                session()->regenerate();
                $user = Auth::user();
                
                $this->message = "Connexion réussie !";
                
                if ($user->hasRole('super_admin')) {
                    return redirect()->route('super-admin.dashboard');
                } elseif ($user->hasRole('admin')) {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->hasRole('restaurant')) {
                    return redirect()->route('restaurant.dashboard');
                } else {
                    return redirect()->intended(route('dashboard'));
                }
            }
            
            throw ValidationException::withMessages([
                'email' => 'Les identifiants fournis ne correspondent à aucun compte.',
            ]);
        } catch (ValidationException $e) {
            $this->isLoading = false;
            $this->message = "Erreur de connexion";
            throw $e;
        } catch (\Exception $e) {
            $this->isLoading = false;
            $this->message = "Une erreur est survenue lors de la connexion.";
            throw ValidationException::withMessages([
                'email' => 'Une erreur est survenue lors de la connexion.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.login-form-pelefood');
    }
}
