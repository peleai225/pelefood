<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Restaurant;

class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, active, inactive, restaurant_owner, customer
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 12;
    
    // Modal pour créer/éditer un utilisateur
    public $showModal = false;
    public $modalTitle = '';
    public $editingUser = null;
    
    // Champs du formulaire
    public $name = '';
    public $email = '';
    public $phone = '';
    public $role = 'customer';
    public $is_active = true;
    public $password = '';
    public $password_confirmation = '';

    protected $listeners = ['userCreated' => 'loadStats', 'userUpdated' => 'loadStats', 'userDeleted' => 'loadStats'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'phone' => 'nullable|string|max:20',
        'role' => 'required|in:admin,restaurant_owner,customer',
        'is_active' => 'boolean',
        'password' => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required|string|min:8'
    ];

    protected $messages = [
        'email.unique' => 'Cette adresse email est déjà utilisée.',
        'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.'
    ];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        // Les statistiques sont gérées par AdminStatsComposer
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function createUser()
    {
        $this->resetForm();
        $this->modalTitle = 'Créer un nouvel utilisateur';
        $this->showModal = true;
    }

    public function editUser($userId)
    {
        $user = User::findOrFail($userId);
        $this->editingUser = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->role = $user->role;
        $this->is_active = $user->is_active;
        $this->password = '';
        $this->password_confirmation = '';
        
        $this->modalTitle = 'Modifier l\'utilisateur';
        $this->showModal = true;
        
        // Règles de validation pour l'édition
        $this->rules['email'] = 'required|email|max:255|unique:users,email,' . $user->id;
        $this->rules['password'] = 'nullable|string|min:8|confirmed';
        $this->rules['password_confirmation'] = 'nullable|string|min:8';
    }

    public function saveUser()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
            'is_active' => $this->is_active,
        ];

        // Ajouter le mot de passe seulement s'il est fourni
        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        if ($this->editingUser) {
            $this->editingUser->update($data);
            $this->emit('userUpdated');
            $this->emit('showNotification', 'Utilisateur mis à jour avec succès', 'success');
        } else {
            User::create($data);
            $this->emit('userCreated');
            $this->emit('showNotification', 'Utilisateur créé avec succès', 'success');
        }

        $this->closeModal();
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
        
        $this->emit('userDeleted');
        $this->emit('showNotification', 'Utilisateur supprimé avec succès', 'success');
    }

    public function toggleActive($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['is_active' => !$user->is_active]);
        
        $this->emit('showNotification', 'Statut de l\'utilisateur mis à jour', 'success');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingUser = null;
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->role = 'customer';
        $this->is_active = true;
        $this->password = '';
        $this->password_confirmation = '';
        $this->resetErrorBag();
        
        // Réinitialiser les règles de validation
        $this->rules['email'] = 'required|email|max:255|unique:users,email';
        $this->rules['password'] = 'required|string|min:8|confirmed';
        $this->rules['password_confirmation'] = 'required|string|min:8';
    }

    public function getUsersProperty()
    {
        // Utiliser une requête simple sans relations problématiques
        $query = User::query();

        // Filtre par recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        // Filtre par statut et rôle
        if ($this->filter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filter === 'inactive') {
            $query->where('is_active', false);
        } elseif (in_array($this->filter, ['admin', 'restaurant_owner', 'customer'])) {
            $query->where('role', $this->filter);
        }

        // Tri
        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.users', [
            'users' => $this->users
        ])->layout('layouts.super-admin-new-design');
    }
}