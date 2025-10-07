@extends('layouts.super-admin-new-design')

@section('page-title', 'Analytics')
@section('page-description', 'Analyses détaillées et métriques de performance')

@section('content')
<div class="space-y-6">
    <!-- En-tête Analytics -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div class="animate-fade-in-up">
            <h1 class="text-3xl font-bold text-white mb-2">📊 Analytics & Métriques</h1>
            <p class="text-gray-400">Analysez les performances de votre plateforme en temps réel</p>
        </div>
        <div class="mt-4 lg:mt-0 flex space-x-3">
            <button class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-xl font-semibold hover:from-blue-600 hover:to-purple-700 transition-all duration-300 hover:scale-105 shadow-lg">
                <i class="fas fa-download mr-2"></i>Export PDF
            </button>
            <button class="px-6 py-3 bg-white/10 text-white rounded-xl font-semibold hover:bg-white/20 transition-all duration-300 hover:scale-105 border border-white/20">
                <i class="fas fa-calendar mr-2"></i>Période
            </button>
        </div>
    </div>

    <!-- Filtres de période -->
    <div class="bg-slate-800/50 backdrop-blur-xl border border-white/10 rounded-2xl p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <span class="text-white font-medium">Période :</span>
                <div class="flex space-x-2">
                    <button class="px-4 py-2 text-sm bg-blue-500/20 text-blue-300 rounded-lg border border-blue-500/30">7j</button>
                    <button class="px-4 py-2 text-sm bg-white/10 text-gray-300 rounded-lg border border-white/20 hover:bg-white/20 transition-colors">30j</button>
                    <button class="px-4 py-2 text-sm bg-white/10 text-gray-300 rounded-lg border border-white/20 hover:bg-white/20 transition-colors">90j</button>
                    <button class="px-4 py-2 text-sm bg-white/10 text-gray-300 rounded-lg border border-white/20 hover:bg-white/20 transition-colors">1an</button>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-white font-medium">Comparer avec :</span>
                <select class="px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Période précédente</option>
                    <option>Même période l'année dernière</option>
                    <option>Moyenne des 3 mois</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Métriques principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Chiffre d'affaires -->
        <div class="group bg-gradient-to-br from-green-500/20 to-emerald-600/20 backdrop-blur-xl border border-green-500/30 rounded-2xl p-6 hover:scale-105 transition-all duration-300 cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-400 text-sm font-medium">Chiffre d'affaires</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ number_format($metrics['total_revenue'] ?? 0, 0, ',', ' ') }} FCFA</p>
                    <p class="text-green-400 text-sm mt-2 flex items-center">
                        <i class="fas fa-chart-line mr-1"></i>
                        Données en temps réel
                    </p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fas fa-euro-sign text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Commandes -->
        <div class="group bg-gradient-to-br from-blue-500/20 to-indigo-600/20 backdrop-blur-xl border border-blue-500/30 rounded-2xl p-6 hover:scale-105 transition-all duration-300 cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-400 text-sm font-medium">Commandes</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ number_format($metrics['total_orders'] ?? 0, 0, ',', ' ') }}</p>
                    <p class="text-blue-400 text-sm mt-2 flex items-center">
                        <i class="fas fa-check-circle mr-1"></i>
                        {{ $metrics['completed_orders'] ?? 0 }} complétées
                    </p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fas fa-shopping-cart text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Panier moyen -->
        <div class="group bg-gradient-to-br from-purple-500/20 to-pink-600/20 backdrop-blur-xl border border-purple-500/30 rounded-2xl p-6 hover:scale-105 transition-all duration-300 cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-400 text-sm font-medium">Panier moyen</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ number_format($metrics['avg_order_value'] ?? 0, 0, ',', ' ') }} FCFA</p>
                    <p class="text-purple-400 text-sm mt-2 flex items-center">
                        <i class="fas fa-calculator mr-1"></i>
                        Valeur moyenne par commande
                    </p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fas fa-shopping-basket text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Taux de conversion -->
        <div class="group bg-gradient-to-br from-orange-500/20 to-red-600/20 backdrop-blur-xl border border-orange-500/30 rounded-2xl p-6 hover:scale-105 transition-all duration-300 cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-400 text-sm font-medium">Taux de conversion</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ number_format($performanceMetrics['conversion_rate'] ?? 0, 1) }}%</p>
                    <p class="text-orange-400 text-sm mt-2 flex items-center">
                        <i class="fas fa-percentage mr-1"></i>
                        Commandes complétées / Total
                    </p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fas fa-percentage text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques principaux -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Évolution des revenus -->
        <div class="bg-slate-800/50 backdrop-blur-xl border border-white/10 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white">Évolution des Revenus</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-green-400 text-sm">+12.5%</span>
                    <i class="fas fa-arrow-up text-green-400 text-xs"></i>
                </div>
            </div>
            <div class="h-80">
                <canvas id="revenueChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Répartition des commandes par catégorie -->
        <div class="bg-slate-800/50 backdrop-blur-xl border border-white/10 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white">Commandes par Catégorie</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-blue-400 text-sm">Total: 2,847</span>
                </div>
            </div>
            <div class="h-80">
                <canvas id="categoryChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Graphiques secondaires -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Performance par restaurant -->
        <div class="bg-slate-800/50 backdrop-blur-xl border border-white/10 rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Top 5 Restaurants</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 rounded-lg bg-white/5">
                    <div class="flex items-center space-x-3">
                        <span class="w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center text-xs font-bold text-white">1</span>
                        <span class="text-white text-sm">Le Gourmet Parisien</span>
                    </div>
                    <span class="text-green-400 text-sm font-medium">€12,450</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-lg bg-white/5">
                    <div class="flex items-center space-x-3">
                        <span class="w-6 h-6 bg-gray-500 rounded-full flex items-center justify-center text-xs font-bold text-white">2</span>
                        <span class="text-white text-sm">Pizza Express</span>
                    </div>
                    <span class="text-blue-400 text-sm font-medium">€8,920</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-lg bg-white/5">
                    <div class="flex items-center space-x-3">
                        <span class="w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center text-xs font-bold text-white">3</span>
                        <span class="text-white text-sm">Sushi Master</span>
                    </div>
                    <span class="text-purple-400 text-sm font-medium">€7,680</span>
                </div>
            </div>
        </div>

        <!-- Tendances temporelles -->
        <div class="bg-slate-800/50 backdrop-blur-xl border border-white/10 rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Tendances Temporelles</h3>
            <div class="h-48">
                <canvas id="trendChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Métriques de performance -->
        <div class="bg-slate-800/50 backdrop-blur-xl border border-white/10 rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">KPI Performance</h3>
            <div class="space-y-4">
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto mb-3 relative">
                        <svg class="w-20 h-20 transform -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="35" stroke="rgba(255,255,255,0.1)" stroke-width="8" fill="none"/>
                            <circle cx="50" cy="50" r="35" stroke="#10b981" stroke-width="8" fill="none" 
                                    stroke-dasharray="220" stroke-dashoffset="66" 
                                    style="stroke-dashoffset: 66;">
                            </circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-lg font-bold text-white">70%</span>
                        </div>
                    </div>
                    <h4 class="text-white font-medium text-sm">Taux de Conversion</h4>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto mb-3 relative">
                        <svg class="w-20 h-20 transform -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="35" stroke="rgba(255,255,255,0.1)" stroke-width="8" fill="none"/>
                            <circle cx="50" cy="50" r="35" stroke="#3b82f6" stroke-width="8" fill="none" 
                                    stroke-dasharray="220" stroke-dashoffset="110"
                                    style="stroke-dashoffset: 110;">
                            </circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-lg font-bold text-white">50%</span>
                        </div>
                    </div>
                    <h4 class="text-white font-medium text-sm">Temps de Réponse</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau détaillé des performances -->
    <div class="bg-slate-800/50 backdrop-blur-xl border border-white/10 rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-white">Détail des Performances</h3>
            <div class="flex space-x-2">
                <button class="px-4 py-2 text-sm bg-blue-500/20 text-blue-300 rounded-lg border border-blue-500/30 hover:bg-blue-500/30 transition-colors">Export CSV</button>
                <button class="px-4 py-2 text-sm bg-white/10 text-gray-300 rounded-lg border border-white/20 hover:bg-white/20 transition-colors">Filtres</button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Restaurant</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Commandes</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Revenus</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Panier Moyen</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Note</th>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Tendance</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($topRestaurants ?? [] as $restaurant)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="py-3 px-4 text-white">{{ $restaurant->name ?? 'Restaurant' }}</td>
                        <td class="py-3 px-4 text-white">{{ $restaurant->orders_count ?? 0 }}</td>
                        <td class="py-3 px-4 text-green-400">{{ number_format($restaurant->orders_sum_total_amount ?? 0, 0, ',', ' ') }} FCFA</td>
                        <td class="py-3 px-4 text-white">
                            {{ $restaurant->orders_count > 0 ? number_format(($restaurant->orders_sum_total_amount ?? 0) / $restaurant->orders_count, 0, ',', ' ') : 0 }} FCFA
                        </td>
                        <td class="py-3 px-4 text-yellow-400">{{ number_format($restaurant->average_rating ?? 4.5, 1) }} ★</td>
                        <td class="py-3 px-4">
                            <span class="text-green-400 text-xs">↗ Actif</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 px-4 text-center text-gray-400">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-utensils text-4xl mb-2"></i>
                                <p>Aucune donnée de restaurant disponible</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuration des couleurs
    const colors = {
        primary: '#3b82f6',
        secondary: '#8b5cf6',
        success: '#10b981',
        warning: '#f59e0b',
        danger: '#ef4444',
        info: '#06b6d4'
    };

    // Graphique des revenus
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
            datasets: [{
                label: 'Revenus (€)',
                data: [1250, 1890, 2100, 1780, 2340, 2890, 3200],
                borderColor: colors.primary,
                backgroundColor: `rgba(59, 130, 246, 0.1)`,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: colors.primary,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255, 255, 255, 0.1)' },
                    ticks: {
                        color: '#9ca3af',
                        callback: function(value) { return '€' + value; }
                    }
                },
                x: {
                    grid: { color: 'rgba(255, 255, 255, 0.1)' },
                    ticks: { color: '#9ca3af' }
                }
            }
        }
    });

    // Graphique des catégories
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pizza', 'Sushi', 'Burger', 'Salades', 'Desserts'],
            datasets: [{
                data: [35, 25, 20, 15, 5],
                backgroundColor: [
                    colors.primary, colors.secondary, colors.success, 
                    colors.warning, colors.danger
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#9ca3af',
                        padding: 20,
                        usePointStyle: true
                    }
                }
            },
            cutout: '60%'
        }
    });

    // Graphique des tendances
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    const trendChart = new Chart(trendCtx, {
        type: 'bar',
        data: {
            labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
            datasets: [{
                label: 'Commandes',
                data: [45, 67, 89, 56, 78, 92, 105],
                backgroundColor: colors.success,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255, 255, 255, 0.1)' },
                    ticks: { color: '#9ca3af' }
                },
                x: {
                    grid: { color: 'rgba(255, 255, 255, 0.1)' },
                    ticks: { color: '#9ca3af' }
                }
            }
        }
    });

    // Animation des éléments au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.animate-fade-in-up').forEach(el => {
        observer.observe(el);
    });
});
</script>
@endsection 