@extends('layouts.staff')

@section('title', 'Gestion des commandes')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Gestion des commandes</h1>
                    <p class="text-gray-600">{{ $restaurant->name }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('staff.dashboard') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>Retour au dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filtres -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="preparing" {{ request('status') == 'preparing' ? 'selected' : '' }}>En préparation</option>
                        <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Prêt</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminé</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les types</option>
                        <option value="delivery" {{ request('type') == 'delivery' ? 'selected' : '' }}>Livraison</option>
                        <option value="pickup" {{ request('type') == 'pickup' ? 'selected' : '' }}>À emporter</option>
                        <option value="dine_in" {{ request('type') == 'dine_in' ? 'selected' : '' }}>Sur place</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                    <input type="date" name="date" value="{{ request('date') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors duration-300">
                        <i class="fas fa-search mr-2"></i>Filtrer
                    </button>
                    @if(request('status') || request('type') || request('date'))
                        <a href="{{ route('staff.orders') }}" class="ml-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-300">
                            <i class="fas fa-times mr-2"></i>Effacer
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Statistiques rapides -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">En attente</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $orders->where('status', 'pending')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-utensils text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">En préparation</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $orders->where('status', 'preparing')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Prêtes</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $orders->where('status', 'ready')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-day text-purple-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $orders->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des commandes -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Commandes</h3>
            </div>
            
            <div class="divide-y divide-gray-200">
                @forelse($orders as $order)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-4">
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900">#{{ $order->order_number }}</h4>
                                        <p class="text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $order->type === 'delivery' ? 'bg-blue-100 text-blue-800' : 
                                               ($order->type === 'pickup' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') }}">
                                            <i class="fas fa-{{ $order->type === 'delivery' ? 'truck' : ($order->type === 'pickup' ? 'hand-holding' : 'utensils') }} mr-1"></i>
                                            {{ ucfirst($order->type) }}
                                        </span>
                                        
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($order->status === 'preparing' ? 'bg-blue-100 text-blue-800' : 
                                               ($order->status === 'ready' ? 'bg-green-100 text-green-800' : 
                                               ($order->status === 'completed' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800'))) }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="mt-2">
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-user mr-1"></i>{{ $order->customer_name }}
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-phone mr-1"></i>{{ $order->customer_phone }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-shopping-cart mr-1"></i>{{ $order->items->count() }} articles
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-money-bill mr-1"></i>{{ number_format($order->total_amount, 0, ',', ' ') }} {{ $order->currency }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('staff.orders.show', $order) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-300">
                                    <i class="fas fa-eye mr-1"></i>Voir
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune commande trouvée</h3>
                        <p class="text-gray-500">Aucune commande ne correspond à vos critères de recherche.</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 