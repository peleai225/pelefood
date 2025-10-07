@extends('layouts.public-restaurant')

@section('title', 'Finaliser votre commande - ' . $restaurant->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-orange-50 to-red-50 py-8 relative overflow-hidden">
    <!-- Éléments décoratifs de fond -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-orange-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-red-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float" style="animation-delay: -1.5s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-50 animate-float" style="animation-delay: -3s;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- En-tête amélioré -->
        <div class="mb-12">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-shopping-cart text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                                Finaliser votre commande
                            </h1>
                            <p class="text-gray-600 mt-2 text-lg">Vérifiez vos articles et complétez vos informations</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('restaurant.public.menu', $restaurant->slug) }}" 
                   class="group bg-white/80 backdrop-blur-sm border border-gray-200 text-gray-700 px-6 py-3 rounded-xl hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <i class="fas fa-arrow-left mr-2 group-hover:animate-bounce-gentle"></i>
                    Retour au menu
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Formulaire de commande -->
            <div class="xl:col-span-2 space-y-8">
                <!-- Informations client -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-500 to-red-500 px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <h2 class="text-xl font-bold text-white">Informations personnelles</h2>
                        </div>
                    </div>
                    
                    <form id="checkout-form" action="{{ route('restaurant.public.checkout.process', $restaurant->slug) }}" method="POST" class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="customer_name" class="block text-sm font-semibold text-gray-700">
                                    Nom complet <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <input type="text" id="customer_name" name="customer_name" required
                                           class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                                           placeholder="Votre nom complet">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label for="customer_phone" class="block text-sm font-semibold text-gray-700">
                                    Téléphone <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <i class="fas fa-phone absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <input type="tel" id="customer_phone" name="customer_phone" required
                                           class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                                           placeholder="Votre numéro de téléphone">
                                </div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label for="customer_email" class="block text-sm font-semibold text-gray-700">
                                Email <span class="text-gray-400">(optionnel)</span>
                            </label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="email" id="customer_email" name="customer_email"
                                       class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                                       placeholder="votre.email@exemple.com">
                            </div>
                        </div>
                        
                        <!-- Type de commande -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800">Type de commande</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label class="relative group">
                                    <input type="radio" name="delivery_type" value="delivery" class="sr-only" checked required>
                                    <div class="border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-orange-500 transition-all duration-300 bg-white/50 backdrop-blur-sm group-hover:shadow-lg group-hover:transform group-hover:-translate-y-1">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center group-hover:border-orange-500 transition-colors">
                                                <div class="w-2.5 h-2.5 bg-orange-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">Livraison</div>
                                                <div class="text-sm text-gray-600 flex items-center gap-1">
                                                    <i class="fas fa-truck text-orange-500"></i>
                                                    {{ $restaurant->formatPrice($restaurant->delivery_fee ?? 0) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative group">
                                    <input type="radio" name="delivery_type" value="pickup" class="sr-only">
                                    <div class="border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-orange-500 transition-all duration-300 bg-white/50 backdrop-blur-sm group-hover:shadow-lg group-hover:transform group-hover:-translate-y-1">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center group-hover:border-orange-500 transition-colors">
                                                <div class="w-2.5 h-2.5 bg-orange-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">À emporter</div>
                                                <div class="text-sm text-gray-600 flex items-center gap-1">
                                                    <i class="fas fa-shopping-bag text-green-500"></i>
                                                    Gratuit
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative group">
                                    <input type="radio" name="delivery_type" value="dine_in" class="sr-only">
                                    <div class="border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-orange-500 transition-all duration-300 bg-white/50 backdrop-blur-sm group-hover:shadow-lg group-hover:transform group-hover:-translate-y-1">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center group-hover:border-orange-500 transition-colors">
                                                <div class="w-2.5 h-2.5 bg-orange-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">Sur place</div>
                                                <div class="text-sm text-gray-600 flex items-center gap-1">
                                                    <i class="fas fa-utensils text-blue-500"></i>
                                                    Service en salle
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Section d'adresse -->
                        <div id="delivery-address-section" class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800">Adresse de livraison</h3>
                            <div class="space-y-2">
                                <label for="delivery_address" class="block text-sm font-semibold text-gray-700">
                                    Adresse complète <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <i class="fas fa-map-marker-alt absolute left-3 top-3 text-gray-400"></i>
                                    <textarea id="delivery_address" name="delivery_address" rows="3" required
                                              class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 bg-white/50 backdrop-blur-sm resize-none"
                                              placeholder="Ex: 123 Boulevard de la Corniche, Cocody, Abidjan"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Section informations de table (sur place) -->
                        <div id="dine-in-section" class="space-y-4" style="display: none;">
                            <h3 class="text-lg font-semibold text-gray-800">Informations de table</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="table_number" class="block text-sm font-semibold text-gray-700">
                                        Numéro de table <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <i class="fas fa-table absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        <input type="text" id="table_number" name="table_number" required
                                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                                               placeholder="Ex: Table 12, Table VIP, etc.">
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label for="number_of_guests" class="block text-sm font-semibold text-gray-700">
                                        Nombre de personnes <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <i class="fas fa-users absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        <input type="number" id="number_of_guests" name="number_of_guests" min="1" max="20" required
                                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                                               placeholder="Ex: 4">
                                    </div>
                                </div>
                            </div>
                            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                                    <div class="text-blue-800 text-sm">
                                        <strong>Information :</strong> Veuillez indiquer votre numéro de table et le nombre de personnes pour que nous puissions vous servir correctement.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Méthode de paiement -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800">Méthode de paiement</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="relative group">
                                    <input type="radio" name="payment_method" value="cash" class="sr-only" checked required>
                                    <div class="border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-orange-500 transition-all duration-300 bg-white/50 backdrop-blur-sm group-hover:shadow-lg group-hover:transform group-hover:-translate-y-1">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center group-hover:border-orange-500 transition-colors">
                                                <div class="w-2.5 h-2.5 bg-orange-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">Espèces</div>
                                                <div class="text-sm text-gray-600 flex items-center gap-1">
                                                    <i class="fas fa-money-bill-wave text-green-500"></i>
                                                    Paiement à la livraison
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                @foreach($paymentMethods as $method)
                                    <label class="relative group">
                                        <input type="radio" name="payment_method" value="{{ $method->provider }}" class="sr-only">
                                        <div class="border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-orange-500 transition-all duration-300 bg-white/50 backdrop-blur-sm group-hover:shadow-lg group-hover:transform group-hover:-translate-y-1">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center group-hover:border-orange-500 transition-colors">
                                                    <div class="w-2.5 h-2.5 bg-orange-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-gray-900">{{ ucfirst($method->provider) }}</div>
                                                    <div class="text-sm text-gray-600 flex items-center gap-1">
                                                        <i class="fas fa-mobile-alt text-blue-500"></i>
                                                        Paiement en ligne
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Instructions spéciales -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800">Instructions spéciales</h3>
                            <div class="space-y-2">
                                <label for="special_instructions" class="block text-sm font-semibold text-gray-700">
                                    Notes pour le restaurant <span class="text-gray-400">(optionnel)</span>
                                </label>
                                <div class="relative">
                                    <i class="fas fa-comment absolute left-3 top-3 text-gray-400"></i>
                                    <textarea id="special_instructions" name="special_instructions" rows="3"
                                              class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-300 bg-white/50 backdrop-blur-sm resize-none"
                                              placeholder="Ex: Livrer à l'entrée principale, appeler avant d'arriver, etc."></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Résumé de la commande -->
            <div class="xl:col-span-1">
                <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-100 p-6 sticky top-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-receipt text-white"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Résumé de votre commande</h2>
                    </div>
                    
                    <!-- Articles du panier -->
                    <div class="space-y-4 mb-6" x-show="$store.cart.getItemCount() > 0">
                        <template x-for="item in $store.cart" :key="item.id">
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-orange-50 rounded-xl border border-gray-100 hover:shadow-md transition-all duration-300">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900" x-text="item.name"></h4>
                                    <p class="text-sm text-gray-600 flex items-center gap-2" x-text="'Quantité: ' + item.quantity">
                                        <i class="fas fa-hashtag text-orange-500"></i>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-orange-600 text-lg" x-text="$store.formatPrice(item.price * item.quantity)"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                    
                    <!-- Panier vide -->
                    <div class="text-center py-8" x-show="$store.cart.getItemCount() === 0">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-shopping-cart text-3xl text-gray-300"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-600 mb-2">Votre panier est vide</h3>
                        <p class="text-gray-500 mb-6">Ajoutez des produits pour commencer votre commande</p>
                        <a href="{{ route('restaurant.public.menu', $restaurant->slug) }}" 
                           class="inline-block bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-3 rounded-xl hover:from-orange-600 hover:to-red-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="fas fa-utensils mr-2"></i>Parcourir le menu
                        </a>
                    </div>
                    
                    <!-- Résumé des coûts -->
                    <div class="space-y-4 border-t border-gray-200 pt-6" x-show="$store.cart.getItemCount() > 0">
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600 font-medium">Sous-total:</span>
                            <span class="font-semibold text-lg" x-text="$store.formatPrice($store.cart.getSubtotal())"></span>
                        </div>
                        <div class="flex justify-between items-center py-2" id="delivery-fee-row">
                            <span class="text-gray-600 font-medium">Livraison:</span>
                            <span class="font-semibold text-lg" id="delivery-fee-display" x-text="$store.formatPrice($store.cart.getDeliveryFee())"></span>
                        </div>
                        <div class="border-t border-gray-200 pt-4 flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-900">Total:</span>
                            <span class="text-2xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent" x-text="$store.formatPrice($store.cart.getTotal())"></span>
                        </div>
                    </div>
                    
                    <!-- Bouton de commande -->
                                        <button type="button" 
                             onclick="submitOrder()"
                             class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white py-4 rounded-xl font-bold hover:from-orange-600 hover:to-red-600 transition-all duration-300 mt-6 shadow-lg hover:shadow-xl transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                             x-show="$store.cart.getItemCount() > 0"
                             :disabled="$store.cart.getItemCount() === 0">
                        <i class="fas fa-credit-card mr-2"></i>Confirmer la commande
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Gestion des options de type de commande avec animations
document.querySelectorAll('input[name="delivery_type"]').forEach(input => {
    input.addEventListener('change', function() {
        // Retirer la sélection de tous les autres
        document.querySelectorAll('input[name="delivery_type"]').forEach(other => {
            if (other !== this) {
                other.closest('label').querySelector('.w-2\\.5').classList.remove('opacity-100');
                other.closest('label').querySelector('.w-2\\.5').classList.add('opacity-0');
            }
        });
        
        // Activer la sélection actuelle
        this.closest('label').querySelector('.w-2\\.5').classList.remove('opacity-0');
        this.closest('label').querySelector('.w-2\\.5').classList.add('opacity-100');
        
        const deliverySection = document.getElementById('delivery-address-section');
        const dineInSection = document.getElementById('dine-in-section');
        const addressField = document.getElementById('delivery_address');
        const tableNumberField = document.getElementById('table_number');
        const numberOfGuestsField = document.getElementById('number_of_guests');
        
        if (this.value === 'delivery') {
            deliverySection.style.display = 'block';
            deliverySection.style.animation = 'slideDown 0.3s ease-out';
            addressField.required = true;
            
            // Masquer la section sur place
            dineInSection.style.animation = 'slideUp 0.3s ease-out';
            setTimeout(() => {
                dineInSection.style.display = 'none';
            }, 300);
            tableNumberField.required = false;
            numberOfGuestsField.required = false;
        } else if (this.value === 'dine_in') {
            // Masquer la section livraison
            deliverySection.style.animation = 'slideUp 0.3s ease-out';
            setTimeout(() => {
                deliverySection.style.display = 'none';
            }, 300);
            addressField.required = false;
            
            // Afficher la section sur place
            dineInSection.style.display = 'block';
            dineInSection.style.animation = 'slideDown 0.3s ease-out';
            tableNumberField.required = true;
            numberOfGuestsField.required = true;
        } else {
            // Pour pickup, masquer les deux sections
            deliverySection.style.animation = 'slideUp 0.3s ease-out';
            setTimeout(() => {
                deliverySection.style.display = 'none';
            }, 300);
            addressField.required = false;
            
            dineInSection.style.animation = 'slideUp 0.3s ease-out';
            setTimeout(() => {
                dineInSection.style.display = 'none';
            }, 300);
            tableNumberField.required = false;
            numberOfGuestsField.required = false;
        }
        
        updateDeliveryFees();
    });
});

// Gestion des options de paiement avec animations
document.querySelectorAll('input[name="payment_method"]').forEach(input => {
    input.addEventListener('change', function() {
        // Retirer la sélection de tous les autres
        document.querySelectorAll('input[name="payment_method"]').forEach(other => {
            if (other !== this) {
                other.closest('label').querySelector('.w-2\\.5').classList.remove('opacity-100');
                other.closest('label').querySelector('.w-2\\.5').classList.add('opacity-0');
            }
        });
        
        // Activer la sélection actuelle
        this.closest('label').querySelector('.w-2\\.5').classList.remove('opacity-0');
        this.closest('label').querySelector('.w-2\\.5').classList.add('opacity-100');
    });
});

// Fonction pour mettre à jour les frais de livraison
function updateDeliveryFees() {
    const deliveryType = document.querySelector('input[name="delivery_type"]:checked').value;
    const deliveryFeeElement = document.getElementById('delivery-fee-display');
    
    if (deliveryFeeElement) {
        if (deliveryType === 'delivery') {
            const deliveryFee = {{ $restaurant->delivery_fee ?? 0 }};
            deliveryFeeElement.textContent = Alpine.store('formatPrice')(deliveryFee);
            deliveryFeeElement.parentElement.style.display = 'flex';
        } else {
            deliveryFeeElement.textContent = Alpine.store('formatPrice')(0);
            deliveryFeeElement.parentElement.style.display = 'none';
        }
    }
}

// Variable pour éviter les soumissions multiples
let isSubmitting = false;

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Attendre que Alpine.js soit initialisé et que le panier soit chargé
    setTimeout(() => {
        updateDeliveryFees();
        
        // Initialiser les sélections visuelles
        const selectedDeliveryType = document.querySelector('input[name="delivery_type"]:checked');
        if (selectedDeliveryType) {
            selectedDeliveryType.dispatchEvent(new Event('change'));
        }
        
        const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked');
        if (selectedPaymentMethod) {
            selectedPaymentMethod.dispatchEvent(new Event('change'));
        }
        
        // Forcer la mise à jour du panier
        if (Alpine.store('cart') && Alpine.store('cart').length > 0) {
            console.log('Panier chargé:', Alpine.store('cart'));
        }
    }, 100);
});

