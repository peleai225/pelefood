@extends('layouts.public-restaurant')

@section('title', $product->name . ' - ' . $restaurant->name)
@section('description', $product->description ?? 'Découvrez ' . $product->name . ' - ' . $restaurant->name)

@section('content')
<!-- Breadcrumb -->
<section class="py-4 bg-gray-50 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4">
                <li>
                    <a href="{{ route('restaurant.public.home', $restaurant->slug) }}" class="text-gray-500 hover:text-primary transition-colors duration-200">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ route('restaurant.public.menu', $restaurant->slug) }}" class="text-gray-500 hover:text-primary transition-colors duration-200">
                            Menu
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ route('restaurant.public.menu', $restaurant->slug) }}?category={{ $product->category->slug }}" class="text-gray-500 hover:text-primary transition-colors duration-200">
                            {{ $product->category->name }}
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-900 font-medium">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- Product Details -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Images -->
            <div class="space-y-4">
                <!-- Image principale -->
                <div class="relative">
                    @if($product->thumbnail)
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" 
                             class="w-full h-96 object-cover rounded-2xl shadow-lg">
                    @else
                        <div class="w-full h-96 bg-gray-200 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-utensils text-gray-400 text-6xl"></i>
                        </div>
                    @endif
                    
                    <!-- Badges -->
                    <div class="absolute top-4 left-4 flex flex-col gap-2">
                        @if($product->is_popular)
                            <span class="bg-orange-500 text-white text-sm px-3 py-1 rounded-full font-medium">
                                <i class="fas fa-fire mr-1"></i> Populaire
                            </span>
                        @endif
                        @if($product->is_featured)
                            <span class="bg-purple-500 text-white text-sm px-3 py-1 rounded-full font-medium">
                                <i class="fas fa-star mr-1"></i> Vedette
                            </span>
                        @endif
                        @if($product->has_stock_management && $product->stock_quantity <= 0)
                            <span class="bg-red-500 text-white text-sm px-3 py-1 rounded-full font-medium">
                                <i class="fas fa-times-circle mr-1"></i> Rupture de stock
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Galerie d'images (si disponible) -->
                @if($product->images && count($product->images) > 0)
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($product->images as $image)
                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" 
                                 class="w-full h-20 object-cover rounded-lg cursor-pointer hover:opacity-75 transition-opacity duration-200">
                        @endforeach
                    </div>
                @endif
            </div>
            
            <!-- Informations produit -->
            <div class="space-y-6">
                <!-- En-tête -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-500">{{ $product->category->name }}</span>
                        @if($product->has_stock_management && $product->stock_quantity > 0)
                            <span class="text-sm text-green-600">
                                <i class="fas fa-check-circle mr-1"></i> En stock
                            </span>
                        @endif
                    </div>
                    
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    
                    <p class="text-gray-600 text-lg leading-relaxed">{{ $product->description }}</p>
                </div>
                
                <!-- Prix -->
                <div class="flex items-center space-x-4">
                                            <span class="text-3xl font-bold text-primary">{{ $restaurant->formatPrice($product->price ?? 0) }}</span>
                        @if($product->original_price && $product->original_price > $product->price)
                            <span class="text-xl text-gray-500 line-through">{{ $restaurant->formatPrice($product->original_price ?? 0) }}</span>
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-sm font-medium">
                            @php
    $discountPercentage = $product->original_price > 0 ? (($product->original_price - $product->price) / $product->original_price) * 100 : 0;
