@extends('layouts.super-admin-modern')

@section('title', 'Démonstration Super Admin Moderne - PeleFood')
@section('page-title', 'Démonstration Super Admin')
@section('page-description', 'Présentation des nouvelles fonctionnalités et du design moderne')

@section('content')
<div class="space-y-8">
    <!-- Header de démonstration -->
    <div class="bg-gradient-to-r from-white via-slate-50 to-white rounded-3xl shadow-2xl border border-slate-200/50 p-8 card-hover">
        <div class="flex items-center space-x-6">
            <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-3xl flex items-center justify-center shadow-2xl pulse-ring floating-card">
                <i class="fas fa-magic text-white text-3xl animate-bounce-in"></i>
            </div>
            <div>
                <h1 class="text-4xl font-bold text-slate-900 text-gradient">Super Admin Moderne</h1>
                <p class="text-slate-600 text-lg font-medium">Découvrez le nouveau design et les fonctionnalités améliorées</p>
                <div class="flex items-center space-x-4 mt-2">
                    <div class="flex items-center space-x-2 bg-green-50 border border-green-200 rounded-xl px-4 py-2">
                        <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                        <span class="text-green-800 text-sm font-bold">Nouveau Design Actif</span>
                    </div>
                    <div class="text-slate-500 text-sm">
                        Version: <span class="font-semibold text-orange-600">2.0 Modern</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nouvelles fonctionnalités -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Design Moderne -->
        <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-2xl border border-slate-200/50 p-8 card-hover">
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-palette text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 text-gradient">Design Moderne</h3>
                    <p class="text-slate-600">Interface repensée avec Shadcn UI</p>
                </div>
            </div>
            <div class="space-y-4">
                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-lg">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-slate-900 font-semibold">Gradients animés et effets de profondeur</span>
                    </div>
                </div>
                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-lg">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-slate-900 font-semibold">Animations fluides et transitions</span>
                    </div>
                </div>
                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-lg">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-slate-900 font-semibold">Composants Shadcn UI intégrés</span>
                    </div>
                </div>
                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-lg">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-slate-900 font-semibold">Mode sombre et responsive design</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ergonomie Améliorée -->
        <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-2xl border border-slate-200/50 p-8 card-hover">
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-mouse-pointer text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 text-gradient">Ergonomie Améliorée</h3>
                    <p class="text-slate-600">Navigation intuitive et interactions optimisées</p>
                </div>
            </div>
            <div class="space-y-4">
                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-lg">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-slate-900 font-semibold">Sidebar moderne avec animations</span>
                    </div>
                </div>
                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-lg">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-slate-900 font-semibold">Cartes interactives avec hover effects</span>
                    </div>
                </div>
                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-lg">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-slate-900 font-semibold">Onglets dynamiques et responsive</span>
                    </div>
                </div>
                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-lg">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-slate-900 font-semibold">Notifications en temps réel</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pages Modernisées -->
    <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-2xl border border-slate-200/50 p-8 card-hover">
        <div class="flex items-center space-x-4 mb-8">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg">
                <i class="fas fa-rocket text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-slate-900 text-gradient">Pages Modernisées</h3>
                <p class="text-slate-600">Découvrez les nouvelles versions des pages principales</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Dashboard -->
            <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-2xl p-6 border-2 border-orange-200 hover:shadow-xl transition-all duration-300 hover:scale-105">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-tachometer-alt text-white"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900">Dashboard</h4>
                </div>
                <p class="text-slate-600 text-sm mb-4">Métriques en temps réel avec graphiques interactifs</p>
                <a href="{{ route('admin.super-admin.dashboard.modern') }}" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white rounded-xl text-sm font-bold hover:bg-orange-600 transition-colors">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Voir le Dashboard
                </a>
            </div>

            <!-- Panneau de Contrôle -->
            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-6 border-2 border-blue-200 hover:shadow-xl transition-all duration-300 hover:scale-105">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-cogs text-white"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900">Contrôle</h4>
                </div>
                <p class="text-slate-600 text-sm mb-4">Gestion avancée avec onglets dynamiques</p>
                <a href="{{ route('admin.super-admin.control-panel.modern') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-xl text-sm font-bold hover:bg-blue-600 transition-colors">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Voir le Contrôle
                </a>
            </div>

            <!-- Monitoring -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border-2 border-green-200 hover:shadow-xl transition-all duration-300 hover:scale-105">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900">Monitoring</h4>
                </div>
                <p class="text-slate-600 text-sm mb-4">Surveillance temps réel avec logs interactifs</p>
                <a href="{{ route('admin.super-admin.monitoring.modern') }}" class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-xl text-sm font-bold hover:bg-green-600 transition-colors">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Voir le Monitoring
                </a>
            </div>
        </div>
    </div>

    <!-- Fonctionnalités Techniques -->
    <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-2xl border border-slate-200/50 p-8 card-hover">
        <div class="flex items-center space-x-4 mb-8">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg">
                <i class="fas fa-code text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-slate-900 text-gradient">Fonctionnalités Techniques</h3>
                <p class="text-slate-600">Améliorations techniques et performances</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center p-6 bg-white rounded-2xl border border-slate-200 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg mx-auto mb-4">
                    <i class="fas fa-bolt text-white text-2xl"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-900 mb-2">Performance</h4>
                <p class="text-slate-600 text-sm">Animations optimisées et chargement rapide</p>
            </div>

            <div class="text-center p-6 bg-white rounded-2xl border border-slate-200 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg mx-auto mb-4">
                    <i class="fas fa-mobile-alt text-white text-2xl"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-900 mb-2">Responsive</h4>
                <p class="text-slate-600 text-sm">Design adaptatif pour tous les écrans</p>
            </div>

            <div class="text-center p-6 bg-white rounded-2xl border border-slate-200 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center shadow-lg mx-auto mb-4">
                    <i class="fas fa-palette text-white text-2xl"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-900 mb-2">Shadcn UI</h4>
                <p class="text-slate-600 text-sm">Composants modernes et accessibles</p>
            </div>

            <div class="text-center p-6 bg-white rounded-2xl border border-slate-200 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg mx-auto mb-4">
                    <i class="fas fa-chart-bar text-white text-2xl"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-900 mb-2">Graphiques</h4>
                <p class="text-slate-600 text-sm">Chart.js intégré avec animations</p>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-3xl shadow-2xl p-8 text-white text-center">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-3xl font-bold mb-4">Prêt à explorer le nouveau Super Admin ?</h2>
            <p class="text-xl mb-8 opacity-90">Découvrez toutes les nouvelles fonctionnalités et le design moderne</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('admin.super-admin.dashboard.modern') }}" class="bg-white text-orange-600 px-8 py-4 rounded-2xl font-bold hover:bg-gray-100 transition-colors hover:scale-105">
                    <i class="fas fa-rocket mr-2"></i>
                    Commencer l'Exploration
                </a>
                <a href="{{ route('admin.super-admin.control-panel.modern') }}" class="bg-orange-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-orange-700 transition-colors hover:scale-105 border-2 border-white">
                    <i class="fas fa-cogs mr-2"></i>
                    Panneau de Contrôle
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
