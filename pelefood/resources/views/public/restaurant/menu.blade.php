@extends('layouts.public-restaurant')

@section('title', 'Menu - ' . $restaurant->name)
@section('description', 'Découvrez notre menu complet - ' . $restaurant->name)

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 overflow-hidden">
    @if($restaurant->cover_image)
        <div class="absolute inset-0">
            <img src="{{ $restaurant->cover_image_url }}" alt="{{ $restaurant->name }}" class="w-full h-full object-cover opacity-30">
        </div>
    @endif
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Notre Menu</h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Découvrez nos délicieuses spécialités préparées avec passion
            </p>
        </div>
    </div>
</section>

<!-- Filtres et recherche -->
<section class="py-8 bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
            <!-- Recherche -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text" id="search-input" placeholder="Rechercher un plat..." 
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
                </div>
            </div>
            
            <!-- Filtres -->
            <div class="flex flex-wrap gap-3">
                <!-- Filtre par catégorie -->
                <select id="category-filter" class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                
                <!-- Tri -->
                <select id="sort-filter" class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">Trier par</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nom A-Z</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Populaires</option>
                </select>
            </div>
        </div>
    </div>
</section>

<!-- Menu -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($products->count() > 0)
            <!-- Grille des produits -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="products-grid">
                @foreach($products as $product)
                <div class="product-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden" 
                     data-category="{{ $product->category->slug }}" 
                     data-name="{{ strtolower($product->name) }}" 
                     data-description="{{ strtolower($product->description) }}">
                    
                    <!-- Image du produit -->
                    <div class="relative">
                        @if($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-utensils text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                        
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 flex flex-col gap-2">
                            @if($product->is_popular)
                                <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded-full font-medium">
                                    <i class="fas fa-fire mr-1"></i> Populaire
                                </span>
                            @endif
                            @if($product->is_featured)
                                <span class="bg-purple-500 text-white text-xs px-2 py-1 rounded-full font-medium">
                                    <i class="fas fa-star mr-1"></i> Vedette
                                </span>
                            @endif
                        </div>
                        
                        <!-- Stock -->
                        @if($product->has_stock_management && $product->stock_quantity <= 0)
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full font-medium">
                                    Rupture de stock
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Contenu -->
                    <div class="p-4">
                        <!-- Catégorie -->
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs text-gray-500">{{ $product->category->name }}</span>
                            @if($product->has_stock_management && $product->stock_quantity > 0)
                                <span class="text-xs text-green-600">
                                    <i class="fas fa-check-circle mr-1"></i> En stock
                                </span>
                            @endif
                        </div>
                        
                        <!-- Nom du produit -->
                        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                        
                        <!-- Description -->
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product->description }}</p>
                        
                        <!-- Prix et actions -->
                        <div class="flex items-center justify-between">
                            <div>
                                                        <span class="text-lg font-bold text-primary">{{ $restaurant->formatPrice($product->price ?? 0) }}</span>
                        @if($product->original_price && $product->original_price > $product->price)
                            <span class="text-sm text-gray-500 line-through ml-2">{{ $restaurant->formatPrice($product->original_price ?? 0) }}</span>
                                @endif
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                @if($product->has_stock_management && $product->stock_quantity <= 0)
                                    <button disabled class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg text-sm font-medium cursor-not-allowed">
                                        Indisponible
                                    </button>
                                @else
                                    <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})" 
                                            class="add-to-cart-btn bg-gradient-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:opacity-90 transition-all duration-200 hover:scale-105">
                                        <i class="fas fa-plus mr-1"></i> Ajouter
                                    </button>
                                @endif
                                
                                <a href="{{ route('restaurant.public.product', [$restaurant->slug, $product->id]) }}" 
                                   class="text-primary hover:text-primary-dark transition-colors duration-200">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($products->hasPages())
                <div class="mt-12">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
            
        @else
            <!-- Aucun produit trouvé -->
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 text-gray-400 mb-6">
                    <i class="fas fa-utensils text-6xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Aucun produit trouvé</h3>
                <p class="text-gray-600 mb-8">Essayez de modifier vos critères de recherche</p>
                <button onclick="clearFilters()" class="bg-gradient-primary text-white px-6 py-3 rounded-xl font-medium hover:opacity-90 transition-opacity duration-200">
                    Effacer les filtres
                </button>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-primary">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-white mb-6">Prêt à commander ?</h2>
        <p class="text-xl text-orange-100 mb-8">Votre commande sera préparée avec soin</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button onclick="openCart()" class="bg-white text-primary px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg">
                <i class="fas fa-shopping-cart mr-2"></i>
                Voir mon panier
            </button>
            
            @if($restaurant->phone)
                <a href="tel:{{ $restaurant->phone }}" class="border-2 border-white text-white px-8 py-4 rounded-xl font-semibold hover:bg-white hover:text-primary transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-phone mr-2"></i>
                    Commander par téléphone
                </a>
            @endif
        </div>
    </div>