@endphp
-{{ number_format($discountPercentage, 0) }}%
                        </span>
                    @endif
                </div>
                
                <!-- Options et personnalisation -->
                @if($product->has_options)
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Options disponibles</h3>
                        <div class="space-y-3">
                            @foreach($product->options ?? [] as $option)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $option['name'] }}</p>
                                        @if(isset($option['description']))
                                            <p class="text-sm text-gray-600">{{ $option['description'] }}</p>
                                        @endif
                                    </div>
                                    @if(isset($option['price']) && $option['price'] > 0)
                                        <span class="text-primary font-medium">+{{ $restaurant->formatPrice($option['price'] ?? 0) }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Informations nutritionnelles -->
                @if($product->nutritional_info)
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations nutritionnelles</h3>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($product->nutritional_info as $info)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">{{ $info['label'] }}</span>
                                    <span class="font-medium">{{ $info['value'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Allergènes -->
                @if($product->allergens && count($product->allergens) > 0)
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Allergènes</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($product->allergens as $allergen)
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                                    {{ $allergen }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Actions -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="flex items-center space-x-4">
                        @if($product->has_stock_management && $product->stock_quantity <= 0)
                            <button disabled class="flex-1 bg-gray-300 text-gray-500 py-4 rounded-xl font-semibold cursor-not-allowed">
                                <i class="fas fa-times-circle mr-2"></i> Indisponible
                            </button>
                        @else
                            <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})" 
                                    class="flex-1 bg-gradient-primary text-white py-4 rounded-xl font-semibold hover:opacity-90 transition-opacity duration-200">
                                <i class="fas fa-plus mr-2"></i> Ajouter au panier
                            </button>
                        @endif
                        
                        <button onclick="shareProduct()" class="p-4 border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                            <i class="fas fa-share-alt text-gray-600"></i>
                        </button>
                        
                        <button onclick="toggleFavorite()" class="p-4 border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                            <i class="far fa-heart text-gray-600" id="favorite-icon"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Avis clients -->
@if($product->reviews && $product->reviews->count() > 0)
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Avis clients</h2>
            <p class="text-gray-600">Ce que disent nos clients sur ce produit</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($product->reviews as $review)
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center mb-4">
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                        @endfor
                    </div>
                    <span class="ml-2 text-sm text-gray-600">{{ $review->rating }}/5</span>
                </div>
                
                <p class="text-gray-700 mb-4 italic">"{{ $review->comment }}"</p>
                
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-primary rounded-full flex items-center justify-center mr-3">
                        <span class="text-white font-semibold text-sm">
                            {{ substr($review->user->name ?? 'Client', 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $review->user->name ?? 'Client' }}</p>
                        <p class="text-sm text-gray-600">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Produits similaires -->
@if($similarProducts->count() > 0)
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Vous aimerez aussi</h2>
            <p class="text-gray-600">Découvrez d'autres produits de la même catégorie</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($similarProducts as $similarProduct)
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                @if($similarProduct->thumbnail)
                    <img src="{{ asset('storage/' . $similarProduct->thumbnail) }}" alt="{{ $similarProduct->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-utensils text-gray-400 text-4xl"></i>
                    </div>
                @endif
                
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $similarProduct->name }}</h3>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $similarProduct->description }}</p>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold text-primary">{{ $restaurant->formatPrice($similarProduct->price ?? 0) }}</span>
                        <a href="{{ route('restaurant.public.product', [$restaurant->slug, $similarProduct->id]) }}" 
                           class="text-primary hover:text-primary-dark transition-colors duration-200">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@push('scripts')
<script>
function addToCart(productId, productName, productPrice) {
    Alpine.store('cart').add({
        id: productId,
        name: productName,
        price: productPrice
    });
    
    // Notification
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 slide-up';
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            ${productName} ajouté au panier
        </div>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

function shareProduct() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $product->name }}',
            text: '{{ $product->description }}',
            url: window.location.href
        });
    } else {
        // Fallback pour les navigateurs qui ne supportent pas l'API Web Share
        navigator.clipboard.writeText(window.location.href).then(() => {
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 slide-up';
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-link mr-2"></i>
                    Lien copié dans le presse-papiers
                </div>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        });
    }
}

function toggleFavorite() {
    const icon = document.getElementById('favorite-icon');
    if (icon.classList.contains('far')) {
        icon.classList.remove('far');
        icon.classList.add('fas', 'text-red-500');
    } else {
        icon.classList.remove('fas', 'text-red-500');
        icon.classList.add('far');
    }
}
</script>
@endpush
@endsection 