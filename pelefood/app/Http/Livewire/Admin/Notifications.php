<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\User;

class Notifications extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, unread, read
    public $perPage = 12;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function markAsRead($notificationId)
    {
        $notification = DatabaseNotification::findOrFail($notificationId);
        $notification->markAsRead();
        session()->flash('success', 'Notification marquée comme lue !');
    }

    public function markAsUnread($notificationId)
    {
        $notification = DatabaseNotification::findOrFail($notificationId);
        $notification->update(['read_at' => null]);
        session()->flash('success', 'Notification marquée comme non lue !');
    }

    public function markAllAsRead()
    {
        DatabaseNotification::whereNull('read_at')->update(['read_at' => now()]);
        session()->flash('success', 'Toutes les notifications ont été marquées comme lues !');
    }

    public function deleteNotification($notificationId)
    {
        try {
            $notification = DatabaseNotification::findOrFail($notificationId);
            $notification->delete();
            session()->flash('success', 'Notification supprimée avec succès !');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->filter = 'all';
        $this->resetPage();
    }

    public function getNotificationsProperty()
    {
        $query = DatabaseNotification::with(['notifiable'])
            ->when($this->search, function($query) {
                $query->whereRaw("JSON_EXTRACT(data, '$.title') LIKE ?", ['%' . $this->search . '%'])
                      ->orWhereRaw("JSON_EXTRACT(data, '$.message') LIKE ?", ['%' . $this->search . '%'])
                      ->orWhereRaw("JSON_EXTRACT(data, '$.body') LIKE ?", ['%' . $this->search . '%']);
            })
            ->when($this->filter === 'unread', function($query) {
                $query->whereNull('read_at');
            })
            ->when($this->filter === 'read', function($query) {
                $query->whereNotNull('read_at');
            })
            ->orderBy('created_at', 'desc');
            
        return $query->paginate($this->perPage);
    }

    public function getStatsProperty()
    {
        return [
            'total' => DatabaseNotification::count(),
            'unread' => DatabaseNotification::whereNull('read_at')->count(),
            'read' => DatabaseNotification::whereNotNull('read_at')->count(),
        ];
    }

    public function render()
    {
        return view('livewire.admin.notifications', [
            'notifications' => $this->notifications,
            'stats' => $this->stats
        ])->layout('layouts.super-admin-new-design');
    }
}