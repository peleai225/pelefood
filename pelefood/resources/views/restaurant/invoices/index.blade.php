@extends('layouts.restaurant')

@section('title', 'Gestion des factures - ' . $restaurant->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Gestion des factures</h1>
                <p class="text-gray-600">Gérez les factures de vos clients</p>
            </div>
            <a href="{{ route('restaurant.invoices.create') }}" 
               class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary-dark transition-colors">
                <i class="fas fa-plus mr-2"></i>Nouvelle facture
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-6 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-file-invoice text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total factures</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Payées</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['paid'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">En attente</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['unpaid'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">En retard</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['overdue'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-money-bill text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total montant</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_amount'], 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Montant payé</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['paid_amount'], 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6 border-b border-gray-200">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div class="md:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Rechercher par numéro, client..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        <option value="">Tous les statuts</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                        <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Envoyée</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Payée</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>En retard</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                    </select>
                </div>
                <div>
                    <select name="payment_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        <option value="">Tous les paiements</option>
                        <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Non payé</option>
                        <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>Partiel</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Payé</option>
                    </select>
                </div>
                <div>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <button type="submit" class="w-full px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                        <i class="fas fa-search mr-2"></i>Rechercher
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des factures -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Facture</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paiement</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date échéance</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($invoices as $invoice)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $invoice->invoice_number }}</div>
                                <div class="text-sm text-gray-500">{{ $invoice->created_at->format('d/m/Y') }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $invoice->customer_name }}</div>
                                <div class="text-sm text-gray-500">{{ $invoice->customer_email }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ number_format($invoice->total_amount, 0, ',', ' ') }} FCFA</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $invoice->getStatusBadgeClass() }}">
                                @switch($invoice->status)
                                    @case('draft')
                                        <i class="fas fa-edit mr-1"></i>Brouillon
                                        @break
                                    @case('sent')
                                        <i class="fas fa-paper-plane mr-1"></i>Envoyée
                                        @break
                                    @case('paid')
                                        <i class="fas fa-check mr-1"></i>Payée
                                        @break
                                    @case('overdue')
                                        <i class="fas fa-exclamation-triangle mr-1"></i>En retard
                                        @break
                                    @case('cancelled')
                                        <i class="fas fa-times mr-1"></i>Annulée
                                        @break
                                @endswitch
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $invoice->getPaymentStatusBadgeClass() }}">
                                @switch($invoice->payment_status)
                                    @case('unpaid')
                                        <i class="fas fa-clock mr-1"></i>Non payé
                                        @break
                                    @case('partial')
                                        <i class="fas fa-percentage mr-1"></i>Partiel
                                        @break
                                    @case('paid')
                                        <i class="fas fa-check mr-1"></i>Payé
                                        @break
                                @endswitch
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($invoice->due_date)
                                <div class="{{ $invoice->isOverdue() ? 'text-red-600 font-medium' : '' }}">
                                    {{ $invoice->due_date->format('d/m/Y') }}
                                </div>
                                @if($invoice->isOverdue())
                                    <div class="text-xs text-red-500">En retard</div>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('restaurant.invoices.show', $invoice) }}" 
                                   class="text-blue-600 hover:text-blue-900" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('restaurant.invoices.preview', $invoice) }}" 
                                   class="text-green-600 hover:text-green-900" title="Aperçu">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('restaurant.invoices.download', $invoice) }}" 
                                   class="text-purple-600 hover:text-purple-900" title="Télécharger">
                                    <i class="fas fa-download"></i>
                                </a>
                                @if($invoice->payment_status !== 'paid')
                                    <button onclick="markAsPaid({{ $invoice->id }})" 
                                            class="text-green-600 hover:text-green-900" title="Marquer comme payée">
                                        <i class="fas fa-check"></i>
                                    </button>
                                @endif
                                @if($invoice->status === 'draft')
                                    <button onclick="sendInvoice({{ $invoice->id }})" 
                                            class="text-orange-600 hover:text-orange-900" title="Envoyer">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                @endif
                                <a href="{{ route('restaurant.invoices.edit', $invoice) }}" 
                                   class="text-yellow-600 hover:text-yellow-900" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="deleteInvoice({{ $invoice->id }})" 
                                        class="text-red-600 hover:text-red-900" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Aucune facture trouvée
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($invoices->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $invoices->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function markAsPaid(invoiceId) {
    if (confirm('Êtes-vous sûr de vouloir marquer cette facture comme payée ?')) {
        fetch(`/restaurant/invoices/${invoiceId}/mark-as-paid`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function sendInvoice(invoiceId) {
    if (confirm('Êtes-vous sûr de vouloir envoyer cette facture au client ?')) {
        fetch(`/restaurant/invoices/${invoiceId}/send`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function deleteInvoice(invoiceId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette facture ?')) {
        fetch(`/restaurant/invoices/${invoiceId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>
@endsection 