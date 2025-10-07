@extends('layouts.super-admin-new-design')

@section('title', 'Test Backoffice Moderne')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
    <!-- Header avec animations -->
    <div class="bg-white shadow-lg border-b border-slate-200 mb-8">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-rocket text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">Backoffice Moderne</h1>
                        <p class="text-slate-600">Interface dynamique et interactive</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="showNotification('Test', 'Notification de test', 'success')" class="bg-green-600 text-white rounded-lg px-4 py-2 text-sm font-medium hover:shadow-lg transition-all duration-200">
                        <i class="fas fa-bell mr-2"></i>
                        Test Notification
                    </button>
                    <button onclick="showNotification('Erreur', 'Test d\'erreur', 'error')" class="bg-red-600 text-white rounded-lg px-4 py-2 text-sm font-medium hover:shadow-lg transition-all duration-200">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Test Erreur
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="px-6 space-y-8">
        <!-- Cartes de statistiques animées -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Revenus</p>
                        <p class="text-3xl font-bold text-slate-900 group-hover:text-blue-600 transition-colors duration-300">2,500,000 FCFA</p>
                        <div class="flex items-center mt-2">
                            <span class="text-green-600 text-sm font-medium flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +12.5%
                            </span>
                        </div>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-money-bill-wave text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Commandes</p>
                        <p class="text-3xl font-bold text-slate-900 group-hover:text-blue-600 transition-colors duration-300">1,234</p>
                        <div class="flex items-center mt-2">
                            <span class="text-blue-600 text-sm font-medium flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +8.2%
                            </span>
                        </div>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-shopping-cart text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Restaurants</p>
                        <p class="text-3xl font-bold text-slate-900 group-hover:text-blue-600 transition-colors duration-300">45</p>
                        <div class="flex items-center mt-2">
                            <span class="text-purple-600 text-sm font-medium flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +5.1%
                            </span>
                        </div>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-store text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Utilisateurs</p>
                        <p class="text-3xl font-bold text-slate-900 group-hover:text-blue-600 transition-colors duration-300">892</p>
                        <div class="flex items-center mt-2">
                            <span class="text-orange-600 text-sm font-medium flex items-center">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +15.3%
                            </span>
                        </div>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau moderne de test -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">Tableau Moderne</h3>
                        <p class="text-sm text-slate-600">Exemple de tableau interactif</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <input type="text" placeholder="Rechercher..." class="pl-10 pr-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                        </div>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter
                        </button>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @for($i = 1; $i <= 5; $i++)
                        <tr class="hover:bg-slate-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-semibold">{{ $i }}</span>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-slate-900">Utilisateur {{ $i }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-900">user{{ $i }}@example.com</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $i % 2 == 0 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $i % 2 == 0 ? 'Actif' : 'En attente' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-900">{{ now()->subDays($i)->format('d/m/Y') }}</div>
                                <div class="text-xs text-slate-500">{{ now()->subDays($i)->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button class="text-blue-600 hover:text-blue-900 transition-colors duration-200" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-green-600 hover:text-green-900 transition-colors duration-200" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-900 transition-colors duration-200" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Graphique interactif -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-slate-800">Graphique Interactif</h3>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-full">7j</button>
                    <button class="px-3 py-1 text-xs font-medium text-slate-600 bg-slate-100 rounded-full">30j</button>
                    <button class="px-3 py-1 text-xs font-medium text-slate-600 bg-slate-100 rounded-full">90j</button>
                </div>
            </div>
            <div class="h-64 flex items-center justify-center">
                <canvas id="testChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique de test
    const ctx = document.getElementById('testChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
            datasets: [{
                label: 'Revenus (FCFA)',
                data: [120000, 190000, 300000, 500000, 200000, 300000],
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
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + ' FCFA';
                        }
                    }
                }
            }
        }
    });

    // Animations d'entrée
    const cards = document.querySelectorAll('.bg-white');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endsection
