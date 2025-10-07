@extends('layouts.saas-modern')

@section('title', 'PeleFood SaaS - Gestion de Restaurants')
@section('description', 'Plateforme SaaS complète pour la gestion de restaurants. Commandes, menus, facturation et plus encore.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-full h-full">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
            <div class="absolute top-1/3 right-1/4 w-72 h-72 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute bottom-1/4 left-1/3 w-80 h-80 bg-pink-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse" style="animation-delay: 4s;"></div>
        </div>
    </div>
    
    <div class="relative container mx-auto px-4 py-20">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                Gérez votre restaurant
                <span class="text-yellow-400">intelligemment</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100 max-w-3xl mx-auto">
                PeleFood SaaS vous offre tous les outils nécessaires pour gérer efficacement votre restaurant : 
                commandes, menus, facturation, et bien plus encore.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="btn btn-primary btn-xl">
                    <i data-lucide="rocket" class="w-5 h-5 mr-2"></i>
                    Commencer gratuitement
                </a>
                <a href="#features" class="btn btn-outline btn-xl text-white border-white hover:bg-white hover:text-blue-600">
                    <i data-lucide="play" class="w-5 h-5 mr-2"></i>
                    Voir la démo
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">
                Tout ce dont vous avez besoin
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Une solution complète pour moderniser la gestion de votre restaurant
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="card hover:shadow-lg transition-all duration-300">
                <div class="card-body text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="shopping-cart" class="w-8 h-8 text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Gestion des Commandes</h3>
                    <p class="text-gray-600">
                        Gérez facilement toutes vos commandes en temps réel avec un système intuitif et moderne.
                    </p>
                </div>
            </div>
            
            <!-- Feature 2 -->
            <div class="card hover:shadow-lg transition-all duration-300">
                <div class="card-body text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="menu" class="w-8 h-8 text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Menu Digital</h3>
                    <p class="text-gray-600">
                        Créez et gérez votre menu en ligne avec des photos attrayantes et des descriptions détaillées.
                    </p>
                </div>
            </div>
            
            <!-- Feature 3 -->
            <div class="card hover:shadow-lg transition-all duration-300">
                <div class="card-body text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="credit-card" class="w-8 h-8 text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Paiements Sécurisés</h3>
                    <p class="text-gray-600">
                        Acceptez les paiements en ligne de manière sécurisée avec nos intégrations bancaires.
                    </p>
                </div>
            </div>
            
            <!-- Feature 4 -->
            <div class="card hover:shadow-lg transition-all duration-300">
                <div class="card-body text-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="bar-chart" class="w-8 h-8 text-orange-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Analytics Avancés</h3>
                    <p class="text-gray-600">
                        Suivez vos performances avec des tableaux de bord détaillés et des rapports personnalisés.
                    </p>
                </div>
            </div>
            
            <!-- Feature 5 -->
            <div class="card hover:shadow-lg transition-all duration-300">
                <div class="card-body text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="truck" class="w-8 h-8 text-red-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Livraison</h3>
                    <p class="text-gray-600">
                        Gérez vos livraisons avec un système de suivi en temps réel et une optimisation des trajets.
                    </p>
                </div>
            </div>
            
            <!-- Feature 6 -->
            <div class="card hover:shadow-lg transition-all duration-300">
                <div class="card-body text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="users" class="w-8 h-8 text-indigo-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Gestion d'Équipe</h3>
                    <p class="text-gray-600">
                        Organisez votre équipe avec des rôles personnalisés et des permissions granulaires.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">
                Tarifs simples et transparents
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Choisissez le plan qui correspond à vos besoins
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            @php
                $plans = \App\Models\SubscriptionPlan::where('is_active', true)->orderBy('created_at', 'asc')->take(3)->get();
            @endphp
            
            @forelse($plans as $plan)
            <div class="card {{ $plan->is_popular ? 'border-2 border-blue-500 relative' : '' }}">
                @if($plan->is_popular)
                <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                    <span class="bg-blue-500 text-white px-4 py-1 rounded-full text-sm font-medium">
                        Populaire
                    </span>
                </div>
                @endif
                
                <div class="card-body text-center">
                    <h3 class="text-2xl font-bold mb-2">{{ $plan->name }}</h3>
                    <div class="text-4xl font-bold text-blue-600 mb-4">
                        {{ \App\Helpers\SettingsHelper::formatAmount($plan->price) }}<span class="text-lg text-gray-500">/{{ $plan->billing_cycle === 'monthly' ? 'mois' : ($plan->billing_cycle === 'yearly' ? 'an' : 'période') }}</span>
                    </div>
                    
                    @if($plan->trial_days > 0)
                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i data-lucide="gift" class="w-4 h-4 mr-1"></i>
                            {{ $plan->trial_days }} jours d'essai gratuit
                        </span>
                    </div>
                    @endif
                    
                    <ul class="space-y-3 mb-8">
                        @if($plan->features)
                            @foreach(array_slice($plan->features, 0, 5) as $feature)
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-5 h-5 text-green-500 mr-3"></i>
                                {{ $feature }}
                            </li>
                            @endforeach
                        @else
                            <!-- Fonctionnalités par défaut -->
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-5 h-5 text-green-500 mr-3"></i>
                                @if($plan->getLimit('max_orders_per_month'))
                                    Jusqu'à {{ number_format($plan->getLimit('max_orders_per_month')) }} commandes/mois
                                @else
                                    Commandes illimitées
                                @endif
                            </li>
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-5 h-5 text-green-500 mr-3"></i>
                                @if($plan->getLimit('max_products'))
                                    {{ number_format($plan->getLimit('max_products')) }} produits
                                @else
                                    Produits illimités
                                @endif
                            </li>
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-5 h-5 text-green-500 mr-3"></i>
                                Support {{ $plan->canUsePrioritySupport() ? 'prioritaire' : 'email' }}
                            </li>
                            @if($plan->canUseAnalytics())
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-5 h-5 text-green-500 mr-3"></i>
                                Analytics avancés
                            </li>
                            @endif
                            @if($plan->canUseApi())
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-5 h-5 text-green-500 mr-3"></i>
                                API complète
                            </li>
                            @endif
                        @endif
                    </ul>
                    
                    @auth
                        <a href="{{ route('restaurant.subscription.show', $plan->id) }}" class="btn {{ $plan->is_popular ? 'btn-primary' : 'btn-outline' }} w-full">
                            Choisir ce plan
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn {{ $plan->is_popular ? 'btn-primary' : 'btn-outline' }} w-full">
                            Commencer
                        </a>
                    @endauth
                </div>
            </div>
            @empty
            <!-- Plans par défaut si aucun plan n'est trouvé -->
            <div class="col-span-3 text-center py-12">
                <i data-lucide="package" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun plan disponible</h3>
                <p class="text-gray-600">Les plans d'abonnement seront bientôt disponibles.</p>
            </div>
            @endforelse
        </div>
        
        <!-- Lien vers tous les plans -->
        @if($plans->count() > 0)
        <div class="text-center mt-8">
            <a href="{{ route('restaurant.subscription.select') }}" class="inline-flex items-center px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition-colors">
                <i data-lucide="eye" class="w-5 h-5 mr-2"></i>
                Voir tous les plans
            </a>
        </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-blue-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-4">
            Prêt à moderniser votre restaurant ?
        </h2>
        <p class="text-xl mb-8 text-blue-100 max-w-2xl mx-auto">
            Rejoignez des centaines de restaurateurs qui font confiance à PeleFood SaaS
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="btn btn-primary btn-xl bg-white text-blue-600 hover:bg-gray-100">
                <i data-lucide="rocket" class="w-5 h-5 mr-2"></i>
                Commencer maintenant
            </a>
            <a href="#contact" class="btn btn-outline btn-xl text-white border-white hover:bg-white hover:text-blue-600">
                <i data-lucide="phone" class="w-5 h-5 mr-2"></i>
                Nous appeler
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">PeleFood SaaS</h3>
                <p class="text-gray-400 mb-4">
                    La solution complète pour gérer votre restaurant efficacement.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i data-lucide="facebook" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i data-lucide="twitter" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i data-lucide="linkedin" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold mb-4">Produit</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white">Fonctionnalités</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Tarifs</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Démo</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">API</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold mb-4">Support</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white">Documentation</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Centre d'aide</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Statut</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold mb-4">Légal</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white">Mentions légales</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Politique de confidentialité</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">CGU</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Cookies</a></li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 pt-8 text-center">
            <p class="text-gray-400">
                © {{ date('Y') }} PeleFood SaaS. Tous droits réservés.
            </p>
        </div>
    </div>
</footer>
@endsection

@push('scripts')
<script>
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
    
    // Animation au scroll
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
    
    document.querySelectorAll('.card').forEach(card => {
        observer.observe(card);
    });
</script>
@endpush
