@extends('layouts.app')

@section('title', 'Choisir votre Plan d\'Abonnement - PeleFood')
@section('description', 'Sélectionnez le plan d\'abonnement qui correspond à vos besoins')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-yellow-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center px-4 py-2 bg-orange-100 border border-orange-200 rounded-full text-sm font-semibold text-orange-700 mb-6">
                <i data-lucide="crown" class="w-4 h-4 mr-2"></i>
                Plans d'Abonnement
            </div>
            <h1 class="text-5xl font-black text-gray-900 mb-6">
                <span class="bg-gradient-to-r from-orange-600 via-yellow-600 to-orange-700 bg-clip-text text-transparent">
                    Choisissez votre plan
                </span>
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Des tarifs simples et transparents pour tous les types de restaurants.
                <span class="font-semibold text-orange-600">Commencez gratuitement, évoluez selon vos besoins.</span>
            </p>
        </div>

        <!-- Plans d'abonnement -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            @foreach($plans as $plan)
            <div class="group relative bg-white rounded-3xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-4 border border-gray-100 hover:border-orange-200 {{ $plan->is_popular ? 'ring-2 ring-orange-500' : '' }}">
                @if($plan->is_popular)
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-gradient-to-r from-orange-500 to-yellow-500 text-white px-6 py-2 rounded-full text-sm font-bold">
                        <i data-lucide="star" class="w-4 h-4 inline mr-1"></i>
                        Populaire
                    </span>
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
                        @endif
                    </div>
                    
                    <!-- Fonctionnalités -->
                    <ul class="space-y-4 mb-8">
                        @if($plan->features)
                            @foreach($plan->features as $feature)
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-5 h-5 text-green-500 mr-3 flex-shrink-0"></i>
                                <span class="text-gray-700">{{ $feature }}</span>
                            </li>
                            @endforeach
                        @else
                            <!-- Fonctionnalités par défaut basées sur les limites -->
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-5 h-5 text-green-500 mr-3 flex-shrink-0"></i>
                                <span class="text-gray-700">
                                    @if($plan->getLimit('max_orders_per_month'))
                                        {{ $plan->getLimit('max_orders_per_month') }} commandes/mois
                                    @else
                                        Commandes illimitées
                                    @endif
                                </span>
                            </li>
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-5 h-5 text-green-500 mr-3 flex-shrink-0"></i>
                                <span class="text-gray-700">
                                    @if($plan->getLimit('max_products'))
                                        {{ $plan->getLimit('max_products') }} produits
                                    @else
                                        Produits illimités
                                    @endif
                                </span>
                            </li>
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-5 h-5 text-green-500 mr-3 flex-shrink-0"></i>
                                <span class="text-gray-700">
                                    @if($plan->getLimit('max_restaurants'))
                                        {{ $plan->getLimit('max_restaurants') }} restaurant(s)
                                    @else
                                        Restaurants illimités
                                    @endif
                                </span>
                            </li>
                            @if($plan->canUseAnalytics())
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-5 h-5 text-green-500 mr-3 flex-shrink-0"></i>
                                <span class="text-gray-700">Analytics avancés</span>
                            </li>
                            @endif
                            @if($plan->canUseApi())
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-5 h-5 text-green-500 mr-3 flex-shrink-0"></i>
                                <span class="text-gray-700">API complète</span>
                            </li>
                            @endif
                            @if($plan->canUsePrioritySupport())
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-5 h-5 text-green-500 mr-3 flex-shrink-0"></i>
                                <span class="text-gray-700">Support prioritaire</span>
                            </li>
                            @endif
                        @endif
                    </ul>
                    
                    <!-- Bouton d'action -->
                    <a href="{{ route('restaurant.subscription.show', $plan->id) }}" 
                       class="block w-full text-center px-6 py-4 rounded-2xl font-bold text-lg transition-all duration-300 {{ $plan->is_popular ? 'bg-gradient-to-r from-orange-500 to-yellow-500 text-white hover:from-orange-600 hover:to-yellow-600 shadow-lg hover:shadow-xl' : 'bg-orange-100 text-orange-700 hover:bg-orange-200' }}">
                        @if($plan->trial_days > 0)
                            Commencer l'essai gratuit
                        @else
                            Choisir ce plan
                        @endif
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Informations supplémentaires -->
        <div class="bg-white rounded-3xl p-8 shadow-lg border border-gray-100">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">
                    <i data-lucide="shield-check" class="w-6 h-6 inline mr-2 text-green-500"></i>
                    Garantie satisfait ou remboursé
                </h3>
                <p class="text-gray-600 mb-6">
                    Essayez PeleFood sans risque pendant 30 jours. Si vous n'êtes pas satisfait, nous vous remboursons intégralement.
                </p>
                <div class="flex flex-wrap justify-center gap-6 text-sm text-gray-500">
                    <div class="flex items-center">
                        <i data-lucide="lock" class="w-4 h-4 mr-2 text-green-500"></i>
                        Paiement sécurisé
                    </div>
                    <div class="flex items-center">
                        <i data-lucide="credit-card" class="w-4 h-4 mr-2 text-green-500"></i>
                        Tous les moyens de paiement
                    </div>
                    <div class="flex items-center">
                        <i data-lucide="headphones" class="w-4 h-4 mr-2 text-green-500"></i>
                        Support 24/7
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Animation des cartes au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.group').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
</script>
@endpush
@endsection