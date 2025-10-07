@extends('layouts.super-admin-new-design')

@section('title', 'Tableau de bord - SuperAdmin PeleFood')
@section('description', 'Vue d\'ensemble de votre plateforme PeleFood')

@section('content')
<div class="space-y-8">
    <!-- En-tête du dashboard -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Tableau de bord</h1>
        <p class="text-gray-600 mt-2">Vue d'ensemble de votre plateforme PeleFood</p>
    </div>

    <!-- Métriques principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Restaurants inscrits -->
        <div class="metric-card rounded-xl p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-building text-blue-600"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-600">Restaurants inscrits</p>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">1,247</p>
                    <div class="flex items-center">
                        <span class="text-green-600 text-sm font-semibold mr-2">+12%</span>
                        <span class="text-gray-500 text-sm">Total des restaurants sur la plateforme</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Restaurants actifs -->
        <div class="metric-card rounded-xl p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-600">Restaurants actifs</p>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">1,089</p>
                    <div class="flex items-center">
                        <span class="text-green-600 text-sm font-semibold mr-2">+8%</span>
                        <span class="text-gray-500 text-sm">Abonnements actifs ce mois</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commandes totales -->
        <div class="metric-card rounded-xl p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-shopping-cart text-orange-600"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-600">Commandes totales</p>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">24,567</p>
                    <div class="flex items-center">
                        <span class="text-green-600 text-sm font-semibold mr-2">+23%</span>
                        <span class="text-gray-500 text-sm">Commandes ce mois</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenus générés -->
        <div class="metric-card rounded-xl p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-dollar-sign text-purple-600"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-600">Revenus générés</p>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">142,580 €</p>
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
        <div class="chart-container rounded-xl p-6 card-hover">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Évolution des commandes</h3>
                <p class="text-sm text-gray-600">Commandes par jour cette semaine</p>
            </div>
            <div class="h-64">
                <canvas id="ordersChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Répartition des paiements -->
        <div class="chart-container rounded-xl p-6 card-hover">
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
    <div class="chart-container rounded-xl p-6 card-hover">
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
            <!-- Restaurant #1 -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-sm">LG</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Le Gourmet Dakar</h4>
                        <p class="text-sm text-gray-600">1250 commandes • ★ 4.8</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-gray-900">28,450 €</p>
                    <span class="text-green-600 text-sm font-semibold">+15%</span>
                </div>
            </div>

            <!-- Restaurant #2 -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-sm">CF</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Chez Fatou</h4>
                        <p class="text-sm text-gray-600">980 commandes • ★ 4.7</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-gray-900">24,200 €</p>
                    <span class="text-orange-600 text-sm font-semibold">+12%</span>
                </div>
            </div>

            <!-- Restaurant #3 -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-sm">TR</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Teranga Restaurant</h4>
                        <p class="text-sm text-gray-600">875 commandes • ★ 4.6</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-gray-900">21,800 €</p>
                    <span class="text-green-600 text-sm font-semibold">+18%</span>
                </div>
            </div>

            <!-- Restaurant #4 -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-sm">BC</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Baobab Cuisine</h4>
                        <p class="text-sm text-gray-600">742 commandes • ★ 4.5</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-gray-900">19,500 €</p>
                    <span class="text-gray-600 text-sm font-semibold">+8%</span>
                </div>
            </div>

            <!-- Restaurant #5 -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-sm">Sd</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Saveurs du Sénégal</h4>
                        <p class="text-sm text-gray-600">689 commandes • ★ 4.4</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-gray-900">18,200 €</p>
                    <span class="text-green-600 text-sm font-semibold">+22%</span>
                </div>
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
