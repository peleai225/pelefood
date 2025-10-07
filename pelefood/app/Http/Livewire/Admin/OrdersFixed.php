<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;

class OrdersFixed extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all';
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

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'restaurant_id' => 'required|exists:restaurants,id',
        'status' => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled',
        'delivery_address' => 'required|string|max:500',
        'notes' => 'nullable|string|max:1000'
    ];

    protected $messages = [
        'user_id.required' => 'L\'utilisateur est obligatoire.',
        'restaurant_id.required' => 'Le restaurant est obligatoire.',
        'status.required' => 'Le statut est obligatoire.',
        'delivery_address.required' => 'L\'adresse de livraison est obligatoire.',
    ];

    public function mount()
    {
        // Pas de chargement de données complexes
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
        try {
            $order = Order::with(['restaurant', 'user', 'items'])->findOrFail($orderId);
            $this->selectedOrder = $order;
            $this->modalTitle = 'Détails de la commande #' . $order->id;
            $this->showModal = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors du chargement de la commande.');
        }
    }

    public function saveOrder()
    {
        try {
            $this->validate();

            $data = [
                'user_id' => $this->user_id,
                'restaurant_id' => $this->restaurant_id,
                'status' => $this->status,
                'delivery_address' => $this->delivery_address,
                'notes' => $this->notes,
                'total_amount' => 0, // À calculer selon les produits
            ];

            Order::create($data);
            session()->flash('message', 'Commande créée avec succès !');
            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la sauvegarde : ' . $e->getMessage());
        }
    }

    public function deleteOrder($orderId)
    {
        try {
            Order::findOrFail($orderId)->delete();
            session()->flash('message', 'Commande supprimée avec succès !');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    public function updateOrderStatus($orderId, $status)
    {
        try {
            $order = Order::findOrFail($orderId);
            $order->update(['status' => $status]);
            session()->flash('message', 'Statut de la commande mis à jour !');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedOrder = null;
        $this->editingOrder = null;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->user_id = '';
        $this->restaurant_id = '';
        $this->status = 'pending';
        $this->delivery_address = '';
        $this->notes = '';
        $this->resetErrorBag();
    }

    public function getUsersProperty()
    {
        return User::select('id', 'name', 'email')->get();
    }

    public function getRestaurantsProperty()
    {
        return Restaurant::select('id', 'name')->get();
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
            default => $status
        };
    }

    public function render()
    {
        // Requête simple comme dans Products
        $query = Order::with(['user', 'restaurant']);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('id', 'like', '%' . $this->search . '%')
                  ->orWhere('delivery_address', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('restaurant', function($restaurantQuery) {
                      $restaurantQuery->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }

        $query->orderBy($this->sortBy, $this->sortDirection);
        $orders = $query->paginate($this->perPage);

        return view('livewire.admin.orders-fixed', [
            'orders' => $orders
        ])->layout('layouts.super-admin-new-design');
    }
}
