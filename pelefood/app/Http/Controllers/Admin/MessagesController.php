<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Tenant;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer les statistiques des messages
        $totalMessages = Message::count();
        $unreadMessages = Message::where('is_read', false)->count();
        $urgentMessages = Message::where('priority', 'urgent')->count();
        $todayMessages = Message::whereDate('created_at', today())->count();

        // Récupérer les messages avec pagination
        $messages = Message::with(['user', 'tenant'])
            ->latest()
            ->paginate(20);

        return view('admin.messages.index', compact(
            'messages',
            'totalMessages',
            'unreadMessages',
            'urgentMessages',
            'todayMessages'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tenants = Tenant::all();
        $users = User::all();
        
        return view('admin.messages.create', compact('tenants', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'priority' => 'required|in:low,normal,high,urgent',
            'type' => 'required|in:general,support,billing,technical',
            'is_read' => 'boolean',
            'is_urgent' => 'boolean',
        ]);

        // Si c'est un message urgent, marquer comme non lu
        if ($validated['priority'] === 'urgent') {
            $validated['is_urgent'] = true;
            $validated['is_read'] = false;
        }

        $message = Message::create($validated);

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        // Marquer le message comme lu
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        $tenants = Tenant::all();
        $users = User::all();
        
        return view('admin.messages.edit', compact('message', 'tenants', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'priority' => 'required|in:low,normal,high,urgent',
            'type' => 'required|in:general,support,billing,technical',
            'is_read' => 'boolean',
            'is_urgent' => 'boolean',
        ]);

        // Si c'est un message urgent, marquer comme non lu
        if ($validated['priority'] === 'urgent') {
            $validated['is_urgent'] = true;
            $validated['is_read'] = false;
        }

        $message->update($validated);

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message supprimé avec succès.');
    }

    /**
     * Mark message as read.
     */
    public function markAsRead(Message $message)
    {
        $message->update(['is_read' => true]);

        return back()->with('success', 'Message marqué comme lu.');
    }

    /**
     * Mark message as unread.
     */
    public function markAsUnread(Message $message)
    {
        $message->update(['is_read' => false]);

        return back()->with('success', 'Message marqué comme non lu.');
    }

    /**
     * Mark all messages as read.
     */
    public function markAllAsRead()
    {
        Message::where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'Tous les messages ont été marqués comme lus.');
    }

    /**
     * Reply to a message.
     */
    public function reply(Request $request, Message $message)
    {
        $validated = $request->validate([
            'reply_content' => 'required|string',
        ]);

        // Créer une réponse
        $reply = Message::create([
            'user_id' => $message->user_id,
            'tenant_id' => $message->tenant_id,
            'subject' => 'Re: ' . $message->subject,
            'content' => $validated['reply_content'],
            'priority' => $message->priority,
            'type' => $message->type,
            'parent_id' => $message->id,
            'is_read' => false,
        ]);

        // Marquer le message original comme lu
        $message->update(['is_read' => true]);

        return back()->with('success', 'Réponse envoyée avec succès.');
    }

    /**
     * Export messages data.
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');
        
        $messages = Message::with(['user', 'tenant'])
            ->when($request->filled('priority'), function ($query, $priority) {
                return $query->where('priority', $priority);
            })
            ->when($request->filled('type'), function ($query, $type) {
                return $query->where('type', $type);
            })
            ->when($request->filled('is_read'), function ($query, $isRead) {
                return $query->where('is_read', $isRead === 'true');
            })
            ->when($request->filled('date_from'), function ($query, $date) {
                return $query->whereDate('created_at', '>=', $date);
            })
            ->when($request->filled('date_to'), function ($query, $date) {
                return $query->whereDate('created_at', '<=', $date);
            })
            ->get();

        if ($format === 'csv') {
            return $this->exportToCsv($messages);
        }

        return back()->with('error', 'Format d\'export non supporté.');
    }

    /**
     * Export to CSV.
     */
    private function exportToCsv($messages)
    {
        $filename = 'messages_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($messages) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID', 'Sujet', 'Utilisateur', 'Tenant', 'Priorité', 
                'Type', 'Statut', 'Date', 'Contenu'
            ]);

            // Données
            foreach ($messages as $message) {
                fputcsv($file, [
                    $message->id,
                    $message->subject,
                    $message->user->name ?? 'N/A',
                    $message->tenant->name ?? 'N/A',
                    $message->priority,
                    $message->type,
                    $message->is_read ? 'Lu' : 'Non lu',
                    $message->created_at->format('d/m/Y H:i'),
                    substr($message->content, 0, 100) . '...'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 