<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class RegisterFormModern extends Component
{
    public $currentStep = 1;
    public $totalSteps = 3;
    
    // Étape 1: Informations personnelles
    public $name = '';
    public $email = '';
    public $phone = '';
    
    // Étape 2: Informations de localisation
    public $city = '';
    public $address = '';
    public $country = 'Côte d\'Ivoire';
    
    // Étape 3: Sécurité et conditions
    public $password = '';
    public $password_confirmation = '';
    public $terms = false;
    
    public $isLoading = false;
    public $message = '';
    public $showPassword = false;

    protected $rules = [
        'name' => 'required|min:2|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|min:8|max:20',
        'city' => 'required|min:2|max:100',
        'address' => 'required|min:10|max:255',
        'country' => 'required|min:2|max:100',
        'password' => 'required|min:8|confirmed',
        'terms' => 'required|accepted',
    ];

    protected $messages = [
        'name.required' => 'Le nom complet est obligatoire.',
        'name.min' => 'Le nom doit contenir au moins 2 caractères.',
        'email.required' => 'L\'adresse email est obligatoire.',
        'email.email' => 'Veuillez saisir une adresse email valide.',
        'email.unique' => 'Cette adresse email est déjà utilisée.',
        'phone.required' => 'Le numéro de téléphone est obligatoire.',
        'phone.min' => 'Le numéro de téléphone doit contenir au moins 8 caractères.',
        'city.required' => 'La ville est obligatoire.',
        'address.required' => 'L\'adresse est obligatoire.',
        'address.min' => 'L\'adresse doit contenir au moins 10 caractères.',
        'password.required' => 'Le mot de passe est obligatoire.',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        'terms.required' => 'Vous devez accepter les conditions d\'utilisation.',
        'terms.accepted' => 'Vous devez accepter les conditions d\'utilisation.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function togglePasswordVisibility()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function nextStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'name' => 'required|min:2|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|min:8|max:20',
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'city' => 'required|min:2|max:100',
                'address' => 'required|min:10|max:255',
                'country' => 'required|min:2|max:100',
            ]);
        }
        
        $this->currentStep++;
        $this->message = "Étape {$this->currentStep} de {$this->totalSteps}";
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            $this->message = "Étape {$this->currentStep} de {$this->totalSteps}";
        }
    }

    public function register()
    {
        $this->validate();
        $this->isLoading = true;
        $this->message = "Création du compte en cours...";

        try {
            // Créer le tenant
            $tenant = Tenant::create([
                'name' => $this->name . ' Restaurant',
                'domain' => strtolower(str_replace(' ', '-', $this->name)) . '.pelefood.com',
                'subdomain' => strtolower(str_replace(' ', '-', $this->name)),
                'company_name' => $this->name . ' Company',
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'city' => $this->city,
                'country' => $this->country,
                'timezone' => 'Africa/Abidjan',
                'currency' => 'XOF',
                'language' => 'fr',
                'is_active' => true,
                'is_verified' => false,
            ]);

            // Créer l'utilisateur
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'tenant_id' => $tenant->id,
                'role' => 'restaurant',
                'phone' => $this->phone,
                'address' => $this->address,
                'city' => $this->city,
                'country' => $this->country,
            ]);

            // Assigner le rôle
            $user->assignRole('restaurant');

            // Créer le restaurant
            Restaurant::create([
                'name' => $this->name . ' Restaurant',
                'phone' => $this->phone,
                'address' => $this->address,
                'city' => $this->city,
                'country' => $this->country,
                'tenant_id' => $tenant->id,
                'is_active' => true,
                'slug' => Str::slug($this->name . ' Restaurant'),
                'email' => $this->email,
            ]);

            // Connecter l'utilisateur
            Auth::login($user);
            
            $this->message = "Compte créé avec succès !";
            return redirect()->route('restaurant.dashboard');

        } catch (\Exception $e) {
            $this->isLoading = false;
            $this->message = "Erreur lors de la création du compte: " . $e->getMessage();
            throw ValidationException::withMessages([
                'email' => 'Une erreur est survenue lors de la création du compte. Veuillez réessayer.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.register-form-modern');
    }
}