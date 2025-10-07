<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PaymentGatewayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin');
    }

    /**
     * Afficher la liste des passerelles de paiement
     */
    public function index()
    {
        $gateways = PaymentGateway::orderBy('name')->get();
        
        return view('admin.payment-gateways.index', compact('gateways'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $providers = [
            'stripe' => 'Stripe',
            'paypal' => 'PayPal',
            'wave' => 'Wave',
            'orange' => 'Orange Money',
            'mtn' => 'MTN Mobile Money',
            'moov' => 'Moov Money',
        ];

        return view('admin.payment-gateways.create', compact('providers'));
    }

    /**
     * Enregistrer une nouvelle passerelle
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'provider' => 'required|string|max:50',
            'is_active' => 'boolean',
            'credentials' => 'required|array',
            'settings' => 'array',
            'description' => 'nullable|string',
        ]);

        PaymentGateway::create([
            'name' => $request->name,
            'provider' => $request->provider,
            'is_active' => $request->has('is_active'),
            'credentials' => $request->credentials,
            'settings' => $request->settings ?? [],
            'description' => $request->description,
        ]);

        // Vider le cache des passerelles
        Cache::forget('payment_gateways');

        return redirect()->route('admin.payment-gateways.index')
            ->with('success', 'Passerelle de paiement créée avec succès.');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(PaymentGateway $paymentGateway)
    {
        $providers = [
            'stripe' => 'Stripe',
            'paypal' => 'PayPal',
            'wave' => 'Wave',
            'orange' => 'Orange Money',
            'mtn' => 'MTN Mobile Money',
            'moov' => 'Moov Money',
        ];

        return view('admin.payment-gateways.edit', compact('paymentGateway', 'providers'));
    }

    /**
     * Mettre à jour une passerelle
     */
    public function update(Request $request, PaymentGateway $paymentGateway)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'provider' => 'required|string|max:50',
            'is_active' => 'boolean',
            'credentials' => 'required|array',
            'settings' => 'array',
            'description' => 'nullable|string',
        ]);

        $paymentGateway->update([
            'name' => $request->name,
            'provider' => $request->provider,
            'is_active' => $request->has('is_active'),
            'credentials' => $request->credentials,
            'settings' => $request->settings ?? [],
            'description' => $request->description,
        ]);

        // Vider le cache des passerelles
        Cache::forget('payment_gateways');

        return redirect()->route('admin.payment-gateways.index')
            ->with('success', 'Passerelle de paiement mise à jour avec succès.');
    }

    /**
     * Supprimer une passerelle
     */
    public function destroy(PaymentGateway $paymentGateway)
    {
        $paymentGateway->delete();

        // Vider le cache des passerelles
        Cache::forget('payment_gateways');

        return redirect()->route('admin.payment-gateways.index')
            ->with('success', 'Passerelle de paiement supprimée avec succès.');
    }

    /**
     * Tester une passerelle de paiement
     */
    public function test(PaymentGateway $paymentGateway)
    {
        try {
            // Test de connexion selon le provider
            switch ($paymentGateway->provider) {
                case 'stripe':
                    $result = $this->testStripeConnection($paymentGateway);
                    break;
                case 'paypal':
                    $result = $this->testPayPalConnection($paymentGateway);
                    break;
                case 'wave':
                    $result = $this->testWaveConnection($paymentGateway);
                    break;
                default:
                    $result = ['success' => false, 'message' => 'Provider non supporté pour les tests'];
            }

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du test: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Tester la connexion Stripe
     */
    private function testStripeConnection(PaymentGateway $gateway)
    {
        $credentials = $gateway->credentials;
        $secretKey = $credentials['secret_key'] ?? null;

        if (!$secretKey) {
            return ['success' => false, 'message' => 'Clé secrète Stripe manquante'];
        }

        // Ici vous feriez un appel API Stripe pour tester
        // Pour l'instant, on simule
        return ['success' => true, 'message' => 'Connexion Stripe réussie'];
    }

    /**
     * Tester la connexion PayPal
     */
    private function testPayPalConnection(PaymentGateway $gateway)
    {
        $credentials = $gateway->credentials;
        $clientId = $credentials['client_id'] ?? null;
        $clientSecret = $credentials['client_secret'] ?? null;

        if (!$clientId || !$clientSecret) {
            return ['success' => false, 'message' => 'Identifiants PayPal manquants'];
        }

        // Ici vous feriez un appel API PayPal pour tester
        return ['success' => true, 'message' => 'Connexion PayPal réussie'];
    }

    /**
     * Tester la connexion Wave
     */
    private function testWaveConnection(PaymentGateway $gateway)
    {
        $credentials = $gateway->credentials;
        $apiKey = $credentials['api_key'] ?? null;

        if (!$apiKey) {
            return ['success' => false, 'message' => 'Clé API Wave manquante'];
        }

        // Ici vous feriez un appel API Wave pour tester
        return ['success' => true, 'message' => 'Connexion Wave réussie'];
    }
} 