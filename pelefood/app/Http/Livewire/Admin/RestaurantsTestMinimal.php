<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class RestaurantsTestMinimal extends Component
{
    public $showModal = false;
    public $modalTitle = '';
    
    // Champs minimaux
    public $name = '';
    public $email = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
    ];

    public function createRestaurant()
    {
        $this->modalTitle = 'Créer un restaurant';
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->name = '';
        $this->email = '';
    }

    public function saveRestaurant()
    {
        $this->validate();
        // Simulation de sauvegarde
        $this->closeModal();
    }

    public function render()
    {
        // Données factices minimales
        $restaurants = collect([
            (object) ['id' => 1, 'name' => 'Restaurant Test 1', 'email' => 'test1@test.com'],
            (object) ['id' => 2, 'name' => 'Restaurant Test 2', 'email' => 'test2@test.com'],
        ]);

        return view('livewire.admin.restaurants-test-minimal', [
            'restaurants' => $restaurants
        ])->layout('layouts.super-admin-new-design');
    }
}
