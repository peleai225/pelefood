<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Restaurant;

class RestaurantsFixed extends Component
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
    public $country = 'France';
    public $postal_code = '';
    public $description = '';
    public $cuisine_type = '';
    public $delivery_time = '';
    public $minimum_order = 0;
    public $delivery_fee = 0;
    public $is_active = true;
    public $is_featured = false;

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

    protected $messages = [
        'name.required' => 'Le nom du restaurant est obligatoire.',
        'email.required' => 'L\'email est obligatoire.',
        'email.email' => 'L\'email doit être valide.',
        'address.required' => 'L\'adresse est obligatoire.',
        'city.required' => 'La ville est obligatoire.',
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

    public function createRestaurant()
    {
        $this->resetForm();
        $this->modalTitle = 'Créer un nouveau restaurant';
        $this->showModal = true;
    }

    public function editRestaurant($restaurantId)
    {
        try {
            $restaurant = Restaurant::findOrFail($restaurantId);
            
            $this->modalTitle = 'Modifier le restaurant';
            $this->editingRestaurant = $restaurant;
            
            $this->name = $restaurant->name ?? '';
            $this->email = $restaurant->email ?? '';
            $this->phone = $restaurant->phone ?? '';
            $this->address = $restaurant->address ?? '';
            $this->city = $restaurant->city ?? '';
            $this->country = $restaurant->country ?? 'France';
            $this->postal_code = $restaurant->postal_code ?? '';
            $this->description = $restaurant->description ?? '';
            $this->cuisine_type = $restaurant->cuisine_type ?? '';
            $this->delivery_time = $restaurant->delivery_time ?? '';
            $this->minimum_order = $restaurant->minimum_order ?? 0;
            $this->delivery_fee = $restaurant->delivery_fee ?? 0;
            $this->is_active = $restaurant->is_active ?? true;
            $this->is_featured = $restaurant->is_featured ?? false;
            
            $this->showModal = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors du chargement du restaurant.');
        }
    }

    public function saveRestaurant()
    {
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
            ];

            if ($this->editingRestaurant) {
                $this->editingRestaurant->update($data);
                session()->flash('message', 'Restaurant modifié avec succès !');
            } else {
                Restaurant::create($data);
                session()->flash('message', 'Restaurant créé avec succès !');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la sauvegarde : ' . $e->getMessage());
        }
    }

    public function deleteRestaurant($restaurantId)
    {
        try {
            Restaurant::findOrFail($restaurantId)->delete();
            session()->flash('message', 'Restaurant supprimé avec succès !');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    public function toggleActive($restaurantId)
    {
        try {
            $restaurant = Restaurant::findOrFail($restaurantId);
            $restaurant->update(['is_active' => !$restaurant->is_active]);
            session()->flash('message', 'Statut du restaurant modifié !');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la modification : ' . $e->getMessage());
        }
    }

    public function toggleFeatured($restaurantId)
    {
        try {
            $restaurant = Restaurant::findOrFail($restaurantId);
            $restaurant->update(['is_featured' => !$restaurant->is_featured]);
            session()->flash('message', 'Statut vedette modifié !');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la modification : ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
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
        $this->country = 'France';
        $this->postal_code = '';
        $this->description = '';
        $this->cuisine_type = '';
        $this->delivery_time = '';
        $this->minimum_order = 0;
        $this->delivery_fee = 0;
        $this->is_active = true;
        $this->is_featured = false;
        $this->resetErrorBag();
    }

    public function render()
    {
        // Requête simple comme dans Products
        $query = Restaurant::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('city', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filter === 'inactive') {
            $query->where('is_active', false);
        }

        $query->orderBy($this->sortBy, $this->sortDirection);
        $restaurants = $query->paginate($this->perPage);

        return view('livewire.admin.restaurants-fixed', [
            'restaurants' => $restaurants
        ])->layout('layouts.super-admin-new-design');
    }
}
