<div class="p-6">
    <!-- En-tête -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            🚀 Marketing Digital
        </h1>
        <p class="text-gray-600">
            Gérez vos campagnes marketing et optimisez votre visibilité en ligne
        </p>
    </div>

    <!-- Statistiques Marketing -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Taux de Conversion -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Taux de Conversion</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $marketingStats['conversion_rate'] }}%</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">+2.5% ce mois</p>
        </div>

        <!-- Valeur Moyenne Commande -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Panier Moyen</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($marketingStats['average_order_value']) }} FCFA</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">+8.2% ce mois</p>
        </div>

        <!-- Rétention Client -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Rétention Client</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $marketingStats['customer_retention'] }}%</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">+5.1% ce mois</p>
        </div>

        <!-- Portée Réseaux Sociaux -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Portée Social</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($marketingStats['social_media_reach']) }}</p>
                </div>
                <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-share-alt text-pink-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">+12.3% ce mois</p>
        </div>
    </div>

    <!-- Outils Marketing -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Campagnes Email -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Email Marketing</h3>
                <i class="fas fa-envelope text-blue-500 text-xl"></i>
            </div>
            <p class="text-gray-600 mb-4">Créez et envoyez des campagnes email personnalisées</p>
            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Taux d'ouverture</span>
                    <span class="font-medium">{{ $marketingStats['email_open_rate'] }}%</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Emails envoyés</span>
                    <span class="font-medium">2,847</span>
                </div>
            </div>
            <button class="btn-modern w-full">Créer une campagne</button>
        </div>

        <!-- Réseaux Sociaux -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Réseaux Sociaux</h3>
                <i class="fas fa-share-alt text-green-500 text-xl"></i>
            </div>
            <p class="text-gray-600 mb-4">Gérez vos publications sur Facebook, Instagram, etc.</p>
            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Publications</span>
                    <span class="font-medium">24 ce mois</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Engagement</span>
                    <span class="font-medium">4.2%</span>
                </div>
            </div>
            <button class="btn-modern w-full">Programmer une publication</button>
        </div>

        <!-- Publicités -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Publicités</h3>
                <i class="fas fa-bullhorn text-orange-500 text-xl"></i>
            </div>
            <p class="text-gray-600 mb-4">Créez et gérez vos campagnes publicitaires</p>
            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Campagnes actives</span>
                    <span class="font-medium">{{ $marketingStats['active_campaigns'] }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Budget dépensé</span>
                    <span class="font-medium">8,200 FCFA</span>
                </div>
            </div>
            <button class="btn-modern w-full">Créer une publicité</button>
        </div>
    </div>

    <!-- Campagnes Actives -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Campagnes Marketing</h2>
                    <p class="text-gray-600 mt-1">Gérez toutes vos campagnes marketing</p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Recherche -->
                    <div class="relative">
                        <input type="text" 
                               wire:model.debounce.300ms="search"
                               placeholder="Rechercher une campagne..."
                               class="input-modern pl-10 pr-4 py-2 w-64">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    
                    <!-- Filtres -->
                    <select wire:model="filter" class="input-modern">
                        <option value="all">Tous les statuts</option>
                        <option value="active">Actives</option>
                        <option value="paused">En pause</option>
                        <option value="completed">Terminées</option>
                    </select>
                    
                    <button wire:click="createCampaign" class="btn-modern">
                        <i class="fas fa-plus mr-2"></i>
                        Nouvelle campagne
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Campagne
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Budget
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Performance
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($campaigns as $campaign)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $campaign['name'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $campaign['target_audience'] }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $campaign['type'] === 'email' ? 'bg-blue-100 text-blue-800' : 
                                       ($campaign['type'] === 'social' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800') }}">
                                    {{ ucfirst($campaign['type']) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $campaign['status'] === 'active' ? 'bg-green-100 text-green-800' : 
                                       ($campaign['status'] === 'paused' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($campaign['status']) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div>{{ number_format($campaign['spent']) }} / {{ number_format($campaign['budget']) }} FCFA</div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                    <div class="bg-red-600 h-2 rounded-full" style="width: {{ ($campaign['spent'] / $campaign['budget']) * 100 }}%"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div>{{ number_format($campaign['impressions']) }} impressions</div>
                                <div>{{ $campaign['conversions'] }} conversions</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    @if($campaign['status'] === 'active')
                                        <button wire:click="pauseCampaign({{ $campaign['id'] }})" 
                                                class="text-yellow-600 hover:text-yellow-900">
                                            <i class="fas fa-pause"></i>
                                        </button>
                                    @elseif($campaign['status'] === 'paused')
                                        <button wire:click="resumeCampaign({{ $campaign['id'] }})" 
                                                class="text-green-600 hover:text-green-900">
                                            <i class="fas fa-play"></i>
                                        </button>
                                    @endif
                                    
                                    <button wire:click="editCampaign({{ $campaign['id'] }})" 
                                            class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <button wire:click="deleteCampaign({{ $campaign['id'] }})" 
                                            class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-bullhorn text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">Aucune campagne trouvée</p>
                                    <p class="text-sm">Commencez par créer votre première campagne marketing</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($totalCampaigns > $perPage)
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $campaigns->links() }}
            </div>
        @endif
    </div>

    <!-- Messages flash -->
    @if (session()->has('success'))
        <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg z-50">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('info'))
        <div class="fixed top-4 right-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg shadow-lg z-50">
            {{ session('info') }}
        </div>
    @endif
</div>
