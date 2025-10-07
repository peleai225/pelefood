<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentTransaction;
use App\Models\Tenant;
use App\Models\User;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer les statistiques des paiements
        $successfulPayments = PaymentTransaction::where('status', 'successful')->count();
        $failedPayments = PaymentTransaction::where('status', 'failed')->count();
        $pendingPayments = PaymentTransaction::where('status', 'pending')->count();
        $totalRevenue = PaymentTransaction::where('status', 'successful')->sum('amount');

        // Récupérer les paiements avec pagination
        $payments = PaymentTransaction::with(['user', 'tenant'])
            ->latest()
            ->paginate(15);

        return view('admin.payments.index', compact(
            'payments',
            'successfulPayments',
            'failedPayments',
            'pendingPayments',
            'totalRevenue'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tenants = Tenant::all();
        $users = User::all();
        
        return view('admin.payments.create', compact('tenants', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tenant_id' => 'required|exists:tenants,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'status' => 'required|in:successful,failed,pending,refunded',
            'transaction_id' => 'nullable|string|unique:payment_transactions',
            'description' => 'nullable|string',
        ]);

        // Générer un ID de transaction si non fourni
        if (empty($validated['transaction_id'])) {
            $validated['transaction_id'] = 'TXN_' . uniqid();
        }

        $payment = PaymentTransaction::create($validated);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Paiement créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentTransaction $payment)
    {
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentTransaction $payment)
    {
        $tenants = Tenant::all();
        $users = User::all();
        
        return view('admin.payments.edit', compact('payment', 'tenants', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentTransaction $payment)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tenant_id' => 'required|exists:tenants,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'status' => 'required|in:successful,failed,pending,refunded',
            'transaction_id' => 'nullable|string|unique:payment_transactions,transaction_id,' . $payment->id,
            'description' => 'nullable|string',
        ]);

        $payment->update($validated);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Paiement mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentTransaction $payment)
    {
        $payment->delete();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Paiement supprimé avec succès.');
    }

    /**
     * Refund a payment.
     */
    public function refund(PaymentTransaction $payment)
    {
        if ($payment->status !== 'successful') {
            return back()->with('error', 'Seuls les paiements réussis peuvent être remboursés.');
        }

        $payment->update(['status' => 'refunded']);

        return back()->with('success', 'Paiement remboursé avec succès.');
    }

    /**
     * Export payments data.
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');
        
        $payments = PaymentTransaction::with(['user', 'tenant'])
            ->when($request->filled('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->filled('payment_method'), function ($query, $method) {
                return $query->where('payment_method', $method);
            })
            ->when($request->filled('date_from'), function ($query, $date) {
                return $query->whereDate('created_at', '>=', $date);
            })
            ->when($request->filled('date_to'), function ($query, $date) {
                return $query->whereDate('created_at', '<=', $date);
            })
            ->get();

        if ($format === 'csv') {
            return $this->exportToCsv($payments);
        }

        return back()->with('error', 'Format d\'export non supporté.');
    }

    /**
     * Export to CSV.
     */
    private function exportToCsv($payments)
    {
        $filename = 'paiements_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID', 'Transaction ID', 'Utilisateur', 'Tenant', 'Montant', 
                'Méthode', 'Statut', 'Date', 'Description'
            ]);

            // Données
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->id,
                    $payment->transaction_id,
                    $payment->user->name ?? 'N/A',
                    $payment->tenant->name ?? 'N/A',
                    $payment->amount . ' FCFA',
                    $payment->payment_method,
                    $payment->status,
                    $payment->created_at->format('d/m/Y H:i'),
                    $payment->description ?? ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 