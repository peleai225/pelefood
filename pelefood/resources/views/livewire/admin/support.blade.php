<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Support Client</h1>
            <p class="text-gray-600 mt-2">Gérez les demandes de support</p>
        </div>
    </div>

    <!-- Statistiques du support -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tickets Ouverts</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['open_tickets'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tickets Résolus</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['resolved_tickets'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Temps de Réponse</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['avg_response_time'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Satisfaction</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['satisfaction_rate'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions Rapides</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <button class="flex items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors">
                <div class="text-center">
                    <i class="fas fa-plus-circle text-3xl text-gray-400 mb-2"></i>
                    <p class="text-sm font-medium text-gray-600">Nouveau Ticket</p>
                </div>
            </button>
            <button class="flex items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500 hover:bg-green-50 transition-colors">
                <div class="text-center">
                    <i class="fas fa-file-export text-3xl text-gray-400 mb-2"></i>
                    <p class="text-sm font-medium text-gray-600">Exporter Données</p>
                </div>
            </button>
            <button class="flex items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-colors">
                <div class="text-center">
                    <i class="fas fa-chart-bar text-3xl text-gray-400 mb-2"></i>
                    <p class="text-sm font-medium text-gray-600">Rapports</p>
                </div>
            </button>
        </div>
    </div>

    <!-- Tickets récents -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Tickets Récents</h3>
            <button class="text-blue-600 text-sm font-medium hover:text-blue-700">
                Voir tout
            </button>
        </div>
        
        @if($stats['recent_tickets']->count() > 0)
            <div class="space-y-4">
                @foreach($stats['recent_tickets'] as $ticket)
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-ticket-alt text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-900 font-medium">{{ $ticket->subject ?? 'Sujet du ticket' }}</p>
                            <p class="text-gray-600 text-sm">{{ $ticket->user->name ?? 'Client' }} • {{ $ticket->created_at->diffForHumans() ?? 'Il y a 2h' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($ticket->status === 'open') bg-yellow-100 text-yellow-800
                            @elseif($ticket->status === 'resolved') bg-green-100 text-green-800
                            @elseif($ticket->status === 'closed') bg-gray-100 text-gray-800
                            @else bg-blue-100 text-blue-800
                            @endif">
                            {{ ucfirst($ticket->status ?? 'Ouvert') }}
                        </span>
                        <button class="text-blue-600 hover:text-blue-700">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-ticket-alt text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun ticket récent</h3>
                <p class="text-gray-500 mb-6">Les tickets de support apparaîtront ici</p>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Créer un ticket
                </button>
            </div>
        @endif
    </div>

    <!-- Base de connaissances -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Base de Connaissances</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow cursor-pointer">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-question-circle text-blue-600"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">FAQ Général</h4>
                        <p class="text-sm text-gray-600">Questions fréquentes</p>
                    </div>
                </div>
            </div>
            
            <div class="p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow cursor-pointer">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Commandes</h4>
                        <p class="text-sm text-gray-600">Gestion des commandes</p>
                    </div>
                </div>
            </div>
            
            <div class="p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow cursor-pointer">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-credit-card text-purple-600"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Paiements</h4>
                        <p class="text-sm text-gray-600">Problèmes de paiement</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>