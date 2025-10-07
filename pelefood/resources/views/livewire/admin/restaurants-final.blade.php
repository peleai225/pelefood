<div class="max-w-7xl mx-auto space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Restaurants</h1>
            <p class="text-gray-600 mt-2">Gérez tous les restaurants de votre plateforme SaaS</p>
        </div>
        <button wire:click="createRestaurant" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
            <i class="fas fa-plus"></i>
            <span>Nouveau restaurant</span>
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
                           placeholder="Rechercher un restaurant..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <!-- Filtres -->
            <div class="flex items-center space-x-4">
                <select wire:model="filter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="all">Tous</option>
                    <option value="active">Actifs</option>
                    <option value="inactive">Inactifs</option>
                    <option value="featured">En vedette</option>
                </select>
                
                <select wire:model="perPage" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="12">12 par page</option>
                    <option value="24">24 par page</option>
                    <option value="48">48 par page</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Liste des restaurants -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($restaurants as $restaurant)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <!-- En-tête de la carte -->
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $restaurant->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $restaurant->email }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    @if($restaurant->is_featured)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-star mr-1"></i>
                            Vedette
                        </span>
                    @endif
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $restaurant->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $restaurant->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
            </div>

            <!-- Informations du restaurant -->
            <div class="space-y-2 mb-4">
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                    <span>{{ $restaurant->city }}, {{ $restaurant->country }}</span>
                </div>
                @if($restaurant->phone)
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-phone mr-2 text-gray-400"></i>
                    <span>{{ $restaurant->phone }}</span>
                </div>
                @endif
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-calendar mr-2 text-gray-400"></i>
                    <span>Créé le {{ $restaurant->created_at->format('d/m/Y') }}</span>
                </div>
                @if($restaurant->cuisine_type)
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-utensils mr-2 text-gray-400"></i>
                    <span>{{ $restaurant->cuisine_type }}</span>
                </div>
                @endif
            </div>

            <!-- Boutons d'action -->
            <div class="flex items-center justify-between mt-4">
                <div class="flex items-center space-x-2">
                    <button wire:click="editRestaurant({{ $restaurant->id }})" 
                            class="text-green-600 hover:text-green-700 p-1"
                            title="Modifier">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button wire:click="toggleActive({{ $restaurant->id }})" 
                            class="text-blue-600 hover:text-blue-700 p-1"
                            title="{{ $restaurant->is_active ? 'Désactiver' : 'Activer' }}">
                        <i class="fas fa-{{ $restaurant->is_active ? 'pause' : 'play' }}"></i>
                    </button>
                    <button wire:click="toggleFeatured({{ $restaurant->id }})" 
                            class="text-yellow-600 hover:text-yellow-700 p-1"
                            title="{{ $restaurant->is_featured ? 'Retirer des vedettes' : 'Mettre en vedette' }}">
                        <i class="fas fa-star"></i>
                    </button>
                    <button wire:click="deleteRestaurant({{ $restaurant->id }})" 
                            wire:confirm="Êtes-vous sûr de vouloir supprimer ce restaurant ?"
                            class="text-red-600 hover:text-red-700 p-1"
                            title="Supprimer">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <i class="fas fa-store text-gray-400 text-4xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun restaurant trouvé</h3>
            <p class="text-gray-600 mb-4">Commencez par créer votre premier restaurant.</p>
            <button wire:click="createRestaurant" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-plus mr-2"></i>
                Créer un restaurant
            </button>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $restaurants->links() }}
    </div>

    <!-- Modal pour créer/éditer un restaurant -->
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

            <!-- Formulaire -->
            <form wire:submit.prevent="saveRestaurant">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Nom -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom du restaurant *</label>
                        <input type="text" 
                               id="name"
                               wire:model="name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" 
                               id="email"
                               wire:model="email"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                        <input type="text" 
                               id="phone"
                               wire:model="phone"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Ville -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Ville *</label>
                        <input type="text" 
                               id="city"
                               wire:model="city"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Pays -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Pays *</label>
                        <input type="text" 
                               id="country"
                               wire:model="country"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('country') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Code postal -->
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">Code postal</label>
                        <input type="text" 
                               id="postal_code"
                               wire:model="postal_code"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('postal_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Adresse -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Adresse *</label>
                        <textarea id="address"
                                  wire:model="address"
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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

                    <!-- Type de cuisine -->
                    <div>
                        <label for="cuisine_type" class="block text-sm font-medium text-gray-700 mb-2">Type de cuisine</label>
                        <input type="text" 
                               id="cuisine_type"
                               wire:model="cuisine_type"
                               placeholder="Ex: Italien, Français, Asiatique..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('cuisine_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Temps de livraison -->
                    <div>
                        <label for="delivery_time" class="block text-sm font-medium text-gray-700 mb-2">Temps de livraison</label>
                        <input type="text" 
                               id="delivery_time"
                               wire:model="delivery_time"
                               placeholder="Ex: 30-45 min"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('delivery_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Commande minimum -->
                    <div>
                        <label for="minimum_order" class="block text-sm font-medium text-gray-700 mb-2">Commande minimum (€)</label>
                        <input type="number" 
                               id="minimum_order"
                               wire:model="minimum_order"
                               min="0"
                               step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('minimum_order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Frais de livraison -->
                    <div>
                        <label for="delivery_fee" class="block text-sm font-medium text-gray-700 mb-2">Frais de livraison (€)</label>
                        <input type="number" 
                               id="delivery_fee"
                               wire:model="delivery_fee"
                               min="0"
                               step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('delivery_fee') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Options -->
                    <div class="md:col-span-2">
                        <div class="flex items-center space-x-6">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       wire:model="is_active"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Restaurant actif</span>
                            </label>
                            
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       wire:model="is_featured"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Mettre en vedette</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            wire:click="closeModal"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ $editingRestaurant ? 'Modifier' : 'Créer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
