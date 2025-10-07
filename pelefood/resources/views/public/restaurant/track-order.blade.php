@extends('layouts.public-restaurant')

@section('title', 'Suivi de commande #' . $order->order_number . ' - ' . $restaurant->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-orange-50 to-red-50 py-8 relative overflow-hidden">
    <!-- Éléments décoratifs de fond -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-orange-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-red-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float" style="animation-delay: -1.5s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-50 animate-float" style="animation-delay: -3s;"></div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- En-tête amélioré -->
        <div class="text-center mb-12">
            <div class="flex items-center justify-center gap-3 mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center shadow-xl">
                    <i class="fas fa-truck text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                        Suivi de votre commande
                    </h1>
                    <p class="text-xl text-gray-600 mt-2">Commande #{{ $order->order_number }}</p>
                    <p class="text-lg text-orange-600 font-semibold">{{ $restaurant->name }}</p>
                </div>
            </div>
        </div>

        <!-- Timeline du statut amélioré -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-100 p-8 mb-8" data-order-id="{{ $order->id }}">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-route text-white text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">État de votre commande</h2>
            </div>
            
            <div class="relative">
                <!-- Timeline -->
                <div class="absolute left-8 top-0 bottom-0 w-1 bg-gradient-to-b from-green-400 via-yellow-400 to-gray-300"></div>
                
                <!-- Étapes -->
                <div class="space-y-8">
                    <!-- Commande reçue -->
                    <div class="relative flex items-center group">
                        <div class="absolute left-6 w-6 h-6 bg-gradient-to-r from-green-400 to-green-600 rounded-full border-4 border-white shadow-lg transform group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="ml-20">
                            <div class="text-xl font-bold text-gray-900">Commande reçue</div>
                            <div class="text-gray-600 text-lg">{{ $order->created_at->format('d/m/Y à H:i') }}</div>
                            <div class="text-sm text-green-600 font-medium mt-1">✓ Confirmé</div>
                        </div>
                    </div>

                    <!-- Commande confirmée -->
                    @if(in_array($order->status, ['confirmed', 'preparing', 'ready', 'delivered']))
                    <div class="relative flex items-center group">
                        <div class="absolute left-6 w-6 h-6 bg-gradient-to-r from-green-400 to-green-600 rounded-full border-4 border-white shadow-lg transform group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="ml-20">
                            <div class="text-xl font-bold text-gray-900">Commande confirmée</div>
                            <div class="text-gray-600 text-lg">Votre commande a été confirmée par le restaurant</div>
                            <div class="text-sm text-green-600 font-medium mt-1">✓ Confirmé</div>
                        </div>
                    </div>
                    @else
                    <div class="relative flex items-center group opacity-50">
                        <div class="absolute left-6 w-6 h-6 bg-gray-300 rounded-full border-4 border-white transform group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="ml-20">
                            <div class="text-xl font-bold text-gray-500">Commande confirmée</div>
                            <div class="text-gray-400 text-lg">En attente de confirmation</div>
                            <div class="text-sm text-gray-400 font-medium mt-1">En attente...</div>
                        </div>
                    </div>
                    @endif

                    <!-- En préparation -->
                    @if(in_array($order->status, ['preparing', 'ready', 'delivered']))
                    <div class="relative flex items-center group">
                        <div class="absolute left-6 w-6 h-6 bg-gradient-to-r from-green-400 to-green-600 rounded-full border-4 border-white shadow-lg transform group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="ml-20">
                            <div class="text-xl font-bold text-gray-900">En préparation</div>
                            <div class="text-gray-600 text-lg">Votre commande est en cours de préparation</div>
                            <div class="text-sm text-green-600 font-medium mt-1">✓ En cours</div>
                        </div>
                    </div>
                    @else
                    <div class="relative flex items-center group opacity-50">
                        <div class="absolute left-6 w-6 h-6 bg-gray-300 rounded-full border-4 border-white transform group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="ml-20">
                            <div class="text-xl font-bold text-gray-500">En préparation</div>
                            <div class="text-gray-400 text-lg">En attente</div>
                            <div class="text-sm text-gray-400 font-medium mt-1">En attente...</div>
                        </div>
                    </div>
                    @endif

                    <!-- Prête -->
                    @if(in_array($order->status, ['ready', 'delivered']))
                    <div class="relative flex items-center group">
                        <div class="absolute left-6 w-6 h-6 bg-gradient-to-r from-green-400 to-green-600 rounded-full border-4 border-white shadow-lg transform group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="ml-20">
                            <div class="text-xl font-bold text-gray-900">Prête</div>
                            <div class="text-gray-600 text-lg">Votre commande est prête</div>
                            <div class="text-sm text-green-600 font-medium mt-1">✓ Prête</div>
                        </div>
                    </div>
                    @else
                    <div class="relative flex items-center group opacity-50">
                        <div class="absolute left-6 w-6 h-6 bg-gray-300 rounded-full border-4 border-white transform group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="ml-20">
                            <div class="text-xl font-bold text-gray-500">Prête</div>
                            <div class="text-gray-400 text-lg">En attente</div>
                            <div class="text-sm text-gray-400 font-medium mt-1">En attente...</div>
                        </div>
                    </div>
                    @endif

                    <!-- Livrée/Complétée -->
                    @if($order->status === 'delivered')
                    <div class="relative flex items-center group">
                        <div class="absolute left-6 w-6 h-6 bg-gradient-to-r from-green-400 to-green-600 rounded-full border-4 border-white shadow-lg transform group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="ml-20">
                            <div class="text-xl font-bold text-gray-900">
                                @if($order->type === 'delivery')
                                    Livrée
                                @elseif($order->type === 'pickup')
                                    Récupérée
                                @else
                                    Terminée
                                @endif
                            </div>
                            <div class="text-gray-600 text-lg">
                                @if($order->type === 'delivery')
                                    Votre commande a été livrée
                                @elseif($order->type === 'pickup')
                                    Votre commande a été récupérée
                                @else
                                    Votre repas est terminé
                                @endif
                            </div>
                            <div class="text-sm text-green-600 font-medium mt-1">✓ Terminé</div>
                        </div>
                    </div>
                    @elseif($order->status === 'cancelled')
                    <div class="relative flex items-center group">
                        <div class="absolute left-6 w-6 h-6 bg-gradient-to-r from-red-400 to-red-600 rounded-full border-4 border-white shadow-lg transform group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="ml-20">
                            <div class="text-xl font-bold text-red-900">Annulée</div>
                            <div class="text-red-600 text-lg">
                                @if($order->cancellation_reason)
                                    {{ $order->cancellation_reason }}
                                @else
                                    Votre commande a été annulée
                                @endif
                            </div>
                            <div class="text-sm text-red-600 font-medium mt-1">✗ Annulé</div>
                        </div>
                    </div>
                    @else
                    <div class="relative flex items-center group opacity-50">
                        <div class="absolute left-6 w-6 h-6 bg-gray-300 rounded-full border-4 border-white transform group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="ml-20">
                            <div class="text-xl font-bold text-gray-500">
                                @if($order->type === 'delivery')
                                    Livrée
                                @elseif($order->type === 'pickup')
                                    Récupérée
                                @else
                                    Terminée
                                @endif
                            </div>
                            <div class="text-gray-400 text-lg">En attente</div>
                            <div class="text-sm text-gray-400 font-medium mt-1">En attente...</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Détails de la commande améliorés -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-100 p-8 mb-8">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-receipt text-white text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Détails de votre commande</h2>
            </div>
            
            <!-- Informations générales -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-6 rounded-xl border border-blue-200">
                    <div class="text-sm font-semibold text-blue-600 mb-2">Type de commande</div>
                    <div class="text-xl text-blue-900 font-bold">
                        @if($order->type === 'delivery')
                            <i class="fas fa-truck mr-2"></i> Livraison
                        @elseif($order->type === 'pickup')
                            <i class="fas fa-hand-holding-usd mr-2"></i> À emporter
                        @else
                            <i class="fas fa-utensils mr-2"></i> Sur place
                        @endif
                    </div>
                </div>
                <div class="bg-gradient-to-r from-green-50 to-green-100 p-6 rounded-xl border border-green-200">
                    <div class="text-sm font-semibold text-green-600 mb-2">Méthode de paiement</div>
                    <div class="text-xl text-green-900 font-bold">
                        @if($order->payment_method === 'cash')
                            <i class="fas fa-money-bill-wave mr-2"></i> Espèces
                        @elseif($order->payment_method === 'card')
                            <i class="fas fa-credit-card mr-2"></i> Carte
                        @else
                            <i class="fas fa-mobile-alt mr-2"></i> {{ ucfirst($order->payment_method) }}
                        @endif
                    </div>
                </div>
                @if($order->type === 'delivery')
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-6 rounded-xl border border-purple-200">
                    <div class="text-sm font-semibold text-purple-600 mb-2">Adresse de livraison</div>
                    <div class="text-lg text-purple-900">
                        @php
                            $deliveryAddress = json_decode($order->delivery_address, true);
                        @endphp
                        {{ $deliveryAddress['address'] ?? 'Non spécifiée' }}
                    </div>
                </div>
                @endif
                @if($order->type === 'dine_in')
                <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 p-6 rounded-xl border border-yellow-200">
                    <div class="text-sm font-semibold text-yellow-600 mb-2">Table</div>
                    <div class="text-xl text-yellow-900 font-bold">
                        @php
                            $customerInfo = json_decode($order->customer_info, true);
                        @endphp
                        Table {{ $customerInfo['table_number'] ?? 'Non spécifiée' }} 
                        <div class="text-lg text-yellow-700">({{ $customerInfo['number_of_guests'] ?? '?' }} personne(s))</div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Articles commandés -->
            <div class="border-t border-gray-200 pt-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-red-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-utensils text-white text-sm"></i>
                    </div>
                    Articles commandés
                </h3>
                
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="bg-gradient-to-r from-gray-50 to-orange-50 border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-utensils text-white text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-xl font-bold text-gray-900">{{ $item->product_name }}</div>
                                    <div class="text-lg text-gray-600 font-medium">
                                        Quantité: {{ $item->quantity }} × {{ $restaurant->formatPrice($item->unit_price) }}
                                    </div>
                                    @if($item->special_instructions)
                                    <div class="text-blue-600 mt-2 font-medium">
                                        <i class="fas fa-info-circle mr-1"></i> {{ $item->special_instructions }}
                                    </div>
                                    @endif
                                    @if($item->options)
                                    <div class="mt-3">
                                        @php
                                            $options = json_decode($item->options, true);
                                        @endphp
                                        @if($options && count($options) > 0)
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($options as $optionName => $optionValue)
                                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                                        {{ $optionName }}: {{ $optionValue }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-orange-600">{{ $restaurant->formatPrice($item->total_price) }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Résumé financier -->
            <div class="border-t border-gray-200 pt-8 mt-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calculator text-white text-sm"></i>
                    </div>
                    Résumé financier
                </h3>
                
                <div class="bg-gradient-to-r from-gray-50 to-green-50 border border-gray-200 rounded-xl p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg text-gray-600">Sous-total</span>
                            <span class="text-lg font-bold text-gray-900">{{ number_format($order->subtotal ?? 0, 0, ',', ' ') }} FCFA</span>
                        </div>
                        @if(($order->delivery_fee ?? 0) > 0)
                        <div class="flex justify-between items-center">
                            <span class="text-lg text-gray-600">Frais de livraison</span>
                            <span class="text-lg font-bold text-gray-900">{{ number_format($order->delivery_fee ?? 0, 0, ',', ' ') }} FCFA</span>
                        </div>
                        @endif
                        @if(($order->tax_amount ?? 0) > 0)
                        <div class="flex justify-between items-center">
                            <span class="text-lg text-gray-600">Taxes</span>
                            <span class="text-lg font-bold text-gray-900">{{ number_format($order->tax_amount ?? 0, 0, ',', ' ') }} FCFA</span>
                        </div>
                        @endif
                        @if(($order->discount_amount ?? 0) > 0)
                        <div class="flex justify-between items-center">
                            <span class="text-lg text-gray-600">Remise</span>
                            <span class="text-lg font-bold text-green-600">-{{ number_format($order->discount_amount ?? 0, 0, ',', ' ') }} FCFA</span>
                        </div>
                        @endif
                        <div class="border-t-2 border-gray-300 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-gray-900">Total</span>
                                <span class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">{{ number_format($order->total_amount ?? 0, 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instructions spéciales -->
            @if($order->special_instructions)
            <div class="border-t border-gray-200 pt-8 mt-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                    </div>
                    Instructions spéciales
                </h3>
                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-200 rounded-xl p-6">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-3 text-xl"></i>
                        <div class="text-yellow-800 text-lg font-medium">{{ $order->special_instructions }}</div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Section avis après livraison -->
        @if($order->status === 'delivered' || $order->status === 'completed')
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-100 p-8 mb-8">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-star text-white text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Partagez votre expérience</h2>
            </div>
            
            <div class="bg-gradient-to-r from-yellow-50 via-orange-50 to-red-50 border-2 border-yellow-200 rounded-xl p-8">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-star text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Comment était votre commande ?</h3>
                    <p class="text-gray-600 text-lg">Votre avis aide le restaurant à s'améliorer et guide les autres clients</p>
                </div>
                
                <div class="flex flex-col sm:flex-row justify-center gap-4 mb-6">
                    <a href="{{ route('restaurant.public.reviews', $restaurant->slug) }}?order={{ $order->order_number }}" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold rounded-xl hover:from-orange-600 hover:to-red-600 transition-all duration-300 shadow-lg transform hover:-translate-y-1">
                        <i class="fas fa-star mr-3"></i>
                        Laisser un avis
                    </a>
                    
                    <a href="{{ route('restaurant.public.menu', $restaurant->slug) }}" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-white border-2 border-orange-500 text-orange-600 font-bold rounded-xl hover:bg-orange-50 transition-all duration-300 shadow-lg transform hover:-translate-y-1">
                        <i class="fas fa-utensils mr-3"></i>
                        Commander à nouveau
                    </a>
                </div>
                
                <div class="text-center text-gray-500">
                    <p>Vous pouvez laisser votre avis maintenant ou plus tard</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Contact et actions améliorés -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-100 p-8 mb-8">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-headset text-white text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Besoin d'aide ?</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                            <i class="fas fa-phone text-white text-xl"></i>
                        </div>
                        <div>
                            <div class="font-bold text-blue-900 text-lg mb-2">Appelez le restaurant</div>
                            <div class="text-blue-800 text-lg mb-4">
                                <a href="tel:{{ $restaurant->phone }}" class="hover:underline font-semibold">
                                    {{ $restaurant->phone }}
                                </a>
                            </div>
                            <div class="text-blue-700 text-sm">Appelez directement pour toute question</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-green-50 to-green-100 border-2 border-green-200 rounded-xl p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                            <i class="fas fa-utensils text-white text-xl"></i>
                        </div>
                        <div>
                            <div class="font-bold text-green-900 text-lg mb-2">Voir le menu</div>
                            <div class="text-green-800 text-lg mb-4">
                                <a href="{{ route('restaurant.public.menu', $restaurant->slug) }}" class="hover:underline font-semibold">
                                    Commander à nouveau
                                </a>
                            </div>
                            <div class="text-green-700 text-sm">Découvrez nos autres plats</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Auto-refresh amélioré -->
        @if(!in_array($order->status, ['delivered', 'completed', 'cancelled']))
        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-200 rounded-xl p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                    <i class="fas fa-sync-alt text-white text-xl animate-spin"></i>
                </div>
                <div class="text-yellow-800">
                    <div class="font-bold text-lg">Mise à jour automatique</div>
                    <div class="text-yellow-700">Cette page se met à jour automatiquement toutes les 10 secondes</div>
                </div>
            </div>
        </div>
        @endif

        <!-- Actions principales -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
            <a href="{{ route('restaurant.public.home', $restaurant->slug) }}" 
               class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold rounded-xl hover:from-orange-600 hover:to-red-600 transition-all duration-300 shadow-lg transform hover:-translate-y-1">
                <i class="fas fa-home mr-3"></i>
                Retour à l'accueil
            </a>
            
            <a href="{{ route('restaurant.public.menu', $restaurant->slug) }}" 
               class="inline-flex items-center justify-center px-8 py-4 bg-white border-2 border-orange-500 text-orange-600 font-bold rounded-xl hover:bg-orange-50 transition-all duration-300 shadow-lg transform hover:-translate-y-1">
                <i class="fas fa-utensils mr-3"></i>
                Commander à nouveau
            </a>
        </div>
    </div>
</div>

@if(!in_array($order->status, ['delivered', 'completed', 'cancelled']))
@push('scripts')
<script>
// Auto-refresh toutes les 10 secondes avec animation
setInterval(function() {
    // Ajouter une animation de fade out
    document.body.style.opacity = '0.8';
    document.body.style.transition = 'opacity 0.3s ease';
    
    setTimeout(function() {
        location.reload();
    }, 300);
}, 10000);

// Animation d'entrée
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.group');
    elements.forEach((element, index) => {
        setTimeout(() => {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endpush
@endif

@push('styles')
<style>
.group {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease-out;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-20px);
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
</style>
@endpush
@endsection 