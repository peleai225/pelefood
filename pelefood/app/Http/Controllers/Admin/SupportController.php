<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SupportTicketResponse;

class SupportController extends Controller
{
    /**
     * Display a listing of support tickets.
     */
    public function index()
    {
        $tickets = SupportTicket::with(['user', 'restaurant'])
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total_tickets' => SupportTicket::count(),
            'open_tickets' => SupportTicket::where('status', 'open')->count(),
            'in_progress_tickets' => SupportTicket::where('status', 'in_progress')->count(),
            'resolved_tickets' => SupportTicket::where('status', 'resolved')->count(),
            'urgent_tickets' => SupportTicket::where('priority', 'urgent')->count(),
        ];

        return view('admin.support.index', compact('tickets', 'stats'));
    }

    /**
     * Show the form for creating a new support ticket.
     */
    public function create()
    {
        $users = User::where('role', '!=', 'super_admin')->get();
        $restaurants = Restaurant::all();
        
        return view('admin.support.create', compact('users', 'restaurants'));
    }

    /**
     * Store a newly created support ticket.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'category' => 'required|in:technical,billing,feature_request,bug_report,general',
            'user_id' => 'nullable|exists:users,id',
            'restaurant_id' => 'nullable|exists:restaurants,id',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $ticket = SupportTicket::create([
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'category' => $validated['category'],
            'user_id' => $validated['user_id'],
            'restaurant_id' => $validated['restaurant_id'],
            'assigned_to' => $validated['assigned_to'],
            'status' => 'open',
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.support.index')
            ->with('success', 'Ticket de support créé avec succès.');
    }

    /**
     * Display the specified support ticket.
     */
    public function show(SupportTicket $ticket)
    {
        $ticket->load(['user', 'restaurant', 'assignedTo', 'responses.user']);
        
        return view('admin.support.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified support ticket.
     */
    public function edit(SupportTicket $ticket)
    {
        $users = User::where('role', '!=', 'super_admin')->get();
        $restaurants = Restaurant::all();
        
        return view('admin.support.edit', compact('ticket', 'users', 'restaurants'));
    }

    /**
     * Update the specified support ticket.
     */
    public function update(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'category' => 'required|in:technical,billing,feature_request,bug_report,general',
            'status' => 'required|in:open,in_progress,resolved,closed',
            'user_id' => 'nullable|exists:users,id',
            'restaurant_id' => 'nullable|exists:restaurants,id',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $ticket->update($validated);

        return redirect()->route('admin.support.show', $ticket)
            ->with('success', 'Ticket de support mis à jour avec succès.');
    }

    /**
     * Remove the specified support ticket.
     */
    public function destroy(SupportTicket $ticket)
    {
        $ticket->delete();

        return redirect()->route('admin.support.index')
            ->with('success', 'Ticket de support supprimé avec succès.');
    }

    /**
     * Update ticket status.
     */
    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
            'note' => 'nullable|string',
        ]);

        $ticket->update(['status' => $validated['status']]);

        if ($validated['note']) {
            $ticket->responses()->create([
                'content' => $validated['note'],
                'user_id' => auth()->id(),
                'is_internal' => true,
            ]);
        }

        return redirect()->back()->with('success', 'Statut du ticket mis à jour.');
    }

    /**
     * Assign ticket to user.
     */
    public function assign(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $ticket->update(['assigned_to' => $validated['assigned_to']]);

        return redirect()->back()->with('success', 'Ticket assigné avec succès.');
    }

    /**
     * Add response to ticket.
     */
    public function addResponse(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'is_internal' => 'boolean',
        ]);

        $response = $ticket->responses()->create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
            'is_internal' => $validated['is_internal'] ?? false,
        ]);

        // Si c'est une réponse publique, notifier l'utilisateur
        if (!$validated['is_internal'] && $ticket->user) {
            Mail::to($ticket->user->email)->send(new SupportTicketResponse($ticket, $response));
        }

        return redirect()->back()->with('success', 'Réponse ajoutée avec succès.');
    }

    /**
     * Export support tickets.
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');
        
        $tickets = SupportTicket::with(['user', 'restaurant', 'assignedTo'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($format === 'csv') {
            return $this->exportToCsv($tickets);
        }

        return response()->json($tickets);
    }

    /**
     * Export tickets to CSV.
     */
    private function exportToCsv($tickets)
    {
        $filename = 'support_tickets_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($tickets) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, [
                'ID', 'Sujet', 'Description', 'Priorité', 'Catégorie', 'Statut',
                'Utilisateur', 'Restaurant', 'Assigné à', 'Créé le', 'Mis à jour le'
            ]);

            // Data
            foreach ($tickets as $ticket) {
                fputcsv($file, [
                    $ticket->id,
                    $ticket->subject,
                    $ticket->description,
                    $ticket->priority,
                    $ticket->category,
                    $ticket->status,
                    $ticket->user ? $ticket->user->name : 'N/A',
                    $ticket->restaurant ? $ticket->restaurant->name : 'N/A',
                    $ticket->assignedTo ? $ticket->assignedTo->name : 'N/A',
                    $ticket->created_at->format('d/m/Y H:i'),
                    $ticket->updated_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get support statistics.
     */
    public function statistics()
    {
        $stats = [
            'tickets_by_status' => SupportTicket::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status'),
            
            'tickets_by_priority' => SupportTicket::selectRaw('priority, COUNT(*) as count')
                ->groupBy('priority')
                ->get()
                ->pluck('count', 'priority'),
            
            'tickets_by_category' => SupportTicket::selectRaw('category, COUNT(*) as count')
                ->groupBy('category')
                ->get()
                ->pluck('count', 'category'),
            
            'tickets_by_month' => SupportTicket::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->get()
                ->pluck('count', 'month'),
            
            'average_resolution_time' => SupportTicket::where('status', 'resolved')
                ->whereNotNull('resolved_at')
                ->avg(\DB::raw('TIMESTAMPDIFF(HOUR, created_at, resolved_at)')),
        ];

        return view('admin.support.statistics', compact('stats'));
    }
} 