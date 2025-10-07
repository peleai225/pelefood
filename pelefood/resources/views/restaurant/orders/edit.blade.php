@extends('layouts.restaurant')

@section('title', 'Modifier la commande #' . $order->order_number)
@section('page-title', 'Modifier la commande')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Modifier la commande #{{ $order->order_number }}</h1>
                <p class="text-gray-600 mt-1">Créée le {{ $order->created_at->format('d/m/Y à H:i') }}</p>
            </div>
            <a href="{{ route('restaurant.orders.show', $order) }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
    </div>

    <!-- Formulaire d'édition -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('restaurant.orders.update', $order) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Informations client -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900">Informations client</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nom complet *
                        </label>
                        <input type="text" id="customer_name" name="customer_name" 
                               value="{{ old('customer_name', $order->customer_name) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        @error('customer_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Téléphone *
                        </label>
                        <input type="tel" id="customer_phone" name="customer_phone" 
                               value="{{ old('customer_phone', $order->customer_phone) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        @error('customer_phone')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input type="email" id="customer_email" name="customer_email" 
                           value="{{ old('customer_email', $order->customer_email) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    @error('customer_email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Informations de livraison -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900">Informations de livraison</h3>
                
                <div>
                    <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse de livraison
                        @if($order->type === 'delivery')
                            <span class="text-red-500">*</span>
                        @endif
                    </label>
                    <textarea id="delivery_address" name="delivery_address" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                              @if($order->type === 'delivery') required @endif>{{ old('delivery_address', $order->delivery_address) }}</textarea>
                    @error('delivery_address')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="estimated_delivery_time" class="block text-sm font-medium text-gray-700 mb-2">
                        Heure de livraison estimée
                    </label>
                    <input type="datetime-local" id="estimated_delivery_time" name="estimated_delivery_time" 
                           value="{{ old('estimated_delivery_time', $order->estimated_delivery_time ? $order->estimated_delivery_time->format('Y-m-d\TH:i') : '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    @error('estimated_delivery_time')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Instructions spéciales -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900">Instructions spéciales</h3>
                
                <div>
                    <label for="special_instructions" class="block text-sm font-medium text-gray-700 mb-2">
                        Instructions spéciales
                    </label>
                    <textarea id="special_instructions" name="special_instructions" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">{{ old('special_instructions', $order->special_instructions) }}</textarea>
                    @error('special_instructions')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Résumé de la commande -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900">Résumé de la commande</h3>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Type de commande:</span>
                            <span class="font-medium">{{ ucfirst($order->type) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Statut:</span>
                            <span class="font-medium">{{ ucfirst($order->status) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Méthode de paiement:</span>
                            <span class="font-medium">{{ ucfirst($order->payment_method) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sous-total:</span>
                            <span class="font-medium">{{ number_format($order->subtotal ?? 0, 0, ',', ' ') }} FCFA</span>
                        </div>
                        @if(($order->delivery_fee ?? 0) > 0)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Frais de livraison:</span>
                            <span class="font-medium">{{ number_format($order->delivery_fee ?? 0, 0, ',', ' ') }} FCFA</span>
                        </div>
                        @endif
                        <div class="flex justify-between text-lg font-bold text-gray-900 border-t pt-2">
                            <span>Total:</span>
                            <span>{{ number_format($order->total_amount ?? 0, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Articles de la commande -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900">Articles de la commande</h3>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                        <div class="flex justify-between items-center py-2 border-b border-gray-200 last:border-b-0">
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">{{ $item->product_name }}</div>
                                @if($item->special_instructions)
                                    <div class="text-sm text-gray-600">{{ $item->special_instructions }}</div>
                                @endif
                                @if($item->options)
                                    <div class="text-sm text-gray-500">
                                        @foreach($item->options as $group => $selections)
                                            {{ $group }}: {{ is_array($selections) ? implode(', ', $selections) : $selections }}
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="text-right">
                                                        <div class="text-sm text-gray-600">{{ $item->quantity }} × {{ $restaurant->formatPrice($item->unit_price ?? 0) }}</div>
                        <div class="font-medium">{{ $restaurant->formatPrice($item->total_price ?? 0) }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('restaurant.orders.show', $order) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    Annuler
                </a>
                <button type="submit" 
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 