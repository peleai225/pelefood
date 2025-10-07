<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use App\Models\Restaurant;
use Livewire\WithFileUploads;

class Promotions extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $filter = 'all'; // all, active, upcoming, expired
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 12;
    
    // Modal pour créer/éditer une promotion
    public $showModal = false;
    public $modalTitle = '';
    public $editingPromotion = null;
    
    // Champs du formulaire
    public $name = '';
    public $description = '';
    public $price = 0;
    public $sale_price = null;
    public $sale_ends_at = null;
    public $category_id = '';
    public $restaurant_id = '';
    public $is_available = true;
    public $is_featured = false;
    public $image = null;

    protected $listeners = ['promotionUpdated' => 'loadStats'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'price' => 'required|numeric|min:0',
        'sale_price' => 'nullable|numeric|min:0|lt:price',
        'sale_ends_at' => 'nullable|date|after:now',
        'category_id' => 'required|exists:categories,id',
        'restaurant_id' => 'required|exists:restaurants,id',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
        'image' => 'nullable|image|max:2048'
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

    public function createPromotion()
    {
        $this->resetForm();
        $this->modalTitle = 'Créer une nouvelle promotion';
        $this->showModal = true;
    }

    public function editPromotion($productId)
    {
        $product = Product::findOrFail($productId);
        $this->editingPromotion = $product;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->sale_price = $product->sale_price;
        $this->sale_ends_at = $product->sale_ends_at ? $product->sale_ends_at->format('Y-m-d\TH:i') : null;
        $this->category_id = $product->category_id;
        $this->restaurant_id = $product->restaurant_id;
        $this->is_available = $product->is_available;
        $this->is_featured = $product->is_featured;
        $this->modalTitle = 'Modifier la promotion';
        $this->showModal = true;
    }

    public function savePromotion()
    {
        $this->validate();

        try {
            $data = [
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'sale_price' => $this->sale_price,
                'sale_ends_at' => $this->sale_ends_at ? now()->parse($this->sale_ends_at) : null,
                'category_id' => $this->category_id,
                'restaurant_id' => $this->restaurant_id,
                'is_available' => $this->is_available,
                'is_featured' => $this->is_featured,
            ];

            if ($this->image) {
                $data['thumbnail'] = $this->image->store('products', 'public');
            }

            if ($this->editingPromotion) {
                $this->editingPromotion->update($data);
                session()->flash('message', 'Promotion mise à jour avec succès.');
            } else {
                Product::create($data);
                session()->flash('message', 'Promotion créée avec succès.');
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
        $this->sale_price = null;
        $this->sale_ends_at = null;
        $this->category_id = '';
        $this->restaurant_id = '';
        $this->is_available = true;
        $this->is_featured = false;
        $this->image = null;
        $this->editingPromotion = null;
        $this->modalTitle = '';
    }

    public function toggleActive($productId)
    {
        try {
            $product = Product::findOrFail($productId);
            $product->update(['is_available' => !$product->is_available]);
            session()->flash('message', 'Statut de disponibilité mis à jour.');
            $this->loadStats();
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la mise à jour.');
        }
    }

    public function toggleFeatured($productId)
    {
        try {
            $product = Product::findOrFail($productId);
            $product->update(['is_featured' => !$product->is_featured]);
            session()->flash('message', 'Statut vedette mis à jour.');
            $this->loadStats();
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la mise à jour.');
        }
    }

    public function deletePromotion($productId)
    {
        try {
            $product = Product::findOrFail($productId);
            $product->delete();
            session()->flash('message', 'Promotion supprimée avec succès.');
            $this->loadStats();
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la suppression.');
        }
    }

    public function getPromotionsProperty()
    {
        $query = Product::with(['category', 'restaurant'])
            ->where(function($q) {
                $q->whereNotNull('sale_price')
                  ->orWhere('is_featured', true);
            })
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhereHas('restaurant', function($restaurantQuery) {
                          $restaurantQuery->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->filter === 'active', function($query) {
                $query->where('is_available', true)
                      ->where(function($q) {
                          $q->whereNull('sale_ends_at')
                            ->orWhere('sale_ends_at', '>', now());
                      });
            })
            ->when($this->filter === 'upcoming', function($query) {
                $query->where('sale_ends_at', '>', now())
                      ->where('is_available', false);
            })
            ->when($this->filter === 'expired', function($query) {
                $query->where('sale_ends_at', '<', now());
            })
            ->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function getStatsProperty()
    {
        $totalProducts = Product::count();
        $activePromotions = Product::where('is_available', true)
            ->where(function($q) {
                $q->whereNotNull('sale_price')
                  ->orWhere('is_featured', true);
            })
            ->where(function($q) {
                $q->whereNull('sale_ends_at')
                  ->orWhere('sale_ends_at', '>', now());
            })->count();
        
        $upcomingPromotions = Product::where('sale_ends_at', '>', now())
            ->where('is_available', false)->count();
        
        $totalSavings = Product::whereNotNull('sale_price')
            ->where('sale_ends_at', '>', now())
            ->get()
            ->sum(function($product) {
                return ($product->price - $product->sale_price) * 100; // Estimation
            });

        return [
            'total' => $totalProducts,
            'active' => $activePromotions,
            'upcoming' => $upcomingPromotions,
            'total_savings' => $totalSavings,
        ];
    }

    public function getRestaurantsProperty()
    {
        return Restaurant::where('is_active', true)->get();
    }

    public function getCategoriesProperty()
    {
        return Category::where('is_active', true)->get();
    }

    public function render()
    {
        return view('livewire.admin.promotions', [
            'promotions' => $this->promotions,
            'stats' => $this->stats,
            'restaurants' => $this->restaurants,
            'categories' => $this->categories
        ])->layout('layouts.super-admin-new-design');
    }
}