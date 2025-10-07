<!DOCTYPE html>
<html lang="fr" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $restaurant->name }} - {{ $restaurant->tagline ?? 'Restaurant' }}</title>
    <meta name="description" content="{{ $restaurant->description ?? 'Découvrez nos délicieux plats' }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ $restaurant->logo_url ?? '/favicon.ico' }}">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite',
                        'pulse-glow': 'pulse-glow 2s ease-in-out infinite',
                        'bounce-gentle': 'bounce-gentle 2s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        glow: {
                            '0%, 100%': { boxShadow: '0 0 20px rgba(249, 115, 22, 0.3)' },
                            '50%': { boxShadow: '0 0 40px rgba(249, 115, 22, 0.6)' },
                        },
                        'pulse-glow': {
                            '0%, 100%': { 
                                transform: 'scale(1)',
                                boxShadow: '0 0 20px rgba(249, 115, 22, 0.3)'
                            },
                            '50%': { 
                                transform: 'scale(1.05)',
                                boxShadow: '0 0 40px rgba(249, 115, 22, 0.6)'
                            },
                        },
                        'bounce-gentle': {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-5px)' },
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
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
        
        /* Dark mode slider styles */
        .dark .slider::-webkit-slider-track {
            background: linear-gradient(to right, #374151, #4b5563);
            border: 2px solid #374151;
        }
        .dark .slider::-moz-range-track {
            background: linear-gradient(to right, #374151, #4b5563);
            border: 2px solid #374151;
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
        
        /* Dark mode transitions */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #f97316, #dc2626);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #ea580c, #b91c1c);
        }
        
        .dark ::-webkit-scrollbar-track {
            background: #1f2937;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-50 via-yellow-50 to-red-50 dark:from-gray-900 dark:via-gray-800 dark:to-black min-h-screen font-sans">
    <!-- Dark mode toggle -->
    <div class="fixed top-4 right-4 z-50">
        <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                class="relative w-12 h-12 bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 dark:border-gray-700/20 flex items-center justify-center group hover:scale-110 transition-all duration-300">
            <!-- Sun icon -->
            <i class="fas fa-sun text-2xl text-yellow-500 absolute transition-all duration-500" 
               :class="{ 'opacity-0 rotate-90 scale-0': darkMode, 'opacity-100 rotate-0 scale-100': !darkMode }"></i>
            <!-- Moon icon -->
            <i class="fas fa-moon text-2xl text-blue-400 absolute transition-all duration-500" 
               :class="{ 'opacity-100 rotate-0 scale-100': darkMode, 'opacity-0 -rotate-90 scale-0': !darkMode }"></i>
            
            <!-- Glow effect -->
            <div class="absolute inset-0 rounded-2xl transition-all duration-500"
                 :class="{ 'bg-gradient-to-r from-yellow-400/20 to-orange-400/20': !darkMode, 'bg-gradient-to-r from-blue-400/20 to-purple-400/20': darkMode }"></div>
        </button>
    </div>

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-orange-500 to-red-500 dark:from-gray-800 dark:to-gray-900 shadow-2xl backdrop-blur-xl border-b border-white/20 dark:border-gray-700/20 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo and Restaurant Name -->
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white/20 dark:bg-gray-700/20 backdrop-blur-sm rounded-xl flex items-center justify-center shadow-lg">
                        @if($restaurant->logo_url)
                            <img src="{{ $restaurant->logo_url }}" alt="{{ $restaurant->name }}" class="w-10 h-10 rounded-lg object-cover">
                        @else
                            <i class="fas fa-utensils text-2xl text-white"></i>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $restaurant->name }}</h1>
                        @if($restaurant->tagline)
                            <p class="text-white/80 text-sm">{{ $restaurant->tagline }}</p>
                        @endif
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#menu" class="text-white/90 hover:text-white font-medium transition-colors duration-300 hover:scale-105">Menu</a>
                    <a href="#about" class="text-white/90 hover:text-white font-medium transition-colors duration-300 hover:scale-105">À propos</a>
                    <a href="#contact" class="text-white/90 hover:text-white font-medium transition-colors duration-300 hover:scale-105">Contact</a>
                </div>

                <!-- Cart Button -->
                <button @click="$store.cartOpen = true" 
                        class="relative bg-yellow-400 dark:bg-yellow-500 hover:bg-yellow-500 dark:hover:bg-yellow-600 text-gray-900 dark:text-white px-6 py-3 rounded-2xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 group">
                    <i class="fas fa-shopping-cart mr-2 group-hover:rotate-12 transition-transform duration-300"></i>
                    Panier
                    <span x-show="$store.cart.getItemCount() > 0" 
                          x-text="$store.cart.getItemCount()"
                          class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center animate-bounce"></span>
                </button>

                <!-- Mobile menu button -->
                <button @click="$store.mobileMenuOpen = !$store.mobileMenuOpen" 
                        class="md:hidden text-white hover:text-yellow-300 transition-colors duration-300">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="$store.mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-4"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-4"
             class="md:hidden bg-gradient-to-r from-orange-500 to-red-500 dark:from-gray-800 dark:to-gray-900 border-t border-white/20 dark:border-gray-700/20">
            <div class="px-4 py-6 space-y-4">
                <a href="#menu" class="block text-white/90 hover:text-white font-medium transition-colors duration-300">Menu</a>
                <a href="#about" class="block text-white/90 hover:text-white font-medium transition-colors duration-300">À propos</a>
                <a href="#contact" class="block text-white/90 hover:text-white font-medium transition-colors duration-300">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-900 via-gray-800 to-black dark:from-black dark:via-gray-900 dark:to-gray-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Restaurant Info -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        @if($restaurant->logo_url)
                            <img src="{{ $restaurant->logo_url }}" alt="{{ $restaurant->name }}" class="w-10 h-10 rounded-lg object-cover">
                        @else
                            <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-utensils text-white"></i>
                            </div>
                        @endif
                        <h3 class="text-xl font-bold">{{ $restaurant->name }}</h3>
                    </div>
                    @if($restaurant->description)
                        <p class="text-gray-300">{{ Str::limit($restaurant->description, 150) }}</p>
                    @endif
                </div>

                <!-- Contact Info -->
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold">Contact</h4>
                    @if($restaurant->phone)
                        <div class="flex items-center space-x-3 text-gray-300">
                            <i class="fas fa-phone text-orange-400"></i>
                            <span>{{ $restaurant->phone }}</span>
                        </div>
                    @endif
                    @if($restaurant->email)
                        <div class="flex items-center space-x-3 text-gray-300">
                            <i class="fas fa-envelope text-orange-400"></i>
                            <span>{{ $restaurant->email }}</span>
                        </div>
                    @endif
                    @if($restaurant->address)
                        <div class="flex items-center space-x-3 text-gray-300">
                            <i class="fas fa-map-marker-alt text-orange-400"></i>
                            <span>{{ $restaurant->address }}, {{ $restaurant->city }}, {{ $restaurant->country }}</span>
                        </div>
                    @endif
                </div>

                <!-- Social Links -->
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold">Suivez-nous</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center text-white hover:scale-110 transition-transform duration-300">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center text-white hover:scale-110 transition-transform duration-300">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center text-white hover:scale-110 transition-transform duration-300">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} {{ $restaurant->name }}. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Cookie Banner -->
    <div x-data="{ showCookieBanner: !localStorage.getItem('cookiesAccepted') }" 
         x-show="showCookieBanner"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-full"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-full"
         class="fixed bottom-4 left-4 right-4 z-50">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 p-6 backdrop-blur-xl">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-cookie-bite text-white text-xl"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Cookies</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">
                        Nous utilisons des cookies pour améliorer votre expérience sur notre site.
                    </p>
                    <div class="flex space-x-3">
                        <button @click="localStorage.setItem('cookiesAccepted', 'true'); showCookieBanner = false"
                                class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-2 rounded-xl font-medium hover:scale-105 transition-transform duration-300">
                            Accepter
                        </button>
                        <button @click="localStorage.setItem('cookiesAccepted', 'false'); showCookieBanner = false"
                                class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-xl font-medium hover:scale-105 transition-transform duration-300">
                            Refuser
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Modal -->
    <div x-show="$store.cartOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900/75 dark:bg-black/75 backdrop-blur-sm"></div>
            </div>

            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl shadow-2xl text-left overflow-hidden transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-gradient-to-r from-orange-500 to-red-500 dark:from-gray-700 dark:to-gray-800 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">Votre Panier</h3>
                        <button @click="$store.cartOpen = false" class="text-white hover:text-yellow-300 transition-colors duration-300">
                            <i class="fas fa-times text-2xl"></i>
                        </button>
                    </div>
                </div>

                <div class="px-6 py-4 max-h-96 overflow-y-auto">
                    <template x-if="$store.cart.getItemCount() === 0">
                        <div class="text-center py-8">
                            <i class="fas fa-shopping-cart text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                            <p class="text-gray-500 dark:text-gray-400">Votre panier est vide</p>
                        </div>
                    </template>

                    <template x-for="(item, index) in $store.cart" :key="index">
                        <div class="flex items-center space-x-4 py-4 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                            <img :src="item.image" :alt="item.name" class="w-16 h-16 rounded-lg object-cover">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 dark:text-white" x-text="item.name"></h4>
                                <p class="text-gray-500 dark:text-gray-400" x-text="item.description"></p>
                                <div class="flex items-center justify-between mt-2">
                                    <div class="flex items-center space-x-2">
                                        <button @click="$store.cart.updateQuantity(item.id, item.quantity - 1)" 
                                                class="w-8 h-8 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full flex items-center justify-center hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-300">
                                            <i class="fas fa-minus text-xs"></i>
                                        </button>
                                        <span class="text-gray-900 dark:text-white font-semibold" x-text="item.quantity"></span>
                                        <button @click="$store.cart.updateQuantity(item.id, item.quantity + 1)" 
                                                class="w-8 h-8 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full flex items-center justify-center hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-300">
                                            <i class="fas fa-plus text-xs"></i>
                                        </button>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <span class="font-bold text-gray-900 dark:text-white" x-text="$store.formatPrice(item.price * item.quantity)"></span>
                                        <button @click="$store.cart.remove(item.id)" 
                                                class="text-red-500 hover:text-red-700 transition-colors duration-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">Total:</span>
                        <span class="text-2xl font-bold text-gray-900 dark:text-white" 
                              x-text="$store.formatPrice($store.cart.getTotal())"></span>
                    </div>
                    <div class="flex space-x-3">
                        <button @click="$store.cart.clear()" 
                                x-show="$store.cart.getItemCount() > 0"
                                class="flex-1 bg-gray-500 text-white py-3 rounded-xl font-semibold hover:bg-gray-600 transition-colors duration-300">
                            Vider le panier
                        </button>
                        <button @click="$store.cartOpen = false; window.location.href = '{{ route('restaurant.public.checkout', $restaurant->slug) }}'"
                                :disabled="$store.cart.getItemCount() === 0"
                                class="flex-1 bg-gradient-to-r from-orange-500 to-red-500 text-white py-3 rounded-xl font-semibold hover:scale-105 transition-transform duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
                            Passer la commande
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    <div x-data="{ notifications: [] }" 
         @notification.window="notifications.push($event.detail); setTimeout(() => { notifications = notifications.filter(n => n.id !== $event.detail.id) }, 5000)"
         class="fixed top-4 right-4 z-50 space-y-2">
        <template x-for="notification in notifications" :key="notification.id">
            <div x-show="true"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-full"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform translate-x-full"
                 class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-4 rounded-2xl shadow-2xl z-50 transform translate-x-full transition-all duration-500 backdrop-blur-xl">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-xl"></i>
                    <span x-text="notification.message"></span>
                </div>
            </div>
        </template>
    </div>

    <!-- Alpine.js Store -->
    <script>
        document.addEventListener('alpine:init', function() {
            // Initialize Alpine.js store
            Alpine.store('cartOpen', false);
            Alpine.store('mobileMenuOpen', false);
            Alpine.store('cart', []);
            
            // Cart methods
            Alpine.store('cart').getSubtotal = function() {
                return this.reduce((total, item) => total + (item.price * item.quantity), 0);
            };
            
            Alpine.store('cart').getDeliveryFee = function() {
                const deliveryType = document.querySelector('input[name="delivery_type"]:checked');
                if (deliveryType && deliveryType.value === 'delivery') {
                    return {{ $restaurant->delivery_fee ?? 0 }};
                }
                return 0;
            };
            
            Alpine.store('cart').getDiscount = function() {
                // Pour l'instant, pas de réduction
                return 0;
            };
            
            Alpine.store('cart').getTotal = function() {
                return this.getSubtotal() + this.getDeliveryFee() - this.getDiscount();
            };
            
            Alpine.store('cart').clear = function() {
                this.length = 0;
                this.saveToStorage();
            };
            
            Alpine.store('cart').add = function(item) {
                const existingItem = this.find(cartItem => cartItem.id === item.id);
                
                if (existingItem) {
                    existingItem.quantity++;
                } else {
                    this.push({
                        ...item,
                        quantity: 1
                    });
                }
                
                // Sauvegarder dans localStorage
                this.saveToStorage();
                
                // Show notification
                window.dispatchEvent(new CustomEvent('notification', {
                    detail: {
                        id: Date.now(),
                        message: `${item.name} ajouté au panier !`
                    }
                }));
            };
            
            Alpine.store('cart').remove = function(itemId) {
                const index = this.findIndex(item => item.id === itemId);
                if (index > -1) {
                    this.splice(index, 1);
                    this.saveToStorage();
                }
            };
            
            Alpine.store('cart').updateQuantity = function(itemId, quantity) {
                const item = this.find(item => item.id === itemId);
                if (item) {
                    if (quantity <= 0) {
                        this.remove(itemId);
                    } else {
                        item.quantity = quantity;
                        this.saveToStorage();
                    }
                }
            };
            
            Alpine.store('cart').getItemCount = function() {
                return this.reduce((total, item) => total + item.quantity, 0);
            };
            
            Alpine.store('cart').saveToStorage = function() {
                localStorage.setItem('restaurant_cart', JSON.stringify(this));
            };
            
            Alpine.store('cart').loadFromStorage = function() {
                const saved = localStorage.getItem('restaurant_cart');
                if (saved) {
                    const items = JSON.parse(saved);
                    this.length = 0;
                    items.forEach(item => this.push(item));
                }
            };
        });
        
        // Charger le panier quand Alpine.js est initialisé
        document.addEventListener('alpine:init', function() {
            // Charger le panier depuis localStorage
            Alpine.store('cart').loadFromStorage();
            
            // Add to cart function (global)
            window.addToCart = function(id, name, price, image, description = '') {
                const cart = Alpine.store('cart');
                const existingItem = cart.find(item => item.id === id);
                
                if (existingItem) {
                    existingItem.quantity++;
                } else {
                    cart.push({
                        id: id,
                        name: name,
                        description: description,
                        price: parseFloat(price),
                        image: image,
                        quantity: 1
                    });
                }
                
                // Sauvegarder dans localStorage
                cart.saveToStorage();
                
                // Show notification
                window.dispatchEvent(new CustomEvent('notification', {
                    detail: {
                        id: Date.now(),
                        message: `${name} ajouté au panier !`
                    }
                }));
            };
            
            // Format price function for dynamic currency
            window.formatPrice = function(amount) {
                const currency = '{{ $restaurant->currency }}';
                const symbol = '{{ $restaurant->currency_symbol }}';
                
                if (currency === 'XOF') {
                    // Pour XOF, pas de décimales
                    return symbol + ' ' + Math.round(amount).toLocaleString('fr-FR');
                } else {
                    // Pour EUR et USD, 2 décimales
                    return symbol + ' ' + parseFloat(amount).toFixed(2).replace('.', ',');
                }
            };
            
            // Rendre formatPrice accessible à Alpine.js
            Alpine.store('formatPrice', window.formatPrice);
        });
    </script>

    @stack('scripts')
</body>
</html> 