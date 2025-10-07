<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Tenant;

class Restaurants extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, active, inactive
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 12;
    
    // Modal pour créer/éditer un restaurant
    public $showModal = false;
    public $modalTitle = '';
    public $editingRestaurant = null;
    
    // Champs du formulaire
    public $name = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $city = '';
    public $country = '';
    public $postal_code = '';
    public $description = '';
    public $cuisine_type = '';
    public $delivery_time = '';
    public $minimum_order = 0;
    public $delivery_fee = 0;
    public $is_active = true;
    public $is_featured = false;
    public $user_id = '';
    public $tenant_id = '';

    protected $listeners = ['restaurantCreated' => 'loadStats', 'restaurantUpdated' => 'loadStats', 'restaurantDeleted' => 'loadStats'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:500',
        'city' => 'required|string|max:100',
        'country' => 'required|string|max:100',
        'postal_code' => 'nullable|string|max:20',
        'description' => 'nullable|string|max:1000',
        'cuisine_type' => 'required|string|max:100',
        'delivery_time' => 'nullable|string|max:50',
        'minimum_order' => 'nullable|numeric|min:0',
        'delivery_fee' => 'nullable|numeric|min:0',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'user_id' => 'required|exists:users,id',
        'tenant_id' => 'required|exists:tenants,id'
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

    public function createRestaurant()
    {
        $this->resetForm();
        $this->modalTitle = 'Créer un nouveau restaurant';
        $this->showModal = true;
    }

    public function editRestaurant($restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
        $this->editingRestaurant = $restaurant;
        $this->name = $restaurant->name;
        $this->email = $restaurant->email;
        $this->phone = $restaurant->phone;
        $this->address = $restaurant->address;
        $this->city = $restaurant->city;
        $this->country = $restaurant->country;
        $this->postal_code = $restaurant->postal_code;
        $this->description = $restaurant->description;
        $this->cuisine_type = $restaurant->cuisine_type;
        $this->delivery_time = $restaurant->delivery_time;
        $this->minimum_order = $restaurant->minimum_order;
        $this->delivery_fee = $restaurant->delivery_fee;
        $this->is_active = $restaurant->is_active;
        $this->is_featured = $restaurant->is_featured;
        $this->user_id = $restaurant->user_id;
        $this->tenant_id = $restaurant->tenant_id;
        
        $this->modalTitle = 'Modifier le restaurant';
        $this->showModal = true;
    }

    public function saveRestaurant()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'postal_code' => $this->postal_code,
            'description' => $this->description,
            'cuisine_type' => $this->cuisine_type,
            'delivery_time' => $this->delivery_time,
            'minimum_order' => $this->minimum_order,
            'delivery_fee' => $this->delivery_fee,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'user_id' => $this->user_id,
            'tenant_id' => $this->tenant_id,
        ];

        if ($this->editingRestaurant) {
            $this->editingRestaurant->update($data);
            $this->emit('restaurantUpdated');
            $this->emit('showNotification', 'Restaurant mis à jour avec succès', 'success');
        } else {
            Restaurant::create($data);
            $this->emit('restaurantCreated');
            $this->emit('showNotification', 'Restaurant créé avec succès', 'success');
        }

        $this->closeModal();
    }

    public function deleteRestaurant($restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
        $restaurant->delete();
        
        $this->emit('restaurantDeleted');
        $this->emit('showNotification', 'Restaurant supprimé avec succès', 'success');
    }

    public function toggleActive($restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
        $restaurant->update(['is_active' => !$restaurant->is_active]);
        
        $this->emit('showNotification', 'Statut du restaurant mis à jour', 'success');
    }

    public function toggleFeatured($restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
        $restaurant->update(['is_featured' => !$restaurant->is_featured]);
        
        $this->emit('showNotification', 'Restaurant mis en vedette mis à jour', 'success');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingRestaurant = null;
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->address = '';
        $this->city = '';
        $this->country = '';
        $this->postal_code = '';
        $this->description = '';
        $this->cuisine_type = '';
        $this->delivery_time = '';
        $this->minimum_order = 0;
        $this->delivery_fee = 0;
        $this->is_active = true;
        $this->is_featured = false;
        $this->user_id = '';
        $this->tenant_id = '';
        $this->resetErrorBag();
    }

    public function getRestaurantsProperty()
    {
        // Utiliser une requête simple sans relations problématiques
        $query = Restaurant::query();

        // Filtre par recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('city', 'like', '%' . $this->search . '%');
            });
        }

        // Filtre par statut
        if ($this->filter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filter === 'inactive') {
            $query->where('is_active', false);
        }

        // Tri
        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function getUsersProperty()
    {
        return User::where('role', 'restaurant_owner')->get();
    }

    public function getTenantsProperty()
    {
        return Tenant::all();
    }

    public function render()
    {
        return view('livewire.admin.restaurants', [
            'restaurants' => $this->restaurants,
            'users' => $this->users,
            'tenants' => $this->tenants
        ])->layout('layouts.super-admin-new-design');
    }
}