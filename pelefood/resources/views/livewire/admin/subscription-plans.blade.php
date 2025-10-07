<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Plans d'Abonnement</h1>
            <p class="text-gray-600 mt-2">Gérez tous les plans d'abonnement de votre plateforme SaaS</p>
        </div>
        <button wire:click="createPlan" 
                class="btn-modern flex items-center space-x-2">
            <i class="fas fa-plus"></i>
            <span>Nouveau plan</span>
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
                    <i class="fas fa-credit-card text-2xl text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Plans</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="metric-card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Plans Actifs</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="metric-card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-star text-2xl text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Plans Populaires</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['popular'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="metric-card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-euro-sign text-2xl text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Revenus Potentiels</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_revenue'] ?? 0, 0, ',', ' ') }} FCFA</p>
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
                           placeholder="Rechercher des plans..."
                           class="input-modern block w-full pl-10 pr-3 py-2">
                </div>
            </div>

            <!-- Filtres -->
            <div class="flex items-center space-x-4">
                <select wire:model="filter" class="input-modern">
                    <option value="all">Tous les plans</option>
                    <option value="active">Actifs</option>
                    <option value="inactive">Inactifs</option>
                </select>

                <select wire:model="perPage" class="input-modern">
                    <option value="12">12 par page</option>
                    <option value="24">24 par page</option>
                    <option value="48">48 par page</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Liste des plans -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @if($plans->count() > 0)
            @foreach($plans as $plan)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300 {{ $plan->is_popular ? 'ring-2 ring-red-500' : '' }}">
                    <!-- Header du plan -->
                    <div class="p-6 text-center {{ $plan->is_popular ? 'bg-gradient-to-r from-red-500 to-red-700 text-white' : 'bg-gray-50' }}">
                        @if($plan->is_popular)
                            <div class="inline-block bg-white text-red-600 text-xs font-bold px-3 py-1 rounded-full mb-2">
                                POPULAIRE
                            </div>
                        @endif
                        <h3 class="text-xl font-bold mb-2">{{ $plan->name }}</h3>
                        <div class="text-3xl font-bold mb-1">{{ number_format($plan->price, 0, ',', ' ') }} FCFA</div>
                        <div class="text-sm opacity-75">{{ ucfirst($plan->billing_cycle) }}</div>
                    </div>

                    <!-- Contenu du plan -->
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">{{ $plan->description }}</p>
                        
                        <!-- Features -->
                        <div class="space-y-2 mb-6">
                            <div class="flex items-center text-sm">
                                <i class="fas fa-store text-green-500 mr-2"></i>
                                <span>{{ $plan->max_restaurants }} restaurant(s)</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-box text-green-500 mr-2"></i>
                                <span>{{ number_format($plan->max_products) }} produits</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-shopping-cart text-green-500 mr-2"></i>
                                <span>{{ number_format($plan->max_orders) }} commandes/mois</span>
                            </div>
                            @if($plan->features && is_array($plan->features))
                                <div class="text-sm text-gray-600 mt-3">
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach($plan->features as $feature)
                                            <li>{{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <!-- Statut -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $plan->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $plan->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                            <span class="text-xs text-gray-500">
                                {{ $plan->billing_cycle === 'monthly' ? 'Mensuel' : 'Annuel' }}
                            </span>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <button wire:click="editPlan({{ $plan->id }})" 
                                        class="text-green-600 hover:text-green-700 p-1"
                                        title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                <button wire:click="toggleActive({{ $plan->id }})" 
                                        class="text-blue-600 hover:text-blue-700 p-1"
                                        title="{{ $plan->is_active ? 'Désactiver' : 'Activer' }}">
                                    <i class="fas fa-{{ $plan->is_active ? 'pause' : 'play' }}"></i>
                                </button>
                                
                                <button wire:click="togglePopular({{ $plan->id }})" 
                                        class="text-yellow-600 hover:text-yellow-700 p-1"
                                        title="{{ $plan->is_popular ? 'Retirer des populaires' : 'Marquer comme populaire' }}">
                                    <i class="fas fa-star"></i>
                                </button>
                                
                                <button wire:click="deletePlan({{ $plan->id }})" 
                                        wire:confirm="Êtes-vous sûr de vouloir supprimer ce plan ?"
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
                    <i class="fas fa-credit-card text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun plan d'abonnement trouvé</h3>
                    <p class="text-gray-500 mb-4">Les plans d'abonnement apparaîtront ici une fois créés.</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($plans->count() > 0)
        <div class="px-6 py-4">
            {{ $plans->links() }}
        </div>
    @endif

    <!-- Modal pour créer/éditer un plan -->
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

                <form wire:submit.prevent="savePlan">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nom -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom du plan</label>
                            <input wire:model="name" type="text" class="input-modern w-full" placeholder="Nom du plan">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea wire:model="description" rows="2" class="input-modern w-full" placeholder="Description du plan"></textarea>
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Prix -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prix (FCFA)</label>
                            <input wire:model="price" type="number" step="0.01" class="input-modern w-full" placeholder="0.00">
                            @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Cycle de facturation -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cycle de facturation</label>
                            <select wire:model="billing_cycle" class="input-modern w-full">
                                <option value="monthly">Mensuel</option>
                                <option value="yearly">Annuel</option>
                            </select>
                            @error('billing_cycle') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Limites -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Restaurants max</label>
                            <input wire:model="max_restaurants" type="number" class="input-modern w-full" placeholder="1">
                            @error('max_restaurants') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Produits max</label>
                            <input wire:model="max_products" type="number" class="input-modern w-full" placeholder="100">
                            @error('max_products') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Commandes max/mois</label>
                            <input wire:model="max_orders" type="number" class="input-modern w-full" placeholder="1000">
                            @error('max_orders') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Features -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fonctionnalités (une par ligne)</label>
                            <textarea wire:model="features" rows="4" class="input-modern w-full" placeholder="Liste des fonctionnalités incluses"></textarea>
                            @error('features') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Options -->
                        <div class="md:col-span-2">
                            <div class="flex items-center space-x-6">
                                <label class="flex items-center">
                                    <input wire:model="is_active" type="checkbox" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    <span class="ml-2 text-sm text-gray-700">Actif</span>
                                </label>
                                
                                <label class="flex items-center">
                                    <input wire:model="is_popular" type="checkbox" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    <span class="ml-2 text-sm text-gray-700">Populaire</span>
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
                            {{ $editingPlan ? 'Mettre à jour' : 'Créer' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>