<div class="bg-white rounded-lg border border-gray-200 p-4 mb-4 shadow-sm hover:shadow-md transition-shadow duration-200" 
     x-data="{ showDetails: false }">
    <!-- En-tête de la commande -->
    <div class="flex justify-between items-start mb-3">
        <div>
            <h4 class="text-lg font-semibold text-gray-900">#{{ $order->order_number }}</h4>
            <p class="text-sm text-gray-500">{{ $order->created_at->format('H:i') }}</p>
        </div>
        <div class="flex items-center space-x-2">
            <!-- Badge de type -->
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                {{ $order->type === 'delivery' ? 'bg-blue-100 text-blue-800' : 
                   ($order->type === 'pickup' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') }}">
                <i class="fas fa-{{ $order->type === 'delivery' ? 'truck' : ($order->type === 'pickup' ? 'hand-holding' : 'utensils') }} mr-1"></i>
                {{ ucfirst($order->type) }}
            </span>
            
            <!-- Badge de statut -->
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                   ($order->status === 'preparing' ? 'bg-blue-100 text-blue-800' : 
                   ($order->status === 'ready' ? 'bg-green-100 text-green-800' : 
                   ($order->status === 'completed' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800'))) }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>
    </div>

    <!-- Informations client -->
    <div class="mb-3">
        <div class="flex items-center text-sm text-gray-600">
            <i class="fas fa-user mr-2"></i>
            <span class="font-medium">{{ $order->customer_name }}</span>
        </div>
        <div class="flex items-center text-sm text-gray-600">
            <i class="fas fa-phone mr-2"></i>
            <span>{{ $order->customer_phone }}</span>
        </div>
        @if($order->customer_email)
            <div class="flex items-center text-sm text-gray-600">
                <i class="fas fa-envelope mr-2"></i>
                <span>{{ $order->customer_email }}</span>
            </div>
        @endif
    </div>

    <!-- Articles de la commande -->
    <div class="mb-3">
        <div class="flex justify-between items-center mb-2">
            <h5 class="text-sm font-medium text-gray-900">Articles</h5>
            <button @click="showDetails = !showDetails" 
                    class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors duration-200">
                <span x-text="showDetails ? 'Masquer' : 'Voir'"></span>
                <i class="fas fa-chevron-down ml-1 transition-transform duration-200" 
                   :class="{ 'rotate-180': showDetails }"></i>
            </button>
        </div>
        
        <div x-show="showDetails" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="space-y-2">
            @foreach($order->items as $item)
                <div class="flex justify-between items-center text-sm">
                    <div class="flex-1">
                        <span class="font-medium">{{ $item->product_name }}</span>
                        @if($item->options)
                            <div class="text-xs text-gray-500">
                                @foreach(json_decode($item->options, true) ?? [] as $key => $value)
                                    <span class="inline-block bg-gray-100 px-1 rounded mr-1">{{ $key }}: {{ $value }}</span>
                                @endforeach
                            </div>
                        @endif
                        @if($item->special_instructions)
                            <div class="text-xs text-orange-600 italic">
                                <i class="fas fa-info-circle mr-1"></i>{{ $item->special_instructions }}
                            </div>
                        @endif
                    </div>
                    <div class="text-right">
                        <span class="font-medium">{{ $item->quantity }}x</span>
                        <span class="text-gray-600">{{ number_format($item->unit_price, 0, ',', ' ') }} {{ $order->currency }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Résumé -->
        <div class="border-t border-gray-200 pt-2 mt-2">
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Total:</span>
                <span class="font-semibold text-gray-900">{{ number_format($order->total_amount, 0, ',', ' ') }} {{ $order->currency }}</span>
            </div>
        </div>
    </div>

    <!-- Instructions spéciales -->
    @if($order->special_instructions)
        <div class="mb-3 p-3 bg-orange-50 border border-orange-200 rounded-lg">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-orange-600 mt-0.5 mr-2"></i>
                <div>
                    <p class="text-sm font-medium text-orange-800">Instructions spéciales</p>
                    <p class="text-sm text-orange-700">{{ $order->special_instructions }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Actions -->
    <div class="flex justify-between items-center pt-3 border-t border-gray-200">
        <div class="text-sm text-gray-500">
            <span>Paiement: </span>
            <span class="font-medium 
                {{ $order->payment_status === 'completed' ? 'text-green-600' : 
                   ($order->payment_status === 'pending' ? 'text-yellow-600' : 'text-red-600') }}">
                {{ ucfirst($order->payment_status) }}
            </span>
        </div>
        
        <div class="flex space-x-2">
            <!-- Bouton de changement de statut -->
            <div class="relative" x-data="{ statusMenuOpen: false }">
                <button @click="statusMenuOpen = !statusMenuOpen" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-sm font-medium transition-colors duration-200">
                    <i class="fas fa-edit mr-1"></i>Statut
                </button>
                
                <div x-show="statusMenuOpen" 
                     @click.away="statusMenuOpen = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                    
                    <button @click="updateOrderStatus('{{ $order->id }}', 'preparing'); statusMenuOpen = false"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200 {{ $order->status === 'preparing' ? 'bg-blue-50 text-blue-700' : '' }}">
                        <i class="fas fa-utensils mr-2"></i>En préparation
                    </button>
                    
                    <button @click="updateOrderStatus('{{ $order->id }}', 'ready'); statusMenuOpen = false"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200 {{ $order->status === 'ready' ? 'bg-green-50 text-green-700' : '' }}">
                        <i class="fas fa-check mr-2"></i>Prêt
                    </button>
                    
                    <button @click="updateOrderStatus('{{ $order->id }}', 'completed'); statusMenuOpen = false"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200 {{ $order->status === 'completed' ? 'bg-gray-50 text-gray-700' : '' }}">
                        <i class="fas fa-flag-checkered mr-2"></i>Terminé
                    </button>
                    
                    <button @click="updateOrderStatus('{{ $order->id }}', 'cancelled'); statusMenuOpen = false"
                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </button>
                </div>
            </div>
            
            <!-- Bouton de détails -->
            <a href="{{ route('staff.orders.show', $order) }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1.5 rounded-md text-sm font-medium transition-colors duration-200">
                <i class="fas fa-eye mr-1"></i>Détails
            </a>
        </div>
    </div>
</div>

<script>
function updateOrderStatus(orderId, status) {
    fetch(`/staff/orders/${orderId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Émettre un événement pour mettre à jour l'interface
            document.dispatchEvent(new CustomEvent('orderStatusUpdated', {
                detail: { message: data.message }
            }));
            
            // Recharger la page après un délai
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showNotification(data.error || 'Erreur lors de la mise à jour', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors de la mise à jour du statut', 'error');
    });
}
</script> 