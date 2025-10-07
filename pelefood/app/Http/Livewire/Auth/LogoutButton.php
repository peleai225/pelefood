<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LogoutButton extends Component
{
    public $showConfirmModal = false;

    public function confirmLogout()
    {
        $this->showConfirmModal = true;
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        
        return redirect()->route('home');
    }

    public function cancelLogout()
    {
        $this->showConfirmModal = false;
    }

    public function render()
    {
        return view('livewire.auth.logout-button');
    }
}