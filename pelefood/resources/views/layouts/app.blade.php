<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'PeleFood - Plateforme SaaS pour Restaurants')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CSS Fintech Moderne -->
    <link rel="stylesheet" href="{{ asset('css/fintech-modern.css') }}">
    
    <!-- CSS Restaurant SaaS -->
    <link rel="stylesheet" href="{{ asset('css/restaurant-saas.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Livewire Scripts -->
    @livewireStyles
    
    <!-- Interactions Modernes -->
    <script defer src="{{ asset('js/modern-interactions.js') }}"></script>
    
    <!-- Interactions Fintech -->
    <script defer src="{{ asset('js/fintech-interactions.js') }}"></script>

    <style>
        .gradient-text {
            background: linear-gradient(135deg, #F77F00 0%, #F4A261 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .glass-effect {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .slide-in {
            animation: slideIn 0.6s ease-out;
        }
        
        @keyframes slideIn {
            from { transform: translateY(-100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        /* Nouvelles animations et effets */
        .nav-link {
            @apply text-gray-900 hover:text-orange-600 px-4 py-2 text-sm font-semibold transition-all duration-500 relative;
        }
        
        .nav-link:hover {
            @apply text-orange-600 transform scale-105;
        }
        
        /* Styles spécifiques pour les liens de navigation */
        nav a.nav-link {
            color: #111827 !important; /* text-gray-900 */
        }
        
        nav a.nav-link:hover {
            color: #ea580c !important; /* text-orange-600 */
        }
        
        /* Animation du logo */
        .logo-container {
            transition: all 0.3s ease;
        }
        
        .logo-container:hover {
            transform: scale(1.05) rotate(2deg);
        }
        
        /* Effet de focus pour les boutons */
        .btn-focus:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.3);
        }
        
        /* Animation des icônes sociales */
        .social-icon {
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            transform: translateY(-3px) scale(1.1);
        }
        
        /* Effet de survol pour les liens du footer */
        .footer-link {
            transition: all 0.3s ease;
        }
        
        .footer-link:hover {
            transform: translateX(5px);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav x-data="{ mobileMenuOpen: false, scrolled: false }" 
         @scroll.window="scrolled = window.pageYOffset > 50"
         class="fixed top-0 left-0 right-0 z-50 transition-all duration-500"
         :class="scrolled ? 'glass-effect shadow-2xl border-b border-orange-200/20' : 'bg-white/95 backdrop-blur-sm'">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center group logo-container">
                        <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-2xl transition-all duration-500 transform group-hover:scale-110 group-hover:rotate-3">
                            <span class="text-white font-bold text-2xl">P</span>
                        </div>
                        <span class="ml-4 text-3xl font-black gradient-text group-hover:scale-105 transition-transform duration-300">PeleFood</span>
                    </a>
                </div>

                <!-- Navigation Links Desktop -->
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" 
                       class="nav-link relative group">
                        Accueil
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-orange-500 to-yellow-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('features') }}" 
                       class="nav-link relative group">
                        Fonctionnalités
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-orange-500 to-yellow-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('pricing') }}" 
                       class="nav-link relative group">
                        Tarifs
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-orange-500 to-yellow-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('about') }}" 
                       class="nav-link relative group">
                        À propos
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-orange-500 to-yellow-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="nav-link relative group">
                        Contact
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-orange-500 to-yellow-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </div>

                <!-- Auth Buttons Desktop -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <div class="flex items-center space-x-4">
                            @if(auth()->user()->isSuperAdmin())
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="text-gray-700 hover:text-orange-600 px-4 py-2 rounded-lg font-medium transition-all duration-300 hover:bg-orange-50">
                                    Tableau de bord
                                </a>
                            @elseif(auth()->user()->role === 'admin' || auth()->user()->role === 'restaurant')
                                <a href="{{ route('restaurant.dashboard') }}" 
                                   class="text-gray-700 hover:text-orange-600 px-4 py-2 rounded-lg font-medium transition-all duration-300 hover:bg-orange-50">
                                    Tableau de bord
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" 
                                   class="text-gray-700 hover:text-orange-600 px-4 py-2 rounded-lg font-medium transition-all duration-300 hover:bg-orange-50">
                                    Tableau de bord
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="text-gray-700 hover:text-red-600 px-4 py-2 rounded-lg font-medium transition-all duration-300 hover:bg-red-50 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>Déconnexion</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('login') }}" 
                               class="text-gray-700 hover:text-orange-600 px-4 py-2 rounded-lg font-medium transition-all duration-300 hover:bg-orange-50">
                                Connexion
                            </a>
                            <a href="{{ route('register') }}" 
                               class="btn-restaurant-primary text-white px-6 py-2.5 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl btn-focus">
                                Commencer
                            </a>
                        </div>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="text-gray-700 hover:text-orange-600 p-2 rounded-lg transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="md:hidden glass-effect border-t border-gray-200/20">
            <div class="px-4 py-6 space-y-4">
                <a href="{{ route('home') }}" 
                   class="block py-3 text-gray-700 hover:text-orange-600 font-medium transition-colors duration-200">
                    Accueil
                </a>
                <a href="{{ route('features') }}" 
                   class="block py-3 text-gray-700 hover:text-orange-600 font-medium transition-colors duration-200">
                    Fonctionnalités
                </a>
                <a href="{{ route('pricing') }}" 
                   class="block py-3 text-gray-700 hover:text-orange-600 font-medium transition-colors duration-200">
                    Tarifs
                </a>
                <a href="{{ route('about') }}" 
                   class="block py-3 text-gray-700 hover:text-orange-600 font-medium transition-colors duration-200">
                    À propos
                </a>
                <a href="{{ route('contact') }}" 
                   class="block py-3 text-gray-700 hover:text-orange-600 font-medium transition-colors duration-200">
                    Contact
                </a>
                
                <div class="pt-4 border-t border-gray-200/20">
                    @auth
                        @if(auth()->user()->isSuperAdmin())
                            <a href="{{ route('admin.dashboard') }}" 
                               class="block py-3 text-gray-700 hover:text-orange-600 font-medium transition-colors duration-200">
                                Tableau de bord
                            </a>
                        @elseif(auth()->user()->role === 'admin' || auth()->user()->role === 'restaurant')
                            <a href="{{ route('restaurant.dashboard') }}" 
                               class="block py-3 text-gray-700 hover:text-orange-600 font-medium transition-colors duration-200">
                                Tableau de bord
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" 
                               class="block py-3 text-gray-700 hover:text-orange-600 font-medium transition-colors duration-200">
                                Tableau de bord
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" 
                                    class="w-full text-left py-3 text-gray-700 hover:text-red-600 font-medium transition-colors duration-200 flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" 
                           class="block py-3 text-gray-700 hover:text-orange-600 font-medium transition-colors duration-200">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" 
                           class="block py-3 btn-restaurant-primary text-white rounded-lg font-medium text-center transition-all duration-300">
                            Commencer
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-10 left-10 w-32 h-32 bg-orange-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-40 h-40 bg-teal-500/10 rounded-full blur-3xl"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <!-- Brand Section -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-2xl">P</span>
                        </div>
                        <span class="ml-3 text-3xl font-bold gradient-text">PeleFood</span>
                    </div>
                    <p class="text-gray-300 text-lg leading-relaxed max-w-lg mb-8">
                        La plateforme SaaS complète pour digitaliser votre restaurant. 
                        Gérez vos commandes, menus et clients en toute simplicité.
                    </p>
                    
                    <!-- Social Links -->
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-orange-500 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg social-icon">
                            <i class="fab fa-twitter text-gray-400 hover:text-white transition-colors duration-300"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-orange-500 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg social-icon">
                            <i class="fab fa-facebook text-gray-400 hover:text-white transition-colors duration-300"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-orange-500 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg social-icon">
                            <i class="fab fa-linkedin text-gray-400 hover:text-white transition-colors duration-300"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-orange-500 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg social-icon">
                            <i class="fab fa-instagram text-gray-400 hover:text-white transition-colors duration-300"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Product Links -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-6">Produit</h3>
                    <ul class="space-y-4">
                        <li>
                            <a href="{{ route('features') }}" 
                               class="text-gray-300 hover:text-orange-400 transition-colors duration-300 hover:translate-x-1 inline-block footer-link">
                                Fonctionnalités
                            </a>
                        </li>
                        <li>
                            <a href="#" 
                               class="text-gray-300 hover:text-orange-400 transition-colors duration-300 hover:translate-x-1 inline-block footer-link">
                                API
                            </a>
                        </li>
                        <li>
                            <a href="#" 
                               class="text-gray-300 hover:text-orange-400 transition-colors duration-300 hover:translate-x-1 inline-block footer-link">
                                Intégrations
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Support Links -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-6">Support</h3>
                    <ul class="space-y-4">
                        <li>
                            <a href="#" 
                               class="text-gray-300 hover:text-orange-400 transition-colors duration-300 hover:translate-x-1 inline-block footer-link">
                                Documentation
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" 
                               class="text-gray-300 hover:text-orange-400 transition-colors duration-300 hover:translate-x-1 inline-block footer-link">
                                Contact
                            </a>
                        </li>
                        <li>
                            <a href="#" 
                               class="text-gray-300 hover:text-orange-400 transition-colors duration-300 hover:translate-x-1 inline-block footer-link">
                                Status
                            </a>
                        </li>
                        <li>
                            <a href="#" 
                               class="text-gray-300 hover:text-orange-400 transition-colors duration-300 hover:translate-x-1 inline-block footer-link">
                                Communauté
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Section -->
            <div class="mt-16 pt-8 border-t border-gray-700">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">
                        © 2024 PeleFood. Tous droits réservés.
                    </p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-orange-400 text-sm transition-colors duration-300 footer-link">
                            Confidentialité
                        </a>
                        <a href="#" class="text-gray-400 hover:text-orange-400 text-sm transition-colors duration-300 footer-link">
                            Conditions
                        </a>
                        <a href="#" class="text-gray-400 hover:text-orange-400 text-sm transition-colors duration-300 footer-link">
                            Cookies
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button x-data="{ show: false }" 
            @scroll.window="show = window.pageYOffset > 300"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 z-40">
        <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <!-- Livewire Scripts -->
    @livewireScripts

</body>
</html> 