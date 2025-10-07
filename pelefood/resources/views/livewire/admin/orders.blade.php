<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Commandes</h1>
            <p class="text-gray-600 mt-2">Suivez et gérez toutes les commandes de la plateforme</p>
        </div>
        <button wire:click="createOrder" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
            <i class="fas fa-plus"></i>
            <span>Nouvelle commande</span>
        </button>
    </div>

    <!-- Filtres et recherche -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <!-- Recherche -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input wire:model.debounce.300ms="search" 
                           type="text" 
                           placeholder="Rechercher des commandes..."
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Filtres -->
            <div class="flex items-center space-x-4">
                <select wire:model="filter" 
                        class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">Tous les statuts</option>
                    <option value="pending">En attente</option>
                    <option value="confirmed">Confirmées</option>
                    <option value="preparing">En préparation</option>
                    <option value="ready">Prêtes</option>
                    <option value="delivered">Livrées</option>
                    <option value="cancelled">Annulées</option>
                </select>

                <select wire:model="perPage" 
                        class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="12">12 par page</option>
                    <option value="24">24 par page</option>
                    <option value="48">48 par page</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Liste des commandes -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Commande
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Restaurant
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Client
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Montant
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-shopping-cart text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">#{{ $order->order_number }}</div>
                                        <div class="text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $order->restaurant->name ?? 'Restaurant supprimé' }}</div>
                                <div class="text-sm text-gray-500">{{ $order->restaurant->city ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $order->user->name ?? 'Client supprimé' }}</div>
                                <div class="text-sm text-gray-500">{{ $order->user->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($order->total_amount, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusBadgeClass($order->status) }}">
                                    {{ $this->getStatusLabel($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button wire:click="viewOrder({{ $order->id }})" 
                                            class="text-blue-600 hover:text-blue-700"
                                            title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    @if($order->status === 'pending')
                                        <button wire:click="updateOrderStatus({{ $order->id }}, 'confirmed')" 
                                                class="text-green-600 hover:text-green-700"
                                                title="Confirmer">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @elseif($order->status === 'confirmed')
                                        <button wire:click="updateOrderStatus({{ $order->id }}, 'preparing')" 
                                                class="text-orange-600 hover:text-orange-700"
                                                title="Marquer en préparation">
                                            <i class="fas fa-clock"></i>
                                        </button>
                                    @elseif($order->status === 'preparing')
                                        <button wire:click="updateOrderStatus({{ $order->id }}, 'ready')" 
                                                class="text-purple-600 hover:text-purple-700"
                                                title="Marquer prête">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    @elseif($order->status === 'ready')
                                        <button wire:click="updateOrderStatus({{ $order->id }}, 'delivered')" 
                                                class="text-green-600 hover:text-green-700"
                                                title="Marquer livrée">
                                            <i class="fas fa-truck"></i>
                                        </button>
                                    @endif
                                    
                                    @if(in_array($order->status, ['pending', 'confirmed', 'preparing']))
                                        <button wire:click="updateOrderStatus({{ $order->id }}, 'cancelled')" 
                                                class="text-red-600 hover:text-red-700"
                                                title="Annuler">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune commande trouvée</h3>
                <p class="text-gray-500 mb-6">Les commandes apparaîtront ici une fois créées</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal de détails de commande -->
@if($showModal && $selectedOrder)
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeModal">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white" wire:click.stop>
        <!-- En-tête du modal -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Détails de la commande #{{ $selectedOrder->order_number }}</h3>
            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Contenu du modal -->
        <div class="space-y-6">
            <!-- Informations générales -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="font-medium text-gray-900 mb-3">Informations de la commande</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Numéro:</span>
                            <span class="font-medium">#{{ $selectedOrder->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date:</span>
                            <span class="font-medium">{{ $selectedOrder->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Statut:</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $this->getStatusBadgeClass($selectedOrder->status) }}">
                                {{ $this->getStatusLabel($selectedOrder->status) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Montant total:</span>
                            <span class="font-medium text-green-600">{{ number_format($selectedOrder->total_amount, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="font-medium text-gray-900 mb-3">Informations du client</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nom:</span>
                            <span class="font-medium">{{ $selectedOrder->user->name ?? 'Client supprimé' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-medium">{{ $selectedOrder->user->email ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Téléphone:</span>
                            <span class="font-medium">{{ $selectedOrder->user->phone ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Restaurant -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-medium text-gray-900 mb-3">Restaurant</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nom:</span>
                        <span class="font-medium">{{ $selectedOrder->restaurant->name ?? 'Restaurant supprimé' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Adresse:</span>
                        <span class="font-medium">{{ $selectedOrder->restaurant->address ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Ville:</span>
                        <span class="font-medium">{{ $selectedOrder->restaurant->city ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- Articles de la commande -->
            @if($selectedOrder->orderItems && $selectedOrder->orderItems->count() > 0)
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-medium text-gray-900 mb-3">Articles commandés</h4>
                <div class="space-y-3">
                    @foreach($selectedOrder->orderItems as $item)
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-utensils text-gray-500"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">{{ $item->product->name ?? 'Produit supprimé' }}</div>
                                <div class="text-sm text-gray-500">Quantité: {{ $item->quantity }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-medium text-gray-900">{{ number_format($item->price, 0, ',', ' ') }} FCFA</div>
                            <div class="text-sm text-gray-500">x{{ $item->quantity }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Boutons du modal -->
        <div class="flex items-center justify-end space-x-4 mt-6 pt-6 border-t border-gray-200">
            <button type="button" 
                    wire:click="closeModal"
                    class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                Fermer
            </button>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
// Notification système pour Livewire
window.addEventListener('showNotification', event => {
    // Créer une notification toast
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
    notification.textContent = event.detail.message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
});
</script>

<!-- Modal pour créer une commande -->
@if($showModal && !$selectedOrder)
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeModal">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white" wire:click.stop>
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">{{ $modalTitle }}</h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form wire:submit.prevent="saveOrder">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Utilisateur -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Client *</label>
                        <select wire:model="user_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-500 @enderror">
                            <option value="">Sélectionner un client</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        @error('user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Restaurant -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Restaurant *</label>
                        <select wire:model="restaurant_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('restaurant_id') border-red-500 @enderror">
                            <option value="">Sélectionner un restaurant</option>
                            @foreach($restaurants as $restaurant)
                                <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                            @endforeach
                        </select>
                        @error('restaurant_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Statut -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Statut *</label>
                        <select wire:model="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                            <option value="pending">En attente</option>
                            <option value="confirmed">Confirmée</option>
                            <option value="preparing">En préparation</option>
                            <option value="ready">Prête</option>
                            <option value="delivered">Livrée</option>
                            <option value="cancelled">Annulée</option>
                        </select>
                        @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Adresse de livraison -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Adresse de livraison *</label>
                        <textarea wire:model="delivery_address" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('delivery_address') border-red-500 @enderror"></textarea>
                        @error('delivery_address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea wire:model="notes" rows="2"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('notes') border-red-500 @enderror"></textarea>
                        @error('notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" wire:click="closeModal"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Annuler
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Créer la commande
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endpush