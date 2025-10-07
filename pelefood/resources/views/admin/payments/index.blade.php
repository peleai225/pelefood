@extends('layouts.super-admin-new-design')

@section('title', 'Gestion des Paiements')
@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestion des Paiements</h1>
                <p class="mt-2 text-gray-600">Surveillez et gérez tous les paiements de votre plateforme</p>
            </div>
            <div class="flex items-center space-x-3">
                <button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-download mr-2"></i> Export
                </button>
                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-sync mr-2"></i> Actualiser
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 fade-in" style="animation-delay: 0.1s;">
        <div class="card-hover bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Paiements Réussis</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $successfulPayments ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="card-hover bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-times text-red-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Paiements Échoués</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $failedPayments ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="card-hover bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">En Attente</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingPayments ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="card-hover bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Revenus Totaux</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalRevenue ?? 0, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="fade-in" style="animation-delay: 0.2s;">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div class="relative">
                    <input type="text" 
                           placeholder="Rechercher..." 
                           class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>

                <!-- Status Filter -->
                <div>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                        <option value="">Tous les statuts</option>
                        <option value="successful">Réussi</option>
                        <option value="failed">Échoué</option>
                        <option value="pending">En attente</option>
                        <option value="refunded">Remboursé</option>
                    </select>
                </div>

                <!-- Payment Method Filter -->
                <div>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                        <option value="">Toutes les méthodes</option>
                        <option value="stripe">Stripe</option>
                        <option value="paypal">PayPal</option>
                        <option value="mobile_money">Mobile Money</option>
                        <option value="bank_transfer">Virement bancaire</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div>
                    <input type="date" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>

                <!-- Amount Range -->
                <div>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                        <option value="">Tous les montants</option>
                        <option value="0-10000">0 - 10,000 FCFA</option>
                        <option value="10000-50000">10,000 - 50,000 FCFA</option>
                        <option value="50000-100000">50,000 - 100,000 FCFA</option>
                        <option value="100000+">100,000+ FCFA</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="fade-in" style="animation-delay: 0.3s;">
        <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Historique des Paiements</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Transaction
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Client
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Montant
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Méthode
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($payments ?? [] as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-credit-card text-white"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $payment->transaction_id ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-500">{{ $payment->payment_method ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $payment->user->name ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500">{{ $payment->tenant->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ number_format($payment->amount ?? 0, 0, ',', ' ') }} FCFA</div>
                                @if($payment->commission)
                                    <div class="text-xs text-gray-500">Commission: {{ number_format($payment->commission, 0, ',', ' ') }} FCFA</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($payment->payment_method === 'stripe')
                                        <i class="fab fa-stripe text-blue-600 mr-2"></i>
                                        <span class="text-sm text-gray-900">Stripe</span>
                                    @elseif($payment->payment_method === 'paypal')
                                        <i class="fab fa-paypal text-blue-500 mr-2"></i>
                                        <span class="text-sm text-gray-900">PayPal</span>
                                    @elseif($payment->payment_method === 'mobile_money')
                                        <i class="fas fa-mobile-alt text-green-600 mr-2"></i>
                                        <span class="text-sm text-gray-900">Mobile Money</span>
                                    @else
                                        <i class="fas fa-university text-gray-600 mr-2"></i>
                                        <span class="text-sm text-gray-900">{{ ucfirst($payment->payment_method) }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($payment->status === 'successful')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i> Réussi
                                    </span>
                                @elseif($payment->status === 'failed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times mr-1"></i> Échoué
                                    </span>
                                @elseif($payment->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i> En attente
                                    </span>
                                @elseif($payment->status === 'refunded')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-undo mr-1"></i> Remboursé
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $payment->created_at->format('d/m/Y H:i') ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="#" class="text-blue-600 hover:text-blue-900" title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($payment->status === 'successful')
                                        <button class="text-yellow-600 hover:text-yellow-900" title="Rembourser">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    @endif
                                    <button class="text-green-600 hover:text-green-900" title="Receipt">
                                        <i class="fas fa-receipt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center py-8">
                                    <i class="fas fa-credit-card text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-lg font-medium text-gray-900 mb-2">Aucun paiement trouvé</p>
                                    <p class="text-gray-500">Les paiements apparaîtront ici une fois effectués.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($payments) && $payments->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $payments->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 