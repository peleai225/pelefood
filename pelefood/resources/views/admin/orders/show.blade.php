@extends('layouts.super-admin-new-design')

@section('title', 'Détails de la Commande - PeleFood')
@section('description', 'Voir les détails complets de la commande')
@section('page-title', 'Détails de la Commande')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Commande #{{ $order->order_number ?? $order->id }}</h1>
                <p class="text-gray-600">Restaurant: {{ $order->restaurant->name ?? 'Restaurant supprimé' }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.orders.edit', $order) }}" class="btn-primary">
                    <i class="fas fa-edit mr-2"></i>
                    Modifier
                </a>
                <a href="{{ route('admin.orders.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <!-- Informations générales -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Détails de la commande -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations de la commande</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Numéro de commande:</span>
                    <span class="font-medium">#{{ $order->order_number ?? $order->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Statut:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if($order->status === 'delivered') bg-green-100 text-green-800
                        @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                        @else bg-blue-100 text-blue-800
                        @endif">
                        {{ ucfirst($order->status ?? 'N/A') }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Montant total:</span>
                    <span class="font-bold text-lg">{{ \App\Helpers\SettingsHelper::formatAmount($order->total_amount ?? 0) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Date de commande:</span>
                    <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Méthode de livraison:</span>
                    <span>{{ ucfirst($order->delivery_method ?? 'N/A') }}</span>
                </div>
            </div>
        </div>

        <!-- Informations client -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations client</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Nom:</span>
                    <span class="font-medium">{{ $order->customer_name ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Téléphone:</span>
                    <span>{{ $order->customer_phone ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Email:</span>
                    <span>{{ $order->customer_email ?? 'N/A' }}</span>
                </div>
                @if($order->user)
                <div class="flex justify-between">
                    <span class="text-gray-600">Utilisateur:</span>
                    <span>{{ $order->user->name }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Adresse de livraison -->
    @if($order->delivery_address)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Adresse de livraison</h3>
        <div class="space-y-2">
            <p class="text-gray-900">{{ $order->delivery_address['address'] ?? 'N/A' }}</p>
            <p class="text-gray-600">{{ $order->delivery_address['city'] ?? 'N/A' }}</p>
            @if(isset($order->delivery_address['postal_code']))
            <p class="text-gray-600">{{ $order->delivery_address['postal_code'] }}</p>
            @endif
        </div>
    </div>
    @endif

    <!-- Articles de la commande -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Articles commandés</h3>
        @if($order->orderItems && $order->orderItems->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unitaire</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $item->product_name ?? 'Produit supprimé' }}</div>
                            @if($item->product)
                            <div class="text-sm text-gray-500">{{ $item->product->name }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->quantity ?? 0 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \App\Helpers\SettingsHelper::formatAmount($item->unit_price ?? 0) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ \App\Helpers\SettingsHelper::formatAmount($item->total_price ?? 0) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-gray-500 text-center py-8">Aucun article trouvé pour cette commande.</p>
        @endif
    </div>

    <!-- Instructions spéciales -->
    @if($order->special_instructions)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Instructions spéciales</h3>
        <p class="text-gray-700">{{ $order->special_instructions }}</p>
    </div>
    @endif

    <!-- Actions rapides -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h3>
        <div class="flex flex-wrap gap-3">
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="inline">
                @csrf
                @method('PUT')
                <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                    <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>En préparation</option>
                    <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Prête</option>
                    <option value="out_for_delivery" {{ $order->status === 'out_for_delivery' ? 'selected' : '' }}>En livraison</option>
                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Livrée</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Annulée</option>
                </select>
                <button type="submit" class="ml-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Mettre à jour
                </button>
            </form>
            
            <a href="{{ route('admin.orders.edit', $order) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Modifier complètement
            </a>
            
            <a href="{{ route('invoice.print', $order) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                <i class="fas fa-print mr-1"></i> Imprimer Facture
            </a>
            
            <a href="{{ route('invoice.receipt', $order) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                <i class="fas fa-receipt mr-1"></i> Reçu
            </a>
            
            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
