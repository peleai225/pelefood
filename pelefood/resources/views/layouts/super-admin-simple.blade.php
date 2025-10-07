<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Super Admin - PeleFood')</title>
    <meta name="description" content="@yield('description', 'Administration de la plateforme PeleFood')">
    
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
                        <i class="fas fa-crown text-orange-600 text-xl"></i>
                    </div>
                    <span class="text-white font-bold text-lg">Super Admin</span>
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
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Restaurants -->
                    <a href="{{ route('admin.restaurants.index') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('admin.restaurants*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-store w-5 mr-3"></i>
                        <span>Restaurants</span>
                    </a>

                    <!-- Utilisateurs -->
                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('admin.users*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-users w-5 mr-3"></i>
                        <span>Utilisateurs</span>
                    </a>

                    <!-- Commandes -->
                    <a href="{{ route('admin.orders.index') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('admin.orders*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-shopping-cart w-5 mr-3"></i>
                        <span>Commandes</span>
                    </a>

                    <!-- Produits -->
                    <a href="{{ route('admin.products.index') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('admin.products*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-box w-5 mr-3"></i>
                        <span>Produits</span>
                    </a>

                    <!-- Plans d'abonnement -->
                    <a href="{{ route('admin.subscription-plans.index') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('admin.subscription-plans*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-credit-card w-5 mr-3"></i>
                        <span>Plans d'abonnement</span>
                    </a>

                    <!-- Rapports -->
                    <a href="{{ route('admin.reports.index') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('admin.reports*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-chart-bar w-5 mr-3"></i>
                        <span>Rapports</span>
                    </a>

                    <!-- Notifications -->
                    <a href="{{ route('admin.notifications.index') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('admin.notifications*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-bell w-5 mr-3"></i>
                        <span>Notifications</span>
                        @if(auth()->user()->unreadNotifications()->count() > 0)
                            <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1">
                                {{ auth()->user()->unreadNotifications()->count() }}
                            </span>
                        @endif
                    </a>

                    <!-- Retraits -->
                    <a href="{{ route('admin.withdrawals.index') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('admin.withdrawals*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-wallet w-5 mr-3"></i>
                        <span>Retraits</span>
                    </a>

                    <!-- Tenants -->
                    <a href="{{ route('admin.tenants.index') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('admin.tenants*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-building w-5 mr-3"></i>
                        <span>Tenants</span>
                    </a>

                    <!-- Paramètres -->
                    <a href="{{ route('admin.settings.index') }}"
                       class="flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/20 transition-colors {{ request()->routeIs('admin.settings*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        <span>Paramètres</span>
                    </a>

                </div>
            </nav>
        </div>

        <!-- Contenu principal -->
        <div class="content-transition" :class="{ 'lg:ml-64': sidebarOpen }">
            
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6">
                    
                    <!-- Bouton menu mobile -->
                    <button @click="mobileSidebarOpen = true" class="lg:hidden text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Bouton toggle sidebar desktop -->
                    <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <!-- Titre de la page -->
                    <div class="flex-1 ml-4">
                        <h1 class="text-xl font-semibold text-gray-900">@yield('page-title', 'Super Admin')</h1>
                    </div>

                    <!-- Actions du header -->
                    <div class="flex items-center space-x-4">
                        
                        <!-- Notifications dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="relative text-gray-600 hover:text-gray-900">
                                <i class="fas fa-bell text-xl"></i>
                                @if(auth()->user()->unreadNotifications()->count() > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ auth()->user()->unreadNotifications()->count() }}
                                    </span>
                                @endif
                            </button>
                            
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95">
                                
                                <div class="p-4 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
                                </div>
                                
                                <div class="max-h-64 overflow-y-auto">
                                    @forelse(auth()->user()->unreadNotifications()->take(5)->get() as $notification)
                                        <div class="p-4 border-b border-gray-100 hover:bg-gray-50">
                                            <div class="flex items-start space-x-3">
                                                <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-bell text-orange-600 text-sm"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                                    <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-4 text-center text-gray-500">
                                            <p class="text-sm">Aucune notification</p>
                                        </div>
                                    @endforelse
                                </div>
                                
                                <div class="p-4 border-t border-gray-200">
                                    <a href="{{ route('admin.notifications.index') }}" class="text-orange-600 hover:text-orange-700 text-sm font-medium">
                                        Voir toutes les notifications
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Profil utilisateur -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 text-gray-700 hover:text-gray-900">
                                <div class="w-8 h-8 bg-orange-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <span class="hidden sm:block text-sm font-medium">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95">
                                
                                <div class="p-4 border-b border-gray-200">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                                
                                <div class="p-2">
                                    <a href="{{ route('admin.settings.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                        <i class="fas fa-cog mr-3"></i>
                                        Paramètres
                                    </a>
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                        <i class="fas fa-tachometer-alt mr-3"></i>
                                        Dashboard
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">
                                            <i class="fas fa-sign-out-alt mr-3"></i>
                                            Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Contenu de la page -->
            <main class="p-4 sm:p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
