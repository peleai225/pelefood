@extends('layouts.super-admin-new-design')

@section('title', 'Dashboard Moderne')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
    <!-- Header avec animations -->
    <div class="bg-white shadow-lg border-b border-slate-200 mb-8">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">Dashboard PeleFood</h1>
                        <p class="text-slate-600">Vue d'ensemble en temps réel</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="bg-white border border-slate-200 rounded-lg px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition-all duration-200 shadow-sm">
                            <i class="fas fa-download mr-2"></i>
                            Exporter
                        </button>
                    </div>
                    <div class="relative">
                        <button class="bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-lg px-4 py-2 text-sm font-medium hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Nouvelle Action
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="px-6 space-y-8">
        <!-- Statistiques principales avec animations -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1: Revenus -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Revenus Totaux</p>
                        <p class="text-3xl font-bold text-slate-900">{{ number_format($stats['total_revenue'] ?? 0, 0, ',', ' ') }} FCFA</p>
                        <div class="flex items-center mt-2">
                            <span class="text-green-600 text-sm font-medium flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +12.5%
                            </span>
                            <span class="text-slate-500 text-sm ml-2">vs mois dernier</span>
                        </div>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-money-bill-wave text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Card 2: Commandes -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Commandes</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $stats['total_orders'] ?? 0 }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-blue-600 text-sm font-medium flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +8.2%
                            </span>
                            <span class="text-slate-500 text-sm ml-2">vs mois dernier</span>
                        </div>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-shopping-cart text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Card 3: Restaurants -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Restaurants</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $stats['total_restaurants'] ?? 0 }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-purple-600 text-sm font-medium flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +5.1%
                            </span>
                            <span class="text-slate-500 text-sm ml-2">vs mois dernier</span>
                        </div>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-store text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Card 4: Utilisateurs -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Utilisateurs</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $stats['total_users'] ?? 0 }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-orange-600 text-sm font-medium flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +15.3%
                            </span>
                            <span class="text-slate-500 text-sm ml-2">vs mois dernier</span>
                        </div>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques et analyses -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Graphique des revenus -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-slate-800">Évolution des Revenus</h3>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-full">7j</button>
                        <button class="px-3 py-1 text-xs font-medium text-slate-600 bg-slate-100 rounded-full">30j</button>
                        <button class="px-3 py-1 text-xs font-medium text-slate-600 bg-slate-100 rounded-full">90j</button>
                    </div>
                </div>
                <div class="h-64 flex items-center justify-center">
                    <canvas id="revenueChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Top restaurants -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-slate-800">Top Restaurants</h3>
                    <button class="text-blue-600 text-sm font-medium hover:text-blue-700">Voir tout</button>
                </div>
                <div class="space-y-4">
                    @forelse($topRestaurants ?? [] as $index => $restaurant)
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl hover:bg-slate-100 transition-colors duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <p class="font-medium text-slate-800">{{ $restaurant->name }}</p>
                                <p class="text-sm text-slate-600">{{ $restaurant->orders_count ?? 0 }} commandes</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-slate-800">{{ number_format($restaurant->total_revenue ?? 0, 0, ',', ' ') }} FCFA</p>
                            <p class="text-sm text-green-600">+{{ rand(5, 25) }}%</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-slate-500">
                        <i class="fas fa-utensils text-4xl mb-4"></i>
                        <p>Aucun restaurant trouvé</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Activité récente -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-slate-800">Activité Récente</h3>
                <button class="text-blue-600 text-sm font-medium hover:text-blue-700">Voir tout</button>
            </div>
            <div class="space-y-4">
                @for($i = 1; $i <= 6; $i++)
                <div class="flex items-center space-x-4 p-4 bg-slate-50 rounded-xl hover:bg-slate-100 transition-colors duration-200">
                    <div class="w-10 h-10 bg-gradient-to-r from-green-400 to-green-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-white text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-slate-800">Nouvelle commande #{{ rand(1000, 9999) }}</p>
                        <p class="text-sm text-slate-600">Restaurant {{ $i }} • {{ number_format(rand(5000, 50000), 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-slate-500">{{ rand(1, 60) }} min</p>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>

<!-- Scripts pour les graphiques -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique des revenus
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul'],
            datasets: [{
                label: 'Revenus (FCFA)',
                data: [120000, 190000, 300000, 500000, 200000, 300000, 450000],
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

    // Animations d'entrée
    const cards = document.querySelectorAll('.bg-white');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endsection
