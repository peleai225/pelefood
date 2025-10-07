<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class Withdrawals extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all';
    public $perPage = 12;

    public function getWithdrawalsProperty()
    {
        // Simuler des retraits basés sur les commandes
        $query = \App\Models\Order::with(['restaurant', 'user'])
            ->where('status', 'delivered');
            
        if ($this->search) {
            $query->whereHas('restaurant', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }
        
        return $query->orderBy('created_at', 'desc')
                    ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.withdrawals', [
            'withdrawals' => $this->withdrawals
        ])->layout('layouts.super-admin-new-design');
    }
}