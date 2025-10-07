@extends('layouts.restaurant')

@section('title', 'Mon Portefeuille')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Mon Portefeuille</h1>
                <p class="text-gray-600">Gérez vos gains et demandes de retrait</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('restaurant.wallet.withdrawal.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i> Demander un retrait
                </a>
                <button onclick="refreshStats()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    <i class="fas fa-sync-alt mr-2"></i> Actualiser
                </button>
            </div>
        </div>
    </div>

    <!-- Statistiques du portefeuille -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Solde disponible -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-wallet text-green-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Solde Disponible</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['formatted_available_balance'] ?? '0 FCFA' }}</p>
                </div>
            </div>
        </div>

        <!-- Total des gains -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-chart-line text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total des Gains</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_earnings'] ?? 0, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>

        <!-- Total des retraits -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-arrow-up text-purple-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total des Retraits</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_withdrawals'] ?? 0, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>

        <!-- Retraits en attente -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">En Attente</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['pending_withdrawals'] ?? 0, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Informations sur les commissions -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-400"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Informations sur les commissions</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>• Commission PeleFood : <strong>2%</strong> par transaction</p>
                    <p>• Frais de retrait : <strong>500 FCFA</strong> par demande</p>
                    <p>• Montant minimum de retrait : <strong>1,000 FCFA</strong></p>
                    <p>• Délai de traitement : <strong>24 heures</strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Demandes de retrait récentes -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Demandes de retrait récentes</h3>
        </div>

        @if($withdrawalRequests->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Demande</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($withdrawalRequests as $request)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">
                                {{ $request->request_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $request->formatted_amount }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($request->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($request->status === 'approved') bg-blue-100 text-blue-800
                                    @elseif($request->status === 'processed') bg-green-100 text-green-800
                                    @elseif($request->status === 'rejected') bg-red-100 text-red-800
                                    @elseif($request->status === 'cancelled') bg-gray-100 text-gray-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    <i class="{{ $request->status_icon }} mr-1"></i>
                                    {{ $request->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $request->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('restaurant.wallet.withdrawal.show', $request) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($request->can_be_cancelled)
                                        <form action="{{ route('restaurant.wallet.withdrawal.cancel', $request) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette demande ?')">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $withdrawalRequests->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <i class="fas fa-wallet text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune demande de retrait</h3>
                <p class="text-gray-500">Vous n'avez pas encore effectué de demande de retrait.</p>
                <div class="mt-4">
                    <a href="{{ route('restaurant.wallet.withdrawal.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-plus mr-2"></i> Faire une demande
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Historique des transactions (simulé) -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Historique des transactions</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($transactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $transaction['description'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($transaction['type'] === 'credit') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                @if($transaction['type'] === 'credit')
                                    <i class="fas fa-arrow-down mr-1"></i> Crédit
                                @else
                                    <i class="fas fa-arrow-up mr-1"></i> Débit
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium
                            @if($transaction['type'] === 'credit') text-green-600
                            @else text-red-600 @endif">
                            @if($transaction['type'] === 'credit')+@else-@endif{{ number_format(abs($transaction['amount']), 0, ',', ' ') }} FCFA
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $transaction['date']->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i> Terminé
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function refreshStats() {
    fetch('{{ route("restaurant.wallet.stats") }}')
        .then(response => response.json())
        .then(data => {
            // Mettre à jour les statistiques
            location.reload();
        })
        .catch(error => {
            console.error('Erreur lors de l\'actualisation:', error);
        });
}
</script>
@endsection
