@extends('layouts.app')

@section('title', 'À propos - PeleFood')

@section('content')
<!-- Hero Section À propos -->
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
                    Notre Histoire
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="space-y-10 animate-fade-in-left">
                <h1 class="text-6xl lg:text-7xl font-black text-white leading-tight">
                    <span class="block">Nous sommes</span>
                    <span class="bg-gradient-to-r from-orange-400 via-yellow-400 to-orange-500 bg-clip-text text-transparent">PeleFood</span>
                </h1>

                <p class="text-slate-100 max-w-4xl mx-auto leading-relaxed text-xl">
                    Une équipe passionnée qui révolutionne la gestion des restaurants en Afrique.
                    <span class="font-semibold text-orange-300">Notre mission : digitaliser l'industrie de la restauration.</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Section Notre Mission -->
<section class="py-24 bg-gradient-to-br from-slate-50 via-orange-50 to-yellow-50 relative overflow-hidden">
    <!-- Éléments de fond -->
    <div class="absolute inset-0">
        <div class="absolute top-10 right-10 w-32 h-32 bg-gradient-to-br from-orange-400/20 to-yellow-400/20 rounded-full blur-xl"></div>
        <div class="absolute bottom-10 left-10 w-24 h-24 bg-gradient-to-br from-teal-400/20 to-green-400/20 rounded-full blur-xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="animate-fade-in-left">
                <div class="inline-flex items-center px-4 py-2 bg-orange-100 border border-orange-200 rounded-full text-sm font-semibold text-orange-700 mb-6">
                    <div class="w-2 h-2 bg-orange-500 rounded-full mr-2 animate-pulse"></div>
                    Notre Mission
                </div>
                <h2 class="text-5xl font-black text-gray-900 mb-8">
                    <span class="bg-gradient-to-r from-orange-600 via-yellow-600 to-orange-700 bg-clip-text text-transparent">
                        Révolutionner la Restauration
                    </span>
                </h2>
                <p class="text-xl text-gray-600 leading-relaxed mb-8">
                    Nous croyons que chaque restaurant mérite d'avoir accès aux meilleures technologies pour prospérer. 
                    Notre plateforme SaaS démocratise l'innovation dans l'industrie de la restauration en Afrique.
                </p>
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Innovation Accessible</h3>
                            <p class="text-gray-600">Des outils de pointe à des prix abordables pour tous les restaurants.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-green-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Support Local</h3>
                            <p class="text-gray-600">Une équipe africaine qui comprend les défis locaux de la restauration.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-slate-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Croissance Durable</h3>
                            <p class="text-gray-600">Accompagner la croissance de nos clients sur le long terme.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="animate-fade-in-right">
                <div class="relative">
                    <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-xl rounded-3xl p-10 shadow-2xl border border-white/20">
                        <div class="text-center">
                            <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-3xl font-black text-white mb-4">Notre Vision</h3>
                            <p class="text-slate-100 mb-8 text-lg leading-relaxed">
                                Devenir la plateforme de référence pour la digitalisation des restaurants en Afrique, 
                                en offrant des solutions innovantes et accessibles.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Éléments décoratifs -->
                    <div class="absolute -top-4 -right-4 w-8 h-8 bg-gradient-to-br from-orange-400 to-yellow-400 rounded-full opacity-60 animate-pulse"></div>
                    <div class="absolute -bottom-4 -left-4 w-6 h-6 bg-gradient-to-br from-teal-400 to-green-400 rounded-full opacity-60 animate-pulse" style="animation-delay: 1s;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Notre Équipe -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20">
            <div class="inline-flex items-center px-4 py-2 bg-orange-100 border border-orange-200 rounded-full text-sm font-semibold text-orange-700 mb-6">
                <div class="w-2 h-2 bg-orange-500 rounded-full mr-2 animate-pulse"></div>
                Notre Équipe
            </div>
            <h2 class="text-5xl font-black text-gray-900 mb-6">
                <span class="bg-gradient-to-r from-orange-600 via-yellow-600 to-orange-700 bg-clip-text text-transparent">
                    L'Équipe PeleFood
                </span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Des experts passionnés qui travaillent chaque jour pour améliorer votre expérience
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Membre 1 -->
            <div class="group text-center">
                <div class="relative mb-6">
                    <div class="w-32 h-32 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-full mx-auto flex items-center justify-center shadow-lg group-hover:shadow-2xl transition-all duration-500 transform group-hover:scale-110">
                        <span class="text-white font-bold text-4xl">A</span>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-teal-400 to-green-400 rounded-full opacity-60 animate-pulse"></div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Amadou Diallo</h3>
                <p class="text-orange-600 font-semibold mb-2">CEO & Fondateur</p>
                <p class="text-gray-600 text-sm">15 ans d'expérience dans la tech et la restauration</p>
            </div>
            
            <!-- Membre 2 -->
            <div class="group text-center">
                <div class="relative mb-6">
                    <div class="w-32 h-32 bg-gradient-to-br from-teal-500 to-green-500 rounded-full mx-auto flex items-center justify-center shadow-lg group-hover:shadow-2xl transition-all duration-500 transform group-hover:scale-110">
                        <span class="text-white font-bold text-4xl">F</span>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-orange-400 to-yellow-400 rounded-full opacity-60 animate-pulse"></div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Fatou Sall</h3>
                <p class="text-teal-600 font-semibold mb-2">CTO</p>
                <p class="text-gray-600 text-sm">Expert en développement et architecture cloud</p>
            </div>
            
            <!-- Membre 3 -->
            <div class="group text-center">
                <div class="relative mb-6">
                    <div class="w-32 h-32 bg-gradient-to-br from-blue-500 to-slate-500 rounded-full mx-auto flex items-center justify-center shadow-lg group-hover:shadow-2xl transition-all duration-500 transform group-hover:scale-110">
                        <span class="text-white font-bold text-4xl">M</span>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-full opacity-60 animate-pulse"></div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Moussa Ba</h3>
                <p class="text-blue-600 font-semibold mb-2">Head of Product</p>
                <p class="text-gray-600 text-sm">Spécialiste UX/UI et expérience utilisateur</p>
            </div>
        </div>
    </div>
