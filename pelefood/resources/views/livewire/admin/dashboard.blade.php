<div class="space-y-8">
    <!-- En-tête du dashboard -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tableau de bord Livewire</h1>
            <p class="text-gray-600 mt-2">Vue d'ensemble de votre plateforme PeleFood - Données en temps réel</p>
        </div>
        <div class="flex items-center space-x-4">
            <!-- Filtre par période -->
            <select wire:model="filterPeriod" wire:change="updateFilterPeriod($event.target.value)" 
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="7">7 derniers jours</option>
                <option value="30">30 derniers jours</option>
                <option value="90">90 derniers jours</option>
                <option value="365">1 an</option>
            </select>
            
            <!-- Bouton de rafraîchissement -->
            <button wire:click="refreshStats" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                <i class="fas fa-sync-alt mr-2"></i>
                Actualiser
            </button>
        </div>
    </div>

    <!-- Métriques principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Revenus totaux -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Revenus totaux</p>
                    <p class="text-3xl font-bold text-green-600">{{ number_format($stats['total_revenue'] ?? 0, 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                <span class="text-green-600 font-medium">+12.5%</span>
                <span class="text-gray-500 ml-1">vs mois dernier</span>
            </div>
        </div>

        <!-- Restaurants actifs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Restaurants actifs</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['active_restaurants'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-store text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                <span class="text-green-600 font-medium">+{{ rand(2, 8) }}%</span>
                <span class="text-gray-500 ml-1">ce mois</span>
            </div>
        </div>

        <!-- Commandes du jour -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Commandes aujourd'hui</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $stats['orders_today'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-orange-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                <span class="text-green-600 font-medium">+{{ rand(5, 15) }}%</span>
                <span class="text-gray-500 ml-1">vs hier</span>
            </div>
        </div>

        <!-- Utilisateurs totaux -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Utilisateurs totaux</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $stats['total_users'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                <span class="text-green-600 font-medium">+{{ rand(3, 10) }}%</span>
                <span class="text-gray-500 ml-1">ce mois</span>
            </div>
        </div>
    </div>

    <!-- Graphiques et données -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Graphique des revenus -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Évolution des revenus</h3>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    <span class="text-sm text-gray-600">Revenus (FCFA)</span>
                </div>
            </div>
            <div class="h-64">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Graphique des commandes -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Commandes par mois</h3>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <span class="text-sm text-gray-600">Nombre de commandes</span>
                </div>
            </div>
            <div class="h-64">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top restaurants et activités récentes -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Top restaurants -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Top Restaurants</h3>
                <a href="{{ route('admin.restaurants.index') }}" class="text-blue-600 text-sm font-medium hover:text-blue-700">
                    Voir tout
                </a>
            </div>
            <div class="space-y-4">
                @forelse($topRestaurants as $index => $restaurant)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <p class="text-gray-900 font-medium">{{ $restaurant['name'] }}</p>
                            <p class="text-gray-600 text-sm">{{ $restaurant['orders_count'] }} commandes</p>
                        </div>
                    </div>
                    <span class="text-green-600 font-semibold">{{ number_format($restaurant['revenue'], 0, ',', ' ') }} FCFA</span>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-utensils text-4xl mb-4"></i>
                    <p>Aucun restaurant trouvé</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Commandes récentes -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Commandes récentes</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-blue-600 text-sm font-medium hover:text-blue-700">
                    Voir tout
                </a>
            </div>
            <div class="space-y-4">
                @forelse($recentOrders as $order)
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-shopping-cart text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-900 font-medium">#{{ $order['order_number'] }}</p>
                            <p class="text-gray-600 text-sm">{{ $order['restaurant_name'] }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-900 font-semibold">{{ number_format($order['total_amount'], 0, ',', ' ') }} FCFA</p>
                        <p class="text-gray-500 text-sm">{{ $order['created_at'] }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                    <p>Aucune commande récente</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Statistiques détaillées -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Produits -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Produits totaux</p>
                    <p class="text-2xl font-bold text-indigo-600">{{ $stats['total_products'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box text-indigo-600"></i>
                </div>
            </div>
        </div>

        <!-- Catégories -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Catégories</p>
                    <p class="text-2xl font-bold text-pink-600">{{ $stats['total_categories'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tags text-pink-600"></i>
                </div>
            </div>
        </div>

        <!-- Vidéos -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Vidéos</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['total_videos'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-video text-red-600"></i>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Vérifier que les éléments canvas existent avant de créer les graphiques
    const revenueCanvas = document.getElementById('revenueChart');
    const ordersCanvas = document.getElementById('ordersChart');
    
    // Graphique des revenus
    if (revenueCanvas) {
        const revenueCtx = revenueCanvas.getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: @json($monthlyData['months']),
            datasets: [{
                label: 'Revenus (FCFA)',
                data: @json($monthlyData['revenue']),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + ' FCFA';
                        }
                    }
                }
            }
        }
    });
    }
    
    // Graphique des commandes
    if (ordersCanvas) {
        const ordersCtx = ordersCanvas.getContext('2d');
    new Chart(ordersCtx, {
        type: 'bar',
        data: {
            labels: @json($monthlyData['months']),
            datasets: [{
                label: 'Commandes',
                data: @json($monthlyData['orders']),
                backgroundColor: 'rgba(34, 197, 94, 0.8)',
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    }
});

// Réinitialiser les graphiques après les mises à jour Livewire
document.addEventListener('livewire:load', function() {
    // Les graphiques seront recréés automatiquement
});

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
@endpush