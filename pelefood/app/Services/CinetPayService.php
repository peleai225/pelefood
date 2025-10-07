<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class CinetPayService
{
    protected $apiKey;
    protected $siteId;
    protected $secretKey;
    protected $environment;
    protected $baseUrl;
    protected $paymentUrl;

    public function __construct()
    {
        $this->apiKey = config('cinetpay.api_key');
        $this->siteId = config('cinetpay.site_id');
        $this->secretKey = config('cinetpay.secret_key');
        $this->environment = config('cinetpay.environment');
        
        $urls = config('cinetpay.urls.' . $this->environment);
        $this->baseUrl = $urls['base_url'];
        $this->paymentUrl = $urls['payment_url'];
    }

    /**
     * Initialiser un paiement
     *
     * @param array $paymentData
     * @return array
     */
    public function initializePayment(array $paymentData)
    {
        try {
            $data = [
                'apikey' => $this->apiKey,
                'site_id' => $this->siteId,
                'transaction_id' => $paymentData['transaction_id'],
                'amount' => $paymentData['amount'],
                'currency' => $paymentData['currency'] ?? config('cinetpay.currency'),
                'description' => $paymentData['description'],
                'customer_name' => $paymentData['customer_name'],
                'customer_surname' => $paymentData['customer_surname'],
                'customer_email' => $paymentData['customer_email'],
                'customer_phone_number' => $paymentData['customer_phone_number'],
                'customer_address' => $paymentData['customer_address'] ?? '',
                'customer_city' => $paymentData['customer_city'] ?? '',
                'customer_country' => $paymentData['customer_country'] ?? 'CI',
                'customer_state' => $paymentData['customer_state'] ?? '',
                'customer_zip_code' => $paymentData['customer_zip_code'] ?? '',
                'notify_url' => $paymentData['notify_url'] ?? config('cinetpay.notify_url'),
                'return_url' => $paymentData['return_url'] ?? config('cinetpay.return_url'),
                'cancel_url' => $paymentData['cancel_url'] ?? config('cinetpay.cancel_url'),
                'channels' => $paymentData['channels'] ?? 'ALL',
                'lang' => $paymentData['lang'] ?? config('cinetpay.lang'),
                'metadata' => $paymentData['metadata'] ?? '',
            ];

            if (config('cinetpay.log_requests')) {
                Log::info('CinetPay Payment Request', $data);
            }

            $response = Http::timeout(config('cinetpay.timeout'))
                ->connectTimeout(config('cinetpay.connect_timeout'))
                ->post($this->baseUrl . '/payment', $data);

            $responseData = $response->json();

            if (config('cinetpay.log_responses')) {
                Log::info('CinetPay Payment Response', $responseData);
            }

            if ($response->successful() && isset($responseData['code']) && $responseData['code'] == '201') {
                return [
                    'success' => true,
                    'payment_url' => $responseData['data']['payment_url'],
                    'transaction_id' => $responseData['data']['transaction_id'],
                    'data' => $responseData['data']
                ];
            }

            return [
                'success' => false,
                'message' => $responseData['message'] ?? 'Erreur lors de l\'initialisation du paiement',
                'data' => $responseData
            ];

        } catch (\Exception $e) {
            Log::error('CinetPay Payment Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Erreur technique lors de l\'initialisation du paiement',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Vérifier le statut d'un paiement
     *
     * @param string $transactionId
     * @return array
     */
    public function checkPaymentStatus(string $transactionId)
    {
        try {
            $data = [
                'apikey' => $this->apiKey,
                'site_id' => $this->siteId,
                'transaction_id' => $transactionId,
            ];

            if (config('cinetpay.log_requests')) {
                Log::info('CinetPay Status Check Request', $data);
            }

            $response = Http::timeout(config('cinetpay.timeout'))
                ->connectTimeout(config('cinetpay.connect_timeout'))
                ->post($this->baseUrl . '/payment/check', $data);

            $responseData = $response->json();

            if (config('cinetpay.log_responses')) {
                Log::info('CinetPay Status Check Response', $responseData);
            }

            if ($response->successful() && isset($responseData['code']) && $responseData['code'] == '00') {
                return [
                    'success' => true,
                    'status' => $responseData['data']['status'],
                    'amount' => $responseData['data']['amount'],
                    'currency' => $responseData['data']['currency'],
                    'transaction_id' => $responseData['data']['transaction_id'],
                    'payment_method' => $responseData['data']['payment_method'],
                    'data' => $responseData['data']
                ];
            }

            return [
                'success' => false,
                'message' => $responseData['message'] ?? 'Erreur lors de la vérification du paiement',
                'data' => $responseData
            ];

        } catch (\Exception $e) {
            Log::error('CinetPay Status Check Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Erreur technique lors de la vérification du paiement',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Traiter la notification de paiement
     *
     * @param array $notificationData
     * @return array
     */
    public function processPaymentNotification(array $notificationData)
    {
        try {
            // Vérifier la signature
            $signature = $this->generateSignature($notificationData);
            
            if ($signature !== $notificationData['signature']) {
                return [
                    'success' => false,
                    'message' => 'Signature invalide'
                ];
            }

            return [
                'success' => true,
                'transaction_id' => $notificationData['cpm_trans_id'],
                'amount' => $notificationData['cpm_amount'],
                'currency' => $notificationData['cpm_currency'],
                'status' => $notificationData['cpm_result'],
                'payment_method' => $notificationData['payment_method'],
                'data' => $notificationData
            ];

        } catch (\Exception $e) {
            Log::error('CinetPay Notification Error', [
                'message' => $e->getMessage(),
                'data' => $notificationData
            ]);

            return [
                'success' => false,
                'message' => 'Erreur lors du traitement de la notification',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Générer une signature pour la vérification
     *
     * @param array $data
     * @return string
     */
    public function generateSignature(array $data)
    {
        $signatureData = [
            $data['cpm_site_id'],
            $data['cpm_trans_id'],
            $data['cpm_amount'],
            $data['cpm_currency'],
            $data['cpm_result'],
            $data['cpm_payid'],
            $data['cpm_payment_date'],
            $data['cpm_payment_time'],
            $data['cpm_error_message'],
            $data['cpm_payment_method'],
            $data['cpm_phone_prefixe'],
            $data['cpm_phone_number'],
            $data['cpm_ipn_ack'],
            $data['cpm_user_agent'],
            $data['cpm_language'],
            $this->secretKey
        ];

        return hash('sha256', implode('', $signatureData));
    }

    /**
     * Obtenir les méthodes de paiement disponibles
     *
     * @return array
     */
    public function getAvailablePaymentMethods()
    {
        return config('cinetpay.payment_methods');
    }

    /**
     * Générer un ID de transaction unique
     *
     * @return string
     */
    public function generateTransactionId()
    {
        return 'PF_' . time() . '_' . rand(1000, 9999);
    }

    /**
     * Valider les données de paiement
     *
     * @param array $data
     * @return array
     */
    public function validatePaymentData(array $data)
    {
        $required = [
            'amount',
            'description',
            'customer_name',
            'customer_surname',
            'customer_email',
            'customer_phone_number'
        ];

        $errors = [];

        foreach ($required as $field) {
            if (empty($data[$field])) {
                $errors[] = "Le champ {$field} est requis";
            }
        }

        // Validation de l'email
        if (!empty($data['customer_email']) && !filter_var($data['customer_email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse email n'est pas valide";
        }

        // Validation du montant
        if (!empty($data['amount']) && (!is_numeric($data['amount']) || $data['amount'] <= 0)) {
            $errors[] = "Le montant doit être un nombre positif";
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
}
