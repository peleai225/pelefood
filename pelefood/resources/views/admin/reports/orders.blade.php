@extends('layouts.super-admin-new-design')

@section('title', 'Rapport des Commandes - PeleFood')
@section('description', 'Analyse détaillée des commandes de la plateforme')
@section('page-title', 'Rapport des Commandes')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Rapport des Commandes</h1>
            <p class="mt-2 text-lg text-muted-foreground">Analyse détaillée des commandes de la plateforme</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            <a href="{{ route('admin.reports.orders.export') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-download mr-2"></i> Exporter CSV
            </a>
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
                        <p class="text-sm font-medium text-muted-foreground">Total Commandes</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['total_orders']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="shopping-bag" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">En Attente</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['pending_orders']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="clock" class="w-6 h-6 text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Livrées</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['completed_orders']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Annulées</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['cancelled_orders']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="x-circle" class="w-6 h-6 text-red-600 dark:text-red-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Revenus</p>
                        <p class="text-2xl font-bold text-foreground">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="dollar-sign" class="w-6 h-6 text-purple-600 dark:text-purple-400"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Commandes par mois -->
        <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
            <h3 class="text-lg font-semibold text-foreground mb-6">Commandes par mois</h3>
            <div class="h-64">
                <canvas id="ordersChart" width="400" height="160"></canvas>
            </div>
        </div>

        <!-- Revenus par mois -->
        <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
            <h3 class="text-lg font-semibold text-foreground mb-6">Revenus par mois</h3>
            <div class="h-64">
                <canvas id="revenueChart" width="400" height="160"></canvas>
            </div>
        </div>
    </div>

    <!-- Répartition par statut -->
    <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
        <h3 class="text-lg font-semibold text-foreground mb-6">Répartition par statut</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($ordersByStatus as $status => $count)
            <div class="text-center p-4 rounded-lg bg-muted">
                <div class="text-2xl font-bold text-foreground">{{ $count }}</div>
                <div class="text-sm text-muted-foreground">{{ ucfirst($status) }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Top restaurants -->
    <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
        <h3 class="text-lg font-semibold text-foreground mb-6">Top restaurants par commandes</h3>
        <div class="space-y-4">
            @forelse($topRestaurants as $index => $restaurant)
            <div class="flex items-center justify-between p-4 rounded-lg bg-muted">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-primary text-primary-foreground rounded-full flex items-center justify-center">
                        <span class="text-sm font-bold">{{ $index + 1 }}</span>
                    </div>
                    <div>
                        <p class="font-medium text-foreground">{{ $restaurant->name }}</p>
                        <p class="text-sm text-muted-foreground">{{ $restaurant->orders_sum_total_amount ?? 0 }} FCFA de revenus</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold text-foreground">{{ $restaurant->orders_count }} commandes</p>
                </div>
            </div>
            @empty
            <p class="text-center text-muted-foreground py-8">Aucun restaurant avec des commandes</p>
            @endforelse
        </div>
    </div>

    <!-- Commandes récentes -->
    <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
        <h3 class="text-lg font-semibold text-foreground mb-6">Commandes récentes</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-border">
                <thead class="bg-muted">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Restaurant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-card divide-y divide-border">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-muted/50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-foreground">
                            #{{ $order->order_number ?? $order->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-foreground">
                            {{ $order->restaurant->name ?? 'Restaurant supprimé' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-foreground">
                            {{ $order->customer_name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-foreground">
                            {{ number_format($order->total_amount ?? 0, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($order->status === 'delivered') bg-green-100 text-green-800
                                @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-blue-100 text-blue-800
                                @endif">
                                {{ ucfirst($order->status ?? 'N/A') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-muted-foreground">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-muted-foreground">
                            Aucune commande trouvée
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($recentOrders->hasPages())
        <div class="mt-6">
            {{ $recentOrders->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique des commandes par mois
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    const ordersChart = new Chart(ordersCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($monthlyOrders)) !!},
            datasets: [{
                label: 'Commandes',
                data: {!! json_encode(array_values($monthlyOrders)) !!},
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

    // Graphique des revenus par mois
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
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
