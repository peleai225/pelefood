<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    /**
     * Gérer les webhooks Wave
     */
    public function waveWebhook(Request $request)
    {
        try {
            Log::info('Webhook Wave reçu', $request->all());
            
            // Vérifier la signature du webhook (à implémenter selon la documentation Wave)
            // $this->verifyWaveSignature($request);
            
            $data = $request->all();
            
            // Extraire les informations importantes
            $paymentLinkId = $data['payment_link_id'] ?? null;
            $status = $data['status'] ?? null;
            $externalReference = $data['external_reference'] ?? null;
            $amount = $data['amount'] ?? null;
            
            if (!$paymentLinkId || !$status || !$externalReference) {
                Log::error('Webhook Wave: données manquantes', $data);
                return response()->json(['error' => 'Données manquantes'], 400);
            }
            
            // Trouver la transaction correspondante
            $transaction = PaymentTransaction::where('transaction_id', $externalReference)
                ->where('external_id', $paymentLinkId)
                ->first();
            
            if (!$transaction) {
                Log::error('Webhook Wave: transaction non trouvée', [
                    'external_reference' => $externalReference,
                    'payment_link_id' => $paymentLinkId
                ]);
                return response()->json(['error' => 'Transaction non trouvée'], 404);
            }
            
            // Mettre à jour le statut de la transaction selon le statut Wave
            switch ($status) {
                case 'completed':
                case 'success':
                    $transaction->markAsCompleted();
                    $transaction->order->update(['payment_status' => 'paid']);
                    Log::info('Paiement Wave complété', ['transaction_id' => $transaction->transaction_id]);
                    break;
                    
                case 'failed':
                case 'cancelled':
                    $transaction->markAsFailed('Paiement annulé ou échoué');
                    $transaction->order->update(['payment_status' => 'failed']);
                    Log::info('Paiement Wave échoué', ['transaction_id' => $transaction->transaction_id]);
                    break;
                    
                case 'pending':
                    $transaction->markAsPending();
                    Log::info('Paiement Wave en attente', ['transaction_id' => $transaction->transaction_id]);
                    break;
                    
                default:
                    Log::warning('Webhook Wave: statut inconnu', [
                        'status' => $status,
                        'transaction_id' => $transaction->transaction_id
                    ]);
            }
            
            // Mettre à jour les détails du paiement
            $transaction->update([
                'payment_details' => array_merge($transaction->payment_details ?? [], [
                    'wave_webhook_data' => $data,
                    'last_webhook_received' => now(),
                ])
            ]);
            
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            Log::error('Erreur webhook Wave', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);
            
            return response()->json(['error' => 'Erreur interne'], 500);
        }
    }
    
    /**
     * Vérifier la signature du webhook Wave (à implémenter)
     */
    private function verifyWaveSignature(Request $request)
    {
        // Implémenter la vérification de signature selon la documentation Wave
        // Cette méthode doit vérifier que le webhook provient bien de Wave
        
        $signature = $request->header('X-Wave-Signature');
        $payload = $request->getContent();
        
        // Exemple de vérification (à adapter selon la documentation Wave)
        // $expectedSignature = hash_hmac('sha256', $payload, config('services.wave.webhook_secret'));
        // 
        // if (!hash_equals($expectedSignature, $signature)) {
        //     throw new \Exception('Signature invalide');
        // }
    }
} 