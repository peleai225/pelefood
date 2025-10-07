<div class="max-w-7xl mx-auto space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Support Client</h1>
            <p class="text-gray-600 mt-2">Gérez tous les tickets de support de la plateforme</p>
        </div>
        <button wire:click="createTicket" 
                class="btn-modern px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
            <i class="fas fa-plus"></i>
            <span>Nouveau ticket</span>
        </button>
    </div>

    <!-- Messages -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-ticket-alt text-blue-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Tickets</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_tickets'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-yellow-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Tickets Ouverts</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['open_tickets'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Résolus</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['resolved_tickets'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-clock text-orange-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Temps Réponse</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['avg_response_time'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-star text-yellow-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Satisfaction</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['satisfaction_rate'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <!-- Barre de recherche -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text" 
                           wire:model.debounce.300ms="search"
                           placeholder="Rechercher un ticket..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <!-- Filtres -->
            <div class="flex items-center space-x-4">
                <select wire:model="filter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="all">Tous les statuts</option>
                    <option value="open">Ouverts</option>
                    <option value="in_progress">En cours</option>
                    <option value="resolved">Résolus</option>
                    <option value="closed">Fermés</option>
                </select>
                
                <select wire:model="perPage" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="12">12 par page</option>
                    <option value="24">24 par page</option>
                    <option value="48">48 par page</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Liste des tickets -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ticket
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Client
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Priorité
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tickets as $ticket)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">#{{ $ticket['id'] }}</div>
                            <div class="text-sm text-gray-500">{{ $ticket['subject'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $ticket['user']->name ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-500">{{ $ticket['user']->email ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getPriorityBadgeClass($ticket['priority']) }}">
                                {{ $this->getPriorityLabel($ticket['priority']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusBadgeClass($ticket['status']) }}">
                                {{ $this->getStatusLabel($ticket['status']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $ticket['created_at']->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <button wire:click="viewTicket({{ $ticket['id'] }})" 
                                        class="text-blue-600 hover:text-blue-700"
                                        title="Voir les détails">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if($ticket['status'] !== 'closed')
                                <button wire:click="updateTicketStatus({{ $ticket['id'] }}, 'resolved')" 
                                        class="text-green-600 hover:text-green-700"
                                        title="Marquer comme résolu">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button wire:click="closeTicket({{ $ticket['id'] }})" 
                                        wire:confirm="Êtes-vous sûr de vouloir fermer ce ticket ?"
                                        class="text-gray-600 hover:text-gray-700"
                                        title="Fermer">
                                    <i class="fas fa-times"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <i class="fas fa-ticket-alt text-gray-400 text-4xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun ticket trouvé</h3>
                            <p class="text-gray-600 mb-4">Commencez par créer votre premier ticket de support.</p>
                            <button wire:click="createTicket" 
                                    class="btn-modern px-4 py-2 rounded-lg">
                                <i class="fas fa-plus mr-2"></i>
                                Créer un ticket
                            </button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $tickets->links() }}
    </div>

    <!-- Modal pour créer un ticket -->
    @if($showModal && !$selectedTicket)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeModal">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white" wire:click.stop>
            <!-- En-tête du modal -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">{{ $modalTitle }}</h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Formulaire -->
            <form wire:submit.prevent="saveTicket">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Sujet -->
                    <div class="md:col-span-2">
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Sujet *</label>
                        <input type="text" 
                               id="subject"
                               wire:model="subject"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Client -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Client *</label>
                        <select id="user_id"
                                wire:model="user_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Sélectionner un client</option>
                            @foreach($this->users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        @error('user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Priorité -->
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Priorité *</label>
                        <select id="priority"
                                wire:model="priority"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="low">Faible</option>
                            <option value="medium">Moyenne</option>
                            <option value="high">Élevée</option>
                            <option value="urgent">Urgente</option>
                        </select>
                        @error('priority') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Statut -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut *</label>
                        <select id="status"
                                wire:model="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="open">Ouvert</option>
                            <option value="in_progress">En cours</option>
                            <option value="resolved">Résolu</option>
                            <option value="closed">Fermé</option>
                        </select>
                        @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                        <textarea id="description"
                                  wire:model="description"
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            wire:click="closeModal"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="btn-modern font-bold py-2 px-4 rounded">
                        Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Modal pour voir les détails d'un ticket -->
    @if($showModal && $selectedTicket)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeModal">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white" wire:click.stop>
            <!-- En-tête du modal -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">{{ $modalTitle }}</h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Détails du ticket -->
            <div class="space-y-6">
                <!-- Informations du ticket -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-gray-50 rounded-lg">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Priorité</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getPriorityBadgeClass($selectedTicket['priority']) }}">
                            {{ $this->getPriorityLabel($selectedTicket['priority']) }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Statut</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusBadgeClass($selectedTicket['status']) }}">
                            {{ $this->getStatusLabel($selectedTicket['status']) }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date de création</label>
                        <p class="text-gray-900">{{ $selectedTicket['created_at']->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-900">{{ $selectedTicket['description'] }}</p>
                    </div>
                </div>

                <!-- Réponses existantes -->
                @if(isset($selectedTicket['responses']) && count($selectedTicket['responses']) > 0)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Réponses</label>
                    <div class="space-y-4">
                        @foreach($selectedTicket['responses'] as $response)
                        <div class="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-400">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-sm font-medium text-blue-900">{{ $response['author'] }}</span>
                                <span class="text-xs text-blue-600">{{ $response['created_at']->format('d/m/Y H:i') }}</span>
                            </div>
                            <p class="text-blue-800">{{ $response['message'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Ajouter une réponse -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ajouter une réponse</label>
                    <form wire:submit.prevent="addResponse">
                        <textarea wire:model="response"
                                  rows="3"
                                  placeholder="Tapez votre réponse ici..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        <div class="mt-2 flex justify-end">
                            <button type="submit" 
                                    class="btn-modern px-4 py-2 rounded-lg">
                                Ajouter la réponse
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex justify-end space-x-3 mt-6">
                <button wire:click="closeModal"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Fermer
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
