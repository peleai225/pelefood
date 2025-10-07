@extends('layouts.staff')

@section('title', 'Dashboard Staff')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard Staff</h1>
                    <p class="text-gray-600">{{ $restaurant->name }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Connecté en tant que</p>
                        <p class="font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                    </div>
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statistiques en temps réel -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">En attente</p>
                        <p class="text-2xl font-bold text-gray-900" id="pending-count">{{ $stats['pending_orders'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-utensils text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">En préparation</p>
                        <p class="text-2xl font-bold text-gray-900" id="preparing-count">{{ $stats['preparing_orders'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Prêtes</p>
                        <p class="text-2xl font-bold text-gray-900" id="ready-count">{{ $stats['ready_orders'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-day text-purple-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Aujourd'hui</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['today_orders'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commandes en temps réel -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Commandes en attente -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-clock text-yellow-600 mr-2"></i>
                        Commandes en attente
                        <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full" id="pending-badge">
                            {{ $stats['pending_orders'] }}
                        </span>
                    </h3>
                </div>
                <div class="p-6" id="pending-orders">
                    @forelse($recentOrders->where('status', 'pending') as $order)
                        @include('staff.partials.order-card', ['order' => $order])
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">Aucune commande en attente</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Commandes en préparation -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-utensils text-blue-600 mr-2"></i>
                        En préparation
                        <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full" id="preparing-badge">
                            {{ $stats['preparing_orders'] }}
                        </span>
                    </h3>
                </div>
                <div class="p-6" id="preparing-orders">
                    @forelse($recentOrders->where('status', 'preparing') as $order)
                        @include('staff.partials.order-card', ['order' => $order])
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-utensils text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">Aucune commande en préparation</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Commandes prêtes -->
        <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-check text-green-600 mr-2"></i>
                    Commandes prêtes
                    <span class="ml-2 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full" id="ready-badge">
                        {{ $stats['ready_orders'] }}
                    </span>
                </h3>
            </div>
            <div class="p-6" id="ready-orders">
                @forelse($recentOrders->where('status', 'ready') as $order)
                    @include('staff.partials.order-card', ['order' => $order])
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-check text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Aucune commande prête</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Notifications toast -->
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

<script>
// Mise à jour en temps réel
function updateStats() {
    fetch('/staff/api/stats')
        .then(response => response.json())
        .then(data => {
            document.getElementById('pending-count').textContent = data.pending_orders;
            document.getElementById('preparing-count').textContent = data.preparing_orders;
            document.getElementById('ready-count').textContent = data.ready_orders;
            
            document.getElementById('pending-badge').textContent = data.pending_orders;
            document.getElementById('preparing-badge').textContent = data.preparing_orders;
            document.getElementById('ready-badge').textContent = data.ready_orders;
        })
        .catch(error => console.error('Erreur lors de la mise à jour des stats:', error));
}

// Mise à jour toutes les 30 secondes
setInterval(updateStats, 30000);

// Fonction pour afficher les notifications
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `bg-${type === 'success' ? 'green' : 'red'}-500 text-white px-6 py-4 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300`;
    toast.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.getElementById('toast-container').appendChild(toast);
    
    // Animation d'entrée
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Suppression automatique
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 5000);
}

// Écouter les événements de mise à jour de statut
document.addEventListener('orderStatusUpdated', function(e) {
    showToast(e.detail.message, 'success');
    updateStats();
});
</script>
@endsection 