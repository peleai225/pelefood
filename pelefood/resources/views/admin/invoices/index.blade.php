@extends('layouts.super-admin-new-design')

@section('page-title', 'Factures')
@section('page-description', 'Gestion des factures de tous les restaurants')

@section('content')
<div class="space-y-6">
    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-blue-500/20 to-blue-600/20 backdrop-blur-xl border border-blue-500/30 rounded-2xl p-6 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-300 text-sm font-medium">Total Facturé</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($totalInvoiced) }} FCFA</p>
                </div>
                <div class="w-16 h-16 bg-blue-500/20 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-file-invoice text-2xl text-blue-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500/20 to-green-600/20 backdrop-blur-xl border border-green-500/30 rounded-2xl p-6 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-300 text-sm font-medium">Factures Payées</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($paidInvoices) }}</p>
                </div>
                <div class="w-16 h-16 bg-green-500/20 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-2xl text-green-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500/20 to-yellow-600/20 backdrop-blur-xl border border-yellow-500/30 rounded-2xl p-6 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-300 text-sm font-medium">En Attente</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($pendingInvoices) }}</p>
                </div>
                <div class="w-16 h-16 bg-yellow-500/20 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-clock text-2xl text-yellow-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500/20 to-purple-600/20 backdrop-blur-xl border border-purple-500/30 rounded-2xl p-6 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-300 text-sm font-medium">Total Factures</p>
                    <p class="text-3xl font-bold text-white">{{ number_format($invoices->total()) }}</p>
                </div>
                <div class="w-16 h-16 bg-purple-500/20 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-list text-2xl text-purple-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
        <div>
            <h2 class="text-2xl font-bold text-white">Liste des Factures</h2>
            <p class="text-gray-400">Gérez toutes les factures de la plateforme</p>
        </div>
        <a href="{{ route('admin.invoices.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-lg transition-all duration-200 hover:scale-105">
            <i class="fas fa-plus mr-2"></i>
            Nouvelle Facture
        </a>
    </div>

    <!-- Filtres -->
    <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700 rounded-xl p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Statut</label>
                <select class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tous les statuts</option>
                    <option value="pending">En attente</option>
                    <option value="paid">Payée</option>
                    <option value="overdue">En retard</option>
                    <option value="cancelled">Annulée</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Restaurant</label>
                <select class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tous les restaurants</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Date de début</label>
                <input type="date" class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Date de fin</label>
                <input type="date" class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </div>
    </div>

    <!-- Tableau des factures -->
    <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Facture</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Restaurant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800/50 divide-y divide-gray-700">
                    @forelse($invoices as $invoice)
                    <tr class="hover:bg-gray-700/30 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-file-invoice text-blue-400"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-white">#{{ $invoice->id }}</div>
                                    <div class="text-sm text-gray-400">{{ $invoice->invoice_number ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-white">{{ $invoice->restaurant->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-white">{{ $invoice->user->name ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-400">{{ $invoice->user->email ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-white">{{ number_format($invoice->total_amount ?? 0) }} FCFA</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'paid' => 'bg-green-100 text-green-800',
                                    'overdue' => 'bg-red-100 text-red-800',
                                    'cancelled' => 'bg-gray-100 text-gray-800'
                                ];
                                $status = $invoice->status ?? 'pending';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            {{ $invoice->created_at ? $invoice->created_at->format('d/m/Y H:i') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="text-blue-400 hover:text-blue-300 transition-colors duration-200">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="text-yellow-400 hover:text-yellow-300 transition-colors duration-200">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="text-red-400 hover:text-red-300 transition-colors duration-200">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i class="fas fa-file-invoice text-4xl mb-4"></i>
                                <p class="text-lg font-medium">Aucune facture trouvée</p>
                                <p class="text-sm">Commencez par créer votre première facture</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($invoices->hasPages())
        <div class="bg-gray-700/50 px-6 py-3 border-t border-gray-700">
            {{ $invoices->links() }}
        </div>
        @endif
    </div>
</div>
@endsection 