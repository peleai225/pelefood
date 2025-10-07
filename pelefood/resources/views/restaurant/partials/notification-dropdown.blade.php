<!-- Dropdown des notifications -->
<div x-data="{ 
    notifications: [],
    unreadCount: 0,
    isOpen: false,
    loading: false,
    
    async loadNotifications() {
        this.loading = true;
        try {
            const response = await fetch('/restaurant/notifications/unread');
            const data = await response.json();
            this.notifications = data.notifications;
            this.unreadCount = data.unread_count;
        } catch (error) {
            console.error('Erreur lors du chargement des notifications:', error);
        } finally {
            this.loading = false;
        }
    },
    
    async markAsRead(notificationId) {
        try {
            await fetch(`/restaurant/notifications/${notificationId}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            });
            this.loadNotifications(); // Recharger les notifications
        } catch (error) {
            console.error('Erreur lors du marquage de la notification:', error);
        }
    },
    
    async markAllAsRead() {
        try {
            await fetch('/restaurant/notifications/mark-all-as-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            });
            this.loadNotifications(); // Recharger les notifications
        } catch (error) {
            console.error('Erreur lors du marquage de toutes les notifications:', error);
        }
    }
}" 
x-init="loadNotifications()" 
class="relative">
    
    <!-- Bouton de notification -->
    <button @click="isOpen = !isOpen; loadNotifications()" 
            class="relative p-2 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">
        <i class="fas fa-bell text-xl"></i>
        
        <!-- Badge de notification -->
        <span x-show="unreadCount > 0" 
              x-text="unreadCount" 
              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center animate-pulse">
        </span>
    </button>

    <!-- Dropdown -->
    <div x-show="isOpen" 
         @click.away="isOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
        
        <!-- Header -->
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notifications</h3>
                <div class="flex space-x-2">
                    <button @click="markAllAsRead()" 
                            x-show="unreadCount > 0"
                            class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        Tout marquer comme lu
                    </button>
                    <a href="{{ route('restaurant.notifications.index') }}" 
                       class="text-xs text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300">
                        Voir tout
                    </a>
                </div>
            </div>
        </div>

        <!-- Contenu -->
        <div class="max-h-96 overflow-y-auto">
            <div x-show="loading" class="p-4 text-center">
                <i class="fas fa-spinner fa-spin text-gray-400"></i>
                <p class="text-sm text-gray-500 mt-2">Chargement...</p>
            </div>

            <div x-show="!loading && notifications.length === 0" class="p-4 text-center">
                <i class="fas fa-bell-slash text-gray-400 text-2xl mb-2"></i>
                <p class="text-sm text-gray-500">Aucune notification</p>
            </div>

            <template x-for="notification in notifications" :key="notification.id">
                <div class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm
                                bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400">
                                <i class="fas fa-bell"></i>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white" 
                               x-text="notification.data.title || 'Notification'"></p>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1" 
                               x-text="notification.data.message || 'Aucun message'"></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" 
                               x-text="notification.created_at"></p>
                        </div>
                        <div class="flex-shrink-0">
                            <button @click="markAsRead(notification.id)" 
                                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <i class="fas fa-check text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Footer -->
        <div x-show="notifications.length > 0" class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('restaurant.notifications.index') }}" 
               class="block text-center text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                Voir toutes les notifications
            </a>
        </div>
    </div>
</div>
