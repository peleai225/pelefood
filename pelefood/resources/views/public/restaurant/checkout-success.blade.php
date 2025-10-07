@extends('layouts.public-restaurant', ['restaurant' => $restaurant])

@section('title', 'Commande confirmée - ' . $restaurant->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-orange-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête de succès avec animation -->
        <div class="text-center mb-12">
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-gradient-to-r from-green-400 to-green-600 mb-8 animate-bounce">
                <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-5xl font-bold text-gray-900 mb-4 animate-fade-in">
                🎉 Commande confirmée !
            </h1>
            <p class="text-xl text-gray-600 mb-2">Votre commande a été enregistrée avec succès</p>
            <p class="text-lg text-orange-600 font-semibold">Merci de votre confiance !</p>
        </div>

        <!-- Lien de suivi principal - MISE EN AVANT -->
        <div class="bg-gradient-to-r from-red-500 via-orange-500 to-red-600 rounded-2xl shadow-2xl border-4 border-red-300 p-8 mb-8 transform hover:scale-105 transition-all duration-300 animate-pulse">
            <div class="text-center">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-link text-white text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-white mb-2">🔗 Votre lien de suivi</h2>
                        <p class="text-white text-xl opacity-90">Cliquez ici pour suivre votre commande en temps réel</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-6 mb-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="text-sm text-gray-600 mb-1">Lien de suivi de votre commande :</div>
                                                         <div class="font-mono text-lg text-gray-800 break-all">
                                 {{ url('/restaurant/' . $restaurant->slug . '/track/' . session('order_number')) }}
                             </div>
                        </div>
                        <button onclick="copyTrackingLink()" 
                                class="ml-4 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors duration-200 flex items-center">
                            <i class="fas fa-copy mr-2"></i>
                            Copier
                        </button>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                         <a href="{{ url('/restaurant/' . $restaurant->slug . '/track/' . session('order_number')) }}"
                        class="inline-flex items-center justify-center bg-white text-red-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-200 shadow-lg transform hover:-translate-y-1">
                        <i class="fas fa-eye mr-3 text-xl"></i>
                        Suivre ma commande maintenant
                    </a>
                    
                    <button onclick="shareTrackingLink()" 
                            class="inline-flex items-center justify-center bg-white bg-opacity-20 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-opacity-30 transition-all duration-200 shadow-lg transform hover:-translate-y-1">
                        <i class="fas fa-share-alt mr-3 text-xl"></i>
                        Partager le lien
                    </button>
                </div>
                
                <div class="mt-6 text-white text-center">
                    <div class="flex items-center justify-center gap-4 text-sm">
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            <span>Suivi en temps réel</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-bell mr-2"></i>
                            <span>Notifications automatiques</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations de la commande -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-100 p-8 mb-8 transform hover:scale-105 transition-transform duration-300">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-receipt text-white text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Détails de votre commande</h2>
            </div>
            
            @if(session('order_number') || session('order_id'))
            <div class="space-y-8">
                <!-- Informations générales -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gradient-to-r from-orange-50 to-orange-100 p-6 rounded-xl border border-orange-200">
                        <div class="text-sm text-orange-600 mb-2 font-medium">Numéro de commande</div>
                        <div class="font-bold text-3xl text-orange-800">#{{ session('order_number') ?? session('order_id') }}</div>
                    </div>
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-6 rounded-xl border border-blue-200">
                        <div class="text-sm text-blue-600 mb-2 font-medium">Date de commande</div>
                        <div class="font-semibold text-2xl text-blue-800">{{ now()->format('d/m/Y à H:i') }}</div>
                    </div>
                </div>
                
                <!-- Statut actuel -->
                <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200 p-6 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-clock text-white text-lg"></i>
                        </div>
                        <div>
                            <div class="font-bold text-yellow-800 text-xl">Statut actuel</div>
                            <div class="text-yellow-700 text-lg">En attente de confirmation par le restaurant</div>
                        </div>
                    </div>
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
                        @php
                            // Récupérer les articles du panier depuis la session
                            $cartItems = session('cart_items', []);
                            $subtotal = session('subtotal', 0);
                            $deliveryFee = session('delivery_fee', 0);
                            $total = session('total', 0);
                        @endphp
                        
                        @if(!empty($cartItems))
                            @foreach($cartItems as $item)
                            <div class="bg-gradient-to-r from-gray-50 to-orange-50 border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                                            <i class="fas fa-utensils text-white text-xl"></i>
                                        </div>
                                        <div>
                                            <div class="text-xl font-bold text-gray-900">{{ $item['name'] ?? 'Produit' }}</div>
                                            <div class="text-lg text-gray-600 font-medium">
                                                Quantité: {{ $item['quantity'] ?? 1 }} × {{ number_format($item['price'] ?? 0, 0, ',', ' ') }} FCFA
                                            </div>
                                            @if(isset($item['specialInstructions']) && $item['specialInstructions'])
                                            <div class="text-blue-600 mt-2 font-medium">
                                                <i class="fas fa-info-circle mr-1"></i> {{ $item['specialInstructions'] }}
                                            </div>
                                            @endif
                                            @if(isset($item['options']) && !empty($item['options']))
                                            <div class="mt-3">
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($item['options'] as $optionName => $optionValue)
                                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                                            {{ $optionName }}: {{ $optionValue }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold text-orange-600">{{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 0, ',', ' ') }} FCFA</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 text-center">
                                <div class="text-gray-500 text-lg">Aucun article disponible</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Informations de livraison et paiement -->
                <div class="border-t border-gray-200 pt-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-info-circle text-white text-sm"></i>
                        </div>
                        Informations de livraison et paiement
                    </h3>
                    
                    @php
                        $deliveryType = session('delivery_type', 'pickup');
                        $paymentMethod = session('payment_method', 'cash');
                    @endphp
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-6 rounded-xl border border-purple-200">
                            <div class="text-sm font-semibold text-purple-600 mb-2">Type de commande</div>
                            <div class="text-xl text-purple-900 font-bold">
                                @if($deliveryType === 'delivery')
                                    <i class="fas fa-truck mr-2"></i> Livraison
                                @elseif($deliveryType === 'pickup')
                                    <i class="fas fa-hand-holding-usd mr-2"></i> À emporter
                                @else
                                    <i class="fas fa-utensils mr-2"></i> Sur place
                                @endif
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-r from-green-50 to-green-100 p-6 rounded-xl border border-green-200">
                            <div class="text-sm font-semibold text-green-600 mb-2">Méthode de paiement</div>
                            <div class="text-xl text-green-900 font-bold">
                                @if($paymentMethod === 'cash')
                                    <i class="fas fa-money-bill-wave mr-2"></i> Espèces
                                @elseif($paymentMethod === 'card')
                                    <i class="fas fa-credit-card mr-2"></i> Carte
                                @else
                                    <i class="fas fa-mobile-alt mr-2"></i> {{ ucfirst($paymentMethod) }}
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Informations spécifiques selon le type de commande -->
                    @if($deliveryType === 'delivery')
                        <!-- Informations de livraison -->
                        <div class="mt-6">
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-6 rounded-xl border border-blue-200">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-4">
                                        <i class="fas fa-map-marker-alt text-white"></i>
                                    </div>
                                    <div>
                                        <div class="text-lg font-bold text-blue-900">Adresse de livraison</div>
                                        <div class="text-blue-700">Votre commande sera livrée à l'adresse spécifiée</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($deliveryType === 'dine_in')
                        <!-- Informations pour commande sur place -->
                        <div class="mt-6">
                            <div class="bg-gradient-to-r from-orange-50 to-orange-100 p-6 rounded-xl border border-orange-200">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center mr-4">
                                        <i class="fas fa-chair text-white"></i>
                                    </div>
                                    <div>
                                        <div class="text-lg font-bold text-orange-900">Informations de table</div>
                                        <div class="text-orange-700">Votre commande sera servie à votre table</div>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    @php
                                        // Récupérer les informations de table depuis la session ou les données de commande
                                        $tableNumber = session('table_number') ?? 'Non spécifié';
                                        $numberOfGuests = session('number_of_guests') ?? 'Non spécifié';
                                    @endphp
                                    
                                    <div class="bg-white bg-opacity-50 p-4 rounded-lg border border-orange-200">
                                        <div class="flex items-center">
                                            <i class="fas fa-table text-orange-600 mr-3 text-lg"></i>
                                            <div>
                                                <div class="text-sm font-semibold text-orange-700">Numéro de table</div>
                                                <div class="text-xl font-bold text-orange-900">{{ $tableNumber }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-white bg-opacity-50 p-4 rounded-lg border border-orange-200">
                                        <div class="flex items-center">
                                            <i class="fas fa-users text-orange-600 mr-3 text-lg"></i>
                                            <div>
                                                <div class="text-sm font-semibold text-orange-700">Nombre de personnes</div>
                                                <div class="text-xl font-bold text-orange-900">{{ $numberOfGuests }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-4 p-4 bg-orange-200 bg-opacity-50 rounded-lg border border-orange-300">
                                    <div class="flex items-start">
                                        <i class="fas fa-info-circle text-orange-600 mt-1 mr-3"></i>
                                        <div class="text-orange-800 text-sm">
                                            <strong>Important :</strong> Veuillez vous présenter à votre table pour confirmer votre commande. 
                                            Le personnel vous servira directement à votre table.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($deliveryType === 'pickup')
                        <!-- Informations pour commande à emporter -->
                        <div class="mt-6">
                            <div class="bg-gradient-to-r from-green-50 to-green-100 p-6 rounded-xl border border-green-200">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-4">
                                        <i class="fas fa-store text-white"></i>
                                    </div>
                                    <div>
                                        <div class="text-lg font-bold text-green-900">Récupération en restaurant</div>
                                        <div class="text-green-700">Votre commande sera prête à récupérer au restaurant</div>
                                    </div>
                                </div>
                                
                                <div class="mt-4 p-4 bg-green-200 bg-opacity-50 rounded-lg border border-green-300">
                                    <div class="flex items-start">
                                        <i class="fas fa-info-circle text-green-600 mt-1 mr-3"></i>
                                        <div class="text-green-800 text-sm">
                                            <strong>Important :</strong> Présentez-vous au comptoir avec votre numéro de commande 
                                            <strong>#{{ session('order_number') ?? session('order_id') }}</strong> pour récupérer votre commande.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Instructions spéciales -->
                @php
                    $specialInstructions = session('special_instructions');
                @endphp
                @if($specialInstructions)
                <div class="border-t border-gray-200 pt-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                        </div>
                        Instructions spéciales
                    </h3>
                    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-200 rounded-xl p-6">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-3 text-xl"></i>
                            <div class="text-yellow-800 text-lg font-medium">{{ $specialInstructions }}</div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Résumé financier -->
                <div class="border-t border-gray-200 pt-8">
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
                                <span class="text-lg font-bold text-gray-900">{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
                            </div>
                            @if($deliveryFee > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-lg text-gray-600">Frais de livraison</span>
                                <span class="text-lg font-bold text-gray-900">{{ number_format($deliveryFee, 0, ',', ' ') }} FCFA</span>
                            </div>
                            @endif
                            <div class="border-t-2 border-gray-300 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-2xl font-bold text-gray-900">Total</span>
                                    <span class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Section QR Code de suivi -->
        @if(session('order_number'))
        <div class="bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl shadow-xl border border-purple-200 p-8 mb-8">
            <div class="text-center">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-qrcode text-white text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-white mb-2">📱 QR Code de suivi</h2>
                        <p class="text-white text-xl opacity-90">Scannez avec votre téléphone pour suivre votre commande</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-8 inline-block shadow-2xl mb-6">
                    <div id="qrcode-tracking" class="flex justify-center items-center min-h-[200px]">
                        <div class="text-gray-500 text-center">
                            <i class="fas fa-spinner fa-spin text-3xl mb-2"></i>
                            <p class="text-sm font-medium">Génération du QR code...</p>
                        </div>
                    </div>
                </div>
                
                <div class="text-white text-center">
                    <div class="flex items-center justify-center gap-4 text-sm">
                        <div class="flex items-center">
                            <i class="fas fa-mobile-alt mr-2"></i>
                            <span>Ouvrez l'appareil photo</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-qrcode mr-2"></i>
                            <span>Pointez vers le QR code</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-link mr-2"></i>
                            <span>Suivez le lien</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Lien direct vers le suivi de commande -->
        @if(session('order_number'))
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl shadow-xl border border-blue-200 p-8 mb-8">
            <div class="text-center">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-eye text-white text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-white mb-2">👁️ Suivi de votre commande</h2>
                        <p class="text-white text-xl opacity-90">Accédez directement au suivi en temps réel</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-6 mb-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="text-sm text-gray-600 mb-1">Lien direct vers le suivi :</div>
                            <div class="font-mono text-lg text-gray-800 break-all">
                                {{ url('/restaurant/' . $restaurant->slug . '/track/' . session('order_number')) }}
                            </div>
                        </div>
                        <button onclick="copyTrackingLink()" 
                                class="ml-4 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-200 flex items-center">
                            <i class="fas fa-copy mr-2"></i>
                            Copier
                        </button>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('restaurant.public.track.order', ['slug' => $restaurant->slug, 'order_number' => session('order_number')]) }}"
                       class="inline-flex items-center justify-center bg-white text-blue-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-200 shadow-lg transform hover:-translate-y-1">
                        <i class="fas fa-eye mr-3 text-xl"></i>
                        Voir le suivi maintenant
                    </a>
                    
                    <button onclick="shareTrackingLink()" 
                            class="inline-flex items-center justify-center bg-white bg-opacity-20 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-opacity-30 transition-all duration-200 shadow-lg transform hover:-translate-y-1">
                        <i class="fas fa-share-alt mr-3 text-xl"></i>
                        Partager le lien
                    </button>
                </div>
                
                <div class="mt-6 text-white text-center">
                    <div class="flex items-center justify-center gap-4 text-sm">
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            <span>Suivi en temps réel</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-bell mr-2"></i>
                            <span>Notifications automatiques</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Section Lien de suivi - MISE EN AVANT -->
        @if(session('order_number'))
        <div class="bg-gradient-to-r from-orange-500 via-red-500 to-orange-600 rounded-2xl shadow-2xl border-4 border-orange-300 p-8 mb-8 transform hover:scale-105 transition-all duration-300 animate-pulse">
            <div class="text-center">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-link text-white text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-white mb-2">🔗 Votre lien de suivi</h2>
                        <p class="text-white text-xl opacity-90">Conservez ce lien pour suivre votre commande</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-6 mb-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="text-sm text-gray-600 mb-1">Lien de suivi de votre commande :</div>
                            <div class="font-mono text-lg text-gray-800 break-all">
                                {{ url('/restaurant/' . $restaurant->slug . '/track/' . session('order_number')) }}
                            </div>
                        </div>
                        <button onclick="copyTrackingLink()" 
                                class="ml-4 bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors duration-200 flex items-center">
                            <i class="fas fa-copy mr-2"></i>
                            Copier
                        </button>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('restaurant.public.track.order', ['slug' => $restaurant->slug, 'order_number' => session('order_number')]) }}"
                       class="inline-flex items-center justify-center bg-white text-orange-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-200 shadow-lg transform hover:-translate-y-1">
                        <i class="fas fa-eye mr-3 text-xl"></i>
                        Suivre ma commande maintenant
                    </a>
                    
                    <button onclick="shareTrackingLink()" 
                            class="inline-flex items-center justify-center bg-white bg-opacity-20 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-opacity-30 transition-all duration-200 shadow-lg transform hover:-translate-y-1">
                        <i class="fas fa-share-alt mr-3 text-xl"></i>
                        Partager le lien
                    </button>
                </div>
                
                <div class="mt-6 text-white text-center">
                    <div class="flex items-center justify-center gap-4 text-sm">
                        <div class="flex items-center">
                            <i class="fas fa-mobile-alt mr-2"></i>
                            <span>Scannez le QR code ci-dessus</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-link mr-2"></i>
                            <span>Ou cliquez sur le bouton</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Contact restaurant -->
        @if($restaurant->phone)
        <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-2xl p-8 text-white shadow-xl transform hover:scale-105 transition-transform duration-300 mb-8">
            <div class="text-center">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-phone text-white text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-white mb-2">📞 Contacter le restaurant</h2>
                        <p class="text-white text-xl opacity-90">Besoin d'aide ? Contactez directement le restaurant</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-6 mb-6 shadow-lg">
                    <div class="flex items-center justify-center">
                        <div class="flex-1 text-center">
                            <div class="text-sm text-gray-600 mb-1">Téléphone du restaurant :</div>
                            <div class="font-bold text-2xl text-gray-800">{{ $restaurant->phone }}</div>
                        </div>
                    </div>
                </div>
                
                <a href="tel:{{ $restaurant->phone }}" 
                   class="inline-flex items-center justify-center bg-white text-green-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-200 shadow-lg transform hover:-translate-y-1">
                    <i class="fas fa-phone mr-3 text-xl"></i>
                    Appeler maintenant
                </a>
            </div>
        </div>
        @endif

        <!-- Actions secondaires -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
            <a href="{{ route('restaurant.public.home', $restaurant->slug) }}" 
               class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-xl text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 transition-all duration-200 shadow-lg transform hover:scale-105">
                <i class="fas fa-home mr-3"></i>
                Retour à l'accueil
            </a>
            
            <a href="{{ route('restaurant.public.menu', $restaurant->slug) }}" 
               class="inline-flex items-center justify-center px-8 py-4 border-2 border-orange-500 text-lg font-bold rounded-xl text-orange-600 bg-white hover:bg-orange-50 transition-all duration-200 shadow-lg transform hover:scale-105">
                <i class="fas fa-utensils mr-3"></i>
                Commander à nouveau
            </a>
        </div>

        <!-- Instructions pour le suivi -->
        <div class="bg-gradient-to-r from-green-50 to-green-100 border-2 border-green-200 rounded-2xl p-8 shadow-lg mb-8">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-map-marker-alt text-white text-xl"></i>
                    </div>
                </div>
                <div class="ml-6">
                    <h3 class="text-2xl font-bold text-green-900 mb-4">Comment suivre votre commande</h3>
                    <div class="text-green-800 space-y-4 text-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white bg-opacity-50 p-4 rounded-lg border border-green-200">
                                <div class="flex items-center mb-3">
                                    <i class="fas fa-mobile-alt text-green-600 mr-3 text-xl"></i>
                                    <span class="font-bold">Sur mobile</span>
                                </div>
                                <ul class="space-y-2 text-sm">
                                    <li>• Scannez le QR code ci-dessus</li>
                                    <li>• Ou copiez le lien et ouvrez-le</li>
                                    <li>• Ajoutez la page à vos favoris</li>
                                </ul>
                            </div>
                            <div class="bg-white bg-opacity-50 p-4 rounded-lg border border-green-200">
                                <div class="flex items-center mb-3">
                                    <i class="fas fa-desktop text-green-600 mr-3 text-xl"></i>
                                    <span class="font-bold">Sur ordinateur</span>
                                </div>
                                <ul class="space-y-2 text-sm">
                                    <li>• Cliquez sur "Suivre ma commande"</li>
                                    <li>• Ou copiez le lien dans votre navigateur</li>
                                    <li>• Gardez l'onglet ouvert pour les mises à jour</li>
                                </ul>
                            </div>
                        </div>
                        <div class="bg-yellow-100 border border-yellow-300 rounded-lg p-4 mt-4">
                            <div class="flex items-start">
                                <i class="fas fa-lightbulb text-yellow-600 mr-3 mt-1"></i>
                                <div>
                                    <div class="font-bold text-yellow-800 mb-2">💡 Conseil pratique</div>
                                    <div class="text-yellow-700 text-sm">
                                        <strong>Conservez ce lien !</strong> Vous pourrez l'utiliser plus tard pour vérifier l'état de votre commande sans avoir besoin de votre numéro de commande.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations importantes -->
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-2 border-blue-200 rounded-2xl p-8 shadow-lg">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-info-circle text-white text-xl"></i>
                    </div>
                </div>
                <div class="ml-6">
                    <h3 class="text-2xl font-bold text-blue-900 mb-4">Informations importantes</h3>
                    <div class="text-blue-800 space-y-3 text-lg">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-blue-600 mr-3 w-5"></i>
                            <span><strong>Temps d'attente estimé :</strong> 20-30 minutes</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-credit-card text-blue-600 mr-3 w-5"></i>
                            <span><strong>Mode de paiement :</strong> Paiement à la livraison/récupération</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-bell text-blue-600 mr-3 w-5"></i>
                            <span><strong>Suivi :</strong> Vous recevrez des notifications par SMS/email</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone text-blue-600 mr-3 w-5"></i>
                            <span><strong>Contact :</strong> Le restaurant vous contactera si nécessaire</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.4.4/build/qrcode.min.js"></script>
<script>
// Générer le QR code de suivi
document.addEventListener('DOMContentLoaded', function() {
    const orderNumber = '{{ session("order_number") }}';
    const restaurantSlug = '{{ $restaurant->slug }}';
    const qrContainer = document.getElementById('qrcode-tracking');
    
    if (orderNumber && restaurantSlug && qrContainer) {
        const trackingUrl = `${window.location.origin}/restaurant/${restaurantSlug}/track/${orderNumber}`;
        
        // Vérifier si QRCode est chargé
        const checkQRCode = () => {
            if (typeof QRCode !== 'undefined') {
                // Nettoyer le conteneur
                qrContainer.innerHTML = '';
                
                // Créer un canvas pour le QR code
                const canvas = document.createElement('canvas');
                qrContainer.appendChild(canvas);
                
                // Générer le QR code
                QRCode.toCanvas(canvas, trackingUrl, {
                    width: 200,
                    margin: 4,
                    color: {
                        dark: '#1F2937',
                        light: '#FFFFFF'
                    },
                    errorCorrectionLevel: 'M'
                }, function(error) {
                    if (error) {
                        console.error('Erreur lors de la génération du QR code:', error);
                        qrContainer.innerHTML = `
                            <div class="text-red-500 text-center p-4">
                                <i class="fas fa-exclamation-triangle text-3xl mb-2"></i>
                                <p class="text-sm font-medium">Erreur QR code</p>
                                <p class="text-xs mt-1">${error.message}</p>
                            </div>
                        `;
                    } else {
                        console.log('QR code généré avec succès');
                    }
                });
            } else {
                // Attendre un peu plus longtemps
                setTimeout(checkQRCode, 200);
            }
        };
        
        // Démarrer la vérification
        checkQRCode();
        
        // Timeout de sécurité après 5 secondes
        setTimeout(() => {
            if (qrContainer.innerHTML === '') {
                qrContainer.innerHTML = `
                    <div class="text-gray-500 text-center p-4">
                        <i class="fas fa-qrcode text-4xl mb-2"></i>
                        <p class="text-sm font-medium">Chargement du QR code...</p>
                        <p class="text-xs mt-1">Veuillez patienter</p>
                    </div>
                `;
            }
        }, 5000);
        
    } else {
        if (qrContainer) {
            qrContainer.innerHTML = `
                <div class="text-gray-500 text-center p-4">
                    <i class="fas fa-qrcode text-4xl mb-2"></i>
                    <p class="text-sm font-medium">QR code non disponible</p>
                    <p class="text-xs mt-1">
                        Order: ${orderNumber || 'null'}<br>
                        Restaurant: ${restaurantSlug || 'null'}
                    </p>
                </div>
            `;
        }
    }
});

// Auto-refresh du statut toutes les 30 secondes
setInterval(function() {
    // Ici on pourrait ajouter une requête AJAX pour vérifier le statut
    // Pour l'instant, on laisse le suivi manuel
}, 30000);

// Animation d'entrée
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.animate-fade-in');
    elements.forEach((element, index) => {
        setTimeout(() => {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, index * 200);
    });
});

// Fonction pour copier le lien de suivi
function copyTrackingLink() {
    const trackingUrl = '{{ url("/restaurant/" . $restaurant->slug . "/track/" . session("order_number")) }}';
    
    if (navigator.clipboard) {
        navigator.clipboard.writeText(trackingUrl).then(function() {
            showNotification('Lien copié dans le presse-papiers !', 'success');
        }).catch(function(err) {
            console.error('Erreur lors de la copie:', err);
            fallbackCopyTextToClipboard(trackingUrl);
        });
    } else {
        fallbackCopyTextToClipboard(trackingUrl);
    }
}

// Fonction de fallback pour copier le texte
function fallbackCopyTextToClipboard(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.top = '0';
    textArea.style.left = '0';
    textArea.style.position = 'fixed';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        const successful = document.execCommand('copy');
        if (successful) {
            showNotification('Lien copié dans le presse-papiers !', 'success');
        } else {
            showNotification('Impossible de copier le lien', 'error');
        }
    } catch (err) {
        showNotification('Erreur lors de la copie', 'error');
    }
    
    document.body.removeChild(textArea);
}

