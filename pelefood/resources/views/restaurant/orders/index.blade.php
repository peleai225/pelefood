@extends('layouts.restaurant')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête avec statistiques -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Gestion des Commandes</h1>
        
        <!-- Statistiques en temps réel -->
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</div>
                <div class="text-sm text-gray-600">Total</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
                <div class="text-sm text-gray-600">En attente</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <div class="text-2xl font-bold text-orange-600">{{ $stats['preparing'] }}</div>
                <div class="text-sm text-gray-600">En préparation</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <div class="text-2xl font-bold text-green-600">{{ $stats['ready'] }}</div>
                <div class="text-sm text-gray-600">Prêtes</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $stats['delivered'] }}</div>
                <div class="text-sm text-gray-600">Livrées</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <div class="text-2xl font-bold text-indigo-600">{{ $stats['today'] }}</div>
                <div class="text-sm text-gray-600">Aujourd'hui</div>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="flex space-x-4 mb-6">
            <button onclick="refreshOrders()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-sync-alt mr-2"></i>Actualiser
            </button>
            <button onclick="toggleAutoRefresh()" id="auto-refresh-btn" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-play mr-2"></i>Auto-actualisation
            </button>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="flex flex-wrap items-center space-x-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select id="status-filter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Tous les statuts</option>
                    <option value="pending">En attente</option>
                    <option value="confirmed">Confirmée</option>
                    <option value="preparing">En préparation</option>
                    <option value="ready">Prête</option>
                    <option value="out_for_delivery">En livraison</option>
                    <option value="delivered">Livrée</option>
                    <option value="cancelled">Annulée</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select id="type-filter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Tous les types</option>
                    <option value="on_site">Sur place</option>
                    <option value="delivery">Livraison</option>
                    <option value="takeaway">À emporter</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" id="date-filter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="flex items-end">
                <button onclick="applyFilters()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-filter mr-2"></i>Filtrer
                </button>
            </div>
        </div>
    </div>

    <!-- Liste des commandes -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Commandes récentes</h2>
        </div>
        
        <div id="orders-container">
            @if($orders->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <div class="order-item p-6 hover:bg-gray-50 transition-colors" data-order-id="{{ $order->id }}">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 font-bold text-lg">#{{ substr($order->order_number, -4) }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $order->order_number }}</h3>
                                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($order->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : 
                                                   ($order->status === 'preparing' ? 'bg-orange-100 text-orange-800' : 
                                                   ($order->status === 'ready' ? 'bg-green-100 text-green-800' : 
                                                   ($order->status === 'delivered' ? 'bg-purple-100 text-purple-800' : 
                                                   'bg-gray-100 text-gray-800')))) }}">
                                                {{ $order->status_text }}
                                            </span>
                                        </div>
                                        
                                        <div class="mt-1 text-sm text-gray-600">
                                            <span class="font-medium">{{ $order->customer_name }}</span> • 
                                            <span>{{ $order->customer_phone }}</span> • 
                                            <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                        
                                        <div class="mt-2 text-sm text-gray-500">
                                            @switch($order->type)
                                                @case('on_site')
                                                    <i class="fas fa-utensils mr-1"></i>Sur place
                                                    @break
                                                @case('delivery')
                                                    <i class="fas fa-truck mr-1"></i>Livraison
                                                    @break
                                                @case('takeaway')
                                                    <i class="fas fa-shopping-bag mr-1"></i>À emporter
                                                    @break
                                            @endswitch
                                            • {{ $order->items->count() }} article(s) • 
                                            <span class="font-semibold text-green-600">{{ number_format($order->total_amount) }} FCFA</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('restaurant.orders.show', $order->id) }}" 
                                   class="bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                    <i class="fas fa-eye mr-1"></i>Voir
                                </a>
                                
                                @if($order->status === 'pending')
                                <button onclick="updateOrderStatus({{ $order->id }}, 'confirmed')" 
                                        class="bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm">
                                    <i class="fas fa-check mr-1"></i>Confirmer
                                </button>
                                @endif
                                
                                @if($order->status === 'confirmed')
                                <button onclick="updateOrderStatus({{ $order->id }}, 'preparing')" 
                                        class="bg-orange-600 text-white px-3 py-2 rounded-lg hover:bg-orange-700 transition-colors text-sm">
                                    <i class="fas fa-utensils mr-1"></i>Préparer
                                </button>
                                @endif
                                
                                @if($order->status === 'preparing')
                                <button onclick="updateOrderStatus({{ $order->id }}, 'ready')" 
                                        class="bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm">
                                    <i class="fas fa-check-double mr-1"></i>Prêt
                                </button>
                                @endif
                                
                                @if($order->status === 'ready' && $order->type === 'delivery')
                                <button onclick="updateOrderStatus({{ $order->id }}, 'out_for_delivery')" 
                                        class="bg-purple-600 text-white px-3 py-2 rounded-lg hover:bg-purple-700 transition-colors text-sm">
                                    <i class="fas fa-truck mr-1"></i>Livrer
                                </button>
                                @endif
                                
                                @if($order->status === 'out_for_delivery')
                                <button onclick="updateOrderStatus({{ $order->id }}, 'delivered')" 
                                        class="bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm">
                                    <i class="fas fa-check-circle mr-1"></i>Livré
                                </button>
                                @endif
                                
                                @if($order->canBeCancelled())
                                <button onclick="showCancelModal({{ $order->id }})" 
                                        class="bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 transition-colors text-sm">
                                    <i class="fas fa-times mr-1"></i>Annuler
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="p-8 text-center">
                    <div class="text-gray-400 text-6xl mb-4">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune commande</h3>
                    <p class="text-gray-500">Les commandes apparaîtront ici dès qu'elles seront passées par vos clients.</p>
                </div>
            @endif
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
let autoRefreshInterval = null;
let currentOrderId = null;

