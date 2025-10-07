<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class TestModal extends Component
{
    public $showModal = false;

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.admin.test-modal')->layout('layouts.super-admin-new-design');
    }
}