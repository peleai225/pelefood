@extends('layouts.super-admin-new-design')

@section('title', 'Modifier la Commande - PeleFood')
@section('description', 'Modifier les détails de la commande')
@section('page-title', 'Modifier la Commande')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Modifier la Commande #{{ $order->order_number }}</h1>
                <p class="text-gray-600">Restaurant: {{ $order->restaurant->name }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.orders.show', $order) }}" class="btn-secondary">
                    <i class="fas fa-eye mr-2"></i>
                    Voir la commande
                </a>
                <a href="{{ route('admin.orders.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <!-- Formulaire de modification -->
    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Informations de la commande -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-info-circle text-purple-600 mr-2"></i>
                Informations de la Commande
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut de la commande *</label>
                    <select name="status" id="status" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}" {{ old('status', $order->status) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-2">Statut du paiement *</label>
                    <select name="payment_status" id="payment_status" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                        @foreach($paymentStatuses as $value => $label)
                            <option value="{{ $value }}" {{ old('payment_status', $order->payment_status) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="order_type" class="block text-sm font-medium text-gray-700 mb-2">Type de commande</label>
                    <select name="type" id="order_type" disabled
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-500">
                        <option value="{{ $order->type }}">
                            {{ $order->type === 'delivery' ? 'Livraison' : ($order->type === 'pickup' ? 'À emporter' : 'Sur place') }}
                        </option>
                    </select>
                </div>
                
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Méthode de paiement</label>
                    <select name="payment_method" id="payment_method" disabled
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-500">
                        <option value="{{ $order->payment_method }}">
                            {{ ucfirst($order->payment_method) }}
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Informations client -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-user text-purple-600 mr-2"></i>
                Informations Client
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet *</label>
                    <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                </div>
                
                <div>
                    <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                    <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone', $order->customer_phone) }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                </div>
                
                <div>
                    <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email', $order->customer_email) }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                </div>
            </div>
        </div>

        <!-- Adresse de livraison -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-map-marker-alt text-purple-600 mr-2"></i>
                Adresse de Livraison
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="delivery_address_address" class="block text-sm font-medium text-gray-700 mb-2">Adresse *</label>
                    <input type="text" name="delivery_address[address]" id="delivery_address_address" 
                           value="{{ old('delivery_address.address', $order->delivery_address['address'] ?? '') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                </div>
                
                <div>
                    <label for="delivery_address_city" class="block text-sm font-medium text-gray-700 mb-2">Ville *</label>
                    <input type="text" name="delivery_address[city]" id="delivery_address_city" 
                           value="{{ old('delivery_address.city', $order->delivery_address['city'] ?? '') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                </div>
            </div>
        </div>

        <!-- Détails supplémentaires -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-clipboard-list text-purple-600 mr-2"></i>
                Détails Supplémentaires
            </h2>
            
            <div class="space-y-6">
                <div>
                    <label for="special_instructions" class="block text-sm font-medium text-gray-700 mb-2">Instructions spéciales</label>
                    <textarea name="special_instructions" id="special_instructions" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">{{ old('special_instructions', $order->special_instructions) }}</textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="estimated_delivery_time" class="block text-sm font-medium text-gray-700 mb-2">Heure de livraison estimée</label>
                        <input type="datetime-local" name="estimated_delivery_time" id="estimated_delivery_time" 
                               value="{{ old('estimated_delivery_time', $order->estimated_delivery_time ? $order->estimated_delivery_time->format('Y-m-d\TH:i') : '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                    </div>
                    
                    <div id="cancellation_reason_field" style="display: none;">
                        <label for="cancellation_reason" class="block text-sm font-medium text-gray-700 mb-2">Raison de l'annulation *</label>
                        <textarea name="cancellation_reason" id="cancellation_reason" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">{{ old('cancellation_reason', $order->cancellation_reason) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Articles de la commande -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-shopping-cart text-purple-600 mr-2"></i>
                Articles de la Commande
            </h2>
            
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
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $item->product->name ?? 'Produit supprimé' }}</div>
                                @if($item->product)
                                    <div class="text-sm text-gray-500">{{ $item->product->restaurant->name }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ currency($item->price) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ currency($item->quantity * $item->price) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-900">Sous-total:</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ currency($order->subtotal) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-900">Frais de livraison:</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ currency($order->delivery_fee) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-900">Total:</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ currency($order->total_amount) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.orders.show', $order) }}" 
               class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                <i class="fas fa-times mr-2"></i>Annuler
            </a>
            <button type="submit" 
                    class="px-8 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium">
                <i class="fas fa-save mr-2"></i>Mettre à jour la commande
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const cancellationReasonField = document.getElementById('cancellation_reason_field');
    const cancellationReasonInput = document.getElementById('cancellation_reason');
    
    function toggleCancellationReason() {
        if (statusSelect.value === 'cancelled') {
            cancellationReasonField.style.display = 'block';
            cancellationReasonInput.required = true;
        } else {
            cancellationReasonField.style.display = 'none';
            cancellationReasonInput.required = false;
        }
    }
    
    statusSelect.addEventListener('change', toggleCancellationReason);
    
    // Initialiser l'état
    toggleCancellationReason();
});
</script>
@endpush
@endsection
