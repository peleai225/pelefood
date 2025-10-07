@extends('layouts.app')

@section('title', 'PeleFood - Plateforme SaaS Fintech pour Restaurants')
@section('description', 'Plateforme SaaS moderne et professionnelle pour la gestion complète de votre restaurant. Commandes, paiements, analytics et plus encore.')

@section('content')
<!-- Hero Section Restaurant SaaS -->
<div class="relative min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 overflow-hidden">
    <!-- Éléments de fond restaurant -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-32 h-32 bg-gradient-to-br from-orange-400 to-yellow-400 rounded-full opacity-20 animate-float"></div>
        <div class="absolute bottom-20 right-10 w-24 h-24 bg-gradient-to-br from-teal-400 to-green-400 rounded-full opacity-20 animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-gradient-to-br from-orange-300 to-red-300 rounded-full opacity-30 animate-pulse" style="animation-delay: 2s;"></div>
        <!-- Grille de fond fintech -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="1"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-20">
        <div class="text-center space-y-16">
            <!-- Badge de statut -->
            <div class="animate-fade-in-up">
                <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500/20 to-yellow-500/20 border border-orange-400/30 rounded-full text-sm font-semibold text-orange-300 backdrop-blur-sm">
                    <div class="w-2 h-2 bg-orange-400 rounded-full mr-3 animate-pulse"></div>
                    Plateforme SaaS pour Restaurants
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="space-y-10 animate-fade-in-left">
                <h1 class="text-7xl lg:text-8xl font-black text-white leading-tight">
                    <span class="block">Gérez votre</span>
                    <span class="bg-gradient-to-r from-orange-400 via-yellow-400 to-orange-500 bg-clip-text text-transparent">restaurant</span>
                    <span class="block text-5xl lg:text-6xl font-light text-orange-200 mt-4">intelligemment</span>
                </h1>
                
                <p class="text-2xl text-slate-100 max-w-4xl mx-auto leading-relaxed">
                    Plateforme SaaS moderne et professionnelle pour la gestion complète de votre restaurant. 
                    <span class="font-semibold text-orange-300">Commandes, paiements, analytics et bien plus encore.</span>
                </p>
                
                <!-- Boutons d'action Restaurant -->
                <div class="flex flex-col sm:flex-row gap-8 justify-center items-center pt-4">
                    <a href="{{ route('register') }}" 
                       class="group relative btn-restaurant-primary text-white px-12 py-5 rounded-2xl font-bold text-xl transition-all duration-300 transform hover:scale-105 shadow-2xl hover:shadow-colored">
                        <span class="relative z-10 flex items-center">
                            Commencer gratuitement
                            <svg class="w-6 h-6 ml-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-yellow-400 rounded-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="group border-2 border-orange-400/50 text-orange-300 hover:border-yellow-400 hover:text-yellow-300 px-12 py-5 rounded-2xl font-bold text-xl transition-all duration-300 hover:shadow-lg backdrop-blur-sm bg-white/5">
                        <span class="flex items-center">
                            Demander une démo
                            <svg class="w-6 h-6 ml-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
            
            <!-- Statistiques Fintech -->
            <div class="animate-fade-in-up">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 max-w-4xl mx-auto">
                    <div class="text-center group">
                        <div class="relative">
                            <div class="text-6xl font-black text-orange-400 mb-3 group-hover:scale-110 transition-transform duration-300">500+</div>
                            <div class="absolute -top-2 -right-2 w-4 h-4 bg-gradient-to-r from-orange-400 to-yellow-400 rounded-full animate-pulse"></div>
                        </div>
                        <div class="text-lg text-slate-200 font-medium">Restaurants actifs</div>
                    </div>
                    <div class="text-center group">
                        <div class="relative">
                            <div class="text-6xl font-black text-yellow-400 mb-3 group-hover:scale-110 transition-transform duration-300">50K+</div>
                            <div class="absolute -top-2 -right-2 w-4 h-4 bg-gradient-to-r from-orange-400 to-yellow-400 rounded-full animate-pulse" style="animation-delay: 0.5s;"></div>
                        </div>
                        <div class="text-lg text-slate-200 font-medium">Commandes traitées</div>
                    </div>
                    <div class="text-center group">
                        <div class="relative">
                            <div class="text-6xl font-black text-teal-400 mb-3 group-hover:scale-110 transition-transform duration-300">98%</div>
                            <div class="absolute -top-2 -right-2 w-4 h-4 bg-gradient-to-r from-teal-400 to-green-400 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
                        </div>
                        <div class="text-lg text-slate-200 font-medium">Satisfaction client</div>
                    </div>
                </div>
            </div>
            
            <!-- Cadre Vidéo -->
            @php
                $featuredVideo = \App\Models\Video::where('is_active', true)->where('is_featured', true)->orderBy('created_at', 'desc')->first();
            @endphp
            
            @if($featuredVideo)
            <div class="relative animate-fade-in-up">
                <div class="relative max-w-6xl mx-auto">
                    <div class="relative bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl rounded-3xl p-8 shadow-2xl border border-white/20 overflow-hidden">
                        <!-- Effet de brillance -->
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-500/20 via-yellow-500/20 to-orange-500/20 rounded-3xl opacity-0 hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <!-- Contenu du cadre vidéo -->
                        <div class="relative z-10">
                            <!-- Header de la vidéo -->
                            <div class="text-center mb-8">
                                <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-3xl font-bold text-white mb-4">{{ $featuredVideo->title }}</h3>
                                <p class="text-xl text-slate-100 max-w-2xl mx-auto leading-relaxed">{{ $featuredVideo->description ?? 'Regardez notre vidéo de démonstration pour voir comment PeleFood peut transformer votre restaurant' }}</p>
                            </div>
                            
                            <!-- Vidéo -->
                            <div class="relative bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl overflow-hidden shadow-2xl">
                                @if($featuredVideo->video_url)
                                    @if($featuredVideo->isYouTube())
                                        <!-- YouTube Embed -->
                                        <div class="relative h-96">
                                            <iframe 
                                                class="w-full h-full rounded-2xl"
                                                src="{{ $featuredVideo->getYouTubeEmbedUrl() }}"
                                                frameborder="0" 
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    @elseif($featuredVideo->isVimeo())
                                        <!-- Vimeo Embed -->
                                        <div class="relative h-96">
                                            <iframe 
                                                class="w-full h-full rounded-2xl"
                                                src="https://player.vimeo.com/video/{{ $featuredVideo->getVimeoId() }}?autoplay=0&title=0&byline=0&portrait=0"
                                                frameborder="0" 
                                                allow="autoplay; fullscreen; picture-in-picture" 
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    @else
                                        <!-- URL générique -->
                                        <div class="relative h-96 bg-gradient-to-br from-slate-900/50 to-slate-800/50 flex items-center justify-center">
                                            <a href="{{ $featuredVideo->video_url }}" target="_blank" 
                                               class="group relative w-24 h-24 bg-gradient-to-r from-orange-600 to-yellow-600 hover:from-orange-700 hover:to-yellow-700 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110 shadow-2xl hover:shadow-orange-500/25 z-10">
                                                <svg class="w-10 h-10 text-white ml-1 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                @elseif($featuredVideo->video_file)
                                    <!-- Fichier vidéo local -->
                                    <div class="relative h-96">
                                        <video 
                                            class="w-full h-full rounded-2xl object-cover" 
                                            controls 
                                            poster="{{ $featuredVideo->thumbnail ? Storage::url($featuredVideo->thumbnail) : '' }}">
                                            <source src="{{ Storage::url($featuredVideo->video_file) }}" type="video/mp4">
                                            Votre navigateur ne supporte pas la lecture vidéo.
                                        </video>
                                    </div>
                                @else
                                    <!-- Placeholder par défaut -->
                                    <div class="relative h-96 bg-gradient-to-br from-slate-900/50 to-slate-800/50 flex items-center justify-center">
                                        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Crect x="10" y="10" width="80" height="60" rx="8"/%3E%3Crect x="20" y="20" width="60" height="8" rx="4" fill-opacity="0.2"/%3E%3Crect x="20" y="35" width="40" height="6" rx="3" fill-opacity="0.15"/%3E%3Crect x="20" y="45" width="50" height="6" rx="3" fill-opacity="0.15"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
                                        <button class="group relative w-24 h-24 bg-gradient-to-r from-orange-600 to-yellow-600 hover:from-orange-700 hover:to-yellow-700 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110 shadow-2xl hover:shadow-orange-500/25 z-10">
                                            <svg class="w-10 h-10 text-white ml-1 group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Informations sous la vidéo -->
                            <div class="mt-6 text-center">
                                <div class="flex items-center justify-center space-x-6 text-slate-300">
                                    @if($featuredVideo->formatted_duration)
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">{{ $featuredVideo->formatted_duration }}</span>
                                    </div>
                                    @endif
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">{{ $featuredVideo->quality }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">{{ ucfirst($featuredVideo->language) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Éléments décoratifs -->
                        <div class="absolute -top-6 -right-6 w-12 h-12 bg-gradient-to-br from-orange-400 to-yellow-400 rounded-full opacity-60 animate-pulse"></div>
                        <div class="absolute -bottom-6 -left-6 w-8 h-8 bg-gradient-to-br from-teal-400 to-green-400 rounded-full opacity-60 animate-pulse" style="animation-delay: 1s;"></div>
                        <div class="absolute top-1/2 -left-8 w-6 h-6 bg-gradient-to-br from-orange-400 to-yellow-400 rounded-full opacity-40 animate-pulse" style="animation-delay: 2s;"></div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Section Fonctionnalités Restaurant -->
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
                Fonctionnalités Avancées
            </div>
            <h2 class="text-5xl font-black text-gray-900 mb-6">
                <span class="bg-gradient-to-r from-orange-600 via-yellow-600 to-orange-700 bg-clip-text text-transparent">
                    Tout ce dont vous avez besoin
                </span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Plateforme SaaS complète avec des outils professionnels pour digitaliser et optimiser votre restaurant
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
                    <p class="text-gray-600 leading-relaxed">Acceptez les commandes 24h/24 avec un système intuitif et personnalisable.</p>
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
                    <p class="text-gray-600 leading-relaxed">Créez et gérez vos menus facilement avec photos, descriptions et prix.</p>
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
                    <p class="text-gray-600 leading-relaxed">Acceptez tous les moyens de paiement avec une sécurité de niveau bancaire.</p>
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
                    <p class="text-gray-600 leading-relaxed">Suivez vos performances avec des rapports détaillés et des insights précieux.</p>
                </div>
            </div>
            
            <!-- Gestion des clients -->
            <div class="group relative bg-white rounded-3xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4 border border-gray-100 hover:border-orange-200">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-yellow-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-orange-600 transition-colors duration-300">Gestion des Clients</h3>
                    <p class="text-gray-600 leading-relaxed">Fidélisez vos clients avec un système de points et de promotions personnalisées.</p>
                </div>
            </div>
            
            <!-- Support 24/7 -->
            <div class="group relative bg-white rounded-3xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4 border border-gray-100 hover:border-orange-200">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-red-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-orange-600 transition-colors duration-300">Support 24/7</h3>
                    <p class="text-gray-600 leading-relaxed">Une équipe dédiée disponible 24h/24 pour vous accompagner.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Avantages Restaurant -->
<section class="py-24 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 relative overflow-hidden">
    <!-- Éléments de fond -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-20 w-40 h-40 bg-gradient-to-br from-orange-400/20 to-yellow-400/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-20 w-32 h-32 bg-gradient-to-br from-teal-400/20 to-green-400/20 rounded-full blur-3xl"></div>
        <!-- Grille de fond -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.03"%3E%3Ccircle cx="30" cy="30" r="1"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="animate-fade-in-left">
                <div class="inline-flex items-center px-4 py-2 bg-orange-500/20 border border-orange-400/30 rounded-full text-sm font-semibold text-orange-300 mb-6 backdrop-blur-sm">
                    <div class="w-2 h-2 bg-yellow-400 rounded-full mr-2 animate-pulse"></div>
                    Pourquoi nous choisir
                </div>
                <h2 class="text-5xl font-black text-white mb-8">
                    <span class="bg-gradient-to-r from-orange-400 via-yellow-400 to-orange-500 bg-clip-text text-transparent">
                        Excellence technologique
                    </span>
                </h2>
                <div class="space-y-8">
                    <div class="group flex items-start space-x-6 p-6 bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10 hover:bg-white/10 transition-all duration-300">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white mb-2 group-hover:text-orange-300 transition-colors duration-300">Interface intuitive</h3>
                            <p class="text-slate-100 leading-relaxed">Design moderne et ergonomique qui ne nécessite aucune formation technique.</p>
                        </div>
                    </div>
                    
                    <div class="group flex items-start space-x-6 p-6 bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10 hover:bg-white/10 transition-all duration-300">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white mb-2 group-hover:text-green-300 transition-colors duration-300">Sécurité maximale</h3>
                            <p class="text-slate-100 leading-relaxed">Infrastructure cloud robuste avec chiffrement de niveau bancaire et sauvegarde automatique.</p>
                        </div>
                    </div>
                    
                    <div class="group flex items-start space-x-6 p-6 bg-white/5 backdrop-blur-sm rounded-2xl border border-white/10 hover:bg-white/10 transition-all duration-300">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white mb-2 group-hover:text-orange-300 transition-colors duration-300">Innovation continue</h3>
                            <p class="text-slate-100 leading-relaxed">Technologies de pointe et mises à jour régulières pour rester à la pointe de l'innovation.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="relative animate-fade-in-right">
                <div class="relative bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl rounded-3xl p-10 shadow-2xl border border-white/20">
                    <!-- Effet de brillance -->
                    <div class="absolute inset-0 bg-gradient-to-r from-orange-500/20 via-yellow-500/20 to-orange-500/20 rounded-3xl opacity-0 hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="relative z-10 text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black text-white mb-4">Prêt à commencer ?</h3>
                        <p class="text-slate-100 mb-8 text-lg leading-relaxed">Rejoignez des centaines de restaurants qui ont déjà digitalisé leur activité avec succès.</p>
                        <a href="{{ route('register') }}" class="group relative inline-flex items-center bg-gradient-to-r from-orange-600 to-yellow-600 hover:from-orange-700 hover:to-yellow-700 text-white px-10 py-4 rounded-2xl font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-2xl hover:shadow-orange-500/25">
                            <span class="relative z-10">Créer mon compte</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-yellow-400 rounded-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        </a>
                    </div>
                </div>
                
                <!-- Éléments décoratifs -->
                <div class="absolute -top-4 -right-4 w-8 h-8 bg-gradient-to-br from-orange-400 to-yellow-400 rounded-full opacity-60 animate-pulse"></div>
                <div class="absolute -bottom-4 -left-4 w-6 h-6 bg-gradient-to-br from-teal-400 to-green-400 rounded-full opacity-60 animate-pulse" style="animation-delay: 1s;"></div>
            </div>
        </div>
    </div>
</section>

<!-- Section Restaurants Populaires -->
<section class="py-24 bg-gradient-to-br from-slate-50 to-slate-100 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-5xl font-black text-slate-800 mb-6">Restaurants Populaires</h2>
            <p class="text-xl text-slate-600 max-w-3xl mx-auto">Découvrez les restaurants les mieux notés de notre plateforme</p>
        </div>
        
        @if($featuredRestaurants->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredRestaurants as $restaurant)
            <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden group">
                <div class="relative h-48 bg-gradient-to-br from-orange-400 to-red-400">
                    @if($restaurant['cover_image_url'])
                        <img src="{{ $restaurant['cover_image_url'] }}" alt="{{ $restaurant['name'] }}" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm rounded-full px-3 py-1 text-sm font-semibold text-orange-600">
                        ⭐ {{ $restaurant['average_rating'] }}
                    </div>
                    @if($restaurant['is_open'])
                    <div class="absolute top-4 left-4 bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                        Ouvert
                    </div>
                    @else
                    <div class="absolute top-4 left-4 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                        Fermé
                    </div>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-slate-800 mb-2 group-hover:text-orange-600 transition-colors">{{ $restaurant['name'] }}</h3>
                    <p class="text-slate-600 mb-4">{{ Str::limit($restaurant['description'], 80) }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-500">📍 {{ $restaurant['city'] }}</span>
                        <span class="text-orange-600 font-semibold">
                            @if($restaurant['delivery_fee'] > 0)
                                {{ number_format($restaurant['delivery_fee'], 0, ',', ' ') }} FCFA
                            @else
                                Livraison gratuite
                            @endif
                        </span>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-sm">
                        <span class="text-slate-500">{{ $restaurant['total_reviews'] }} avis</span>
                        <a href="/restaurant/{{ $restaurant['slug'] }}" class="text-orange-600 hover:text-orange-700 font-semibold">
                            Voir le menu →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-slate-200 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-slate-600 mb-2">Aucun restaurant disponible</h3>
            <p class="text-slate-500">Les restaurants seront bientôt disponibles sur notre plateforme.</p>
        </div>
        @endif
    </div>
</section>

<!-- Section Témoignages Restaurant -->
<section class="py-24 bg-gradient-to-br from-slate-50 via-orange-50 to-yellow-50 relative overflow-hidden">
    <!-- Éléments de fond -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-32 h-32 bg-gradient-to-br from-orange-400/10 to-yellow-400/10 rounded-full blur-2xl"></div>
        <div class="absolute bottom-20 right-10 w-24 h-24 bg-gradient-to-br from-teal-400/10 to-green-400/10 rounded-full blur-2xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-20">
            <div class="inline-flex items-center px-4 py-2 bg-orange-100 border border-orange-200 rounded-full text-sm font-semibold text-orange-700 mb-6">
                <div class="w-2 h-2 bg-orange-500 rounded-full mr-2 animate-pulse"></div>
                Témoignages clients
            </div>
            <h2 class="text-5xl font-black text-gray-900 mb-6">
                <span class="bg-gradient-to-r from-orange-600 via-yellow-600 to-orange-700 bg-clip-text text-transparent">
                    Ils nous font confiance
                </span>
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">Découvrez les retours de nos clients satisfaits</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="group relative bg-white rounded-3xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 hover:border-orange-200">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-yellow-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-lg group-hover:scale-110 transition-transform duration-300">M</div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900 text-lg">Mamadou Diallo</h4>
                            <p class="text-sm text-gray-600 font-medium">Restaurant Le Baobab</p>
                        </div>
                    </div>
                    <p class="text-gray-600 leading-relaxed italic">"PeleFood a transformé notre restaurant. Nos commandes ont augmenté de 40% en 3 mois grâce à cette plateforme exceptionnelle !"</p>
                    <div class="flex items-center mt-4">
                        <div class="flex text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm text-gray-500 font-medium">5.0</span>
                    </div>
                </div>
            </div>
            
            <div class="group relative bg-white rounded-3xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 hover:border-teal-200">
                <div class="absolute inset-0 bg-gradient-to-br from-teal-500/5 to-green-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-green-500 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-lg group-hover:scale-110 transition-transform duration-300">F</div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900 text-lg">Fatou Sall</h4>
                            <p class="text-sm text-gray-600 font-medium">Café Teranga</p>
                        </div>
                    </div>
                    <p class="text-gray-600 leading-relaxed italic">"L'interface est très intuitive et le support client est exceptionnel. Je recommande vivement cette solution !"</p>
                    <div class="flex items-center mt-4">
                        <div class="flex text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm text-gray-500 font-medium">5.0</span>
                    </div>
                </div>
            </div>
            
            <div class="group relative bg-white rounded-3xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 hover:border-orange-200">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-yellow-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-lg group-hover:scale-110 transition-transform duration-300">A</div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900 text-lg">Amadou Ba</h4>
                            <p class="text-sm text-gray-600 font-medium">Pizzeria Milano</p>
                        </div>
                    </div>
                    <p class="text-gray-600 leading-relaxed italic">"Grâce à PeleFood, nous gérons maintenant nos livraisons de manière professionnelle et efficace."</p>
                    <div class="flex items-center mt-4">
                        <div class="flex text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm text-gray-500 font-medium">5.0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section CTA finale Restaurant -->
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
                    Digitalisez votre restaurant
                </span>
                <span class="block text-4xl font-light text-orange-200 mt-2">dès aujourd'hui</span>
            </h2>
            
            <p class="text-xl text-slate-100 mb-12 max-w-3xl mx-auto leading-relaxed">
                Rejoignez la révolution digitale de la restauration en Afrique avec notre plateforme SaaS de nouvelle génération
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a href="{{ route('register') }}" class="group relative bg-gradient-to-r from-orange-600 to-yellow-600 hover:from-orange-700 hover:to-yellow-700 text-white px-12 py-5 rounded-2xl font-bold text-xl transition-all duration-300 transform hover:scale-105 shadow-2xl hover:shadow-orange-500/25">
                    <span class="relative z-10 flex items-center">
                        Commencer maintenant
                        <svg class="w-6 h-6 ml-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-yellow-400 rounded-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                </a>
                
                <a href="{{ route('contact') }}" class="group border-2 border-orange-400/50 text-orange-300 hover:border-yellow-400 hover:text-yellow-300 px-12 py-5 rounded-2xl font-bold text-xl transition-all duration-300 hover:shadow-lg backdrop-blur-sm bg-white/5">
                    <span class="flex items-center">
                        Nous contacter
                        <svg class="w-6 h-6 ml-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </span>
                </a>
            </div>
            
            <!-- Statistiques finales -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16 pt-16 border-t border-white/10">
                <div class="text-center group">
                    <div class="text-4xl font-black text-orange-400 mb-2 group-hover:scale-110 transition-transform duration-300">500+</div>
                    <div class="text-slate-200 font-medium">Restaurants actifs</div>
                </div>
                <div class="text-center group">
                    <div class="text-4xl font-black text-yellow-400 mb-2 group-hover:scale-110 transition-transform duration-300">50K+</div>
                    <div class="text-slate-200 font-medium">Commandes traitées</div>
                </div>
                <div class="text-center group">
                    <div class="text-4xl font-black text-teal-400 mb-2 group-hover:scale-110 transition-transform duration-300">98%</div>
                    <div class="text-slate-200 font-medium">Satisfaction client</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 