@extends('layouts.super-admin-new-design')

@section('title', 'Super Admin Dashboard')
@section('page-title', 'Super Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header Super Admin -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-crown text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Super Admin</h1>
                    <p class="text-gray-600">Contrôle total de la plateforme PeleFood</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Indicateur de statut système -->
                <div class="flex items-center space-x-2 bg-green-50 border border-green-200 rounded-lg px-4 py-2">
                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-green-800 text-sm font-medium">Système Opérationnel</span>
                </div>
                <!-- Actions rapides -->
                <button class="bg-orange-500 text-white rounded-lg px-4 py-2 text-sm font-medium hover:bg-orange-600 transition-colors">
                    <i class="fas fa-cog mr-2"></i>
                    Paramètres
                </button>
            </div>
        </div>
    </div>

    <!-- Métriques globales en temps réel -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Revenus totaux -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Revenus Totaux</p>
                    <p class="text-3xl font-bold text-gray-900">
                        {{ number_format($stats['total_revenue'] ?? 0, 0, ',', ' ') }} FCFA
                    </p>
                    <div class="flex items-center mt-2">
                        <span class="text-green-600 text-sm font-medium flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i>
                            +24.5%
                        </span>
                        <span class="text-gray-500 text-sm ml-2">vs mois dernier</span>
                    </div>
                </div>
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-chart-line text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Restaurants actifs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Restaurants Actifs</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['active_restaurants'] ?? 0 }}</p>
                    <div class="flex items-center mt-2">
                        <span class="text-blue-600 text-sm font-medium flex items-center">
                            <i class="fas fa-store mr-1"></i>
                            En ligne
                        </span>
                    </div>
                </div>
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-store text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Commandes aujourd'hui -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Commandes Aujourd'hui</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['today_orders'] ?? 0 }}</p>
                    <div class="flex items-center mt-2">
                        <span class="text-orange-600 text-sm font-medium flex items-center">
                            <i class="fas fa-shopping-cart mr-1"></i>
                            En cours
                        </span>
                    </div>
                </div>
                <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-shopping-cart text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Utilisateurs totaux -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Utilisateurs Totaux</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] ?? 0 }}</p>
                    <div class="flex items-center mt-2">
                        <span class="text-purple-600 text-sm font-medium flex items-center">
                            <i class="fas fa-users mr-1"></i>
                            Inscrits
                        </span>
                    </div>
                </div>
                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions Rapides</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <button class="p-4 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 transition-colors group">
                <div class="flex items-center justify-center mb-2">
                    <i class="fas fa-plus text-blue-600 text-2xl"></i>
                </div>
                <p class="text-blue-800 font-medium text-sm">Nouveau Restaurant</p>
            </button>
            <button class="p-4 bg-green-50 border border-green-200 rounded-xl hover:bg-green-100 transition-colors group">
                <div class="flex items-center justify-center mb-2">
                    <i class="fas fa-chart-bar text-green-600 text-2xl"></i>
                </div>
                <p class="text-green-800 font-medium text-sm">Rapports</p>
            </button>
            <button class="p-4 bg-orange-50 border border-orange-200 rounded-xl hover:bg-orange-100 transition-colors group">
                <div class="flex items-center justify-center mb-2">
                    <i class="fas fa-cog text-orange-600 text-2xl"></i>
                </div>
                <p class="text-orange-800 font-medium text-sm">Paramètres</p>
            </button>
            <button class="p-4 bg-red-50 border border-red-200 rounded-xl hover:bg-red-100 transition-colors group">
                <div class="flex items-center justify-center mb-2">
                    <i class="fas fa-shield-alt text-red-600 text-2xl"></i>
                </div>
                <p class="text-red-800 font-medium text-sm">Sécurité</p>
            </button>
        </div>
    </div>

    <!-- Graphiques et statistiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Graphique des revenus -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Évolution des Revenus</h3>
            <div class="h-64">
                <canvas id="revenueChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Top restaurants -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Restaurants</h3>
            <div class="space-y-4">
                @forelse($topRestaurants ?? [] as $index => $restaurant)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <p class="text-gray-900 font-medium">{{ $restaurant->name }}</p>
                            <p class="text-gray-600 text-sm">{{ $restaurant->orders_count ?? 0 }} commandes</p>
                        </div>
                    </div>
                    <span class="text-green-600 font-semibold">{{ number_format($restaurant->total_revenue ?? 0, 0, ',', ' ') }} FCFA</span>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-utensils text-4xl mb-4"></i>
                    <p>Aucun restaurant trouvé</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
// Graphique des revenus
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
            datasets: [{
                label: 'Revenus (FCFA)',
                data: [1200000, 1900000, 3000000, 5000000, 2000000, 3000000],
                borderColor: 'rgb(249, 115, 22)',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
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
});
</script>
@endsection