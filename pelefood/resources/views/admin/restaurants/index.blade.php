@extends('layouts.super-admin-new-design')

@section('title', 'Gestion des Restaurants - PeleFood')
@section('description', 'Gérer tous les restaurants de la plateforme')

@section('breadcrumb')
<li>
    <div class="flex items-center">
        <i data-lucide="chevron-right" class="h-4 w-4 text-muted-foreground mx-2"></i>
        <span class="text-sm font-medium text-foreground">Restaurants</span>
    </div>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Gestion des Restaurants</h1>
            <p class="mt-2 text-lg text-muted-foreground">Gérer tous les restaurants de la plateforme PeleFood</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.restaurants.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 transition-colors">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Ajouter un restaurant
            </a>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-muted-foreground mb-2">Rechercher</label>
                <input type="text" id="search" placeholder="Nom, ville, email..." class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-muted-foreground mb-2">Statut</label>
                <select id="status" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    <option value="">Tous les statuts</option>
                    <option value="active">Actif</option>
                    <option value="inactive">Inactif</option>
                </select>
            </div>
            <div>
                <label for="subscription" class="block text-sm font-medium text-muted-foreground mb-2">Abonnement</label>
                <select id="subscription" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    <option value="">Tous les abonnements</option>
                    <option value="trial">Essai gratuit</option>
                    <option value="active">Actif</option>
                    <option value="expired">Expiré</option>
                    <option value="cancelled">Annulé</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="button" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-secondary text-secondary-foreground hover:bg-secondary/80 h-10 px-4 py-2 w-full">
                    <i data-lucide="search" class="w-4 h-4 mr-2"></i>
                    Filtrer
                </button>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Total</p>
                        <p class="text-2xl font-bold text-foreground">{{ $restaurants->total() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="building-2" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Actifs</p>
                        <p class="text-2xl font-bold text-foreground">{{ $restaurants->where('is_active', true)->count() }}</p>
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
                        <p class="text-sm font-medium text-muted-foreground">Revenus</p>
                        <p class="text-2xl font-bold text-foreground">{{ \App\Helpers\SettingsHelper::formatAmount($restaurants->sum('total_revenue') ?? 0) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="dollar-sign" class="w-6 h-6 text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Commandes</p>
                        <p class="text-2xl font-bold text-foreground">{{ $restaurants->sum('orders_count') ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="shopping-bag" class="w-6 h-6 text-purple-600 dark:text-purple-400"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des restaurants -->
    <div class="rounded-xl border bg-card text-card-foreground shadow">
        <div class="p-6 border-b border-border">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-foreground">Liste des Restaurants</h3>
                <a href="{{ route('admin.restaurants.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 transition-colors">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                    Créer un Restaurant
                </a>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-border">
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Restaurant</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Propriétaire</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Localisation</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Statut</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Abonnement</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Statistiques</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($restaurants as $restaurant)
                    <tr class="border-b border-border hover:bg-muted/50">
                        <td class="p-4 align-middle">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-lg overflow-hidden">
                                    @if($restaurant->logo)
                                        <img class="h-10 w-10 rounded-lg object-cover" src="{{ Storage::url($restaurant->logo) }}" alt="{{ $restaurant->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-lg bg-primary/10 flex items-center justify-center">
                                            <span class="text-sm font-semibold text-primary">{{ substr($restaurant->name, 0, 2) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <div class="font-medium text-foreground">{{ $restaurant->name }}</div>
                                    <div class="text-sm text-muted-foreground">{{ $restaurant->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 align-middle">
                            <div class="font-medium text-foreground">{{ $restaurant->user->name ?? 'N/A' }}</div>
                            <div class="text-sm text-muted-foreground">{{ $restaurant->user->email ?? 'N/A' }}</div>
                        </td>
                        <td class="p-4 align-middle">
                            <div class="font-medium text-foreground">{{ $restaurant->city }}, {{ $restaurant->country }}</div>
                            <div class="text-sm text-muted-foreground">{{ $restaurant->address }}</div>
                        </td>
                        <td class="p-4 align-middle">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                @if($restaurant->is_active) bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300 @else bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300 @endif">
                                {{ $restaurant->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td class="p-4 align-middle">
                            <div class="font-medium text-foreground">
                                @if($restaurant->subscriptionPlan)
                                    {{ $restaurant->subscriptionPlan->name }}
                                @else
                                    Aucun plan
                                @endif
                            </div>
                            <div class="text-sm text-muted-foreground">
                                @if($restaurant->subscription_status === 'trial')
                                    <span class="text-blue-600 dark:text-blue-400">Essai gratuit</span>
                                @elseif($restaurant->subscription_status === 'active')
                                    <span class="text-green-600 dark:text-green-400">Actif</span>
                                @elseif($restaurant->subscription_status === 'expired')
                                    <span class="text-red-600 dark:text-red-400">Expiré</span>
                                @else
                                    <span class="text-muted-foreground">{{ ucfirst($restaurant->subscription_status) }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="p-4 align-middle">
                            <div class="font-medium text-foreground">{{ $restaurant->orders_count ?? 0 }} commandes</div>
                            <div class="text-sm text-muted-foreground">{{ $restaurant->products_count ?? 0 }} produits</div>
                            <div class="text-sm text-muted-foreground">{{ \App\Helpers\SettingsHelper::formatAmount($restaurant->total_revenue ?? 0) }}</div>
                        </td>
                        <td class="p-4 align-middle">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('restaurant.dashboard') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-secondary text-secondary-foreground hover:bg-secondary/80 h-8 w-8" title="Voir le dashboard">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('admin.restaurants.edit', $restaurant) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-primary text-primary-foreground hover:bg-primary/90 h-8 w-8" title="Modifier">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.restaurants.destroy', $restaurant) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce restaurant ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-destructive text-destructive-foreground hover:bg-destructive/90 h-8 w-8" title="Supprimer">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="building-2" class="w-12 h-12 text-muted-foreground mb-4"></i>
                                <p class="text-lg font-medium text-foreground mb-2">Aucun restaurant trouvé</p>
                                <p class="text-muted-foreground">Commencez par ajouter votre premier restaurant</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($restaurants->hasPages())
        <div class="p-6 border-t border-border">
            {{ $restaurants->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtres de recherche
    const searchInput = document.getElementById('search');
    const statusSelect = document.getElementById('status');
    const subscriptionSelect = document.getElementById('subscription');

    function applyFilters() {
        const search = searchInput.value.toLowerCase();
        const status = statusSelect.value;
        const subscription = subscriptionSelect.value;

        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const restaurantName = row.querySelector('td:first-child .text-sm.font-medium').textContent.toLowerCase();
            const restaurantEmail = row.querySelector('td:first-child .text-sm.text-gray-500').textContent.toLowerCase();
            const restaurantStatus = row.querySelector('td:nth-child(4) span').textContent.toLowerCase();
            const restaurantSubscription = row.querySelector('td:nth-child(5) .text-sm.text-gray-500').textContent.toLowerCase();

            let show = true;

            // Filtre de recherche
            if (search && !restaurantName.includes(search) && !restaurantEmail.includes(search)) {
                show = false;
            }

            // Filtre de statut
            if (status && restaurantStatus !== status) {
                show = false;
            }

            // Filtre d'abonnement
            if (subscription && !restaurantSubscription.includes(subscription)) {
                show = false;
            }

            row.style.display = show ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', applyFilters);
    statusSelect.addEventListener('change', applyFilters);
    subscriptionSelect.addEventListener('change', applyFilters);
});
</script>
@endpush
@endsection 