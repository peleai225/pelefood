@extends('layouts.super-admin-new-design')

@section('title', 'Gestion des Produits - PeleFood')
@section('description', 'Gérer tous les produits de la plateforme')

@section('breadcrumb')
<li>
    <div class="flex items-center">
        <i data-lucide="chevron-right" class="h-4 w-4 text-muted-foreground mx-2"></i>
        <span class="text-sm font-medium text-foreground">Produits</span>
    </div>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Gestion des Produits</h1>
            <p class="mt-2 text-lg text-muted-foreground">Gérez tous les produits de tous les restaurants</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.products.export') }}" class="inline-flex items-center px-4 py-2 bg-secondary text-secondary-foreground rounded-lg hover:bg-secondary/80 transition-colors">
                <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                Exporter
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Total</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['total_products']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="package" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Actifs</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['active_products']) }}</p>
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
                        <p class="text-sm font-medium text-muted-foreground">En Vedette</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['featured_products']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="star" class="w-6 h-6 text-purple-600 dark:text-purple-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Catégories</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['total_categories']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="tag" class="w-6 h-6 text-orange-600 dark:text-orange-400"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                <div class="relative">
                    <input type="text" id="search" placeholder="Rechercher un produit..." 
                           class="flex h-10 w-full md:w-80 rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted-foreground w-4 h-4"></i>
                </div>
                
                <select id="status-filter" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    <option value="">Tous les statuts</option>
                    <option value="active">Actifs</option>
                    <option value="inactive">Inactifs</option>
                    <option value="featured">En vedette</option>
                </select>

                <select id="restaurant-filter" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    <option value="">Tous les restaurants</option>
                    @foreach(\App\Models\Restaurant::all() as $restaurant)
                        <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Tableau des produits -->
    <div class="rounded-xl border bg-card text-card-foreground shadow">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-border">
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Produit</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Restaurant</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Catégorie</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Prix</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Ventes</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Statut</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="border-b border-border hover:bg-muted/50">
                        <td class="p-4 align-middle">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-lg overflow-hidden">
                                    @if($product->image)
                                        <img class="h-10 w-10 rounded-lg object-cover" src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-lg bg-muted flex items-center justify-center">
                                            <i data-lucide="image" class="w-5 h-5 text-muted-foreground"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <div class="font-medium text-foreground">{{ $product->name }}</div>
                                    <div class="text-sm text-muted-foreground">{{ Str::limit($product->description, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 align-middle">
                            <div class="font-medium text-foreground">{{ $product->restaurant->name ?? 'Restaurant supprimé' }}</div>
                            <div class="text-sm text-muted-foreground">{{ $product->restaurant->city ?? 'N/A' }}</div>
                        </td>
                        <td class="p-4 align-middle">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-secondary text-secondary-foreground">
                                {{ $product->category->name ?? 'Aucune' }}
                            </span>
                        </td>
                        <td class="p-4 align-middle font-medium text-foreground">
                            {{ \App\Helpers\SettingsHelper::formatAmount($product->price) }}
                        </td>
                        <td class="p-4 align-middle font-medium text-foreground">
                            {{ $product->order_items_count ?? 0 }} commandes
                        </td>
                        <td class="p-4 align-middle">
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $product->is_available ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300' }}">
                                    {{ $product->is_available ? 'Actif' : 'Inactif' }}
                                </span>
                                @if($product->is_featured)
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300">
                                        <i data-lucide="star" class="w-3 h-3 mr-1"></i>Vedette
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="p-4 align-middle">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.products.show', $product) }}" 
                                   class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-secondary text-secondary-foreground hover:bg-secondary/80 h-8 w-8" title="Voir">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                
                                <button onclick="toggleStatus({{ $product->id }}, {{ $product->is_available ? 'false' : 'true' }})"
                                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 {{ $product->is_available ? 'bg-destructive text-destructive-foreground hover:bg-destructive/90' : 'bg-green-600 text-white hover:bg-green-700' }} h-8 w-8" title="{{ $product->is_available ? 'Désactiver' : 'Activer' }}">
                                    <i data-lucide="{{ $product->is_available ? 'x' : 'check' }}" class="w-4 h-4"></i>
                                </button>
                                
                                <button onclick="toggleFeatured({{ $product->id }})"
                                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-yellow-600 text-white hover:bg-yellow-700 h-8 w-8" title="Mettre en vedette">
                                    <i data-lucide="star" class="w-4 h-4"></i>
                                </button>
                                
                                <button onclick="deleteProduct({{ $product->id }})"
                                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-destructive text-destructive-foreground hover:bg-destructive/90 h-8 w-8" title="Supprimer">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="package" class="w-12 h-12 text-muted-foreground mb-4"></i>
                                <p class="text-lg font-medium text-foreground">Aucun produit trouvé</p>
                                <p class="text-muted-foreground">Les produits apparaîtront ici une fois créés par les restaurants.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="p-6 border-t border-border">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
// Toggle statut du produit
function toggleStatus(productId, newStatus) {
    fetch(`/admin/products/${productId}/status`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            is_available: newStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erreur: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erreur lors de la mise à jour du statut');
    });
}

// Toggle produit en vedette
function toggleFeatured(productId) {
    fetch(`/admin/products/${productId}/featured`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erreur: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erreur lors de la mise à jour');
    });
}

// Supprimer un produit
function deleteProduct(productId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ? Cette action est irréversible.')) {
        fetch(`/admin/products/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Erreur lors de la suppression du produit');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de la suppression');
        });
    }
}
</script>
@endpush
@endsection
