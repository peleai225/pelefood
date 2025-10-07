<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Catégories</h1>
            <p class="text-gray-600 mt-2">Gérez les catégories de produits</p>
        </div>
        <button wire:click="createCategory" 
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Nouvelle catégorie
        </button>
    </div>

    <!-- Filtres et recherche -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <!-- Recherche -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input wire:model.debounce.300ms="search" 
                           type="text" 
                           placeholder="Rechercher des catégories..."
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Filtres -->
            <div class="flex items-center space-x-4">
                <select wire:model="filter" 
                        class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">Tous les statuts</option>
                    <option value="active">Actives</option>
                    <option value="inactive">Inactives</option>
                </select>

                <select wire:model="perPage" 
                        class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="12">12 par page</option>
                    <option value="24">24 par page</option>
                    <option value="48">48 par page</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Liste des catégories -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        @if($categories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @foreach($categories as $category)
                <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <!-- Image de la catégorie -->
                    <div class="aspect-video bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                        @if($category->image)
                            <img src="{{ Storage::url($category->image) }}" 
                                 alt="{{ $category->name }}" 
                                 class="w-full h-full object-cover rounded-lg"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-full h-full flex items-center justify-center" style="display: none;">
                                <i class="fas fa-tag text-gray-400 text-4xl"></i>
                            </div>
                        @else
                            <i class="fas fa-tag text-gray-400 text-4xl"></i>
                        @endif
                    </div>

                    <!-- Informations -->
                    <div>
                        <h4 class="font-medium text-gray-900 mb-1">{{ $category->name }}</h4>
                        <p class="text-sm text-gray-500 mb-2">{{ Str::limit($category->description, 60) }}</p>
                        
                        <!-- Statistiques -->
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                            <span>{{ $category->products_count }} produits</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                @if($category->is_active) bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <button wire:click="toggleActive({{ $category->id }})" 
                                        class="text-blue-600 hover:text-blue-700"
                                        title="{{ $category->is_active ? 'Désactiver' : 'Activer' }}">
                                    <i class="fas fa-{{ $category->is_active ? 'pause' : 'play' }}"></i>
                                </button>
                                
                                <button wire:click="editCategory({{ $category->id }})" 
                                        class="text-green-600 hover:text-green-700"
                                        title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                <button wire:click="deleteCategory({{ $category->id }})" 
                                        wire:confirm="Êtes-vous sûr de vouloir supprimer cette catégorie ?"
                                        class="text-red-600 hover:text-red-700"
                                        title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <span class="text-xs text-gray-500">
                                Ordre: {{ $category->sort_order }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $categories->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-tags text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune catégorie trouvée</h3>
                <p class="text-gray-500 mb-6">Commencez par créer votre première catégorie</p>
                <button wire:click="createCategory" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Créer une catégorie
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Modal de création/édition -->
@if($showModal)
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeModal">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white" wire:click.stop>
        <!-- En-tête du modal -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">{{ $modalTitle }}</h3>
            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Contenu du modal -->
        <form wire:submit.prevent="saveCategory">
            <div class="space-y-6">
                <!-- Nom -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom de la catégorie *</label>
                    <input wire:model="name" 
                           type="text" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Nom de la catégorie">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea wire:model="description" 
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Description de la catégorie"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Image de la catégorie</label>
                    <input wire:model="image" 
                           type="file" 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Ordre de tri -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ordre de tri</label>
                    <input wire:model="sort_order" 
                           type="number" 
                           min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="0">
                    @error('sort_order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Options -->
                <div>
                    <label class="flex items-center">
                        <input wire:model="is_active" 
                               type="checkbox" 
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Catégorie active</span>
                    </label>
                </div>
            </div>

            <!-- Boutons du modal -->
            <div class="flex items-center justify-end space-x-4 mt-6 pt-6 border-t border-gray-200">
                <button type="button" 
                        wire:click="closeModal"
                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    {{ $editingCategory ? 'Mettre à jour' : 'Créer' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@push('scripts')
<script>
// Notification système pour Livewire
window.addEventListener('showNotification', event => {
    // Créer une notification toast
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
    notification.textContent = event.detail.message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
});
</script>
@endpush