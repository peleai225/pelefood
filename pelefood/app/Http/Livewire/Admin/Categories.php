<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use Livewire\WithFileUploads;

class Categories extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $filter = 'all'; // all, active, inactive
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 12;
    
    // Modal pour créer/éditer une catégorie
    public $showModal = false;
    public $modalTitle = '';
    public $editingCategory = null;
    
    // Champs du formulaire
    public $name = '';
    public $description = '';
    public $image;
    public $is_active = true;
    public $sort_order = 0;

    protected $listeners = ['categoryCreated' => 'loadStats', 'categoryUpdated' => 'loadStats', 'categoryDeleted' => 'loadStats'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'image' => 'nullable|image|max:2048',
        'is_active' => 'boolean',
        'sort_order' => 'nullable|integer|min:0'
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

    public function createCategory()
    {
        $this->resetForm();
        $this->modalTitle = 'Créer une nouvelle catégorie';
        $this->showModal = true;
    }

    public function editCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $this->editingCategory = $category;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->is_active = $category->is_active;
        $this->sort_order = $category->sort_order;
        
        $this->modalTitle = 'Modifier la catégorie';
        $this->showModal = true;
    }

    public function saveCategory()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        // Gestion de l'image
        if ($this->image) {
            $data['image'] = $this->image->store('categories', 'public');
        }

        if ($this->editingCategory) {
            $this->editingCategory->update($data);
            $this->emit('categoryUpdated');
            $this->emit('showNotification', 'Catégorie mise à jour avec succès', 'success');
        } else {
            Category::create($data);
            $this->emit('categoryCreated');
            $this->emit('showNotification', 'Catégorie créée avec succès', 'success');
        }

        $this->closeModal();
    }

    public function deleteCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->delete();
        
        $this->emit('categoryDeleted');
        $this->emit('showNotification', 'Catégorie supprimée avec succès', 'success');
    }

    public function toggleActive($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->update(['is_active' => !$category->is_active]);
        
        $this->emit('showNotification', 'Statut de la catégorie mis à jour', 'success');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingCategory = null;
        $this->name = '';
        $this->description = '';
        $this->image = null;
        $this->is_active = true;
        $this->sort_order = 0;
        $this->resetErrorBag();
    }

    public function getCategoriesProperty()
    {
        $query = Category::withCount('products');

        // Filtre par recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Filtre par statut
        if ($this->filter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filter === 'inactive') {
            $query->where('is_active', false);
        }

        // Tri
        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.categories', [
            'categories' => $this->categories
        ])->layout('layouts.super-admin-new-design');
    }
}