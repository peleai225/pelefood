@extends('layouts.restaurant')

@section('title', 'Produits')
@section('page-title', 'Gestion des produits')

@section('content')
<div class="space-y-6">
    <!-- En-tête avec actions -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Produits</h2>
            <p class="text-gray-600">Gérez votre catalogue de produits</p>
        </div>
        <a href="{{ route('restaurant.products.create') }}" 
           class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i> Nouveau produit
        </a>
    </div>

    <!-- Filtres et recherche -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('restaurant.products.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                           placeholder="Nom du produit...">
                </div>
                
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                    <select name="category_id" id="category_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select name="status" id="status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">Tous les statuts</option>
                        <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Disponible</option>
                        <option value="unavailable" {{ request('status') === 'unavailable' ? 'selected' : '' }}>Indisponible</option>
                    </select>
                </div>
                
                <div class="flex items-end space-x-2">
                    <button type="submit" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i> Filtrer
                    </button>
                    <a href="{{ route('restaurant.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="text-center">
                <div class="text-2xl font-bold text-gray-900">{{ $products->total() }}</div>
                <div class="text-sm text-gray-600">Total produits</div>
            </div>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">{{ $products->where('is_available', true)->count() }}</div>
                <div class="text-sm text-gray-600">Disponibles</div>
            </div>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="text-center">
                <div class="text-2xl font-bold text-orange-600">{{ $products->where('is_featured', true)->count() }}</div>
                <div class="text-sm text-gray-600">En vedette</div>
            </div>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
            <div class="text-center">
                <div class="text-2xl font-bold text-red-600">{{ $products->where('stock_quantity', '<=', 0)->count() }}</div>
                <div class="text-sm text-gray-600">En rupture</div>
            </div>
        </div>
    </div>

    <!-- Liste des produits -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($products as $product)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
            <!-- Image du produit -->
            <div class="relative h-48 bg-gray-100">
                @if($product->thumbnail)
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fas fa-image text-gray-400 text-4xl"></i>
                    </div>
                @endif
                
                <!-- Badges -->
                <div class="absolute top-2 left-2 flex space-x-1">
                    @if($product->is_featured)
                        <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded-full">Vedette</span>
                    @endif
                    @if($product->is_popular)
                        <span class="bg-purple-500 text-white text-xs px-2 py-1 rounded-full">Populaire</span>
                    @endif
                    @if($product->sale_price)
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">Promo</span>
                    @endif
                </div>
                
                <!-- Statut -->
                <div class="absolute top-2 right-2">
                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                        {{ $product->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $product->is_available ? 'Disponible' : 'Indisponible' }}
                    </span>
                </div>
            </div>
            
            <!-- Informations du produit -->
            <div class="p-4">
                <div class="flex items-start justify-between mb-2">
                    <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $product->name }}</h3>
                    <div class="flex space-x-1">
                        <a href="{{ route('restaurant.products.edit', $product) }}" 
                           class="text-blue-600 hover:text-blue-800 transition-colors duration-200">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('restaurant.products.destroy', $product) }}" 
                              class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 transition-colors duration-200">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ Str::limit($product->description, 100) }}</p>
                
                <div class="flex items-center justify-between mb-3">
                    <div class="text-sm text-gray-500">{{ $product->category->name ?? 'Sans catégorie' }}</div>
                    @if($product->has_stock_management)
                        <div class="text-sm {{ $product->stock_quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                            Stock: {{ $product->stock_quantity }}
                        </div>
                    @endif
                </div>
                
                <!-- Prix -->
                <div class="flex items-center justify-between">
                    <div>
                        @if($product->sale_price)
                            <div class="flex items-center space-x-2">
                                                        <span class="text-lg font-bold text-red-600">{{ $restaurant->formatPrice($product->sale_price ?? 0) }}</span>
                        <span class="text-sm text-gray-500 line-through">{{ $restaurant->formatPrice($product->price ?? 0) }}</span>
                            </div>
                        @else
                            <span class="text-lg font-bold text-gray-900">{{ $restaurant->formatPrice($product->price ?? 0) }}</span>
                        @endif
                    </div>
                    
                    <!-- Actions rapides -->
                    <div class="flex space-x-2">
                        <form method="POST" action="{{ route('restaurant.products.toggle-status', $product) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-sm {{ $product->is_available ? 'text-green-600' : 'text-red-600' }} hover:underline">
                                {{ $product->is_available ? 'Désactiver' : 'Activer' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="text-center py-12">
                <div class="text-gray-500">
                    <i class="fas fa-box text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun produit trouvé</h3>
                    <p class="text-gray-600 mb-6">Commencez par ajouter votre premier produit.</p>
                    <a href="{{ route('restaurant.products.create') }}" 
                       class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i> Ajouter un produit
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 px-6 py-4">
        {{ $products->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit du formulaire lors du changement de catégorie ou statut
    document.getElementById('category_id').addEventListener('change', function() {
        this.form.submit();
    });
    
    document.getElementById('status').addEventListener('change', function() {
        this.form.submit();
    });
});
</script>
@endpush
@endsection 