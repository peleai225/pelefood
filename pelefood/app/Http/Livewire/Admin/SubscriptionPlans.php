<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SubscriptionPlan;
use App\Models\Restaurant;

class SubscriptionPlans extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, active, inactive
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 12;
    
    // Modal pour créer/éditer un plan
    public $showModal = false;
    public $modalTitle = '';
    public $editingPlan = null;
    
    // Champs du formulaire
    public $name = '';
    public $description = '';
    public $price = 0;
    public $billing_cycle = 'monthly'; // monthly, yearly
    public $features = '';
    public $max_restaurants = 1;
    public $max_products = 100;
    public $max_orders = 1000;
    public $is_active = true;
    public $is_popular = false;

    protected $listeners = ['planUpdated' => 'loadStats'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'price' => 'required|numeric|min:0',
        'billing_cycle' => 'required|in:monthly,yearly',
        'features' => 'nullable|string|max:2000',
        'max_restaurants' => 'required|integer|min:1',
        'max_products' => 'required|integer|min:1',
        'max_orders' => 'required|integer|min:1',
        'is_active' => 'boolean',
        'is_popular' => 'boolean'
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

    public function createPlan()
    {
        $this->resetForm();
        $this->modalTitle = 'Créer un nouveau plan d\'abonnement';
        $this->showModal = true;
    }

    public function editPlan($planId)
    {
        $plan = SubscriptionPlan::findOrFail($planId);
        $this->editingPlan = $plan;
        $this->name = $plan->name;
        $this->description = $plan->description;
        $this->price = $plan->price;
        $this->billing_cycle = $plan->billing_cycle;
        $this->features = $plan->features;
        $this->max_restaurants = $plan->max_restaurants;
        $this->max_products = $plan->max_products;
        $this->max_orders = $plan->max_orders;
        $this->is_active = $plan->is_active;
        $this->is_popular = $plan->is_popular;
        $this->modalTitle = 'Modifier le plan d\'abonnement';
        $this->showModal = true;
    }

    public function savePlan()
    {
        $this->validate();

        try {
            $data = [
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'billing_cycle' => $this->billing_cycle,
                'features' => $this->features,
                'max_restaurants' => $this->max_restaurants,
                'max_products' => $this->max_products,
                'max_orders' => $this->max_orders,
                'is_active' => $this->is_active,
                'is_popular' => $this->is_popular,
            ];

            if ($this->editingPlan) {
                $this->editingPlan->update($data);
                session()->flash('message', 'Plan d\'abonnement mis à jour avec succès.');
            } else {
                SubscriptionPlan::create($data);
                session()->flash('message', 'Plan d\'abonnement créé avec succès.');
            }

            $this->closeModal();
            $this->loadStats();
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la sauvegarde: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->price = 0;
        $this->billing_cycle = 'monthly';
        $this->features = '';
        $this->max_restaurants = 1;
        $this->max_products = 100;
        $this->max_orders = 1000;
        $this->is_active = true;
        $this->is_popular = false;
        $this->editingPlan = null;
        $this->modalTitle = '';
    }

    public function toggleActive($planId)
    {
        try {
            $plan = SubscriptionPlan::findOrFail($planId);
            $plan->update(['is_active' => !$plan->is_active]);
            session()->flash('message', 'Statut du plan mis à jour.');
            $this->loadStats();
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la mise à jour.');
        }
    }

    public function togglePopular($planId)
    {
        try {
            $plan = SubscriptionPlan::findOrFail($planId);
            $plan->update(['is_popular' => !$plan->is_popular]);
            session()->flash('message', 'Statut populaire mis à jour.');
            $this->loadStats();
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la mise à jour.');
        }
    }

    public function deletePlan($planId)
    {
        try {
            $plan = SubscriptionPlan::findOrFail($planId);
            $plan->delete();
            session()->flash('message', 'Plan d\'abonnement supprimé avec succès.');
            $this->loadStats();
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la suppression.');
        }
    }

    public function getPlansProperty()
    {
        $query = SubscriptionPlan::query()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->filter === 'active', function($query) {
                $query->where('is_active', true);
            })
            ->when($this->filter === 'inactive', function($query) {
                $query->where('is_active', false);
            })
            ->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function getStatsProperty()
    {
        $totalPlans = SubscriptionPlan::count();
        $activePlans = SubscriptionPlan::where('is_active', true)->count();
        $popularPlans = SubscriptionPlan::where('is_popular', true)->count();
        $totalRevenue = SubscriptionPlan::where('is_active', true)->sum('price');

        return [
            'total' => $totalPlans,
            'active' => $activePlans,
            'popular' => $popularPlans,
            'total_revenue' => $totalRevenue,
        ];
    }

    public function render()
    {
        return view('livewire.admin.subscription-plans', [
            'plans' => $this->plans,
            'stats' => $this->stats
        ])->layout('layouts.super-admin-new-design');
    }
}