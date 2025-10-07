<!-- Sidebar Super Admin simplifiée -->
<div class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-orange-600 to-red-600 shadow-2xl border-r border-orange-500/20 transform transition-transform duration-300 ease-in-out" id="superAdminSidebar">
    <!-- Logo et header -->
    <div class="flex items-center justify-between h-20 px-6 border-b border-orange-500/20">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-crown text-orange-600 text-xl"></i>
            </div>
            <div>
                <span class="text-2xl font-bold text-white">Super Admin</span>
                <p class="text-orange-200 text-xs">PeleFood Control</p>
            </div>
        </div>
        <button onclick="toggleSuperAdminSidebar()" class="p-2 rounded-xl hover:bg-white/10 transition-colors duration-200">
            <i class="fas fa-bars text-orange-200"></i>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <!-- Dashboard Super Admin -->
        <a href="{{ route('admin.super-admin.dashboard') }}" 
           class="group flex items-center px-4 py-4 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.super-admin.dashboard') ? 'bg-white/20 text-white' : 'text-orange-200 hover:bg-white/10 hover:text-white' }}">
            <i class="fas fa-tachometer-alt w-5 h-5 mr-4 {{ request()->routeIs('admin.super-admin.dashboard') ? 'text-white' : 'text-orange-300 group-hover:text-white' }}"></i>
            <span>Dashboard</span>
            @if(request()->routeIs('admin.super-admin.dashboard'))
                <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
            @endif
        </a>

        <!-- Panneau de Contrôle -->
        <a href="{{ route('admin.super-admin.control-panel') }}" 
           class="group flex items-center px-4 py-4 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.super-admin.control-panel') ? 'bg-white/20 text-white' : 'text-orange-200 hover:bg-white/10 hover:text-white' }}">
            <i class="fas fa-cogs w-5 h-5 mr-4 {{ request()->routeIs('admin.super-admin.control-panel') ? 'text-white' : 'text-orange-300 group-hover:text-white' }}"></i>
            <span>Contrôle</span>
            @if(request()->routeIs('admin.super-admin.control-panel'))
                <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
            @endif
        </a>

        <!-- Monitoring -->
        <a href="{{ route('admin.super-admin.monitoring') }}" 
           class="group flex items-center px-4 py-4 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.super-admin.monitoring') ? 'bg-white/20 text-white' : 'text-orange-200 hover:bg-white/10 hover:text-white' }}">
            <i class="fas fa-chart-line w-5 h-5 mr-4 {{ request()->routeIs('admin.super-admin.monitoring') ? 'text-white' : 'text-orange-300 group-hover:text-white' }}"></i>
            <span>Monitoring</span>
            @if(request()->routeIs('admin.super-admin.monitoring'))
                <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
            @endif
        </a>

        <!-- Séparateur -->
        <div class="my-6 border-t border-orange-500/20"></div>

        <!-- Gestion des Restaurants -->
        <div class="mb-4">
            <h3 class="px-4 text-xs font-semibold text-orange-300 uppercase tracking-wider mb-3">Gestion</h3>
            
            <a href="{{ route('admin.restaurants.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.restaurants*') ? 'bg-white/10 text-white' : 'text-orange-200 hover:bg-white/5 hover:text-white' }}">
                <i class="fas fa-store w-5 h-5 mr-3 {{ request()->routeIs('admin.restaurants*') ? 'text-white' : 'text-orange-300 group-hover:text-white' }}"></i>
                <span>Restaurants</span>
            </a>

            <a href="{{ route('admin.users.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.users*') ? 'bg-white/10 text-white' : 'text-orange-200 hover:bg-white/5 hover:text-white' }}">
                <i class="fas fa-users w-5 h-5 mr-3 {{ request()->routeIs('admin.users*') ? 'text-white' : 'text-orange-300 group-hover:text-white' }}"></i>
                <span>Utilisateurs</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.orders*') ? 'bg-white/10 text-white' : 'text-orange-200 hover:bg-white/5 hover:text-white' }}">
                <i class="fas fa-shopping-cart w-5 h-5 mr-3 {{ request()->routeIs('admin.orders*') ? 'text-white' : 'text-orange-300 group-hover:text-white' }}"></i>
                <span>Commandes</span>
            </a>

            <a href="{{ route('admin.withdrawals.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.withdrawals*') ? 'bg-white/10 text-white' : 'text-orange-200 hover:bg-white/5 hover:text-white' }}">
                <i class="fas fa-wallet w-5 h-5 mr-3 {{ request()->routeIs('admin.withdrawals*') ? 'text-white' : 'text-orange-300 group-hover:text-white' }}"></i>
                <span>Retraits</span>
            </a>
        </div>

        <!-- Analytics -->
        <div class="mb-4">
            <h3 class="px-4 text-xs font-semibold text-orange-300 uppercase tracking-wider mb-3">Analytics</h3>
            
            <a href="{{ route('admin.reports.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.reports*') ? 'bg-white/10 text-white' : 'text-orange-200 hover:bg-white/5 hover:text-white' }}">
                <i class="fas fa-chart-bar w-5 h-5 mr-3 {{ request()->routeIs('admin.reports*') ? 'text-white' : 'text-orange-300 group-hover:text-white' }}"></i>
                <span>Rapports</span>
            </a>

            <a href="{{ route('admin.analytics.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.analytics*') ? 'bg-white/10 text-white' : 'text-orange-200 hover:bg-white/5 hover:text-white' }}">
                <i class="fas fa-chart-pie w-5 h-5 mr-3 {{ request()->routeIs('admin.analytics*') ? 'text-white' : 'text-orange-300 group-hover:text-white' }}"></i>
                <span>Analytics</span>
            </a>
        </div>

        <!-- Système -->
        <div class="mb-4">
            <h3 class="px-4 text-xs font-semibold text-orange-300 uppercase tracking-wider mb-3">Système</h3>
            
            <a href="#" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 text-orange-200 hover:bg-white/5 hover:text-white">
                <i class="fas fa-database w-5 h-5 mr-3 text-orange-300 group-hover:text-white"></i>
                <span>Base de Données</span>
            </a>

            <a href="#" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 text-orange-200 hover:bg-white/5 hover:text-white">
                <i class="fas fa-server w-5 h-5 mr-3 text-orange-300 group-hover:text-white"></i>
                <span>Serveurs</span>
            </a>

            <a href="#" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 text-orange-200 hover:bg-white/5 hover:text-white">
                <i class="fas fa-shield-alt w-5 h-5 mr-3 text-orange-300 group-hover:text-white"></i>
                <span>Sécurité</span>
            </a>
        </div>
    </nav>

    <!-- Footer avec profil Super Admin -->
    <div class="border-t border-orange-500/20 p-4">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-crown text-orange-600 text-lg"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white font-semibold text-sm truncate">{{ auth()->user()->name }}</p>
                <p class="text-orange-200 text-xs">Super Administrateur</p>
            </div>
            <div class="relative">
                <button onclick="toggleSuperAdminMenu()" class="p-2 rounded-xl hover:bg-white/10 transition-colors duration-200">
                    <i class="fas fa-chevron-down text-orange-200 text-xs"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Overlay pour mobile -->
<div id="superAdminSidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="toggleSuperAdminSidebar()"></div>

<script>
function toggleSuperAdminSidebar() {
    const sidebar = document.getElementById('superAdminSidebar');
    const overlay = document.getElementById('superAdminSidebarOverlay');
    
    if (sidebar.classList.contains('-translate-x-full')) {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    } else {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }
}

function toggleSuperAdminMenu() {
    // Implémentation du menu Super Admin
    console.log('Toggle Super Admin menu');
}

// Fermer la sidebar sur mobile quand on clique sur un lien
document.addEventListener('DOMContentLoaded', function() {
    const sidebarLinks = document.querySelectorAll('#superAdminSidebar a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 1024) {
                toggleSuperAdminSidebar();
            }
        });
    });
});
</script>