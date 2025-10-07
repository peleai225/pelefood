<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Factures</h1>
            <p class="text-gray-600 mt-2">Suivez et gérez toutes les factures de la plateforme</p>
        </div>
    </div>

    <!-- Messages -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="metric-card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-file-invoice text-2xl text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Factures</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="metric-card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Payées</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['paid'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="metric-card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-clock text-2xl text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">En Attente</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="metric-card">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-2xl text-red-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">En Retard</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['overdue'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <!-- Recherche -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input wire:model.debounce.300ms="search" 
                           type="text" 
                           placeholder="Rechercher des factures..."
                           class="input-modern block w-full pl-10 pr-3 py-2">
                </div>
            </div>

            <!-- Filtres -->
            <div class="flex items-center space-x-4">
                <select wire:model="filter" class="input-modern">
                    <option value="all">Toutes les factures</option>
                    <option value="paid">Payées</option>
                    <option value="pending">En attente</option>
                    <option value="overdue">En retard</option>
                </select>

                <select wire:model="perPage" class="input-modern">
                    <option value="12">12 par page</option>
                    <option value="24">24 par page</option>
                    <option value="48">48 par page</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Liste des factures -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        @if($invoices->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <button wire:click="sortBy('id')" class="flex items-center space-x-1">
                                    <span>Facture</span>
                                    <i class="fas fa-sort"></i>
                                </button>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Restaurant
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Client
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <button wire:click="sortBy('total_amount')" class="flex items-center space-x-1">
                                    <span>Montant</span>
                                    <i class="fas fa-sort"></i>
                                </button>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <button wire:click="sortBy('created_at')" class="flex items-center space-x-1">
                                    <span>Date</span>
                                    <i class="fas fa-sort"></i>
                                </button>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($invoices as $invoice)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $invoice->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $invoice->restaurant->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $invoice->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ number_format($invoice->total_amount, 0, ',', ' ') }} FCFA
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getPaymentStatusBadgeClass($invoice->payment_status ?? 'pending') }}">
                                        {{ $this->getPaymentStatusLabel($invoice->payment_status ?? 'pending') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $invoice->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <button wire:click="viewInvoice({{ $invoice->id }})" 
                                                class="text-blue-600 hover:text-blue-700"
                                                title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        @if(($invoice->payment_status ?? 'pending') === 'pending')
                                            <button wire:click="markAsPaid({{ $invoice->id }})" 
                                                    class="text-green-600 hover:text-green-700"
                                                    title="Marquer comme payé">
                                                <i class="fas fa-check"></i>
                                            </button>
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
                {{ $invoices->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-file-invoice text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune facture trouvée</h3>
                <p class="text-gray-500 mb-4">Les factures apparaîtront ici une fois créées.</p>
            </div>
        @endif
    </div>

    <!-- Modal pour voir les détails d'une facture -->
    @if($showModal && $selectedInvoice)
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4" wire:click="closeModal">
        <div class="modal-modern relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl transform transition-all duration-300 scale-100" wire:click.stop>
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">{{ $modalTitle }}</h3>
                    <button wire:click="closeModal" class="modal-close-btn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="space-y-6">
                    <!-- Informations de la facture -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">Informations de la facture</h4>
                            <div class="space-y-2">
                                <p><span class="font-medium">N° Facture:</span> #{{ $selectedInvoice->id }}</p>
                                <p><span class="font-medium">Date:</span> {{ $selectedInvoice->created_at->format('d/m/Y H:i') }}</p>
                                <p><span class="font-medium">Restaurant:</span> {{ $selectedInvoice->restaurant->name ?? 'N/A' }}</p>
                                <p><span class="font-medium">Client:</span> {{ $selectedInvoice->user->name ?? 'N/A' }}</p>
                                <p><span class="font-medium">Email:</span> {{ $selectedInvoice->user->email ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">Résumé financier</h4>
                            <div class="space-y-2">
                                <p><span class="font-medium">Sous-total:</span> {{ number_format($selectedInvoice->subtotal ?? $selectedInvoice->total_amount, 0, ',', ' ') }} FCFA</p>
                                <p><span class="font-medium">Frais de livraison:</span> {{ number_format($selectedInvoice->delivery_fee ?? 0, 0, ',', ' ') }} FCFA</p>
                                <p><span class="font-medium">Total:</span> {{ number_format($selectedInvoice->total_amount, 0, ',', ' ') }} FCFA</p>
                                <p><span class="font-medium">Statut:</span> 
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getPaymentStatusBadgeClass($selectedInvoice->payment_status ?? 'pending') }}">
                                        {{ $this->getPaymentStatusLabel($selectedInvoice->payment_status ?? 'pending') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Articles de la commande -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-3">Articles commandés</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantité</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prix unitaire</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @if($selectedInvoice->items)
                                        @foreach($selectedInvoice->items as $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $item->product_name ?? 'Produit' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $item->quantity }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ number_format($item->price, 0, ',', ' ') }} FCFA
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ number_format($item->price * $item->quantity, 0, ',', ' ') }} FCFA
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                                Aucun article trouvé
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                    <button type="button" wire:click="closeModal"
                            class="modal-cancel-btn">
                        Fermer
                    </button>
                    @if(($selectedInvoice->payment_status ?? 'pending') === 'pending')
                        <button wire:click="markAsPaid({{ $selectedInvoice->id }})" 
                                class="btn-modern">
                            Marquer comme payé
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>