<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::with('restaurant')->latest()->paginate(15);
        $restaurants = Restaurant::all();
        return view('admin.promotions.index', compact('promotions', 'restaurants'));
    }

    public function create()
    {
        $restaurants = Restaurant::all();
        return view('admin.promotions.create', compact('restaurants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'restaurant_id' => 'required|exists:restaurants,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'promo_code' => 'nullable|string|unique:promotions',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:0',
            'max_uses_per_user' => 'nullable|integer|min:1',
            'discount_type' => 'nullable|in:percentage,fixed',
            'is_first_time_only' => 'boolean',
            'is_public' => 'boolean',
        ]);

        $promotion = Promotion::create($validated);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promotion créée avec succès.');
    }

    public function show(Promotion $promotion)
    {
        return view('admin.promotions.show', compact('promotion'));
    }

    public function edit(Promotion $promotion)
    {
        $restaurants = Restaurant::all();
        return view('admin.promotions.edit', compact('promotion', 'restaurants'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'restaurant_id' => 'required|exists:restaurants,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'promo_code' => 'nullable|string|unique:promotions,promo_code,' . $promotion->id,
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:0',
            'max_uses_per_user' => 'nullable|integer|min:1',
            'discount_type' => 'nullable|in:percentage,fixed',
            'is_first_time_only' => 'boolean',
            'is_public' => 'boolean',
        ]);

        $promotion->update($validated);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promotion mise à jour avec succès.');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promotion supprimée avec succès.');
    }

    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');
        $promotions = Promotion::with('restaurant')->get();

        if ($format === 'csv') {
            return $this->exportToCSV($promotions);
        }

        return $this->exportToExcel($promotions);
    }

    private function exportToCSV($promotions)
    {
        $filename = 'promotions_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($promotions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Nom', 'Description', 'Restaurant', 'Réduction (%)', 'Date début', 'Date fin', 'Statut']);

            foreach ($promotions as $promotion) {
                fputcsv($file, [
                    $promotion->id,
                    $promotion->name,
                    $promotion->description,
                    $promotion->restaurant->name ?? 'N/A',
                    $promotion->discount_percentage,
                    $promotion->start_date->format('d/m/Y'),
                    $promotion->end_date->format('d/m/Y'),
                    $promotion->is_active ? 'Active' : 'Inactive'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportToExcel($promotions)
    {
        // Implémentation Excel si nécessaire
        return redirect()->back()->with('info', 'Export Excel non encore implémenté');
    }
} 