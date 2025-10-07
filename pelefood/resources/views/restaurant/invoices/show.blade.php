@extends('layouts.restaurant')

@section('title', 'Facture ' . $invoice->invoice_number . ' - ' . $restaurant->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Facture {{ $invoice->invoice_number }}</h1>
                <p class="text-gray-600">Détails de la facture</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('restaurant.invoices.preview', $invoice) }}" 
                   class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-eye mr-2"></i>Aperçu
                </a>
                <a href="{{ route('restaurant.invoices.download', $invoice) }}" 
                   class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors">
                    <i class="fas fa-download mr-2"></i>Télécharger
                </a>
                <a href="{{ route('restaurant.invoices.index') }}" 
                   class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>
        </div>
    </div>

    <!-- Informations de la facture -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Détails principaux -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informations client -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations client</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom</label>
                        <p class="text-sm text-gray-900">{{ $invoice->customer_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="text-sm text-gray-900">{{ $invoice->customer_email }}</p>
                    </div>
                    @if($invoice->customer_phone)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <p class="text-sm text-gray-900">{{ $invoice->customer_phone }}</p>
                    </div>
                    @endif
                    @if($invoice->customer_address)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Adresse</label>
                        <p class="text-sm text-gray-900">{{ $invoice->customer_address }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Articles de la facture -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Articles</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unitaire</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($invoice->items as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $item->product_name }}</div>
                                        @if($item->product_description)
                                        <div class="text-sm text-gray-500">{{ $item->product_description }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->quantity }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $restaurant->formatPrice($item->unit_price) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $restaurant->formatPrice($item->total_price) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Résumé et actions -->
        <div class="space-y-6">
            <!-- Résumé -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Résumé</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Sous-total</span>
                        <span class="font-medium">{{ number_format($invoice->subtotal, 0, ',', ' ') }} FCFA</span>
                    </div>
                    @if($invoice->tax_amount > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Taxes</span>
                        <span class="font-medium">{{ number_format($invoice->tax_amount, 0, ',', ' ') }} FCFA</span>
                    </div>
                    @endif
                    @if($invoice->delivery_fee > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Livraison</span>
                        <span class="font-medium">{{ number_format($invoice->delivery_fee, 0, ',', ' ') }} FCFA</span>
                    </div>
                    @endif
                    @if($invoice->discount_amount > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Remise</span>
                        <span class="font-medium text-green-600">-{{ number_format($invoice->discount_amount, 0, ',', ' ') }} FCFA</span>
                    </div>
                    @endif
                    <hr class="border-gray-200">
                    <div class="flex justify-between text-lg font-semibold">
                        <span>Total</span>
                        <span>{{ number_format($invoice->total_amount, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>

            <!-- Statuts -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Statuts</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Statut de la facture</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $invoice->getStatusBadgeClass() }} mt-1">
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
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Statut du paiement</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $invoice->getPaymentStatusBadgeClass() }} mt-1">
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
                    </div>
                    @if($invoice->due_date)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date d'échéance</label>
                        <p class="text-sm text-gray-900 {{ $invoice->isOverdue() ? 'text-red-600 font-medium' : '' }}">
                            {{ $invoice->due_date->format('d/m/Y') }}
                            @if($invoice->isOverdue())
                                <span class="text-red-500">(En retard)</span>
                            @endif
                        </p>
                    </div>
                    @endif
                    @if($invoice->paid_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date de paiement</label>
                        <p class="text-sm text-gray-900">{{ $invoice->paid_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Actions</h2>
                <div class="space-y-3">
                    @if($invoice->payment_status !== 'paid')
                    <button onclick="markAsPaid({{ $invoice->id }})" 
                            class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-check mr-2"></i>Marquer comme payée
                    </button>
                    @endif
                    @if($invoice->status === 'draft')
                    <button onclick="sendInvoice({{ $invoice->id }})" 
                            class="w-full bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i>Envoyer au client
                    </button>
                    @endif
                    <a href="{{ route('restaurant.invoices.edit', $invoice) }}" 
                       class="block w-full bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors text-center">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </a>
                </div>
            </div>
        </div>
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
</script>
@endsection 