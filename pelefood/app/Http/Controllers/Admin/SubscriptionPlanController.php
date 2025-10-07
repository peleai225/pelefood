<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $subscriptionPlans = SubscriptionPlan::latest()->paginate(15);
        return view('admin.subscription-plans.index', compact('subscriptionPlans'));
    }

    public function create()
    {
        return view('admin.subscription-plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'is_active' => 'boolean',
            'max_restaurants' => 'nullable|integer|min:0',
            'max_products' => 'nullable|integer|min:0',
            'max_users' => 'nullable|integer|min:0',
            'features' => 'nullable|array',
            'duration_days' => 'nullable|integer|min:1',
        ]);

        $subscriptionPlan = SubscriptionPlan::create($validated);

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Plan d\'abonnement créé avec succès.');
    }

    public function show(SubscriptionPlan $subscriptionPlan)
    {
        return view('admin.subscription-plans.show', compact('subscriptionPlan'));
    }

    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        return view('admin.subscription-plans.edit', compact('subscriptionPlan'));
    }

    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'is_active' => 'boolean',
            'max_restaurants' => 'nullable|integer|min:0',
            'max_products' => 'nullable|integer|min:0',
            'max_users' => 'nullable|integer|min:0',
            'features' => 'nullable|array',
            'duration_days' => 'nullable|integer|min:1',
        ]);

        $subscriptionPlan->update($validated);

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Plan d\'abonnement mis à jour avec succès.');
    }

    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->delete();

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Plan d\'abonnement supprimé avec succès.');
    }

    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');
        $subscriptionPlans = SubscriptionPlan::all();

        if ($format === 'csv') {
            return $this->exportToCSV($subscriptionPlans);
        }

        return $this->exportToExcel($subscriptionPlans);
    }

    private function exportToCSV($subscriptionPlans)
    {
        $filename = 'subscription_plans_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($subscriptionPlans) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Nom', 'Description', 'Prix', 'Cycle de facturation', 'Type', 'Statut']);

            foreach ($subscriptionPlans as $plan) {
                fputcsv($file, [
                    $plan->id,
                    $plan->name,
                    $plan->description,
                    $plan->price,
                    $plan->billing_cycle,
                    $plan->type,
                    $plan->is_active ? 'Actif' : 'Inactif'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportToExcel($subscriptionPlans)
    {
        // Implémentation Excel si nécessaire
        return redirect()->back()->with('info', 'Export Excel non encore implémenté');
    }
} 