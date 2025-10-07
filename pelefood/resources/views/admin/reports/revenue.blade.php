@extends('layouts.super-admin-new-design')

@section('title', 'Rapport des Revenus - PeleFood')
@section('description', 'Analyse détaillée des revenus de la plateforme')
@section('page-title', 'Rapport des Revenus')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Rapport des Revenus</h1>
            <p class="mt-2 text-lg text-muted-foreground">Analyse détaillée des revenus de la plateforme</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            <a href="{{ route('admin.reports.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Retour aux rapports
            </a>
        </div>
    </div>

    <!-- Statistiques principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Revenus Totaux</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="dollar-sign" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Ce Mois</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['monthly_revenue'], 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="calendar" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Aujourd'hui</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['daily_revenue'], 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="trending-up" class="w-6 h-6 text-purple-600 dark:text-purple-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Panier Moyen</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['average_order_value'], 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="shopping-cart" class="w-6 h-6 text-orange-600 dark:text-orange-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Commandes</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['total_orders']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="package" class="w-6 h-6 text-red-600 dark:text-red-400"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Croissance des revenus -->
    @if($revenueGrowth != 0)
    <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-foreground">Croissance des revenus</h3>
                <p class="text-muted-foreground">Comparaison avec le mois précédent</p>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold {{ $revenueGrowth > 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $revenueGrowth > 0 ? '+' : '' }}{{ number_format($revenueGrowth, 1) }}%
                </div>
                <p class="text-sm text-muted-foreground">
                    {{ $revenueGrowth > 0 ? 'Augmentation' : 'Diminution' }}
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Revenus par mois -->
        <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
            <h3 class="text-lg font-semibold text-foreground mb-6">Revenus par mois</h3>
            <div class="h-64">
                <canvas id="monthlyRevenueChart" width="400" height="160"></canvas>
            </div>
        </div>

        <!-- Revenus par jour -->
        <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
            <h3 class="text-lg font-semibold text-foreground mb-6">Revenus par jour (30 derniers jours)</h3>
            <div class="h-64">
                <canvas id="dailyRevenueChart" width="400" height="160"></canvas>
            </div>
        </div>
    </div>

    <!-- Répartition par statut -->
    <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
        <h3 class="text-lg font-semibold text-foreground mb-6">Revenus par statut de commande</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($revenueByStatus as $status => $revenue)
            <div class="text-center p-4 rounded-lg bg-muted">
                <div class="text-2xl font-bold text-foreground">{{ number_format($revenue, 0, ',', ' ') }} FCFA</div>
                <div class="text-sm text-muted-foreground">{{ ucfirst($status) }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Top restaurants par revenus -->
    <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
        <h3 class="text-lg font-semibold text-foreground mb-6">Top restaurants par revenus</h3>
        <div class="space-y-4">
            @forelse($revenueByRestaurant as $index => $restaurant)
            <div class="flex items-center justify-between p-4 rounded-lg bg-muted">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-primary text-primary-foreground rounded-full flex items-center justify-center">
                        <span class="text-sm font-bold">{{ $index + 1 }}</span>
                    </div>
                    <div>
                        <p class="font-medium text-foreground">{{ $restaurant->name }}</p>
                        <p class="text-sm text-muted-foreground">{{ $restaurant->orders_count }} commandes</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold text-foreground">{{ number_format($restaurant->orders_sum_total_amount ?? 0, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
            @empty
            <p class="text-center text-muted-foreground py-8">Aucun restaurant avec des revenus</p>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique des revenus par mois
    const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
    const monthlyRevenueChart = new Chart(monthlyRevenueCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($monthlyRevenue)) !!},
            datasets: [{
                label: 'Revenus (FCFA)',
                data: {!! json_encode(array_values($monthlyRevenue)) !!},
                backgroundColor: 'rgba(16, 185, 129, 0.8)',
                borderColor: 'rgb(16, 185, 129)',
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
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('fr-FR').format(value) + ' FCFA';
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

    // Graphique des revenus par jour
    const dailyRevenueCtx = document.getElementById('dailyRevenueChart').getContext('2d');
    const dailyRevenueChart = new Chart(dailyRevenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($dailyRevenue)) !!},
            datasets: [{
                label: 'Revenus (FCFA)',
                data: {!! json_encode(array_values($dailyRevenue)) !!},
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
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('fr-FR').format(value) + ' FCFA';
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
});
</script>
@endpush
@endsection
