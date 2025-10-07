<!DOCTYPE html>
<html lang="fr" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PeleFood - Plateforme SaaS pour Restaurants')</title>
    <meta name="description" content="@yield('description', 'Plateforme SaaS moderne et professionnelle pour la gestion complète de votre restaurant. Commandes, paiements, analytics et plus encore.')">
    
    <!-- Tailwind CSS -->
    <!-- Tailwind CSS Local -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Livewire Styles -->
    @livewireStyles
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
        }
        
        /* Gradients modernes - Style CinetPay */
        .gradient-primary {
            background: linear-gradient(135deg, #f97316 0%, #ef4444 100%);
        }
        
        .gradient-secondary {
            background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);
        }
        
        .gradient-success {
            background: linear-gradient(135deg, #f97316 0%, #ef4444 100%);
        }
        
        /* Effets de verre modernes */
        .glass-effect {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        .glass-card {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }
        
        /* Animations avancées */
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }
        
        .animate-fade-in {
            animation: fadeIn 1.2s ease-out forwards;
            opacity: 0;
        }
        
        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(50px) scale(0.95); 
                filter: blur(10px);
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
                filter: blur(0);
            }
        }
        
        .animate-slide-in-left {
            animation: slideInLeft 1s ease-out forwards;
            opacity: 0;
        }
        
        @keyframes slideInLeft {
            from { 
                opacity: 0; 
                transform: translateX(-80px) rotate(-5deg); 
                filter: blur(5px);
            }
            to { 
                opacity: 1; 
                transform: translateX(0) rotate(0deg); 
                filter: blur(0);
            }
        }
        
        .animate-slide-in-right {
            animation: slideInRight 1s ease-out forwards;
            opacity: 0;
        }
        
        @keyframes slideInRight {
            from { 
                opacity: 0; 
                transform: translateX(80px) rotate(5deg); 
                filter: blur(5px);
            }
            to { 
                opacity: 1; 
                transform: translateX(0) rotate(0deg); 
                filter: blur(0);
            }
        }
        
        .animate-scale-in {
            animation: scaleIn 0.8s ease-out forwards;
            opacity: 0;
            transform: scale(0.8);
        }
        
        @keyframes scaleIn {
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .animate-glow {
            animation: glow 2s ease-in-out infinite alternate;
        }
        
        @keyframes glow {
            from {
                box-shadow: 0 0 20px rgba(249, 115, 22, 0.3);
            }
            to {
                box-shadow: 0 0 40px rgba(249, 115, 22, 0.6);
            }
        }
        
        .animate-pulse-slow {
            animation: pulseSlow 3s ease-in-out infinite;
        }
        
        @keyframes pulseSlow {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
        
        /* Boutons premium avec effets avancés */
        .btn-primary {
            background: linear-gradient(135deg, #f97316 0%, #ef4444 50%, #dc2626 100%);
            border: none;
            color: white;
            font-weight: 700;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 25px 0 rgba(249, 115, 22, 0.4);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 35px 0 rgba(249, 115, 22, 0.6);
            background: linear-gradient(135deg, #ea580c 0%, #dc2626 50%, #b91c1c 100%);
        }
        
        .btn-primary:active {
            transform: translateY(-1px) scale(0.98);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-weight: 600;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            backdrop-filter: blur(10px);
        }
        
        .btn-secondary::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: width 0.4s ease;
        }
        
        .btn-secondary:hover::before {
            width: 100%;
        }
        
        .btn-secondary:hover {
            border-color: rgba(255, 255, 255, 0.6);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px 0 rgba(0, 0, 0, 0.2);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }
        
        /* Cartes premium avec effets 3D */
        .card-modern {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 1.5rem;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.08),
                0 8px 16px rgba(0, 0, 0, 0.04),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(249, 115, 22, 0.3), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        
        .card-modern:hover::before {
            opacity: 1;
        }
        
        .card-modern:hover {
            transform: translateY(-8px) rotateX(5deg);
            box-shadow: 
                0 30px 60px rgba(0, 0, 0, 0.12),
                0 15px 30px rgba(0, 0, 0, 0.08),
                0 0 0 1px rgba(249, 115, 22, 0.1);
        }
        
        .card-modern:active {
            transform: translateY(-4px) rotateX(2deg);
        }
        
        /* Gradients animés */
        .gradient-animated {
            background: linear-gradient(-45deg, #f97316, #ef4444, #dc2626, #b91c1c);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Effets de texte */
        .text-gradient {
            background: linear-gradient(135deg, #f97316 0%, #ef4444 50%, #dc2626 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: textShine 3s ease-in-out infinite;
        }
        
        @keyframes textShine {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        /* Navigation moderne */
        .nav-link {
            position: relative;
            color: #6b7280;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 0;
        }
        
        .nav-link:hover {
            color: #f97316;
        }
        
        .nav-link.active {
            color: #f97316;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, #f97316 0%, #ef4444 100%);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
        
        /* Header fixe */
        .header-fixed {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        /* Scrollbar personnalisée */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #e55a2b 0%, #e0841a 100%);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .animate-slide-in-left,
            .animate-slide-in-right {
                animation: fadeIn 0.8s ease-out;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="h-full">
    <!-- Header -->
    <header class="header-fixed fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 gradient-primary rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-utensils text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">PeleFood</h1>
                        <p class="text-xs text-gray-500">SaaS Platform</p>
                    </div>
                </div>
                
                <!-- Navigation Desktop -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        Accueil
                    </a>
                    <a href="{{ route('features') }}" class="nav-link {{ request()->routeIs('features') ? 'active' : '' }}">
                        Fonctionnalités
                    </a>
                    <a href="{{ route('pricing') }}" class="nav-link {{ request()->routeIs('pricing') ? 'active' : '' }}">
                        Tarifs
                    </a>
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                        À propos
                    </a>
                    <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                        Contact
                    </a>
                </nav>
                
                <!-- Actions -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary px-6 py-2 rounded-lg text-sm">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                                Déconnexion
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary px-6 py-2 rounded-lg text-sm">
                            Commencer
                        </a>
                    @endauth
                    
                    <!-- Menu mobile -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Menu mobile -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="md:hidden glass-effect border-t border-gray-200">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" class="block py-2 text-gray-600 hover:text-gray-900">Accueil</a>
                <a href="{{ route('features') }}" class="block py-2 text-gray-600 hover:text-gray-900">Fonctionnalités</a>
                <a href="{{ route('pricing') }}" class="block py-2 text-gray-600 hover:text-gray-900">Tarifs</a>
                <a href="{{ route('about') }}" class="block py-2 text-gray-600 hover:text-gray-900">À propos</a>
                <a href="{{ route('contact') }}" class="block py-2 text-gray-600 hover:text-gray-900">Contact</a>
            </div>
        </div>
    </header>
    
    <!-- Contenu principal -->
    <main class="pt-16 min-h-screen">
        {{ $slot ?? '' }}
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo et description -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 gradient-primary rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-utensils text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">PeleFood</h3>
                            <p class="text-sm text-gray-400">SaaS Platform</p>
                        </div>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-md">
                        Plateforme SaaS moderne et professionnelle pour la gestion complète de votre restaurant. 
                        Commandes, paiements, analytics et bien plus encore.
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
                    <h4 class="text-lg font-semibold mb-4">Liens rapides</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors">Accueil</a></li>
                        <li><a href="{{ route('features') }}" class="text-gray-400 hover:text-white transition-colors">Fonctionnalités</a></li>
                        <li><a href="{{ route('pricing') }}" class="text-gray-400 hover:text-white transition-colors">Tarifs</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition-colors">À propos</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Support -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Centre d'aide</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">API</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Statut</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} PeleFood. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
    
    <!-- Alpine.js pour l'interactivité (AVANT Livewire) -->
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Scripts personnalisés -->
    <script>
        // Gestion du menu mobile
        document.addEventListener('alpine:init', () => {
            Alpine.data('mobileMenu', () => ({
                mobileMenuOpen: false
            }))
        });
        
        // Scroll smooth pour les liens d'ancrage
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
        
        // Animation d'entrée pour les éléments
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, observerOptions);
        
        // Observer les éléments avec la classe animate-on-scroll
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });
    </script>
    
    @stack('scripts')
</body>
</html>
