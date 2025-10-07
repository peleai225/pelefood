<!-- Navigation principale -->
<div class="space-y-1">
    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}"
       class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.dashboard*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:text-foreground hover:bg-accent' }}">
        <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard*') ? 'text-primary' : 'text-muted-foreground group-hover:text-primary' }}"></i>
        Dashboard
    </a>

    <!-- Restaurants -->
    <a href="{{ route('admin.restaurants.index') }}" 
       class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.restaurants*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:text-foreground hover:bg-accent' }}">
        <i data-lucide="building-2" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.restaurants*') ? 'text-primary' : 'text-muted-foreground group-hover:text-primary' }}"></i>
        Restaurants
    </a>

    <!-- Utilisateurs -->
    <a href="{{ route('admin.users.index') }}" 
       class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.users*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:text-foreground hover:bg-accent' }}">
        <i data-lucide="users" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.users*') ? 'text-primary' : 'text-muted-foreground group-hover:text-primary' }}"></i>
        Utilisateurs
    </a>

    <!-- Commandes -->
    <a href="{{ route('admin.orders.index') }}" 
       class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.orders*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:text-foreground hover:bg-accent' }}">
        <i data-lucide="shopping-bag" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.orders*') ? 'text-primary' : 'text-muted-foreground group-hover:text-primary' }}"></i>
        Commandes
    </a>

    <!-- Produits -->
    <a href="{{ route('admin.products.index') }}" 
       class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.products*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:text-foreground hover:bg-accent' }}">
        <i data-lucide="package" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.products*') ? 'text-primary' : 'text-muted-foreground group-hover:text-primary' }}"></i>
        Produits
    </a>

    <!-- Avis -->
    <a href="{{ route('admin.reviews.index') }}" 
       class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.reviews*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:text-foreground hover:bg-accent' }}">
        <i data-lucide="star" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.reviews*') ? 'text-primary' : 'text-muted-foreground group-hover:text-primary' }}"></i>
        Avis
    </a>
</div>

<!-- Séparateur -->
<div class="my-6 border-t border-border"></div>

<!-- Section Paiements -->
<div class="space-y-1">
    <h3 class="px-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider">Paiements</h3>
    
    <a href="{{ route('admin.payments.index') }}" 
       class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.payments*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:text-foreground hover:bg-accent' }}">
        <i data-lucide="credit-card" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.payments*') ? 'text-primary' : 'text-muted-foreground group-hover:text-primary' }}"></i>
        Paiements
    </a>

    <a href="{{ route('admin.payment-gateways.index') }}" 
       class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.payment-gateways*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:text-foreground hover:bg-accent' }}">
        <i data-lucide="shield-check" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.payment-gateways*') ? 'text-primary' : 'text-muted-foreground group-hover:text-primary' }}"></i>
        Passerelles
    </a>

    <a href="{{ route('admin.payment-transactions.index') }}" 
       class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.payment-transactions*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:text-foreground hover:bg-accent' }}">
        <i data-lucide="receipt" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.payment-transactions*') ? 'text-primary' : 'text-muted-foreground group-hover:text-primary' }}"></i>
        Transactions
    </a>

    <a href="{{ route('admin.invoices.index') }}" 
       class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.invoices*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:text-foreground hover:bg-accent' }}">
        <i data-lucide="file-text" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.invoices*') ? 'text-primary' : 'text-muted-foreground group-hover:text-primary' }}"></i>
        Factures
    </a>
</div>

<!-- Séparateur -->
<div class="my-6 border-t border-border"></div>

<!-- Section Analytics -->
<div class="space-y-1">
    <h3 class="px-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider">Analytics</h3>
    
    <a href="{{ route('admin.analytics.index') }}" 
       class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.analytics*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:text-foreground hover:bg-accent' }}">
        <i data-lucide="bar-chart-3" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.analytics*') ? 'text-primary' : 'text-muted-foreground group-hover:text-primary' }}"></i>
        Analytics
    </a>

    <a href="{{ route('admin.reports.index') }}" 
       class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.reports*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:text-foreground hover:bg-accent' }}">
        <i data-lucide="file-bar-chart" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.reports*') ? 'text-primary' : 'text-muted-foreground group-hover:text-primary' }}"></i>
        Rapports
    </a>
</div>

<!-- Séparateur -->
<div class="my-6 border-t border-border"></div>

<!-- Section Contenu -->
<div class="space-y-1">
    <h3 class="px-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider">Contenu</h3>
    
    <a href="{{ route('admin.promotions.index') }}" 
       class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.promotions*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:text-foreground hover:bg-accent' }}">
        <i data-lucide="tag" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.promotions*') ? 'text-primary' : 'text-muted-foreground group-hover:text-primary' }}"></i>
        Promotions
    </a>

    <a href="{{ route('admin.notifications.index') }}" 
       class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.notifications*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:text-foreground hover:bg-accent' }}">
        <i data-lucide="bell" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.notifications*') ? 'text-primary' : 'text-muted-foreground group-hover:text-primary' }}"></i>
        Notifications
        @if(auth()->user()->unreadNotifications()->count() > 0)
            <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1 min-w-[20px] text-center">
                {{ auth()->user()->unreadNotifications()->count() }}
            </span>
        @endif
    </a>

    <a href="{{ route('admin.withdrawals.index') }}" 
       class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.withdrawals*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:text-foreground hover:bg-accent' }}">
        <i data-lucide="wallet" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.withdrawals*') ? 'text-primary' : 'text-muted-foreground group-hover:text-primary' }}"></i>
        Retraits
    </a>
</div>

<!-- Séparateur -->
<div class="my-6 border-t border-border"></div>

<!-- Section Système -->
<div class="space-y-1">
    <h3 class="px-3 text-xs font-semibold text-muted-foreground uppercase tracking-wider">Système</h3>
    
    <a href="{{ route('admin.subscription-plans.index') }}" 
       class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.subscription-plans*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:text-foreground hover:bg-accent' }}">
        <i data-lucide="package" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.subscription-plans*') ? 'text-primary' : 'text-muted-foreground group-hover:text-primary' }}"></i>
        Plans d'abonnement
    </a>

    <a href="{{ route('admin.tenants.index') }}" 
       class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.tenants*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:text-foreground hover:bg-accent' }}">
        <i data-lucide="building" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.tenants*') ? 'text-primary' : 'text-muted-foreground group-hover:text-primary' }}"></i>
        Tenants
    </a>

    <a href="{{ route('admin.settings.index') }}" 
       class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.settings*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:text-foreground hover:bg-accent' }}">
        <i data-lucide="settings" class="w-5 h-5 mr-3 {{ request()->routeIs('admin.settings*') ? 'text-primary' : 'text-muted-foreground group-hover:text-primary' }}"></i>
        Paramètres
    </a>
</div>