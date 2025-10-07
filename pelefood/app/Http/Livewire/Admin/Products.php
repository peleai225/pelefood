<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use App\Models\Restaurant;
use Livewire\WithFileUploads;

class Products extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $filter = 'all'; // all, active, inactive
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 12;
    
    // Modal pour créer/éditer un produit
    public $showModal = false;
    public $modalTitle = '';
    public $editingProduct = null;
    
    // Champs du formulaire
    public $name = '';
    public $description = '';
    public $price = 0;
    public $discount_price = null;
    public $category_id = '';
    public $restaurant_id = '';
    public $is_available = true;
    public $is_featured = false;
    public $image = null;
    public $ingredients = '';
    public $allergens = '';
    public $preparation_time = '';
    public $calories = null;

    protected $listeners = ['productCreated' => 'loadStats', 'productUpdated' => 'loadStats', 'productDeleted' => 'loadStats'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'price' => 'required|numeric|min:0',
        'discount_price' => 'nullable|numeric|min:0|lt:price',
        'category_id' => 'required|exists:categories,id',
        'restaurant_id' => 'required|exists:restaurants,id',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
        'image' => 'nullable|image|max:2048',
        'ingredients' => 'nullable|string|max:500',
        'allergens' => 'nullable|string|max:500',
        'preparation_time' => 'nullable|string|max:50',
        'calories' => 'nullable|integer|min:0'
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

    public function createProduct()
    {
        $this->resetForm();
        $this->modalTitle = 'Créer un nouveau produit';
        $this->showModal = true;
    }

    public function editProduct($productId)
    {
        $product = Product::findOrFail($productId);
        $this->editingProduct = $product;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->discount_price = $product->discount_price;
        $this->category_id = $product->category_id;
        $this->restaurant_id = $product->restaurant_id;
        $this->is_available = $product->is_available;
        $this->is_featured = $product->is_featured;
        $this->ingredients = $product->ingredients;
        $this->allergens = $product->allergens;
        $this->preparation_time = $product->preparation_time;
        $this->calories = $product->calories;
        
        $this->modalTitle = 'Modifier le produit';
        $this->showModal = true;
    }

    public function saveProduct()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'category_id' => $this->category_id,
            'restaurant_id' => $this->restaurant_id,
            'is_available' => $this->is_available,
            'is_featured' => $this->is_featured,
            'ingredients' => $this->ingredients,
            'allergens' => $this->allergens,
            'preparation_time' => $this->preparation_time,
            'calories' => $this->calories,
        ];

        // Gérer l'upload d'image
        if ($this->image) {
            $imagePath = $this->image->store('products', 'public');
            $data['image'] = $imagePath;
        }

        if ($this->editingProduct) {
            $this->editingProduct->update($data);
            $this->emit('productUpdated');
            $this->emit('showNotification', 'Produit mis à jour avec succès', 'success');
        } else {
            Product::create($data);
            $this->emit('productCreated');
            $this->emit('showNotification', 'Produit créé avec succès', 'success');
        }

        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingProduct = null;
        $this->name = '';
        $this->description = '';
        $this->price = 0;
        $this->discount_price = null;
        $this->category_id = '';
        $this->restaurant_id = '';
        $this->is_available = true;
        $this->is_featured = false;
        $this->image = null;
        $this->ingredients = '';
        $this->allergens = '';
        $this->preparation_time = '';
        $this->calories = null;
        $this->resetErrorBag();
    }

    public function toggleActive($productId)
    {
        $product = Product::findOrFail($productId);
        $product->update(['is_available' => !$product->is_available]);
        
        $this->emit('showNotification', 'Statut du produit mis à jour', 'success');
        $this->emit('productUpdated');
    }

    public function toggleFeatured($productId)
    {
        $product = Product::findOrFail($productId);
        $product->update(['is_featured' => !$product->is_featured]);
        
        $this->emit('showNotification', 'Produit mis en vedette mis à jour', 'success');
        $this->emit('productUpdated');
    }

    public function deleteProduct($productId)
    {
        $product = Product::findOrFail($productId);
        $product->delete();
        
        $this->emit('productDeleted');
        $this->emit('showNotification', 'Produit supprimé avec succès', 'success');
    }

    public function getProductsProperty()
    {
        $query = Product::with(['category', 'restaurant']);

        // Filtre par recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Filtre par statut
        if ($this->filter === 'active') {
            $query->where('is_available', true);
        } elseif ($this->filter === 'inactive') {
            $query->where('is_available', false);
        }

        // Tri
        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function getCategoriesProperty()
    {
        return Category::orderBy('name')->get();
    }

    public function getRestaurantsProperty()
    {
        return Restaurant::where('is_active', true)->orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.admin.products', [
            'products' => $this->products,
            'categories' => $this->categories,
            'restaurants' => $this->restaurants
        ])->layout('layouts.super-admin-new-design');
    }
}