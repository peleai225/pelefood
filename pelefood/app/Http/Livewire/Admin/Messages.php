<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Messages extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 12;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getMessagesProperty()
    {
        // Simuler des messages depuis les utilisateurs
        $query = User::query();
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }
        
        return $query->orderBy($this->sortBy, $this->sortDirection)
                    ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.messages', [
            'messages' => $this->messages
        ])->layout('layouts.super-admin-new-design');
    }
}