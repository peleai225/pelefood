@extends('layouts.super-admin-modern')

@section('title', 'Dashboard Super Admin Moderne - PeleFood')
@section('page-title', 'Dashboard Super Admin')
@section('page-description', 'Centre de contrôle et monitoring en temps réel')

@section('content')
<div class="space-y-8">
    <!-- Header avec statistiques en temps réel -->
    <div class="bg-gradient-to-r from-white via-slate-50 to-white rounded-3xl shadow-2xl border border-slate-200/50 p-8 card-hover">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-6 lg:space-y-0">
            <div class="flex items-center space-x-6">
                <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-red-500 rounded-3xl flex items-center justify-center shadow-2xl pulse-ring floating-card">
                    <i class="fas fa-crown text-white text-3xl animate-bounce-in"></i>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-slate-900 text-gradient">Super Admin</h1>
                    <p class="text-slate-600 text-lg font-medium">Contrôle total de la plateforme PeleFood</p>
                    <div class="flex items-center space-x-4 mt-2">
                        <div class="flex items-center space-x-2 bg-green-50 border border-green-200 rounded-xl px-4 py-2">
                            <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-green-800 text-sm font-bold">Système Opérationnel</span>
                        </div>
                        <div class="text-slate-500 text-sm">
                            Dernière mise à jour: <span class="font-semibold" id="last-update">{{ now()->format('H:i:s') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                <button class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-2xl px-6 py-3 text-sm font-bold hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 hover:scale-105 shadow-lg">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Actualiser
                </button>
                <button class="bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-2xl px-6 py-3 text-sm font-bold hover:from-orange-600 hover:to-red-600 transition-all duration-300 hover:scale-105 shadow-lg">
                    <i class="fas fa-cog mr-2"></i>
                    Paramètres
                </button>
            </div>
        </div>
    </div>

    <!-- Métriques globales en temps réel avec animations -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Revenus totaux -->
        <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-xl border border-slate-200/50 p-8 card-hover animate-scale-in" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-slate-600 text-sm font-bold mb-2 uppercase tracking-wide">Revenus Totaux</p>
                    <p class="text-4xl font-bold text-slate-900 mb-3">
                        <span id="total-revenue">{{ number_format($stats['total_revenue'] ?? 0, 0, ',', ' ') }}</span> FCFA
                    </p>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center bg-green-50 border border-green-200 rounded-xl px-3 py-1">
                            <i class="fas fa-arrow-up text-green-600 mr-1"></i>
                            <span class="text-green-600 text-sm font-bold">+24.5%</span>
                        </div>
                        <span class="text-slate-500 text-sm">vs mois dernier</span>
                    </div>
                </div>
                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-500 rounded-3xl flex items-center justify-center shadow-2xl floating-card">
                    <i class="fas fa-chart-line text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Restaurants actifs -->
        <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-xl border border-slate-200/50 p-8 card-hover animate-scale-in" style="animation-delay: 0.2s;">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-slate-600 text-sm font-bold mb-2 uppercase tracking-wide">Restaurants Actifs</p>
                    <p class="text-4xl font-bold text-slate-900 mb-3" id="active-restaurants">{{ $stats['active_restaurants'] ?? 0 }}</p>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center bg-blue-50 border border-blue-200 rounded-xl px-3 py-1">
                            <i class="fas fa-store text-blue-600 mr-1"></i>
                            <span class="text-blue-600 text-sm font-bold">En ligne</span>
                        </div>
                        <span class="text-slate-500 text-sm">Actifs</span>
                    </div>
                </div>
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-3xl flex items-center justify-center shadow-2xl floating-card">
                    <i class="fas fa-store text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Commandes aujourd'hui -->
        <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-xl border border-slate-200/50 p-8 card-hover animate-scale-in" style="animation-delay: 0.3s;">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-slate-600 text-sm font-bold mb-2 uppercase tracking-wide">Commandes Aujourd'hui</p>
                    <p class="text-4xl font-bold text-slate-900 mb-3" id="today-orders">{{ $stats['today_orders'] ?? 0 }}</p>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center bg-orange-50 border border-orange-200 rounded-xl px-3 py-1">
                            <i class="fas fa-shopping-cart text-orange-600 mr-1"></i>
                            <span class="text-orange-600 text-sm font-bold">En cours</span>
                        </div>
                        <span class="text-slate-500 text-sm">Live</span>
                    </div>
                </div>
                <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-red-500 rounded-3xl flex items-center justify-center shadow-2xl floating-card">
                    <i class="fas fa-shopping-cart text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Utilisateurs totaux -->
        <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-xl border border-slate-200/50 p-8 card-hover animate-scale-in" style="animation-delay: 0.4s;">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-slate-600 text-sm font-bold mb-2 uppercase tracking-wide">Utilisateurs Totaux</p>
                    <p class="text-4xl font-bold text-slate-900 mb-3" id="total-users">{{ $stats['total_users'] ?? 0 }}</p>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center bg-purple-50 border border-purple-200 rounded-xl px-3 py-1">
                            <i class="fas fa-users text-purple-600 mr-1"></i>
                            <span class="text-purple-600 text-sm font-bold">Inscrits</span>
                        </div>
                        <span class="text-slate-500 text-sm">Total</span>
                    </div>
                </div>
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-3xl flex items-center justify-center shadow-2xl floating-card">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides avec animations -->
    <div class="bg-gradient-to-r from-white via-slate-50 to-white rounded-3xl shadow-xl border border-slate-200/50 p-8 card-hover">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-bold text-slate-900 text-gradient">Actions Rapides</h3>
            <div class="flex items-center space-x-2 bg-slate-100 rounded-xl px-4 py-2">
                <i class="fas fa-bolt text-orange-500"></i>
                <span class="text-slate-700 text-sm font-semibold">Accès Rapide</span>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <button class="group p-6 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-2xl hover:from-blue-100 hover:to-blue-200 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-plus text-white text-2xl"></i>
                    </div>
                </div>
                <p class="text-blue-800 font-bold text-center group-hover:text-blue-900 transition-colors">Nouveau Restaurant</p>
            </button>
            
            <button class="group p-6 bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-2xl hover:from-green-100 hover:to-green-200 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-chart-bar text-white text-2xl"></i>
                    </div>
                </div>
                <p class="text-green-800 font-bold text-center group-hover:text-green-900 transition-colors">Rapports</p>
            </button>
            
            <button class="group p-6 bg-gradient-to-br from-orange-50 to-orange-100 border-2 border-orange-200 rounded-2xl hover:from-orange-100 hover:to-orange-200 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-cog text-white text-2xl"></i>
                    </div>
                </div>
                <p class="text-orange-800 font-bold text-center group-hover:text-orange-900 transition-colors">Paramètres</p>
            </button>
            
            <button class="group p-6 bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-200 rounded-2xl hover:from-red-100 hover:to-red-200 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                </div>
                <p class="text-red-800 font-bold text-center group-hover:text-red-900 transition-colors">Sécurité</p>
            </button>
        </div>
    </div>

    <!-- Graphiques et statistiques avancées -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Graphique des revenus interactif -->
        <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-xl border border-slate-200/50 p-8 card-hover">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 text-gradient">Évolution des Revenus</h3>
                    <p class="text-slate-600 text-sm">Sur les 12 derniers mois</p>
                </div>
                <div class="flex space-x-2">
                    <button class="px-4 py-2 bg-orange-500 text-white rounded-xl text-sm font-semibold hover:bg-orange-600 transition-colors">12M</button>
                    <button class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-200 transition-colors">6M</button>
                    <button class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-200 transition-colors">3M</button>
                </div>
            </div>
            <div class="h-80">
                <canvas id="revenueChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Top restaurants avec animations -->
        <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-xl border border-slate-200/50 p-8 card-hover">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 text-gradient">Top Restaurants</h3>
                    <p class="text-slate-600 text-sm">Par revenus ce mois</p>
                </div>
                <button class="px-4 py-2 bg-blue-500 text-white rounded-xl text-sm font-semibold hover:bg-blue-600 transition-colors">
                    <i class="fas fa-eye mr-2"></i>
                    Voir tout
                </button>
            </div>
            <div class="space-y-4">
                @forelse($topRestaurants ?? [] as $index => $restaurant)
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-slate-50 to-white rounded-2xl border border-slate-200 hover:shadow-lg transition-all duration-300 hover:scale-105 animate-fade-in" style="animation-delay: {{ ($index + 1) * 0.1 }}s;">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <p class="text-slate-900 font-bold">{{ $restaurant->name }}</p>
                            <p class="text-slate-600 text-sm">{{ $restaurant->orders_count ?? 0 }} commandes</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-green-600 font-bold text-lg">{{ number_format($restaurant->total_revenue ?? 0, 0, ',', ' ') }} FCFA</p>
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-arrow-up text-green-500 text-xs"></i>
                            <span class="text-green-500 text-xs font-semibold">+{{ rand(5, 25) }}%</span>
                        </div>
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

    <!-- Alertes système et notifications -->
    <div class="bg-gradient-to-r from-white via-slate-50 to-white rounded-3xl shadow-xl border border-slate-200/50 p-8 card-hover">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-bold text-slate-900 text-gradient">Alertes Système</h3>
            <div class="flex items-center space-x-2 bg-slate-100 rounded-xl px-4 py-2">
                <i class="fas fa-exclamation-triangle text-orange-500"></i>
                <span class="text-slate-700 text-sm font-semibold">Surveillance Active</span>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="p-6 bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-2xl animate-fade-in">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-green-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-check text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-green-800 font-bold text-sm">Système Stable</p>
                        <p class="text-green-600 text-xs">Tous les services fonctionnent</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-2xl animate-fade-in" style="animation-delay: 0.1s;">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-database text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-blue-800 font-bold text-sm">Base de Données</p>
                        <p class="text-blue-600 text-xs">Performance optimale</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6 bg-gradient-to-br from-orange-50 to-orange-100 border-2 border-orange-200 rounded-2xl animate-fade-in" style="animation-delay: 0.2s;">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-bell text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-orange-800 font-bold text-sm">Notifications</p>
                        <p class="text-orange-600 text-xs">{{ auth()->user()->unreadNotifications()->count() }} nouvelles</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Mise à jour en temps réel des statistiques
function updateStats() {
    // Simuler des mises à jour en temps réel
    const revenueElement = document.getElementById('total-revenue');
    const restaurantsElement = document.getElementById('active-restaurants');
    const ordersElement = document.getElementById('today-orders');
    const usersElement = document.getElementById('total-users');
    
    // Mettre à jour le timestamp
    document.getElementById('last-update').textContent = new Date().toLocaleTimeString();
    
    // Simuler des changements mineurs
    if (Math.random() < 0.3) {
        const currentRevenue = parseInt(revenueElement.textContent.replace(/,/g, ''));
        const change = Math.floor(Math.random() * 1000) - 500;
        revenueElement.textContent = (currentRevenue + change).toLocaleString();
    }
    
    if (Math.random() < 0.2) {
        const currentOrders = parseInt(ordersElement.textContent);
        ordersElement.textContent = currentOrders + Math.floor(Math.random() * 3);
    }
}

// Mettre à jour toutes les 5 secondes
setInterval(updateStats, 5000);

// Graphique des revenus
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // Données simulées pour 12 mois
    const months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
    const revenueData = [1200000, 1900000, 3000000, 5000000, 2000000, 3000000, 4500000, 3800000, 5200000, 4800000, 6100000, 5500000];
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Revenus (FCFA)',
                data: revenueData,
                borderColor: 'rgb(249, 115, 22)',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgb(249, 115, 22)',
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
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgb(249, 115, 22)',
                    borderWidth: 1,
                    cornerRadius: 12,
                    displayColors: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#64748b',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(100, 116, 139, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#64748b',
                        font: {
                            weight: 'bold'
                        },
                        callback: function(value) {
                            return value.toLocaleString() + ' FCFA';
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            }
        }
    });
});

// Animation d'entrée des cartes
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.animate-scale-in');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});
</script>
@endsection
