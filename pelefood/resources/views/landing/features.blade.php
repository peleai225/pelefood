@extends('layouts.app')

@section('title', 'Fonctionnalités - PeleFood')

@section('content')
<!-- Hero Section Fonctionnalités -->
<div class="relative min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 overflow-hidden">
    <!-- Éléments de fond -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-32 h-32 bg-gradient-to-br from-orange-400 to-yellow-400 rounded-full opacity-20 animate-float"></div>
        <div class="absolute bottom-20 right-10 w-24 h-24 bg-gradient-to-br from-teal-400 to-green-400 rounded-full opacity-20 animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-gradient-to-br from-orange-300 to-red-300 rounded-full opacity-30 animate-pulse" style="animation-delay: 2s;"></div>
        <!-- Grille de fond -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="1"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-20">
        <div class="text-center space-y-16">
            <!-- Badge de statut -->
            <div class="animate-fade-in-up">
                <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500/20 to-yellow-500/20 border border-orange-400/30 rounded-full text-sm font-semibold text-orange-300 backdrop-blur-sm">
                    <div class="w-2 h-2 bg-orange-400 rounded-full mr-3 animate-pulse"></div>
                    Fonctionnalités Avancées
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="space-y-10 animate-fade-in-left">
                <h1 class="text-6xl lg:text-7xl font-black text-white leading-tight">
                    <span class="block">Tout ce dont vous avez</span>
                    <span class="bg-gradient-to-r from-orange-400 via-yellow-400 to-orange-500 bg-clip-text text-transparent">besoin</span>
                </h1>

                <p class="text-slate-100 max-w-4xl mx-auto leading-relaxed text-xl">
                    Plateforme SaaS complète avec des outils professionnels pour digitaliser et optimiser votre restaurant.
                    <span class="font-semibold text-orange-300">Commandes, paiements, analytics et bien plus encore.</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Section Fonctionnalités Principales -->
<section class="py-24 bg-gradient-to-br from-slate-50 via-orange-50 to-yellow-50 relative overflow-hidden">
    <!-- Éléments de fond -->
    <div class="absolute inset-0">
        <div class="absolute top-10 right-10 w-32 h-32 bg-gradient-to-br from-orange-400/20 to-yellow-400/20 rounded-full blur-xl"></div>
        <div class="absolute bottom-10 left-10 w-24 h-24 bg-gradient-to-br from-teal-400/20 to-green-400/20 rounded-full blur-xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-20">
            <div class="inline-flex items-center px-4 py-2 bg-orange-100 border border-orange-200 rounded-full text-sm font-semibold text-orange-700 mb-6">
                <div class="w-2 h-2 bg-orange-500 rounded-full mr-2 animate-pulse"></div>
                Fonctionnalités Principales
            </div>
            <h2 class="text-5xl font-black text-gray-900 mb-6">
                <span class="bg-gradient-to-r from-orange-600 via-yellow-600 to-orange-700 bg-clip-text text-transparent">
                    Gestion Complète
                </span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Toutes les fonctionnalités nécessaires pour gérer efficacement votre restaurant
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Commande en ligne -->
            <div class="group relative bg-white rounded-3xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4 border border-gray-100 hover:border-orange-200">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-yellow-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-orange-600 transition-colors duration-300">Commande en Ligne</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Acceptez les commandes 24h/24 avec un système intuitif et personnalisable.</p>
                    <ul class="text-sm text-gray-500 space-y-2">
                        <li class="flex items-center"><span class="w-2 h-2 bg-orange-400 rounded-full mr-2"></span>Interface mobile optimisée</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-orange-400 rounded-full mr-2"></span>Gestion des disponibilités</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-orange-400 rounded-full mr-2"></span>Notifications en temps réel</li>
                    </ul>
                </div>
            </div>
            
            <!-- Gestion des menus -->
            <div class="group relative bg-white rounded-3xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4 border border-gray-100 hover:border-teal-200">
                <div class="absolute inset-0 bg-gradient-to-br from-teal-500/5 to-green-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-green-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-teal-600 transition-colors duration-300">Gestion des Menus</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Créez et gérez vos menus facilement avec photos, descriptions et prix.</p>
                    <ul class="text-sm text-gray-500 space-y-2">
                        <li class="flex items-center"><span class="w-2 h-2 bg-teal-400 rounded-full mr-2"></span>Éditeur visuel intuitif</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-teal-400 rounded-full mr-2"></span>Gestion des catégories</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-teal-400 rounded-full mr-2"></span>Mise à jour en temps réel</li>
                    </ul>
                </div>
            </div>
            
            <!-- Paiements sécurisés -->
            <div class="group relative bg-white rounded-3xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4 border border-gray-100 hover:border-green-200">
                <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-emerald-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-green-600 transition-colors duration-300">Paiements Sécurisés</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Acceptez tous les moyens de paiement avec une sécurité de niveau bancaire.</p>
                    <ul class="text-sm text-gray-500 space-y-2">
                        <li class="flex items-center"><span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>Cartes bancaires</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>Paiements mobiles</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>Chiffrement SSL</li>
                    </ul>
                </div>
            </div>
            
            <!-- Analytics -->
            <div class="group relative bg-white rounded-3xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4 border border-gray-100 hover:border-orange-200">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-yellow-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-orange-600 transition-colors duration-300">Analytics en Temps Réel</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Suivez vos performances avec des rapports détaillés et des insights précieux.</p>
                    <ul class="text-sm text-gray-500 space-y-2">
                        <li class="flex items-center"><span class="w-2 h-2 bg-orange-400 rounded-full mr-2"></span>Tableaux de bord</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-orange-400 rounded-full mr-2"></span>Rapports détaillés</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-orange-400 rounded-full mr-2"></span>Export des données</li>
                    </ul>
                </div>
            </div>
            
            <!-- Gestion des clients -->
            <div class="group relative bg-white rounded-3xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4 border border-gray-100 hover:border-blue-200">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-slate-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-slate-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors duration-300">Gestion des Clients</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Fidélisez vos clients avec un système de points et de promotions personnalisées.</p>
                    <ul class="text-sm text-gray-500 space-y-2">
                        <li class="flex items-center"><span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>Base de données clients</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>Programme de fidélité</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>Campagnes marketing</li>
                    </ul>
                </div>
            </div>
            
            <!-- Support 24/7 -->
            <div class="group relative bg-white rounded-3xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4 border border-gray-100 hover:border-orange-200">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-yellow-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-orange-600 transition-colors duration-300">Support 24/7</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Une équipe dédiée disponible 24h/24 pour vous accompagner.</p>
                    <ul class="text-sm text-gray-500 space-y-2">
                        <li class="flex items-center"><span class="w-2 h-2 bg-orange-400 rounded-full mr-2"></span>Chat en direct</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-orange-400 rounded-full mr-2"></span>Formation personnalisée</li>
                        <li class="flex items-center"><span class="w-2 h-2 bg-orange-400 rounded-full mr-2"></span>Documentation complète</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section CTA -->
