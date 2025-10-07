<?php

namespace App\Http\Controllers\Restaurant;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\WithdrawalRequest;
use App\Services\WalletService;
use Carbon\Carbon;

class WalletController extends BaseRestaurantController
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * Afficher le portefeuille du restaurant
     */
    public function index(Request $request)
    {
        $restaurant = $this->ensureRestaurant($request);

        // Obtenir les statistiques du portefeuille
        $stats = $this->walletService->getWalletStats($restaurant->id);
        
        // Obtenir les demandes de retrait récentes
        $withdrawalRequests = WithdrawalRequest::where('restaurant_id', $restaurant->id)
            ->latest()
            ->paginate(10);

        // Obtenir l'historique des transactions (simulé pour l'instant)
        $transactions = collect([
            [
                'id' => 1,
                'type' => 'credit',
                'description' => 'Paiement commande #12345',
                'amount' => 15000,
                'date' => now()->subHours(2),
                'status' => 'completed'
            ],
            [
                'id' => 2,
                'type' => 'debit',
                'description' => 'Retrait #WR-20250916-ABC123',
                'amount' => -5000,
                'date' => now()->subDays(1),
                'status' => 'completed'
            ],
            [
                'id' => 3,
                'type' => 'credit',
                'description' => 'Paiement commande #12344',
                'amount' => 8500,
                'date' => now()->subDays(2),
                'status' => 'completed'
            ],
        ]);

        return view('restaurant.wallet.index', compact('stats', 'withdrawalRequests', 'transactions', 'restaurant'));
    }

    /**
     * Afficher le formulaire de demande de retrait
     */
    public function createWithdrawal(Request $request)
    {
        $restaurant = $this->ensureRestaurant($request);

        $stats = $this->walletService->getWalletStats($restaurant->id);

        return view('restaurant.wallet.create-withdrawal', compact('stats', 'restaurant'));
    }

    /**
     * Traiter la demande de retrait
     */
    public function storeWithdrawal(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_holder_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $restaurant = $this->ensureRestaurant($request);

        $amount = $request->amount;
        $bankDetails = [
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder_name' => $request->account_holder_name,
            'phone' => $request->phone,
        ];

        $result = $this->walletService->createWithdrawalRequest($restaurant->id, $amount, $bankDetails);

        if ($result['success']) {
            return redirect()->route('restaurant.wallet.index')
                ->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message'])->withInput();
        }
    }

    /**
     * Afficher les détails d'une demande de retrait
     */
    public function showWithdrawal(Request $request, WithdrawalRequest $withdrawalRequest)
    {
        $restaurant = $this->ensureRestaurant($request);
        
        if ($withdrawalRequest->restaurant_id !== $restaurant->id) {
            abort(403, 'Accès non autorisé');
        }

        return view('restaurant.wallet.show-withdrawal', compact('withdrawalRequest', 'restaurant'));
    }

    /**
     * Annuler une demande de retrait
     */
    public function cancelWithdrawal(Request $request, WithdrawalRequest $withdrawalRequest)
    {
        $restaurant = $this->ensureRestaurant($request);
        
        if ($withdrawalRequest->restaurant_id !== $restaurant->id) {
            abort(403, 'Accès non autorisé');
        }

        if (!$withdrawalRequest->can_be_cancelled) {
            return back()->with('error', 'Cette demande ne peut pas être annulée');
        }

        $withdrawalRequest->cancel();

        return redirect()->route('restaurant.wallet.index')
            ->with('success', 'Demande de retrait annulée avec succès');
    }

    /**
     * Obtenir les statistiques du portefeuille (API)
     */
    public function getStats(Request $request)
    {
        $restaurant = $this->ensureRestaurant($request);

        $stats = $this->walletService->getWalletStats($restaurant->id);

        return response()->json($stats);
    }

    /**
     * Calculer les frais de retrait (API)
     */
    public function calculateWithdrawalFees(Request $request)
    {
        $amount = $request->input('amount', 0);
        
        if ($amount < 1000) {
            return response()->json([
                'error' => 'Le montant minimum est de 1,000 FCFA'
            ], 400);
        }

        $fees = 500; // Frais fixes
        $netAmount = $amount - $fees;

        return response()->json([
            'amount' => $amount,
            'fees' => $fees,
            'net_amount' => $netAmount,
            'formatted_amount' => number_format($amount, 0, ',', ' ') . ' FCFA',
            'formatted_fees' => number_format($fees, 0, ',', ' ') . ' FCFA',
            'formatted_net_amount' => number_format($netAmount, 0, ',', ' ') . ' FCFA',
        ]);
    }
}