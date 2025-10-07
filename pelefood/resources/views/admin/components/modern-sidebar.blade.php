<!-- Sidebar moderne et interactive -->
<div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-2xl border-r border-slate-200 transform transition-transform duration-300 ease-in-out" id="sidebar">
    <!-- Logo et header -->
    <div class="flex items-center justify-between h-16 px-6 border-b border-slate-200">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-utensils text-white text-sm"></i>
            </div>
            <span class="text-xl font-bold text-slate-800">PeleFood</span>
        </div>
        <button onclick="toggleSidebar()" class="p-2 rounded-lg hover:bg-slate-100 transition-colors duration-200">
            <i class="fas fa-bars text-slate-600"></i>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
            <i class="fas fa-chart-line w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-slate-700' }}"></i>
            <span>Dashboard</span>
            @if(request()->routeIs('admin.dashboard'))
                <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>
            @endif
        </a>

        <!-- Commandes -->
        <a href="{{ route('admin.orders.index') }}" 
           class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.orders*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
            <i class="fas fa-shopping-cart w-5 h-5 mr-3 {{ request()->routeIs('admin.orders*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-700' }}"></i>
            <span>Commandes</span>
            @if(request()->routeIs('admin.orders*'))
                <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>
            @endif
        </a>

        <!-- Restaurants -->
        <a href="{{ route('admin.restaurants.index') }}" 
           class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.restaurants*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
            <i class="fas fa-store w-5 h-5 mr-3 {{ request()->routeIs('admin.restaurants*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-700' }}"></i>
            <span>Restaurants</span>
            @if(request()->routeIs('admin.restaurants*'))
                <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>
            @endif
        </a>

        <!-- Produits -->
        <a href="{{ route('admin.products.index') }}" 
           class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.products*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
            <i class="fas fa-box w-5 h-5 mr-3 {{ request()->routeIs('admin.products*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-700' }}"></i>
            <span>Produits</span>
            @if(request()->routeIs('admin.products*'))
                <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>
            @endif
        </a>

        <!-- Utilisateurs -->
        <a href="{{ route('admin.users.index') }}" 
           class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
            <i class="fas fa-users w-5 h-5 mr-3 {{ request()->routeIs('admin.users*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-700' }}"></i>
            <span>Utilisateurs</span>
            @if(request()->routeIs('admin.users*'))
                <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>
            @endif
        </a>

        <!-- Notifications -->
        <a href="{{ route('admin.notifications.index') }}" 
           class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.notifications*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
            <i class="fas fa-bell w-5 h-5 mr-3 {{ request()->routeIs('admin.notifications*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-700' }}"></i>
            <span>Notifications</span>
            @if(auth()->user()->unreadNotifications()->count() > 0)
                <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1 min-w-[20px] text-center animate-pulse">
                    {{ auth()->user()->unreadNotifications()->count() }}
                </span>
            @endif
            @if(request()->routeIs('admin.notifications*'))
                <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>
            @endif
        </a>

        <!-- Retraits -->
        <a href="{{ route('admin.withdrawals.index') }}" 
           class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.withdrawals*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
            <i class="fas fa-wallet w-5 h-5 mr-3 {{ request()->routeIs('admin.withdrawals*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-700' }}"></i>
            <span>Retraits</span>
            @if(request()->routeIs('admin.withdrawals*'))
                <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>
            @endif
        </a>

        <!-- Rapports -->
        <a href="{{ route('admin.reports.index') }}" 
           class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.reports*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
            <i class="fas fa-chart-bar w-5 h-5 mr-3 {{ request()->routeIs('admin.reports*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-700' }}"></i>
            <span>Rapports</span>
            @if(request()->routeIs('admin.reports*'))
                <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>
            @endif
        </a>

        <!-- Paramètres -->
        <a href="{{ route('admin.settings') }}" 
           class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.settings*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
            <i class="fas fa-cog w-5 h-5 mr-3 {{ request()->routeIs('admin.settings*') ? 'text-white' : 'text-slate-500 group-hover:text-slate-700' }}"></i>
            <span>Paramètres</span>
            @if(request()->routeIs('admin.settings*'))
                <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>
            @endif
        </a>
    </nav>

    <!-- Footer avec profil utilisateur -->
    <div class="border-t border-slate-200 p-4">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                <span class="text-white font-semibold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-slate-800 truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-500">Super Admin</p>
            </div>
            <div class="relative">
                <button onclick="toggleUserMenu()" class="p-2 rounded-lg hover:bg-slate-100 transition-colors duration-200">
                    <i class="fas fa-chevron-down text-slate-500 text-xs"></i>
                </button>
                <!-- Menu utilisateur (à implémenter) -->
            </div>
        </div>
    </div>
</div>

<!-- Overlay pour mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" onclick="toggleSidebar()"></div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    
    if (sidebar.classList.contains('-translate-x-full')) {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    } else {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }
}

function toggleUserMenu() {
    // Implémentation du menu utilisateur
    console.log('Toggle user menu');
}

// Fermer la sidebar sur mobile quand on clique sur un lien
document.addEventListener('DOMContentLoaded', function() {
    const sidebarLinks = document.querySelectorAll('#sidebar a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 1024) {
                toggleSidebar();
            }
        });
    });
});
</script>
