<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Produits</h1>
            <p class="text-gray-600 mt-2">Gérez tous les produits de la plateforme</p>
        </div>
        <button wire:click="createProduct" 
                class="btn-modern flex items-center space-x-2">
            <i class="fas fa-plus"></i>
            <span>Créer un produit</span>
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
                           placeholder="Rechercher des produits..."
                           class="input-modern block w-full pl-10 pr-3 py-2">
                </div>
            </div>

            <!-- Filtres -->
            <div class="flex items-center space-x-4">
                <select wire:model="filter" 
                        class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">Tous les statuts</option>
                    <option value="active">Disponibles</option>
                    <option value="inactive">Indisponibles</option>
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

    <!-- Liste des produits -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @foreach($products as $product)
                <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <!-- Image du produit -->
                    <div class="aspect-video bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover rounded-lg"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-full h-full flex items-center justify-center" style="display: none;">
                                <i class="fas fa-utensils text-gray-400 text-4xl"></i>
                            </div>
                        @else
                            <i class="fas fa-utensils text-gray-400 text-4xl"></i>
                        @endif
                    </div>

                    <!-- Informations -->
                    <div>
                        <h4 class="font-medium text-gray-900 mb-1">{{ $product->name }}</h4>
                        <p class="text-sm text-gray-500 mb-2">{{ $product->restaurant->name ?? 'Restaurant supprimé' }}</p>
                        <p class="text-sm text-gray-600 mb-2">{{ Str::limit($product->description, 60) }}</p>
                        
                        <!-- Prix et statut -->
                        <div class="flex items-center justify-between text-sm mb-3">
                            <span class="font-semibold text-green-600">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                @if($product->is_available) bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $product->is_available ? 'Disponible' : 'Indisponible' }}
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <button wire:click="editProduct({{ $product->id }})" 
                                        class="text-green-600 hover:text-green-700"
                                        title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                <button wire:click="toggleActive({{ $product->id }})" 
                                        class="text-blue-600 hover:text-blue-700"
                                        title="{{ $product->is_available ? 'Désactiver' : 'Activer' }}">
                                    <i class="fas fa-{{ $product->is_available ? 'pause' : 'play' }}"></i>
                                </button>
                                
                                <button wire:click="toggleFeatured({{ $product->id }})" 
                                        class="text-yellow-600 hover:text-yellow-700"
                                        title="{{ $product->is_featured ? 'Retirer des vedettes' : 'Mettre en vedette' }}">
                                    <i class="fas fa-star"></i>
                                </button>
                                
                                <button wire:click="deleteProduct({{ $product->id }})" 
                                        wire:confirm="Êtes-vous sûr de vouloir supprimer ce produit ?"
                                        class="text-red-600 hover:text-red-700"
                                        title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            @if($product->is_featured)
                                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">
                                    <i class="fas fa-star mr-1"></i>Vedette
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-utensils text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun produit trouvé</h3>
                <p class="text-gray-500 mb-6">Les produits apparaîtront ici une fois créés</p>
            </div>
        @endif
    </div>

    <!-- Modal pour créer/éditer un produit -->
    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4" wire:click="closeModal">
        <div class="modal-modern relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl transform transition-all duration-300 scale-100" wire:click.stop>
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">{{ $modalTitle }}</h3>
                    <button wire:click="closeModal" class="modal-close-btn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form wire:submit.prevent="saveProduct">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nom -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom du produit *</label>
                            <input wire:model="name" type="text" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Prix -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prix *</label>
                            <input wire:model="price" type="number" step="0.01" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('price') border-red-500 @enderror">
                            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Prix de promotion -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prix promotionnel</label>
                            <input wire:model="discount_price" type="number" step="0.01" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('discount_price') border-red-500 @enderror">
                            @error('discount_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Catégorie -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie *</label>
                            <select wire:model="category_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror">
                                <option value="">Sélectionner une catégorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Restaurant -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Restaurant *</label>
                            <select wire:model="restaurant_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('restaurant_id') border-red-500 @enderror">
                                <option value="">Sélectionner un restaurant</option>
                                @foreach($restaurants as $restaurant)
                                    <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                                @endforeach
                            </select>
                            @error('restaurant_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea wire:model="description" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"></textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Ingrédients -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ingrédients</label>
                            <textarea wire:model="ingredients" rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('ingredients') border-red-500 @enderror"></textarea>
                            @error('ingredients') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Allergènes -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Allergènes</label>
                            <textarea wire:model="allergens" rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('allergens') border-red-500 @enderror"></textarea>
                            @error('allergens') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Image -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image du produit</label>
                            <input wire:model="image" type="file" accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('image') border-red-500 @enderror">
                            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Options -->
                        <div class="md:col-span-2">
                            <div class="flex items-center space-x-6">
                                <label class="flex items-center">
                                    <input wire:model="is_available" type="checkbox" 
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Disponible</span>
                                </label>
                                <label class="flex items-center">
                                    <input wire:model="is_featured" type="checkbox" 
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Mettre en vedette</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                        <button type="button" wire:click="closeModal"
                                class="modal-cancel-btn">
                            Annuler
                        </button>
                        <button type="submit"
                                class="btn-modern">
                            {{ $editingProduct ? 'Mettre à jour' : 'Créer' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
// Notification système pour Livewire
window.addEventListener('showNotification', event => {
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