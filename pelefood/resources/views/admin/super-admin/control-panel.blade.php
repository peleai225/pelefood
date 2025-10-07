@extends('layouts.super-admin-new-design')

@section('title', 'Panneau de Contrôle Super Admin')
@section('page-title', 'Panneau de Contrôle')

@section('content')
<div class="space-y-6">
    <!-- Header avec actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-cogs text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Panneau de Contrôle</h2>
                    <p class="text-gray-600">Gestion avancée de la plateforme</p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                <button class="bg-red-50 text-red-600 rounded-lg px-4 py-2 text-sm font-medium hover:bg-red-100 transition-colors border border-red-200">
                    <i class="fas fa-power-off mr-2"></i>
                    Mode Urgence
                </button>
                <button class="bg-orange-500 text-white rounded-lg px-4 py-2 text-sm font-medium hover:bg-orange-600 transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Sauvegarder
                </button>
            </div>
        </div>
    </div>

    <!-- Onglets de contrôle -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-wrap gap-2 mb-6 overflow-x-auto">
            <button onclick="switchTab('system')" class="tab-button active px-4 sm:px-6 py-3 rounded-lg text-sm font-medium transition-all duration-200 whitespace-nowrap" data-tab="system">
                <i class="fas fa-server mr-2"></i>
                <span class="hidden sm:inline">Système</span>
                <span class="sm:hidden">Sys</span>
            </button>
            <button onclick="switchTab('users')" class="tab-button px-4 sm:px-6 py-3 rounded-lg text-sm font-medium transition-all duration-200 whitespace-nowrap" data-tab="users">
                <i class="fas fa-users mr-2"></i>
                <span class="hidden sm:inline">Utilisateurs</span>
                <span class="sm:hidden">Users</span>
            </button>
            <button onclick="switchTab('payments')" class="tab-button px-4 sm:px-6 py-3 rounded-lg text-sm font-medium transition-all duration-200 whitespace-nowrap" data-tab="payments">
                <i class="fas fa-credit-card mr-2"></i>
                <span class="hidden sm:inline">Paiements</span>
                <span class="sm:hidden">Pay</span>
            </button>
            <button onclick="switchTab('analytics')" class="tab-button px-4 sm:px-6 py-3 rounded-lg text-sm font-medium transition-all duration-200 whitespace-nowrap" data-tab="analytics">
                <i class="fas fa-chart-line mr-2"></i>
                <span class="hidden sm:inline">Analytics</span>
                <span class="sm:hidden">Stats</span>
            </button>
            <button onclick="switchTab('security')" class="tab-button px-4 sm:px-6 py-3 rounded-lg text-sm font-medium transition-all duration-200 whitespace-nowrap" data-tab="security">
                <i class="fas fa-shield-alt mr-2"></i>
                <span class="hidden sm:inline">Sécurité</span>
                <span class="sm:hidden">Sec</span>
            </button>
        </div>

        <!-- Contenu des onglets -->
        <div id="tab-content">
            <!-- Onglet Système -->
            <div id="tab-system" class="tab-content active">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Statut des services -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Statut des Services</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                                    <span class="text-gray-900">API Principale</span>
                                </div>
                                <span class="text-green-600 text-sm font-medium">Opérationnel</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                                    <span class="text-gray-900">Base de Données</span>
                                </div>
                                <span class="text-green-600 text-sm font-medium">Connectée</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-yellow-400 rounded-full animate-pulse"></div>
                                    <span class="text-gray-900">Cache Redis</span>
                                </div>
                                <span class="text-yellow-600 text-sm font-medium">Maintenance</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                                    <span class="text-gray-900">Queue Jobs</span>
                                </div>
                                <span class="text-green-600 text-sm font-medium">Actif</span>
                            </div>
                        </div>
                    </div>

                    <!-- Performances -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Performances</h3>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>CPU</span>
                                    <span>23%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-green-400 to-blue-500 h-2 rounded-full" style="width: 23%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>Mémoire</span>
                                    <span>67%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-yellow-400 to-orange-500 h-2 rounded-full" style="width: 67%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>Stockage</span>
                                    <span>45%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-400 to-purple-500 h-2 rounded-full" style="width: 45%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Onglet Utilisateurs -->
            <div id="tab-users" class="tab-content">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Gestion des Utilisateurs</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-4 bg-white rounded-lg border border-gray-200">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-semibold">A</span>
                                    </div>
                                    <div>
                                        <p class="text-gray-900 font-medium">Admin Principal</p>
                                        <p class="text-gray-600 text-sm">admin@pelefood.com</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-lg text-xs border border-green-200">
                                        Actif
                                    </span>
                                    <button class="px-3 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs border border-blue-200 hover:bg-blue-200 transition-colors">
                                        Modifier
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions Rapides</h3>
                        <div class="space-y-3">
                            <button class="w-full p-3 bg-blue-50 border border-blue-200 rounded-lg text-blue-700 hover:bg-blue-100 transition-colors duration-200">
                                <i class="fas fa-user-plus mr-2"></i>
                                Créer Utilisateur
                            </button>
                            <button class="w-full p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 hover:bg-green-100 transition-colors duration-200">
                                <i class="fas fa-download mr-2"></i>
                                Exporter Liste
                            </button>
                            <button class="w-full p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-700 hover:bg-yellow-100 transition-colors duration-200">
                                <i class="fas fa-key mr-2"></i>
                                Réinitialiser Mots de Passe
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Onglet Paiements -->
            <div id="tab-payments" class="tab-content">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Configuration Paiements</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                <span class="text-gray-900">Stripe</span>
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-lg text-xs border border-green-200">
                                    Actif
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                <span class="text-gray-900">PayPal</span>
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-lg text-xs border border-yellow-200">
                                    Test
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                <span class="text-gray-900">Orange Money</span>
                                <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded-lg text-xs border border-orange-200">
                                    Actif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Transactions Récentes</h3>
                        <div class="space-y-3">
                            @for($i = 1; $i <= 4; $i++)
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                <div>
                                    <p class="text-gray-900 text-sm">Transaction #{{ rand(1000, 9999) }}</p>
                                    <p class="text-gray-600 text-xs">{{ number_format(rand(5000, 50000), 0, ',', ' ') }} FCFA</p>
                                </div>
                                <span class="text-green-600 text-xs font-medium">Réussie</span>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <!-- Onglet Analytics -->
            <div id="tab-analytics" class="tab-content">
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Analytics Avancées</h3>
                    <div class="h-64">
                        <canvas id="analyticsChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>

            <!-- Onglet Sécurité -->
            <div id="tab-security" class="tab-content">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Sécurité</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                <span class="text-gray-900">SSL/TLS</span>
                                <span class="text-green-600 text-sm font-medium">✓ Actif</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                <span class="text-gray-900">Firewall</span>
                                <span class="text-green-600 text-sm font-medium">✓ Actif</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                <span class="text-gray-900">DDoS Protection</span>
                                <span class="text-green-600 text-sm font-medium">✓ Actif</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Connexions Suspectes</h3>
                        <div class="space-y-3">
                            <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                                <p class="text-red-800 text-sm font-medium">Tentative de connexion suspecte</p>
                                <p class="text-red-600 text-xs">IP: 192.168.1.100 - Il y a 5min</p>
                            </div>
                            <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <p class="text-yellow-800 text-sm font-medium">Trop de tentatives de connexion</p>
                                <p class="text-yellow-600 text-xs">IP: 10.0.0.50 - Il y a 15min</p>
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
    background: #f3f4f6;
    color: #6b7280;
    border: 1px solid #d1d5db;
}

.tab-button:hover {
    background: #e5e7eb;
    color: #374151;
}

.tab-button.active {
    background: linear-gradient(135deg, #f97316, #ea580c);
    color: white;
    border: 1px solid #ea580c;
    box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
}

.tab-content {
    display: none;
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
                    'rgba(247, 127, 0, 0.8)',
                    'rgba(42, 157, 143, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderColor: [
                    'rgba(247, 127, 0, 1)',
                    'rgba(42, 157, 143, 1)',
                    'rgba(34, 197, 94, 1)',
                    'rgba(239, 68, 68, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: 'rgba(255, 255, 255, 0.8)'
                    }
                }
            }
        }
    });
});
</script>
@endsection
