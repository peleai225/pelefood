<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Order;

class Support extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 12;

    protected $listeners = ['ticketUpdated' => 'loadStats'];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        // Les statistiques sont gérées par AdminStatsComposer
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getSupportStats()
    {
        return [
            'open_tickets' => 0, // Temporaire - pas de modèle SupportTicket
            'resolved_tickets' => 0,
            'avg_response_time' => '2h 30min',
            'satisfaction_rate' => '4.2/5',
            'recent_tickets' => collect([]) // Temporaire
        ];
    }

    public function render()
    {
        $stats = $this->getSupportStats();
        
        return view('livewire.admin.support', [
            'stats' => $stats
        ])->layout('layouts.super-admin-new-design');
    }
}