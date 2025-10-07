<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Payment;

class Payments extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 12;

    protected $listeners = ['paymentUpdated' => 'loadStats'];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        // Les statistiques sont gérées par AdminStatsComposer
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getPaymentsProperty()
    {
        // Utiliser une requête simple sans relations problématiques
        $query = Payment::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('transaction_id', 'like', '%' . $this->search . '%')
                  ->orWhere('payment_method', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }

        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.payments', [
            'payments' => $this->payments
        ])->layout('layouts.super-admin-new-design');
    }
}