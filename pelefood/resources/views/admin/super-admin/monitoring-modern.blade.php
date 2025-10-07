@extends('layouts.super-admin-modern')

@section('title', 'Monitoring Temps Réel - PeleFood')
@section('page-title', 'Monitoring Temps Réel')
@section('page-description', 'Surveillance en direct et analytics de performance')

@section('content')
<div class="space-y-8">
    <!-- Header avec statut temps réel -->
    <div class="bg-gradient-to-r from-white via-slate-50 to-white rounded-3xl shadow-2xl border border-slate-200/50 p-8 card-hover">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-6 lg:space-y-0">
            <div class="flex items-center space-x-6">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-3xl flex items-center justify-center shadow-2xl pulse-ring floating-card">
                    <i class="fas fa-chart-line text-white text-2xl animate-bounce-in"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 text-gradient">Monitoring Temps Réel</h1>
                    <p class="text-slate-600 text-lg font-medium">Surveillance en direct de la plateforme</p>
                    <div class="flex items-center space-x-4 mt-2">
                        <div class="flex items-center space-x-2 bg-green-50 border border-green-200 rounded-xl px-4 py-2">
                            <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-green-800 text-sm font-bold">En Direct</span>
                        </div>
                        <div class="text-slate-500 text-sm">
                            Dernière mise à jour: <span class="font-semibold" id="last-update">{{ now()->format('H:i:s') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                <button onclick="toggleAutoRefresh()" class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-2xl px-6 py-3 text-sm font-bold hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 hover:scale-105 shadow-lg">
                    <i class="fas fa-sync-alt mr-2" id="refresh-icon"></i>
                    <span id="refresh-text">Auto-refresh</span>
                </button>
                <button class="bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-2xl px-6 py-3 text-sm font-bold hover:from-orange-600 hover:to-red-600 transition-all duration-300 hover:scale-105 shadow-lg">
                    <i class="fas fa-download mr-2"></i>
                    Exporter
                </button>
            </div>
        </div>
    </div>

    <!-- Métriques en temps réel avec animations -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Requêtes par seconde -->
        <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-2xl border border-slate-200/50 p-8 card-hover animate-scale-in" style="animation-delay: 0.1s;">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-slate-600 text-sm font-bold mb-2 uppercase tracking-wide">Requêtes/sec</p>
                    <p class="text-4xl font-bold text-slate-900 mb-3" id="requests-per-second">0</p>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center bg-green-50 border border-green-200 rounded-xl px-3 py-1">
                            <i class="fas fa-arrow-up text-green-600 mr-1"></i>
                            <span class="text-green-600 text-sm font-bold">+15%</span>
                        </div>
                        <span class="text-slate-500 text-sm">vs 1h</span>
                    </div>
                </div>
                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-500 rounded-3xl flex items-center justify-center shadow-2xl floating-card">
                    <i class="fas fa-bolt text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Utilisateurs connectés -->
        <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-2xl border border-slate-200/50 p-8 card-hover animate-scale-in" style="animation-delay: 0.2s;">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-slate-600 text-sm font-bold mb-2 uppercase tracking-wide">Utilisateurs Actifs</p>
                    <p class="text-4xl font-bold text-slate-900 mb-3" id="active-users">0</p>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center bg-blue-50 border border-blue-200 rounded-xl px-3 py-1">
                            <i class="fas fa-users text-blue-600 mr-1"></i>
                            <span class="text-blue-600 text-sm font-bold">En ligne</span>
                        </div>
                        <span class="text-slate-500 text-sm">Live</span>
                    </div>
                </div>
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-3xl flex items-center justify-center shadow-2xl floating-card">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Latence moyenne -->
        <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-2xl border border-slate-200/50 p-8 card-hover animate-scale-in" style="animation-delay: 0.3s;">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-slate-600 text-sm font-bold mb-2 uppercase tracking-wide">Latence Moyenne</p>
                    <p class="text-4xl font-bold text-slate-900 mb-3" id="average-latency">0ms</p>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center bg-green-50 border border-green-200 rounded-xl px-3 py-1">
                            <i class="fas fa-check text-green-600 mr-1"></i>
                            <span class="text-green-600 text-sm font-bold">Excellent</span>
                        </div>
                        <span class="text-slate-500 text-sm">Optimal</span>
                    </div>
                </div>
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-3xl flex items-center justify-center shadow-2xl floating-card">
                    <i class="fas fa-tachometer-alt text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Erreurs -->
        <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-2xl border border-slate-200/50 p-8 card-hover animate-scale-in" style="animation-delay: 0.4s;">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-slate-600 text-sm font-bold mb-2 uppercase tracking-wide">Taux d'Erreur</p>
                    <p class="text-4xl font-bold text-slate-900 mb-3" id="error-rate">0%</p>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center bg-green-50 border border-green-200 rounded-xl px-3 py-1">
                            <i class="fas fa-shield-alt text-green-600 mr-1"></i>
                            <span class="text-green-600 text-sm font-bold">Stable</span>
                        </div>
                        <span class="text-slate-500 text-sm">Normal</span>
                    </div>
                </div>
                <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-red-500 rounded-3xl flex items-center justify-center shadow-2xl floating-card">
                    <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques de monitoring -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Graphique des performances -->
        <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-2xl border border-slate-200/50 p-8 card-hover">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 text-gradient">Performances en Temps Réel</h3>
                    <p class="text-slate-600 text-sm">Surveillance continue des métriques</p>
                </div>
                <div class="flex space-x-2">
                    <button class="px-4 py-2 bg-blue-500 text-white rounded-xl text-sm font-bold hover:bg-blue-600 transition-colors">1h</button>
                    <button class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors">6h</button>
                    <button class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors">24h</button>
                </div>
            </div>
            <div class="h-80">
                <canvas id="performanceChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Graphique des erreurs -->
        <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-2xl border border-slate-200/50 p-8 card-hover">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 text-gradient">Erreurs par Type</h3>
                    <p class="text-slate-600 text-sm">Distribution des erreurs système</p>
                </div>
                <button class="px-4 py-2 bg-orange-500 text-white rounded-xl text-sm font-bold hover:bg-orange-600 transition-colors">
                    <i class="fas fa-eye mr-2"></i>
                    Détails
                </button>
            </div>
            <div class="h-80">
                <canvas id="errorsChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Logs en temps réel -->
    <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-2xl border border-slate-200/50 p-8 card-hover">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="text-2xl font-bold text-slate-900 text-gradient">Logs en Temps Réel</h3>
                <p class="text-slate-600 text-sm">Surveillance des événements système</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex space-x-2">
                    <button class="px-4 py-2 bg-green-500 text-white rounded-xl text-sm font-bold hover:bg-green-600 transition-colors">INFO</button>
                    <button class="px-4 py-2 bg-yellow-500 text-white rounded-xl text-sm font-bold hover:bg-yellow-600 transition-colors">WARN</button>
                    <button class="px-4 py-2 bg-red-500 text-white rounded-xl text-sm font-bold hover:bg-red-600 transition-colors">ERROR</button>
                </div>
                <button onclick="clearLogs()" class="px-4 py-2 bg-slate-500 text-white rounded-xl text-sm font-bold hover:bg-slate-600 transition-colors">
                    <i class="fas fa-trash mr-2"></i>
                    Effacer
                </button>
            </div>
        </div>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-6 h-80 overflow-y-auto shadow-inner">
            <div class="space-y-3" id="logs-list">
                <!-- Les logs seront ajoutés dynamiquement -->
            </div>
        </div>
    </div>

    <!-- Alertes système -->
    <div class="bg-gradient-to-br from-white to-slate-50 rounded-3xl shadow-2xl border border-slate-200/50 p-8 card-hover">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="text-2xl font-bold text-slate-900 text-gradient">Alertes Système</h3>
                <p class="text-slate-600 text-sm">Surveillance proactive des anomalies</p>
            </div>
            <button class="px-4 py-2 bg-blue-500 text-white rounded-xl text-sm font-bold hover:bg-blue-600 transition-colors">
                <i class="fas fa-cog mr-2"></i>
                Configurer
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="p-6 bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-2xl animate-fade-in">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-green-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-check text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-green-800 font-bold text-sm">Système Stable</p>
                        <p class="text-green-600 text-xs">Tous les services fonctionnent normalement</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6 bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-200 rounded-2xl animate-fade-in" style="animation-delay: 0.1s;">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-yellow-500 rounded-2xl flex items-center justify-center shadow-lg pulse-ring">
                        <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-yellow-800 font-bold text-sm">Charge Élevée</p>
                        <p class="text-yellow-600 text-xs">CPU à 85% - Surveillance active</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-2xl animate-fade-in" style="animation-delay: 0.2s;">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-download text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-blue-800 font-bold text-sm">Mise à Jour</p>
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
let logCounter = 0;

document.addEventListener('DOMContentLoaded', function() {
    // Initialiser les graphiques
    initCharts();
    
    // Démarrer le monitoring
    startMonitoring();
    
    // Simuler des logs en temps réel
    simulateLogs();
    
    // Mettre à jour le timestamp
    updateTimestamp();
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
                fill: true,
                borderWidth: 3,
                pointRadius: 4,
                pointHoverRadius: 6
            }, {
                label: 'Latence (ms)',
                data: [],
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 3,
                pointRadius: 4,
                pointHoverRadius: 6
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
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(168, 85, 247, 1)',
                    borderWidth: 1,
                    cornerRadius: 12
                }
            },
            scales: {
                x: {
                    grid: {
                        color: 'rgba(100, 116, 139, 0.1)',
                        drawBorder: false
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
                        }
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
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
                    borderColor: 'rgba(245, 158, 11, 1)',
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
}

function startMonitoring() {
    if (!autoRefresh) return;
    
    // Simuler des données en temps réel
    updateMetrics();
    updateCharts();
    
    setTimeout(startMonitoring, 2000); // Mise à jour toutes les 2 secondes
}

function updateMetrics() {
    // Simuler des valeurs aléatoires réalistes
    document.getElementById('requests-per-second').textContent = Math.floor(Math.random() * 50) + 75;
    document.getElementById('active-users').textContent = Math.floor(Math.random() * 200) + 150;
    document.getElementById('average-latency').textContent = Math.floor(Math.random() * 30) + 15 + 'ms';
    document.getElementById('error-rate').textContent = (Math.random() * 1.5).toFixed(2) + '%';
    
    // Mettre à jour le timestamp
    updateTimestamp();
}

function updateCharts() {
    const now = new Date();
    const timeLabel = now.toLocaleTimeString();
    
    // Ajouter de nouvelles données
    performanceChart.data.labels.push(timeLabel);
    performanceChart.data.datasets[0].data.push(Math.floor(Math.random() * 50) + 75);
    performanceChart.data.datasets[1].data.push(Math.floor(Math.random() * 30) + 15);
    
    // Garder seulement les 20 dernières valeurs
    if (performanceChart.data.labels.length > 20) {
        performanceChart.data.labels.shift();
        performanceChart.data.datasets[0].data.shift();
        performanceChart.data.datasets[1].data.shift();
    }
    
    performanceChart.update('none');
}

function updateTimestamp() {
    document.getElementById('last-update').textContent = new Date().toLocaleTimeString();
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
        'Erreur de validation',
        'Session expirée',
        'Fichier uploadé',
        'Notification envoyée',
        'Erreur de connexion'
    ];
    
    setInterval(() => {
        if (Math.random() < 0.4) { // 40% de chance d'ajouter un log
            addLog(
                logTypes[Math.floor(Math.random() * logTypes.length)],
                logMessages[Math.floor(Math.random() * logMessages.length)]
            );
        }
    }, 1500);
}

function addLog(type, message) {
    const logsContainer = document.getElementById('logs-list');
    const logElement = document.createElement('div');
    
    const typeColor = {
        'INFO': 'text-blue-400',
        'WARN': 'text-yellow-400',
        'ERROR': 'text-red-400'
    };
    
    const typeBg = {
        'INFO': 'bg-blue-500/10',
        'WARN': 'bg-yellow-500/10',
        'ERROR': 'bg-red-500/10'
    };
    
    logCounter++;
    
    logElement.innerHTML = `
        <div class="flex items-center space-x-4 p-3 rounded-xl ${typeBg[type]} border border-slate-700/50 animate-fade-in">
            <span class="text-slate-400 text-xs font-mono w-20">${new Date().toLocaleTimeString()}</span>
            <span class="${typeColor[type]} font-bold text-sm px-2 py-1 rounded-lg bg-slate-800/50">[${type}]</span>
            <span class="text-slate-200 text-sm flex-1">${message}</span>
            <span class="text-slate-500 text-xs">#${logCounter.toString().padStart(4, '0')}</span>
        </div>
    `;
    
    logsContainer.appendChild(logElement);
    
    // Garder seulement les 30 derniers logs
    while (logsContainer.children.length > 30) {
        logsContainer.removeChild(logsContainer.firstChild);
    }
    
    // Scroll vers le bas
    logsContainer.parentElement.scrollTop = logsContainer.parentElement.scrollHeight;
}

function toggleAutoRefresh() {
    autoRefresh = !autoRefresh;
    const icon = document.getElementById('refresh-icon');
    const text = document.getElementById('refresh-text');
    
    if (autoRefresh) {
        icon.classList.remove('fa-pause');
        icon.classList.add('fa-sync-alt');
        text.textContent = 'Auto-refresh';
        startMonitoring();
    } else {
        icon.classList.remove('fa-sync-alt');
        icon.classList.add('fa-pause');
        text.textContent = 'Pause';
    }
}

function clearLogs() {
    document.getElementById('logs-list').innerHTML = '';
    logCounter = 0;
}

// Animation d'entrée des cartes
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.animate-scale-in');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});
</script>
@endsection