</section>

@push('scripts')
<script>
// Filtres et recherche
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const categoryFilter = document.getElementById('category-filter');
    const sortFilter = document.getElementById('sort-filter');
    const productsGrid = document.getElementById('products-grid');
    const productCards = document.querySelectorAll('.product-card');
    
    function filterProducts() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedCategory = categoryFilter.value;
        
        productCards.forEach(card => {
            const name = card.dataset.name;
            const description = card.dataset.description;
            const category = card.dataset.category;
            
            const matchesSearch = name.includes(searchTerm) || description.includes(searchTerm);
            const matchesCategory = !selectedCategory || category === selectedCategory;
            
            if (matchesSearch && matchesCategory) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
        
        // Vérifier s'il y a des produits visibles
        const visibleProducts = document.querySelectorAll('.product-card[style="display: block"]');
        if (visibleProducts.length === 0) {
            showNoResults();
        } else {
            hideNoResults();
        }
    }
    
    function showNoResults() {
        let noResults = document.getElementById('no-results');
        if (!noResults) {
            noResults = document.createElement('div');
            noResults.id = 'no-results';
            noResults.className = 'text-center py-16 col-span-full';
            noResults.innerHTML = `
                <div class="mx-auto h-24 w-24 text-gray-400 mb-6">
                    <i class="fas fa-search text-6xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Aucun produit trouvé</h3>
                <p class="text-gray-600 mb-8">Essayez de modifier vos critères de recherche</p>
                <button onclick="clearFilters()" class="bg-gradient-primary text-white px-6 py-3 rounded-xl font-medium hover:opacity-90 transition-opacity duration-200">
                    Effacer les filtres
                </button>
            `;
            productsGrid.appendChild(noResults);
        }
    }
    
    function hideNoResults() {
        const noResults = document.getElementById('no-results');
        if (noResults) {
            noResults.remove();
        }
    }
    
    function clearFilters() {
        searchInput.value = '';
        categoryFilter.value = '';
        sortFilter.value = '';
        filterProducts();
    }
    
    // Événements
    searchInput.addEventListener('input', filterProducts);
    categoryFilter.addEventListener('change', filterProducts);
    sortFilter.addEventListener('change', function() {
        const sortValue = this.value;
        if (sortValue) {
            const url = new URL(window.location);
            url.searchParams.set('sort', sortValue);
            window.location.href = url.toString();
        }
    });
    
    // Initialiser les filtres
    if (searchInput.value || categoryFilter.value) {
        filterProducts();
    }
});

// Fonctions globales
function addToCart(productId, productName, productPrice, productDescription = '') {
    // Ouvrir un modal pour les options si le produit en a
    const product = document.querySelector(`[data-product-id="${productId}"]`);
    const hasOptions = product && product.dataset.hasOptions === 'true';
    
    if (hasOptions) {
        openProductOptionsModal(productId, productName, productPrice, productDescription);
    } else {
        addToCartDirect(productId, productName, productPrice, productDescription);
    }
}

function addToCartDirect(productId, productName, productPrice, productDescription = '', options = {}, specialInstructions = '') {
    Alpine.store('cart').add({
        id: productId,
        name: productName,
        price: productPrice,
        description: productDescription,
        options: options,
        specialInstructions: specialInstructions
    });
}

