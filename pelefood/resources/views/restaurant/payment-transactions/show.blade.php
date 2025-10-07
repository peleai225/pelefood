@extends('layouts.restaurant')

@section('title', 'Transaction ' . $transaction->transaction_id . ' - ' . $restaurant->name)
@section('page-title', 'Détails de la transaction')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Transaction {{ $transaction->transaction_id }}</h1>
                <p class="text-gray-600 mt-1">Détails complets de la transaction</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('restaurant.payment-transactions.index') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
                @if($transaction->isCompleted())
                <form method="POST" action="{{ route('restaurant.payment-transactions.refund', $transaction) }}" 
                      class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir rembourser cette transaction ?')">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-undo mr-2"></i>Rembourser
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informations principales -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Statut et montant -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Informations de la transaction</h2>
                    <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full {{ $transaction->status_badge }}">
                        {{ $transaction->status_text }}
                    </span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Montant</h3>
                        <p class="text-2xl font-bold text-gray-900">{{ $transaction->formatted_amount }}</p>
                        @if($transaction->fee_amount > 0)
                            <p class="text-sm text-gray-500">Frais: {{ number_format($transaction->fee_amount, 0, ',', ' ') }} FCFA</p>
                        @endif
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Méthode de paiement</h3>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                @if($transaction->isMobileMoney())
                                    <i class="fas fa-mobile-alt text-gray-600"></i>
                                @elseif($transaction->isCardPayment())
                                    <i class="fas fa-credit-card text-gray-600"></i>
                                @elseif($transaction->isCashPayment())
                                    <i class="fas fa-money-bill-wave text-gray-600"></i>
                                @else
                                    <i class="fas fa-university text-gray-600"></i>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $transaction->paymentMethod->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-500">{{ ucfirst($transaction->provider) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations de la commande -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informations de la commande</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Numéro de commande</h3>
                        <p class="text-lg font-medium text-gray-900">{{ $transaction->order->order_number ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Date de commande</h3>
                        <p class="text-lg font-medium text-gray-900">{{ $transaction->order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Client</h3>
                        <p class="text-lg font-medium text-gray-900">{{ $transaction->order->customer_name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">{{ $transaction->order->customer_email ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">{{ $transaction->order->customer_phone ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Statut de la commande</h3>
                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                            {{ $transaction->order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                               ($transaction->order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst($transaction->order->status ?? 'N/A') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Détails du paiement -->
            @if($transaction->payment_details)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Détails du paiement</h2>
                
                <div class="space-y-3">
                    @foreach($transaction->payment_details as $key => $value)
                    <div class="flex justify-between py-2 border-b border-gray-100 last:border-b-0">
                        <span class="text-sm font-medium text-gray-500">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                        <span class="text-sm text-gray-900">{{ is_array($value) ? json_encode($value) : $value }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Métadonnées -->
            @if($transaction->metadata)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Métadonnées</h2>
                
                <div class="space-y-3">
                    @foreach($transaction->metadata as $key => $value)
                    <div class="flex justify-between py-2 border-b border-gray-100 last:border-b-0">
                        <span class="text-sm font-medium text-gray-500">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                        <span class="text-sm text-gray-900">{{ is_array($value) ? json_encode($value) : $value }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Timeline -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Timeline</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Transaction créée</p>
                            <p class="text-sm text-gray-500">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>

                    @if($transaction->paid_at)
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Paiement confirmé</p>
                            <p class="text-sm text-gray-500">{{ $transaction->paid_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                    @endif

                    @if($transaction->failed_at)
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Échec du paiement</p>
                            <p class="text-sm text-gray-500">{{ $transaction->failed_at->format('d/m/Y H:i:s') }}</p>
                            @if($transaction->failure_reason)
                                <p class="text-sm text-red-600">{{ $transaction->failure_reason }}</p>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Dernière mise à jour</p>
                            <p class="text-sm text-gray-500">{{ $transaction->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Actions</h2>
                
                <div class="space-y-3">
                    <a href="{{ route('restaurant.orders.show', $transaction->order) }}" 
                       class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-center block">
                        <i class="fas fa-eye mr-2"></i>
                        Voir la commande
                    </a>
                    
                    @if($transaction->isCompleted())
                    <form method="POST" action="{{ route('restaurant.payment-transactions.refund', $transaction) }}" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir rembourser cette transaction ?')">
                        @csrf
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-undo mr-2"></i>
                            Rembourser
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 