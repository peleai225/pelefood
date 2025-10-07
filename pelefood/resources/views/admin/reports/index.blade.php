@extends('layouts.super-admin-new-design')

@section('page-title', 'Rapports')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Rapports & Analytics</h1>
                <p class="mt-2 text-gray-600">Analysez les performances de votre plateforme</p>
            </div>
            <div class="flex items-center space-x-3">
                <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <i class="fas fa-download mr-2"></i>
                    Exporter
                </button>
                <button class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <i class="fas fa-cog mr-2"></i>
                    Configurer
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 fade-in" style="animation-delay: 0.1s;">
        <div class="card-hover bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-building text-white text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Tenants</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_tenants'] }}</p>
                </div>
            </div>
        </div>

        <div class="card-hover bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-store text-white text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Restaurants</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_restaurants'] }}</p>
                </div>
            </div>
        </div>

        <div class="card-hover bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-white text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Commandes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                </div>
            </div>
        </div>

        <div class="card-hover bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Revenus</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 fade-in" style="animation-delay: 0.2s;">
        <!-- Orders by Month -->
        <div class="card-hover bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Commandes par mois</h3>
                <a href="{{ route('admin.reports.orders') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Voir détail</a>
            </div>
            <div class="h-48 flex items-end justify-between space-x-2">
                @php
                    $maxOrders = max(array_column($reports['orders_by_month'] ?? [], 'count')) ?: 1;
                @endphp
                @foreach($reports['orders_by_month'] ?? [] as $monthData)
                    @php
                        $height = $monthData['count'] > 0 ? ($monthData['count'] / $maxOrders) * 100 : 0;
                        $monthNames = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
                        $monthName = $monthNames[$monthData['month'] - 1] ?? $monthData['month'];
                    @endphp
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-full bg-gray-200 rounded-t-lg relative group">
                            <div class="bg-gradient-to-t from-blue-500 to-blue-600 rounded-t-lg transition-all duration-300 group-hover:from-blue-600 group-hover:to-blue-700" 
                                 style="height: {{ $height }}%"></div>
                            <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                {{ $monthData['count'] }}
                            </div>
                        </div>
                        <span class="text-xs text-gray-500 mt-2">{{ $monthName }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Revenue Trends -->
        <div class="card-hover bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Évolution des revenus</h3>
                <a href="{{ route('admin.reports.revenue') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Voir détail</a>
            </div>
            <div class="h-48 flex items-end justify-between space-x-2">
                @php
                    $maxRevenue = max(array_column($reports['revenue_trends'] ?? [], 'revenue')) ?: 1;
                @endphp
                @foreach($reports['revenue_trends'] ?? [] as $trend)
                    @php
                        $height = $trend['revenue'] > 0 ? ($trend['revenue'] / $maxRevenue) * 100 : 0;
                    @endphp
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-full bg-gray-200 rounded-t-lg relative group">
                            <div class="bg-gradient-to-t from-green-500 to-green-600 rounded-t-lg transition-all duration-300 group-hover:from-green-600 group-hover:to-green-700" 
                                 style="height: {{ $height }}%"></div>
                            <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                {{ number_format($trend['revenue'], 0, ',', ' ') }}
                            </div>
                        </div>
                        <span class="text-xs text-gray-500 mt-2">{{ \Carbon\Carbon::parse($trend['date'])->format('d/m') }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Detailed Reports -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 fade-in" style="animation-delay: 0.3s;">
        <!-- Top Restaurants -->
        <div class="card-hover bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Top 10 Restaurants</h3>
                <a href="{{ route('admin.reports.restaurants') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Voir tout</a>
            </div>
            <div class="space-y-3">
                @foreach($reports['top_restaurants'] ?? [] as $restaurant)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-medium text-sm">{{ $loop->iteration }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $restaurant->name }}</p>
                                <p class="text-xs text-gray-500">{{ $restaurant->orders_count }} commandes</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-900">{{ number_format($restaurant->orders_sum_total_amount ?? 0, 0, ',', ' ') }} FCFA</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Orders by Status -->
        <div class="card-hover bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Commandes par statut</h3>
                <a href="{{ route('admin.reports.orders') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Voir détail</a>
            </div>
            <div class="space-y-4">
                @foreach($reports['orders_by_status'] ?? [] as $status)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 rounded-full 
                                @if($status->status === 'completed') bg-green-500
                                @elseif($status->status === 'pending') bg-yellow-500
                                @elseif($status->status === 'cancelled') bg-red-500
                                @else bg-gray-500
                                @endif">
                            </div>
                            <span class="text-sm font-medium text-gray-900 capitalize">{{ $status->status }}</span>
                        </div>
                        <span class="text-sm text-gray-600">{{ $status->count }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Export Section -->
    <div class="card-hover bg-white rounded-xl p-6 shadow-sm border border-gray-200 fade-in" style="animation-delay: 0.4s;">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Exporter les rapports</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.reports.export', ['type' => 'orders']) }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all duration-200 group">
                <i class="fas fa-shopping-cart text-blue-500 mr-3 group-hover:text-blue-600"></i>
                <div>
                    <p class="font-medium text-gray-900">Commandes</p>
                    <p class="text-sm text-gray-500">CSV, PDF</p>
                </div>
            </a>

            <a href="{{ route('admin.reports.export', ['type' => 'revenue']) }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition-all duration-200 group">
                <i class="fas fa-chart-line text-green-500 mr-3 group-hover:text-green-600"></i>
                <div>
                    <p class="font-medium text-gray-900">Revenus</p>
                    <p class="text-sm text-gray-500">CSV, PDF</p>
                </div>
            </a>

            <a href="{{ route('admin.reports.export', ['type' => 'restaurants']) }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-orange-300 hover:bg-orange-50 transition-all duration-200 group">
                <i class="fas fa-store text-orange-500 mr-3 group-hover:text-orange-600"></i>
                <div>
                    <p class="font-medium text-gray-900">Restaurants</p>
                    <p class="text-sm text-gray-500">CSV, PDF</p>
                </div>
            </a>

            <a href="{{ route('admin.reports.export', ['type' => 'tenants']) }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 group">
                <i class="fas fa-building text-purple-500 mr-3 group-hover:text-purple-600"></i>
                <div>
                    <p class="font-medium text-gray-900">Tenants</p>
                    <p class="text-sm text-gray-500">CSV, PDF</p>
                </div>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation des cartes au scroll
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

    // Observer toutes les cartes
    document.querySelectorAll('.card-hover').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s ease-out';
        observer.observe(card);
    });
});
</script>
@endpush
@endsection 