<section class="py-24 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 relative overflow-hidden">
    <!-- Éléments de fond -->
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-40 h-40 bg-gradient-to-br from-orange-400/20 to-yellow-400/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-gradient-to-br from-teal-400/20 to-green-400/20 rounded-full blur-3xl"></div>
        <!-- Grille de fond -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="1"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
    </div>
    
    <div class="max-w-6xl mx-auto text-center px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="animate-fade-in-up">
            <div class="inline-flex items-center px-6 py-3 bg-orange-500/20 border border-orange-400/30 rounded-full text-sm font-semibold text-orange-300 mb-8 backdrop-blur-sm">
                <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3 animate-pulse"></div>
                Prêt à commencer ?
            </div>
            
            <h2 class="text-6xl font-black text-white mb-8 leading-tight">
                <span class="bg-gradient-to-r from-orange-400 via-yellow-400 to-orange-500 bg-clip-text text-transparent">
                    Testez toutes ces fonctionnalités
                </span>
                <span class="block text-4xl font-light text-orange-200 mt-2">gratuitement</span>
            </h2>
            
            <p class="text-xl text-slate-100 mb-12 max-w-3xl mx-auto leading-relaxed">
                Découvrez comment PeleFood peut transformer votre restaurant en 14 jours d'essai gratuit
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a href="{{ route('register') }}" class="group relative bg-gradient-to-r from-orange-600 to-yellow-600 hover:from-orange-700 hover:to-yellow-700 text-white px-12 py-5 rounded-2xl font-bold text-xl transition-all duration-300 transform hover:scale-105 shadow-2xl hover:shadow-orange-500/25">
                    <span class="relative z-10 flex items-center">
                        Commencer l'essai gratuit
                        <svg class="w-6 h-6 ml-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-yellow-400 rounded-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                </a>
                
                <a href="{{ route('contact') }}" class="group border-2 border-orange-400/50 text-orange-300 hover:border-yellow-400 hover:text-yellow-300 px-12 py-5 rounded-2xl font-bold text-xl transition-all duration-300 hover:shadow-lg backdrop-blur-sm bg-white/5">
                    <span class="flex items-center">
                        Demander une démo
                        <svg class="w-6 h-6 ml-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection