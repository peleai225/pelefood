@extends('layouts.public-restaurant')

@section('title', $restaurant->name)
@section('description', $restaurant->description ?? 'Découvrez ' . $restaurant->name . ' - Une expérience culinaire exceptionnelle')

@section('content')
<!-- Hero Section avec image de couverture -->
<section id="hero" class="relative pt-20 pb-16 bg-gradient-to-br from-orange-50 via-yellow-50 to-red-50 overflow-hidden">
    <!-- Image de couverture en arrière-plan -->
    @if($restaurant->cover_image)
        <div class="absolute inset-0">
            <img src="{{ $restaurant->cover_image_url }}" alt="{{ $restaurant->name }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-br from-black/40 via-black/20 to-black/40"></div>
        </div>
    @endif
    
    <!-- Éléments décoratifs -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-10 w-32 h-32 bg-gradient-to-r from-orange-400 to-red-400 rounded-full opacity-10 animate-bounce"></div>
        <div class="absolute top-40 right-20 w-24 h-24 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-full opacity-10 animate-pulse"></div>
        <div class="absolute bottom-20 left-1/4 w-20 h-20 bg-gradient-to-r from-red-400 to-pink-400 rounded-full opacity-10 animate-spin"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <!-- Titre principal -->
            <h1 class="text-6xl md:text-8xl font-black mb-6">
                <span class="bg-gradient-to-r from-orange-400 via-red-400 to-pink-400 bg-clip-text text-transparent drop-shadow-2xl">
                    {{ $restaurant->name }}
                </span>
            </h1>
            
            <!-- Slogan -->
            <p class="text-2xl md:text-3xl text-white mb-10 font-medium drop-shadow-lg">
                {{ $restaurant->description ?: 'Une expérience culinaire exceptionnelle' }}
            </p>
            
            <!-- Bouton d'action -->
            <div class="mb-16">
                <a href="#menu" 
                   class="group relative inline-flex items-center px-12 py-6 text-2xl font-bold text-white bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl hover:shadow-2xl transition-all duration-500 overflow-hidden">
                    <span class="relative z-10 flex items-center">
                        <i class="fas fa-chevron-down mr-3 group-hover:animate-bounce"></i>
                        Voir le menu
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-red-500 to-pink-500 opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                </a>
            </div>
            
            <!-- Informations rapides avec cartes modernes -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Horaires d'ouverture -->
                <div class="group bg-white/80 backdrop-blur-xl p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 border border-white/50 hover:scale-105">
                    <div class="flex items-center space-x-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-orange-400 to-red-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-all duration-500">
                            <i class="fas fa-clock text-white text-2xl"></i>
                        </div>
                        <div class="text-left">
                            <h3 class="font-bold text-gray-900 text-xl mb-2">Horaires d'ouverture</h3>
                            @if($restaurant->is_open)
                                <p class="text-green-600 font-bold text-lg">08:00 - 23:00</p>
                            @else
                                <p class="text-red-600 font-bold text-lg">Fermé</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Adresse -->
                <div class="group bg-white/80 backdrop-blur-xl p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 border border-white/50 hover:scale-105">
                    <div class="flex items-center space-x-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-400 to-purple-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-all duration-500">
                            <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                        </div>
                        <div class="text-left">
                            <h3 class="font-bold text-gray-900 text-xl mb-2">Adresse</h3>
                            <p class="text-gray-700 font-medium text-lg">{{ $restaurant->address ?: '123 Restaurant Street' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Contact -->
                <div class="group bg-white/80 backdrop-blur-xl p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 border border-white/50 hover:scale-105">
                    <div class="flex items-center space-x-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-all duration-500">
                            <i class="fas fa-phone text-white text-2xl"></i>
                        </div>
                        <div class="text-left">
                            <h3 class="font-bold text-gray-900 text-xl mb-2">Contact</h3>
                            <p class="text-gray-700 font-medium text-lg">{{ $restaurant->phone ?: '+1 234 567 890' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Menu moderne -->
<section id="menu" class="py-20 bg-gradient-to-br from-white via-gray-50 to-orange-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête de la section -->
        <div class="text-center mb-16">
            <h2 class="text-5xl md:text-6xl font-black mb-8">
                Notre <span class="bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">Menu</span>
            </h2>
            <p class="text-xl md:text-2xl text-gray-600 max-w-4xl mx-auto">
                Découvrez nos délicieux plats préparés avec passion et des ingrédients frais de qualité
            </p>
        </div>
        
        <!-- Barre de recherche ultra-moderne -->
        <div class="max-w-5xl mx-auto mb-16">
            <div class="relative group" x-data="{ 
                searchOpen: false, 
                searchTerm: '', 
                suggestions: [],
                selectedIndex: -1,
                showSuggestions: false,
                searchHistory: JSON.parse(localStorage.getItem('searchHistory') || '[]'),
                showHistory: false
            }" @click.away="showSuggestions = false; showHistory = false">
                
                <!-- Barre de recherche principale avec effet glassmorphism -->
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-orange-500/20 via-red-500/20 to-pink-500/20 rounded-3xl blur-xl"></div>
                    <input type="text" 
                           id="search-input" 
                           x-model="searchTerm"
                           @input="handleSearchInput($event.target.value)"
                           @keydown="handleKeydown($event)"
                           @focus="showHistory = true; showSuggestions = false"
                           placeholder="✨ Que souhaitez-vous déguster aujourd'hui ?" 
                           class="relative w-full pl-24 pr-32 py-8 border-4 border-white/30 rounded-3xl focus:ring-8 focus:ring-orange-200/50 focus:border-orange-400 bg-white/90 backdrop-blur-xl text-gray-900 text-2xl shadow-2xl transition-all duration-700 group-hover:border-orange-300 group-hover:shadow-3xl group-hover:bg-white/95 placeholder-gray-500 font-medium">
                    
                    <!-- Icône de recherche animée -->
                    <div class="absolute left-8 top-8">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-red-500 rounded-full blur-md opacity-50 animate-pulse"></div>
                            <div class="relative w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-all duration-500">
                                <i class="fas fa-search text-white text-xl group-hover:rotate-12 transition-transform duration-500"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bouton de filtres avancés avec effet hover -->
                    <button @click="searchOpen = !searchOpen" 
                            class="absolute right-8 top-8 p-3 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-orange-100 hover:to-red-100 text-gray-600 hover:text-orange-600 rounded-2xl transition-all duration-500 hover:scale-110 hover:shadow-xl border border-gray-200/50">
                        <i class="fas fa-sliders-h text-xl"></i>
                    </button>
                    
                    <!-- Compteur de résultats avec badge animé -->
                    <div class="absolute right-32 top-8">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-4 py-2 rounded-full text-lg font-bold shadow-lg animate-pulse">
                            <span id="search-count">0</span> résultat(s)
                        </div>
                    </div>
                </div>
                
                <!-- Historique de recherche avec design amélioré -->
                <div x-show="showHistory && searchHistory.length > 0 && !searchTerm" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95 translate-y-4"
                     x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 transform scale-95 translate-y-4"
                     class="absolute top-full left-0 right-0 mt-4 bg-white/95 backdrop-blur-xl rounded-3xl shadow-3xl border border-white/50 z-50 max-h-80 overflow-y-auto">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-history text-white text-sm"></i>
                                </div>
                                <h4 class="font-bold text-gray-900 text-lg">Historique de recherche</h4>
                            </div>
                            <button @click="clearSearchHistory()" class="text-orange-500 hover:text-orange-600 text-sm bg-orange-50 hover:bg-orange-100 px-3 py-1 rounded-full transition-all duration-300">
                                <i class="fas fa-trash mr-1"></i>Effacer
                            </button>
                        </div>
                        <template x-for="(item, index) in searchHistory.slice(0, 5)" :key="index">
                            <div @click="selectFromHistory(item)" 
                                 class="flex items-center space-x-4 p-4 hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50 rounded-2xl cursor-pointer transition-all duration-300 hover:scale-105 hover:shadow-lg border border-transparent hover:border-orange-200/50">
                                <div class="w-10 h-10 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clock text-gray-500"></i>
                                </div>
                                <span x-text="item" class="text-gray-700 font-medium text-lg"></span>
                                <div class="ml-auto">
                                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-orange-500 transition-colors"></i>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                
                <!-- Suggestions de recherche avec design amélioré -->
                <div x-show="showSuggestions && suggestions.length > 0" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95 translate-y-4"
                     x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 transform scale-95 translate-y-4"
                     class="absolute top-full left-0 right-0 mt-4 bg-white/95 backdrop-blur-xl rounded-3xl shadow-3xl border border-white/50 z-50 max-h-80 overflow-y-auto">
                    <div class="p-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-8 h-8 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-lightbulb text-white text-sm"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 text-lg">Suggestions intelligentes</h4>
                        </div>
                        <template x-for="(suggestion, index) in suggestions" :key="index">
                            <div @click="selectSuggestion(suggestion)" 
                                 :class="selectedIndex === index ? 'bg-gradient-to-r from-orange-100 to-red-100 border-orange-300 shadow-lg' : 'hover:bg-gradient-to-r hover:from-orange-50 hover:to-red-50'"
                                 class="flex items-center space-x-4 p-4 rounded-2xl cursor-pointer transition-all duration-300 hover:scale-105 hover:shadow-lg border-2 border-transparent hover:border-orange-200/50">
                                <div class="w-10 h-10 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center shadow-md">
                                    <i class="fas fa-lightbulb text-white"></i>
                                </div>
                                <span x-text="suggestion" class="text-gray-700 font-medium text-lg"></span>
                                <div class="ml-auto">
                                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-orange-500 transition-colors"></i>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                
                <!-- Filtres avancés avec design amélioré -->
                <div x-show="searchOpen" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 transform -translate-y-8 scale-95"
                     x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 transform -translate-y-8 scale-95"
                     class="absolute top-full left-0 right-0 mt-6 bg-white/95 backdrop-blur-xl rounded-3xl shadow-3xl border border-white/50 z-50">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-sliders-h text-white"></i>
                                </div>
                                <h4 class="font-bold text-gray-900 text-xl">Filtres avancés</h4>
                            </div>
                            <button @click="searchOpen = false" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center text-gray-600 hover:text-gray-800 transition-all duration-300 hover:scale-110">
                                <i class="fas fa-times text-lg"></i>
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Filtre par prix -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Prix maximum</label>
                                <div class="relative">
                                    <input type="range" 
                                           id="price-filter" 
                                           min="0" 
                                           max="10000" 
                                           step="500" 
                                           value="10000"
                                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider">
                                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                                        <span>0 {{ $restaurant->currency_symbol }}</span>
                                        <span id="price-value">10000 {{ $restaurant->currency_symbol }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Filtre par note -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Note minimum</label>
                                <div class="flex items-center space-x-2">
                                    <input type="range" 
                                           id="rating-filter" 
                                           min="0" 
                                           max="5" 
                                           step="0.5" 
                                           value="0"
                                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider">
                                    <div class="flex items-center space-x-1">
                                        <span id="rating-value">0</span>
                                        <i class="fas fa-star text-yellow-400"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Filtre par disponibilité -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Disponibilité</label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" id="available-only" class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                                        <span class="ml-2 text-sm text-gray-700">En stock uniquement</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" id="popular-only" class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                                        <span class="ml-2 text-sm text-gray-700">Populaires uniquement</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Boutons d'action avec design amélioré -->
                        <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200/50">
                            <button @click="resetFilters()" 
                                    class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-900 rounded-2xl font-bold transition-all duration-300 hover:scale-105 hover:shadow-lg border border-gray-200/50">
                                <i class="fas fa-undo mr-2"></i>
                                Réinitialiser
                            </button>
                            <button @click="applyFilters()" 
                                    class="px-8 py-3 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white rounded-2xl font-bold transition-all duration-300 hover:scale-105 hover:shadow-xl shadow-lg">
                                <i class="fas fa-check mr-2"></i>
                                Appliquer les filtres
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            

        </div>
        
        <!-- Filtres par catégorie modernes -->
        <div class="flex flex-wrap justify-center gap-4 mb-16">
            <button onclick="filterByCategory('all')" 
                    class="filter-btn active px-8 py-4 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-2xl font-bold hover:shadow-xl transition-all duration-500 text-lg shadow-lg">
                <i class="fas fa-utensils mr-3"></i>
                Menu Principal
            </button>
            @foreach($restaurant->categories()->withCount('products')->get() as $category)
            <button onclick="filterByCategory('{{ $category->id }}')" 
                    class="filter-btn px-8 py-4 bg-white text-gray-700 rounded-2xl font-bold hover:bg-gradient-to-r hover:from-orange-500 hover:to-red-500 hover:text-white transition-all duration-500 border-4 border-gray-200 hover:border-transparent shadow-lg hover:shadow-xl text-lg">
                <i class="fas fa-tag mr-3"></i>
                {{ $category->name }} ({{ $category->products_count }})
            </button>
            @endforeach
        </div>
        
        <!-- Grille des produits moderne -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="products-grid">
            @foreach($restaurant->products()->with('category')->get() as $product)
            <div class="product-card bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden group border border-gray-100 hover:border-orange-200" 
                 data-category="{{ $product->category_id ?? 'none' }}" 
                 data-name="{{ strtolower($product->name) }}" 
                 data-description="{{ strtolower($product->description ?? '') }}">
                
                <div class="relative overflow-hidden">
                    @if($product->image)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                             class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="w-full h-56 bg-gradient-to-br from-orange-400 via-red-500 to-pink-500 flex items-center justify-center">
                            <i class="fas fa-utensils text-white text-6xl"></i>
                        </div>
                    @endif
                    
                    <!-- Badge catégorie -->
                    @if($product->category)
                        <div class="absolute top-4 left-4">
                            <span class="bg-gradient-to-r from-blue-500 to-purple-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg">{{ $product->category->name }}</span>
                        </div>
                    @endif
                    
                    <!-- Badge prix -->
                    <div class="absolute top-4 right-4">
                        <span class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-3 py-1 rounded-full text-lg font-bold shadow-lg" data-price="{{ $product->price }}">{{ $restaurant->formatPrice($product->price) }}</span>
                    </div>
                    
                    <!-- Overlay stock -->
                    <div class="absolute bottom-4 left-4">
                        <span class="bg-black/70 text-white px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm" data-stock="{{ $product->stock ?? 100 }}">
                            {{ $product->stock ?? 100 }} En stock
                        </span>
                    </div>
                    
                    <!-- Bouton d'ajout au panier au survol -->
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center">
                        <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, '{{ $product->image_url }}')" 
                                class="bg-white text-orange-500 px-8 py-4 rounded-2xl font-bold hover:bg-gradient-to-r hover:from-orange-500 hover:to-red-500 hover:text-white transition-all duration-500 transform scale-90 group-hover:scale-100 shadow-2xl">
                            <i class="fas fa-plus mr-3 text-xl"></i>
                            Ajouter au panier
                        </button>
                    </div>
                </div>
                
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $product->name }}</h3>
                    
                    @if($product->description)
                        <p class="text-gray-600 mb-6 line-clamp-2 text-lg leading-relaxed">{{ $product->description }}</p>
                    @endif
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            @if($product->rating > 0)
                                <div class="flex items-center" data-rating="{{ $product->rating }}">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $product->rating ? 'text-yellow-400' : 'text-gray-300' }} text-lg"></i>
                                    @endfor
                                    <span class="ml-3 text-gray-600 font-medium">({{ $product->reviews_count ?? 0 }})</span>
                                </div>
                            @endif
                        </div>
                        
                        <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, '{{ $product->image_url }}')" 
                                class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-3 rounded-xl font-bold hover:shadow-xl hover:scale-105 transition-all duration-500 shadow-lg">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Message si aucun produit trouvé -->
        <div id="no-products" class="text-center py-16 hidden">
            <div class="w-24 h-24 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                <i class="fas fa-search text-gray-400 text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Aucun plat trouvé</h3>
            <p class="text-gray-600 text-lg">Essayez de modifier vos critères de recherche</p>
        </div>
        
        <!-- Bouton "Charger plus" -->
        <div class="text-center mt-16">
            <button class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-12 py-4 rounded-2xl font-bold hover:shadow-2xl hover:scale-105 transition-all duration-500 text-xl shadow-xl">
                <i class="fas fa-plus mr-3"></i>
                Charger plus
            </button>
        </div>
    </div>
