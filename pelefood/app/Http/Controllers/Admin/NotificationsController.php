<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use App\Models\Tenant;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer les statistiques des notifications
        $totalNotifications = Notification::count();
        $unreadNotifications = Notification::where('is_read', false)->count();
        $urgentNotifications = Notification::where('priority', 'urgent')->count();
        $todayNotifications = Notification::whereDate('created_at', today())->count();

        // Récupérer les notifications avec pagination
        $notifications = Notification::with(['user', 'tenant'])
            ->latest()
            ->paginate(20);

        return view('admin.notifications.index', compact(
            'notifications',
            'totalNotifications',
            'unreadNotifications',
            'urgentNotifications',
            'todayNotifications'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tenants = Tenant::all();
        $users = User::all();
        
        return view('admin.notifications.create', compact('tenants', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:info,warning,error,success',
            'priority' => 'required|in:low,normal,high,urgent',
            'is_read' => 'boolean',
            'is_urgent' => 'boolean',
            'action_url' => 'nullable|url',
            'action_text' => 'nullable|string|max:100',
        ]);

        // Si c'est une notification urgente, marquer comme non lue
        if ($validated['priority'] === 'urgent') {
            $validated['is_urgent'] = true;
            $validated['is_read'] = false;
        }

        $notification = Notification::create($validated);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        // Marquer la notification comme lue
        if (!$notification->is_read) {
            $notification->update(['is_read' => true]);
        }

        return view('admin.notifications.show', compact('notification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        $tenants = Tenant::all();
        $users = User::all();
        
        return view('admin.notifications.edit', compact('notification', 'tenants', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:info,warning,error,success',
            'priority' => 'required|in:low,normal,high,urgent',
            'is_read' => 'boolean',
            'is_urgent' => 'boolean',
            'action_url' => 'nullable|url',
            'action_text' => 'nullable|string|max:100',
        ]);

        // Si c'est une notification urgente, marquer comme non lue
        if ($validated['priority'] === 'urgent') {
            $validated['is_urgent'] = true;
            $validated['is_read'] = false;
        }

        $notification->update($validated);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification supprimée avec succès.');
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);

        return back()->with('success', 'Notification marquée comme lue.');
    }

    /**
     * Mark notification as unread.
     */
    public function markAsUnread(Notification $notification)
    {
        $notification->update(['is_read' => false]);

        return back()->with('success', 'Notification marquée comme non lue.');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    /**
     * Send notification to all users.
     */
    public function sendToAll(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:info,warning,error,success',
            'priority' => 'required|in:low,normal,high,urgent',
            'action_url' => 'nullable|url',
            'action_text' => 'nullable|string|max:100',
        ]);

        // Créer une notification pour tous les utilisateurs
        $users = User::all();
        
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => $validated['title'],
                'content' => $validated['content'],
                'type' => $validated['type'],
                'priority' => $validated['priority'],
                'action_url' => $validated['action_url'],
                'action_text' => $validated['action_text'],
                'is_read' => false,
                'is_urgent' => $validated['priority'] === 'urgent',
            ]);
        }

        return back()->with('success', 'Notification envoyée à tous les utilisateurs.');
    }

    /**
     * Send notification to specific tenant.
     */
    public function sendToTenant(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:info,warning,error,success',
            'priority' => 'required|in:low,normal,high,urgent',
            'action_url' => 'nullable|url',
            'action_text' => 'nullable|string|max:100',
        ]);

        // Créer une notification pour le tenant
        Notification::create([
            'tenant_id' => $tenant->id,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'type' => $validated['type'],
            'priority' => $validated['priority'],
            'action_url' => $validated['action_url'],
            'action_text' => $validated['action_text'],
            'is_read' => false,
            'is_urgent' => $validated['priority'] === 'urgent',
        ]);

        return back()->with('success', 'Notification envoyée au tenant avec succès.');
    }

    /**
     * Export notifications data.
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');
        
        $notifications = Notification::with(['user', 'tenant'])
            ->when($request->filled('type'), function ($query, $type) {
                return $query->where('type', $type);
            })
            ->when($request->filled('priority'), function ($query, $priority) {
                return $query->where('priority', $priority);
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
            return $this->exportToCsv($notifications);
        }

        return back()->with('error', 'Format d\'export non supporté.');
    }

    /**
     * Export to CSV.
     */
    private function exportToCsv($notifications)
    {
        $filename = 'notifications_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($notifications) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID', 'Titre', 'Utilisateur', 'Tenant', 'Type', 
                'Priorité', 'Statut', 'Date', 'Contenu'
            ]);

            // Données
            foreach ($notifications as $notification) {
                fputcsv($file, [
                    $notification->id,
                    $notification->title,
                    $notification->user->name ?? 'N/A',
                    $notification->tenant->name ?? 'N/A',
                    $notification->type,
                    $notification->priority,
                    $notification->is_read ? 'Lue' : 'Non lue',
                    $notification->created_at->format('d/m/Y H:i'),
                    substr($notification->content, 0, 100) . '...'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 