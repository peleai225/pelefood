@extends('layouts.super-admin-new-design')

@section('title', 'Centre de Support - PeleFood')
@section('description', 'Gestion du support client et des tickets')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Centre de Support</h1>
            <p class="mt-2 text-lg text-gray-600">Gérez le support client et les tickets d'assistance</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="exportSupportData()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-download mr-2"></i> Exporter
            </button>
            <button onclick="refreshSupportData()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-sync mr-2"></i> Actualiser
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-600 mr-3"></i>
            <p class="text-green-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Statistiques du support -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-ticket-alt text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Tickets</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_tickets'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tickets Ouverts</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['open_tickets'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tickets Résolus</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['resolved_tickets'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Temps de Réponse Moyen</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['avg_response_time'], 1) }}h</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions Rapides</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <button onclick="createNewTicket()" class="flex items-center justify-center p-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Nouveau Ticket
            </button>
            <button onclick="openKnowledgeBase()" class="flex items-center justify-center p-4 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-book mr-2"></i>
                Base de Connaissances
            </button>
            <button onclick="scheduleTraining()" class="flex items-center justify-center p-4 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-calendar mr-2"></i>
                Planifier Formation
            </button>
        </div>
    </div>

    <!-- Tickets récents -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Tickets Récents</h3>
            <a href="{{ route('admin.support.tickets') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                Voir tous →
            </a>
        </div>
        
        <div class="space-y-4">
            @forelse($recentTickets as $ticket)
            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-gray-300 transition-colors">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-semibold
                        @if($ticket->priority === 'urgent') bg-red-500
                        @elseif($ticket->priority === 'high') bg-orange-500
                        @elseif($ticket->priority === 'medium') bg-yellow-500
                        @else bg-green-500
                        @endif">
                        #{{ $ticket->id }}
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">{{ $ticket->subject }}</div>
                        <div class="text-sm text-gray-500">
                            {{ $ticket->user->name ?? 'Utilisateur anonyme' }}
                            @if($ticket->restaurant)
                                - {{ $ticket->restaurant->name }}
                            @endif
                            - {{ $ticket->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($ticket->status === 'open') bg-red-100 text-red-800
                        @elseif($ticket->status === 'in_progress') bg-yellow-100 text-yellow-800
                        @elseif($ticket->status === 'resolved') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($ticket->status) }}
                    </span>
                    <a href="{{ route('admin.support.tickets.show', $ticket) }}" class="text-blue-600 hover:text-blue-700">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <i class="fas fa-ticket-alt text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500">Aucun ticket récent</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Répartition par priorité -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Répartition par Priorité</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-600">Urgent</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $ticketsByPriority['urgent'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-orange-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-600">Élevée</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $ticketsByPriority['high'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-600">Moyenne</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $ticketsByPriority['medium'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-600">Faible</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $ticketsByPriority['low'] }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Répartition par Catégorie</h3>
            <div class="space-y-3">
                @forelse($ticketsByCategory as $category => $count)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">{{ ucfirst($category) }}</span>
                    <span class="font-semibold text-gray-900">{{ $count }}</span>
                </div>
                @empty
                <p class="text-gray-500 text-sm">Aucune donnée disponible</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Métriques de satisfaction -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Métriques de Satisfaction</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600 mb-2">{{ number_format($stats['satisfaction_rate'], 1) }}/5</div>
                <div class="text-sm text-gray-600">Note moyenne</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2">{{ number_format($stats['avg_response_time'], 1) }}h</div>
                <div class="text-sm text-gray-600">Temps de réponse moyen</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-600 mb-2">
                    {{ $stats['total_tickets'] > 0 ? number_format(($stats['resolved_tickets'] / $stats['total_tickets']) * 100, 1) : 0 }}%
                </div>
                <div class="text-sm text-gray-600">Taux de résolution</div>
            </div>
        </div>
    </div>
</div>

<script>
function createNewTicket() {
    // Logique pour créer un nouveau ticket
    window.location.href = "{{ route('admin.support.tickets.create') }}";
}

function openKnowledgeBase() {
    // Logique pour ouvrir la base de connaissances
    window.open("{{ route('admin.support.knowledge-base') }}", '_blank');
}

function scheduleTraining() {
    // Logique pour planifier une formation
    alert('Fonctionnalité de planification de formation à implémenter');
}

function exportSupportData() {
    // Logique pour exporter les données de support
    window.location.href = "{{ route('admin.support.export') }}";
}

function refreshSupportData() {
    // Actualiser la page
    location.reload();
}
</script>
@endsection
