@extends('layouts.restaurant')

@section('title', 'Créer une facture - ' . $restaurant->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Créer une facture</h1>
                <p class="text-gray-600">Sélectionnez une commande pour créer une facture</p>
            </div>
            <a href="{{ route('restaurant.invoices.index') }}" 
               class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    @if($orders->count() > 0)
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Commandes disponibles</h2>
            <p class="text-gray-600">Sélectionnez une commande pour créer une facture automatiquement</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commande</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $order->order_number }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $order->customer_name }}</div>
                                <div class="text-sm text-gray-500">{{ $order->customer_email }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($order->status === 'completed') bg-green-100 text-green-800
                                @elseif($order->status === 'delivered') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="createInvoice({{ $order->id }})" 
                                    class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors">
                                <i class="fas fa-file-invoice mr-2"></i>Créer facture
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <div class="mb-4">
            <i class="fas fa-file-invoice text-6xl text-gray-300"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune commande disponible</h3>
        <p class="text-gray-600 mb-6">Toutes les commandes ont déjà une facture ou ne sont pas encore terminées.</p>
        <a href="{{ route('restaurant.orders.index') }}" 
           class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary-dark transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Voir les commandes
        </a>
    </div>
    @endif
</div>

<script>
function createInvoice(orderId) {
    if (confirm('Êtes-vous sûr de vouloir créer une facture pour cette commande ?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("restaurant.invoices.store") }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const orderInput = document.createElement('input');
        orderInput.type = 'hidden';
        orderInput.name = 'order_id';
        orderInput.value = orderId;
        
        form.appendChild(csrfToken);
        form.appendChild(orderInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection 