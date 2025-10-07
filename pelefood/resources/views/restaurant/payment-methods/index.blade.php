@extends('layouts.restaurant')

@section('title', 'Méthodes de paiement - ' . $restaurant->name)
@section('page-title', 'Méthodes de paiement')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Méthodes de paiement</h1>
                <p class="text-gray-600 mt-1">Configurez les moyens de paiement acceptés par votre restaurant</p>
            </div>
            <a href="{{ route('restaurant.payment-methods.create') }}" 
               class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Ajouter une méthode
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-credit-card text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total méthodes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_methods'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Méthodes actives</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active_methods'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-mobile-alt text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Mobile Money</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['mobile_money_methods'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-credit-card text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Cartes bancaires</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['card_methods'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des méthodes de paiement -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Méthodes configurées</h2>
        </div>

        @if($paymentMethods->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($paymentMethods as $method)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                @if($method->isWavePayment())
                                    <i class="fas fa-link text-blue-600"></i>
                                @elseif($method->isMobileMoney())
                                    <i class="fas fa-mobile-alt text-gray-600"></i>
                                @elseif($method->isCardPayment())
                                    <i class="fas fa-credit-card text-gray-600"></i>
                                @elseif($method->isCashPayment())
                                    <i class="fas fa-money-bill-wave text-gray-600"></i>
                                @else
                                    <i class="fas fa-university text-gray-600"></i>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $method->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $method->provider }} - {{ ucfirst($method->type) }}</p>
                                @if($method->description)
                                    <p class="text-sm text-gray-500 mt-1">{{ $method->description }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <!-- Statut -->
                            <div class="flex items-center space-x-2">
                                @if($method->is_active)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Actif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Inactif
                                    </span>
                                @endif

                                @if($method->is_default)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-star mr-1"></i>
                                        Par défaut
                                    </span>
                                @endif
                            </div>

                            <!-- Frais -->
                            <div class="text-right">
                                @if($method->transaction_fee > 0 || $method->fixed_fee > 0)
                                    <p class="text-sm text-gray-600">
                                        @if($method->transaction_fee > 0)
                                            {{ $method->transaction_fee }}%
                                        @endif
                                        @if($method->fixed_fee > 0)
                                            +{{ number_format($method->fixed_fee, 0, ',', ' ') }} FCFA
                                        @endif
                                    </p>
                                @else
                                    <p class="text-sm text-green-600">Aucun frais</p>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('restaurant.payment-methods.configure', $method) }}" 
                                   class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    <i class="fas fa-cog mr-1"></i>
                                    @if($method->credentials && count($method->credentials) > 0)
                                        Configurer
                                    @else
                                        Configurer
                                    @endif
                                </a>

                                <a href="{{ route('restaurant.payment-methods.edit', $method) }}" 
                                   class="text-gray-600 hover:text-gray-700">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @if(!$method->is_default)
                                <form method="POST" action="{{ route('restaurant.payment-methods.destroy', $method) }}" 
                                      class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette méthode ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-credit-card text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune méthode de paiement configurée</h3>
                <p class="text-gray-600 mb-6">Commencez par ajouter vos premières méthodes de paiement pour accepter les commandes en ligne.</p>
                <a href="{{ route('restaurant.payment-methods.create') }}" 
                   class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Ajouter une méthode
                </a>
            </div>
        @endif
    </div>

    <!-- Conseils -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Conseils pour configurer vos paiements</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li>Activez au moins une méthode de paiement pour accepter les commandes en ligne</li>
                        <li>Configurez les credentials API pour les méthodes électroniques</li>
                        <li>Testez vos paiements en mode sandbox avant de passer en production</li>
                        <li>Gardez vos clés API sécurisées et ne les partagez jamais</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 