// Actualisation automatique
function toggleAutoRefresh() {
    const btn = document.getElementById('auto-refresh-btn');
    if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
        autoRefreshInterval = null;
        btn.innerHTML = '<i class="fas fa-play mr-2"></i>Auto-actualisation';
        btn.className = 'bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors';
    } else {
        autoRefreshInterval = setInterval(refreshOrders, 30000); // 30 secondes
        btn.innerHTML = '<i class="fas fa-pause mr-2"></i>Arrêter auto-actualisation';
        btn.className = 'bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors';
    }
}

// Actualiser les commandes
function refreshOrders() {
    fetch('{{ route("restaurant.orders.ajax.get-orders") }}')
        .then(response => response.json())
        .then(orders => {
            // Mettre à jour la liste des commandes
            updateOrdersList(orders);
        })
        .catch(error => console.error('Erreur:', error));
}

// Mettre à jour le statut d'une commande
function updateOrderStatus(orderId, newStatus) {
    fetch(`/restaurant/orders/${orderId}/update-status`, {
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
function showCancelModal(orderId) {
    currentOrderId = orderId;
    document.getElementById('cancel-modal').classList.remove('hidden');
}

// Masquer le modal d'annulation
function hideCancelModal() {
    document.getElementById('cancel-modal').classList.add('hidden');
    document.getElementById('cancellation-reason').value = '';
    currentOrderId = null;
}

// Confirmer l'annulation
function confirmCancellation() {
    const reason = document.getElementById('cancellation-reason').value.trim();
    
    if (!reason) {
        showNotification('Veuillez indiquer une raison', 'error');
        return;
    }
    
    fetch(`/restaurant/orders/${currentOrderId}/cancel`, {
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

// Appliquer les filtres
function applyFilters() {
    const status = document.getElementById('status-filter').value;
    const type = document.getElementById('type-filter').value;
    const date = document.getElementById('date-filter').value;
    
    let url = '{{ route("restaurant.orders.index") }}?';
    const params = new URLSearchParams();
    
    if (status) params.append('status', status);
    if (type) params.append('type', type);
    if (date) params.append('date', date);
    
    window.location.href = url + params.toString();
}

// Afficher une notification
function showNotification(message, type) {
    // Créer une notification simple
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

// Démarrer l'auto-actualisation au chargement
document.addEventListener('DOMContentLoaded', function() {
    // Démarrer l'auto-actualisation automatiquement
    toggleAutoRefresh();
});
</script>
@endsection 