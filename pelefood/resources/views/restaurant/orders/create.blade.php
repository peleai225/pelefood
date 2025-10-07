@extends('layouts.restaurant')

@section('page-title', 'Nouvelle Commande')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Créer une nouvelle commande</h1>
            <p class="text-gray-600">Ajoutez manuellement une commande pour un client</p>
        </div>

        <!-- Formulaire de création -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="{{ route('restaurant.orders.store') }}" method="POST" id="createOrderForm">
                @csrf
                
                <!-- Informations client -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations client</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet *</label>
                            <input type="text" id="customer_name" name="customer_name" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div>
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                            <input type="tel" id="customer_phone" name="customer_phone" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div>
                            <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" id="customer_email" name="customer_email"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div>
                            <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-2">Adresse de livraison *</label>
                            <input type="text" id="delivery_address" name="delivery_address" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                    </div>
                </div>

                <!-- Type de commande -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Type de commande</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="order_type" value="on_site" class="mr-3" checked>
                            <div>
                                <div class="font-medium text-gray-900">Sur place</div>
                                <div class="text-sm text-gray-500">Consommation au restaurant</div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="order_type" value="takeaway" class="mr-3">
                            <div>
                                <div class="font-medium text-gray-900">À emporter</div>
                                <div class="text-sm text-gray-500">Récupération au restaurant</div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="order_type" value="delivery" class="mr-3">
                            <div>
                                <div class="font-medium text-gray-900">Livraison</div>
                                <div class="text-sm text-gray-500">Livraison à domicile</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Produits -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Produits commandés</h3>
                    <div id="productsList" class="space-y-4">
                        <!-- Les produits seront ajoutés ici dynamiquement -->
                    </div>
                    
                    <button type="button" onclick="addProductRow()" 
                            class="mt-4 inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-plus mr-2"></i>Ajouter un produit
                    </button>
                </div>

                <!-- Instructions spéciales -->
                <div class="mb-8">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Instructions spéciales</label>
                    <textarea id="notes" name="notes" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                              placeholder="Allergies, préférences de cuisson, etc."></textarea>
                </div>

                <!-- Résumé et total -->
                <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Résumé de la commande</h3>
                    <div id="orderSummary" class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sous-total:</span>
                            <span id="subtotal" class="font-medium">0.00 €</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Frais de livraison:</span>
                            <span id="deliveryFee" class="font-medium">0.00 €</span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total:</span>
                            <span id="total" class="text-orange-600">0.00 €</span>
                        </div>
                    </div>
                    
                    <!-- Champs cachés pour le total -->
                    <input type="hidden" name="total_amount" id="total_amount" value="0">
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('restaurant.orders.index') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                        Créer la commande
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Template pour les lignes de produits -->
<template id="productRowTemplate">
    <div class="product-row flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
        <div class="flex-1">
            <select name="items[][product_id]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" onchange="updateProductPrice(this)">
                <option value="">Sélectionner un produit</option>
                @foreach($restaurant->products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }} - {{ number_format($product->price, 2) }} €</option>
                @endforeach
            </select>
        </div>
        <div class="w-24">
            <input type="number" name="items[][quantity]" min="1" value="1" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                   onchange="updateTotal()">
        </div>
        <div class="w-32">
            <input type="text" name="items[][price]" readonly
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-center">
        </div>
        <div class="w-32">
            <input type="text" name="items[][total]" readonly
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-center">
        </div>
        <button type="button" onclick="removeProductRow(this)" 
                class="text-red-600 hover:text-red-800">
            <i class="fas fa-trash"></i>
        </button>
    </div>
</template>

@endsection

@push('scripts')
<script>
let productRowCount = 0;

function addProductRow() {
    const template = document.getElementById('productRowTemplate');
    const productsList = document.getElementById('productsList');
    const clone = template.content.cloneNode(true);
    
    // Mettre à jour les noms des champs pour utiliser l'index
    const selects = clone.querySelectorAll('select, input');
    selects.forEach(select => {
        if (select.name) {
            select.name = select.name.replace('[]', `[${productRowCount}]`);
        }
    });
    
    productsList.appendChild(clone);
    productRowCount++;
}

function removeProductRow(button) {
    button.closest('.product-row').remove();
    updateTotal();
}

function updateProductPrice(select) {
    const row = select.closest('.product-row');
    const priceInput = row.querySelector('input[name*="[price]"]');
    const quantityInput = row.querySelector('input[name*="[quantity]"]');
    const totalInput = row.querySelector('input[name*="[total]"]');
    
    const option = select.selectedOptions[0];
    if (option.dataset.price) {
        const price = parseFloat(option.dataset.price);
        priceInput.value = price.toFixed(2);
        updateRowTotal(row);
        updateTotal();
    }
}

function updateRowTotal(row) {
    const priceInput = row.querySelector('input[name*="[price]"]');
    const quantityInput = row.querySelector('input[name*="[quantity]"]');
    const totalInput = row.querySelector('input[name*="[total]"]');
    
    const price = parseFloat(priceInput.value) || 0;
    const quantity = parseInt(quantityInput.value) || 0;
    const total = price * quantity;
    
    totalInput.value = total.toFixed(2);
}

function updateTotal() {
    let subtotal = 0;
    const totalInputs = document.querySelectorAll('input[name*="[total]"]');
    
    totalInputs.forEach(input => {
        subtotal += parseFloat(input.value) || 0;
    });
    
    const orderType = document.querySelector('input[name="order_type"]:checked').value;
    let deliveryFee = 0;
    
    if (orderType === 'delivery') {
        deliveryFee = 2.50; // Frais de livraison standard
    }
    
    const total = subtotal + deliveryFee;
    
    document.getElementById('subtotal').textContent = subtotal.toFixed(2) + ' €';
    document.getElementById('deliveryFee').textContent = deliveryFee.toFixed(2) + ' €';
    document.getElementById('total').textContent = total.toFixed(2) + ' €';
    document.getElementById('total_amount').value = total.toFixed(2);
}

// Ajouter une ligne de produit au chargement
document.addEventListener('DOMContentLoaded', function() {
    addProductRow();
    
    // Écouter les changements de type de commande
    document.querySelectorAll('input[name="order_type"]').forEach(radio => {
        radio.addEventListener('change', updateTotal);
    });
    
    // Écouter les changements de quantité
    document.addEventListener('change', function(e) {
        if (e.target.name && e.target.name.includes('[quantity]')) {
            updateRowTotal(e.target.closest('.product-row'));
            updateTotal();
        }
    });
});
</script>
@endpush 