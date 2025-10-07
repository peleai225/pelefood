@extends('layouts.super-admin-new-design')

@section('page-title', 'Analytics')

@section('content')
<div class="animate-fade-in">
    <!-- Header Section -->
    <div class="text-center mb-12">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full mb-6 shadow-lg">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
        </div>
        <h1 class="text-5xl md:text-6xl font-bold bg-gradient-to-r from-gray-900 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-4">
            Analytics
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
            Analysez les performances de votre plateforme avec des données détaillées et des graphiques interactifs.
        </p>
    </div>

    <!-- Analytics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Commandes par Statut -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900">{{ array_sum($analytics['orders_by_status'] ?? []) }}</div>
                    <div class="text-sm text-gray-500">Total</div>
                </div>
            </div>
            <div class="text-gray-600 font-medium">Commandes</div>
            <div class="mt-4 space-y-2">
                @foreach($analytics['orders_by_status'] ?? [] as $status => $count)
                    <div class="flex justify-between text-sm">
                        <span class="capitalize">{{ $status }}</span>
                        <span class="font-semibold">{{ $count }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Revenus Mensuels -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900">{{ number_format(array_sum($analytics['revenue_by_month'] ?? []), 0, ',', ' ') }} €</div>
                    <div class="text-sm text-gray-500">Total</div>
                </div>
            </div>
            <div class="text-gray-600 font-medium">Revenus (12 mois)</div>
            <div class="mt-4 space-y-2">
                @foreach(array_slice($analytics['revenue_by_month'] ?? [], -6) as $month => $revenue)
                    <div class="flex justify-between text-sm">
                        <span>{{ $month }}</span>
                        <span class="font-semibold">{{ number_format($revenue, 0, ',', ' ') }} €</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Produits Populaires -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900">{{ count($analytics['top_products'] ?? []) }}</div>
                    <div class="text-sm text-gray-500">Produits</div>
                </div>
            </div>
            <div class="text-gray-600 font-medium">Top Produits</div>
            <div class="mt-4 space-y-2">
                @foreach(array_slice($analytics['top_products'] ?? [], 0, 3) as $product)
                    <div class="flex justify-between text-sm">
                        <span class="truncate">{{ $product->name }}</span>
                        <span class="font-semibold">{{ $product->total_ordered }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Rétention Client -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900">{{ $analytics['customer_retention']['percentage'] ?? 0 }}%</div>
                    <div class="text-sm text-gray-500">Rétention</div>
                </div>
            </div>
            <div class="text-gray-600 font-medium">Clients Fidèles</div>
            <div class="mt-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span>Total Clients</span>
                    <span class="font-semibold">{{ $analytics['customer_retention']['total'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span>Clients Fidèles</span>
                    <span class="font-semibold">{{ $analytics['customer_retention']['repeat'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <!-- Revenue Chart -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Évolution des Revenus</h3>
                    <p class="text-sm text-gray-500">12 derniers mois</p>
                </div>
            </div>
            <div class="h-64">
                <canvas id="revenueChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Orders Status Chart -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Commandes par Statut</h3>
                    <p class="text-sm text-gray-500">Répartition actuelle</p>
                </div>
            </div>
            <div class="h-64">
                <canvas id="ordersStatusChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Products Table -->
    <div class="card p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6">Top 10 des Produits</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Produit</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Total Commandé</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Restaurant</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($analytics['top_products'] ?? [] as $product)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $product->name }}</td>
                            <td class="py-3 px-4 font-semibold">{{ $product->total_ordered }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $product->restaurant_name ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-8 text-center text-gray-500">
                                <p>Aucun produit trouvé</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- JavaScript pour les graphiques -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($analytics['revenue_by_month'] ?? [])) !!},
            datasets: [{
                label: 'Revenus (€)',
                data: {!! json_encode(array_values($analytics['revenue_by_month'] ?? [])) !!},
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6
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
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value + ' €';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Orders Status Chart
    const ordersStatusCtx = document.getElementById('ordersStatusChart').getContext('2d');
    new Chart(ordersStatusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($analytics['orders_by_status'] ?? [])) !!},
            datasets: [{
                data: {!! json_encode(array_values($analytics['orders_by_status'] ?? [])) !!},
                backgroundColor: [
                    '#10b981',
                    '#f59e0b',
                    '#ef4444',
                    '#8b5cf6',
                    '#3b82f6'
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
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                }
            },
            cutout: '60%'
        }
    });
});
</script>
@endsection 