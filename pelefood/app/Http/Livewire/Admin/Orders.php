<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;

class Orders extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, pending, confirmed, preparing, ready, delivered, cancelled
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 12;
    
    // Modal pour créer/voir les détails d'une commande
    public $showModal = false;
    public $modalTitle = '';
    public $selectedOrder = null;
    public $editingOrder = null;
    
    // Champs du formulaire pour créer une commande
    public $user_id = '';
    public $restaurant_id = '';
    public $status = 'pending';
    public $delivery_address = '';
    public $notes = '';

    protected $listeners = ['orderCreated' => 'loadStats', 'orderUpdated' => 'loadStats', 'orderDeleted' => 'loadStats'];

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'restaurant_id' => 'required|exists:restaurants,id',
        'status' => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled',
        'delivery_address' => 'required|string|max:500',
        'notes' => 'nullable|string|max:1000'
    ];

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

    public function createOrder()
    {
        $this->resetForm();
        $this->modalTitle = 'Créer une nouvelle commande';
        $this->showModal = true;
    }

    public function viewOrder($orderId)
    {
        $this->selectedOrder = Order::with(['restaurant', 'user', 'orderItems.product'])->findOrFail($orderId);
        $this->showModal = true;
    }

    public function updateOrderStatus($orderId, $status)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => $status]);
        
        $this->emit('orderUpdated');
        $this->emit('showNotification', 'Statut de la commande mis à jour', 'success');
    }

    public function deleteOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->delete();
        
        $this->emit('orderDeleted');
        $this->emit('showNotification', 'Commande supprimée avec succès', 'success');
    }

    public function saveOrder()
    {
        $this->validate();

        $data = [
            'user_id' => $this->user_id,
            'restaurant_id' => $this->restaurant_id,
            'status' => $this->status,
            'delivery_address' => $this->delivery_address,
            'notes' => $this->notes,
            'order_number' => 'ORD-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
            'total_amount' => 0, // Sera calculé plus tard avec les items
        ];

        Order::create($data);
        $this->emit('orderCreated');
        $this->emit('showNotification', 'Commande créée avec succès', 'success');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedOrder = null;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingOrder = null;
        $this->user_id = '';
        $this->restaurant_id = '';
        $this->status = 'pending';
        $this->delivery_address = '';
        $this->notes = '';
        $this->resetErrorBag();
    }

    public function getOrdersProperty()
    {
        $query = Order::with(['restaurant', 'user']);

        // Filtre par recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('order_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('restaurant', function($restaurantQuery) {
                      $restaurantQuery->where('name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->search . '%')
                               ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Filtre par statut
        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }

        // Tri
        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function getUsersProperty()
    {
        return User::where('role', 'customer')->orderBy('name')->get();
    }

    public function getRestaurantsProperty()
    {
        return Restaurant::where('is_active', true)->orderBy('name')->get();
    }

    public function getStatusBadgeClass($status)
    {
        return match($status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-blue-100 text-blue-800',
            'preparing' => 'bg-orange-100 text-orange-800',
            'ready' => 'bg-purple-100 text-purple-800',
            'delivered' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getStatusLabel($status)
    {
        return match($status) {
            'pending' => 'En attente',
            'confirmed' => 'Confirmée',
            'preparing' => 'En préparation',
            'ready' => 'Prête',
            'delivered' => 'Livrée',
            'cancelled' => 'Annulée',
            default => ucfirst($status)
        };
    }

    public function render()
    {
        return view('livewire.admin.orders', [
            'orders' => $this->orders,
            'users' => $this->users,
            'restaurants' => $this->restaurants
        ])->layout('layouts.super-admin-new-design');
    }
}