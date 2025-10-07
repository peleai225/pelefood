<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class UltraSimpleTest extends Component
{
    public $showModal = false;
    public $message = 'Test ultra simple';

    public function openModal()
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
        return view('livewire.admin.ultra-simple-test')->layout('layouts.super-admin-new-design');
    }
}
