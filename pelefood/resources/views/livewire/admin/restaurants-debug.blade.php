<div class="max-w-7xl mx-auto space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Restaurants (Debug)</h1>
            <p class="text-gray-600 mt-2">Version debug avec logs pour identifier le problème</p>
        </div>
        <button wire:click="createRestaurant" 
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Nouveau restaurant
        </button>
    </div>

    <!-- Debug Info -->
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
        <p><strong>Debug Info:</strong></p>
        <p>État du modal : {{ $showModal ? 'Ouvert' : 'Fermé' }}</p>
        <p>Titre du modal : {{ $modalTitle }}</p>
        <p>Restaurant en édition : {{ $editingRestaurant ?? 'Aucun' }}</p>
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
                    <span>{{ $restaurant->city }}</span>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-calendar mr-2 text-gray-400"></i>
                    <span>Créé le {{ $restaurant->created_at->format('d/m/Y') }}</span>
                </div>
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
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Créer un restaurant
            </button>
        </div>
        @endforelse
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

                    <!-- Adresse -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Adresse *</label>
                        <textarea id="address"
                                  wire:model="address"
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