// Fonction pour soumettre le formulaire
function submitOrder() {
    const form = document.getElementById('checkout-form');
    const submitButton = document.querySelector('button[type="submit"]');
    
    if (isSubmitting) {
        console.log('Soumission déjà en cours...');
        return;
    }
    
    // Validation du panier
    const cart = Alpine.store('cart');
    if (cart.length === 0) {
        alert('Votre panier est vide. Veuillez ajouter des articles avant de passer la commande.');
        return;
    }
    
    // Validation du formulaire
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    // Désactiver le bouton et afficher le chargement
    isSubmitting = true;
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Traitement en cours...';
    }
    
    // Préparer les données du formulaire
    const formData = new FormData(form);
    
    // Ajouter les données du panier
    formData.append('cart_items', JSON.stringify(cart));
    formData.append('subtotal', cart.getSubtotal());
    formData.append('delivery_fee', cart.getDeliveryFee());
    formData.append('total', cart.getTotal());
    
    // Log des données envoyées
    console.log('Données envoyées:', {
        cart_items: cart,
        subtotal: cart.getSubtotal(),
        delivery_fee: cart.getDeliveryFee(),
        total: cart.getTotal(),
        form_data: Object.fromEntries(formData)
    });
    
    // Envoyer la requête
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        }
    })
    .then(response => {
        console.log('Réponse reçue:', response);
        
        if (response.redirected) {
            console.log('Redirection détectée vers:', response.url);
            window.location.href = response.url;
            return null;
        }
        
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json();
        } else {
            console.log('Réponse non-JSON détectée, redirection...');
            window.location.href = '{{ route("restaurant.public.checkout.success", $restaurant->slug) }}';
            return null;
        }
    })
    .then(data => {
        console.log('Données reçues:', data);
        
        if (data && data.success) {
            // Vider le panier
            Alpine.store('cart').clear();
            
            // Gérer la redirection selon le type de paiement
            if (data.payment_redirect && data.payment_link_url) {
                // Redirection vers le lien de paiement Wave
                console.log('Redirection vers le lien de paiement Wave:', data.payment_link_url);
                
                const messageDiv = document.createElement('div');
                messageDiv.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50';
                messageDiv.innerHTML = `
                    <div class="bg-white rounded-2xl p-8 max-w-md mx-4 text-center shadow-2xl">
                        <div class="mb-6">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-external-link-alt text-blue-600 text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Redirection vers Wave</h3>
                            <p class="text-gray-600">Vous allez être redirigé vers l'application Wave pour finaliser votre paiement.</p>
                        </div>
                        <div class="flex justify-center space-x-3">
                            <button onclick="window.location.href='${data.payment_link_url}'" class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                Continuer vers Wave
                            </button>
                            <button onclick="this.closest('.fixed').remove()" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-400 transition-all duration-300">
                                Annuler
                            </button>
                        </div>
                    </div>
                `;
                document.body.appendChild(messageDiv);
                
                // Redirection automatique après 3 secondes
                setTimeout(() => {
                    const wavePendingUrl = '{{ route("restaurant.public.checkout.wave-pending", $restaurant->slug) }}?order_number=' + data.order_number;
                    window.location.href = wavePendingUrl;
                }, 3000);
                
            } else {
                // Redirection normale vers la page de confirmation
                window.location.href = data.redirect_url || '{{ route("restaurant.public.checkout.success", $restaurant->slug) }}';
            }
        } else if (data && data.error) {
            // Afficher l'erreur
            alert('Erreur: ' + data.error);
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-credit-card mr-2"></i>Confirmer la commande';
            }
            isSubmitting = false;
        } else {
            // Redirection directe en cas de succès
            console.log('Redirection vers la page de succès...');
            window.location.href = '{{ route("restaurant.public.checkout.success", $restaurant->slug) }}';
        }
    })
    .catch(error => {
        console.error('Erreur lors de la soumission:', error);
        alert('Une erreur est survenue lors de la soumission de la commande. Veuillez réessayer.');
        
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-credit-card mr-2"></i>Confirmer la commande';
        }
        isSubmitting = false;
    });
}

// Ajouter les animations CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideUp {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-20px);
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush
@endsection 