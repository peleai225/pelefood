<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersNewDesign extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all';
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

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'role' => 'required|in:admin,restaurant_owner,customer',
        'is_active' => 'boolean',
        'password' => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required|string|min:8'
    ];

    protected $messages = [
        'name.required' => 'Le nom est obligatoire.',
        'email.required' => 'L\'email est obligatoire.',
        'email.email' => 'L\'email doit être valide.',
        'password.required' => 'Le mot de passe est obligatoire.',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        'password.confirmed' => 'Les mots de passe ne correspondent pas.',
    ];

    public function mount()
    {
        // Pas de chargement de données complexes
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
        try {
            $user = User::findOrFail($userId);
            
            $this->modalTitle = 'Modifier l\'utilisateur';
            $this->editingUser = $userId;
            
            $this->name = $user->name ?? '';
            $this->email = $user->email ?? '';
            $this->phone = $user->phone ?? '';
            $this->role = $user->role ?? 'customer';
            $this->is_active = $user->is_active ?? true;
            $this->password = '';
            $this->password_confirmation = '';
            
            // Règles de validation pour l'édition
            $this->rules['email'] = 'required|email|max:255';
            $this->rules['password'] = 'nullable|string|min:8|confirmed';
            
            $this->showModal = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors du chargement de l\'utilisateur.');
        }
    }

    public function saveUser()
    {
        try {
            // Règles de validation dynamiques
            $rules = $this->rules;
            if ($this->editingUser) {
                $rules['email'] = 'required|email|max:255';
                $rules['password'] = 'nullable|string|min:8|confirmed';
            } else {
                $rules['email'] = 'required|email|max:255|unique:users,email';
                $rules['password'] = 'required|string|min:8|confirmed';
            }
            
            $this->validate($rules);

            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'role' => $this->role,
                'is_active' => $this->is_active,
            ];

            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }

            if ($this->editingUser) {
                User::findOrFail($this->editingUser)->update($data);
                session()->flash('message', 'Utilisateur modifié avec succès !');
            } else {
                User::create($data);
                session()->flash('message', 'Utilisateur créé avec succès !');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la sauvegarde : ' . $e->getMessage());
        }
    }

    public function deleteUser($userId)
    {
        try {
            User::findOrFail($userId)->delete();
            session()->flash('message', 'Utilisateur supprimé avec succès !');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    public function toggleActive($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $user->update(['is_active' => !$user->is_active]);
            session()->flash('message', 'Statut de l\'utilisateur modifié !');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la modification : ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->editingUser = null;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->role = 'customer';
        $this->is_active = true;
        $this->password = '';
        $this->password_confirmation = '';
        $this->resetErrorBag();
        
        // Restaurer les règles par défaut
        $this->rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,restaurant_owner,customer',
            'is_active' => 'boolean',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8'
        ];
    }

    public function render()
    {
        // Requête simple comme dans Products
        $query = User::query();

        // Filtre par recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        // Filtre par statut
        if ($this->filter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filter === 'inactive') {
            $query->where('is_active', false);
        } elseif (in_array($this->filter, ['admin', 'restaurant_owner', 'customer'])) {
            $query->where('role', $this->filter);
        }

        // Tri
        $query->orderBy($this->sortBy, $this->sortDirection);

        $users = $query->paginate($this->perPage);

        return view('livewire.admin.users-new-design', [
            'users' => $users
        ])->layout('layouts.super-admin-new-design');
    }
}
