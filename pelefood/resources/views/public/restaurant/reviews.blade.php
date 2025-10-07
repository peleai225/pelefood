@extends('layouts.public-restaurant')

@section('title', 'Avis clients - ' . $restaurant->name)
@section('description', 'Découvrez les avis de nos clients satisfaits - ' . $restaurant->name)

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
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Avis de nos clients</h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Découvrez ce que disent nos clients satisfaits
            </p>
        </div>
    </div>
</section>

<!-- Statistiques des avis -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Note moyenne -->
            <div class="text-center">
                <div class="bg-gradient-primary text-white rounded-2xl p-8">
                    <div class="text-4xl font-bold mb-2">{{ number_format($reviewStats['average'] ?? 0, 1) }}</div>
                    <div class="flex justify-center mb-4">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $reviewStats['average'] ? 'text-yellow-300' : 'text-gray-300' }}"></i>
                        @endfor
                    </div>
                    <div class="text-orange-100">Note moyenne</div>
                    <div class="text-sm text-orange-100 mt-2">{{ $reviewStats['total'] }} avis</div>
                </div>
            </div>
            
            <!-- Répartition des notes -->
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Répartition des notes</h2>
                <div class="space-y-4">
                    @for($rating = 5; $rating >= 1; $rating--)
                        <div class="flex items-center">
                            <div class="flex items-center w-16">
                                <span class="text-sm font-medium text-gray-900">{{ $rating }}</span>
                                <i class="fas fa-star text-yellow-400 ml-1"></i>
                            </div>
                            <div class="flex-1 mx-4">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    @php
                                        $percentage = $reviewStats['total'] > 0 ? ($reviewStats['by_rating'][$rating] / $reviewStats['total']) * 100 : 0;
                                    @endphp
                                    <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                            <div class="w-12 text-right">
                                <span class="text-sm text-gray-600">{{ $reviewStats['by_rating'][$rating] }}</span>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filtres et tri -->
<section class="py-8 bg-gray-50 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
            <div class="flex items-center space-x-4">
                <span class="text-gray-700 font-medium">Filtrer par :</span>
                <select id="rating-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">Toutes les notes</option>
                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 étoiles</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 étoiles</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 étoiles</option>
                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 étoiles</option>
                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 étoile</option>
                </select>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-700 font-medium">Trier par :</span>
                <select id="sort-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Plus récents</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Plus anciens</option>
                    <option value="rating_high" {{ request('sort') == 'rating_high' ? 'selected' : '' }}>Note la plus haute</option>
                    <option value="rating_low" {{ request('sort') == 'rating_low' ? 'selected' : '' }}>Note la plus basse</option>
                </select>
            </div>
        </div>
    </div>
</section>

