<div class="relative dropdown-fix" x-data="{ open: false }">
    <button @click="open = !open" class="header-button relative text-gray-600 hover:text-gray-900">
        <i class="fas fa-bell text-xl"></i>
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center animate-pulse">
                {{ $unreadCount }}
            </span>
        @endif
    </button>
    
    <div x-show="open" 
         @click.away="open = false" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="notification-dropdown mt-2 w-80">
        
        <!-- En-tête -->
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead" 
                        class="text-sm text-red-600 hover:text-red-700 font-medium">
                    Tout marquer comme lu
                </button>
            @endif
        </div>
        
        <!-- Liste des notifications -->
        <div class="max-h-64 overflow-y-auto">
            @forelse($notifications as $notification)
                <div class="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors cursor-pointer"
                     wire:click="markAsRead('{{ $notification['id'] }}')">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $notification['color'] }} bg-gray-100">
                            <i class="{{ $notification['icon'] }} text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">{{ $notification['title'] }}</p>
                            <p class="text-xs text-gray-600 mt-1 line-clamp-2">{{ $notification['message'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $notification['time'] }}</p>
                        </div>
                        <div class="w-2 h-2 bg-red-500 rounded-full flex-shrink-0"></div>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-gray-500">
                    <i class="fas fa-bell-slash text-2xl mb-2"></i>
                    <p class="text-sm">Aucune notification</p>
                </div>
            @endforelse
        </div>
        
        <!-- Pied de page -->
        <div class="p-4 border-t border-gray-200">
            <a href="{{ route('admin.notifications.index') }}" 
               class="text-red-600 hover:text-red-700 text-sm font-medium flex items-center justify-center">
                <i class="fas fa-eye mr-2"></i>
                Voir toutes les notifications
            </a>
        </div>
    </div>
</div>
