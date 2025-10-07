@extends('layouts.super-admin-modern')

@section('title', 'Panneau de Contrôle Moderne - PeleFood')
@section('page-title', 'Panneau de Contrôle')
@section('page-description', 'Gestion avancée et contrôle total de la plateforme')

@section('content')
<div class="space-y-8">
    <!-- Header avec actions -->
    <div class="bg-gradient-to-r from-white via-slate-50 to-white rounded-3xl shadow-2xl border border-slate-200/50 p-8 card-hover">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-6 lg:space-y-0">
            <div class="flex items-center space-x-6">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-3xl flex items-center justify-center shadow-2xl pulse-ring floating-card">
                    <i class="fas fa-cogs text-white text-2xl animate-bounce-in"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 text-gradient">Panneau de Contrôle</h1>
                    <p class="text-slate-600 text-lg font-medium">Gestion avancée de la plateforme</p>
                    <div class="flex items-center space-x-4 mt-2">
                        <div class="flex items-center space-x-2 bg-green-50 border border-green-200 rounded-xl px-4 py-2">
                            <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-green-800 text-sm font-bold">Tous les systèmes opérationnels</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                <button class="bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-2xl px-6 py-3 text-sm font-bold hover:from-red-600 hover:to-pink-600 transition-all duration-300 hover:scale-105 shadow-lg">
                    <i class="fas fa-power-off mr-2"></i>
                    Mode Urgence
                </button>
                <button class="bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-2xl px-6 py-3 text-sm font-bold hover:from-green-600 hover:to-emerald-600 transition-all duration-300 hover:scale-105 shadow-lg">
                    <i class="fas fa-save mr-2"></i>
                    Sauvegarder
                </button>
            </div>
        </div>
    </div>

    <!-- Onglets de contrôle modernes -->
    <div class="bg-gradient-to-r from-white via-slate-50 to-white rounded-3xl shadow-2xl border border-slate-200/50 p-8 card-hover">
        <div class="flex flex-wrap gap-3 mb-8 overflow-x-auto">
            <button onclick="switchTab('system')" class="tab-button active px-6 py-4 rounded-2xl text-sm font-bold transition-all duration-300 whitespace-nowrap hover:scale-105" data-tab="system">
                <i class="fas fa-server mr-3"></i>
                <span>Système</span>
            </button>
            <button onclick="switchTab('users')" class="tab-button px-6 py-4 rounded-2xl text-sm font-bold transition-all duration-300 whitespace-nowrap hover:scale-105" data-tab="users">
                <i class="fas fa-users mr-3"></i>
                <span>Utilisateurs</span>
            </button>
            <button onclick="switchTab('payments')" class="tab-button px-6 py-4 rounded-2xl text-sm font-bold transition-all duration-300 whitespace-nowrap hover:scale-105" data-tab="payments">
                <i class="fas fa-credit-card mr-3"></i>
                <span>Paiements</span>
            </button>
            <button onclick="switchTab('analytics')" class="tab-button px-6 py-4 rounded-2xl text-sm font-bold transition-all duration-300 whitespace-nowrap hover:scale-105" data-tab="analytics">
                <i class="fas fa-chart-line mr-3"></i>
                <span>Analytics</span>
            </button>
            <button onclick="switchTab('security')" class="tab-button px-6 py-4 rounded-2xl text-sm font-bold transition-all duration-300 whitespace-nowrap hover:scale-105" data-tab="security">
                <i class="fas fa-shield-alt mr-3"></i>
                <span>Sécurité</span>
            </button>
        </div>

        <!-- Contenu des onglets -->
        <div id="tab-content">
            <!-- Onglet Système -->
            <div id="tab-system" class="tab-content active">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Statut des services -->
                    <div class="bg-gradient-to-br from-slate-50 to-white rounded-3xl p-8 border border-slate-200/50 shadow-xl card-hover">
                        <h3 class="text-2xl font-bold text-slate-900 mb-6 text-gradient">Statut des Services</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-slate-200 shadow-lg hover:shadow-xl transition-all duration-300">
                                <div class="flex items-center space-x-4">
                                    <div class="w-4 h-4 bg-green-400 rounded-full animate-pulse shadow-lg"></div>
                                    <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center">
                                        <i class="fas fa-server text-green-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-slate-900 font-bold">API Principale</p>
                                        <p class="text-slate-600 text-sm">Serveur principal</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-green-600 text-sm font-bold bg-green-50 px-3 py-1 rounded-xl border border-green-200">Opérationnel</span>
                                    <p class="text-slate-500 text-xs mt-1">99.9% uptime</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-slate-200 shadow-lg hover:shadow-xl transition-all duration-300">
                                <div class="flex items-center space-x-4">
                                    <div class="w-4 h-4 bg-green-400 rounded-full animate-pulse shadow-lg"></div>
                                    <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center">
                                        <i class="fas fa-database text-blue-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-slate-900 font-bold">Base de Données</p>
                                        <p class="text-slate-600 text-sm">MySQL Cluster</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-green-600 text-sm font-bold bg-green-50 px-3 py-1 rounded-xl border border-green-200">Connectée</span>
                                    <p class="text-slate-500 text-xs mt-1">45ms latence</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-slate-200 shadow-lg hover:shadow-xl transition-all duration-300">
                                <div class="flex items-center space-x-4">
                                    <div class="w-4 h-4 bg-yellow-400 rounded-full animate-pulse shadow-lg"></div>
                                    <div class="w-12 h-12 bg-yellow-100 rounded-2xl flex items-center justify-center">
                                        <i class="fas fa-memory text-yellow-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-slate-900 font-bold">Cache Redis</p>
                                        <p class="text-slate-600 text-sm">Cache distribué</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-yellow-600 text-sm font-bold bg-yellow-50 px-3 py-1 rounded-xl border border-yellow-200">Maintenance</span>
                                    <p class="text-slate-500 text-xs mt-1">Redémarrage prévu</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-slate-200 shadow-lg hover:shadow-xl transition-all duration-300">
                                <div class="flex items-center space-x-4">
                                    <div class="w-4 h-4 bg-green-400 rounded-full animate-pulse shadow-lg"></div>
                                    <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center">
                                        <i class="fas fa-tasks text-purple-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-slate-900 font-bold">Queue Jobs</p>
                                        <p class="text-slate-600 text-sm">Traitement asynchrone</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-green-600 text-sm font-bold bg-green-50 px-3 py-1 rounded-xl border border-green-200">Actif</span>
                                    <p class="text-slate-500 text-xs mt-1">12 jobs en cours</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Performances -->
                    <div class="bg-gradient-to-br from-slate-50 to-white rounded-3xl p-8 border border-slate-200/50 shadow-xl card-hover">
                        <h3 class="text-2xl font-bold text-slate-900 mb-6 text-gradient">Performances</h3>
                        <div class="space-y-6">
                            <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-lg">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-slate-700 font-bold">CPU</span>
                                    <span class="text-green-600 font-bold text-lg">23%</span>
                                </div>
                                <div class="w-full bg-slate-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-green-400 to-blue-500 h-3 rounded-full transition-all duration-1000" style="width: 23%"></div>
                                </div>
                            </div>
                            
                            <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-lg">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-slate-700 font-bold">Mémoire</span>
                                    <span class="text-orange-600 font-bold text-lg">67%</span>
                                </div>
                                <div class="w-full bg-slate-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-yellow-400 to-orange-500 h-3 rounded-full transition-all duration-1000" style="width: 67%"></div>
                                </div>
                            </div>
                            
                            <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-lg">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-slate-700 font-bold">Stockage</span>
                                    <span class="text-blue-600 font-bold text-lg">45%</span>
                                </div>
                                <div class="w-full bg-slate-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-blue-400 to-purple-500 h-3 rounded-full transition-all duration-1000" style="width: 45%"></div>
                                </div>
                            </div>
                            
                            <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-lg">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-slate-700 font-bold">Réseau</span>
                                    <span class="text-purple-600 font-bold text-lg">12%</span>
                                </div>
                                <div class="w-full bg-slate-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-purple-400 to-pink-500 h-3 rounded-full transition-all duration-1000" style="width: 12%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Onglet Utilisateurs -->
            <div id="tab-users" class="tab-content">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 bg-gradient-to-br from-slate-50 to-white rounded-3xl p-8 border border-slate-200/50 shadow-xl card-hover">
                        <h3 class="text-2xl font-bold text-slate-900 mb-6 text-gradient">Gestion des Utilisateurs</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-6 bg-white rounded-2xl border border-slate-200 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                                <div class="flex items-center space-x-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                                        <span class="text-white font-bold text-lg">A</span>
                                    </div>
                                    <div>
                                        <p class="text-slate-900 font-bold text-lg">Admin Principal</p>
                                        <p class="text-slate-600">admin@pelefood.com</p>
                                        <p class="text-slate-500 text-sm">Dernière connexion: Il y a 2h</p>
                                    </div>
                                </div>
                                <div class="flex space-x-3">
                                    <span class="px-4 py-2 bg-green-100 text-green-800 rounded-xl text-sm font-bold border border-green-200">
                                        Actif
                                    </span>
                                    <button class="px-4 py-2 bg-blue-100 text-blue-800 rounded-xl text-sm font-bold border border-blue-200 hover:bg-blue-200 transition-colors hover:scale-105">
                                        Modifier
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-slate-50 to-white rounded-3xl p-8 border border-slate-200/50 shadow-xl card-hover">
                        <h3 class="text-2xl font-bold text-slate-900 mb-6 text-gradient">Actions Rapides</h3>
                        <div class="space-y-4">
                            <button class="w-full p-4 bg-gradient-to-r from-blue-50 to-blue-100 border-2 border-blue-200 rounded-2xl text-blue-700 hover:from-blue-100 hover:to-blue-200 transition-all duration-300 hover:scale-105 shadow-lg">
                                <i class="fas fa-user-plus mr-3 text-lg"></i>
                                <span class="font-bold">Créer Utilisateur</span>
                            </button>
                            <button class="w-full p-4 bg-gradient-to-r from-green-50 to-green-100 border-2 border-green-200 rounded-2xl text-green-700 hover:from-green-100 hover:to-green-200 transition-all duration-300 hover:scale-105 shadow-lg">
                                <i class="fas fa-download mr-3 text-lg"></i>
                                <span class="font-bold">Exporter Liste</span>
                            </button>
                            <button class="w-full p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 border-2 border-yellow-200 rounded-2xl text-yellow-700 hover:from-yellow-100 hover:to-yellow-200 transition-all duration-300 hover:scale-105 shadow-lg">
                                <i class="fas fa-key mr-3 text-lg"></i>
                                <span class="font-bold">Réinitialiser MDP</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Onglet Paiements -->
            <div id="tab-payments" class="tab-content">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="bg-gradient-to-br from-slate-50 to-white rounded-3xl p-8 border border-slate-200/50 shadow-xl card-hover">
                        <h3 class="text-2xl font-bold text-slate-900 mb-6 text-gradient">Configuration Paiements</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-slate-200 shadow-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center">
                                        <i class="fab fa-stripe text-blue-600 text-xl"></i>
                                    </div>
                                    <span class="text-slate-900 font-bold">Stripe</span>
                                </div>
                                <span class="px-4 py-2 bg-green-100 text-green-800 rounded-xl text-sm font-bold border border-green-200">
                                    Actif
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-slate-200 shadow-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-yellow-100 rounded-2xl flex items-center justify-center">
                                        <i class="fab fa-paypal text-yellow-600 text-xl"></i>
                                    </div>
                                    <span class="text-slate-900 font-bold">PayPal</span>
                                </div>
                                <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-xl text-sm font-bold border border-yellow-200">
                                    Test
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-slate-200 shadow-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center">
                                        <i class="fas fa-mobile-alt text-orange-600 text-xl"></i>
                                    </div>
                                    <span class="text-slate-900 font-bold">Orange Money</span>
                                </div>
                                <span class="px-4 py-2 bg-orange-100 text-orange-800 rounded-xl text-sm font-bold border border-orange-200">
                                    Actif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-slate-50 to-white rounded-3xl p-8 border border-slate-200/50 shadow-xl card-hover">
                        <h3 class="text-2xl font-bold text-slate-900 mb-6 text-gradient">Transactions Récentes</h3>
                        <div class="space-y-4">
                            @for($i = 1; $i <= 4; $i++)
                            <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-slate-200 shadow-lg hover:shadow-xl transition-all duration-300">
                                <div>
                                    <p class="text-slate-900 font-bold">Transaction #{{ rand(1000, 9999) }}</p>
                                    <p class="text-slate-600 text-sm">{{ number_format(rand(5000, 50000), 0, ',', ' ') }} FCFA</p>
                                </div>
                                <span class="text-green-600 text-sm font-bold bg-green-50 px-3 py-1 rounded-xl border border-green-200">Réussie</span>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <!-- Onglet Analytics -->
            <div id="tab-analytics" class="tab-content">
                <div class="bg-gradient-to-br from-slate-50 to-white rounded-3xl p-8 border border-slate-200/50 shadow-xl card-hover">
                    <h3 class="text-2xl font-bold text-slate-900 mb-6 text-gradient">Analytics Avancées</h3>
                    <div class="h-80">
                        <canvas id="analyticsChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>

            <!-- Onglet Sécurité -->
            <div id="tab-security" class="tab-content">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="bg-gradient-to-br from-slate-50 to-white rounded-3xl p-8 border border-slate-200/50 shadow-xl card-hover">
                        <h3 class="text-2xl font-bold text-slate-900 mb-6 text-gradient">Sécurité</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-slate-200 shadow-lg">
                                <span class="text-slate-900 font-bold">SSL/TLS</span>
                                <span class="text-green-600 text-sm font-bold bg-green-50 px-3 py-1 rounded-xl border border-green-200">✓ Actif</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-slate-200 shadow-lg">
                                <span class="text-slate-900 font-bold">Firewall</span>
                                <span class="text-green-600 text-sm font-bold bg-green-50 px-3 py-1 rounded-xl border border-green-200">✓ Actif</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-slate-200 shadow-lg">
                                <span class="text-slate-900 font-bold">DDoS Protection</span>
                                <span class="text-green-600 text-sm font-bold bg-green-50 px-3 py-1 rounded-xl border border-green-200">✓ Actif</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-slate-50 to-white rounded-3xl p-8 border border-slate-200/50 shadow-xl card-hover">
                        <h3 class="text-2xl font-bold text-slate-900 mb-6 text-gradient">Connexions Suspectes</h3>
                        <div class="space-y-4">
                            <div class="p-4 bg-red-50 border-2 border-red-200 rounded-2xl">
                                <p class="text-red-800 font-bold">Tentative de connexion suspecte</p>
                                <p class="text-red-600 text-sm">IP: 192.168.1.100 - Il y a 5min</p>
                            </div>
                            <div class="p-4 bg-yellow-50 border-2 border-yellow-200 rounded-2xl">
                                <p class="text-yellow-800 font-bold">Trop de tentatives de connexion</p>
                                <p class="text-yellow-600 text-sm">IP: 10.0.0.50 - Il y a 15min</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.tab-button {
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    color: #64748b;
    border: 2px solid #e2e8f0;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.tab-button:hover {
    background: linear-gradient(135deg, #f1f5f9, #cbd5e1);
    color: #475569;
    border-color: #cbd5e1;
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.tab-button.active {
    background: linear-gradient(135deg, #f97316, #ea580c);
    color: white;
    border: 2px solid #ea580c;
    box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.4);
    transform: translateY(-2px);
}

.tab-content {
    display: none;
    animation: fade-in 0.5s ease-in-out;
}

.tab-content.active {
    display: block;
}
</style>

<script>
function switchTab(tabName) {
    // Désactiver tous les onglets
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
    });
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });

    // Activer l'onglet sélectionné
    document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
    document.getElementById(`tab-${tabName}`).classList.add('active');
}

// Graphique analytics
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('analyticsChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Restaurants', 'Utilisateurs', 'Commandes', 'Revenus'],
            datasets: [{
                data: [45, 892, 1234, 2500000],
                backgroundColor: [
                    'rgba(249, 115, 22, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderColor: [
                    'rgba(249, 115, 22, 1)',
                    'rgba(59, 130, 246, 1)',
                    'rgba(34, 197, 94, 1)',
                    'rgba(239, 68, 68, 1)'
                ],
                borderWidth: 3,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#64748b',
                        font: {
                            size: 14,
                            weight: 'bold'
                        },
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(249, 115, 22, 1)',
                    borderWidth: 1,
                    cornerRadius: 12
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 2000,
                easing: 'easeInOutQuart'
            }
        }
    });
});
</script>
@endsection