</section>

<!-- Section Nos Valeurs -->
<section class="py-24 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 relative overflow-hidden">
    <!-- Éléments de fond -->
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-40 h-40 bg-gradient-to-br from-orange-400/20 to-yellow-400/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-gradient-to-br from-teal-400/20 to-green-400/20 rounded-full blur-3xl"></div>
        <!-- Grille de fond -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="1"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-20">
            <div class="inline-flex items-center px-6 py-3 bg-orange-500/20 border border-orange-400/30 rounded-full text-sm font-semibold text-orange-300 mb-8 backdrop-blur-sm">
                <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3 animate-pulse"></div>
                Nos Valeurs
            </div>
            <h2 class="text-5xl font-black text-white mb-6">
                <span class="bg-gradient-to-r from-orange-400 via-yellow-400 to-orange-500 bg-clip-text text-transparent">
                    Ce qui nous guide
                </span>
            </h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Innovation -->
            <div class="text-center group">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Innovation</h3>
                <p class="text-slate-300">Toujours à la pointe de la technologie pour servir nos clients</p>
            </div>
            
            <!-- Excellence -->
            <div class="text-center group">
                <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-green-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Excellence</h3>
                <p class="text-slate-300">Recherche constante de la qualité dans tout ce que nous faisons</p>
            </div>
            
            <!-- Transparence -->
            <div class="text-center group">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-slate-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Transparence</h3>
                <p class="text-slate-300">Communication claire et honnête avec nos clients</p>
            </div>
            
            <!-- Engagement -->
            <div class="text-center group">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Engagement</h3>
                <p class="text-slate-300">Dévouement total au succès de nos clients</p>
            </div>
        </div>
    </div>
</section>

<!-- Section CTA -->
<section class="py-24 bg-gradient-to-br from-slate-50 via-orange-50 to-yellow-50 relative overflow-hidden">
    <!-- Éléments de fond -->
    <div class="absolute inset-0">
        <div class="absolute top-10 right-10 w-32 h-32 bg-gradient-to-br from-orange-400/20 to-yellow-400/20 rounded-full blur-xl"></div>
        <div class="absolute bottom-10 left-10 w-24 h-24 bg-gradient-to-br from-teal-400/20 to-green-400/20 rounded-full blur-xl"></div>
    </div>
    
    <div class="max-w-6xl mx-auto text-center px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="animate-fade-in-up">
            <div class="inline-flex items-center px-6 py-3 bg-orange-500/20 border border-orange-400/30 rounded-full text-sm font-semibold text-orange-700 mb-8 backdrop-blur-sm">
                <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3 animate-pulse"></div>
                Rejoignez-nous
            </div>
            
            <h2 class="text-6xl font-black text-gray-900 mb-8 leading-tight">
                <span class="bg-gradient-to-r from-orange-600 via-yellow-600 to-orange-700 bg-clip-text text-transparent">
                    Prêt à nous rejoindre ?
                </span>
            </h2>
            
            <p class="text-xl text-gray-600 mb-12 max-w-3xl mx-auto leading-relaxed">
                Découvrez comment PeleFood peut transformer votre restaurant et rejoignez des centaines de restaurateurs satisfaits
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
                
                <a href="{{ route('contact') }}" class="group border-2 border-orange-400/50 text-orange-600 hover:border-yellow-400 hover:text-yellow-600 px-12 py-5 rounded-2xl font-bold text-xl transition-all duration-300 hover:shadow-lg backdrop-blur-sm bg-white/5">
                    <span class="flex items-center">
                        Nous contacter
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