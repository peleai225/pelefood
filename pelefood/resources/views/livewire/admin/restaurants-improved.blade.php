<div class="max-w-7xl mx-auto space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Restaurants</h1>
            <p class="mt-2 text-lg text-gray-600">Gérez tous les restaurants de votre plateforme</p>
        </div>
        <button wire:click="createRestaurant" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-plus mr-2"></i> Nouveau Restaurant
        </button>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-store text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Restaurants</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $restaurants->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Restaurants Actifs</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $restaurants->where('is_active', true)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">En Attente</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $restaurants->where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Propriétaires</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalOwners ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des restaurants -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Restaurants</h3>
                <div class="flex items-center space-x-2">
                    <input type="text" wire:model="search" placeholder="Rechercher..." class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <select wire:model="filter" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">Tous</option>
                        <option value="active">Actifs</option>
                        <option value="inactive">Inactifs</option>
                        <option value="pending">En attente</option>
                    </select>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restaurant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Propriétaire</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créé le</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($restaurants as $restaurant)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($restaurant->logo)
                                            <img class="h-10 w-10 rounded-full" src="{{ Storage::url($restaurant->logo) }}" alt="{{ $restaurant->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <i class="fas fa-store text-gray-600"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $restaurant->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $restaurant->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $restaurant->owner->name ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500">{{ $restaurant->owner->email ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($restaurant->is_active) bg-green-100 text-green-800
                                    @elseif($restaurant->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    @if($restaurant->is_active) Actif
                                    @elseif($restaurant->status === 'pending') En attente
                                    @else Inactif
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $restaurant->subscriptionPlan->name ?? 'Aucun plan' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $restaurant->created_at ? $restaurant->created_at->format('d/m/Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button wire:click="editRestaurant({{ $restaurant->id }})" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="viewRestaurant({{ $restaurant->id }})" class="text-green-600 hover:text-green-900">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button wire:click="deleteRestaurant({{ $restaurant->id }})" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce restaurant ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <i class="fas fa-store text-gray-400 text-4xl mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun restaurant trouvé</h3>
                                <p class="text-gray-500 mb-4">Commencez par ajouter votre premier restaurant</p>
                                <button wire:click="createRestaurant" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-plus mr-2"></i> Ajouter un restaurant
                                </button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $restaurants->links() }}
            </div>
        </div>
    </div>

    <!-- Modal pour créer/éditer un restaurant -->
    <x-modal :show="$showModal" :title="$modalTitle" size="xl" icon="store">
        <form wire:submit.prevent="saveRestaurant">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Colonne principale -->
                <div class="space-y-6">
                    <!-- Section Informations du restaurant -->
                    <x-form-section 
                        title="Informations du restaurant" 
                        icon="store" 
                        icon-color="blue"
                        description="Définissez les informations principales du restaurant"
                        :columns="1">
                        
                        <x-form-field 
                            label="Nom du restaurant"
                            name="name"
                            type="text"
                            :required="true"
                            placeholder="Nom du restaurant"
                            wire:model="name"
                            :error="$errors->first('name')"
                        />

                        <x-form-field 
                            label="Description"
                            name="description"
                            type="textarea"
                            :rows="3"
                            placeholder="Description du restaurant"
                            wire:model="description"
                            :error="$errors->first('description')"
                        />

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-form-field 
                                label="Email"
                                name="email"
                                type="email"
                                :required="true"
                                placeholder="email@restaurant.com"
                                wire:model="email"
                                :error="$errors->first('email')"
                            />

                            <x-form-field 
                                label="Téléphone"
                                name="phone"
                                type="tel"
                                placeholder="+225 XX XX XX XX"
                                wire:model="phone"
                                :error="$errors->first('phone')"
                            />
                        </div>

                        <x-form-field 
                            label="Adresse"
                            name="address"
                            type="textarea"
                            :rows="2"
                            placeholder="Adresse complète du restaurant"
                            wire:model="address"
                            :error="$errors->first('address')"
                        />
                    </x-form-section>

                    <!-- Section Informations du propriétaire -->
                    <x-form-section 
                        title="Propriétaire" 
                        icon="user" 
                        icon-color="green"
                        description="Informations du propriétaire du restaurant"
                        :columns="1">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-form-field 
                                label="Nom du propriétaire"
                                name="owner_name"
                                type="text"
                                :required="true"
                                placeholder="Nom complet"
                                wire:model="owner_name"
                                :error="$errors->first('owner_name')"
                            />

                            <x-form-field 
                                label="Email du propriétaire"
                                name="owner_email"
                                type="email"
                                :required="true"
                                placeholder="email@proprietaire.com"
                                wire:model="owner_email"
                                :error="$errors->first('owner_email')"
                            />
                        </div>
                    </x-form-section>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Section Paramètres -->
                    <x-form-section 
                        title="Paramètres" 
                        icon="cog" 
                        icon-color="orange"
                        description="Configuration du restaurant"
                        :columns="1"
                        spacing="compact">
                        
                        <x-form-field 
                            label="Plan d'abonnement"
                            name="subscription_plan_id"
                            type="select"
                            :required="true"
                            :options="$subscriptionPlans"
                            wire:model="subscription_plan_id"
                            :error="$errors->first('subscription_plan_id')"
                        />

                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">Restaurant actif</h4>
                                    <p class="text-sm text-gray-500">Le restaurant sera visible sur la plateforme</p>
                                </div>
                                <x-form-field 
                                    name="is_active"
                                    type="checkbox"
                                    wire:model="is_active"
                                />
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">Livraison disponible</h4>
                                    <p class="text-sm text-gray-500">Le restaurant propose la livraison</p>
                                </div>
                                <x-form-field 
                                    name="delivery_available"
                                    type="checkbox"
                                    wire:model="delivery_available"
                                />
                            </div>
                        </div>
                    </x-form-section>

                    <!-- Section Médias -->
                    <x-form-section 
                        title="Médias" 
                        icon="image" 
                        icon-color="purple"
                        description="Images du restaurant"
                        :columns="1"
                        spacing="compact">
                        
                        <x-form-field 
                            label="Logo du restaurant"
                            name="logo"
                            type="file"
                            accept="image/*"
                            wire:model="logo"
                            :error="$errors->first('logo')"
                            help="Format: JPG, PNG. Max: 2MB"
                        />

                        <x-form-field 
                            label="Image de couverture"
                            name="cover_image"
                            type="file"
                            accept="image/*"
                            wire:model="cover_image"
                            :error="$errors->first('cover_image')"
                            help="Format: JPG, PNG. Max: 5MB"
                        />
                    </x-form-section>
                </div>
            </div>

            <!-- Actions -->
            <x-slot name="footer">
                <button type="button" wire:click="closeModal" class="modal-cancel-btn">
                    Annuler
                </button>
                <button type="submit" class="btn-modern">
                    <i class="fas fa-save mr-2"></i>
                    {{ $editingRestaurant ? 'Mettre à jour' : 'Créer le restaurant' }}
                </button>
            </x-slot>
        </form>
    </x-modal>
</div>