// Fonction pour partager le lien
function shareTrackingLink() {
    const trackingUrl = '{{ url("/restaurant/" . $restaurant->slug . "/track/" . session("order_number")) }}';
    const orderNumber = '{{ session("order_number") }}';
    const restaurantName = '{{ $restaurant->name }}';
    
    const shareData = {
        title: `Suivi de commande - ${restaurantName}`,
        text: `Suivez ma commande #${orderNumber} chez ${restaurantName}`,
        url: trackingUrl
    };
    
    if (navigator.share) {
        navigator.share(shareData).then(function() {
            showNotification('Lien partagé avec succès !', 'success');
        }).catch(function(err) {
            console.error('Erreur lors du partage:', err);
            copyTrackingLink(); // Fallback vers la copie
        });
    } else {
        copyTrackingLink(); // Fallback vers la copie
    }
}

// Fonction pour afficher les notifications
function showNotification(message, type = 'info') {
    // Créer l'élément de notification
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        'bg-blue-500 text-white'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} mr-3"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Ajouter au DOM
    document.body.appendChild(notification);
    
    // Animation d'entrée
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Supprimer après 3 secondes
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}
</script>

<style>
.animate-fade-in {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease-out;
}

@keyframes bounce {
    0%, 20%, 53%, 80%, 100% {
        transform: translate3d(0,0,0);
    }
    40%, 43% {
        transform: translate3d(0, -30px, 0);
    }
    70% {
        transform: translate3d(0, -15px, 0);
    }
    90% {
        transform: translate3d(0, -4px, 0);
    }
}

.animate-bounce {
    animation: bounce 2s infinite;
}
</style>
@endpush
@endsection 