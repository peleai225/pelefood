<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Promotions</h1>
            <p class="text-gray-600 mt-2">Gérez toutes les promotions et offres spéciales</p>
        </div>
        <button wire:click="createPromotion" 
                class="btn-modern flex items-center space-x-2">
            <i class="fas fa-plus"></i>
            <span>Nouvelle promotion</span>
        </button>
    </div>

    <!-- Messages -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="metric-card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-percent text-2xl text-orange-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Promotions</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="metric-card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-clock text-2xl text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Actives</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="metric-card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-calendar text-2xl text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">À venir</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['upcoming'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="metric-card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-euro-sign text-2xl text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Économies totales</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_savings'] ?? 0, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>
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
                           placeholder="Rechercher des promotions..."
                           class="input-modern block w-full pl-10 pr-3 py-2">
                </div>
            </div>

            <!-- Filtres -->
            <div class="flex items-center space-x-4">
                <select wire:model="filter" class="input-modern">
                    <option value="all">Toutes les promotions</option>
                    <option value="active">Actives</option>
                    <option value="upcoming">À venir</option>
                    <option value="expired">Expirées</option>
                </select>

                <select wire:model="perPage" class="input-modern">
                    <option value="12">12 par page</option>
                    <option value="24">24 par page</option>
                    <option value="48">48 par page</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Liste des promotions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @if($promotions->count() > 0)
            @foreach($promotions as $promotion)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300">
                    <!-- Image du produit -->
                    <div class="h-48 bg-gray-200 relative">
                        @if($promotion->thumbnail)
                            <img src="{{ Storage::url($promotion->thumbnail) }}" 
                                 alt="{{ $promotion->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-image text-4xl text-gray-400"></i>
                            </div>
                        @endif
                        
                        <!-- Badge promotion -->
                        <div class="absolute top-3 left-3">
                            @if($promotion->sale_price && $promotion->price)
                                @php
                                    $discount = round((($promotion->price - $promotion->sale_price) / $promotion->price) * 100);
                                @endphp
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    -{{ $discount }}%
                                </span>
                            @endif
                        </div>

                        <!-- Badge statut -->
                        <div class="absolute top-3 right-3">
                            @if($promotion->sale_ends_at && $promotion->sale_ends_at > now())
                                <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    Actif
                                </span>
                            @elseif($promotion->sale_ends_at && $promotion->sale_ends_at < now())
                                <span class="bg-gray-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    Expiré
                                </span>
                            @else
                                <span class="bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    Permanent
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $promotion->name }}</h3>
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $promotion->description }}</p>
                        
                        <!-- Prix -->
                        <div class="flex items-center space-x-2 mb-3">
                            @if($promotion->sale_price)
                                <span class="text-lg font-bold text-red-600">{{ number_format($promotion->sale_price, 0, ',', ' ') }} FCFA</span>
                                <span class="text-sm text-gray-500 line-through">{{ number_format($promotion->price, 0, ',', ' ') }} FCFA</span>
                            @else
                                <span class="text-lg font-bold text-gray-900">{{ number_format($promotion->price, 0, ',', ' ') }} FCFA</span>
                            @endif
                        </div>

                        <!-- Informations -->
                        <div class="space-y-1 text-xs text-gray-500 mb-4">
                            <p><i class="fas fa-store mr-1"></i> {{ $promotion->restaurant->name ?? 'N/A' }}</p>
                            <p><i class="fas fa-tag mr-1"></i> {{ $promotion->category->name ?? 'N/A' }}</p>
                            @if($promotion->sale_ends_at)
                                <p><i class="fas fa-clock mr-1"></i> Expire le {{ $promotion->sale_ends_at->format('d/m/Y') }}</p>
                            @endif
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <button wire:click="editPromotion({{ $promotion->id }})" 
                                        class="text-green-600 hover:text-green-700 p-1"
                                        title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                <button wire:click="toggleActive({{ $promotion->id }})" 
                                        class="text-blue-600 hover:text-blue-700 p-1"
                                        title="{{ $promotion->is_available ? 'Désactiver' : 'Activer' }}">
                                    <i class="fas fa-{{ $promotion->is_available ? 'pause' : 'play' }}"></i>
                                </button>
                                
                                <button wire:click="toggleFeatured({{ $promotion->id }})" 
                                        class="text-yellow-600 hover:text-yellow-700 p-1"
                                        title="{{ $promotion->is_featured ? 'Retirer des vedettes' : 'Mettre en vedette' }}">
                                    <i class="fas fa-star"></i>
                                </button>
                                
                                <button wire:click="deletePromotion({{ $promotion->id }})" 
                                        wire:confirm="Êtes-vous sûr de vouloir supprimer cette promotion ?"
                                        class="text-red-600 hover:text-red-700 p-1"
                                        title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-span-full">
                <div class="text-center py-12">
                    <i class="fas fa-percent text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune promotion trouvée</h3>
                    <p class="text-gray-500 mb-4">Les promotions apparaîtront ici une fois créées.</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($promotions->count() > 0)
        <div class="px-6 py-4">
            {{ $promotions->links() }}
        </div>
    @endif

    <!-- Modal pour créer/éditer une promotion -->
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

                <form wire:submit.prevent="savePromotion">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nom -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom de la promotion</label>
                            <input wire:model="name" type="text" class="input-modern w-full" placeholder="Nom de la promotion">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Restaurant -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Restaurant</label>
                            <select wire:model="restaurant_id" class="input-modern w-full">
                                <option value="">Sélectionner un restaurant</option>
                                @foreach($restaurants as $restaurant)
                                    <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                                @endforeach
                            </select>
                            @error('restaurant_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Catégorie -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                            <select wire:model="category_id" class="input-modern w-full">
                                <option value="">Sélectionner une catégorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Prix normal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prix normal (FCFA)</label>
                            <input wire:model="price" type="number" step="0.01" class="input-modern w-full" placeholder="0.00">
                            @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Prix promotion -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prix promotion (FCFA)</label>
                            <input wire:model="sale_price" type="number" step="0.01" class="input-modern w-full" placeholder="0.00">
                            @error('sale_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Date de fin -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin (optionnel)</label>
                            <input wire:model="sale_ends_at" type="datetime-local" class="input-modern w-full">
                            @error('sale_ends_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea wire:model="description" rows="3" class="input-modern w-full" placeholder="Description de la promotion"></textarea>
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Options -->
                        <div class="md:col-span-2">
                            <div class="flex items-center space-x-6">
                                <label class="flex items-center">
                                    <input wire:model="is_available" type="checkbox" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    <span class="ml-2 text-sm text-gray-700">Disponible</span>
                                </label>
                                
                                <label class="flex items-center">
                                    <input wire:model="is_featured" type="checkbox" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    <span class="ml-2 text-sm text-gray-700">Mise en vedette</span>
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
                            {{ $editingPromotion ? 'Mettre à jour' : 'Créer' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>