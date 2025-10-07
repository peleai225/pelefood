@extends('layouts.app')

@section('title', 'Facture #' . ($order->order_number ?? $order->id))

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Facture</h1>
                    <p class="text-gray-600">Commande #{{ $order->order_number ?? $order->id }}</p>
                </div>
                <div class="text-right">
                    <div class="flex space-x-2">
                        <a href="{{ route('invoice.print', $order) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium inline-flex items-center">
                            <i class="fas fa-print mr-2"></i>
                            Imprimer PDF
                        </a>
                        <a href="{{ route('invoice.preview', $order) }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium inline-flex items-center">
                            <i class="fas fa-eye mr-2"></i>
                            Aperçu
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations de la commande -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Informations du restaurant -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Restaurant</h3>
                <div class="space-y-2">
                    <p class="font-medium">{{ $order->restaurant->name ?? 'Restaurant' }}</p>
                    <p class="text-gray-600 text-sm">{{ $order->restaurant->address ?? '' }}</p>
                    <p class="text-gray-600 text-sm">{{ $order->restaurant->city ?? '' }}, {{ $order->restaurant->country ?? '' }}</p>
                    <p class="text-gray-600 text-sm">Tél: {{ $order->restaurant->phone ?? '' }}</p>
                </div>
            </div>

            <!-- Informations du client -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Client</h3>
                <div class="space-y-2">
                    <p class="font-medium">{{ $order->user->name ?? $order->customer_name ?? 'Client' }}</p>
                    <p class="text-gray-600 text-sm">{{ $order->customer_phone ?? '' }}</p>
                    <p class="text-gray-600 text-sm">{{ $order->customer_email ?? '' }}</p>
                    @if($order->delivery_address)
                        <p class="text-gray-600 text-sm">{{ $order->delivery_address['address'] ?? '' }}</p>
                        <p class="text-gray-600 text-sm">{{ $order->delivery_address['city'] ?? '' }}</p>
                    @endif
                </div>
            </div>

            <!-- Détails de la commande -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Détails</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Date:</span>
                        <span class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Statut:</span>
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'confirmed') bg-blue-100 text-blue-800
                            @elseif($order->status === 'delivered') bg-green-100 text-green-800
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($order->status ?? 'En attente') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Méthode:</span>
                        <span class="font-medium">{{ ucfirst($order->delivery_method ?? 'Livraison') }}</span>
                    </div>
                    @if($order->estimated_delivery_time)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Livraison:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($order->estimated_delivery_time)->format('d/m/Y H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Articles commandés -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Articles commandés</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Article</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unitaire</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $item->product_name ?? $item->product->name ?? 'Produit' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ Str::limit($item->product->description ?? '', 50) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">
                                {{ $item->quantity ?? 0 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900">
                                {{ number_format($item->unit_price ?? 0, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">
                                {{ number_format($item->total_price ?? 0, 0, ',', ' ') }} FCFA
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Totaux -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="max-w-md ml-auto">
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Sous-total:</span>
                        <span class="font-medium">{{ number_format($order->subtotal ?? 0, 0, ',', ' ') }} FCFA</span>
                    </div>
                    @if($order->tax_amount && $order->tax_amount > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Taxes:</span>
                        <span class="font-medium">{{ number_format($order->tax_amount, 0, ',', ' ') }} FCFA</span>
                    </div>
                    @endif
                    @if($order->delivery_fee && $order->delivery_fee > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Frais de livraison:</span>
                        <span class="font-medium">{{ number_format($order->delivery_fee, 0, ',', ' ') }} FCFA</span>
                    </div>
                    @endif
                    <div class="border-t border-gray-200 pt-2">
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total:</span>
                            <span class="text-red-600">{{ number_format($order->total_amount ?? 0, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-6 flex justify-center space-x-4">
            <a href="{{ route('invoice.print', $order) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium inline-flex items-center">
                <i class="fas fa-print mr-2"></i>
                Imprimer Facture PDF
            </a>
            <a href="{{ route('invoice.receipt', $order) }}" 
               class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-md font-medium inline-flex items-center">
                <i class="fas fa-receipt mr-2"></i>
                Télécharger Reçu
            </a>
            <a href="{{ route('invoice.ticket', $order) }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-md font-medium inline-flex items-center">
                <i class="fas fa-ticket-alt mr-2"></i>
                Ticket de Caisse
            </a>
        </div>
    </div>
</div>
@endsection
