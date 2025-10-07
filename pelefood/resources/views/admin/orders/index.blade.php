@extends('layouts.super-admin-new-design')

@section('title', 'Gestion des Commandes - PeleFood')
@section('description', 'Gérer toutes les commandes de la plateforme')

@section('breadcrumb')
<li>
    <div class="flex items-center">
        <i data-lucide="chevron-right" class="h-4 w-4 text-muted-foreground mx-2"></i>
        <span class="text-sm font-medium text-foreground">Commandes</span>
    </div>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Gestion des Commandes</h1>
            <p class="mt-2 text-lg text-muted-foreground">Gérer toutes les commandes de la plateforme PeleFood</p>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Total</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($totalOrders) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="shopping-bag" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">En Attente</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($pendingOrders) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="clock" class="w-6 h-6 text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Terminées</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($completedOrders) }}</p>
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
                        <p class="text-sm font-medium text-muted-foreground">Annulées</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($cancelledOrders ?? 0) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="x-circle" class="w-6 h-6 text-red-600 dark:text-red-400"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-muted-foreground mb-2">Recherche</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Numéro, client, restaurant..." 
                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-muted-foreground mb-2">Statut</label>
                    <select name="status" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                        <option value="preparing" {{ request('status') == 'preparing' ? 'selected' : '' }}>En préparation</option>
                        <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Prête</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Livrée</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminée</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-muted-foreground mb-2">Date début</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-muted-foreground mb-2">Date fin</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                </div>
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                    <i data-lucide="search" class="w-4 h-4 mr-2"></i>Filtrer
                </button>
                
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-secondary text-secondary-foreground hover:bg-secondary/80 h-10 px-4 py-2">
                    <i data-lucide="x" class="w-4 h-4 mr-2"></i>Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- Liste des commandes -->
    <div class="rounded-xl border bg-card text-card-foreground shadow">
        <div class="p-6 border-b border-border">
            <h2 class="text-xl font-semibold text-foreground">Commandes récentes</h2>
            <p class="text-muted-foreground text-sm mt-1">Gérez toutes les commandes de la plateforme</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-border">
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Commande</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Client</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Restaurant</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Montant</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Statut</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Date</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr class="border-b border-border hover:bg-muted/50">
                        <td class="p-4 align-middle">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center mr-3">
                                    <i data-lucide="shopping-bag" class="w-5 h-5 text-primary"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-foreground">{{ $order->order_number }}</p>
                                    <p class="text-sm text-muted-foreground">#{{ $order->id }}</p>
                                </div>
                            </div>
                        </td>
                        
                        <td class="p-4 align-middle">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-secondary rounded-full flex items-center justify-center mr-3">
                                    <i data-lucide="user" class="w-4 h-4 text-secondary-foreground"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-foreground">{{ $order->user->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-muted-foreground">{{ $order->user->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        
                        <td class="p-4 align-middle">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900/20 rounded-full flex items-center justify-center mr-3">
                                    <i data-lucide="building-2" class="w-4 h-4 text-orange-600 dark:text-orange-400"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-foreground">{{ $order->restaurant->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-muted-foreground">{{ $order->restaurant->city ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        
                        <td class="p-4 align-middle">
                            <span class="text-lg font-bold text-foreground">{{ \App\Helpers\SettingsHelper::formatAmount($order->total_amount) }}</span>
                        </td>
                        
                        <td class="p-4 align-middle">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300',
                                    'confirmed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300',
                                    'preparing' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-300',
                                    'ready' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-300',
                                    'delivered' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300',
                                    'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300',
                                    'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300',
                                ];
                                $statusLabels = [
                                    'pending' => 'En attente',
                                    'confirmed' => 'Confirmée',
                                    'preparing' => 'En préparation',
                                    'ready' => 'Prête',
                                    'delivered' => 'Livrée',
                                    'completed' => 'Terminée',
                                    'cancelled' => 'Annulée',
                                ];
                            @endphp
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-300' }}">
                                {{ $statusLabels[$order->status] ?? $order->status }}
                            </span>
                        </td>
                        
                        <td class="p-4 align-middle">
                            <div class="text-sm">
                                <p class="font-medium text-foreground">{{ $order->created_at->format('d/m/Y') }}</p>
                                <p class="text-muted-foreground">{{ $order->created_at->format('H:i') }}</p>
                            </div>
                        </td>
                        
                        <td class="p-4 align-middle">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-secondary text-secondary-foreground hover:bg-secondary/80 h-8 w-8" title="Voir">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('admin.orders.edit', $order) }}" 
                                   class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-primary text-primary-foreground hover:bg-primary/90 h-8 w-8" title="Modifier">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-destructive text-destructive-foreground hover:bg-destructive/90 h-8 w-8" title="Supprimer">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="shopping-bag" class="w-12 h-12 text-muted-foreground mb-4"></i>
                                <p class="text-lg font-medium text-foreground">Aucune commande trouvée</p>
                                <p class="text-muted-foreground">Les commandes apparaîtront ici une fois créées</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-white/10">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-400">
                    Affichage de {{ $orders->firstItem() }} à {{ $orders->lastItem() }} sur {{ $orders->total() }} résultats
                </div>
                <div class="flex items-center space-x-2">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 