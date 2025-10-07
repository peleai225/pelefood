<div class="space-y-6">
    <!-- Header avec statistiques -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>
            <p class="text-gray-600 mt-2">Gérez et suivez toutes les notifications du système</p>
        </div>
        
        <!-- Statistiques -->
        <div class="flex flex-wrap gap-4">
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-bell text-blue-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Total</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-2 bg-red-100 rounded-lg">
                        <i class="fas fa-exclamation-circle text-red-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Non lues</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['unread'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500">Lues</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['read'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barre de recherche et filtres -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col lg:flex-row gap-4">
            <!-- Recherche -->
            <div class="flex-1">
                <div class="relative">
                    <input type="text" 
                           wire:model="search" 
                           placeholder="Rechercher par titre, message ou utilisateur..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            
            <!-- Filtres -->
            <div class="flex gap-2">
                <select wire:model="filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <option value="all">Toutes</option>
                    <option value="unread">Non lues</option>
                    <option value="read">Lues</option>
                </select>
                
                @if($stats['unread'] > 0)
                    <button wire:click="markAllAsRead" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-check-double mr-2"></i>
                        Marquer tout comme lu
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Messages flash -->
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Liste des notifications -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        @if($notifications->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($notifications as $notification)
                    <div class="p-6 hover:bg-gray-50 transition-colors {{ is_null($notification->read_at) ? 'bg-red-50 border-l-4 border-red-500' : '' }}">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="p-2 {{ !is_null($notification->read_at) ? 'bg-gray-100' : 'bg-red-100' }} rounded-lg">
                                        <i class="fas fa-bell {{ !is_null($notification->read_at) ? 'text-gray-600' : 'text-red-600' }}"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 {{ is_null($notification->read_at) ? 'font-bold' : '' }}">
                                            {{ $notification->data['title'] ?? 'Notification' }}
                                        </h3>
                                        <p class="text-gray-600 mt-1">{{ $notification->data['message'] ?? $notification->data['body'] ?? 'Aucun message' }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-4 text-sm text-gray-500 mt-3">
                                    <span class="flex items-center">
                                        <i class="fas fa-user mr-1"></i>
                                        {{ $notification->notifiable->name ?? 'Système' }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                    @if($notification->type)
                                        <span class="flex items-center">
                                            <i class="fas fa-tag mr-1"></i>
                                            {{ $notification->type }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center gap-2 ml-4">
                                @if(is_null($notification->read_at))
                                    <button wire:click="markAsRead('{{ $notification->id }}')" 
                                            class="p-2 text-green-600 hover:bg-green-100 rounded-lg transition-colors"
                                            title="Marquer comme lu">
                                        <i class="fas fa-check"></i>
                                    </button>
                                @else
                                    <button wire:click="markAsUnread('{{ $notification->id }}')" 
                                            class="p-2 text-yellow-600 hover:bg-yellow-100 rounded-lg transition-colors"
                                            title="Marquer comme non lu">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                @endif
                                
                                <button wire:click="deleteNotification('{{ $notification->id }}')" 
                                        class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-colors"
                                        title="Supprimer"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette notification ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $notifications->links() }}
            </div>
        @else
            <!-- État vide -->
            <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-bell text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune notification</h3>
                <p class="text-gray-500">
                    @if($search || $filter !== 'all')
                        Aucune notification ne correspond à vos critères de recherche.
                    @else
                        Vous n'avez pas encore de notifications dans le système.
                    @endif
                </p>
                @if($search || $filter !== 'all')
                    <button wire:click="resetFilters" 
                            class="mt-4 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Réinitialiser les filtres
                    </button>
                @endif
            </div>
        @endif
    </div>
</div>