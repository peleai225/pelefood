<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Tenant;

class RestaurantsTestReal extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all';
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
    public $minimum_order = '';
    public $delivery_fee = '';
    public $is_active = true;
    public $is_featured = false;
    public $user_id = '';
    public $tenant_id = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'address' => 'required|string|max:500',
        'city' => 'required|string|max:100',
        'country' => 'required|string|max:100',
        'postal_code' => 'nullable|string|max:20',
        'description' => 'nullable|string|max:1000',
        'cuisine_type' => 'nullable|string|max:100',
        'delivery_time' => 'nullable|string|max:50',
        'minimum_order' => 'nullable|numeric|min:0',
        'delivery_fee' => 'nullable|numeric|min:0',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function mount()
    {
        \Log::info('RestaurantsTestReal component mounted');
        try {
            $this->loadStats();
        } catch (\Exception $e) {
            \Log::error('Error in mount: ' . $e->getMessage());
        }
    }

    public function loadStats()
    {
        \Log::info('loadStats called');
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

    public function createRestaurant()
    {
        \Log::info('createRestaurant method called');
        try {
            $this->resetForm();
            $this->modalTitle = 'Créer un nouveau restaurant';
            $this->showModal = true;
            \Log::info('Modal should be open: ' . ($this->showModal ? 'true' : 'false'));
        } catch (\Exception $e) {
            \Log::error('Error in createRestaurant: ' . $e->getMessage());
        }
    }

    public function editRestaurant($restaurantId)
    {
        \Log::info('editRestaurant method called with ID: ' . $restaurantId);
        try {
            $restaurant = Restaurant::findOrFail($restaurantId);
            
            $this->modalTitle = 'Modifier le restaurant';
            $this->editingRestaurant = $restaurantId;
            
            $this->name = $restaurant->name ?? '';
            $this->email = $restaurant->email ?? '';
            $this->phone = $restaurant->phone ?? '';
            $this->address = $restaurant->address ?? '';
            $this->city = $restaurant->city ?? '';
            $this->country = $restaurant->country ?? '';
            $this->postal_code = $restaurant->postal_code ?? '';
            $this->description = $restaurant->description ?? '';
            $this->cuisine_type = $restaurant->cuisine_type ?? '';
            $this->delivery_time = $restaurant->delivery_time ?? '';
            $this->minimum_order = $restaurant->minimum_order ?? '';
            $this->delivery_fee = $restaurant->delivery_fee ?? '';
            $this->is_active = $restaurant->is_active ?? true;
            $this->is_featured = $restaurant->is_featured ?? false;
            $this->user_id = $restaurant->user_id ?? '';
            $this->tenant_id = $restaurant->tenant_id ?? '';
            
            $this->showModal = true;
            \Log::info('Modal should be open: ' . ($this->showModal ? 'true' : 'false'));
        } catch (\Exception $e) {
            \Log::error('Error in editRestaurant: ' . $e->getMessage());
            $this->emit('showNotification', 'Erreur lors du chargement du restaurant', 'error');
        }
    }

    public function saveRestaurant()
    {
        \Log::info('saveRestaurant method called');
        try {
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
                Restaurant::findOrFail($this->editingRestaurant)->update($data);
                $this->emit('showNotification', 'Restaurant modifié avec succès', 'success');
            } else {
                Restaurant::create($data);
                $this->emit('showNotification', 'Restaurant créé avec succès', 'success');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            \Log::error('Error in saveRestaurant: ' . $e->getMessage());
            $this->emit('showNotification', 'Erreur lors de la sauvegarde', 'error');
        }
    }

    public function deleteRestaurant($restaurantId)
    {
        \Log::info('deleteRestaurant method called with ID: ' . $restaurantId);
        try {
            Restaurant::findOrFail($restaurantId)->delete();
            $this->emit('showNotification', 'Restaurant supprimé avec succès', 'success');
        } catch (\Exception $e) {
            \Log::error('Error in deleteRestaurant: ' . $e->getMessage());
            $this->emit('showNotification', 'Erreur lors de la suppression', 'error');
        }
    }

    public function toggleActive($restaurantId)
    {
        \Log::info('toggleActive method called with ID: ' . $restaurantId);
        try {
            $restaurant = Restaurant::findOrFail($restaurantId);
            $restaurant->update(['is_active' => !$restaurant->is_active]);
            $this->emit('showNotification', 'Statut du restaurant modifié', 'success');
        } catch (\Exception $e) {
            \Log::error('Error in toggleActive: ' . $e->getMessage());
            $this->emit('showNotification', 'Erreur lors de la modification', 'error');
        }
    }

    public function toggleFeatured($restaurantId)
    {
        \Log::info('toggleFeatured method called with ID: ' . $restaurantId);
        try {
            $restaurant = Restaurant::findOrFail($restaurantId);
            $restaurant->update(['is_featured' => !$restaurant->is_featured]);
            $this->emit('showNotification', 'Statut vedette modifié', 'success');
        } catch (\Exception $e) {
            \Log::error('Error in toggleFeatured: ' . $e->getMessage());
            $this->emit('showNotification', 'Erreur lors de la modification', 'error');
        }
    }

    public function closeModal()
    {
        \Log::info('closeModal method called');
        $this->showModal = false;
        $this->editingRestaurant = null;
        $this->resetForm();
    }

    public function resetForm()
    {
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
        $this->minimum_order = '';
        $this->delivery_fee = '';
        $this->is_active = true;
        $this->is_featured = false;
        $this->user_id = '';
        $this->tenant_id = '';
        $this->resetErrorBag();
    }

    public function getUsersProperty()
    {
        try {
            return User::where('role', 'restaurant_owner')->get();
        } catch (\Exception $e) {
            \Log::error('Error loading users: ' . $e->getMessage());
            return collect();
        }
    }

    public function getTenantsProperty()
    {
        try {
            return Tenant::all();
        } catch (\Exception $e) {
            \Log::error('Error loading tenants: ' . $e->getMessage());
            return collect();
        }
    }

    public function getRestaurantsProperty()
    {
        try {
            \Log::info('getRestaurantsProperty called');
            
            // Test simple d'abord
            $restaurants = Restaurant::all();
            \Log::info('Restaurants found: ' . $restaurants->count());
            
            // Si ça marche, on fait la requête complète
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

            $result = $query->paginate($this->perPage);
            \Log::info('Restaurants query completed successfully');
            return $result;
            
        } catch (\Exception $e) {
            \Log::error('Error in getRestaurantsProperty: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return collect()->paginate($this->perPage);
        }
    }

    public function render()
    {
        try {
            \Log::info('Render method called');
            return view('livewire.admin.restaurants', [
                'restaurants' => $this->restaurants,
                'users' => $this->users,
                'tenants' => $this->tenants
            ])->layout('layouts.super-admin-new-design');
        } catch (\Exception $e) {
            \Log::error('Error in render: ' . $e->getMessage());
            return view('livewire.admin.restaurants', [
                'restaurants' => collect()->paginate($this->perPage),
                'users' => collect(),
                'tenants' => collect()
            ])->layout('layouts.super-admin-new-design');
        }
    }
}
