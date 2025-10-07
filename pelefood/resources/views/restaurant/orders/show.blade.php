@extends('layouts.restaurant')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête avec actions -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Commande {{ $order->order_number }}</h1>
            <p class="text-gray-600 mt-2">Détails complets de la commande</p>
        </div>
        
        <div class="flex space-x-3">
            <a href="{{ route('restaurant.orders.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
            
            @if($order->status === 'pending')
            <button onclick="updateOrderStatus('confirmed')" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-check mr-2"></i>Confirmer
            </button>
            @endif
            
            @if($order->status === 'confirmed')
            <button onclick="updateOrderStatus('preparing')" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors">
                <i class="fas fa-utensils mr-2"></i>Préparer
            </button>
            @endif
            
            @if($order->status === 'preparing')
            <button onclick="updateOrderStatus('ready')" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-check-double mr-2"></i>Prêt
            </button>
            @endif
            
            @if($order->status === 'ready' && $order->type === 'delivery')
            <button onclick="updateOrderStatus('out_for_delivery')" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-truck mr-2"></i>Livrer
            </button>
            @endif
            
            @if($order->status === 'out_for_delivery')
            <button onclick="updateOrderStatus('delivered')" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-check-circle mr-2"></i>Livré
            </button>
            @endif
            
            @if($order->canBeCancelled())
            <button onclick="showCancelModal()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                <i class="fas fa-times mr-2"></i>Annuler
            </button>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Informations principales -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Statut de la commande -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Statut de la commande</h2>
                
                <!-- Barre de progression -->
                <div class="w-full bg-gray-200 rounded-full h-3 mb-6">
                    <div class="bg-green-600 h-3 rounded-full transition-all duration-500" style="width: {{ $order->getProgressPercentage() }}%"></div>
                </div>
                
                <!-- Étapes -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto mb-2 rounded-full flex items-center justify-center 
                            {{ $order->isStepCompleted(1) ? 'bg-green-600 text-white' : ($order->isStepActive(1) ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600') }}">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="text-sm font-medium">En attente</div>
                        <div class="text-xs text-gray-500">Commande reçue</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto mb-2 rounded-full flex items-center justify-center 
                            {{ $order->isStepCompleted(2) ? 'bg-green-600 text-white' : ($order->isStepActive(2) ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600') }}">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="text-sm font-medium">Confirmée</div>
                        <div class="text-xs text-gray-500">Commande validée</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto mb-2 rounded-full flex items-center justify-center 
                            {{ $order->isStepCompleted(3) ? 'bg-green-600 text-white' : ($order->isStepActive(3) ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600') }}">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div class="text-sm font-medium">En préparation</div>
                        <div class="text-xs text-gray-500">Cuisine en cours</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto mb-2 rounded-full flex items-center justify-center 
                            {{ $order->isStepCompleted(4) ? 'bg-green-600 text-white' : ($order->isStepActive(4) ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600') }}">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <div class="text-sm font-medium">Prête</div>
                        <div class="text-xs text-gray-500">Commande terminée</div>
                    </div>
                </div>
                
                <!-- Statut actuel -->
                <div class="mt-6 text-center">
                    <div class="inline-flex items-center px-4 py-2 rounded-full text-lg font-semibold 
                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           ($order->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : 
                           ($order->status === 'preparing' ? 'bg-orange-100 text-orange-800' : 
                           ($order->status === 'ready' ? 'bg-green-100 text-green-800' : 
                           ($order->status === 'delivered' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800')))) }}">
                        <i class="fas fa-circle mr-2"></i>
                        {{ $order->status_text }}
                    </div>
                </div>
            </div>

            <!-- Articles commandés -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Articles commandés</h2>
                
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-utensils text-gray-400 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $item->product_name }}</h3>
                                <p class="text-sm text-gray-600">Quantité: {{ $item->quantity }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-green-600">{{ number_format($item->total_price) }} FCFA</div>
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
                        
                        <div class="flex justify-between text-xl font-bold border-t border-gray-200 pt-2">
                            <span>Total:</span>
                            <span class="text-green-600">{{ number_format($order->total_amount) }} FCFA</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations client et commande -->
        <div class="space-y-6">
            <!-- Informations client -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations client</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nom:</span>
                        <span class="font-semibold">{{ $order->customer_name }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Téléphone:</span>
                        <span class="font-semibold">{{ $order->customer_phone }}</span>
                    </div>
                    
                    @if($order->customer_email)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Email:</span>
                        <span class="font-semibold">{{ $order->customer_email }}</span>
                    </div>
                    @endif
                    
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
                    
                    @if($order->special_instructions)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Instructions:</span>
                        <span class="font-semibold">{{ $order->special_instructions }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Détails de la commande -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Détails de la commande</h2>
                
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
                            @endswitch
                        </span>
                    </div>
                    
                    @if($order->estimated_delivery_time)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Temps estimé:</span>
                        <span class="font-semibold text-blue-600">{{ $order->estimated_delivery_time }}</span>
                    </div>
                    @endif
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Méthode de paiement:</span>
                        <span class="font-semibold">{{ $order->payment_method ?? 'Non spécifiée' }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Statut du paiement:</span>
                        <span class="font-semibold">{{ $order->payment_status_text }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Actions rapides</h2>
                
                <div class="space-y-3">
                    <button onclick="printOrder()" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-print mr-2"></i>Imprimer la commande
                    </button>
                    
                    <button onclick="sendNotification()" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-bell mr-2"></i>Notifier le client
                    </button>
                    
                    <button onclick="copyOrderNumber()" class="w-full bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-copy mr-2"></i>Copier le numéro
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'annulation -->
<div id="cancel-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Annuler la commande</h3>
            </div>
            
            <div class="px-6 py-4">
                <p class="text-gray-600 mb-4">Veuillez indiquer la raison de l'annulation :</p>
                <textarea id="cancellation-reason" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Raison de l'annulation..."></textarea>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200 flex space-x-3">
                <button onclick="hideCancelModal()" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                    Annuler
                </button>
                <button onclick="confirmCancellation()" class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                    Confirmer l'annulation
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Mettre à jour le statut d'une commande
function updateOrderStatus(newStatus) {
    fetch(`/restaurant/orders/{{ $order->id }}/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            // Actualiser la page après un délai
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors de la mise à jour', 'error');
    });
}

// Afficher le modal d'annulation
function showCancelModal() {
    document.getElementById('cancel-modal').classList.remove('hidden');
}

// Masquer le modal d'annulation
function hideCancelModal() {
    document.getElementById('cancel-modal').classList.add('hidden');
    document.getElementById('cancellation-reason').value = '';
}

// Confirmer l'annulation
function confirmCancellation() {
    const reason = document.getElementById('cancellation-reason').value.trim();
    
    if (!reason) {
        showNotification('Veuillez indiquer une raison', 'error');
        return;
    }
    
    fetch(`/restaurant/orders/{{ $order->id }}/cancel`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ cancellation_reason: reason })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            hideCancelModal();
            // Actualiser la page après un délai
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors de l\'annulation', 'error');
    });
}

// Imprimer la commande
function printOrder() {
    window.open(`/order/receipt/{{ $order->order_number }}?print=1`, '_blank');
}

// Notifier le client
function sendNotification() {
    showNotification('Notification envoyée au client', 'success');
}

// Copier le numéro de commande
function copyOrderNumber() {
    navigator.clipboard.writeText('{{ $order->order_number }}').then(function() {
        showNotification('Numéro de commande copié !', 'success');
    });
}

// Afficher une notification
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 ${
        type === 'success' ? 'bg-green-600' : 'bg-red-600'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endsection 