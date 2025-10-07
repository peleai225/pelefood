<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Order;

class SupportFixed extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, open, closed, urgent
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 12;
    
    // Modal pour créer/répondre à un ticket
    public $showModal = false;
    public $modalTitle = '';
    public $selectedTicket = null;
    public $editingTicket = null;
    
    // Champs du formulaire
    public $subject = '';
    public $description = '';
    public $priority = 'medium'; // low, medium, high, urgent
    public $status = 'open'; // open, in_progress, resolved, closed
    public $user_id = '';
    public $response = '';

    protected $rules = [
        'subject' => 'required|string|max:255',
        'description' => 'required|string|max:2000',
        'priority' => 'required|in:low,medium,high,urgent',
        'status' => 'required|in:open,in_progress,resolved,closed',
        'user_id' => 'required|exists:users,id',
        'response' => 'nullable|string|max:2000'
    ];

    protected $messages = [
        'subject.required' => 'Le sujet est obligatoire.',
        'description.required' => 'La description est obligatoire.',
        'user_id.required' => 'L\'utilisateur est obligatoire.',
    ];

    public function mount()
    {
        // Pas de chargement de données complexes
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function createTicket()
    {
        $this->resetForm();
        $this->modalTitle = 'Créer un nouveau ticket de support';
        $this->showModal = true;
    }

    public function viewTicket($ticketId)
    {
        try {
            // Simuler un ticket de support
            $ticket = $this->getSimulatedTicket($ticketId);
            $this->selectedTicket = $ticket;
            $this->modalTitle = 'Ticket de support #' . $ticket['id'];
            $this->showModal = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors du chargement du ticket.');
        }
    }

    public function saveTicket()
    {
        try {
            $this->validate();

            // Simuler la sauvegarde d'un ticket
            $ticketData = [
                'subject' => $this->subject,
                'description' => $this->description,
                'priority' => $this->priority,
                'status' => $this->status,
                'user_id' => $this->user_id,
                'created_at' => now(),
            ];

            session()->flash('message', 'Ticket de support créé avec succès !');
            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la sauvegarde : ' . $e->getMessage());
        }
    }

    public function addResponse()
    {
        try {
            $this->validate(['response' => 'required|string|max:2000']);

            // Simuler l'ajout d'une réponse
            session()->flash('message', 'Réponse ajoutée avec succès !');
            $this->response = '';
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de l\'ajout de la réponse : ' . $e->getMessage());
        }
    }

    public function updateTicketStatus($ticketId, $status)
    {
        try {
            // Simuler la mise à jour du statut
            session()->flash('message', 'Statut du ticket mis à jour !');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    public function closeTicket($ticketId)
    {
        try {
            // Simuler la fermeture du ticket
            session()->flash('message', 'Ticket fermé avec succès !');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la fermeture : ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedTicket = null;
        $this->editingTicket = null;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->subject = '';
        $this->description = '';
        $this->priority = 'medium';
        $this->status = 'open';
        $this->user_id = '';
        $this->response = '';
        $this->resetErrorBag();
    }

    public function getUsersProperty()
    {
        return User::select('id', 'name', 'email')->get();
    }

    public function getPriorityBadgeClass($priority)
    {
        return match($priority) {
            'low' => 'bg-gray-100 text-gray-800',
            'medium' => 'bg-blue-100 text-blue-800',
            'high' => 'bg-orange-100 text-orange-800',
            'urgent' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getPriorityLabel($priority)
    {
        return match($priority) {
            'low' => 'Faible',
            'medium' => 'Moyenne',
            'high' => 'Élevée',
            'urgent' => 'Urgente',
            default => $priority
        };
    }

    public function getStatusBadgeClass($status)
    {
        return match($status) {
            'open' => 'bg-yellow-100 text-yellow-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'resolved' => 'bg-green-100 text-green-800',
            'closed' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getStatusLabel($status)
    {
        return match($status) {
            'open' => 'Ouvert',
            'in_progress' => 'En cours',
            'resolved' => 'Résolu',
            'closed' => 'Fermé',
            default => $status
        };
    }

    private function getSimulatedTicket($ticketId)
    {
        // Simuler un ticket de support
        return [
            'id' => $ticketId,
            'subject' => 'Problème avec la commande #12345',
            'description' => 'Je n\'ai pas reçu ma commande et je ne peux pas contacter le restaurant.',
            'priority' => 'high',
            'status' => 'open',
            'user' => User::first(),
            'created_at' => now()->subDays(2),
            'responses' => [
                [
                    'id' => 1,
                    'message' => 'Bonjour, nous allons enquêter sur votre problème.',
                    'author' => 'Support Team',
                    'created_at' => now()->subDay()
                ]
            ]
        ];
    }

    public function getSupportStats()
    {
        // Simuler des statistiques de support
        return [
            'total_tickets' => 156,
            'open_tickets' => 23,
            'resolved_tickets' => 120,
            'avg_response_time' => '2h 30min',
            'satisfaction_rate' => '4.2/5'
        ];
    }

    public function render()
    {
        // Simuler des tickets de support basés sur les commandes récentes
        $query = Order::with(['user', 'restaurant'])
            ->where('created_at', '>=', now()->subDays(30));

        if ($this->search) {
            $query->where(function($q) {
                $q->where('id', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        $query->orderBy($this->sortBy, $this->sortDirection);
        $orders = $query->paginate($this->perPage);

        // Convertir les commandes en tickets de support simulés
        $tickets = $orders->getCollection()->map(function($order, $index) {
            return [
                'id' => $order->id,
                'subject' => 'Support pour commande #' . $order->id,
                'description' => 'Demande d\'aide concernant la commande du ' . $order->created_at->format('d/m/Y'),
                'priority' => $order->status === 'cancelled' ? 'high' : 'medium',
                'status' => $order->status === 'delivered' ? 'resolved' : 'open',
                'user' => $order->user,
                'created_at' => $order->created_at,
                'restaurant' => $order->restaurant
            ];
        });

        $tickets = $orders->setCollection($tickets);
        $stats = $this->getSupportStats();

        return view('livewire.admin.support-fixed', [
            'tickets' => $tickets,
            'stats' => $stats
        ])->layout('layouts.super-admin-new-design');
    }
}
