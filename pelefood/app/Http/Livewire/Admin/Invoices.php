<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;

class Invoices extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, paid, pending, overdue
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 12;
    
    // Modal pour voir les détails d'une facture
    public $showModal = false;
    public $modalTitle = '';
    public $selectedInvoice = null;

    protected $listeners = ['invoiceUpdated' => 'loadStats'];

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

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function viewInvoice($orderId)
    {
        try {
            $this->selectedInvoice = Order::with(['restaurant', 'user', 'items'])
                ->findOrFail($orderId);
            $this->modalTitle = 'Facture #' . $this->selectedInvoice->id;
            $this->showModal = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors du chargement de la facture.');
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedInvoice = null;
        $this->modalTitle = '';
    }

    public function markAsPaid($orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            $order->update(['payment_status' => 'paid']);
            session()->flash('message', 'Facture marquée comme payée.');
            $this->loadStats();
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la mise à jour.');
        }
    }

    public function getInvoicesProperty()
    {
        $query = Order::with(['restaurant', 'user'])
            ->when($this->search, function($query) {
                $query->where('id', 'like', '%' . $this->search . '%')
                      ->orWhereHas('restaurant', function($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      })
                      ->orWhereHas('user', function($q) {
                          $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->filter === 'paid', function($query) {
                $query->where('payment_status', 'paid');
            })
            ->when($this->filter === 'pending', function($query) {
                $query->where('payment_status', 'pending');
            })
            ->when($this->filter === 'overdue', function($query) {
                $query->where('payment_status', 'pending')
                      ->where('created_at', '<', now()->subDays(7));
            })
            ->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function getStatsProperty()
    {
        return [
            'total' => Order::count(),
            'paid' => Order::where('payment_status', 'paid')->count(),
            'pending' => Order::where('payment_status', 'pending')->count(),
            'overdue' => Order::where('payment_status', 'pending')
                ->where('created_at', '<', now()->subDays(7))->count(),
            'total_amount' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'pending_amount' => Order::where('payment_status', 'pending')->sum('total_amount'),
        ];
    }

    public function getPaymentStatusBadgeClass($status)
    {
        return match($status) {
            'paid' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'failed' => 'bg-red-100 text-red-800',
            'refunded' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getPaymentStatusLabel($status)
    {
        return match($status) {
            'paid' => 'Payé',
            'pending' => 'En attente',
            'failed' => 'Échoué',
            'refunded' => 'Remboursé',
            default => 'Inconnu'
        };
    }

    public function render()
    {
        return view('livewire.admin.invoices', [
            'invoices' => $this->invoices,
            'stats' => $this->stats
        ])->layout('layouts.super-admin-new-design');
    }
}