<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PeleFood - Plateforme SaaS pour Restaurants</title>
    <meta name="description" content="Transformez votre restaurant avec PeleFood, la plateforme SaaS moderne pour la gestion complète de votre établissement. Commandes, paiements, analytics et plus encore.">
    
    <!-- Tailwind CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
        }
        
        /* Animations avancées */
        .animate-fade-in {
            animation: fadeIn 1.2s ease-out forwards;
            opacity: 0;
        }
        
        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(50px) scale(0.95); 
                filter: blur(10px);
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
                filter: blur(0);
            }
        }
        
        .animate-slide-in-left {
            animation: slideInLeft 1s ease-out forwards;
            opacity: 0;
        }
        
        @keyframes slideInLeft {
            from { 
                opacity: 0; 
                transform: translateX(-80px) rotate(-5deg); 
                filter: blur(5px);
            }
            to { 
                opacity: 1; 
                transform: translateX(0) rotate(0deg); 
                filter: blur(0);
            }
        }
        
        .animate-slide-in-right {
            animation: slideInRight 1s ease-out forwards;
            opacity: 0;
        }
        
        @keyframes slideInRight {
            from { 
                opacity: 0; 
                transform: translateX(80px) rotate(5deg); 
                filter: blur(5px);
            }
            to { 
                opacity: 1; 
                transform: translateX(0) rotate(0deg); 
                filter: blur(0);
            }
        }
        
        .animate-scale-in {
            animation: scaleIn 0.8s ease-out forwards;
            opacity: 0;
            transform: scale(0.8);
        }
        
        @keyframes scaleIn {
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .animate-glow {
            animation: glow 2s ease-in-out infinite alternate;
        }
        
        @keyframes glow {
            from {
                box-shadow: 0 0 20px rgba(249, 115, 22, 0.3);
            }
            to {
                box-shadow: 0 0 40px rgba(249, 115, 22, 0.6);
            }
        }
        
        /* Gradients animés */
        .gradient-animated {
            background: linear-gradient(-45deg, #f97316, #ef4444, #dc2626, #b91c1c);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Effets de texte */
        .text-gradient {
            background: linear-gradient(135deg, #f97316 0%, #ef4444 50%, #dc2626 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: textShine 3s ease-in-out infinite;
        }
        
        @keyframes textShine {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        /* Boutons premium */
        .btn-primary {
            background: linear-gradient(135deg, #f97316 0%, #ef4444 50%, #dc2626 100%);
            border: none;
            color: white;
            font-weight: 700;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 25px 0 rgba(249, 115, 22, 0.4);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 35px 0 rgba(249, 115, 22, 0.6);
            background: linear-gradient(135deg, #ea580c 0%, #dc2626 50%, #b91c1c 100%);
        }
        
        /* Cartes premium */
        .card-premium {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 1.5rem;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.08),
                0 8px 16px rgba(0, 0, 0, 0.04),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .card-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(249, 115, 22, 0.3), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        
        .card-premium:hover::before {
            opacity: 1;
        }
        
        .card-premium:hover {
            transform: translateY(-8px) rotateX(5deg);
            box-shadow: 
                0 30px 60px rgba(0, 0, 0, 0.12),
                0 15px 30px rgba(0, 0, 0, 0.08),
                0 0 0 1px rgba(249, 115, 22, 0.1);
        }
        
        /* Navigation */
        .nav-link {
            position: relative;
            color: #6b7280;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 0;
        }
        
        .nav-link:hover {
            color: #f97316;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, #f97316 0%, #ef4444 100%);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Header fixe */
        .header-fixed {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="h-full">
    <!-- Header -->
    <header class="header-fixed fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 gradient-animated rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-utensils text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">PeleFood</h1>
                        <p class="text-xs text-gray-500">SaaS Platform</p>
                    </div>
                </div>
                
                <!-- Navigation Desktop -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="nav-link">Fonctionnalités</a>
                    <a href="#pricing" class="nav-link">Tarifs</a>
                    <a href="#testimonials" class="nav-link">Témoignages</a>
                    <a href="#contact" class="nav-link">Contact</a>
                </nav>
                
                <!-- Actions -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn-primary px-6 py-2 rounded-lg text-sm">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary px-6 py-2 rounded-lg text-sm">
                            Commencer
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative min-h-screen bg-gradient-to-br from-gray-900 via-black to-gray-900 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-20 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-20 right-20 w-80 h-80 bg-red-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gradient-to-r from-orange-500/5 to-red-500/5 rounded-full blur-2xl animate-pulse" style="animation-delay: 4s;"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20">
            <div class="text-center space-y-12">
                <!-- Badge -->
                <div class="animate-fade-in">
                    <div class="inline-flex items-center px-4 py-2 bg-orange-500/10 border border-orange-500/20 rounded-full text-sm font-medium text-orange-400 backdrop-blur-sm">
                        <div class="w-2 h-2 bg-orange-500 rounded-full mr-2 animate-pulse"></div>
                        Nouveau : Le Shopify pour les Restaurants
                    </div>
                </div>

                <!-- Main Headline -->
                <div class="space-y-8">
                    <h1 class="text-6xl lg:text-8xl font-bold text-white leading-tight animate-fade-in" style="animation-delay: 0.2s;">
                        Accélérez votre croissance avec <span class="text-gradient animate-glow">PeleFood</span>
                    </h1>
                    
                    <p class="text-2xl text-gray-300 max-w-4xl mx-auto leading-relaxed animate-fade-in" style="animation-delay: 0.4s;">
                        Transformez votre restaurant en plateforme digitale moderne. 
                        Commandes en ligne, paiements, analytics, marketing digital - 
                        tout ce dont vous avez besoin pour faire exploser vos ventes.
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-6 justify-center items-center pt-8 animate-scale-in" style="animation-delay: 0.6s;">
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center btn-primary gradient-animated text-white px-12 py-5 rounded-xl font-bold text-xl shadow-2xl hover:shadow-orange-500/25">
                            <span class="flex items-center relative z-10">
                                Commencer gratuitement
                                <svg class="w-6 h-6 ml-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </span>
                        </a>
                        
                        <a href="#demo" 
                           class="group border-2 border-gray-600 text-gray-300 px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-105 hover:border-white hover:text-white">
                            <span class="flex items-center">
                                Voir la démo
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </span>
                        </a>
                    </div>


                    <!-- Section Vidéo Intégrée dans le Hero -->
                    @if($featuredVideo)
                        <div class="pt-16 animate-fade-in" style="animation-delay: 0.8s;">
                            <div class="max-w-4xl mx-auto">
                                <div class="text-center mb-8">
                                    <h3 class="text-3xl font-bold text-white mb-4">
                                        Découvrez PeleFood en action
                                    </h3>
                                    <p class="text-gray-300 text-lg">
                                        {{ $featuredVideo->title }}
                                    </p>
                                </div>
                                
                                @if(!empty($featuredVideo->video_url))
                                    @if($featuredVideo->isYouTube())
                                        <!-- YouTube Embed -->
                                        <div class="aspect-video bg-black rounded-2xl overflow-hidden shadow-2xl">
                                            <iframe 
                                                src="{{ $featuredVideo->getYouTubeEmbedUrl() }}" 
                                                class="w-full h-full"
                                                frameborder="0" 
                                                allowfullscreen
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                loading="lazy">
                                            </iframe>
                                        </div>
                                    @elseif($featuredVideo->isVimeo())
                                        <!-- Vimeo Embed -->
                                        <div class="aspect-video bg-black rounded-2xl overflow-hidden shadow-2xl">
                                            <iframe 
                                                src="https://player.vimeo.com/video/{{ $featuredVideo->getVimeoId() }}?autoplay=0&title=0&byline=0&portrait=0" 
                                                class="w-full h-full"
                                                frameborder="0" 
                                                allowfullscreen
                                                allow="autoplay; fullscreen; picture-in-picture"
                                                loading="lazy">
                                            </iframe>
                                        </div>
                                    @else
                                        <!-- URL générique -->
                                        <div class="aspect-video bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl flex items-center justify-center">
                                            <a href="{{ $featuredVideo->video_url }}" target="_blank" 
                                               class="group relative w-24 h-24 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110 shadow-2xl">
                                                <i class="fas fa-play text-white text-2xl ml-1 group-hover:scale-110 transition-transform duration-300"></i>
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <!-- Placeholder interactif avec info vidéo -->
                                    <div class="aspect-video bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center relative overflow-hidden group cursor-pointer" 
                                         onclick="showVideoModal('{{ $featuredVideo->title }}', '{{ $featuredVideo->description }}')">
                                        <!-- Background animé -->
                                        <div class="absolute inset-0 bg-gradient-to-br from-orange-400 to-red-600 opacity-50 group-hover:opacity-70 transition-opacity"></div>
                                        
                                        <!-- Particules flottantes -->
                                        <div class="absolute inset-0">
                                            <div class="absolute top-4 left-4 w-2 h-2 bg-white/30 rounded-full animate-pulse"></div>
                                            <div class="absolute top-8 right-8 w-1 h-1 bg-white/40 rounded-full animate-pulse" style="animation-delay: 0.5s;"></div>
                                            <div class="absolute bottom-6 left-8 w-1.5 h-1.5 bg-white/25 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
                                            <div class="absolute bottom-4 right-4 w-2 h-2 bg-white/35 rounded-full animate-pulse" style="animation-delay: 1.5s;"></div>
                                        </div>
                                        
                                        <!-- Contenu principal -->
                                        <div class="text-center text-white relative z-10">
                                            <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-all duration-300 shadow-2xl">
                                                <i class="fas fa-play text-4xl ml-1"></i>
                                            </div>
                                            <h3 class="text-2xl font-bold mb-3">{{ $featuredVideo->title }}</h3>
                                            <p class="text-orange-100 text-base max-w-md mx-auto leading-relaxed">{{ $featuredVideo->description }}</p>
                                            <div class="mt-6 flex items-center justify-center space-x-4 text-orange-200">
                                                <div class="flex items-center">
                                                    <i class="fas fa-clock mr-2"></i>
                                                    <span class="text-sm">Démo interactive</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <i class="fas fa-users mr-2"></i>
                                                    <span class="text-sm">Guide complet</span>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <span class="bg-white/20 px-4 py-2 rounded-full text-sm font-medium">
                                                    Cliquez pour découvrir
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Effet de brillance au hover -->
                                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                                        
                                        <!-- Bordure animée -->
                                        <div class="absolute inset-0 rounded-xl border-2 border-white/20 group-hover:border-white/40 transition-colors"></div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 pt-16 animate-fade-in" style="animation-delay: 0.8s;">
                    <div class="text-center group">
                        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-globe text-white text-2xl"></i>
                        </div>
                        <div class="text-4xl lg:text-5xl font-bold text-white mb-2">{{ number_format($stats['restaurants']) }}+</div>
                        <div class="text-gray-400 font-medium">Restaurants</div>
                    </div>
                    <div class="text-center group">
                        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-coins text-white text-2xl"></i>
                        </div>
                        <div class="text-4xl lg:text-5xl font-bold text-white mb-2">{{ number_format($stats['users']) }}+</div>
                        <div class="text-gray-400 font-medium">Utilisateurs</div>
                    </div>
                    <div class="text-center group">
                        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-credit-card text-white text-2xl"></i>
                        </div>
                        <div class="text-4xl lg:text-5xl font-bold text-white mb-2">{{ number_format($stats['orders']) }}+</div>
                        <div class="text-gray-400 font-medium">Commandes</div>
                    </div>
                    <div class="text-center group">
                        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-chart-bar text-white text-2xl"></i>
                        </div>
                        <div class="text-4xl lg:text-5xl font-bold text-white mb-2">{{ number_format($stats['revenue'] / 1000000) }}M+</div>
                        <div class="text-gray-400 font-medium">FCFA de CA</div>
                    </div>
                </div>
            </div>
        </div>

    </section>


    <!-- Features Section -->
    <section id="features" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-6xl font-bold text-gray-900 mb-8">
                    Simplicité. Flexibilité. <span class="text-gradient">Sécurité.</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Une plateforme pensée pour les restaurateurs, par des restaurateurs
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach([
                    ['icon' => 'fas fa-utensils', 'title' => 'Gestion de Menu', 'description' => 'Créez et gérez facilement vos menus avec des catégories personnalisées et des prix dynamiques.', 'color' => 'from-orange-500 to-red-600'],
                    ['icon' => 'fas fa-shopping-cart', 'title' => 'Commandes en Temps Réel', 'description' => 'Recevez et gérez les commandes instantanément avec des notifications push et un suivi en direct.', 'color' => 'from-blue-400 to-purple-500'],
                    ['icon' => 'fas fa-credit-card', 'title' => 'Paiements Sécurisés', 'description' => 'Intégration avec les principales passerelles de paiement pour des transactions sécurisées.', 'color' => 'from-green-400 to-teal-500'],
                    ['icon' => 'fas fa-chart-line', 'title' => 'Analytics Avancés', 'description' => 'Analysez vos performances avec des tableaux de bord détaillés et des rapports personnalisés.', 'color' => 'from-purple-400 to-pink-500'],
                    ['icon' => 'fas fa-mobile-alt', 'title' => 'Application Mobile', 'description' => 'Application mobile native pour gérer votre restaurant depuis n\'importe où.', 'color' => 'from-indigo-400 to-blue-500'],
                    ['icon' => 'fas fa-users', 'title' => 'Gestion des Clients', 'description' => 'Base de données clients complète avec historique des commandes et préférences.', 'color' => 'from-yellow-400 to-orange-500']
                ] as $feature)
                    <div class="card-premium p-8 rounded-2xl group hover:scale-105 transition-all duration-300">
                        <div class="w-14 h-14 bg-gradient-to-r {{ $feature['color'] }} rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="{{ $feature['icon'] }} text-2xl text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $feature['title'] }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-6xl font-bold text-gray-900 mb-8">
                    Plans <span class="text-gradient">simples</span> et transparents
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Choisissez le plan qui correspond à votre restaurant. 
                    Changez ou annulez à tout moment.
                </p>
            </div>
            

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($plans as $plan)
                    <div class="card-premium p-8 rounded-2xl {{ $plan->is_popular ? 'border-2 border-orange-500 scale-105' : '' }}">
                        @if($plan->is_popular)
                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                <span class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-4 py-1 rounded-full text-sm font-semibold">
                                    Le plus populaire
                                </span>
                            </div>
                        @endif
                        
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h3>
                            <p class="text-gray-600 mb-6">{{ $plan->description }}</p>
                            <div class="flex items-baseline justify-center">
                                @if($plan->price == 0)
                                    <span class="text-5xl font-bold text-green-600">Gratuit</span>
                                @else
                                    @php
                                        $priceFCFA = $plan->price * 650; // 1€ = 650 FCFA
                                    @endphp
                                    <span class="text-5xl font-bold text-gray-900">{{ number_format($priceFCFA, 0, ',', ' ') }} FCFA</span>
                                @endif
                                <span class="text-gray-600 ml-2">/{{ $plan->billing_cycle == 'monthly' ? 'mois' : 'an' }}</span>
                            </div>
                            @if($plan->billing_cycle == 'yearly' && $plan->price > 0)
                                <div class="mt-2">
                                    <span class="bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded-full">
                                        Économisez 20%
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <ul class="space-y-4 mb-8">
                            @foreach($plan->features ?? [] as $feature)
                                <li class="flex items-center">
                                    <i class="fas fa-check text-orange-500 mr-3 flex-shrink-0"></i>
                                    <span class="text-gray-700">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                        
                        <a href="{{ route('register') }}" 
                           class="w-full {{ $plan->is_popular ? 'btn-primary gradient-animated' : 'bg-gray-900 hover:bg-gray-800' }} text-white py-3 rounded-xl font-semibold text-center block transition-colors">
                           {{ $plan->price == 0 ? 'Essayer gratuitement' : 'Commencer' }}
                        </a>
                    </div>
                @empty
                    <div class="col-span-3 text-center">
                        <p class="text-gray-500">Aucun plan de souscription disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Additional Info -->
            <div class="text-center mt-16">
                <div class="bg-gray-50 rounded-2xl p-8 max-w-4xl mx-auto">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        Essai gratuit de 14 jours
                    </h3>
                    <p class="text-gray-600 mb-6">
                        Testez toutes les fonctionnalités sans engagement. Aucune carte de crédit requise.
                    </p>
                    <div class="flex items-center justify-center space-x-8 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-orange-500 mr-2"></i>
                            <span>Annulation à tout moment</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-orange-500 mr-2"></i>
                            <span>Support inclus</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-orange-500 mr-2"></i>
                            <span>Mises à jour gratuites</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-5xl font-bold text-gray-900 mb-6">Ils parlent de nous</h2>
                <p class="text-xl text-gray-600">Des restaurateurs qui ont transformé leur business avec PeleFood</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach([
                    ['name' => 'Marie Dubois', 'restaurant' => 'Le Bistrot Parisien', 'content' => 'PeleFood a transformé notre restaurant ! Nos commandes en ligne ont augmenté de 300% en 6 mois. C\'est vraiment le Shopify de la restauration !', 'rating' => 5, 'avatar' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80'],
                    ['name' => 'Ahmed Hassan', 'restaurant' => 'Restaurant Aladin', 'content' => 'Interface intuitive, paiements fluides, analytics détaillés. PeleFood nous a permis de moderniser complètement notre service.', 'rating' => 5, 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80'],
                    ['name' => 'Sophie Martin', 'restaurant' => 'Café des Arts', 'content' => 'Support exceptionnel et fonctionnalités complètes. Nos clients adorent l\'expérience de commande. Un investissement qui se rentabilise rapidement !', 'rating' => 5, 'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80']
                ] as $testimonial)
                    <div class="card-premium p-8 rounded-2xl">
                        <div class="flex items-center mb-6">
                            <img src="{{ $testimonial['avatar'] }}" alt="{{ $testimonial['name'] }}" class="w-12 h-12 rounded-full object-cover mr-4">
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $testimonial['name'] }}</h4>
                                <p class="text-gray-600 text-sm">{{ $testimonial['restaurant'] }}</p>
                            </div>
                        </div>
                        <p class="text-gray-700 mb-4">"{{ $testimonial['content'] }}"</p>
                        <div class="flex">
                            @for ($i = 0; $i < $testimonial['rating']; $i++)
                                <i class="fas fa-star text-orange-400"></i>
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-gradient-to-r from-orange-500 to-red-500">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-5xl font-bold text-white mb-6">
                Prêt à transformer votre restaurant ?
            </h2>
            <p class="text-xl text-orange-100 mb-8">
                Rejoignez des milliers de restaurateurs qui font confiance à PeleFood.
                Commencez gratuitement dès aujourd'hui.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a href="{{ route('register') }}" 
                   class="bg-white text-orange-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-colors shadow-xl">
                   Commencer gratuitement
                </a>
                <a href="#contact" 
                   class="border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-orange-600 transition-colors">
                   Nous contacter
                </a>
            </div>
            
            <p class="text-orange-200 text-sm mt-8">
                Essai gratuit de 14 jours • Aucune carte de crédit requise • Support inclus
            </p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo et description -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 gradient-animated rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-utensils text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">PeleFood</h3>
                            <p class="text-sm text-gray-400">SaaS Platform</p>
                        </div>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-md">
                        Plateforme SaaS moderne et professionnelle pour la gestion complète de votre restaurant. 
                        Commandes, paiements, analytics et bien plus encore.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Liens rapides -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Liens rapides</h4>
                    <ul class="space-y-2">
                        <li><a href="#features" class="text-gray-400 hover:text-white transition-colors">Fonctionnalités</a></li>
                        <li><a href="#pricing" class="text-gray-400 hover:text-white transition-colors">Tarifs</a></li>
                        <li><a href="#testimonials" class="text-gray-400 hover:text-white transition-colors">Témoignages</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Support -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Centre d'aide</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Politique de confidentialité</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Conditions d'utilisation</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} PeleFood. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Modal Vidéo -->
    <div id="videoModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl p-8 max-w-2xl mx-4 relative">
            <button onclick="closeVideoModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                <i class="fas fa-times"></i>
            </button>
            
            <div class="text-center">
                <div class="w-20 h-20 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-play text-white text-3xl ml-1"></i>
                </div>
                
                <h3 id="modalVideoTitle" class="text-3xl font-bold text-gray-900 mb-4"></h3>
                <p id="modalVideoDescription" class="text-gray-600 text-lg mb-8"></p>
                
                <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-xl p-6 text-white">
                    <h4 class="text-xl font-bold mb-4">🚀 Démo PeleFood</h4>
                    <p class="mb-6">Découvrez comment PeleFood peut transformer votre restaurant en quelques minutes seulement.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                            <span class="text-sm">5 min</span>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                            <span class="text-sm">Guide complet</span>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-star text-xl"></i>
                            </div>
                            <span class="text-sm">Démo interactive</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('register') }}" class="inline-flex items-center bg-white text-orange-600 px-8 py-3 rounded-xl font-bold hover:bg-gray-100 transition-colors">
                        <span>Commencer maintenant</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts personnalisés -->
    <script>
        // Fonction pour afficher la modal vidéo
        function showVideoModal(title, description) {
            document.getElementById('modalVideoTitle').textContent = title;
            document.getElementById('modalVideoDescription').textContent = description;
            document.getElementById('videoModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        // Fonction pour fermer la modal vidéo
        function closeVideoModal() {
            document.getElementById('videoModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Fermer la modal en cliquant à l'extérieur
        document.getElementById('videoModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeVideoModal();
            }
        });
        
        // Smooth scrolling pour les liens d'ancrage
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Animation d'entrée pour les éléments
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, observerOptions);
        
        // Observer les éléments avec la classe animate-on-scroll
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
