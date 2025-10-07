<div class="max-w-7xl mx-auto space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Plans d'Abonnement</h1>
            <p class="mt-2 text-lg text-gray-600">Gérez les plans d'abonnement de votre plateforme</p>
        </div>
        <button wire:click="createPlan" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-plus mr-2"></i> Nouveau Plan
        </button>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-credit-card text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Plans</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $plans->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Plans Actifs</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $plans->where('is_active', true)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Plans Populaires</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $plans->where('is_popular', true)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Abonnés</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalSubscribers ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des plans -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Plans Disponibles</h3>
                <div class="flex items-center space-x-2">
                    <select wire:model="filter" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">Tous les plans</option>
                        <option value="active">Plans actifs</option>
                        <option value="inactive">Plans inactifs</option>
                        <option value="popular">Plans populaires</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($plans as $plan)
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow {{ $plan->is_popular ? 'ring-2 ring-blue-500' : '' }}">
                    @if($plan->is_popular)
                    <div class="flex items-center justify-center mb-4">
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            <i class="fas fa-star mr-1"></i> Populaire
                        </span>
                    </div>
                    @endif

                    <div class="text-center mb-4">
                        <h4 class="text-xl font-bold text-gray-900">{{ $plan->name }}</h4>
                        <p class="text-gray-600 text-sm mt-1">{{ $plan->description }}</p>
                    </div>

                    <div class="text-center mb-6">
                        <div class="text-3xl font-bold text-gray-900">
                            {{ number_format($plan->price, 0, ',', ' ') }} FCFA
                        </div>
                        <div class="text-sm text-gray-500">
                            / {{ $plan->billing_cycle === 'monthly' ? 'mois' : 'an' }}
                        </div>
                    </div>

                    <!-- Fonctionnalités -->
                    <div class="mb-6">
                        <h5 class="font-medium text-gray-900 mb-3">Fonctionnalités incluses</h5>
                        <ul class="space-y-2 text-sm text-gray-600">
                            @if($plan->features)
                                @foreach(explode("\n", $plan->features) as $feature)
                                    @if(trim($feature))
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        {{ trim($feature) }}
                                    </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <!-- Limites -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h5 class="font-medium text-gray-900 mb-3">Limites</h5>
                        <div class="grid grid-cols-1 gap-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Restaurants:</span>
                                <span class="font-medium">{{ $plan->max_restaurants ?? 'Illimité' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Produits:</span>
                                <span class="font-medium">{{ $plan->max_products ?? 'Illimité' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Commandes/mois:</span>
                                <span class="font-medium">{{ $plan->max_orders ?? 'Illimité' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <button wire:click="editPlan({{ $plan->id }})" class="text-blue-600 hover:text-blue-700">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button wire:click="deletePlan({{ $plan->id }})" class="text-red-600 hover:text-red-700" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce plan ?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            @if($plan->is_active) bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $plan->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-credit-card text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun plan trouvé</h3>
                    <p class="text-gray-500 mb-4">Commencez par créer votre premier plan d'abonnement</p>
                    <button wire:click="createPlan" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i> Créer un plan
                    </button>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal pour créer/éditer un plan -->
    <x-modal :show="$showModal" :title="$modalTitle" size="2xl" icon="credit-card">
        <form wire:submit.prevent="savePlan">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Colonne principale -->
                <div class="space-y-6">
                    <!-- Section Informations de base -->
                    <x-form-section 
                        title="Informations de base" 
                        icon="info-circle" 
                        icon-color="blue"
                        description="Définissez les informations principales du plan"
                        :columns="1">
                        
                        <x-form-field 
                            label="Nom du plan"
                            name="name"
                            type="text"
                            :required="true"
                            placeholder="Nom du plan"
                            wire:model="name"
                            :error="$errors->first('name')"
                        />

                        <x-form-field 
                            label="Description"
                            name="description"
                            type="textarea"
                            :rows="3"
                            placeholder="Description du plan"
                            wire:model="description"
                            :error="$errors->first('description')"
                        />

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-form-field 
                                label="Prix (FCFA)"
                                name="price"
                                type="number"
                                :required="true"
                                placeholder="0.00"
                                wire:model="price"
                                :error="$errors->first('price')"
                            />

                            <x-form-field 
                                label="Cycle de facturation"
                                name="billing_cycle"
                                type="select"
                                :required="true"
                                :options="[
                                    'monthly' => 'Mensuel',
                                    'yearly' => 'Annuel'
                                ]"
                                wire:model="billing_cycle"
                                :error="$errors->first('billing_cycle')"
                            />
                        </div>
                    </x-form-section>

                    <!-- Section Limites -->
                    <x-form-section 
                        title="Limites du plan" 
                        icon="chart-bar" 
                        icon-color="green"
                        description="Définissez les limites d'utilisation"
                        :columns="1"
                        spacing="compact">
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <x-form-field 
                                label="Restaurants max"
                                name="max_restaurants"
                                type="number"
                                placeholder="1"
                                wire:model="max_restaurants"
                                :error="$errors->first('max_restaurants')"
                            />

                            <x-form-field 
                                label="Produits max"
                                name="max_products"
                                type="number"
                                placeholder="100"
                                wire:model="max_products"
                                :error="$errors->first('max_products')"
                            />

                            <x-form-field 
                                label="Commandes max/mois"
                                name="max_orders"
                                type="number"
                                placeholder="1000"
                                wire:model="max_orders"
                                :error="$errors->first('max_orders')"
                            />
                        </div>
                    </x-form-section>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Section Critères sélectionnables -->
                    <x-plan-criteria 
                        title="Critères du plan"
                        :criteria="[
                            'analytics' => [
                                'name' => 'Analytics avancés',
                                'description' => 'Tableaux de bord détaillés',
                                'value' => 1
                            ],
                            'custom_domain' => [
                                'name' => 'Domaine personnalisé',
                                'description' => 'Votre propre nom de domaine',
                                'value' => 1
                            ],
                            'priority_support' => [
                                'name' => 'Support prioritaire',
                                'description' => 'Support client en priorité',
                                'value' => 1
                            ],
                            'api_access' => [
                                'name' => 'Accès API',
                                'description' => 'Intégration avec des services tiers',
                                'value' => 1
                            ],
                            'white_label' => [
                                'name' => 'Marque blanche',
                                'description' => 'Suppression de la marque PeleFood',
                                'value' => 1
                            ],
                            'multi_language' => [
                                'name' => 'Multi-langues',
                                'description' => 'Support de plusieurs langues',
                                'value' => 1
                            ]
                        ]"
                        :selected-criteria="[]"
                    />

                    <!-- Section Fonctionnalités -->
                    <x-form-section 
                        title="Fonctionnalités" 
                        icon="star" 
                        icon-color="yellow"
                        description="Liste des fonctionnalités incluses"
                        :columns="1"
                        spacing="compact">
                        
                        <x-form-field 
                            label="Fonctionnalités (une par ligne)"
                            name="features"
                            type="textarea"
                            :rows="4"
                            placeholder="• Gestion des commandes&#10;• Analytics de base&#10;• Support email"
                            wire:model="features"
                            :error="$errors->first('features')"
                        />
                    </x-form-section>

                    <!-- Section Options -->
                    <x-form-section 
                        title="Options" 
                        icon="cog" 
                        icon-color="gray"
                        description="Options supplémentaires"
                        :columns="1"
                        spacing="compact">
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">Plan populaire</h4>
                                    <p class="text-sm text-gray-500">Mettre en avant ce plan</p>
                                </div>
                                <x-form-field 
                                    name="is_popular"
                                    type="checkbox"
                                    wire:model="is_popular"
                                />
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900">Plan actif</h4>
                                    <p class="text-sm text-gray-500">Disponible pour souscription</p>
                                </div>
                                <x-form-field 
                                    name="is_active"
                                    type="checkbox"
                                    wire:model="is_active"
                                />
                            </div>
                        </div>
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
                    {{ $editingPlan ? 'Mettre à jour' : 'Créer le plan' }}
                </button>
            </x-slot>
        </form>
    </x-modal>
</div>