function openProductOptionsModal(productId, productName, productPrice, productDescription) {
    // Créer un modal pour les options du produit
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 z-50 flex items-center justify-center';
    modal.innerHTML = `
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeProductOptionsModal()"></div>
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">${productName}</h3>
                <button onclick="closeProductOptionsModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="space-y-4">
                <!-- Options du produit -->
                <div id="product-options-${productId}">
                    <!-- Les options seront chargées dynamiquement -->
                </div>
                
                <!-- Instructions spéciales -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Instructions spéciales</label>
                    <textarea id="special-instructions-${productId}" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                              placeholder="Ex: Sans oignons, bien cuit, etc."
                              rows="3"></textarea>
                </div>
                
                <!-- Actions -->
                <div class="flex space-x-3 pt-4">
                    <button onclick="closeProductOptionsModal()" 
                            class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Annuler
                    </button>
                    <button onclick="addToCartWithOptions(${productId}, '${productName}', ${productPrice}, '${productDescription}')" 
                            class="flex-1 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark">
                        Ajouter au panier
                    </button>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Charger les options du produit
    loadProductOptions(productId);
}

function closeProductOptionsModal() {
    const modal = document.querySelector('.fixed.inset-0.z-50');
    if (modal) {
        modal.remove();
    }
}

function loadProductOptions(productId) {
    // Simuler le chargement des options (à remplacer par un appel API)
    const optionsContainer = document.getElementById(`product-options-${productId}`);
    if (optionsContainer) {
        optionsContainer.innerHTML = `
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Taille</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="size-${productId}" value="petite" class="mr-2">
                            <span class="text-sm">Petite (+0 FCFA)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="size-${productId}" value="moyenne" checked class="mr-2">
                            <span class="text-sm">Moyenne (+0 FCFA)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="size-${productId}" value="grande" class="mr-2">
                            <span class="text-sm">Grande (+500 FCFA)</span>
                        </label>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Extras</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="extras-${productId}" value="fromage" class="mr-2">
                            <span class="text-sm">Fromage (+200 FCFA)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="extras-${productId}" value="champignons" class="mr-2">
                            <span class="text-sm">Champignons (+150 FCFA)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="extras-${productId}" value="olives" class="mr-2">
                            <span class="text-sm">Olives (+100 FCFA)</span>
                        </label>
                    </div>
                </div>
            </div>
        `;
    }
}

function addToCartWithOptions(productId, productName, productPrice, productDescription) {
    const options = {};
    const specialInstructions = document.getElementById(`special-instructions-${productId}`).value;
    
    // Récupérer les options sélectionnées
    const sizeInputs = document.querySelectorAll(`input[name="size-${productId}"]`);
    sizeInputs.forEach(input => {
        if (input.checked) {
            options['Taille'] = input.value;
        }
    });
    
    const extrasInputs = document.querySelectorAll(`input[name="extras-${productId}"]`);
    const selectedExtras = [];
    extrasInputs.forEach(input => {
        if (input.checked) {
            selectedExtras.push(input.value);
        }
    });
    
    if (selectedExtras.length > 0) {
        options['Extras'] = selectedExtras;
    }
    
    // Calculer le prix total avec les options
    let totalPrice = productPrice;
    if (options['Taille'] === 'grande') {
        totalPrice += 500;
    }
    if (options['Extras']) {
        options['Extras'].forEach(extra => {
            if (extra === 'fromage') totalPrice += 200;
            if (extra === 'champignons') totalPrice += 150;
            if (extra === 'olives') totalPrice += 100;
        });
    }
    
    addToCartDirect(productId, productName, totalPrice, productDescription, options, specialInstructions);
    closeProductOptionsModal();
}

function openCart() {
    Alpine.store('cart').count > 0 ? 
        document.querySelector('[x-data]').__x.$data.cartOpen = true :
        alert('Votre panier est vide');
}

function clearFilters() {
    document.getElementById('search-input').value = '';
    document.getElementById('category-filter').value = '';
    document.getElementById('sort-filter').value = '';
    
    document.querySelectorAll('.product-card').forEach(card => {
        card.style.display = 'block';
    });
    
    const noResults = document.getElementById('no-results');
    if (noResults) {
        noResults.remove();
    }
}
</script>
@endpush
@endsection 