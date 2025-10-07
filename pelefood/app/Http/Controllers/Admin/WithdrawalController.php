<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WithdrawalRequest;
use App\Models\Restaurant;
use App\Services\WalletService;
use Carbon\Carbon;

class WithdrawalController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * Afficher la liste des demandes de retrait
     */
    public function index(Request $request)
    {
        $query = WithdrawalRequest::with(['restaurant', 'processedBy']);

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('restaurant_id')) {
            $query->where('restaurant_id', $request->restaurant_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $withdrawalRequests = $query->latest()->paginate(20);

        // Statistiques
        $stats = [
            'total_requests' => WithdrawalRequest::count(),
            'pending_requests' => WithdrawalRequest::pending()->count(),
            'approved_requests' => WithdrawalRequest::approved()->count(),
            'processed_requests' => WithdrawalRequest::processed()->count(),
            'rejected_requests' => WithdrawalRequest::rejected()->count(),
            'total_amount' => WithdrawalRequest::where('status', '!=', 'rejected')->sum('amount'),
            'pending_amount' => WithdrawalRequest::pending()->sum('amount'),
        ];

        // Restaurants pour le filtre
        $restaurants = Restaurant::with('user')->get();

        return view('admin.withdrawals.index', compact('withdrawalRequests', 'stats', 'restaurants'));
    }

    /**
     * Afficher les détails d'une demande de retrait
     */
    public function show(WithdrawalRequest $withdrawalRequest)
    {
        $withdrawalRequest->load(['restaurant.user', 'processedBy']);

        return view('admin.withdrawals.show', compact('withdrawalRequest'));
    }

    /**
     * Approuver une demande de retrait
     */
    public function approve(Request $request, WithdrawalRequest $withdrawalRequest)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $result = $this->walletService->approveWithdrawal(
            $withdrawalRequest, 
            Auth::id(), 
            $request->admin_notes
        );

        if ($result['success']) {
            return redirect()->route('admin.withdrawals.index')
                ->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    /**
     * Rejeter une demande de retrait
     */
    public function reject(Request $request, WithdrawalRequest $withdrawalRequest)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $result = $this->walletService->rejectWithdrawal(
            $withdrawalRequest, 
            Auth::id(), 
            $request->rejection_reason,
            $request->admin_notes
        );

        if ($result['success']) {
            return redirect()->route('admin.withdrawals.index')
                ->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    /**
     * Traiter une demande de retrait (après transfert effectif)
     */
    public function process(Request $request, WithdrawalRequest $withdrawalRequest)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $result = $this->walletService->processWithdrawal(
            $withdrawalRequest, 
            Auth::id(), 
            $request->admin_notes
        );

        if ($result['success']) {
            return redirect()->route('admin.withdrawals.index')
                ->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    /**
     * Afficher les statistiques globales
     */
    public function stats()
    {
        // Statistiques globales
        $globalStats = [
            'total_wallets' => \App\Models\RestaurantWallet::where('is_active', true)->count(),
            'total_balance' => \App\Models\RestaurantWallet::where('is_active', true)->sum('balance'),
            'total_earnings' => \App\Models\RestaurantWallet::where('is_active', true)->sum('total_earnings'),
            'total_withdrawals' => \App\Models\RestaurantWallet::where('is_active', true)->sum('total_withdrawals'),
            'total_commission' => \App\Models\RestaurantWallet::where('is_active', true)->sum('total_commission'),
            'pending_requests' => WithdrawalRequest::where('status', 'pending')->count(),
            'approved_requests' => WithdrawalRequest::where('status', 'approved')->count(),
            'processed_requests' => WithdrawalRequest::where('status', 'processed')->count(),
            'rejected_requests' => WithdrawalRequest::where('status', 'rejected')->count(),
            'pending_amount' => WithdrawalRequest::where('status', 'pending')->sum('amount'),
            'formatted_total_balance' => number_format(\App\Models\RestaurantWallet::where('is_active', true)->sum('balance'), 0, ',', ' ') . ' FCFA',
            'formatted_total_commission' => number_format(\App\Models\RestaurantWallet::where('is_active', true)->sum('total_commission'), 0, ',', ' ') . ' FCFA',
        ];

        // Statistiques par période
        $monthlyStats = [
            'current_month' => $this->getMonthlyStats(now()),
            'last_month' => $this->getMonthlyStats(now()->subMonth()),
        ];

        // Top restaurants par retraits
        $topRestaurants = WithdrawalRequest::with('restaurant')
            ->where('status', 'processed')
            ->selectRaw('restaurant_id, SUM(amount) as total_withdrawn, COUNT(*) as withdrawal_count')
            ->groupBy('restaurant_id')
            ->orderBy('total_withdrawn', 'desc')
            ->limit(10)
            ->get();

        return view('admin.withdrawals.stats', compact('globalStats', 'monthlyStats', 'topRestaurants'));
    }

    /**
     * Exporter les données de retrait
     */
    public function export(Request $request)
    {
        try {
            $query = WithdrawalRequest::with(['restaurant', 'processedBy']);

            // Appliquer les mêmes filtres que l'index
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('restaurant_id')) {
                $query->where('restaurant_id', $request->restaurant_id);
            }

            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            $withdrawalRequests = $query->latest()->get();

            $filename = 'demandes_retrait_' . date('Y-m-d') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function() use ($withdrawalRequests) {
                $file = fopen('php://output', 'w');
                
                // Ajouter BOM pour UTF-8
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
                
                fputcsv($file, [
                    'N° Demande',
                    'Restaurant',
                    'Montant',
                    'Frais',
                    'Montant Net',
                    'Statut',
                    'Date Demande',
                    'Date Traitement',
                    'Traité par'
                ]);

                foreach ($withdrawalRequests as $request) {
                    fputcsv($file, [
                        $request->request_number ?? 'N/A',
                        $request->restaurant->name ?? 'Restaurant supprimé',
                        number_format($request->amount, 0, ',', ' ') . ' FCFA',
                        number_format($request->fees ?? 500, 0, ',', ' ') . ' FCFA',
                        number_format($request->net_amount ?? ($request->amount - 500), 0, ',', ' ') . ' FCFA',
                        $request->status_label ?? 'Inconnu',
                        $request->created_at->format('d/m/Y H:i'),
                        $request->processed_at ? $request->processed_at->format('d/m/Y H:i') : 'N/A',
                        $request->processedBy ? $request->processedBy->name : 'N/A'
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'export: ' . $e->getMessage());
        }
    }

    /**
     * Obtenir les statistiques mensuelles
     */
    private function getMonthlyStats(Carbon $date)
    {
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        return [
            'total_requests' => WithdrawalRequest::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            'total_amount' => WithdrawalRequest::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->where('status', '!=', 'rejected')
                ->sum('amount'),
            'processed_amount' => WithdrawalRequest::whereBetween('processed_at', [$startOfMonth, $endOfMonth])
                ->where('status', 'processed')
                ->sum('amount'),
        ];
    }
}