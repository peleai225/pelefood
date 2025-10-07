<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class RestaurantsDebug extends Component
{
    use WithPagination;
    
    public $search = '';
    public $filter = 'all';
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
    public $is_active = true;
    public $is_featured = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'address' => 'required|string|max:500',
        'city' => 'required|string|max:100',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function mount()
    {
        // Debug: Log pour vérifier que le composant se charge
        \Log::info('RestaurantsDebug component mounted');
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
        $this->resetForm();
        $this->modalTitle = 'Créer un nouveau restaurant';
        $this->showModal = true;
        \Log::info('Modal should be open: ' . ($this->showModal ? 'true' : 'false'));
    }

    public function editRestaurant($restaurantId)
    {
        \Log::info('editRestaurant method called with ID: ' . $restaurantId);
        $this->modalTitle = 'Modifier le restaurant';
        $this->editingRestaurant = $restaurantId;
        
        // Données factices pour le test
        $this->name = 'Restaurant Test';
        $this->email = 'test@restaurant.com';
        $this->phone = '0123456789';
        $this->address = '123 Rue Test';
        $this->city = 'Ville Test';
        $this->is_active = true;
        $this->is_featured = false;
        
        $this->showModal = true;
        \Log::info('Modal should be open: ' . ($this->showModal ? 'true' : 'false'));
    }

    public function saveRestaurant()
    {
        \Log::info('saveRestaurant method called');
        $this->validate();
        
        // Simulation de sauvegarde
        $this->emit('showNotification', 'Restaurant sauvegardé avec succès', 'success');
        $this->closeModal();
    }

    public function deleteRestaurant($restaurantId)
    {
        \Log::info('deleteRestaurant method called with ID: ' . $restaurantId);
        // Simulation de suppression
        $this->emit('showNotification', 'Restaurant supprimé avec succès', 'success');
    }

    public function toggleActive($restaurantId)
    {
        \Log::info('toggleActive method called with ID: ' . $restaurantId);
        // Simulation de basculement
        $this->emit('showNotification', 'Statut du restaurant modifié', 'success');
    }

    public function toggleFeatured($restaurantId)
    {
        \Log::info('toggleFeatured method called with ID: ' . $restaurantId);
        // Simulation de basculement
        $this->emit('showNotification', 'Statut vedette modifié', 'success');
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
        $this->is_active = true;
        $this->is_featured = false;
        $this->resetErrorBag();
    }

    public function render()
    {
        // Données factices pour le test
        $restaurants = collect([
            (object) [
                'id' => 1,
                'name' => 'Restaurant Test 1',
                'email' => 'test1@restaurant.com',
                'city' => 'Paris',
                'is_active' => true,
                'is_featured' => false,
                'created_at' => now(),
            ],
            (object) [
                'id' => 2,
                'name' => 'Restaurant Test 2',
                'email' => 'test2@restaurant.com',
                'city' => 'Lyon',
                'is_active' => false,
                'is_featured' => true,
                'created_at' => now(),
            ],
        ]);

        return view('livewire.admin.restaurants-debug', [
            'restaurants' => $restaurants
        ])->layout('layouts.super-admin-new-design');
    }
}
