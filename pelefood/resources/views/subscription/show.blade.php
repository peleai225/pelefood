@extends('layouts.app')

@section('title', 'Détails du Plan - ' . $plan->name . ' - PeleFood')
@section('description', 'Découvrez tous les détails du plan ' . $plan->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-yellow-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('home') }}" class="hover:text-orange-600">Accueil</a></li>
                <li><i data-lucide="chevron-right" class="w-4 h-4"></i></li>
                <li><a href="{{ route('restaurant.subscription.select') }}" class="hover:text-orange-600">Plans d'abonnement</a></li>
                <li><i data-lucide="chevron-right" class="w-4 h-4"></i></li>
                <li class="text-gray-900 font-medium">{{ $plan->name }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Plan principal -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl p-8 shadow-lg border border-gray-100">
                    <!-- En-tête du plan -->
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center px-4 py-2 bg-orange-100 border border-orange-200 rounded-full text-sm font-semibold text-orange-700 mb-4">
                            <i data-lucide="crown" class="w-4 h-4 mr-2"></i>
                            {{ $plan->name }}
                        </div>
                        <h1 class="text-4xl font-black text-gray-900 mb-4">{{ $plan->name }}</h1>
                        <p class="text-xl text-gray-600 mb-6">{{ $plan->description }}</p>
                        
                        <div class="mb-6">
                            <span class="text-6xl font-black text-orange-600">
                                {{ \App\Helpers\SettingsHelper::formatAmount($plan->price) }}
                            </span>
                            <span class="text-gray-600 text-xl">/{{ $plan->billing_cycle === 'monthly' ? 'mois' : ($plan->billing_cycle === 'yearly' ? 'an' : 'période') }}</span>
                        </div>

                        @if($plan->trial_days > 0)
                        <div class="bg-green-50 border border-green-200 rounded-2xl p-4 mb-6">
                            <div class="flex items-center justify-center">
                                <i data-lucide="gift" class="w-6 h-6 text-green-500 mr-2"></i>
                                <span class="text-green-700 font-semibold">
                                    {{ $plan->trial_days }} jours d'essai gratuit inclus
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Fonctionnalités détaillées -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">
                            <i data-lucide="check-circle" class="w-6 h-6 inline mr-2 text-green-500"></i>
                            Fonctionnalités incluses
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Limites -->
                            <div class="space-y-4">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Limites du plan</h4>
                                
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                    <div class="flex items-center">
                                        <i data-lucide="shopping-cart" class="w-5 h-5 text-orange-500 mr-3"></i>
                                        <span class="text-gray-700">Commandes par mois</span>
                                    </div>
                                    <span class="font-semibold text-gray-900">
                                        @if($plan->getLimit('max_orders_per_month'))
                                            {{ number_format($plan->getLimit('max_orders_per_month')) }}
                                        @else
                                            Illimitées
                                        @endif
                                    </span>
                                </div>

                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                    <div class="flex items-center">
                                        <i data-lucide="package" class="w-5 h-5 text-orange-500 mr-3"></i>
                                        <span class="text-gray-700">Produits</span>
                                    </div>
                                    <span class="font-semibold text-gray-900">
                                        @if($plan->getLimit('max_products'))
                                            {{ number_format($plan->getLimit('max_products')) }}
                                        @else
                                            Illimités
                                        @endif
                                    </span>
                                </div>

                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                    <div class="flex items-center">
                                        <i data-lucide="building" class="w-5 h-5 text-orange-500 mr-3"></i>
                                        <span class="text-gray-700">Restaurants</span>
                                    </div>
                                    <span class="font-semibold text-gray-900">
                                        @if($plan->getLimit('max_restaurants'))
                                            {{ number_format($plan->getLimit('max_restaurants')) }}
                                        @else
                                            Illimités
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <!-- Fonctionnalités avancées -->
                            <div class="space-y-4">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Fonctionnalités avancées</h4>
                                
                                <div class="space-y-3">
                                    <div class="flex items-center p-3 {{ $plan->canUseAnalytics() ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-400' }} rounded-lg">
                                        <i data-lucide="{{ $plan->canUseAnalytics() ? 'check' : 'x' }}" class="w-5 h-5 mr-3"></i>
                                        <span>Analytics avancés</span>
                                    </div>

                                    <div class="flex items-center p-3 {{ $plan->canUseApi() ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-400' }} rounded-lg">
                                        <i data-lucide="{{ $plan->canUseApi() ? 'check' : 'x' }}" class="w-5 h-5 mr-3"></i>
                                        <span>API complète</span>
                                    </div>

                                    <div class="flex items-center p-3 {{ $plan->canExportData() ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-400' }} rounded-lg">
                                        <i data-lucide="{{ $plan->canExportData() ? 'check' : 'x' }}" class="w-5 h-5 mr-3"></i>
                                        <span>Export de données</span>
                                    </div>

                                    <div class="flex items-center p-3 {{ $plan->canCustomizeTheme() ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-400' }} rounded-lg">
                                        <i data-lucide="{{ $plan->canCustomizeTheme() ? 'check' : 'x' }}" class="w-5 h-5 mr-3"></i>
                                        <span>Personnalisation du thème</span>
                                    </div>

                                    <div class="flex items-center p-3 {{ $plan->canUseIntegrations() ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-400' }} rounded-lg">
                                        <i data-lucide="{{ $plan->canUseIntegrations() ? 'check' : 'x' }}" class="w-5 h-5 mr-3"></i>
                                        <span>Intégrations tierces</span>
                                    </div>

                                    <div class="flex items-center p-3 {{ $plan->canUsePrioritySupport() ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-400' }} rounded-lg">
                                        <i data-lucide="{{ $plan->canUsePrioritySupport() ? 'check' : 'x' }}" class="w-5 h-5 mr-3"></i>
                                        <span>Support prioritaire</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comparaison avec les autres plans -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">
                            <i data-lucide="bar-chart-3" class="w-6 h-6 inline mr-2 text-blue-500"></i>
                            Comparaison des plans
                        </h3>
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
                            <p class="text-blue-800 text-center">
                                <i data-lucide="info" class="w-5 h-5 inline mr-2"></i>
                                Vous pouvez changer de plan à tout moment depuis votre tableau de bord.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar - Actions -->
            <div class="lg:col-span-1">
                <div class="sticky top-8">
                    <!-- Carte de souscription -->
                    <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-100 mb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Souscrire au plan</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Plan sélectionné</span>
                                <span class="font-semibold text-gray-900">{{ $plan->name }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Prix</span>
                                <span class="font-bold text-orange-600 text-lg">
                                    {{ \App\Helpers\SettingsHelper::formatAmount($plan->price) }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Facturation</span>
                                <span class="text-gray-900">{{ $plan->billing_cycle === 'monthly' ? 'Mensuelle' : ($plan->billing_cycle === 'yearly' ? 'Annuelle' : 'Personnalisée') }}</span>
                            </div>

                            @if($plan->trial_days > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Essai gratuit</span>
                                <span class="text-green-600 font-semibold">{{ $plan->trial_days }} jours</span>
                            </div>
                            @endif
                        </div>

                        <form action="{{ route('restaurant.subscription.subscribe', $plan->id) }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-bold py-4 px-6 rounded-2xl hover:from-orange-600 hover:to-yellow-600 transition-all duration-300 shadow-lg hover:shadow-xl">
                                @if($plan->trial_days > 0)
                                    <i data-lucide="gift" class="w-5 h-5 inline mr-2"></i>
                                    Commencer l'essai gratuit
                                @else
                                    <i data-lucide="credit-card" class="w-5 h-5 inline mr-2"></i>
                                    Souscrire maintenant
                                @endif
                            </button>
                        </form>

                        <p class="text-xs text-gray-500 text-center mt-4">
                            <i data-lucide="lock" class="w-4 h-4 inline mr-1"></i>
                            Paiement sécurisé et chiffré
                        </p>
                    </div>

                    <!-- Support -->
                    <div class="bg-gray-50 rounded-2xl p-6">
                        <h4 class="font-semibold text-gray-900 mb-3">
                            <i data-lucide="headphones" class="w-5 h-5 inline mr-2 text-blue-500"></i>
                            Besoin d'aide ?
                        </h4>
                        <p class="text-sm text-gray-600 mb-4">
                            Notre équipe est là pour vous accompagner dans votre choix.
                        </p>
                        <div class="space-y-2">
                            <a href="mailto:support@pelefood.ci" class="flex items-center text-sm text-blue-600 hover:text-blue-800">
                                <i data-lucide="mail" class="w-4 h-4 mr-2"></i>
                                support@pelefood.ci
                            </a>
                            <a href="tel:+225123456789" class="flex items-center text-sm text-blue-600 hover:text-blue-800">
                                <i data-lucide="phone" class="w-4 h-4 mr-2"></i>
                                +225 12 34 56 789
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection