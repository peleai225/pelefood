@extends('layouts.super-admin-new-design')

@section('title', 'Test Responsivité - PeleFood')
@section('page-title', 'Test Responsivité')

@section('content')
<div class="space-y-6">
    <!-- Header de test -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-mobile-alt text-white text-xl sm:text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Test Responsivité</h1>
                    <p class="text-gray-600 text-sm sm:text-base">Vérification du design sur tous les écrans</p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                <div class="flex items-center space-x-2 bg-green-50 border border-green-200 rounded-lg px-4 py-2">
                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-green-800 text-sm font-medium">Responsive</span>
                </div>
                <button class="bg-orange-500 text-white rounded-lg px-4 py-2 text-sm font-medium hover:bg-orange-600 transition-colors">
                    <i class="fas fa-check mr-2"></i>
                    Valider
                </button>
            </div>
        </div>
    </div>

    <!-- Test des grilles responsives -->
    <div class="space-y-6">
        <h2 class="text-xl font-bold text-gray-900">Test des Grilles Responsives</h2>
        
        <!-- Grille 1: Mobile First -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Grille Mobile First (1-2-4 colonnes)</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <div class="bg-orange-50 border border-orange-200 p-4 rounded-xl text-center">
                    <i class="fas fa-mobile-alt text-orange-500 text-2xl mb-2"></i>
                    <p class="text-gray-900 text-sm">Mobile</p>
                    <p class="text-gray-600 text-xs">1 colonne</p>
                </div>
                <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl text-center">
                    <i class="fas fa-tablet-alt text-blue-500 text-2xl mb-2"></i>
                    <p class="text-gray-900 text-sm">Tablet</p>
                    <p class="text-gray-600 text-xs">2 colonnes</p>
                </div>
                <div class="bg-green-50 border border-green-200 p-4 rounded-xl text-center">
                    <i class="fas fa-desktop text-green-500 text-2xl mb-2"></i>
                    <p class="text-gray-900 text-sm">Desktop</p>
                    <p class="text-gray-600 text-xs">4 colonnes</p>
                </div>
                <div class="bg-purple-50 border border-purple-200 p-4 rounded-xl text-center">
                    <i class="fas fa-tv text-purple-500 text-2xl mb-2"></i>
                    <p class="text-gray-900 text-sm">Large</p>
                    <p class="text-gray-600 text-xs">4 colonnes</p>
                </div>
            </div>
        </div>

        <!-- Test des cartes responsives -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Test des Cartes Responsives</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">
                <div class="bg-gray-50 border border-gray-200 p-6 rounded-xl hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                        <span class="text-green-600 text-sm font-medium">+12%</span>
                    </div>
                    <h4 class="text-gray-900 font-semibold mb-2">Revenus</h4>
                    <p class="text-2xl font-bold text-gray-900 mb-1">2.5M FCFA</p>
                    <p class="text-gray-600 text-sm">Ce mois</p>
                </div>

                <div class="bg-gray-50 border border-gray-200 p-6 rounded-xl hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                        <span class="text-green-600 text-sm font-medium">+8%</span>
                    </div>
                    <h4 class="text-gray-900 font-semibold mb-2">Utilisateurs</h4>
                    <p class="text-2xl font-bold text-gray-900 mb-1">1,234</p>
                    <p class="text-gray-600 text-sm">Actifs</p>
                </div>

                <div class="bg-gray-50 border border-gray-200 p-6 rounded-xl hover:shadow-md transition-shadow md:col-span-2 xl:col-span-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-shopping-cart text-white text-xl"></i>
                        </div>
                        <span class="text-orange-600 text-sm font-medium">+25%</span>
                    </div>
                    <h4 class="text-gray-900 font-semibold mb-2">Commandes</h4>
                    <p class="text-2xl font-bold text-gray-900 mb-1">456</p>
                    <p class="text-gray-600 text-sm">Aujourd'hui</p>
                </div>
            </div>
        </div>

        <!-- Test des boutons responsives -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Test des Boutons Responsives</h3>
            <div class="flex flex-col sm:flex-row gap-4">
                <button class="bg-orange-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-orange-600 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Bouton Principal
                </button>
                <button class="bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Bouton Secondaire
                </button>
                <button class="border border-red-300 text-red-600 px-6 py-3 rounded-lg font-medium hover:bg-red-50 transition-colors">
                    <i class="fas fa-trash mr-2"></i>
                    Bouton Danger
                </button>
            </div>
        </div>

        <!-- Test des formulaires responsives -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Test des Formulaires Responsives</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" placeholder="Votre nom">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" placeholder="votre@email.com">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection