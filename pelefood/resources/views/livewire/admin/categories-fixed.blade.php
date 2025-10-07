<div class="max-w-7xl mx-auto space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Catégories</h1>
            <p class="text-gray-600 mt-2">Gérez toutes les catégories de votre plateforme SaaS</p>
        </div>
        <button wire:click="createCategory" 
                class="btn-modern flex items-center space-x-2">
            <i class="fas fa-plus"></i>
            <span>Nouvelle catégorie</span>
        </button>
    </div>

    <!-- Messages -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filtres et recherche -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <!-- Barre de recherche -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text" 
                           wire:model.debounce.300ms="search"
                           placeholder="Rechercher une catégorie..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <!-- Filtres -->
            <div class="flex items-center space-x-4">
                <select wire:model="filter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="all">Toutes</option>
                    <option value="active">Actives</option>
                    <option value="inactive">Inactives</option>
                </select>
                
                <select wire:model="perPage" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="12">12 par page</option>
                    <option value="24">24 par page</option>
                    <option value="48">48 par page</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Liste des catégories -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($categories as $category)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <!-- En-tête de la carte -->
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-600">Ordre: {{ $category->sort_order }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>

            <!-- Informations de la catégorie -->
            <div class="space-y-2 mb-4">
                @if($category->description)
                <div class="text-sm text-gray-600">
                    <p>{{ Str::limit($category->description, 100) }}</p>
                </div>
                @endif
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-calendar mr-2 text-gray-400"></i>
                    <span>Créée le {{ $category->created_at->format('d/m/Y') }}</span>
                </div>
                @if($category->image)
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-image mr-2 text-gray-400"></i>
                    <span>Image disponible</span>
                </div>
                @endif
            </div>

            <!-- Boutons d'action -->
            <div class="flex items-center justify-between mt-4">
                <div class="flex items-center space-x-2">
                    <button wire:click="editCategory({{ $category->id }})" 
                            class="text-green-600 hover:text-green-700 p-1"
                            title="Modifier">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button wire:click="toggleActive({{ $category->id }})" 
                            class="text-blue-600 hover:text-blue-700 p-1"
                            title="{{ $category->is_active ? 'Désactiver' : 'Activer' }}">
                        <i class="fas fa-{{ $category->is_active ? 'pause' : 'play' }}"></i>
                    </button>
                    <button wire:click="deleteCategory({{ $category->id }})" 
                            wire:confirm="Êtes-vous sûr de vouloir supprimer cette catégorie ?"
                            class="text-red-600 hover:text-red-700 p-1"
                            title="Supprimer">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <i class="fas fa-tags text-gray-400 text-4xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune catégorie trouvée</h3>
            <p class="text-gray-600 mb-4">Commencez par créer votre première catégorie.</p>
            <button wire:click="createCategory" 
                    class="btn-modern px-4 py-2 rounded-lg">
                <i class="fas fa-plus mr-2"></i>
                Créer une catégorie
            </button>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $categories->links() }}
    </div>

    <!-- Modal pour créer/éditer une catégorie -->
    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4" wire:click="closeModal">
        <div class="modal-modern relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl transform transition-all duration-300 scale-100" wire:click.stop>
            <!-- En-tête du modal -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">{{ $modalTitle }}</h3>
                <button wire:click="closeModal" class="modal-close-btn">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Formulaire -->
            <form wire:submit.prevent="saveCategory">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Nom -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom de la catégorie *</label>
                        <input type="text" 
                               id="name"
                               wire:model="name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea id="description"
                                  wire:model="description"
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Image -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                        <input type="file" 
                               id="image"
                               wire:model="image"
                               accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Ordre de tri -->
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Ordre de tri</label>
                        <input type="number" 
                               id="sort_order"
                               wire:model="sort_order"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('sort_order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Options -->
                    <div class="md:col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   wire:model="is_active"
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Catégorie active</span>
                        </label>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            wire:click="closeModal"
                            class="modal-cancel-btn">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="btn-modern font-bold py-2 px-4 rounded">
                        {{ $editingCategory ? 'Modifier' : 'Créer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