</section>

<!-- Footer moderne -->
<footer class="bg-gradient-to-r from-gray-900 via-gray-800 to-black text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div>
                <div class="flex items-center space-x-4 mb-8">
                    <div class="w-12 h-12 bg-gradient-to-r from-orange-400 to-red-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-sun text-white text-xl"></i>
                    </div>
                    <h3 class="text-3xl font-bold">{{ $restaurant->name }}</h3>
                </div>
                <div class="flex space-x-6 mb-6">
                    <a href="#" class="text-gray-400 hover:text-white transition-all duration-300 hover:scale-125">
                        <i class="fab fa-youtube text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-all duration-300 hover:scale-125">
                        <i class="fab fa-instagram text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-all duration-300 hover:scale-125">
                        <i class="fab fa-whatsapp text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-all duration-300 hover:scale-125">
                        <i class="fab fa-tiktok text-2xl"></i>
                    </a>
                </div>
                <p class="text-gray-400 text-lg">Tous droits réservés</p>
            </div>
            
            <div>
                <h4 class="text-2xl font-bold mb-6">Informations</h4>
                <div class="space-y-4 text-gray-300 text-lg">
                    @if($restaurant->address)
                        <p>{{ $restaurant->address }}</p>
                    @else
                        <p>123 Restaurant Street</p>
                    @endif
                    @if($restaurant->phone)
                        <p>{{ $restaurant->phone }}</p>
                    @else
                        <p>+1 234 567 890</p>
                    @endif
                    @if($restaurant->email)
                        <p>{{ $restaurant->email }}</p>
                    @else
                        <p>resto@gmail.com</p>
                    @endif
                    <p>Politique de confidentialité</p>
                    <p>v1.29.6</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Bannière de cookies moderne -->
