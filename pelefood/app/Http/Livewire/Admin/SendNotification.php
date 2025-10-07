<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Notifications\BulkNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\WithFileUploads;

class SendNotification extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $modalTitle = 'Envoyer une notification';

    // Form fields
    public $title = '';
    public $message = '';
    public $type = 'announcement';
    public $channels = ['database'];
    public $target_roles = [];
    public $target_users = [];
    public $send_to_all = false;
    public $attachment = null;

    // Available options
    public $availableRoles = [
        'super_admin' => 'Super Admin',
        'admin' => 'Admin',
        'restaurant' => 'Restaurant',
        'customer' => 'Client',
        'driver' => 'Livreur'
    ];

    public $availableChannels = [
        'database' => 'Base de données',
        'mail' => 'Email',
        'broadcast' => 'Temps réel',
        'slack' => 'Slack',
        'nexmo' => 'SMS'
    ];

    public $availableTypes = [
        'announcement' => 'Annonce',
        'promotion' => 'Promotion',
        'maintenance' => 'Maintenance',
        'update' => 'Mise à jour',
        'warning' => 'Avertissement',
        'success' => 'Succès',
        'error' => 'Erreur'
    ];

    protected $rules = [
        'title' => 'required|string|max:255',
        'message' => 'required|string|max:1000',
        'type' => 'required|in:announcement,promotion,maintenance,update,warning,success,error',
        'channels' => 'required|array|min:1',
        'channels.*' => 'in:database,mail,broadcast,slack,nexmo',
    ];

    protected $messages = [
        'title.required' => 'Le titre est obligatoire.',
        'message.required' => 'Le message est obligatoire.',
        'type.required' => 'Le type est obligatoire.',
        'channels.required' => 'Au moins un canal doit être sélectionné.',
        'channels.min' => 'Au moins un canal doit être sélectionné.',
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->title = '';
        $this->message = '';
        $this->type = 'announcement';
        $this->channels = ['database'];
        $this->target_roles = [];
        $this->target_users = [];
        $this->send_to_all = false;
        $this->attachment = null;
    }

    public function updatedSendToAll()
    {
        if ($this->send_to_all) {
            $this->target_roles = array_keys($this->availableRoles);
            $this->target_users = [];
        } else {
            $this->target_roles = [];
            $this->target_users = [];
        }
    }

    public function sendNotification()
    {
        $this->validate();

        try {
            // Déterminer les utilisateurs cibles
            if ($this->send_to_all) {
                $users = User::all();
            } elseif (!empty($this->target_users)) {
                $users = User::whereIn('id', $this->target_users)->get();
            } elseif (!empty($this->target_roles)) {
                $users = User::whereIn('role', $this->target_roles)->get();
            } else {
                session()->flash('error', 'Veuillez sélectionner au moins un destinataire.');
                return;
            }

            if ($users->isEmpty()) {
                session()->flash('error', 'Aucun utilisateur trouvé pour les critères sélectionnés.');
                return;
            }

            // Créer la notification
            $notification = new BulkNotification(
                $this->title,
                $this->message,
                $this->type,
                $this->channels
            );

            // Envoyer la notification
            Notification::send($users, $notification);

            $count = $users->count();
            session()->flash('success', "Notification envoyée avec succès à {$count} utilisateur(s) !");
            
            // Émettre un événement pour mettre à jour les notifications de la navbar
            $this->emit('notificationReceived');
            
            $this->closeModal();

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de l\'envoi de la notification : ' . $e->getMessage());
        }
    }

    public function getUsersProperty()
    {
        return User::select('id', 'name', 'email', 'role')
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.send-notification', [
            'users' => $this->users
        ])->layout('layouts.super-admin-new-design');
    }
}
