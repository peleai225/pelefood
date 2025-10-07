@extends('layouts.super-admin-new-design')

@section('title', 'Rapport des Restaurants - PeleFood')
@section('description', 'Analyse détaillée des restaurants de la plateforme')
@section('page-title', 'Rapport des Restaurants')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Rapport des Restaurants</h1>
            <p class="mt-2 text-lg text-muted-foreground">Analyse détaillée des restaurants de la plateforme</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            <a href="{{ route('admin.reports.restaurants.export') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-download mr-2"></i> Exporter CSV
            </a>
            <a href="{{ route('admin.reports.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Retour aux rapports
            </a>
        </div>
    </div>

    <!-- Statistiques principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Total Restaurants</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['total_restaurants']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="building" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Actifs</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['active_restaurants']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Vérifiés</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['verified_restaurants']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="shield-check" class="w-6 h-6 text-purple-600 dark:text-purple-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">En Vedette</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['featured_restaurants']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="star" class="w-6 h-6 text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Avec Commandes</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['restaurants_with_orders']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="shopping-bag" class="w-6 h-6 text-orange-600 dark:text-orange-400"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertes -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @if($restaurantsWithoutOrders > 0)
        <div class="rounded-xl border border-yellow-200 bg-yellow-50 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-yellow-800">Restaurants sans commandes</h3>
                    <p class="text-yellow-700">{{ $restaurantsWithoutOrders }} restaurant(s) n'ont encore reçu aucune commande</p>
                </div>
            </div>
        </div>
        @endif

        @if($restaurantsWithoutProducts > 0)
        <div class="rounded-xl border border-red-200 bg-red-50 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="alert-circle" class="w-6 h-6 text-red-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-red-800">Restaurants sans produits</h3>
                    <p class="text-red-700">{{ $restaurantsWithoutProducts }} restaurant(s) n'ont encore ajouté aucun produit</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Répartition par abonnement -->
        <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
            <h3 class="text-lg font-semibold text-foreground mb-6">Répartition par abonnement</h3>
            <div class="space-y-4">
                @foreach($restaurantsBySubscription as $status => $count)
                <div class="flex items-center justify-between p-3 rounded-lg bg-muted">
                    <span class="font-medium text-foreground">{{ ucfirst($status ?? 'Aucun') }}</span>
                    <span class="text-2xl font-bold text-primary">{{ $count }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top villes -->
        <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
            <h3 class="text-lg font-semibold text-foreground mb-6">Top villes</h3>
            <div class="space-y-4">
                @foreach($restaurantsByCity as $city => $count)
                <div class="flex items-center justify-between p-3 rounded-lg bg-muted">
                    <span class="font-medium text-foreground">{{ $city }}</span>
                    <span class="text-2xl font-bold text-primary">{{ $count }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Top restaurants par commandes -->
    <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
        <h3 class="text-lg font-semibold text-foreground mb-6">Top restaurants par commandes</h3>
        <div class="space-y-4">
            @forelse($topRestaurantsByOrders as $index => $restaurant)
            <div class="flex items-center justify-between p-4 rounded-lg bg-muted">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-primary text-primary-foreground rounded-full flex items-center justify-center">
                        <span class="text-sm font-bold">{{ $index + 1 }}</span>
                    </div>
                    <div>
                        <p class="font-medium text-foreground">{{ $restaurant->name }}</p>
                        <p class="text-sm text-muted-foreground">{{ $restaurant->city ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold text-foreground">{{ $restaurant->orders_count }} commandes</p>
                    <p class="text-sm text-muted-foreground">{{ number_format($restaurant->orders_sum_total_amount ?? 0, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
            @empty
            <p class="text-center text-muted-foreground py-8">Aucun restaurant avec des commandes</p>
            @endforelse
        </div>
    </div>

    <!-- Top restaurants par revenus -->
    <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
        <h3 class="text-lg font-semibold text-foreground mb-6">Top restaurants par revenus</h3>
        <div class="space-y-4">
            @forelse($topRestaurantsByRevenue as $index => $restaurant)
            <div class="flex items-center justify-between p-4 rounded-lg bg-muted">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-green-100 text-green-800 rounded-full flex items-center justify-center">
                        <span class="text-sm font-bold">{{ $index + 1 }}</span>
                    </div>
                    <div>
                        <p class="font-medium text-foreground">{{ $restaurant->name }}</p>
                        <p class="text-sm text-muted-foreground">{{ $restaurant->city ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold text-foreground">{{ number_format($restaurant->orders_sum_total_amount ?? 0, 0, ',', ' ') }} FCFA</p>
                    <p class="text-sm text-muted-foreground">{{ $restaurant->orders_count }} commandes</p>
                </div>
            </div>
            @empty
            <p class="text-center text-muted-foreground py-8">Aucun restaurant avec des revenus</p>
            @endforelse
        </div>
    </div>

    <!-- Restaurants récents -->
    <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
        <h3 class="text-lg font-semibold text-foreground mb-6">Restaurants récents</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-border">
                <thead class="bg-muted">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Restaurant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Propriétaire</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Ville</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Commandes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Produits</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-card divide-y divide-border">
                    @forelse($recentRestaurants as $restaurant)
                    <tr class="hover:bg-muted/50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-semibold">{{ substr($restaurant->name, 0, 2) }}</span>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-foreground">{{ $restaurant->name }}</div>
                                    <div class="text-sm text-muted-foreground">{{ $restaurant->subscriptionPlan->name ?? 'Aucun plan' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-foreground">
                            {{ $restaurant->user->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-foreground">
                            {{ $restaurant->city ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-foreground">
                            {{ $restaurant->orders_count ?? 0 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-foreground">
                            {{ $restaurant->products_count ?? 0 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($restaurant->is_active) bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $restaurant->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-muted-foreground">
                            {{ $restaurant->created_at->format('d/m/Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-muted-foreground">
                            Aucun restaurant trouvé
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($recentRestaurants->hasPages())
        <div class="mt-6">
            {{ $recentRestaurants->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
