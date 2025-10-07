<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name ?? 'Restaurant PeleFood' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
    
    <style>
        /* Variables CSS pour le thème */
        :root {
            --primary-color: {{ $restaurant->theme_colors['primary'] ?? '#f97316' }};
            --secondary-color: {{ $restaurant->theme_colors['secondary'] ?? '#ea580c' }};
            --accent-color: {{ $restaurant->theme_colors['accent'] ?? '#c2410c' }};
            --text-color: {{ $restaurant->theme_colors['text'] ?? '#1f2937' }};
        }

        /* Mode sombre */
        .dark {
            --primary-color: #fbbf24;
            --secondary-color: #f59e0b;
            --accent-color: #d97706;
            --text-color: #f9fafb;
        }

        .dark body {
            background-color: #111827;
            color: #f9fafb;
        }

        .dark .bg-white {
            background-color: #1f2937;
        }

        .dark .text-gray-900 {
            color: #f9fafb;
        }

        .dark .text-gray-700 {
            color: #d1d5db;
        }

        .dark .text-gray-600 {
            color: #9ca3af;
        }

        .dark .text-gray-500 {
            color: #6b7280;
        }

        .dark .border-gray-200 {
            border-color: #374151;
        }

        .dark .border-gray-100 {
            border-color: #374151;
        }

        .dark .bg-gray-50 {
            background-color: #374151;
        }

        .dark .bg-gray-100 {
            background-color: #4b5563;
        }

        .dark .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
        }

        .dark .shadow-xl {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);
        }
        
        .restaurant-theme {
            --primary-color: {{ $restaurant->theme_colors['primary'] ?? '#f97316' }};
            --secondary-color: {{ $restaurant->theme_colors['secondary'] ?? '#ea580c' }};
            --accent-color: {{ $restaurant->theme_colors['accent'] ?? '#c2410c' }};
            --text-color: {{ $restaurant->theme_colors['text'] ?? '#1f2937' }};
            --bg-color: {{ $restaurant->theme_colors['background'] ?? '#ffffff' }};
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
        }
        
        .text-primary {
            color: var(--primary-color);
        }
        
        .border-primary {
            border-color: var(--primary-color);
        }
        
        .bg-primary-light {
            background-color: color-mix(in srgb, var(--primary-color) 10%, transparent);
        }
        
        /* Styles pour la barre de recherche */
        #search-input:focus {
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }
        
        /* Styles pour les filtres */
        .filter-btn {
            background-color: #f3f4f6;
            color: #6b7280;
            border: 2px solid transparent;
        }
        
        .filter-btn:hover {
            background-color: #e5e7eb;
            color: #374151;
        }
        
        .filter-btn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        /* Animation pour les produits */
        .product-card {
            transition: all 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Surbrillance de recherche */
        mark {
            background-color: #fef3c7;
            color: #92400e;
            padding: 2px 4px;
            border-radius: 4px;
            font-weight: 600;
        }
    </style>
</head>
<body class="restaurant-theme bg-gray-50">
    <!-- Header avec design amélioré -->
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo et nom du restaurant -->
                <div class="flex items-center space-x-4">
                    @if($restaurant->logo)
                        <img src="{{ asset('storage/' . $restaurant->logo) }}" alt="Logo" class="w-12 h-12 rounded-full shadow-md">
                    @else
                        <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center shadow-md">
                            <i class="fas fa-utensils text-white text-xl"></i>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-2xl font-bold text-primary">{{ $restaurant->name ?? 'Restaurant PeleFood' }}</h1>
                        <p class="text-sm text-gray-500">{{ $restaurant->city ?? 'Abidjan' }}</p>
                    </div>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#menu" class="text-gray-700 hover:text-primary transition-colors font-medium">Menu</a>
                </nav>
                
                <!-- Panier et actions -->
                <div class="flex items-center space-x-4">
                    <!-- Statut d'ouverture -->
                    <div class="hidden sm:flex items-center space-x-2">
                        @if($restaurant->isCurrentlyOpen())
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-circle text-green-400 mr-2"></i>
                                Ouvert
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-circle text-red-400 mr-2"></i>
                                Fermé
                            </span>
                        @endif
                    </div>
                    
                    <!-- Mode sombre/clair -->
                    <button onclick="toggleTheme()" class="bg-gray-100 text-gray-700 p-3 rounded-lg hover:bg-gray-200 transition-colors">
                        <i id="theme-icon" class="fas fa-moon text-xl"></i>
                    </button>
                    
                    <!-- QR Code -->
                    <button onclick="showQRCode()" class="bg-gray-100 text-gray-700 p-3 rounded-lg hover:bg-gray-200 transition-colors">
                        <i class="fas fa-qrcode text-xl"></i>
                    </button>
                    
                    <!-- Panier -->
                    <button onclick="toggleCart()" class="relative btn-primary p-3 rounded-lg hover:bg-secondary transition-colors shadow-lg">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-bold">0</span>
                    </button>
                    
                    <!-- Menu mobile -->
                    <button onclick="toggleMobileMenu()" class="md:hidden text-gray-700 hover:text-primary">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Menu mobile -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
            <div class="px-4 py-2 space-y-1">
                <a href="#menu" class="block px-3 py-2 text-gray-700 hover:text-primary">Menu</a>
            </div>
        </div>
    </header>

    <!-- Hero Section améliorée -->
    <section class="relative bg-gradient-to-br from-primary to-secondary text-white py-20">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-5xl font-bold mb-6">{{ $restaurant->slogan ?? 'La cuisine africaine authentique' }}</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto">{{ $restaurant->description ?? 'Découvrez nos délicieux plats traditionnels préparés avec des ingrédients frais et des recettes authentiques.' }}</p>
            
            <!-- Horaires d'ouverture -->
            <div class="mb-8">
                <button onclick="showOpeningHours()" class="inline-flex items-center px-6 py-3 bg-white bg-opacity-20 text-white rounded-lg hover:bg-opacity-30 transition-all backdrop-blur-sm">
                    <i class="fas fa-clock mr-2"></i>
                    Horaires d'ouverture
                </button>
            </div>
            
            <!-- Options de commande -->
            <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <button onclick="scrollToMenu()" class="btn-primary px-8 py-4 rounded-full text-lg font-semibold shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <i class="fas fa-utensils mr-2"></i>
                    Commander sur place
                </button>
                <button onclick="scrollToMenu()" class="bg-white text-primary px-8 py-4 rounded-full text-lg font-semibold shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <i class="fas fa-truck mr-2"></i>
                    Livraison
                </button>
                <button onclick="scrollToMenu()" class="bg-white text-primary px-8 py-4 rounded-full text-lg font-semibold shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <i class="fas fa-shopping-bag mr-2"></i>
                    À emporter
                </button>
            </div>
        </div>
    </section>

    <!-- Section Menu avec design amélioré -->
    <section id="menu" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-primary mb-4">Notre Menu</h2>
                <p class="text-xl text-gray-600">Découvrez nos délicieux plats</p>
            </div>
            
            <!-- Filtres de catégories -->
            <div class="flex flex-wrap justify-center gap-4 mb-8">
                <button onclick="filterByCategory('all')" class="filter-btn active px-6 py-3 rounded-full font-medium transition-all">
                    Tous
                </button>
                @foreach($categories as $category)
                <button onclick="filterByCategory('{{ $category->id }}')" class="filter-btn px-6 py-3 rounded-full font-medium transition-all">
                    {{ $category->name }}
                </button>
                @endforeach
            </div>
            
            <!-- Barre de recherche -->
            <div class="max-w-2xl mx-auto mb-8">
                <div class="relative">
                    <input type="text" 
                           id="search-input" 
                           placeholder="Rechercher un plat, une boisson..." 
                           class="w-full px-6 py-4 pl-14 text-lg border-2 border-gray-200 rounded-full focus:outline-none focus:border-primary transition-colors shadow-lg"
                           oninput="searchProducts(this.value)">
                    <div class="absolute left-5 top-1/2 transform -translate-y-1/2">
                        <i class="fas fa-search text-gray-400 text-xl"></i>
                    </div>
                    <div class="absolute right-5 top-1/2 transform -translate-y-1/2">
                        <button onclick="clearSearch()" id="clear-search" class="hidden text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>
                <p class="text-center text-gray-500 mt-2">Tapez le nom d'un plat pour le trouver rapidement</p>
            </div>
            
            <!-- Grille des produits -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($products as $product)
                <div class="product-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-2 border border-gray-100 overflow-hidden" data-category="{{ $product->category_id }}">
                    <div class="relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                <i class="fas fa-utensils text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-4 right-4">
                            @if($product->is_featured)
                                <span class="bg-primary text-white px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-star mr-1"></i>Populaire
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="text-xl font-bold text-gray-900">{{ $product->name }}</h3>
                            <span class="text-2xl font-bold text-primary">{{ number_format($product->price) }} FCFA</span>
                        </div>
                        
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $product->description }}</p>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= ($product->rating ?? 4) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-500">({{ $product->reviews_count ?? 12 }})</span>
                            </div>
                            
                            <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})" 
                                    class="btn-primary px-6 py-2 rounded-full font-medium hover:shadow-lg transition-all">
                                <i class="fas fa-plus mr-2"></i>Ajouter
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer amélioré -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold text-primary mb-4">{{ $restaurant->name }}</h3>
                    <p class="text-gray-400">{{ $restaurant->description ?? 'Restaurant spécialisé dans la cuisine africaine traditionnelle.' }}</p>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Liens rapides</h4>
                    <ul class="space-y-2">
                        <li><a href="#menu" class="text-gray-400 hover:text-primary transition-colors">Menu</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Services</h4>
                    <ul class="space-y-2">
                        <li class="text-gray-400">Sur place</li>
                        <li class="text-gray-400">Livraison</li>
                        <li class="text-gray-400">À emporter</li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Suivez-nous</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                            <i class="fab fa-facebook text-2xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                            <i class="fab fa-instagram text-2xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                            <i class="fab fa-twitter text-2xl"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">&copy; 2024 {{ $restaurant->name }}. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Panier flottant amélioré -->
    <div id="cart-sidebar" class="fixed right-0 top-0 h-full w-96 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50">
        <div class="p-6 h-full flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-primary">Votre Panier</h3>
                <button onclick="toggleCart()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div id="cart-items" class="flex-1 overflow-y-auto space-y-4 mb-6">
                <!-- Les articles seront ajoutés dynamiquement -->
            </div>
            
            <div class="border-t border-gray-200 pt-4 space-y-4">
                <div class="flex justify-between text-lg">
                    <span class="font-semibold">Total:</span>
                    <span id="cart-total" class="font-bold text-primary">0 FCFA</span>
                </div>
                
                <button onclick="proceedToCheckout()" class="w-full btn-primary py-4 rounded-lg text-lg font-semibold hover:shadow-lg transition-all">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Passer la commande
                </button>
            </div>
        </div>
    </div>

    <!-- Modal QR Code -->
    <div id="qr-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg p-8 max-w-sm w-full mx-4">
            <div class="text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">QR Code du Restaurant</h3>
                <div id="qrcode" class="mb-4"></div>
                <p class="text-sm text-gray-600 mb-4">Scannez ce QR code pour accéder directement au site</p>
                <button onclick="hideQRCode()" class="btn-primary px-6 py-2 rounded-lg">
                    Fermer
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Horaires d'ouverture -->
    <div id="hours-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
            <div class="text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-clock text-primary mr-2"></i>
                    Horaires d'ouverture
                </h3>
                
                @if($restaurant->opening_hours)
                    <div class="space-y-3 text-left">
                        @foreach($restaurant->opening_hours as $day => $hours)
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <span class="font-medium text-gray-700">{{ ucfirst($day) }}</span>
                                <span class="text-gray-600">
                                    @if($hours['open'])
                                        {{ $hours['open'] }} - {{ $hours['close'] }}
                                    @else
                                        <span class="text-red-500">Fermé</span>
                                    @endif
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="space-y-3 text-left">
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="font-medium text-gray-700">Lundi</span>
                            <span class="text-gray-600">11:00 - 22:00</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="font-medium text-gray-700">Mardi</span>
                            <span class="text-gray-600">11:00 - 22:00</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="font-medium text-gray-700">Mercredi</span>
                            <span class="text-gray-600">11:00 - 22:00</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="font-medium text-gray-700">Jeudi</span>
                            <span class="text-gray-600">11:00 - 22:00</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="font-medium text-gray-700">Vendredi</span>
                            <span class="text-gray-600">11:00 - 23:00</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="font-medium text-gray-700">Samedi</span>
                            <span class="text-gray-600">11:00 - 23:00</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <span class="font-medium text-gray-700">Dimanche</span>
                            <span class="text-gray-600">12:00 - 21:00</span>
                        </div>
                    </div>
                @endif
                
                <button onclick="hideOpeningHours()" class="btn-primary px-6 py-2 rounded-lg mt-6">
                    Fermer
                </button>
            </div>
        </div>
    </div>

    <!-- Overlay pour le panier -->
    <div id="cart-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="toggleCart()"></div>

    <script>
        // Variables globales
        let cart = [];
        let currentRestaurantSlug = '{{ $restaurant->slug ?? "pelefood" }}';
        
        // Fonctions du panier
        function addToCart(productId, productName, price) {
            const existingItem = cart.find(item => item.id === productId);
            
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    id: productId,
                    name: productName,
                    price: price,
                    quantity: 1
                });
            }
            
            updateCartDisplay();
            showNotification(`${productName} ajouté au panier !`, 'success');
        }
        
        function updateCartDisplay() {
            const cartItems = document.getElementById('cart-items');
            const cartCount = document.getElementById('cart-count');
            const cartTotal = document.getElementById('cart-total');
            
            // Mettre à jour le compteur
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            cartCount.textContent = totalItems;
            
            // Mettre à jour les articles
            cartItems.innerHTML = '';
            let total = 0;
            
            cart.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg';
                itemElement.innerHTML = `
                    <div>
                        <h4 class="font-medium">${item.name}</h4>
                        <p class="text-sm text-gray-600">${item.price} FCFA x ${item.quantity}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})" class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300">
                            <i class="fas fa-minus text-sm"></i>
                        </button>
                        <span class="w-8 text-center">${item.quantity}</span>
                        <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})" class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300">
                            <i class="fas fa-plus text-sm"></i>
                        </button>
                    </div>
                `;
                cartItems.appendChild(itemElement);
                total += item.price * item.quantity;
            });
            
            cartTotal.textContent = `${total.toLocaleString()} FCFA`;
        }
        
        function updateQuantity(productId, newQuantity) {
            if (newQuantity <= 0) {
                cart = cart.filter(item => item.id !== productId);
            } else {
                const item = cart.find(item => item.id === productId);
                if (item) item.quantity = newQuantity;
            }
            updateCartDisplay();
        }
        
        function toggleCart() {
            const sidebar = document.getElementById('cart-sidebar');
            const overlay = document.getElementById('cart-overlay');
            
            if (sidebar.classList.contains('translate-x-full')) {
                sidebar.classList.remove('translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('translate-x-full');
                overlay.classList.add('hidden');
            }
        }
        
        function proceedToCheckout() {
            if (cart.length === 0) {
                showNotification('Votre panier est vide !', 'error');
                return;
            }
            
            // Sauvegarder le panier dans localStorage
            localStorage.setItem('restaurant_cart', JSON.stringify(cart));
            localStorage.setItem('restaurant_slug', currentRestaurantSlug);
            
            // Rediriger vers la page de commande
            window.location.href = `/restaurant/${currentRestaurantSlug}/checkout`;
        }
        
        // Fonctions de navigation
        function scrollToMenu() {
            document.getElementById('menu').scrollIntoView({ behavior: 'smooth' });
        }
        
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }
        
        // Filtres de catégories
        function filterByCategory(categoryId) {
            const products = document.querySelectorAll('.product-card');
            const filterBtns = document.querySelectorAll('.filter-btn');
            
            // Mettre à jour les boutons actifs
            filterBtns.forEach(btn => btn.classList.remove('active', 'bg-primary', 'text-white'));
            event.target.classList.add('active', 'bg-primary', 'text-white');
            
            // Filtrer les produits
            products.forEach(product => {
                if (categoryId === 'all' || product.dataset.category === categoryId) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        }
        
        // Recherche de produits
        function searchProducts(searchTerm) {
            const products = document.querySelectorAll('.product-card');
            const clearButton = document.getElementById('clear-search');
            const searchInput = document.getElementById('search-input');
            
            // Afficher/masquer le bouton de suppression
            if (searchTerm.length > 0) {
                clearButton.classList.remove('hidden');
            } else {
                clearButton.classList.add('hidden');
            }
            
            // Rechercher dans les produits
            products.forEach(product => {
                const productName = product.querySelector('h3').textContent.toLowerCase();
                const productDescription = product.querySelector('p').textContent.toLowerCase();
                const searchLower = searchTerm.toLowerCase();
                
                if (productName.includes(searchLower) || productDescription.includes(searchLower)) {
                    product.style.display = 'block';
                    // Mettre en surbrillance le texte trouvé
                    if (searchTerm.length > 0) {
                        highlightText(product, searchTerm);
                    } else {
                        removeHighlight(product);
                    }
                } else {
                    product.style.display = 'none';
                }
            });
            
            // Mettre à jour le compteur de résultats
            updateSearchResults(searchTerm);
        }
        
        // Mettre en surbrillance le texte trouvé
        function highlightText(product, searchTerm) {
            const nameElement = product.querySelector('h3');
            const descElement = product.querySelector('p');
            
            if (!nameElement.dataset.originalText) {
                nameElement.dataset.originalText = nameElement.innerHTML;
                descElement.dataset.originalText = descElement.innerHTML;
            }
            
            const nameHighlighted = nameElement.dataset.originalText.replace(
                new RegExp(searchTerm, 'gi'),
                match => `<mark class="bg-yellow-200 px-1 rounded">${match}</mark>`
            );
            
            const descHighlighted = descElement.dataset.originalText.replace(
                new RegExp(searchTerm, 'gi'),
                match => `<mark class="bg-yellow-200 px-1 rounded">${match}</mark>`
            );
            
            nameElement.innerHTML = nameHighlighted;
            descElement.innerHTML = descHighlighted;
        }
        
        // Supprimer la surbrillance
        function removeHighlight(product) {
            const nameElement = product.querySelector('h3');
            const descElement = product.querySelector('p');
            
            if (nameElement.dataset.originalText) {
                nameElement.innerHTML = nameElement.dataset.originalText;
                descElement.innerHTML = descElement.dataset.originalText;
            }
        }
        
        // Effacer la recherche
        function clearSearch() {
            const searchInput = document.getElementById('search-input');
            const clearButton = document.getElementById('clear-search');
            
            searchInput.value = '';
            clearButton.classList.add('hidden');
            
            // Afficher tous les produits
            const products = document.querySelectorAll('.product-card');
            products.forEach(product => {
                product.style.display = 'block';
                removeHighlight(product);
            });
            
            // Réinitialiser les filtres
            document.querySelector('.filter-btn').classList.add('active', 'bg-primary', 'text-white');
        }
        
        // Mettre à jour le compteur de résultats
        function updateSearchResults(searchTerm) {
            const visibleProducts = document.querySelectorAll('.product-card[style*="block"], .product-card:not([style*="none"])');
            const totalProducts = document.querySelectorAll('.product-card').length;
            
            if (searchTerm.length > 0) {
                const resultsCount = visibleProducts.length;
                showNotification(`${resultsCount} produit(s) trouvé(s)`, 'success');
            }
        }
        
        // QR Code
        function showQRCode() {
            const modal = document.getElementById('qr-modal');
            const qrContainer = document.getElementById('qr-code');
            
            // Générer le QR code
            const currentUrl = window.location.href;
            QRCode.toCanvas(qrContainer, currentUrl, {
                width: 200,
                margin: 2,
                color: {
                    dark: '#f97316',
                    light: '#ffffff'
                }
            }, function (error) {
                if (error) console.error(error);
            });
            
            modal.classList.remove('hidden');
        }
        
        function hideQRCode() {
            document.getElementById('qr-modal').classList.add('hidden');
        }

        // Horaires d'ouverture
        function showOpeningHours() {
            const modal = document.getElementById('hours-modal');
            modal.classList.remove('hidden');
        }

        function hideOpeningHours() {
            document.getElementById('hours-modal').classList.add('hidden');
        }
        
        // Notifications
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg ${
                type === 'success' ? 'bg-green-500 text-white' : 
                type === 'error' ? 'bg-red-500 text-white' : 
                'bg-blue-500 text-white'
            }`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Mode sombre/clair
        function toggleTheme() {
            const body = document.body;
            const themeIcon = document.getElementById('theme-icon');
            const currentIcon = themeIcon.classList.contains('fa-moon') ? 'fa-sun' : 'fa-moon';

            body.classList.toggle('dark');
            themeIcon.classList.remove('fa-moon', 'fa-sun');
            themeIcon.classList.add(currentIcon);

            // Sauvegarder le thème dans localStorage
            localStorage.setItem('theme', body.classList.contains('dark') ? 'dark' : 'light');
        }
        
        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            // Charger le panier depuis localStorage
            const savedCart = localStorage.getItem('restaurant_cart');
            const savedSlug = localStorage.getItem('restaurant_slug');
            
            if (savedCart && savedSlug === currentRestaurantSlug) {
                cart = JSON.parse(savedCart);
                updateCartDisplay();
            }

            // Charger le thème depuis localStorage
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.body.classList.add('dark');
                document.getElementById('theme-icon').classList.remove('fa-moon');
                document.getElementById('theme-icon').classList.add('fa-sun');
            }
            
            // Activer le premier filtre
            document.querySelector('.filter-btn').classList.add('active', 'bg-primary', 'text-white');
        });
    </script>
</body>
</html> 