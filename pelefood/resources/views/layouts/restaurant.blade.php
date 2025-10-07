<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Backoffice Restaurant - PeleFood')</title>
    <meta name="description" content="@yield('description', 'Gestion complète de votre restaurant')">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Chart.js pour les graphiques -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .sidebar-transition { transition: all 0.3s ease-in-out; }
        .content-transition { transition: margin-left 0.3s ease-in-out; }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div x-data="{ sidebarOpen: true, mobileSidebarOpen: false }" class="min-h-screen">
        
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-orange-600 to-red-600 sidebar-transition"
             :class="{ '-translate-x-full': !sidebarOpen && !mobileSidebarOpen, 'translate-x-0': sidebarOpen || mobileSidebarOpen }">
            
            <!-- Logo et Header -->
            <div class="flex items-center justify-between h-16 px-6 bg-white/10">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-orange-600 font-bold text-xl">P</span>
                    </div>
                    <span class="text-white font-bold text-lg">PeleFood</span>
                </div>
                
                <!-- Bouton fermer sur mobile -->
                <button @click="mobileSidebarOpen = false" class="lg:hidden text-white hover:text-orange-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-8 px-4">
                <div class="space-y-2">
                    
                    <!-- Dashboard -->
                    <a href="{{ route('restaurant.dashboard') }}" 
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('restaurant.dashboard') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                        <span>Tableau de bord</span>
                    </a>
                    
                    <!-- Commandes -->
                    <a href="{{ route('restaurant.orders.index') }}" 
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('restaurant.orders*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-shopping-cart w-5 mr-3"></i>
                        <span>Commandes</span>
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">12</span>
                    </a>
                    
                    <!-- Notifications -->
                    <a href="{{ route('restaurant.notifications.index') }}" 
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('restaurant.notifications*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-bell w-5 mr-3"></i>
                        <span>Notifications</span>
                        @if(auth()->user()->unreadNotifications()->count() > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                            {{ auth()->user()->unreadNotifications()->count() }}
                        </span>
                        @endif
                    </a>
                    
                    <!-- Menu -->
                    <a href="{{ route('restaurant.menu.index') }}" 
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('restaurant.menu*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-utensils w-5 mr-3"></i>
                        <span>Menu & Plats</span>
                    </a>
                    
                    <!-- Catégories -->
                    <a href="{{ route('restaurant.categories.index') }}" 
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('restaurant.categories*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-tags w-5 mr-3"></i>
                        <span>Catégories</span>
                    </a>
                    
                    <!-- Clients -->
                    <a href="{{ route('restaurant.customers.index') }}" 
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('restaurant.customers*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-users w-5 mr-3"></i>
                        <span>Clients</span>
                    </a>
                    
                    <!-- Livraisons -->
                    <a href="{{ route('restaurant.deliveries.index') }}" 
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('restaurant.deliveries*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-truck w-5 mr-3"></i>
                        <span>Livraisons</span>
                    </a>
                    
                    <!-- Comptabilité -->
                    <a href="{{ route('restaurant.accounting.index') }}" 
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('restaurant.accounting*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-chart-line w-5 mr-3"></i>
                        <span>Comptabilité</span>
                    </a>
                    
                    <!-- Portefeuille -->
                    <a href="{{ route('restaurant.wallet.index') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('restaurant.wallet*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-wallet w-5 mr-3"></i>
                        <span>Mon Portefeuille</span>
                    </a>
                    
                    <!-- Promotions -->
                    <a href="{{ route('restaurant.promotions.index') }}" 
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('restaurant.promotions*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-percentage w-5 mr-3"></i>
                        <span>Promotions</span>
                    </a>
                    
                    <!-- Avis & Notes -->
                    <a href="{{ route('restaurant.reviews.index') }}" 
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('restaurant.reviews*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-star w-5 mr-3"></i>
                        <span>Avis & Notes</span>
                    </a>
                    
                    <!-- Paramètres -->
                    <a href="{{ route('restaurant.settings.index') }}" 
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('restaurant.settings*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        <span>Paramètres</span>
                    </a>
                </div>
            </nav>
            
            <!-- Footer Sidebar -->
            <div class="absolute bottom-0 left-0 right-0 p-4">
                <div class="bg-white/10 rounded-xl p-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-orange-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-medium text-sm">{{ Auth::user()->name ?? 'Restaurant' }}</p>
                            <p class="text-orange-200 text-xs">Gérant</p>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full bg-white/20 text-white py-2 px-4 rounded-lg hover:bg-white/30 transition-colors text-sm">
                            <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Overlay mobile -->
        <div x-show="mobileSidebarOpen" @click="mobileSidebarOpen = false" 
             class="fixed inset-0 z-40 bg-black/50 lg:hidden"></div>
        
        <!-- Contenu principal -->
        <div class="content-transition" :class="{ 'lg:ml-64': sidebarOpen }">
            
            <!-- Header principal -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between h-16 px-6">
                    
                    <!-- Bouton menu mobile -->
                    <button @click="mobileSidebarOpen = true" class="lg:hidden text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Bouton toggle sidebar desktop -->
                    <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Titre de la page -->
                    <div class="flex-1 text-center lg:text-left">
                        <h1 class="text-xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    
                    <!-- Actions rapides -->
                    <div class="flex items-center space-x-4">
                        
                        <!-- Profil utilisateur -->
                        <div class="flex items-center space-x-4">
                            <!-- Lien vers le site public -->
                            @php
                                $currentRestaurant = $restaurant ?? auth()->user()->tenant->restaurants->first() ?? null;
                            @endphp
                            @if($currentRestaurant)
                                <a href="{{ route('restaurant.show', $currentRestaurant->slug) }}" target="_blank" 
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-orange-600 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    Voir mon site
                                </a>
                            @else
                                <a href="{{ route('restaurant.show', 'demo') }}" target="_blank" 
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-orange-600 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    Voir mon site
                                </a>
                            @endif
                            
                            <!-- Notifications -->
                            @include('restaurant.partials.notification-dropdown')
                        </div>
                        
                        <!-- Nouvelle commande -->
                        <a href="{{ route('restaurant.orders.create') }}" 
                           class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Nouvelle commande
                        </a>
                    </div>
                </div>
            </header>
            
            <!-- Contenu de la page -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Scripts personnalisés -->
    @stack('scripts')
    
    <!-- Scripts globaux -->
    <script>
        // Gestion des notifications
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
        
        // Gestion des confirmations
        function confirmAction(message, callback) {
            if (confirm(message)) {
                callback();
            }
        }
        
        // Gestion des erreurs AJAX
        document.addEventListener('DOMContentLoaded', function() {
            // Intercepter les erreurs de validation
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('input[type="submit"], button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.value = 'En cours...';
                    }
                });
            });
        });
    </script>
</body>
</html> 