<div x-data="{ showCookies: true }" x-show="showCookies" 
     class="fixed bottom-6 left-6 right-6 z-50 bg-white rounded-2xl shadow-2xl border border-gray-200 p-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-gradient-to-r from-orange-400 to-red-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-cookie-bite text-white text-xl"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 text-lg">Nous utilisons des cookies</h4>
                <p class="text-gray-600">Nous utilisons des cookies pour vous offrir une meilleure expérience de navigation. En continuant à naviguer, vous acceptez notre politique de cookies.</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <button @click="showCookies = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
            <button class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-3 rounded-xl font-bold hover:shadow-lg transition-all duration-300">
                Accepter
            </button>
            <button class="bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-bold hover:bg-gray-300 transition-all duration-300">
                Plus tard
            </button>
        </div>
    </div>
</div>

<!-- Panier modal moderne -->
<div x-data="{ cartOpen: false }" x-show="cartOpen" x-transition:enter="transition ease-out duration-300" 
     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
     x-transition:leave="transition ease-in duration-200" 
     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
        </div>
        
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-8 pt-8 pb-8 sm:p-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-bold text-gray-900">🛒 Votre panier</h3>
                    <button @click="cartOpen = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                
                <div x-show="$store.cart.items.length === 0" class="text-center py-12">
                    <div class="w-20 h-20 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shopping-cart text-gray-400 text-3xl"></i>
                    </div>
                    <p class="text-gray-500 text-lg font-medium">Votre panier est vide</p>
                </div>
                
                <div x-show="$store.cart.items.length > 0" class="space-y-6">
                    <template x-for="item in $store.cart.items" :key="item.id">
                        <div class="flex items-center space-x-6 p-6 bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl shadow-lg">
                            <img :src="item.image" :alt="item.name" class="w-20 h-20 object-cover rounded-xl shadow-md">
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 text-lg" x-text="item.name"></h4>
                                <p class="text-gray-600 font-bold text-lg" x-text="item.price + ' {{ $restaurant->currency_symbol }}'"></p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <button @click="$store.cart.updateQuantity(item.id, item.quantity - 1)" 
                                        class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <span class="w-12 text-center font-bold text-xl" x-text="item.quantity"></span>
                                <button @click="$store.cart.updateQuantity(item.id, item.quantity + 1)" 
                                        class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                    
                    <div class="border-t-2 border-gray-200 pt-6">
                        <div class="flex justify-between items-center mb-6">
                            <span class="font-bold text-gray-900 text-xl">Total:</span>
                            <span class="font-black text-2xl text-orange-500" x-text="$store.cart.total + ' FCFA'"></span>
                        </div>
                        
                        <a href="{{ route('restaurant.public.checkout', $restaurant->slug) }}" 
                           class="bg-gradient-to-r from-orange-500 to-red-500 text-white w-full text-center py-4 rounded-2xl text-lg font-bold hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-shopping-cart mr-3"></i>
                            Passer la commande
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .filter-btn.active {
        background: linear-gradient(135deg, #f97316, #dc2626);
        color: white;
    }
    
    /* Styles améliorés pour les sliders */
    .slider::-webkit-slider-thumb {
        appearance: none;
        height: 24px;
        width: 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f97316, #dc2626);
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(249, 115, 22, 0.4);
        border: 3px solid white;
        transition: all 0.3s ease;
    }
    
    .slider::-webkit-slider-thumb:hover {
        transform: scale(1.2);
        box-shadow: 0 6px 20px rgba(249, 115, 22, 0.6);
    }
    
    .slider::-moz-range-thumb {
        height: 24px;
        width: 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f97316, #dc2626);
        cursor: pointer;
        border: 3px solid white;
        box-shadow: 0 4px 12px rgba(249, 115, 22, 0.4);
        transition: all 0.3s ease;
    }
    
    .slider::-moz-range-thumb:hover {
        transform: scale(1.2);
        box-shadow: 0 6px 20px rgba(249, 115, 22, 0.6);
    }
    
    .slider::-webkit-slider-track {
        background: linear-gradient(to right, #e5e7eb, #f3f4f6);
        border-radius: 12px;
        height: 12px;
        border: 2px solid #e5e7eb;
    }
    
    .slider::-moz-range-track {
        background: linear-gradient(to right, #e5e7eb, #f3f4f6);
        border-radius: 12px;
        height: 12px;
        border: 2px solid #e5e7eb;
    }
    
    /* Effets de glassmorphism améliorés */
    .backdrop-blur-xl {
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
    }
    
    /* Animations personnalisées */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes glow {
        0%, 100% { box-shadow: 0 0 20px rgba(249, 115, 22, 0.3); }
        50% { box-shadow: 0 0 40px rgba(249, 115, 22, 0.6); }
    }
    
    .animate-glow {
        animation: glow 2s ease-in-out infinite;
    }
    
    /* Effet de focus amélioré */
    .search-input:focus {
        transform: scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(249, 115, 22, 0.25);
    }
    
    /* Styles pour les checkboxes personnalisées */
    input[type="checkbox"]:checked {
        background: linear-gradient(135deg, #f97316, #dc2626);
        border-color: #f97316;
    }
    
    input[type="checkbox"]:focus {
        ring: 4px;
        ring-color: rgba(249, 115, 22, 0.3);
    }
</style>

<script>
// Initialiser le store cartOpen global
document.addEventListener('alpine:init', () => {
    Alpine.store('cartOpen', false);
});

// La fonction addToCart est maintenant définie globalement dans le layout principal

// Fonction pour afficher une notification
function showNotification(message) {
    // Créer l'élément de notification
    const notification = document.createElement('div');
    notification.className = 'fixed top-6 right-6 bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-4 rounded-2xl shadow-2xl z-50 transform translate-x-full transition-all duration-500 backdrop-blur-xl';
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-3 text-xl"></i>
            <span class="text-lg font-bold">${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animer l'entrée
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Supprimer après 4 secondes
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 500);
    }, 4000);
}

// Filtres et recherche
function filterByCategory(category) {
    const products = document.querySelectorAll('.product-card');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const noProducts = document.getElementById('no-products');
    
    // Mettre à jour les boutons
    filterBtns.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    let visibleCount = 0;
    
    // Filtrer les produits
    products.forEach(product => {
        if (category === 'all' || product.dataset.category === category) {
            product.style.display = 'block';
            visibleCount++;
        } else {
            product.style.display = 'none';
        }
    });
    
    // Afficher/masquer le message "aucun produit"
    if (visibleCount === 0) {
        noProducts.classList.remove('hidden');
    } else {
        noProducts.classList.add('hidden');
    }
}

// Fonctions de recherche avancées
function handleSearchInput(value) {
    this.searchTerm = value;
    this.showHistory = false;
    
    if (value.length >= 2) {
        this.showSuggestions = true;
        this.suggestions = generateSuggestions(value);
        this.selectedIndex = -1;
    } else {
        this.showSuggestions = false;
    }
    
    // Recherche en temps réel
    performSearch(value);
    
    // Sauvegarder dans l'historique
    if (value.trim()) {
        saveToHistory(value.trim());
    }
}

function handleKeydown(event) {
    if (this.showSuggestions && this.suggestions.length > 0) {
        if (event.key === 'ArrowDown') {
            event.preventDefault();
            this.selectedIndex = Math.min(this.selectedIndex + 1, this.suggestions.length - 1);
        } else if (event.key === 'ArrowUp') {
            event.preventDefault();
            this.selectedIndex = Math.max(this.selectedIndex - 1, -1);
        } else if (event.key === 'Enter') {
            event.preventDefault();
            if (this.selectedIndex >= 0) {
                this.selectSuggestion(this.suggestions[this.selectedIndex]);
            } else {
                performSearch(this.searchTerm);
            }
        } else if (event.key === 'Escape') {
            this.showSuggestions = false;
            this.selectedIndex = -1;
        }
    }
}

function generateSuggestions(searchTerm) {
    const allProducts = Array.from(document.querySelectorAll('.product-card'));
    const suggestions = new Set();
    
    allProducts.forEach(product => {
        const name = product.dataset.name;
        const description = product.dataset.description;
        const category = product.querySelector('[data-category]')?.textContent || '';
        
        // Suggestions basées sur le nom
        if (name.includes(searchTerm.toLowerCase())) {
            suggestions.add(name);
        }
        
        // Suggestions basées sur la description
        const words = description.split(' ');
        words.forEach(word => {
            if (word.toLowerCase().includes(searchTerm.toLowerCase()) && word.length > 2) {
                suggestions.add(word);
            }
        });
        
        // Suggestions basées sur la catégorie
        if (category.toLowerCase().includes(searchTerm.toLowerCase())) {
            suggestions.add(category);
        }
    });
    
    // Suggestions génériques
    const genericSuggestions = [
        'Pizza', 'Burger', 'Salade', 'Dessert', 'Boisson', 'Viande', 'Poulet', 'Poisson', 'Végétarien'
    ];
    
    genericSuggestions.forEach(suggestion => {
        if (suggestion.toLowerCase().includes(searchTerm.toLowerCase())) {
            suggestions.add(suggestion);
        }
    });
    
    return Array.from(suggestions).slice(0, 8);
}

function selectSuggestion(suggestion) {
    this.searchTerm = suggestion;
    this.showSuggestions = false;
    this.selectedIndex = -1;
    performSearch(suggestion);
    saveToHistory(suggestion);
}

function selectFromHistory(item) {
    this.searchTerm = item;
    this.showHistory = false;
    performSearch(item);
}

function saveToHistory(searchTerm) {
    let history = JSON.parse(localStorage.getItem('searchHistory') || '[]');
    history = history.filter(item => item !== searchTerm);
    history.unshift(searchTerm);
    history = history.slice(0, 10);
    localStorage.setItem('searchHistory', JSON.stringify(history));
    this.searchHistory = history;
}

function clearSearchHistory() {
    localStorage.removeItem('searchHistory');
    this.searchHistory = [];
    this.showHistory = false;
}

function quickSearch(term) {
    this.searchTerm = term;
    this.showSuggestions = false;
    this.showHistory = false;
    performSearch(term);
    saveToHistory(term);
}

function performSearch(searchTerm) {
    const products = document.querySelectorAll('.product-card');
    const noProducts = document.getElementById('no-products');
    const searchCount = document.getElementById('search-count');
    
    let visibleCount = 0;
    
    products.forEach(product => {
        const name = product.dataset.name;
        const description = product.dataset.description;
        const price = parseInt(product.querySelector('[data-price]')?.dataset.price || '0');
        const rating = parseFloat(product.querySelector('[data-rating]')?.dataset.rating || '0');
        const stock = parseInt(product.querySelector('[data-stock]')?.dataset.stock || '0');
        
        // Recherche textuelle
        const textMatch = name.includes(searchTerm.toLowerCase()) || 
                         description.includes(searchTerm.toLowerCase());
        
        // Filtres avancés
        const priceFilter = document.getElementById('price-filter');
        const ratingFilter = document.getElementById('rating-filter');
        const availableOnly = document.getElementById('available-only');
        const popularOnly = document.getElementById('popular-only');
        
        const priceMatch = !priceFilter || price <= parseInt(priceFilter.value);
        const ratingMatch = !ratingFilter || rating >= parseFloat(ratingFilter.value);
        const stockMatch = !availableOnly?.checked || stock > 0;
        const popularMatch = !popularOnly?.checked || rating >= 4.0;
        
        if (textMatch && priceMatch && ratingMatch && stockMatch && popularMatch) {
            product.style.display = 'block';
            visibleCount++;
        } else {
            product.style.display = 'none';
        }
    });
    
    // Mettre à jour le compteur
    searchCount.textContent = visibleCount;
    
    // Afficher/masquer le message "aucun produit"
    if (visibleCount === 0) {
        noProducts.classList.remove('hidden');
    } else {
        noProducts.classList.add('hidden');
    }
}

function applyFilters() {
    this.searchOpen = false;
    performSearch(this.searchTerm);
}

function resetFilters() {
    document.getElementById('price-filter').value = 10000;
    document.getElementById('rating-filter').value = 0;
    document.getElementById('available-only').checked = false;
    document.getElementById('popular-only').checked = false;
    
    // Mettre à jour les affichages
            document.getElementById('price-value').textContent = '10000 {{ $restaurant->currency_symbol }}';
    document.getElementById('rating-value').textContent = '0';
    
    performSearch(this.searchTerm);
}

// Initialisation des filtres
document.addEventListener('DOMContentLoaded', function() {
    // Gestionnaire pour le filtre de prix
    const priceFilter = document.getElementById('price-filter');
    const priceValue = document.getElementById('price-value');
    
    if (priceFilter) {
        priceFilter.addEventListener('input', function() {
            priceValue.textContent = this.value + ' {{ $restaurant->currency_symbol }}';
        });
    }
    
    // Gestionnaire pour le filtre de note
    const ratingFilter = document.getElementById('rating-filter');
    const ratingValue = document.getElementById('rating-value');
    
    if (ratingFilter) {
        ratingFilter.addEventListener('input', function() {
            ratingValue.textContent = this.value;
        });
    }
    
    // Style pour les sliders
    const style = document.createElement('style');
    style.textContent = `
        .slider::-webkit-slider-thumb {
            appearance: none;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f97316, #dc2626);
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }
        
        .slider::-moz-range-thumb {
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f97316, #dc2626);
            cursor: pointer;
            border: none;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }
        
        .slider::-webkit-slider-track {
            background: #e5e7eb;
            border-radius: 10px;
            height: 8px;
        }
        
        .slider::-moz-range-track {
            background: #e5e7eb;
            border-radius: 10px;
            height: 8px;
            border: none;
        }
    `;
    document.head.appendChild(style);
});

// Smooth scroll pour les ancres
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>
@endsection 