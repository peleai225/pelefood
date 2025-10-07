<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class Tenants extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all';
    public $perPage = 12;

    public function getTenantsProperty()
    {
        // Simuler des locataires basés sur les restaurants
        $query = \App\Models\Restaurant::query();
        
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        
        return $query->orderBy('created_at', 'desc')
                    ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.tenants', [
            'tenants' => $this->tenants
        ])->layout('layouts.super-admin-new-design');
    }
}