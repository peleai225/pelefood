@extends('layouts.saas-modern')

@section('title', 'Dashboard - PeleFood SaaS')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-blue-600">
                        PeleFood SaaS
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                        </button>
                    </div>
                    
                    <div class="relative">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-sm h-screen sticky top-0">
            <div class="p-6">
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg bg-blue-50 text-blue-700">
                        <i data-lucide="home" class="w-5 h-5"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">
                        <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                        <span>Commandes</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                        <span>Menu</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">
                        <i data-lucide="users" class="w-5 h-5"></i>
                        <span>Clients</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">
                        <i data-lucide="bar-chart" class="w-5 h-5"></i>
                        <span>Analytics</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">
                        <i data-lucide="settings" class="w-5 h-5"></i>
                        <span>Paramètres</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    Bonjour, {{ auth()->user()->name }} !
                </h1>
                <p class="text-gray-600">
                    Voici un aperçu de votre restaurant aujourd'hui
                </p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Commandes du jour</p>
                                <p class="text-2xl font-bold text-gray-900">24</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="shopping-cart" class="w-6 h-6 text-blue-600"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-green-600 font-medium">+12%</span>
                            <span class="text-sm text-gray-500">vs hier</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Chiffre d'affaires</p>
                                <p class="text-2xl font-bold text-gray-900">1,247€</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="euro" class="w-6 h-6 text-green-600"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-green-600 font-medium">+8%</span>
                            <span class="text-sm text-gray-500">vs hier</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Nouveaux clients</p>
                                <p class="text-2xl font-bold text-gray-900">8</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="users" class="w-6 h-6 text-purple-600"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-green-600 font-medium">+3</span>
                            <span class="text-sm text-gray-500">vs hier</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Note moyenne</p>
                                <p class="text-2xl font-bold text-gray-900">4.8</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="star" class="w-6 h-6 text-yellow-600"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-green-600 font-medium">+0.2</span>
                            <span class="text-sm text-gray-500">vs hier</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Tables -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Revenue Chart -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Évolution du chiffre d'affaires</h3>
                    </div>
                    <div class="card-body">
                        <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                            <p class="text-gray-500">Graphique en cours de développement</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Commandes récentes</h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="user" class="w-5 h-5 text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Jean Dupont</p>
                                        <p class="text-sm text-gray-500">Commande #1234</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold">45.50€</p>
                                    <span class="badge badge-success">Livré</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="user" class="w-5 h-5 text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Marie Martin</p>
                                        <p class="text-sm text-gray-500">Commande #1235</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold">32.00€</p>
                                    <span class="badge badge-warning">En cours</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="user" class="w-5 h-5 text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Pierre Durand</p>
                                        <p class="text-sm text-gray-500">Commande #1236</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold">28.75€</p>
                                    <span class="badge badge-info">En préparation</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold">Actions rapides</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="#" class="flex items-center space-x-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="plus" class="w-5 h-5 text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium">Nouvelle commande</p>
                                <p class="text-sm text-gray-500">Créer une commande</p>
                            </div>
                        </a>

                        <a href="#" class="flex items-center space-x-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="menu" class="w-5 h-5 text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium">Modifier le menu</p>
                                <p class="text-sm text-gray-500">Gérer les plats</p>
                            </div>
                        </a>

                        <a href="#" class="flex items-center space-x-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="users" class="w-5 h-5 text-purple-600"></i>
                            </div>
                            <div>
                                <p class="font-medium">Gérer l'équipe</p>
                                <p class="text-sm text-gray-500">Ajouter des employés</p>
                            </div>
                        </a>

                        <a href="#" class="flex items-center space-x-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="bar-chart" class="w-5 h-5 text-orange-600"></i>
                            </div>
                            <div>
                                <p class="font-medium">Voir les rapports</p>
                                <p class="text-sm text-gray-500">Analytics détaillés</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Animation des cartes au chargement
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.3s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
@endpush
