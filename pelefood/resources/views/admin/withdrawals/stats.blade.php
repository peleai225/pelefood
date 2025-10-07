@extends('layouts.super-admin-new-design')

@section('title', 'Statistiques des Retraits')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Statistiques des Retraits</h1>
                <p class="text-gray-600">Analyse des demandes de retrait et des portefeuilles</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.withdrawals.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    <i class="fas fa-arrow-left mr-2"></i> Retour
                </a>
                <a href="{{ route('admin.withdrawals.export') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    <i class="fas fa-download mr-2"></i> Exporter
                </a>
            </div>
        </div>
    </div>

    <!-- Statistiques globales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-wallet text-blue-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Portefeuilles Actifs</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $globalStats['total_wallets'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-green-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Solde Total</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $globalStats['formatted_total_balance'] ?? '0 FCFA' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Demandes en Attente</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $globalStats['pending_requests'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-percentage text-purple-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Commission Totale</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $globalStats['formatted_total_commission'] ?? '0 FCFA' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparaison mensuelle -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Comparaison Mensuelle</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Mois Actuel</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $monthlyStats['current_month']['total_requests'] ?? 0 }} demandes</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Montant</p>
                        <p class="text-lg font-semibold text-gray-900">{{ number_format($monthlyStats['current_month']['total_amount'] ?? 0, 0, ',', ' ') }} FCFA</p>
                    </div>
                </div>
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Mois Précédent</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $monthlyStats['last_month']['total_requests'] ?? 0 }} demandes</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Montant</p>
                        <p class="text-lg font-semibold text-gray-900">{{ number_format($monthlyStats['last_month']['total_amount'] ?? 0, 0, ',', ' ') }} FCFA</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Répartition des Statuts</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">En Attente</span>
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                        {{ $globalStats['pending_requests'] ?? 0 }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Approuvées</span>
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                        {{ $globalStats['approved_requests'] ?? 0 }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Traitées</span>
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                        {{ $globalStats['processed_requests'] ?? 0 }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Rejetées</span>
                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                        {{ $globalStats['rejected_requests'] ?? 0 }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Top restaurants par retraits -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Top Restaurants par Retraits</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restaurant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant Retiré</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre de Retraits</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($topRestaurants ?? [] as $restaurant)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $restaurant->restaurant->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ number_format($restaurant->total_withdrawn, 0, ',', ' ') }} FCFA</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $restaurant->withdrawal_count }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                            Aucun retrait traité pour le moment
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
