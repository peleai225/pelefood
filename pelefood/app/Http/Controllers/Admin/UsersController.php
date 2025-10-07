<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Récupérer les statistiques
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $pendingUsers = User::where('status', 'pending')->count();
        $suspendedUsers = User::where('status', 'suspended')->count();

        // Récupérer les utilisateurs avec filtres
        $query = User::with(['tenant']);

        // Filtre par recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filtre par rôle
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filtre par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'pendingUsers',
            'suspendedUsers'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tenants = Tenant::all();
        $roles = ['admin', 'manager', 'staff', 'user'];
        
        return view('admin.users.create', compact('tenants', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,manager,staff,user',
            'status' => 'required|in:active,pending,suspended',
            'tenant_id' => 'nullable|exists:tenants,id',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        // Créer l'utilisateur
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => $validated['status'],
            'tenant_id' => $validated['tenant_id'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'country' => $validated['country'],
            'postal_code' => $validated['postal_code'],
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['tenant', 'orders', 'reviews']);
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $tenants = Tenant::all();
        $roles = ['admin', 'manager', 'staff', 'user'];
        
        return view('admin.users.edit', compact('user', 'tenants', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,manager,staff,user',
            'status' => 'required|in:active,pending,suspended',
            'tenant_id' => 'nullable|exists:tenants,id',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        // Mettre à jour les données de base
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'status' => $validated['status'],
            'tenant_id' => $validated['tenant_id'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'country' => $validated['country'],
            'postal_code' => $validated['postal_code'],
        ];

        // Mettre à jour le mot de passe si fourni
        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Empêcher la suppression de l'utilisateur connecté
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Toggle user status.
     */
    public function toggleStatus(User $user)
    {
        $newStatus = $user->status === 'active' ? 'suspended' : 'active';
        $user->update(['status' => $newStatus]);

        $statusText = $newStatus === 'active' ? 'activé' : 'suspendu';
        return back()->with('success', "Utilisateur {$statusText} avec succès.");
    }

    /**
     * Reset user password.
     */
    public function resetPassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($validated['new_password'])
        ]);

        return back()->with('success', 'Mot de passe réinitialisé avec succès.');
    }

    /**
     * Bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:activate,suspend,delete,change_role',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'new_role' => 'required_if:action,change_role|in:admin,manager,staff,user',
        ]);

        $userIds = $validated['user_ids'];
        $action = $validated['action'];

        switch ($action) {
            case 'activate':
                User::whereIn('id', $userIds)->update(['status' => 'active']);
                $message = 'Utilisateurs activés avec succès.';
                break;

            case 'suspend':
                User::whereIn('id', $userIds)->update(['status' => 'suspended']);
                $message = 'Utilisateurs suspendus avec succès.';
                break;

            case 'delete':
                // Empêcher la suppression de l'utilisateur connecté
                $userIds = array_filter($userIds, function($id) {
                    return $id !== auth()->id();
                });
                User::whereIn('id', $userIds)->delete();
                $message = 'Utilisateurs supprimés avec succès.';
                break;

            case 'change_role':
                User::whereIn('id', $userIds)->update(['role' => $validated['new_role']]);
                $message = 'Rôles des utilisateurs modifiés avec succès.';
                break;

            default:
                $message = 'Action non reconnue.';
        }

        return back()->with('success', $message);
    }

    /**
     * Export users data.
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');
        
        $users = User::with(['tenant'])
            ->when($request->filled('role'), function ($query, $role) {
                return $query->where('role', $role);
            })
            ->when($request->filled('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->filled('tenant_id'), function ($query, $tenantId) {
                return $query->where('tenant_id', $tenantId);
            })
            ->get();

        if ($format === 'csv') {
            return $this->exportToCsv($users);
        }

        return back()->with('error', 'Format d\'export non supporté.');
    }

    /**
     * Export to CSV.
     */
    private function exportToCsv($users)
    {
        $filename = 'utilisateurs_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID', 'Nom', 'Email', 'Téléphone', 'Rôle', 'Statut', 
                'Tenant', 'Adresse', 'Ville', 'Pays', 'Code Postal', 'Date d\'inscription'
            ]);

            // Données
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->phone ?? '',
                    $user->role,
                    $user->status,
                    $user->tenant->name ?? 'N/A',
                    $user->address ?? '',
                    $user->city ?? '',
                    $user->country ?? '',
                    $user->postal_code ?? '',
                    $user->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get user statistics.
     */
    public function statistics()
    {
        $stats = [
            'total' => User::count(),
            'active' => User::where('status', 'active')->count(),
            'pending' => User::where('status', 'pending')->count(),
            'suspended' => User::where('status', 'suspended')->count(),
            'by_role' => [
                'admin' => User::where('role', 'admin')->count(),
                'manager' => User::where('role', 'manager')->count(),
                'staff' => User::where('role', 'staff')->count(),
                'user' => User::where('role', 'user')->count(),
            ],
            'new_this_month' => User::whereMonth('created_at', now()->month)->count(),
            'new_this_week' => User::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
        ];

        return response()->json($stats);
    }
} 