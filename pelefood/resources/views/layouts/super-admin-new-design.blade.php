<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SuperAdmin - PeleFood')</title>
    <meta name="description" content="@yield('description', 'Plateforme de gestion PeleFood')">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js sera chargé à la fin du body -->
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Livewire Styles -->
    @livewireStyles
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            min-height: 100vh;
        }
        
        /* Sidebar moderne avec fond blanc */
        .sidebar-modern {
            background: #ffffff;
            border-right: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 2px 0 10px 0 rgba(0, 0, 0, 0.05);
        }
        
        /* Contenu principal avec fond blanc pur */
        .main-content {
            background: #ffffff;
            border-radius: 20px;
            margin: 20px;
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.1);
        }
        
        /* Header moderne */
        .header-modern {
            background: #ffffff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 1000;
        }
        
        /* Transitions fluides */
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .content-transition {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Navigation items avec effets modernes */
        .nav-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }
        
        .nav-item:hover::before {
            left: 100%;
        }
        
        .nav-item:hover {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            transform: translateX(5px);
            box-shadow: 0 4px 15px 0 rgba(231, 76, 60, 0.4);
        }
        
        .nav-item.active {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            box-shadow: 0 4px 15px 0 rgba(231, 76, 60, 0.4);
            transform: translateX(3px);
        }
        
        .nav-item.active:hover {
            transform: translateX(5px);
            box-shadow: 0 6px 20px 0 rgba(231, 76, 60, 0.6);
        }
        
        /* Dropdown avec animations fluides */
        .dropdown-content {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
            margin-top: 8px;
        }
        
        /* Cards modernes */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 60px 0 rgba(31, 38, 135, 0.5);
        }
        
        /* Métriques avec gradients */
        .metric-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .metric-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px 0 rgba(31, 38, 135, 0.5);
        }
        
        /* Charts avec effets modernes */
        .chart-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .chart-container:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px 0 rgba(31, 38, 135, 0.5);
        }
        
        /* Boutons modernes */
        .btn-modern {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px 0 rgba(231, 76, 60, 0.4);
        }
        
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px 0 rgba(231, 76, 60, 0.6);
        }
        
        /* Inputs modernes */
        .input-modern {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }
        
        .input-modern:focus {
            outline: none;
            border-color: #e74c3c;
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
            background: rgba(255, 255, 255, 1);
            transform: translateY(-1px);
        }
        
        /* Modals modernes */
        .modal-modern {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 60px 0 rgba(31, 38, 135, 0.5);
        }
        
        /* Badges et statuts */
        .badge-modern {
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 0.75rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }
        
        /* Animations d'entrée */
        @keyframes slideInFromLeft {
            0% {
                transform: translateX(-100%);
                opacity: 0;
            }
            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideInFromTop {
            0% {
                transform: translateY(-50px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
        
        .animate-slide-in-left {
            animation: slideInFromLeft 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .animate-slide-in-top {
            animation: slideInFromTop 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .animate-fade-in {
            animation: fadeIn 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Scrollbar personnalisée */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #d63031 0%, #a93226 100%);
        }
        
        /* Fix pour les dropdowns et notifications */
        .dropdown-fix {
            position: relative;
            z-index: 9999 !important;
        }
        
        .notification-dropdown {
            position: absolute;
            right: 0;
            top: 100%;
            z-index: 9999;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 10px 30px 0 rgba(0, 0, 0, 0.15);
        }
        
        .profile-dropdown {
            position: absolute;
            right: 0;
            top: 100%;
            z-index: 9999;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 10px 30px 0 rgba(0, 0, 0, 0.15);
        }
        
        /* Fix pour les boutons du header */
        .header-button {
            position: relative;
            z-index: 1001;
        }
        
        .header-button:hover {
            z-index: 1002;
        }

        /* Modal moderne */
        .modal-modern {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 80px 0 rgba(0, 0, 0, 0.15);
        }

        .modal-close-btn {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }

        .modal-close-btn:hover {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
            transform: scale(1.1);
            border-color: rgba(231, 76, 60, 0.3);
        }

        .modal-cancel-btn {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 12px 24px;
            color: #6b7280;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }

        .modal-cancel-btn:hover {
            background: rgba(0, 0, 0, 0.05);
            border-color: rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
            color: #374151;
        }

        /* Animation d'entrée pour les modals */
        .modal-modern {
            animation: modalSlideIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
    </style>
</head>
<body class="h-full">
    <div x-data="sidebarNavigation()" class="min-h-screen flex">
        
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-72 sidebar-modern sidebar-transition animate-slide-in-left"
             :class="{ '-translate-x-full': !sidebarOpen && !mobileSidebarOpen, 'translate-x-0': sidebarOpen || mobileSidebarOpen }">
            
            <!-- Logo et Header -->
            <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-red-500 to-red-700 rounded-lg flex items-center justify-center shadow-lg">
                        <i class="fas fa-crown text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">SuperAdmin</h1>
                        <p class="text-xs text-gray-500">PeleFood Platform</p>
                    </div>
                </div>
                
                <!-- Bouton fermer mobile -->
                <button @click="mobileSidebarOpen = false" class="lg:hidden text-gray-600 hover:text-gray-900">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                
                <!-- Tableau de bord -->
                <button @click="navigateTo('{{ route('admin.dashboard') }}', 'admin.dashboard')" 
                        class="nav-item flex items-center px-4 py-3 text-sm font-medium w-full text-left"
                        :class="isActiveRoute('admin.dashboard') ? 'active' : 'text-gray-700'">
                    <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                    <span>Tableau de bord</span>
                </button>

                <!-- Restaurants -->
                <div class="space-y-1">
                    <button @click="dropdowns.restaurants = !dropdowns.restaurants" 
                            class="nav-item flex items-center justify-between w-full px-4 py-3 text-sm font-medium"
                            :class="isActiveRouteGroup('admin.restaurants') || isActiveRouteGroup('admin.subscription-plans') ? 'active' : 'text-gray-700'">
                        <div class="flex items-center">
                            <i class="fas fa-store w-5 mr-3"></i>
                            <span>Restaurants</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" 
                           :class="{ 'rotate-180': dropdowns.restaurants }"></i>
                    </button>
                    
                    <div x-show="dropdowns.restaurants" class="dropdown-content ml-6 space-y-1">
                        <button @click="navigateTo('{{ route('admin.restaurants.new-design') }}', 'admin.restaurants.new-design')" 
                                class="nav-item flex items-center justify-between w-full px-4 py-2 text-sm hover:text-gray-900 text-left"
                                :class="isActiveRoute('admin.restaurants.new-design') ? 'text-red-600 font-medium' : 'text-gray-600'">
                            <div class="flex items-center">
                                <i class="fas fa-list w-4 mr-3"></i>
                                <span>Liste des restaurants</span>
                            </div>
                            <span class="badge-modern text-xs bg-blue-100 text-blue-800">{{ $globalStats['restaurants']['total'] ?? 0 }}</span>
                        </button>
                        <button @click="navigateTo('{{ route('admin.restaurants.index') }}', 'admin.restaurants.index')" 
                                class="nav-item flex items-center justify-between w-full px-4 py-2 text-sm hover:text-gray-900 text-left"
                                :class="isActiveRoute('admin.restaurants.index') ? 'text-red-600 font-medium' : 'text-gray-600'">
                            <div class="flex items-center">
                                <i class="fas fa-plus w-4 mr-3"></i>
                                <span>Ajouter un restaurant</span>
                            </div>
                            <span class="badge-modern text-xs bg-green-100 text-green-800">{{ $globalStats['restaurants']['active'] ?? 0 }} actifs</span>
                        </button>
                        <button @click="navigateTo('{{ route('admin.subscription-plans.index') }}', 'admin.subscription-plans.index')" 
                                class="nav-item flex items-center w-full px-4 py-2 text-sm hover:text-gray-900 text-left"
                                :class="isActiveRoute('admin.subscription-plans.index') ? 'text-red-600 font-medium' : 'text-gray-600'">
                            <i class="fas fa-credit-card w-4 mr-3"></i>
                            <span>Plans d'abonnement</span>
                        </button>
                    </div>
                </div>

                <!-- Commandes -->
                <div class="space-y-1">
                    <button @click="dropdowns.commandes = !dropdowns.commandes" 
                            class="nav-item flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-700">
                        <div class="flex items-center">
                            <i class="fas fa-shopping-cart w-5 mr-3"></i>
                            <span>Commandes</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" 
                           :class="{ 'rotate-180': dropdowns.commandes }"></i>
                    </button>
                    
                    <div x-show="dropdowns.commandes" class="dropdown-content ml-6 space-y-1">
                        <a href="{{ route('admin.orders.new-design') }}" 
                           class="nav-item flex items-center justify-between px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <div class="flex items-center">
                                <i class="fas fa-list w-4 mr-3"></i>
                                <span>Toutes les commandes</span>
                            </div>
                            <span class="badge-modern text-xs bg-blue-100 text-blue-800">{{ $globalStats['orders']['total'] ?? 0 }}</span>
                        </a>
                        <a href="{{ route('admin.orders.index') }}" 
                           class="nav-item flex items-center justify-between px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <div class="flex items-center">
                                <i class="fas fa-clock w-4 mr-3"></i>
                                <span>Commandes en attente</span>
                            </div>
                            <span class="badge-modern text-xs bg-yellow-100 text-yellow-800">{{ $globalStats['orders']['pending'] ?? 0 }}</span>
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="nav-item flex items-center justify-between px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt w-4 mr-3"></i>
                                <span>Suivi en temps réel</span>
                            </div>
                            <span class="badge-modern text-xs bg-green-100 text-green-800">{{ $globalStats['orders']['completed'] ?? 0 }} livrées</span>
                        </a>
                    </div>
                </div>

                <!-- Produits & Catalogue -->
                <div class="space-y-1">
                    <button @click="dropdowns.produits = !dropdowns.produits" 
                            class="nav-item flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-700">
                        <div class="flex items-center">
                            <i class="fas fa-box w-5 mr-3"></i>
                            <span>Produits & Catalogue</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" 
                           :class="{ 'rotate-180': dropdowns.produits }"></i>
                    </button>
                    
                    <div x-show="dropdowns.produits" class="dropdown-content ml-6 space-y-1">
                        <a href="{{ route('admin.products.index') }}" 
                           class="nav-item flex items-center justify-between px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <div class="flex items-center">
                                <i class="fas fa-utensils w-4 mr-3"></i>
                                <span>Gestion des produits</span>
                            </div>
                            <span class="badge-modern text-xs bg-blue-100 text-blue-800">{{ $globalStats['products']['total'] ?? 0 }}</span>
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="nav-item flex items-center justify-between px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <div class="flex items-center">
                                <i class="fas fa-tags w-4 mr-3"></i>
                                <span>Catégories</span>
                            </div>
                            <span class="badge-modern text-xs bg-purple-100 text-purple-800">{{ $globalStats['categories']['total'] ?? 0 }}</span>
                        </a>
                        <a href="{{ route('admin.promotions.index') }}" 
                           class="nav-item flex items-center justify-between px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <div class="flex items-center">
                                <i class="fas fa-percent w-4 mr-3"></i>
                                <span>Promotions</span>
                            </div>
                            <span class="badge-modern text-xs bg-orange-100 text-orange-800">{{ $globalStats['promotions']['active'] ?? 0 }}</span>
                        </a>
                    </div>
                </div>

                <!-- Finances & Paiements -->
                <div class="space-y-1">
                    <button @click="dropdowns.finances = !dropdowns.finances" 
                            class="nav-item flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-700">
                        <div class="flex items-center">
                            <i class="fas fa-chart-line w-5 mr-3"></i>
                            <span>Finances & Paiements</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" 
                           :class="{ 'rotate-180': dropdowns.finances }"></i>
                    </button>
                    
                    <div x-show="dropdowns.finances" class="dropdown-content ml-6 space-y-1">
                        <a href="{{ route('admin.payments.new-design') }}" class="nav-item flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-credit-card w-4 mr-3"></i>
                            <span>Transactions & Paiements</span>
                        </a>
                        <a href="{{ route('admin.withdrawals.index') }}" class="nav-item flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-money-bill-wave w-4 mr-3"></i>
                            <span>Demandes de retrait</span>
                        </a>
                        <a href="{{ route('admin.invoices.index') }}" class="nav-item flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-file-invoice w-4 mr-3"></i>
                            <span>Factures</span>
                        </a>
                        <a href="{{ route('admin.payment-gateways.index') }}" class="nav-item flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-cogs w-4 mr-3"></i>
                            <span>Passerelles de paiement</span>
                        </a>
                    </div>
                </div>

                <!-- Utilisateurs -->
                <div class="space-y-1">
                    <button @click="dropdowns.utilisateurs = !dropdowns.utilisateurs" 
                            class="nav-item flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-700">
                        <div class="flex items-center">
                            <i class="fas fa-users w-5 mr-3"></i>
                            <span>Utilisateurs</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" 
                           :class="{ 'rotate-180': dropdowns.utilisateurs }"></i>
                    </button>
                    
                    <div x-show="dropdowns.utilisateurs" class="dropdown-content ml-6 space-y-1">
                        <a href="{{ route('admin.users.new-design') }}" 
                           class="nav-item flex items-center justify-between px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <div class="flex items-center">
                                <i class="fas fa-user-shield w-4 mr-3"></i>
                                <span>Gestion des utilisateurs</span>
                            </div>
                            <span class="badge-modern text-xs bg-blue-100 text-blue-800">{{ $globalStats['users']['total'] ?? 0 }}</span>
                        </a>
                        <a href="{{ route('admin.users.create') }}" 
                           class="nav-item flex items-center justify-between px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <div class="flex items-center">
                                <i class="fas fa-user-plus w-4 mr-3"></i>
                                <span>Nouvel utilisateur</span>
                            </div>
                            <span class="badge-modern text-xs bg-green-100 text-green-800">{{ $globalStats['users']['active'] ?? 0 }} actifs</span>
                        </a>
                        <a href="{{ route('admin.tenants.index') }}" 
                           class="nav-item flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-building w-4 mr-3"></i>
                            <span>Tenants</span>
                        </a>
                    </div>
                </div>

                <!-- Analytics & Rapports -->
                <div class="space-y-1">
                    <button @click="dropdowns.analytics = !dropdowns.analytics" 
                            class="nav-item flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-700">
                        <div class="flex items-center">
                            <i class="fas fa-chart-bar w-5 mr-3"></i>
                            <span>Analytics & Rapports</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" 
                           :class="{ 'rotate-180': dropdowns.analytics }"></i>
                    </button>
                    
                    <div x-show="dropdowns.analytics" class="dropdown-content ml-6 space-y-1">
                        <a href="{{ route('admin.reports.new-design') }}" class="nav-item flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-chart-pie w-4 mr-3"></i>
                            <span>Rapports généraux</span>
                        </a>
                        <a href="{{ route('admin.analytics.index') }}" class="nav-item flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-analytics w-4 mr-3"></i>
                            <span>Analytics détaillés</span>
                        </a>
                        <a href="{{ route('admin.reports.orders') }}" class="nav-item flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-shopping-cart w-4 mr-3"></i>
                            <span>Rapport commandes</span>
                        </a>
                        <a href="{{ route('admin.reports.revenue') }}" class="nav-item flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-euro-sign w-4 mr-3"></i>
                            <span>Rapport revenus</span>
                        </a>
                    </div>
                </div>

                <!-- Contenu & Communication -->
                <div class="space-y-1">
                    <button @click="dropdowns.contenu = !dropdowns.contenu" 
                            class="nav-item flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-700">
                        <div class="flex items-center">
                            <i class="fas fa-comments w-5 mr-3"></i>
                            <span>Contenu & Communication</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" 
                           :class="{ 'rotate-180': dropdowns.contenu }"></i>
                    </button>
                    
                    <div x-show="dropdowns.contenu" class="dropdown-content ml-6 space-y-1">
                        <a href="{{ route('admin.reviews.index') }}" class="nav-item flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-star w-4 mr-3"></i>
                            <span>Avis & Reviews</span>
                        </a>
                        <a href="{{ route('admin.notifications.index') }}" class="nav-item flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bell w-4 mr-3"></i>
                            <span>Notifications</span>
                        </a>
                        <a href="{{ route('admin.messages.index') }}" class="nav-item flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-envelope w-4 mr-3"></i>
                            <span>Messages</span>
                        </a>
                        <button @click="navigateTo('{{ route('admin.send-notification.index') }}', 'admin.send-notification.index')" 
                                class="nav-item flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900 w-full text-left"
                                :class="isActiveRoute('admin.send-notification.index') ? 'active' : 'text-gray-700'">
                            <i class="fas fa-paper-plane w-4 mr-3"></i>
                            <span>Envoyer des Messages</span>
                        </button>
                    </div>
                </div>

                <!-- Vidéos & Médias -->
                <a href="{{ route('admin.videos.index') }}" 
                   class="nav-item flex items-center justify-between px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.videos*') ? 'active' : 'text-gray-700' }}">
                    <div class="flex items-center">
                        <i class="fas fa-video w-5 mr-3"></i>
                        <span>Vidéos & Médias</span>
                    </div>
                    <span class="badge-modern text-xs bg-purple-100 text-purple-800">{{ $globalStats['videos']['total'] ?? 0 }}</span>
                </a>

                <!-- Transactions -->
                <a href="{{ route('admin.payment-transactions.index') }}" 
                   class="nav-item flex items-center justify-between px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.payment-transactions*') ? 'active' : 'text-gray-700' }}">
                    <div class="flex items-center">
                        <i class="fas fa-exchange-alt w-5 mr-3"></i>
                        <span>Transactions</span>
                    </div>
                    <span class="badge-modern text-xs bg-green-100 text-green-800">{{ $globalStats['transactions']['total'] ?? 0 }}</span>
                </a>

                <!-- Marketing Digital -->
                <a href="{{ route('admin.marketing.index') }}" 
                   class="nav-item flex items-center justify-between px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.marketing*') ? 'active' : 'text-gray-700' }}">
                    <div class="flex items-center">
                        <i class="fas fa-bullhorn w-5 mr-3"></i>
                        <span>Marketing Digital</span>
                    </div>
                    <span class="badge-modern text-xs bg-purple-100 text-purple-800">{{ $marketingStats['active_campaigns'] ?? 0 }} actives</span>
                </a>

                <!-- Support -->
                <a href="{{ route('admin.support.index') }}" 
                   class="nav-item flex items-center justify-between px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.support*') ? 'active' : 'text-gray-700' }}">
                    <div class="flex items-center">
                        <i class="fas fa-headset w-5 mr-3"></i>
                        <span>Support</span>
                    </div>
                    <span class="badge-modern text-xs bg-red-100 text-red-800">{{ $globalStats['support']['open'] ?? 0 }} ouverts</span>
                </a>

                <!-- Système -->
                <div class="space-y-1">
                    <button @click="dropdowns.systeme = !dropdowns.systeme" 
                            class="nav-item flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-700">
                        <div class="flex items-center">
                            <i class="fas fa-cogs w-5 mr-3"></i>
                            <span>Système</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200" 
                           :class="{ 'rotate-180': dropdowns.systeme }"></i>
                    </button>
                    
                    <div x-show="dropdowns.systeme" class="dropdown-content ml-6 space-y-1">
                        <a href="{{ route('admin.settings.new-design') }}" class="nav-item flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-cog w-4 mr-3"></i>
                            <span>Paramètres</span>
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="nav-item flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-tools w-4 mr-3"></i>
                            <span>Configuration</span>
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="nav-item flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-database w-4 mr-3"></i>
                            <span>Sauvegardes</span>
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="nav-item flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-history w-4 mr-3"></i>
                            <span>Logs système</span>
                        </a>
                    </div>
                </div>
            </nav>
            
            <!-- Footer -->
            <div class="border-t border-gray-200 p-4">
                <div class="space-y-3">
                    <!-- Profil utilisateur -->
                    <div class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 transition-all duration-300">
                        <div class="w-8 h-8 rounded-full overflow-hidden bg-gradient-to-r from-red-500 to-red-700 flex items-center justify-center shadow-lg">
                            @if(auth()->user()->avatar)
                                <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Photo de profil" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-full h-full bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center" style="display: none;">
                                    <span class="text-white text-sm font-bold">{{ substr(auth()->user()->name, 0, 2) }}</span>
                                </div>
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('admin.profile.show') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-cog w-4 h-4"></i>
                        </a>
                    </div>
                    
                    <!-- Informations système -->
                    <div class="text-xs text-gray-500 space-y-1">
                        <p class="font-semibold">SuperAdmin Dashboard v2.0</p>
                        <p>© 2024 PeleFood Platform</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="flex-1 content-transition" :class="{ 'lg:ml-72': sidebarOpen }">
            
            <!-- Header -->
            <header class="header-modern h-16 flex items-center justify-between px-6 animate-slide-in-top">
                
                <!-- Bouton menu mobile -->
                <button @click="mobileSidebarOpen = true" class="lg:hidden text-gray-600 hover:text-gray-900">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <!-- Bouton toggle sidebar desktop -->
                <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block text-gray-600 hover:text-gray-900">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Barre de recherche -->
                <div class="flex-1 max-w-md mx-8">
                    <div class="relative">
                        <input type="text" 
                               placeholder="Rechercher restaurants, commandes..." 
                               class="input-modern w-full pl-10 pr-4 py-2">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <!-- Actions du header -->
                <div class="flex items-center space-x-4">
                    
                    <!-- Notifications (Livewire) -->
                    @livewire('admin.navbar-notifications')

                    <!-- Paramètres -->
                    <a href="{{ route('admin.settings.new-design') }}" class="header-button text-gray-600 hover:text-gray-900">
                        <i class="fas fa-cog text-xl"></i>
                    </a>

                    <!-- Profil utilisateur -->
                    <div class="relative dropdown-fix" x-data="{ open: false }">
                        <button @click="open = !open" class="header-button flex items-center space-x-3 text-gray-700 hover:text-gray-900">
                            <div class="w-10 h-10 rounded-full overflow-hidden bg-gradient-to-r from-red-500 to-red-700 flex items-center justify-center shadow-lg">
                                @if(auth()->user()->avatar)
                                    <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Photo de profil" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="w-full h-full bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center" style="display: none;">
                                        <span class="text-white text-sm font-bold">{{ substr(auth()->user()->name, 0, 2) }}</span>
                                    </div>
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center">
                                        <span class="text-white text-sm font-bold">{{ substr(auth()->user()->name, 0, 2) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" 
                             class="profile-dropdown mt-2 w-48"
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
                                <a href="{{ route('admin.profile.show') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                    <i class="fas fa-user mr-3"></i>
                                    Mon Profil
                                </a>
                                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                    <i class="fas fa-cog mr-3"></i>
                                    Paramètres
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
            </header>

            <!-- Contenu de la page -->
            <main class="main-content p-6 animate-fade-in">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>

        <!-- Overlay mobile -->
        <div x-show="mobileSidebarOpen" @click="mobileSidebarOpen = false" 
             class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"></div>
    </div>

    @stack('scripts')
    
    <!-- Alpine.js pour l'interactivité (AVANT Livewire) -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Script de navigation sidebar -->
    <script>
        function sidebarNavigation() {
            return {
                sidebarOpen: true, 
                mobileSidebarOpen: false,
                currentRoute: '{{ request()->route()->getName() ?? 'admin.dashboard' }}',
                dropdowns: {
                    restaurants: false,
                    commandes: false,
                    produits: false,
                    finances: false,
                    utilisateurs: false,
                    analytics: false,
                    contenu: false,
                    systeme: false
                },
                navigateTo(url, routeName) {
                    // Mettre à jour la route actuelle
                    this.currentRoute = routeName;
                    
                    // Ajouter un indicateur de chargement
                    const loadingIndicator = document.createElement('div');
                    loadingIndicator.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300';
                    loadingIndicator.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Chargement...';
                    document.body.appendChild(loadingIndicator);
                    
                    // Fermer les dropdowns sur mobile après navigation
                    if (window.innerWidth < 1024) {
                        this.mobileSidebarOpen = false;
                    }
                    
                    // Navigation
                    setTimeout(() => {
                        window.location.href = url;
                    }, 100);
                },
                isActiveRoute(routeName) {
                    return this.currentRoute === routeName;
                },
                isActiveRouteGroup(routeGroup) {
                    return this.currentRoute.startsWith(routeGroup);
                },
                init() {
                    // Ouvrir automatiquement les dropdowns selon la route active
                    if (this.isActiveRouteGroup('admin.restaurants') || this.isActiveRouteGroup('admin.subscription-plans')) {
                        this.dropdowns.restaurants = true;
                    }
                    if (this.isActiveRouteGroup('admin.orders')) {
                        this.dropdowns.commandes = true;
                    }
                    if (this.isActiveRouteGroup('admin.products') || this.isActiveRouteGroup('admin.categories') || this.isActiveRouteGroup('admin.promotions')) {
                        this.dropdowns.produits = true;
                    }
                    if (this.isActiveRouteGroup('admin.payments') || this.isActiveRouteGroup('admin.withdrawals') || this.isActiveRouteGroup('admin.invoices') || this.isActiveRouteGroup('admin.payment-gateways')) {
                        this.dropdowns.finances = true;
                    }
                    if (this.isActiveRouteGroup('admin.users') || this.isActiveRouteGroup('admin.tenants')) {
                        this.dropdowns.utilisateurs = true;
                    }
                    if (this.isActiveRouteGroup('admin.analytics') || this.isActiveRouteGroup('admin.reports')) {
                        this.dropdowns.analytics = true;
                    }
                    if (this.isActiveRouteGroup('admin.reviews') || this.isActiveRouteGroup('admin.notifications') || this.isActiveRouteGroup('admin.messages') || this.isActiveRouteGroup('admin.send-notification')) {
                        this.dropdowns.contenu = true;
                    }
                    if (this.isActiveRouteGroup('admin.settings')) {
                        this.dropdowns.systeme = true;
                    }
                }
            }
        }
    </script>

    <!-- Script de mise à jour automatique des notifications -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mettre à jour les notifications toutes les 30 secondes
            setInterval(function() {
                Livewire.emit('refreshNotifications');
            }, 30000);

            // Écouter les événements de notification
            Livewire.on('notificationReceived', () => {
                // Jouer un son de notification (optionnel)
                // new Audio('/sounds/notification.mp3').play().catch(() => {});
                
                // Afficher une notification toast (optionnel)
                // toastr.success('Nouvelle notification reçue !');
            });

            // Fermer le dropdown des notifications après marquage
            Livewire.on('closeDropdown', () => {
                // Fermer tous les dropdowns de notifications
                document.querySelectorAll('[x-data*="open"]').forEach(dropdown => {
                    if (dropdown.querySelector('.notification-dropdown')) {
                        dropdown._x_dataStack[0].open = false;
                    }
                });
            });

            // Écouter les mises à jour des notifications
            Livewire.on('notificationsUpdated', () => {
                console.log('Notifications mises à jour');
            });
        });
    </script>
</body>
</html>
