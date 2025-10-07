<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::with(['owner', 'subscriptionPlan'])
            ->latest()
            ->paginate(15);

        return view('admin.tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subscriptionPlans = \App\Models\SubscriptionPlan::all();
        return view('admin.tenants.create', compact('subscriptionPlans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:tenants',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|unique:users,email',
            'owner_phone' => 'nullable|string|max:20',
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'status' => 'required|in:active,inactive,suspended',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);

        // Créer le tenant
        $tenant = Tenant::create([
            'name' => $validated['name'],
            'domain' => $validated['domain'],
            'subscription_plan_id' => $validated['subscription_plan_id'],
            'status' => $validated['status'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'country' => $validated['country'],
        ]);

        // Créer l'utilisateur propriétaire
        $owner = User::create([
            'name' => $validated['owner_name'],
            'email' => $validated['owner_email'],
            'phone' => $validated['owner_phone'],
            'password' => Hash::make('password123'), // Mot de passe temporaire
            'tenant_id' => $tenant->id,
        ]);

        // Assigner le rôle admin au propriétaire
        $owner->assignRole('admin');

        // Mettre à jour le tenant avec l'ID du propriétaire
        $tenant->update(['owner_id' => $owner->id]);

        return redirect()->route('admin.tenants.index')
            ->with('success', 'Tenant créé avec succès. Le propriétaire peut se connecter avec email: ' . $validated['owner_email'] . ' et mot de passe: password123');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        $tenant->load(['owner', 'subscriptionPlan', 'restaurants', 'users']);
        
        return view('admin.tenants.show', compact('tenant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        return view('admin.tenants.edit', compact('tenant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => ['required', 'string', 'max:255', Rule::unique('tenants')->ignore($tenant->id)],
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'status' => 'required|in:active,inactive,suspended',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);

        $tenant->update($validated);

        return redirect()->route('admin.tenants.index')
            ->with('success', 'Tenant mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        // Vérifier s'il y a des restaurants associés
        if ($tenant->restaurants()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer ce tenant car il a des restaurants associés');
        }

        // Supprimer tous les utilisateurs du tenant
        $tenant->users()->delete();

        // Supprimer le tenant
        $tenant->delete();

        return redirect()->route('admin.tenants.index')
            ->with('success', 'Tenant supprimé avec succès');
    }

    /**
     * Suspendre un tenant
     */
    public function suspend(Tenant $tenant)
    {
        $tenant->update(['status' => 'suspended']);
        
        return back()->with('success', 'Tenant suspendu avec succès');
    }

    /**
     * Réactiver un tenant
     */
    public function activate(Tenant $tenant)
    {
        $tenant->update(['status' => 'active']);
        
        return back()->with('success', 'Tenant réactivé avec succès');
    }
}
