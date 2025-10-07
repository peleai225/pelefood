@extends('layouts.super-admin-new-design')

@section('title', 'Dashboard Super Admin - PeleFood')
@section('description', 'Tableau de bord complet pour la gestion de la plateforme')

@section('content')
<div class="space-y-8">
    <!-- En-tête du dashboard -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Tableau de bord</h1>
        <p class="text-gray-600 mt-2">Vue d'ensemble de votre plateforme PeleFood</p>
    </div>

    <!-- Alertes système -->
    @if(count($systemAlerts) > 0)
    <div class="space-y-3 mb-8">
        @foreach($systemAlerts as $alert)
        <div class="bg-{{ $alert['type'] == 'danger' ? 'red' : ($alert['type'] == 'warning' ? 'yellow' : 'blue') }}-50 border border-{{ $alert['type'] == 'danger' ? 'red' : ($alert['type'] == 'warning' ? 'yellow' : 'blue') }}-200 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="{{ $alert['icon'] }} text-{{ $alert['type'] == 'danger' ? 'red' : ($alert['type'] == 'warning' ? 'yellow' : 'blue') }}-400"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm text-{{ $alert['type'] == 'danger' ? 'red' : ($alert['type'] == 'warning' ? 'yellow' : 'blue') }}-800">
                        {{ $alert['message'] }}
                    </p>
                </div>
                <div class="ml-auto pl-3">
                    <a href="{{ $alert['action'] }}" class="text-{{ $alert['type'] == 'danger' ? 'red' : ($alert['type'] == 'warning' ? 'yellow' : 'blue') }}-600 hover:text-{{ $alert['type'] == 'danger' ? 'red' : ($alert['type'] == 'warning' ? 'yellow' : 'blue') }}-800 text-sm font-medium">
                        Voir →
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Métriques principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Restaurants inscrits -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-building text-blue-600"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-600">Restaurants inscrits</p>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($stats['total_restaurants']) }}</p>
                    <div class="flex items-center">
                        <span class="text-green-600 text-sm font-semibold mr-2">+12%</span>
                        <span class="text-gray-500 text-sm">Total des restaurants sur la plateforme</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Restaurants actifs -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-600">Restaurants actifs</p>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($stats['active_restaurants']) }}</p>
                    <div class="flex items-center">
                        <span class="text-green-600 text-sm font-semibold mr-2">+8%</span>
                        <span class="text-gray-500 text-sm">Abonnements actifs ce mois</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commandes totales -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-shopping-cart text-orange-600"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-600">Commandes totales</p>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($stats['total_orders']) }}</p>
                    <div class="flex items-center">
                        <span class="text-green-600 text-sm font-semibold mr-2">+23%</span>
                        <span class="text-gray-500 text-sm">Commandes ce mois</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenus générés -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-euro-sign text-purple-600"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-600">Revenus générés</p>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} FCFA</p>
                    <div class="flex items-center">
                        <span class="text-green-600 text-sm font-semibold mr-2">+18%</span>
                        <span class="text-gray-500 text-sm">Abonnements + commissions</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Évolution des commandes -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 card-hover">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Évolution des commandes</h3>
                <p class="text-sm text-gray-600">Commandes par jour cette semaine</p>
            </div>
            <div class="h-64">
                <canvas id="ordersChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Répartition des paiements -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 card-hover">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Répartition des paiements</h3>
                <p class="text-sm text-gray-600">Moyens de paiement utilisés ce mois</p>
            </div>
            <div class="h-64">
                <canvas id="paymentsChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Top 5 Restaurants -->
    <div class="bg-white rounded-xl p-6 border border-gray-200 card-hover">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-crown text-yellow-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Top 5 Restaurants</h3>
                    <p class="text-sm text-gray-600">Classement par chiffre d'affaires ce mois</p>
                </div>
            </div>
        </div>
        
        <div class="space-y-4">
            @forelse($topRestaurants->take(5) as $index => $restaurant)
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-sm">{{ strtoupper(substr($restaurant->name, 0, 2)) }}</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $restaurant->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $restaurant->total_orders ?? 0 }} commandes • ★ 4.8</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-gray-900">{{ number_format($restaurant->orders_sum_total_amount ?? 0, 0, ',', ' ') }} FCFA</p>
                    <span class="text-green-600 text-sm font-semibold">+{{ rand(5, 25) }}%</span>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <p class="text-gray-500">Aucun restaurant trouvé</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Statistiques détaillées -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Statistiques des commandes -->
        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistiques des Commandes</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">En attente</span>
                    <span class="font-semibold text-yellow-600">{{ $stats['pending_orders'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Livrées</span>
                    <span class="font-semibold text-green-600">{{ $stats['completed_orders'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Annulées</span>
                    <span class="font-semibold text-red-600">{{ $stats['cancelled_orders'] }}</span>
                </div>
            </div>
        </div>

        <!-- Statistiques des produits -->
        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistiques des Produits</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total produits</span>
                    <span class="font-semibold text-blue-600">{{ $stats['total_products'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Catégories</span>
                    <span class="font-semibold text-purple-600">{{ $stats['total_categories'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Avis</span>
                    <span class="font-semibold text-orange-600">{{ $stats['total_reviews'] }}</span>
                </div>
            </div>
        </div>

        <!-- Statistiques des abonnements -->
        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistiques des Abonnements</h3>
            <div class="space-y-4">
                @foreach($subscriptionStats as $status => $count)
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 capitalize">{{ $status }}</span>
                    <span class="font-semibold text-blue-600">{{ $count }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique des commandes (ligne)
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ordersCtx, {
        type: 'line',
        data: {
            labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
            datasets: [{
                label: 'Commandes',
                data: [1100, 950, 1200, 1350, 1650, 1850, 1400],
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#3b82f6',
                    borderWidth: 1,
                    cornerRadius: 8
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            weight: '500'
                        }
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(107, 114, 128, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            weight: '500'
                        },
                        maxTicksLimit: 5
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // Graphique des paiements (barres)
    const paymentsCtx = document.getElementById('paymentsChart').getContext('2d');
    new Chart(paymentsCtx, {
        type: 'bar',
        data: {
            labels: ['Wave', 'Orange Money', 'MTN Money', 'Visa'],
            datasets: [{
                label: 'Utilisation (%)',
                data: [35, 28, 22, 15],
                backgroundColor: [
                    '#3b82f6',
                    '#f97316',
                    '#10b981',
                    '#8b5cf6'
                ],
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#3b82f6',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + '%';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            weight: '500'
                        }
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(107, 114, 128, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            weight: '500'
                        },
                        callback: function(value) {
                            return value + '%';
                        }
                    },
                    beginAtZero: true,
                    max: 40
                }
            }
        }
    });
});
</script>
@endsection