<!-- Liste des avis -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($reviews->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($reviews as $review)
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                    <!-- En-tête de l'avis -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-primary rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-semibold text-lg">
                                    {{ substr($review->user->name ?? 'Client', 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $review->user->name ?? 'Client' }}</h3>
                                <p class="text-sm text-gray-600">{{ $review->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                            @endfor
                        </div>
                    </div>
                    
                    <!-- Contenu de l'avis -->
                    <div class="mb-4">
                        @if($review->title)
                            <h4 class="font-semibold text-gray-900 mb-2">{{ $review->title }}</h4>
                        @endif
                        <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                    </div>
                    
                    <!-- Réponse du restaurant (si disponible) -->
                    @if($review->response)
                        <div class="bg-gray-50 rounded-lg p-4 mt-4">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-gradient-primary rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-utensils text-white text-sm"></i>
                                </div>
                                <span class="font-semibold text-gray-900">{{ $restaurant->name }}</span>
                            </div>
                            <p class="text-gray-700 text-sm">{{ $review->response }}</p>
                        </div>
                    @endif
                    
                    <!-- Métadonnées -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            @if($review->verified_purchase)
                                <span class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                    Achat vérifié
                                </span>
                            @endif
                            <span>{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <button onclick="likeReview({{ $review->id }})" class="text-gray-400 hover:text-primary transition-colors duration-200">
                                <i class="far fa-thumbs-up"></i>
                                <span class="ml-1 text-sm">{{ $review->likes_count ?? 0 }}</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($reviews->hasPages())
                <div class="mt-12">
                    {{ $reviews->appends(request()->query())->links() }}
                </div>
            @endif
            
        @else
            <!-- Aucun avis -->
            <div class="text-center py-16">
                <div class="mx-auto h-24 w-24 text-gray-400 mb-6">
                    <i class="fas fa-star text-6xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Aucun avis pour le moment</h3>
                <p class="text-gray-600 mb-8">Soyez le premier à laisser un avis sur {{ $restaurant->name }}</p>
                <a href="{{ route('restaurant.public.contact', $restaurant->slug) }}" 
                   class="bg-gradient-primary text-white px-6 py-3 rounded-xl font-medium hover:opacity-90 transition-opacity duration-200">
                    <i class="fas fa-pen mr-2"></i>
                    Laisser un avis
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Formulaire pour laisser un avis -->
<section class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Messages d'erreur et de succès -->
        @if(session('success'))
            <div class="alert alert-restaurant-success alert-dismissible fade show mb-6" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl p-8 shadow-lg">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Partagez votre expérience</h2>
                @if(request('order'))
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-shopping-bag text-blue-600 mr-2"></i>
                            <span class="text-blue-800 font-medium">Avis pour la commande #{{ request('order') }}</span>
                        </div>
                    </div>
                @endif
                <p class="text-gray-600">Votre avis nous aide à nous améliorer et aide d'autres clients</p>
            </div>
            
            <form action="{{ route('restaurant.public.reviews.store', $restaurant->slug) }}" method="POST" class="space-y-6">
                @csrf
                @if(request('order'))
                    <input type="hidden" name="order_number" value="{{ request('order') }}">
                @endif
                
                <!-- Note -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Votre note</label>
                    <div class="flex items-center space-x-2" x-data="{ rating: 0 }">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" @click="rating = {{ $i }}" 
                                    class="text-2xl transition-colors duration-200"
                                    :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300'">
                                <i class="fas fa-star"></i>
                            </button>
                        @endfor
                        <input type="hidden" name="rating" x-model="rating" required>
                    </div>
                </div>
                
                <!-- Commentaire -->
                <div>
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Votre avis *</label>
                    <textarea name="comment" id="comment" rows="5" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary"
                              placeholder="Partagez votre expérience avec nous..."></textarea>
                </div>
                
                <!-- Informations personnelles -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">Votre nom *</label>
                        <input type="text" name="customer_name" id="customer_name" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                    
                    <div>
                        <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">Votre email *</label>
                        <input type="email" name="customer_email" id="customer_email" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-gradient-primary text-white py-4 rounded-xl font-semibold hover:opacity-90 transition-opacity duration-200">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Publier mon avis
                </button>
            </form>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-primary">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-white mb-6">Merci pour votre confiance</h2>
        <p class="text-xl text-orange-100 mb-8">Votre satisfaction est notre priorité</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('restaurant.public.menu', $restaurant->slug) }}" 
               class="bg-white text-primary px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg">
                <i class="fas fa-utensils mr-2"></i>
                Commander maintenant
            </a>
            
            <a href="{{ route('restaurant.public.contact', $restaurant->slug) }}" 
               class="border-2 border-white text-white px-8 py-4 rounded-xl font-semibold hover:bg-white hover:text-primary transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-envelope mr-2"></i>
                Nous contacter
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script>
// Filtres et tri
document.addEventListener('DOMContentLoaded', function() {
    const ratingFilter = document.getElementById('rating-filter');
    const sortFilter = document.getElementById('sort-filter');
    
    function updateFilters() {
        const url = new URL(window.location);
        
        if (ratingFilter.value) {
            url.searchParams.set('rating', ratingFilter.value);
        } else {
            url.searchParams.delete('rating');
        }
        
        if (sortFilter.value) {
            url.searchParams.set('sort', sortFilter.value);
        } else {
            url.searchParams.delete('sort');
        }
        
        window.location.href = url.toString();
    }
    
    ratingFilter.addEventListener('change', updateFilters);
    sortFilter.addEventListener('change', updateFilters);
});

// Fonctions globales
function likeReview(reviewId) {
    // Implémentation de la fonction like
    console.log('Like review:', reviewId);
}

function submitReview() {
    // Implémentation de la soumission d'avis
    console.log('Submit review');
}
</script>
@endpush
@endsection 