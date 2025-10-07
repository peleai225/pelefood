<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'restaurant'])->latest()->paginate(15);
        $restaurants = Restaurant::all();
        return view('admin.reviews.index', compact('reviews', 'restaurants'));
    }

    public function show(Review $review)
    {
        $review->load(['user', 'restaurant']);
        return view('admin.reviews.show', compact('review'));
    }

    public function edit(Review $review)
    {
        $restaurants = Restaurant::all();
        return view('admin.reviews.edit', compact('review', 'restaurants'));
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'is_approved' => 'boolean',
            'is_rejected' => 'boolean',
        ]);

        $review->update($validated);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Avis mis à jour avec succès.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Avis supprimé avec succès.');
    }

    public function approve(Review $review)
    {
        $review->update([
            'is_approved' => true,
            'is_rejected' => false,
        ]);

        return back()->with('success', 'Avis approuvé avec succès.');
    }

    public function reject(Review $review)
    {
        $review->update([
            'is_approved' => false,
            'is_rejected' => true,
        ]);

        return back()->with('success', 'Avis rejeté avec succès.');
    }

    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');
        $reviews = Review::with(['user', 'restaurant'])->get();

        if ($format === 'csv') {
            return $this->exportToCSV($reviews);
        }

        return $this->exportToExcel($reviews);
    }

    private function exportToCSV($reviews)
    {
        $filename = 'reviews_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($reviews) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Client', 'Email', 'Restaurant', 'Note', 'Commentaire', 'Date', 'Statut']);

            foreach ($reviews as $review) {
                fputcsv($file, [
                    $review->id,
                    $review->user->name ?? 'N/A',
                    $review->user->email ?? 'N/A',
                    $review->restaurant->name ?? 'N/A',
                    $review->rating,
                    $review->comment,
                    $review->created_at->format('d/m/Y H:i'),
                    $review->is_approved ? 'Approuvé' : ($review->is_rejected ? 'Rejeté' : 'En attente')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportToExcel($reviews)
    {
        // Implémentation Excel si nécessaire
        return redirect()->back()->with('info', 'Export Excel non encore implémenté');
    }
} 