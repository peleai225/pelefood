<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use App\Models\User;

class Reviews extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all';
    public $perPage = 12;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getReviewsProperty()
    {
        // Simuler des avis basés sur les commandes livrées
        $query = Order::with(['user', 'restaurant'])
            ->where('status', 'delivered')
            ->when($this->search, function($query) {
                $query->whereHas('user', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('restaurant', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            });
            
        return $query->orderBy('created_at', 'desc')
                    ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.reviews', [
            'reviews' => $this->reviews
        ])->layout('layouts.super-admin-new-design');
    }
}