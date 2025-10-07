@extends('layouts.super-admin-new-design')

@section('title', 'Rapports & Analytics - PeleFood')
@section('description', 'Analyses et rapports détaillés de la plateforme')

@section('content')
<div class="space-y-6">
    <!-- En-tête de la page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Rapports & Analytics</h1>
            <p class="text-gray-600 mt-2">Analyses détaillées et insights de la plateforme</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition-colors">
                <i class="fas fa-download mr-2"></i>
                Exporter Rapport
            </button>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors">
                <i class="fas fa-calendar mr-2"></i>
                Période Personnalisée
            </button>
        </div>
    </div>

    <!-- Filtres de période -->
    <div class="bg-white rounded-xl p-6 border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Période</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="today">Aujourd'hui</option>
                    <option value="week">Cette semaine</option>
                    <option value="month" selected>Ce mois</option>
                    <option value="quarter">Ce trimestre</option>
                    <option value="year">Cette année</option>
                    <option value="custom">Période personnalisée</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date de début</label>
                <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin</label>
                <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Restaurant</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tous les restaurants</option>
                    <option value="1">Le Gourmet Dakar</option>
                    <option value="2">Chez Fatou</option>
                    <option value="3">Teranga Restaurant</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-700 transition-colors">
                    <i class="fas fa-search mr-2"></i>
                    Générer
                </button>
            </div>
        </div>
    </div>

    <!-- Métriques principales -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Revenus Totaux</p>
                    <p class="text-2xl font-bold text-gray-900">142,580 €</p>
                    <p class="text-sm text-green-600 font-semibold">+18% vs mois dernier</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-euro-sign text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Commandes</p>
                    <p class="text-2xl font-bold text-gray-900">24,567</p>
                    <p class="text-sm text-blue-600 font-semibold">+23% vs mois dernier</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Clients Actifs</p>
                    <p class="text-2xl font-bold text-gray-900">1,045</p>
                    <p class="text-sm text-purple-600 font-semibold">+12% vs mois dernier</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Panier Moyen</p>
                    <p class="text-2xl font-bold text-gray-900">5.8 €</p>
                    <p class="text-sm text-orange-600 font-semibold">+5% vs mois dernier</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-basket text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques principaux -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Évolution des revenus -->
        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Évolution des Revenus</h3>
                <p class="text-sm text-gray-600">Revenus par jour ce mois</p>
            </div>
            <div class="h-64">
                <canvas id="revenueChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Top restaurants par revenus -->
        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Top Restaurants</h3>
                <p class="text-sm text-gray-600">Classement par revenus ce mois</p>
            </div>
            <div class="h-64">
                <canvas id="topRestaurantsChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Analyses détaillées -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Répartition géographique -->
        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Répartition Géographique</h3>
                <p class="text-sm text-gray-600">Commandes par ville</p>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-blue-500 rounded-full mr-3"></div>
                        <span class="text-sm font-medium text-gray-900">Dakar</span>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900">15,234</p>
                        <p class="text-xs text-gray-500">62%</p>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-sm font-medium text-gray-900">Thiès</span>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900">5,678</p>
                        <p class="text-xs text-gray-500">23%</p>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-orange-500 rounded-full mr-3"></div>
                        <span class="text-sm font-medium text-gray-900">Saint-Louis</span>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900">3,655</p>
                        <p class="text-xs text-gray-500">15%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Heures de pointe -->
        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Heures de Pointe</h3>
                <p class="text-sm text-gray-600">Commandes par heure</p>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">12h - 14h</span>
                    <div class="flex-1 mx-3">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 85%"></div>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-gray-900">85%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">19h - 21h</span>
                    <div class="flex-1 mx-3">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 75%"></div>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-gray-900">75%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">08h - 10h</span>
                    <div class="flex-1 mx-3">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-orange-500 h-2 rounded-full" style="width: 45%"></div>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-gray-900">45%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">22h - 24h</span>
                    <div class="flex-1 mx-3">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-500 h-2 rounded-full" style="width: 35%"></div>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-gray-900">35%</span>
                </div>
            </div>
        </div>

        <!-- Satisfaction client -->
        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Satisfaction Client</h3>
                <p class="text-sm text-gray-600">Notes moyennes</p>
            </div>
            <div class="space-y-4">
                <div class="text-center">
                    <div class="text-4xl font-bold text-gray-900 mb-2">4.6</div>
                    <div class="flex justify-center mb-2">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                    <p class="text-sm text-gray-600">Note moyenne globale</p>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span>5 étoiles</span>
                        <span class="font-semibold">68%</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>4 étoiles</span>
                        <span class="font-semibold">22%</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>3 étoiles</span>
                        <span class="font-semibold">8%</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>2 étoiles</span>
                        <span class="font-semibold">2%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau de bord détaillé -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Analyses Détaillées par Restaurant</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restaurant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commandes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenus</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Panier Moyen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Évolution</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Restaurant 1 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">LG</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Le Gourmet Dakar</div>
                                    <div class="text-sm text-gray-500">Dakar</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">1,250</div>
                            <div class="text-sm text-gray-500">+15%</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">28,450 €</div>
                            <div class="text-sm text-gray-500">+18%</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">22.8 €</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-900">4.8</span>
                                <div class="ml-1">
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">+15%</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-chart-line"></i>
                                </button>
                                <button class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Restaurant 2 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">CF</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Chez Fatou</div>
                                    <div class="text-sm text-gray-500">Thiès</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">980</div>
                            <div class="text-sm text-gray-500">+12%</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">24,200 €</div>
                            <div class="text-sm text-gray-500">+15%</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">24.7 €</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-900">4.7</span>
                                <div class="ml-1">
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">+12%</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-chart-line"></i>
                                </button>
                                <button class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique des revenus
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'],
            datasets: [{
                label: 'Revenus (€)',
                data: [3200, 2800, 3500, 4200, 3800, 4500, 4100, 4800, 5200, 4600, 5400, 5800, 6200, 5600, 6400, 6800, 7200, 7800, 8200, 8600, 9000, 8400, 8800, 9200, 9600, 10000, 10400, 9800, 10200, 10600],
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
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
                            return value + '€';
                        }
                    }
                }
            }
        }
    });

    // Graphique des top restaurants
    const topRestaurantsCtx = document.getElementById('topRestaurantsChart').getContext('2d');
    new Chart(topRestaurantsCtx, {
        type: 'bar',
        data: {
            labels: ['Le Gourmet', 'Chez Fatou', 'Teranga', 'Baobab', 'Saveurs'],
            datasets: [{
                label: 'Revenus (€)',
                data: [28450, 24200, 21800, 19500, 18200],
                backgroundColor: [
                    '#3b82f6',
                    '#10b981',
                    '#f59e0b',
                    '#8b5cf6',
                    '#ef4444'
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
                            return value + '€';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection
