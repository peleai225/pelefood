<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Profile extends Component
{
    use WithFileUploads;

    public $user;
    public $name;
    public $email;
    public $phone;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;
    public $avatar;
    public $showPasswordModal = false;
    public $showAvatarModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
    ];

    protected $messages = [
        'name.required' => 'Le nom est requis.',
        'email.required' => 'L\'email est requis.',
        'email.email' => 'L\'email doit être valide.',
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
    }

    public function updateProfile()
    {
        $this->validate();

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        $this->emit('showNotification', 'Profil mis à jour avec succès', 'success');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required|min:8',
        ], [
            'current_password.required' => 'Le mot de passe actuel est requis.',
            'new_password.required' => 'Le nouveau mot de passe est requis.',
            'new_password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères.',
            'new_password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'new_password_confirmation.required' => 'La confirmation du mot de passe est requise.',
        ]);

        if (!Hash::check($this->current_password, $this->user->password)) {
            $this->addError('current_password', 'Le mot de passe actuel est incorrect.');
            return;
        }

        $this->user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->resetPasswordFields();
        $this->showPasswordModal = false;
        $this->emit('showNotification', 'Mot de passe mis à jour avec succès', 'success');
    }

    public function updateAvatar()
    {
        $this->validate([
            'avatar' => 'required|image|max:2048',
        ], [
            'avatar.required' => 'Veuillez sélectionner une image.',
            'avatar.image' => 'Le fichier doit être une image.',
            'avatar.max' => 'L\'image ne doit pas dépasser 2MB.',
        ]);

        // Supprimer l'ancien avatar s'il existe
        if ($this->user->avatar && Storage::disk('public')->exists($this->user->avatar)) {
            Storage::disk('public')->delete($this->user->avatar);
        }

        // Stocker le nouvel avatar
        $avatarPath = $this->avatar->store('avatars', 'public');
        
        $this->user->update([
            'avatar' => $avatarPath,
        ]);

        $this->avatar = null;
        $this->showAvatarModal = false;
        $this->emit('showNotification', 'Photo de profil mise à jour avec succès', 'success');
    }

    public function showPasswordModal()
    {
        $this->showPasswordModal = true;
    }

    public function showAvatarModal()
    {
        $this->showAvatarModal = true;
    }

    public function closePasswordModal()
    {
        $this->showPasswordModal = false;
        $this->resetPasswordFields();
    }

    public function closeAvatarModal()
    {
        $this->showAvatarModal = false;
        $this->avatar = null;
    }

    public function resetPasswordFields()
    {
        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';
        $this->resetErrorBag(['current_password', 'new_password', 'new_password_confirmation']);
    }

    public function render()
    {
        return view('livewire.admin.profile')->layout('layouts.super-admin-new-design');
    }
}