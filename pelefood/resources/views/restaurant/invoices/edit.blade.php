@extends('layouts.restaurant')

@section('title', 'Modifier la facture ' . $invoice->invoice_number . ' - ' . $restaurant->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Modifier la facture {{ $invoice->invoice_number }}</h1>
                <p class="text-gray-600">Modifiez les détails de la facture</p>
            </div>
            <a href="{{ route('restaurant.invoices.show', $invoice) }}" 
               class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('restaurant.invoices.update', $invoice) }}" class="space-y-8">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Informations client -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations client</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">Nom du client</label>
                            <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', $invoice->customer_name) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                            @error('customer_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email', $invoice->customer_email) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                            @error('customer_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                            <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $invoice->customer_phone) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                            @error('customer_phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="customer_address" class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                            <textarea id="customer_address" name="customer_address" rows="3" 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">{{ old('customer_address', $invoice->customer_address) }}</textarea>
                            @error('customer_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Articles de la facture -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">Articles</h2>
                    </div>
                    <div class="p-6">
                        <div id="invoice-items" class="space-y-4">
                            @foreach($invoice->items as $index => $item)
                            <div class="invoice-item border border-gray-200 rounded-lg p-4">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom du produit</label>
                                        <input type="text" name="items[{{ $index }}][product_name]" value="{{ $item->product_name }}" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantité</label>
                                        <input type="number" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}" min="1" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Prix unitaire</label>
                                        <input type="number" name="items[{{ $index }}][unit_price]" value="{{ $item->unit_price }}" step="0.01" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Total</label>
                                        <input type="number" name="items[{{ $index }}][total_price]" value="{{ $item->total_price }}" step="0.01" readonly 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <textarea name="items[{{ $index }}][product_description]" rows="2" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">{{ $item->product_description }}</textarea>
                                </div>
                                <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                            </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="addInvoiceItem()" 
                                class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Ajouter un article
                        </button>
                    </div>
                </div>
            </div>

            <!-- Résumé et paramètres -->
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

                <!-- Paramètres de la facture -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Paramètres</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                            <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                <option value="draft" {{ $invoice->status === 'draft' ? 'selected' : '' }}>Brouillon</option>
                                <option value="sent" {{ $invoice->status === 'sent' ? 'selected' : '' }}>Envoyée</option>
                                <option value="paid" {{ $invoice->status === 'paid' ? 'selected' : '' }}>Payée</option>
                                <option value="overdue" {{ $invoice->status === 'overdue' ? 'selected' : '' }}>En retard</option>
                                <option value="cancelled" {{ $invoice->status === 'cancelled' ? 'selected' : '' }}>Annulée</option>
                            </select>
                        </div>
                        <div>
                            <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-2">Statut du paiement</label>
                            <select id="payment_status" name="payment_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                <option value="unpaid" {{ $invoice->payment_status === 'unpaid' ? 'selected' : '' }}>Non payé</option>
                                <option value="partial" {{ $invoice->payment_status === 'partial' ? 'selected' : '' }}>Partiel</option>
                                <option value="paid" {{ $invoice->payment_status === 'paid' ? 'selected' : '' }}>Payé</option>
                            </select>
                        </div>
                        <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Date d'échéance</label>
                            <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '') }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <textarea id="notes" name="notes" rows="3" 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">{{ old('notes', $invoice->notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Actions</h2>
                    <div class="space-y-3">
                        <button type="submit" class="w-full bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors">
                            <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                        </button>
                        <a href="{{ route('restaurant.invoices.show', $invoice) }}" 
                           class="block w-full bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors text-center">
                            <i class="fas fa-times mr-2"></i>Annuler
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
let itemIndex = {{ count($invoice->items) }};

function addInvoiceItem() {
    const container = document.getElementById('invoice-items');
    const newItem = document.createElement('div');
    newItem.className = 'invoice-item border border-gray-200 rounded-lg p-4';
    newItem.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nom du produit</label>
                <input type="text" name="items[${itemIndex}][product_name]" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Quantité</label>
                <input type="number" name="items[${itemIndex}][quantity]" value="1" min="1" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Prix unitaire</label>
                <input type="number" name="items[${itemIndex}][unit_price]" value="0" step="0.01" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Total</label>
                <input type="number" name="items[${itemIndex}][total_price]" value="0" step="0.01" readonly 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
            </div>
        </div>
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea name="items[${itemIndex}][product_description]" rows="2" 
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"></textarea>
        </div>
        <div class="mt-4 flex justify-end">
            <button type="button" onclick="removeInvoiceItem(this)" 
                    class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition-colors">
                <i class="fas fa-trash mr-1"></i>Supprimer
            </button>
        </div>
    `;
    container.appendChild(newItem);
    itemIndex++;
}

function removeInvoiceItem(button) {
    button.closest('.invoice-item').remove();
}

// Calculer automatiquement le total des articles
document.addEventListener('input', function(e) {
    if (e.target.name && e.target.name.includes('[quantity]') || e.target.name.includes('[unit_price]')) {
        const item = e.target.closest('.invoice-item');
        const quantity = item.querySelector('input[name*="[quantity]"]').value || 0;
        const unitPrice = item.querySelector('input[name*="[unit_price]"]').value || 0;
        const totalPrice = quantity * unitPrice;
        item.querySelector('input[name*="[total_price]"]').value = totalPrice.toFixed(2);
    }
});
</script>
@endsection 