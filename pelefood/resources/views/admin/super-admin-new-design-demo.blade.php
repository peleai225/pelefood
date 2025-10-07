@extends('layouts.super-admin-new-design')

@section('title', 'Nouveau Design - SuperAdmin PeleFood')
@section('description', 'Découvrez le nouveau design inspiré des meilleures pratiques UI/UX')

@section('content')
<div class="space-y-8">
    <!-- En-tête de démonstration -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-8 border border-blue-200">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-palette text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Nouveau Design SuperAdmin</h1>
                <p class="text-gray-600 mt-2">Interface moderne inspirée des meilleures pratiques UI/UX</p>
            </div>
        </div>
    </div>

    <!-- Fonctionnalités du nouveau design -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Design & UX -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 card-hover">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-paint-brush text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Design & UX</h3>
                    <p class="text-gray-600">Interface moderne et intuitive</p>
                </div>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span class="text-gray-700">Sidebar hiérarchique avec dropdowns</span>
                </div>
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span class="text-gray-700">Header avec barre de recherche intégrée</span>
                </div>
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span class="text-gray-700">Cartes métriques avec icônes colorées</span>
                </div>
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span class="text-gray-700">Graphiques Chart.js intégrés</span>
                </div>
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span class="text-gray-700">Top restaurants avec avatars</span>
                </div>
            </div>
        </div>

        <!-- Navigation & Organisation -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 card-hover">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-sitemap text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Navigation</h3>
                    <p class="text-gray-600">Organisation logique et hiérarchique</p>
                </div>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span class="text-gray-700">Sections organisées par catégories</span>
                </div>
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span class="text-gray-700">Dropdowns pour sous-sections</span>
                </div>
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span class="text-gray-700">État actif visible et intuitif</span>
                </div>
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span class="text-gray-700">Footer avec version et copyright</span>
                </div>
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span class="text-gray-700">Responsive design mobile-first</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparaison avec l'ancien design -->
    <div class="bg-white rounded-xl p-8 border border-gray-200">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-balance-scale text-purple-600 text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Comparaison des Designs</h3>
                <p class="text-gray-600">Évolution de l'interface utilisateur</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Ancien Design -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-clock mr-2 text-gray-500"></i>
                    Ancien Design
                </h4>
                <div class="space-y-3">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-times-circle text-red-500"></i>
                        <span class="text-gray-700">Sidebar simple sans hiérarchie</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-times-circle text-red-500"></i>
                        <span class="text-gray-700">Pas de barre de recherche</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-times-circle text-red-500"></i>
                        <span class="text-gray-700">Métriques basiques</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-times-circle text-red-500"></i>
                        <span class="text-gray-700">Graphiques limités</span>
                    </div>
                </div>
            </div>

            <!-- Nouveau Design -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-star mr-2 text-yellow-500"></i>
                    Nouveau Design
                </h4>
                <div class="space-y-3">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-gray-700">Navigation hiérarchique organisée</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-gray-700">Recherche globale intégrée</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-gray-700">Métriques visuelles et colorées</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-gray-700">Graphiques interactifs avancés</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accès aux différentes versions -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-8 border border-blue-200">
        <div class="text-center mb-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Explorez les Différents Designs</h3>
            <p class="text-gray-600">Comparez et choisissez votre interface préférée</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Design Original -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 card-hover">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-desktop text-gray-600 text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Design Original</h4>
                    <p class="text-gray-600 text-sm mb-4">Interface classique et fonctionnelle</p>
                    <a href="{{ route('admin.super-admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg text-sm font-semibold hover:bg-gray-700 transition-colors">
                        <i class="fas fa-eye mr-2"></i>
                        Voir le Design
                    </a>
                </div>
            </div>

            <!-- Design Moderne -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 card-hover">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-rocket text-white text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Design Moderne</h4>
                    <p class="text-gray-600 text-sm mb-4">Interface avec animations et gradients</p>
                    <a href="{{ route('admin.super-admin.dashboard.modern') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg text-sm font-semibold hover:from-orange-600 hover:to-red-600 transition-all">
                        <i class="fas fa-magic mr-2"></i>
                        Voir le Design
                    </a>
                </div>
            </div>

            <!-- Nouveau Design -->
            <div class="bg-white rounded-xl p-6 border-2 border-blue-500 card-hover">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-crown text-white text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Nouveau Design</h4>
                    <p class="text-gray-600 text-sm mb-4">Interface professionnelle et organisée</p>
                    <a href="{{ route('admin.super-admin.dashboard.new-design') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors">
                        <i class="fas fa-star mr-2"></i>
                        Voir le Design
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
