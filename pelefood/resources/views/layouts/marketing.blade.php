<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'PeleFood - Digitalisez votre restaurant')</title>
    <meta name="description" content="@yield('description', 'Plateforme SaaS complète pour digitaliser votre restaurant en Afrique. Gérez vos commandes, menus et clients en toute simplicité.')">
    
    <!-- CSS local PeleFood -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- CSS de fallback Tailwind -->
    <link rel="stylesheet" href="{{ asset('css/tailwind-fallback.css') }}">
    
    <!-- Tailwind CSS via CDN autorisé (fallback) -->
    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/lib/index.min.js"></script>
    
    <!-- Alpine.js via CDN autorisé -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
    
    <!-- Font Awesome via CDN autorisé -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts via CDN autorisé -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Styles personnalisés supplémentaires -->
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #1A1A1A 0%, #2D2D2D 100%);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #FF6B00 0%, #FF8533 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 107, 0, 0.3);
        }
        
        .feature-card {
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .stat-number {
            background: linear-gradient(135deg, #FF6B00 0%, #FF8533 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Animations CSS */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideOutRight {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(30px);
            }
        }
        
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .animate-on-scroll.animate-in {
            opacity: 1;
            transform: translateY(0);
        }
        
        .fade-in, .slide-in-left, .slide-in-right {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        
        .fade-in.visible, .slide-in-left.visible, .slide-in-right.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .slide-in-left {
            transform: translateX(-30px);
        }
        
        .slide-in-right {
            transform: translateX(30px);
        }
        
        .slide-in-left.visible, .slide-in-right.visible {
            transform: translateX(0);
        }
    </style>
    
    @stack('styles')
</head>
<body class="antialiased">
    <!-- Header -->
    <header class="header" x-data="{ mobileMenuOpen: false }">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <span>PeleFood</span>
                </a>
                
                <!-- Navigation Desktop -->
                <nav class="nav hidden md:flex">
                    <a href="{{ route('features') }}" class="nav-link">Fonctionnalités</a>
                    <a href="{{ route('contact') }}" class="nav-link">Contact</a>
                </nav>
                
                <!-- Actions -->
                <div class="flex items-center gap-4">
                    <!-- Toggle de thème -->
                    <button class="theme-toggle p-2 rounded-lg hover:bg-gray-100 transition-colors" title="Changer de thème">
                        <i class="fas fa-sun text-gray-600"></i>
                    </button>
                    
                    <!-- Boutons d'action -->
                    <div class="hidden md:flex items-center gap-3">
                        @guest
                            <a href="{{ route('login') }}" class="nav-link">Connexion</a>
                            <a href="{{ route('register') }}" class="btn btn-primary">Commencer</a>
                        @else
                            @if(auth()->user()->hasRole('super_admin'))
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Admin</a>
                            @elseif(auth()->user()->hasRole('admin'))
                                <a href="{{ route('restaurant.dashboard') }}" class="btn btn-primary">Mon Restaurant</a>
                            @elseif(auth()->user()->hasRole('manager') || auth()->user()->hasRole('staff'))
                                <a href="{{ route('staff.dashboard') }}" class="btn btn-primary">Gestion</a>
                            @else
                                <a href="{{ route('profile.show') }}" class="btn btn-primary">Mon Compte</a>
                            @endif
                        @endguest
                    </div>
                    
                    <!-- Menu mobile toggle -->
                    <button 
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="mobile-menu-toggle md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors"
                        :aria-expanded="mobileMenuOpen"
                    >
                        <i class="fas fa-bars" x-show="!mobileMenuOpen"></i>
                        <i class="fas fa-times" x-show="mobileMenuOpen"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Menu mobile -->
        <div 
            class="mobile-menu md:hidden absolute top-full left-0 right-0 bg-white border-t border-gray-200 shadow-lg transform transition-transform duration-300"
            :class="mobileMenuOpen ? 'translate-y-0' : '-translate-y-full'"
            x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="transform -translate-y-full"
            x-transition:enter-end="transform translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="transform translate-y-0"
            x-transition:leave-end="transform -translate-y-full"
        >
            <div class="container py-6">
                <nav class="space-y-4">
                    <a href="{{ route('features') }}" class="block py-2 text-gray-700 hover:text-gray-900 transition-colors">Fonctionnalités</a>
                    <a href="{{ route('contact') }}" class="block py-2 text-gray-700 hover:text-gray-900 transition-colors">Contact</a>
                </nav>
                
                <div class="pt-6 border-t border-gray-200">
                    @guest
                        <div class="space-y-3">
                            <a href="{{ route('login') }}" class="block w-full text-center py-2 px-4 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Connexion</a>
                            <a href="{{ route('register') }}" class="block w-full text-center py-2 px-4 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">Commencer</a>
                        </div>
                    @else
                        @if(auth()->user()->hasRole('super_admin'))
                            <a href="{{ route('admin.dashboard') }}" class="block w-full text-center py-2 px-4 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">Admin</a>
                        @elseif(auth()->user()->hasRole('admin'))
                            <a href="{{ route('restaurant.dashboard') }}" class="block w-full text-center py-2 px-4 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">Mon Restaurant</a>
                        @elseif(auth()->user()->hasRole('manager') || auth()->user()->hasRole('staff'))
                            <a href="{{ route('staff.dashboard') }}" class="block w-full text-center py-2 px-4 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">Gestion</a>
                        @else
                            <a href="{{ route('profile.show') }}" class="block w-full text-center py-2 px-4 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">Mon Compte</a>
                        @endif
                    @endguest
                </div>
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="container">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo et description -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-utensils text-white"></i>
                        </div>
                        <span class="text-xl font-bold">PeleFood</span>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-md">
                        La plateforme SaaS complète pour digitaliser votre restaurant en Afrique. 
                        Gérez vos commandes, menus et clients en toute simplicité.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Liens rapides -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Produits</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('features') }}" class="text-gray-400 hover:text-white transition-colors">Fonctionnalités</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">API</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Intégrations</a></li>
                    </ul>
                </div>
                
                <!-- Support -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Centre d'aide</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Statut</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">
                        © {{ date('Y') }} PeleFood. Tous droits réservés.
                    </p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Confidentialité</a>
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Conditions</a>
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Cookies</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript local PeleFood -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    @stack('scripts')
</body>
</html> 