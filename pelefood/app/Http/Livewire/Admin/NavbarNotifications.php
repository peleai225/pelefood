<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Notifications\DatabaseNotification;

class NavbarNotifications extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    protected $listeners = [
        'notificationReceived' => 'loadNotifications',
        'notificationMarkedAsRead' => 'loadNotifications',
        'notificationDeleted' => 'loadNotifications',
        'refreshNotifications' => 'loadNotifications'
    ];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = auth()->user()->unreadNotifications()
            ->take(5)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->data['title'] ?? 'Notification',
                    'message' => $notification->data['message'] ?? $notification->data['body'] ?? 'Nouvelle notification',
                    'time' => $notification->created_at->diffForHumans(),
                    'type' => $notification->data['type'] ?? 'info',
                    'icon' => $this->getNotificationIcon($notification->data['type'] ?? 'info'),
                    'color' => $this->getNotificationColor($notification->data['type'] ?? 'info')
                ];
            })
            ->toArray();

        $this->unreadCount = auth()->user()->unreadNotifications()->count();
    }

    public function markAsRead($notificationId)
    {
        $notification = DatabaseNotification::findOrFail($notificationId);
        $notification->markAsRead();
        
        $this->loadNotifications();
        $this->emit('notificationMarkedAsRead');
        $this->emit('closeDropdown');
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);
        $this->loadNotifications();
        $this->emit('notificationMarkedAsRead');
    }


    private function getNotificationIcon($type)
    {
        $icons = [
            'info' => 'fas fa-info-circle',
            'success' => 'fas fa-check-circle',
            'warning' => 'fas fa-exclamation-triangle',
            'error' => 'fas fa-times-circle',
            'announcement' => 'fas fa-bullhorn',
            'promotion' => 'fas fa-percent',
            'maintenance' => 'fas fa-tools',
            'update' => 'fas fa-sync-alt'
        ];

        return $icons[$type] ?? 'fas fa-bell';
    }

    private function getNotificationColor($type)
    {
        $colors = [
            'info' => 'text-blue-600',
            'success' => 'text-green-600',
            'warning' => 'text-yellow-600',
            'error' => 'text-red-600',
            'announcement' => 'text-purple-600',
            'promotion' => 'text-orange-600',
            'maintenance' => 'text-gray-600',
            'update' => 'text-indigo-600'
        ];

        return $colors[$type] ?? 'text-gray-600';
    }

    public function render()
    {
        return view('livewire.admin.navbar-notifications');
    }
}
