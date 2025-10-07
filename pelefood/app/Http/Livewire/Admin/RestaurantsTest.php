<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class RestaurantsTest extends Component
{
    public $showModal = false;
    public $message = '';

    public function createRestaurant()
    {
        $this->showModal = true;
        $this->message = 'Modal ouvert !';
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->message = 'Modal fermé !';
    }

    public function render()
    {
        return view('livewire.admin.restaurants-test')->layout('layouts.super-admin-new-design');
    }
}