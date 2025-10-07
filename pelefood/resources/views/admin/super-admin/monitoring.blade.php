@extends('layouts.super-admin-new-design')

@section('title', 'Monitoring Temps Réel')
@section('page-title', 'Monitoring Temps Réel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Monitoring Temps Réel</h2>
                    <p class="text-gray-600">Surveillance en direct de la plateforme</p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                <div class="flex items-center space-x-2 bg-green-50 border border-green-200 rounded-lg px-4 py-2">
                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-green-800 text-sm font-medium">En Direct</span>
                </div>
                <button onclick="toggleAutoRefresh()" class="bg-orange-500 text-white rounded-lg px-4 py-2 text-sm font-medium hover:bg-orange-600 transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Auto-refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Métriques en temps réel -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- Requêtes par seconde -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Requêtes/sec</p>
                    <p class="text-3xl font-bold text-gray-900" id="requests-per-second">0</p>
                    <div class="flex items-center mt-2">
                        <span class="text-green-600 text-sm font-medium flex items-center">
                            <i class="fas fa-arrow-up mr-1"></i>
                            +15%
                        </span>
                    </div>
                </div>
                <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-bolt text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Utilisateurs connectés -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Utilisateurs Actifs</p>
                    <p class="text-3xl font-bold text-gray-900" id="active-users">0</p>
                    <div class="flex items-center mt-2">
                        <span class="text-blue-600 text-sm font-medium flex items-center">
                            <i class="fas fa-users mr-1"></i>
                            En ligne
                        </span>
                    </div>
                </div>
                <div class="w-16 h-16 bg-gradient-to-r from-blue-400 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Latence moyenne -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Latence Moyenne</p>
                    <p class="text-3xl font-bold text-gray-900" id="average-latency">0ms</p>
                    <div class="flex items-center mt-2">
                        <span class="text-green-600 text-sm font-medium flex items-center">
                            <i class="fas fa-check mr-1"></i>
                            Excellent
                        </span>
                    </div>
                </div>
                <div class="w-16 h-16 bg-gradient-to-r from-purple-400 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-tachometer-alt text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Erreurs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium mb-1">Taux d'Erreur</p>
                    <p class="text-3xl font-bold text-gray-900" id="error-rate">0%</p>
                    <div class="flex items-center mt-2">
                        <span class="text-green-600 text-sm font-medium flex items-center">
                            <i class="fas fa-shield-alt mr-1"></i>
                            Stable
                        </span>
                    </div>
                </div>
                <div class="w-16 h-16 bg-gradient-to-r from-orange-400 to-red-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques de monitoring -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Graphique des performances -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-gray-900">Performances en Temps Réel</h3>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-xs font-medium text-white bg-blue-500 rounded-lg">1h</button>
                    <button class="px-3 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded-lg">6h</button>
                    <button class="px-3 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded-lg">24h</button>
                </div>
            </div>
            <div class="h-64">
                <canvas id="performanceChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Graphique des erreurs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-gray-900">Erreurs par Type</h3>
                <button class="text-blue-600 text-sm hover:text-blue-800 transition-colors duration-200">Voir détails</button>
            </div>
            <div class="h-64">
                <canvas id="errorsChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Logs en temps réel -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-gray-900">Logs en Temps Réel</h3>
            <div class="flex items-center space-x-4">
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-xs font-medium text-white bg-green-500 rounded-lg">INFO</button>
                    <button class="px-3 py-1 text-xs font-medium text-white bg-yellow-500 rounded-lg">WARN</button>
                    <button class="px-3 py-1 text-xs font-medium text-white bg-red-500 rounded-lg">ERROR</button>
                </div>
                <button onclick="clearLogs()" class="text-blue-600 text-sm hover:text-blue-800 transition-colors duration-200">
                    <i class="fas fa-trash mr-2"></i>
                    Effacer
                </button>
            </div>
        </div>
        <div class="bg-gray-900 rounded-xl p-4 h-64 overflow-y-auto" id="logs-container">
            <div class="space-y-2" id="logs-list">
                <!-- Les logs seront ajoutés dynamiquement -->
            </div>
        </div>
    </div>

    <!-- Alertes système -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-gray-900">Alertes Système</h3>
            <button class="text-blue-600 text-sm hover:text-blue-800 transition-colors duration-200">Configurer</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="p-4 bg-green-50 border border-green-200 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                    <div>
                        <p class="text-green-800 font-medium text-sm">Système Stable</p>
                        <p class="text-green-600 text-xs">Tous les services fonctionnent normalement</p>
                    </div>
                </div>
            </div>
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-3 h-3 bg-yellow-400 rounded-full animate-pulse"></div>
                    <div>
                        <p class="text-yellow-800 font-medium text-sm">Charge Élevée</p>
                        <p class="text-yellow-600 text-xs">CPU à 85% - Surveillance active</p>
                    </div>
                </div>
            </div>
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-3 h-3 bg-blue-400 rounded-full"></div>
                    <div>
                        <p class="text-blue-800 font-medium text-sm">Mise à Jour</p>
                        <p class="text-blue-600 text-xs">Nouvelle version disponible</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let autoRefresh = true;
let performanceChart, errorsChart;

document.addEventListener('DOMContentLoaded', function() {
    // Initialiser les graphiques
    initCharts();
    
    // Démarrer le monitoring
    startMonitoring();
    
    // Simuler des logs en temps réel
    simulateLogs();
});

function initCharts() {
    // Graphique des performances
    const perfCtx = document.getElementById('performanceChart').getContext('2d');
    performanceChart = new Chart(perfCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Requêtes/sec',
                data: [],
                borderColor: 'rgb(168, 85, 247)',
                backgroundColor: 'rgba(168, 85, 247, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Latence (ms)',
                data: [],
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
                    labels: {
                        color: 'rgba(255, 255, 255, 0.8)'
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                },
                y: {
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.7)'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                }
            }
        }
    });

    // Graphique des erreurs
    const errorsCtx = document.getElementById('errorsChart').getContext('2d');
    errorsChart = new Chart(errorsCtx, {
        type: 'doughnut',
        data: {
            labels: ['404', '500', 'Timeout', 'Auth'],
            datasets: [{
                data: [12, 3, 1, 2],
                backgroundColor: [
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(168, 85, 247, 0.8)'
                ],
                borderColor: [
                    'rgba(245, 158, 11, 1)',
                    'rgba(239, 68, 68, 1)',
                    'rgba(59, 130, 246, 1)',
                    'rgba(168, 85, 247, 1)'
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
}

function startMonitoring() {
    if (!autoRefresh) return;
    
    // Simuler des données en temps réel
    updateMetrics();
    updateCharts();
    
    setTimeout(startMonitoring, 2000); // Mise à jour toutes les 2 secondes
}

function updateMetrics() {
    // Simuler des valeurs aléatoires
    document.getElementById('requests-per-second').textContent = Math.floor(Math.random() * 100) + 50;
    document.getElementById('active-users').textContent = Math.floor(Math.random() * 500) + 200;
    document.getElementById('average-latency').textContent = Math.floor(Math.random() * 50) + 10 + 'ms';
    document.getElementById('error-rate').textContent = (Math.random() * 2).toFixed(2) + '%';
}

function updateCharts() {
    const now = new Date();
    const timeLabel = now.toLocaleTimeString();
    
    // Ajouter de nouvelles données
    performanceChart.data.labels.push(timeLabel);
    performanceChart.data.datasets[0].data.push(Math.floor(Math.random() * 100) + 50);
    performanceChart.data.datasets[1].data.push(Math.floor(Math.random() * 50) + 10);
    
    // Garder seulement les 20 dernières valeurs
    if (performanceChart.data.labels.length > 20) {
        performanceChart.data.labels.shift();
        performanceChart.data.datasets[0].data.shift();
        performanceChart.data.datasets[1].data.shift();
    }
    
    performanceChart.update('none');
}

function simulateLogs() {
    const logTypes = ['INFO', 'WARN', 'ERROR'];
    const logMessages = [
        'Nouvelle commande reçue',
        'Utilisateur connecté',
        'Erreur de base de données',
        'Sauvegarde terminée',
        'Cache mis à jour',
        'Email envoyé',
        'Paiement traité',
        'Erreur de validation'
    ];
    
    setInterval(() => {
        if (Math.random() < 0.3) { // 30% de chance d'ajouter un log
            addLog(
                logTypes[Math.floor(Math.random() * logTypes.length)],
                logMessages[Math.floor(Math.random() * logMessages.length)]
            );
        }
    }, 1000);
}

function addLog(type, message) {
    const logsContainer = document.getElementById('logs-list');
    const logElement = document.createElement('div');
    
    const typeColor = {
        'INFO': 'text-blue-400',
        'WARN': 'text-yellow-400',
        'ERROR': 'text-red-400'
    };
    
    logElement.innerHTML = `
        <div class="flex items-center space-x-3 text-sm">
            <span class="text-gray-400">${new Date().toLocaleTimeString()}</span>
            <span class="${typeColor[type]} font-medium">[${type}]</span>
            <span class="text-white">${message}</span>
        </div>
    `;
    
    logsContainer.appendChild(logElement);
    
    // Garder seulement les 50 derniers logs
    while (logsContainer.children.length > 50) {
        logsContainer.removeChild(logsContainer.firstChild);
    }
    
    // Scroll vers le bas
    logsContainer.parentElement.scrollTop = logsContainer.parentElement.scrollHeight;
}

function toggleAutoRefresh() {
    autoRefresh = !autoRefresh;
    if (autoRefresh) {
        startMonitoring();
    }
}

function clearLogs() {
    document.getElementById('logs-list').innerHTML = '';
}
</script>
@endsection
