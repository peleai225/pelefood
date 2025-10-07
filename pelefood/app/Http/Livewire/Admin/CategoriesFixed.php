<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Category;

class CategoriesFixed extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $filter = 'all';
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

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'image' => 'nullable|image|max:2048',
        'is_active' => 'boolean',
        'sort_order' => 'nullable|integer|min:0'
    ];

    protected $messages = [
        'name.required' => 'Le nom de la catégorie est obligatoire.',
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

    public function createCategory()
    {
        $this->resetForm();
        $this->modalTitle = 'Créer une nouvelle catégorie';
        $this->showModal = true;
    }

    public function editCategory($categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);
            
            $this->modalTitle = 'Modifier la catégorie';
            $this->editingCategory = $category;
            
            $this->name = $category->name ?? '';
            $this->description = $category->description ?? '';
            $this->is_active = $category->is_active ?? true;
            $this->sort_order = $category->sort_order ?? 0;
            
            $this->showModal = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors du chargement de la catégorie.');
        }
    }

    public function saveCategory()
    {
        try {
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
                session()->flash('message', 'Catégorie modifiée avec succès !');
            } else {
                Category::create($data);
                session()->flash('message', 'Catégorie créée avec succès !');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la sauvegarde : ' . $e->getMessage());
        }
    }

    public function deleteCategory($categoryId)
    {
        try {
            Category::findOrFail($categoryId)->delete();
            session()->flash('message', 'Catégorie supprimée avec succès !');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    public function toggleActive($categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);
            $category->update(['is_active' => !$category->is_active]);
            session()->flash('message', 'Statut de la catégorie modifié !');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la modification : ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->editingCategory = null;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->image = null;
        $this->is_active = true;
        $this->sort_order = 0;
        $this->resetErrorBag();
    }

    public function render()
    {
        // Requête simple comme dans Products
        $query = Category::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filter === 'inactive') {
            $query->where('is_active', false);
        }

        $query->orderBy($this->sortBy, $this->sortDirection);
        $categories = $query->paginate($this->perPage);

        return view('livewire.admin.categories-fixed', [
            'categories' => $categories
        ])->layout('layouts.super-admin-new-design');
    }
}
