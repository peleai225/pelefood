<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PaymentGateway;

class PaymentGateways extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, active, inactive
    public $perPage = 12;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function getGatewaysProperty()
    {
        $query = PaymentGateway::query()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('display_name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->filter === 'active', function($query) {
                $query->where('is_active', true);
            })
            ->when($this->filter === 'inactive', function($query) {
                $query->where('is_active', false);
            })
            ->orderBy('created_at', 'desc');

        return $query->paginate($this->perPage);
    }

    public function getStatsProperty()
    {
        return [
            'total' => PaymentGateway::count(),
            'active' => PaymentGateway::where('is_active', true)->count(),
            'inactive' => PaymentGateway::where('is_active', false)->count(),
        ];
    }

    public function render()
    {
        return view('livewire.admin.payment-gateways', [
            'gateways' => $this->gateways,
            'stats' => $this->stats
        ])->layout('layouts.super-admin-new-design');
    }
}