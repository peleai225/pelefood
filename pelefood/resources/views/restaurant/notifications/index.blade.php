@extends('layouts.restaurant')

@section('title', 'Notifications')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Notifications</h1>
                <p class="text-gray-600 dark:text-gray-400">Restez informé de toutes les activités importantes</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="markAllAsRead()" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i data-lucide="check" class="w-4 h-4 inline mr-2"></i>
                    Tout marquer comme lu
                </button>
                <button onclick="refreshNotifications()" 
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i data-lucide="refresh-cw" class="w-4 h-4 inline mr-2"></i>
                    Actualiser
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                        <i data-lucide="bell" class="w-6 h-6 text-red-600 dark:text-red-400"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Non lues</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $unreadCount }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Lues</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $notifications->total() - $unreadCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                        <i data-lucide="shopping-cart" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Commandes</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $orderNotificationsCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            @if($notifications->count() > 0)
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($notifications as $notification)
                        <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors {{ $notification->read_at ? '' : 'bg-blue-50 dark:bg-blue-900/20' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg
                                            @if(($notification->data['type'] ?? 'info') === 'success') bg-green-100 dark:bg-green-900
                                            @elseif(($notification->data['type'] ?? 'info') === 'error') bg-red-100 dark:bg-red-900
                                            @elseif(($notification->data['type'] ?? 'info') === 'warning') bg-yellow-100 dark:bg-yellow-900
                                            @else bg-blue-100 dark:bg-blue-900
                                            @endif">
                                            @if(($notification->data['type'] ?? 'info') === 'success') ✅
                                            @elseif(($notification->data['type'] ?? 'info') === 'error') ❌
                                            @elseif(($notification->data['type'] ?? 'info') === 'warning') ⚠️
                                            @else 🔔
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-2">
                                            @if(!$notification->read_at)
                                                <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                                            @endif
                                            <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $notification->data['title'] ?? 'Notification' }}
                                            </h3>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                            {{ $notification->data['message'] ?? 'Aucun message' }}
                                        </p>
                                        
                                        @if(isset($notification->data['data']))
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            @if(isset($notification->data['data']['order_id']))
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    Commande #{{ $notification->data['data']['order_id'] }}
                                                </span>
                                            @endif
                                            @if(isset($notification->data['data']['order_total']))
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    {{ number_format($notification->data['data']['order_total'], 0, ',', ' ') }} FCFA
                                                </span>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if(!$notification->read_at)
                                    <button onclick="markAsRead('{{ $notification->id }}')" 
                                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                            title="Marquer comme lu">
                                        <i data-lucide="check" class="w-5 h-5"></i>
                                    </button>
                                    @endif
                                    <button onclick="deleteNotification('{{ $notification->id }}')" 
                                            class="text-gray-400 hover:text-red-600"
                                            title="Supprimer">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($notifications->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $notifications->links() }}
                </div>
                @endif
            @else
                <div class="text-center py-12">
                    <i data-lucide="bell-off" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Aucune notification</h3>
                    <p class="text-gray-600 dark:text-gray-400">Vous n'avez pas encore de notifications.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function markAsRead(notificationId) {
    fetch(`/restaurant/notifications/${notificationId}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function markAllAsRead() {
    fetch('/restaurant/notifications/mark-all-as-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function deleteNotification(notificationId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette notification ?')) {
        fetch(`/restaurant/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function refreshNotifications() {
    location.reload();
}
</script>
@endsection
