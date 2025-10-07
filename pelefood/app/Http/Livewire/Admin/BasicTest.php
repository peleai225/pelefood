<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class BasicTest extends Component
{
    public $message = 'Hello Livewire!';
    public $count = 0;

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        return view('livewire.admin.basic-test');
    }
}
