<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi de commande - {{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        .status-step {
            transition: all 0.3s ease;
        }
        
        .status-step.active {
            background-color: #10b981;
            color: white;
        }
        
        .status-step.completed {
            background-color: #059669;
            color: white;
        }
        
        .status-step.pending {
            background-color: #e5e7eb;
            color: #6b7280;
        }
        
        .progress-bar {
            transition: width 0.5s ease;
        }
        
        .order-card {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-4">
                    <a href="/restaurant/{{ $order->restaurant->slug }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour au restaurant
                    </a>
                </div>
                <div class="text-center">
                    <h1 class="text-xl font-bold text-gray-900">Suivi de commande</h1>
                    <p class="text-sm text-gray-500">Numéro: {{ $order->order_number }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="printReceipt()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-print mr-2"></i>Imprimer
                    </button>
                    <button onclick="downloadReceipt()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-download mr-2"></i>Télécharger
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Informations de la commande -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8 order-card">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Détails de la commande</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Numéro:</span>
                            <span class="font-semibold">{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date:</span>
                            <span class="font-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Type:</span>
                            <span class="font-semibold">
                                @switch($order->type)
                                    @case('on_site')
                                        <i class="fas fa-utensils mr-2"></i>Sur place
                                        @break
                                    @case('delivery')
                                        <i class="fas fa-truck mr-2"></i>Livraison
                                        @break
                                    @case('takeaway')
                                        <i class="fas fa-shopping-bag mr-2"></i>À emporter
                                        @break
                                    @default
                                        {{ ucfirst($order->type) }}
                                @endswitch
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total:</span>
                            <span class="font-bold text-xl text-green-600">{{ number_format($order->total_amount) }} FCFA</span>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations client</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nom:</span>
                            <span class="font-semibold">{{ $order->customer_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Téléphone:</span>
                            <span class="font-semibold">{{ $order->customer_phone }}</span>
                        </div>
                        @if($order->delivery_address)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Adresse:</span>
                            <span class="font-semibold">
                                @if(is_array($order->delivery_address))
                                    {{ $order->delivery_address['address'] ?? 'Adresse non renseignée' }}
                                    @if(isset($order->delivery_address['city']))
                                        <br><span class="text-xs text-gray-500">{{ $order->delivery_address['city'] }}</span>
                                    @endif
                                @else
                                    {{ $order->delivery_address }}
                                @endif
                            </span>
                        </div>
                        @endif
                        @if($order->estimated_delivery_time)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Livraison estimée:</span>
                            <span class="font-semibold">{{ $order->estimated_delivery_time }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Barre de progression du statut -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8 order-card">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Statut de votre commande</h2>
            
            <!-- Barre de progression -->
            <div class="w-full bg-gray-200 rounded-full h-3 mb-8">
                <div id="progress-bar" class="progress-bar bg-green-600 h-3 rounded-full" style="width: {{ $order->getProgressPercentage() }}%"></div>
            </div>
            
            <!-- Étapes du statut -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="status-step {{ $order->isStepCompleted(1) ? 'completed' : ($order->isStepActive(1) ? 'active' : 'pending') }} rounded-lg p-4 text-center">
                    <div class="text-2xl mb-2">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="font-semibold">En attente</h3>
                    <p class="text-sm">Commande reçue</p>
                </div>
                
                <div class="status-step {{ $order->isStepCompleted(2) ? 'completed' : ($order->isStepActive(2) ? 'active' : 'pending') }} rounded-lg p-4 text-center">
                    <div class="text-2xl mb-2">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="font-semibold">Confirmée</h3>
                    <p class="text-sm">Commande validée</p>
                </div>
                
                <div class="status-step {{ $order->isStepCompleted(3) ? 'completed' : ($order->isStepActive(3) ? 'active' : 'pending') }} rounded-lg p-4 text-center">
                    <div class="text-2xl mb-2">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3 class="font-semibold">En préparation</h3>
                    <p class="text-sm">Cuisine en cours</p>
                </div>
                
                <div class="status-step {{ $order->isStepCompleted(4) ? 'completed' : ($order->isStepActive(4) ? 'active' : 'pending') }} rounded-lg p-4 text-center">
                    <div class="text-2xl mb-2">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <h3 class="font-semibold">Prête</h3>
                    <p class="text-sm">Commande terminée</p>
                </div>
            </div>
            
            <!-- Statut actuel -->
            <div class="mt-8 text-center">
                <div class="inline-flex items-center px-6 py-3 rounded-full text-lg font-semibold 
                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                       ($order->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : 
                       ($order->status === 'preparing' ? 'bg-orange-100 text-orange-800' : 
                       ($order->status === 'ready' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'))) }}">
                    <i class="fas fa-circle mr-2"></i>
                    Statut actuel: {{ $order->status_text }}
                </div>
            </div>
        </div>

        <!-- Détails des articles commandés -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8 order-card">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Articles commandés</h2>
            
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-4">
                        @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-lg">
                        @else
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-utensils text-gray-400 text-xl"></i>
                            </div>
                        @endif
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $item->product_name }}</h3>
                            <p class="text-sm text-gray-600">Quantité: {{ $item->quantity }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-semibold text-gray-900">{{ $item->quantity }}x</div>
                        <div class="text-lg font-bold text-green-600">{{ number_format($item->total_price) }} FCFA</div>
                        <div class="text-sm text-gray-500">{{ number_format($item->unit_price) }} FCFA l'unité</div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Résumé des coûts -->
            <div class="border-t border-gray-200 mt-6 pt-6">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Sous-total:</span>
                        <span class="font-semibold">{{ number_format($order->subtotal) }} FCFA</span>
                    </div>
                    @if($order->delivery_fee > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Frais de livraison:</span>
                        <span class="font-semibold">{{ number_format($order->delivery_fee) }} FCFA</span>
                    </div>
                    @endif
                    @if($order->discount_amount > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Réduction:</span>
                        <span class="font-semibold text-red-600">-{{ number_format($order->discount_amount) }} FCFA</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-lg font-bold border-t border-gray-200 pt-2">
                        <span>Total:</span>
                        <span class="text-green-600">{{ number_format($order->total_amount) }} FCFA</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8 order-card">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Actions</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button onclick="printReceipt()" class="flex items-center justify-center space-x-2 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-print"></i>
                    <span>Imprimer le reçu</span>
                </button>
                
                <button onclick="downloadReceipt()" class="flex items-center justify-center space-x-2 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-download"></i>
                    <span>Télécharger PDF</span>
                </button>
                
                @if($order->status === 'delivered')
                <a href="{{ route('order.review', $order->order_number) }}" class="flex items-center justify-center space-x-2 bg-yellow-600 text-white px-6 py-3 rounded-lg hover:bg-yellow-700 transition-colors">
                    <i class="fas fa-star"></i>
                    <span>Donner un avis</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Actualisation automatique -->
        <div class="text-center text-gray-500 text-sm">
            <p>Cette page se met à jour automatiquement toutes les 30 secondes</p>
            <p>Dernière mise à jour: <span id="last-update">{{ now()->format('H:i:s') }}</span></p>
        </div>
    </div>

    <script>
        // Actualisation automatique du statut
        function updateOrderStatus() {
            fetch(`/order/check-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    order_number: '{{ $order->order_number }}'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mettre à jour l'heure de dernière mise à jour
                    document.getElementById('last-update').textContent = new Date().toLocaleTimeString('fr-FR');
                    
                    // Si le statut a changé, recharger la page
                    if (data.status !== '{{ $order->status }}') {
                        location.reload();
                    }
                }
            })
            .catch(error => console.error('Erreur:', error));
        }

        // Actualiser toutes les 30 secondes
        setInterval(updateOrderStatus, 30000);

        // Fonctions d'impression et téléchargement
        function printReceipt() {
            window.open('{{ route("order.receipt", $order->order_number) }}', '_blank');
        }

        function downloadReceipt() {
            window.location.href = '{{ route("order.download", $order->order_number) }}';
        }

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            // Animation de la barre de progression
            const progressBar = document.getElementById('progress-bar');
            setTimeout(() => {
                progressBar.style.width = '{{ $order->getProgressPercentage() }}%';
            }, 500);
        });
    </script>
</body>
</html> 