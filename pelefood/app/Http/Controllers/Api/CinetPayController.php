<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CinetPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CinetPayController extends Controller
{
    protected $cinetPayService;

    public function __construct(CinetPayService $cinetPayService)
    {
        $this->cinetPayService = $cinetPayService;
    }

    /**
     * Initialiser un paiement
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function initializePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:100',
            'description' => 'required|string|max:255',
            'customer_name' => 'required|string|max:100',
            'customer_surname' => 'required|string|max:100',
            'customer_email' => 'required|email|max:100',
            'customer_phone_number' => 'required|string|max:20',
            'customer_address' => 'nullable|string|max:255',
            'customer_city' => 'nullable|string|max:100',
            'customer_country' => 'nullable|string|max:2',
            'channels' => 'nullable|string|in:ALL,MOBILE_MONEY,CARD,BANK_TRANSFER',
            'metadata' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['transaction_id'] = $this->cinetPayService->generateTransactionId();

        $result = $this->cinetPayService->initializePayment($data);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Paiement initialisé avec succès',
                'data' => [
                    'payment_url' => $result['payment_url'],
                    'transaction_id' => $result['transaction_id']
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
            'data' => $result['data'] ?? null
        ], 400);
    }

    /**
     * Vérifier le statut d'un paiement
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkPaymentStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'ID de transaction requis',
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->cinetPayService->checkPaymentStatus($request->transaction_id);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Statut du paiement récupéré',
                'data' => [
                    'status' => $result['status'],
                    'amount' => $result['amount'],
                    'currency' => $result['currency'],
                    'transaction_id' => $result['transaction_id'],
                    'payment_method' => $result['payment_method']
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
            'data' => $result['data'] ?? null
        ], 400);
    }

    /**
     * Traiter la notification de paiement (Webhook)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handlePaymentNotification(Request $request)
    {
        try {
            Log::info('CinetPay Notification Received', $request->all());

            $result = $this->cinetPayService->processPaymentNotification($request->all());

            if ($result['success']) {
                // Ici, vous pouvez traiter le paiement réussi
                // Par exemple, mettre à jour le statut de la commande, envoyer un email, etc.
                
                Log::info('Payment Successful', [
                    'transaction_id' => $result['transaction_id'],
                    'amount' => $result['amount'],
                    'status' => $result['status']
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Notification traitée avec succès'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);

        } catch (\Exception $e) {
            Log::error('CinetPay Notification Error', [
                'message' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du traitement de la notification'
            ], 500);
        }
    }

    /**
     * Page de retour après paiement
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function paymentReturn(Request $request)
    {
        $transactionId = $request->get('transaction_id');
        
        if ($transactionId) {
            $result = $this->cinetPayService->checkPaymentStatus($transactionId);
            
            if ($result['success']) {
                return view('payments.success', [
                    'transaction_id' => $result['transaction_id'],
                    'amount' => $result['amount'],
                    'currency' => $result['currency'],
                    'status' => $result['status']
                ]);
            }
        }

        return view('payments.error', [
            'message' => 'Erreur lors de la vérification du paiement'
        ]);
    }

    /**
     * Page d'annulation de paiement
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function paymentCancel(Request $request)
    {
        return view('payments.cancel', [
            'message' => 'Paiement annulé par l\'utilisateur'
        ]);
    }

    /**
     * Obtenir les méthodes de paiement disponibles
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPaymentMethods()
    {
        $methods = $this->cinetPayService->getAvailablePaymentMethods();

        return response()->json([
            'success' => true,
            'data' => $methods
        ]);
    }
}
