@extends('layouts.app')

@section('title', 'Tarifs - PeleFood')
@section('description', 'Choisissez le plan qui correspond à votre restaurant')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-orange-600 via-yellow-600 to-orange-700 overflow-hidden">
    <!-- Éléments de fond -->
    <div class="absolute inset-0">
        <div class="absolute top-10 right-10 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
        <div class="absolute bottom-10 left-10 w-24 h-24 bg-yellow-400/20 rounded-full blur-xl"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-orange-400/10 rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-6xl mx-auto text-center px-4 sm:px-6 lg:px-8 relative z-10 py-24">
        <div class="animate-fade-in-up">
            <div class="inline-flex items-center px-6 py-3 bg-orange-500/20 border border-orange-400/30 rounded-full text-sm font-semibold text-orange-300 mb-8 backdrop-blur-sm">
                <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3 animate-pulse"></div>
                Tarifs Transparents
            </div>

            <!-- Contenu principal -->
            <div class="space-y-10 animate-fade-in-left">
                <h1 class="text-6xl lg:text-7xl font-black text-white leading-tight">
                    <span class="block">Choisissez votre</span>
                    <span class="bg-gradient-to-r from-orange-400 via-yellow-400 to-orange-500 bg-clip-text text-transparent">plan</span>
                </h1>

                <p class="text-slate-100 max-w-4xl mx-auto leading-relaxed text-xl">
                    Des tarifs simples et transparents pour tous les types de restaurants.
                    <span class="font-semibold text-orange-300">Commencez gratuitement, évoluez selon vos besoins.</span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Section Plans Tarifaires -->
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
                Plans Tarifaires
            </div>
            <h2 class="text-5xl font-black text-gray-900 mb-6">
                <span class="bg-gradient-to-r from-orange-600 via-yellow-600 to-orange-700 bg-clip-text text-transparent">
                    Tarifs Simples
                </span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Choisissez le plan qui correspond à votre restaurant
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $plans = \App\Models\SubscriptionPlan::where('is_active', true)->orderBy('created_at', 'asc')->take(3)->get();
            @endphp
            
            @forelse($plans as $plan)
            <div class="group relative bg-white rounded-3xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4 {{ $plan->is_popular ? 'border-2 border-orange-500 hover:border-orange-600' : 'border border-gray-100 hover:border-orange-200' }}">
                @if($plan->is_popular)
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-gradient-to-r from-orange-500 to-yellow-500 text-white px-6 py-2 rounded-full text-sm font-semibold">Populaire</span>
                </div>
                @endif
                
                <div class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-yellow-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative z-10">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h3>
                        <p class="text-gray-600 mb-6">{{ $plan->description }}</p>
                        <div class="mb-6">
                            <span class="text-5xl font-black text-orange-600">
                                {{ \App\Helpers\SettingsHelper::formatAmount($plan->price) }}
                            </span>
                            <span class="text-gray-600">/{{ $plan->billing_cycle === 'monthly' ? 'mois' : ($plan->billing_cycle === 'yearly' ? 'an' : 'période') }}</span>
                        </div>
                        
                        @if($plan->trial_days > 0)
                        <p class="text-sm text-green-600 font-semibold">
                            <i data-lucide="gift" class="w-4 h-4 inline mr-1"></i>
                            {{ $plan->trial_days }} jours d'essai gratuit
                        </p>
                        @else
                        <p class="text-sm text-gray-500">Facturation {{ $plan->billing_cycle === 'monthly' ? 'mensuelle' : ($plan->billing_cycle === 'yearly' ? 'annuelle' : 'personnalisée') }}</p>
                        @endif
                    </div>
                    
                    <ul class="space-y-4 mb-8">
                        @if($plan->features)
                            @foreach(array_slice($plan->features, 0, 5) as $feature)
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">{{ $feature }}</span>
                            </li>
                            @endforeach
                        @else
                            <!-- Fonctionnalités par défaut -->
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">
                                    @if($plan->getLimit('max_orders_per_month'))
                                        Jusqu'à {{ number_format($plan->getLimit('max_orders_per_month')) }} commandes/mois
                                    @else
                                        Commandes illimitées
                                    @endif
                                </span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">
                                    @if($plan->getLimit('max_products'))
                                        {{ number_format($plan->getLimit('max_products')) }} produits
                                    @else
                                        Produits illimités
                                    @endif
                                </span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">Support {{ $plan->canUsePrioritySupport() ? 'prioritaire' : 'email' }}</span>
                            </li>
                            @if($plan->canUseAnalytics())
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">Analytics avancés</span>
                            </li>
                            @endif
                            @if($plan->canUseApi())
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700">API complète</span>
                            </li>
                            @endif
                        @endif
                    </ul>
                    
                    @auth
                        <a href="{{ route('restaurant.subscription.show', $plan->id) }}" class="w-full bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-center block">
                            Choisir ce plan
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="w-full bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-center block">
                            @if($plan->trial_days > 0)
                                Commencer l'essai gratuit
                            @else
                                Choisir ce plan
                            @endif
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
        <div class="text-center mt-12">
            <a href="{{ route('restaurant.subscription.select') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-600 to-yellow-600 text-white font-bold rounded-2xl hover:from-orange-700 hover:to-yellow-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                <i data-lucide="eye" class="w-6 h-6 mr-3"></i>
                Voir tous les plans d'abonnement
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Section FAQ -->
<section class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20">
            <div class="inline-flex items-center px-4 py-2 bg-orange-100 border border-orange-200 rounded-full text-sm font-semibold text-orange-700 mb-6">
                <div class="w-2 h-2 bg-orange-500 rounded-full mr-2 animate-pulse"></div>
                Questions Fréquentes
            </div>
            <h2 class="text-5xl font-black text-gray-900 mb-6">
                <span class="bg-gradient-to-r from-orange-600 via-yellow-600 to-orange-700 bg-clip-text text-transparent">
                    FAQ
                </span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Tout ce que vous devez savoir sur nos tarifs et fonctionnalités
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Puis-je changer de plan à tout moment ?</h3>
                    <p class="text-gray-600">Oui, vous pouvez upgrader ou downgrader votre plan à tout moment depuis votre tableau de bord.</p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Y a-t-il des frais de configuration ?</h3>
                    <p class="text-gray-600">Non, il n'y a aucun frais de configuration. Vous payez uniquement votre abonnement mensuel.</p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Que se passe-t-il si j'annule ?</h3>
                    <p class="text-gray-600">Vous gardez l'accès à votre compte jusqu'à la fin de votre période de facturation.</p>
                </div>
            </div>
            
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Puis-je essayer gratuitement ?</h3>
                    <p class="text-gray-600">Oui, nous offrons des essais gratuits pour tous nos plans, sans carte de crédit requise.</p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Quels moyens de paiement acceptez-vous ?</h3>
                    <p class="text-gray-600">Nous acceptons toutes les cartes bancaires, Mobile Money, et les virements bancaires.</p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Le support est-il inclus ?</h3>
                    <p class="text-gray-600">Oui, tous nos plans incluent le support par email. Les plans avancés incluent le support prioritaire.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-24 bg-gradient-to-br from-orange-600 via-yellow-600 to-orange-700 relative overflow-hidden">
    <!-- Éléments de fond -->
    <div class="absolute inset-0">
        <div class="absolute top-10 right-10 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
        <div class="absolute bottom-10 left-10 w-24 h-24 bg-yellow-400/20 rounded-full blur-xl"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-orange-400/10 rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-6xl mx-auto text-center px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="animate-fade-in-up">
            <div class="inline-flex items-center px-6 py-3 bg-orange-500/20 border border-orange-400/30 rounded-full text-sm font-semibold text-orange-300 mb-8 backdrop-blur-sm">
                <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3 animate-pulse"></div>
                Prêt à commencer ?
            </div>
            
            <h2 class="text-6xl font-black text-white mb-8 leading-tight">
                <span class="bg-gradient-to-r from-orange-400 via-yellow-400 to-orange-500 bg-clip-text text-transparent">
                    Commencez gratuitement
                </span>
                <span class="block text-4xl font-light text-orange-200 mt-2">dès aujourd'hui</span>
            </h2>
            
            <p class="text-xl text-slate-100 mb-12 max-w-3xl mx-auto leading-relaxed">
                Essai gratuit, sans engagement, sans carte de crédit
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