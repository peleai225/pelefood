<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class SimpleTest extends Component
{
    public $count = 0;
    public $message = 'Livewire fonctionne !';

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        return view('livewire.admin.simple-test')->layout('layouts.super-admin-new-design');
    }
}
