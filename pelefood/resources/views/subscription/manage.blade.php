@extends('layouts.app')

@section('title', 'Gérer mon Abonnement - PeleFood')
@section('description', 'Gérez votre abonnement et vos factures')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-yellow-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-4xl font-black text-gray-900 mb-4">
                <i data-lucide="crown" class="w-8 h-8 inline mr-3 text-orange-500"></i>
                Gérer mon Abonnement
            </h1>
            <p class="text-xl text-gray-600">Gérez votre abonnement, consultez vos factures et changez de plan</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Plan actuel -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl p-8 shadow-lg border border-gray-100 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                        <i data-lucide="package" class="w-6 h-6 inline mr-2 text-blue-500"></i>
                        Plan Actuel
                    </h2>

                    @if($restaurant && $restaurant->subscriptionPlan)
                        <div class="bg-gradient-to-r from-orange-50 to-yellow-50 rounded-2xl p-6 border border-orange-200">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900">{{ $restaurant->subscriptionPlan->name }}</h3>
                                    <p class="text-gray-600">{{ $restaurant->subscriptionPlan->description }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-3xl font-bold text-orange-600">
                                        {{ \App\Helpers\SettingsHelper::formatAmount($restaurant->subscriptionPlan->price) }}
                                    </div>
                                    <div class="text-gray-600">
                                        /{{ $restaurant->subscriptionPlan->billing_cycle === 'monthly' ? 'mois' : ($restaurant->subscriptionPlan->billing_cycle === 'yearly' ? 'an' : 'période') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Statut de l'abonnement -->
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-600 mr-2">Statut :</span>
                                    @if($restaurant->subscription_status === 'active')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <i data-lucide="check-circle" class="w-4 h-4 mr-1"></i>
                                            Actif
                                        </span>
                                    @elseif($restaurant->subscription_status === 'trial')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <i data-lucide="clock" class="w-4 h-4 mr-1"></i>
                                            Essai gratuit
                                        </span>
                                    @elseif($restaurant->subscription_status === 'expired')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            <i data-lucide="x-circle" class="w-4 h-4 mr-1"></i>
                                            Expiré
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($restaurant->subscription_status) }}
                                        </span>
                                    @endif
                                </div>

                                @if($restaurant->subscription_expires_at)
                                <div class="text-sm text-gray-600">
                                    @if($restaurant->subscription_status === 'trial')
                                        Essai se termine le {{ $restaurant->subscription_expires_at->format('d/m/Y') }}
                                    @else
                                        Renouvellement le {{ $restaurant->subscription_expires_at->format('d/m/Y') }}
                                    @endif
                                </div>
                                @endif
                            </div>

                            <!-- Fonctionnalités du plan -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <h4 class="font-semibold text-gray-900">Limites actuelles</h4>
                                    <div class="text-sm text-gray-600">
                                        @if($restaurant->subscriptionPlan->getLimit('max_orders_per_month'))
                                            • {{ number_format($restaurant->subscriptionPlan->getLimit('max_orders_per_month')) }} commandes/mois
                                        @else
                                            • Commandes illimitées
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        @if($restaurant->subscriptionPlan->getLimit('max_products'))
                                            • {{ number_format($restaurant->subscriptionPlan->getLimit('max_products')) }} produits
                                        @else
                                            • Produits illimités
                                        @endif
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <h4 class="font-semibold text-gray-900">Fonctionnalités</h4>
                                    <div class="text-sm text-gray-600">
                                        @if($restaurant->subscriptionPlan->canUseAnalytics())
                                            • Analytics avancés
                                        @endif
                                        @if($restaurant->subscriptionPlan->canUseApi())
                                            • API complète
                                        @endif
                                        @if($restaurant->subscriptionPlan->canUsePrioritySupport())
                                            • Support prioritaire
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-red-50 border border-red-200 rounded-2xl p-6 text-center">
                            <i data-lucide="alert-triangle" class="w-12 h-12 text-red-500 mx-auto mb-4"></i>
                            <h3 class="text-lg font-semibold text-red-800 mb-2">Aucun plan d'abonnement</h3>
                            <p class="text-red-600 mb-4">Vous n'avez pas encore souscrit à un plan d'abonnement.</p>
                            <a href="{{ route('restaurant.subscription.select') }}" class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                                <i data-lucide="crown" class="w-5 h-5 mr-2"></i>
                                Choisir un plan
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Changer de plan -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <i data-lucide="refresh-cw" class="w-5 h-5 inline mr-2 text-blue-500"></i>
                            Changer de plan
                        </h3>
                        <p class="text-gray-600 mb-4">Passez à un plan plus adapté à vos besoins.</p>
                        <a href="{{ route('restaurant.subscription.select') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            Voir les plans disponibles
                        </a>
                    </div>

                    <!-- Gérer le paiement -->
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            <i data-lucide="credit-card" class="w-5 h-5 inline mr-2 text-green-500"></i>
                            Moyens de paiement
                        </h3>
                        <p class="text-gray-600 mb-4">Gérez vos moyens de paiement et vos factures.</p>
                        <button class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                            Gérer le paiement
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Prochain paiement -->
                @if($restaurant && $restaurant->subscriptionPlan && $restaurant->subscription_status === 'active')
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i data-lucide="calendar" class="w-5 h-5 inline mr-2 text-purple-500"></i>
                        Prochain paiement
                    </h3>
                    
                    @if($restaurant->subscription_expires_at)
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-900 mb-2">
                            {{ \App\Helpers\SettingsHelper::formatAmount($restaurant->subscriptionPlan->price) }}
                        </div>
                        <div class="text-gray-600 mb-4">
                            Le {{ $restaurant->subscription_expires_at->format('d/m/Y') }}
                        </div>
                        <div class="text-sm text-gray-500">
                            Facturation {{ $restaurant->subscriptionPlan->billing_cycle === 'monthly' ? 'mensuelle' : ($restaurant->subscriptionPlan->billing_cycle === 'yearly' ? 'annuelle' : 'personnalisée') }}
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Support -->
                <div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-2xl p-6 border border-orange-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i data-lucide="headphones" class="w-5 h-5 inline mr-2 text-orange-500"></i>
                        Besoin d'aide ?
                    </h3>
                    <p class="text-gray-600 mb-4 text-sm">
                        Notre équipe est là pour vous accompagner dans la gestion de votre abonnement.
                    </p>
                    <div class="space-y-2">
                        <a href="mailto:support@pelefood.ci" class="flex items-center text-sm text-orange-600 hover:text-orange-800">
                            <i data-lucide="mail" class="w-4 h-4 mr-2"></i>
                            support@pelefood.ci
                        </a>
                        <a href="tel:+225123456789" class="flex items-center text-sm text-orange-600 hover:text-orange-800">
                            <i data-lucide="phone" class="w-4 h-4 mr-2"></i>
                            +225 12 34 56 789
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection