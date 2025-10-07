<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\PaymentTransaction;

class FirebaseService
{
    protected $apiKey;
    protected $projectId;
    protected $databaseUrl;
    protected $messagingSenderId;

    public function __construct()
    {
        $this->apiKey = config('firebase.api_key');
        $this->projectId = config('firebase.project_id');
        $this->databaseUrl = config('firebase.database_url');
        $this->messagingSenderId = config('firebase.messaging_sender_id');
    }

    /**
     * Envoyer une notification push
     */
    public function sendNotification($topic, $title, $body, $data = [])
    {
        try {
            $payload = [
                'to' => "/topics/{$topic}",
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                    'sound' => 'default',
                    'badge' => 1,
                ],
                'data' => $data,
                'priority' => 'high',
            ];

            $response = Http::withHeaders([
                'Authorization' => 'key=' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/fcm/send', $payload);

            if ($response->successful()) {
                Log::info('Firebase notification sent successfully', [
                    'topic' => $topic,
                    'title' => $title,
                    'response' => $response->json()
                ]);
                return true;
            }

            Log::error('Firebase notification failed', [
                'topic' => $topic,
                'response' => $response->json()
            ]);
            return false;
        } catch (\Exception $e) {
            Log::error('Firebase notification error', [
                'error' => $e->getMessage(),
                'topic' => $topic
            ]);
            return false;
        }
    }

    /**
     * Notifier une nouvelle commande
     */
    public function notifyNewOrder(Order $order)
    {
        $restaurant = $order->restaurant;
        $title = "Nouvelle commande #{$order->order_number}";
        $body = "Commande de {$order->total_amount} XOF pour {$restaurant->name}";

        $data = [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'restaurant_id' => $restaurant->id,
            'amount' => $order->total_amount,
            'type' => 'new_order',
        ];

        // Notifier le restaurant
        $this->sendNotification(
            "restaurant_{$restaurant->id}",
            $title,
            $body,
            $data
        );

        // Notifier les admins
        $this->sendNotification(
            'admin_notifications',
            $title,
            $body,
            $data
        );

        // Sauvegarder dans Firestore
        $this->saveOrderToFirestore($order);
    }

    /**
     * Notifier un paiement complété
     */
    public function notifyPaymentCompleted(PaymentTransaction $transaction)
    {
        $order = $transaction->order;
        $restaurant = $order->restaurant;

        $title = "Paiement complété #{$order->order_number}";
        $body = "Paiement de {$transaction->amount} XOF reçu pour {$restaurant->name}";

        $data = [
            'transaction_id' => $transaction->id,
            'order_id' => $order->id,
            'amount' => $transaction->amount,
            'payment_method' => $transaction->payment_method_type,
            'type' => 'payment_completed',
        ];

        // Notifier le restaurant
        $this->sendNotification(
            "restaurant_{$restaurant->id}",
            $title,
            $body,
            $data
        );

        // Notifier les admins
        $this->sendNotification(
            'admin_notifications',
            $title,
            $body,
            $data
        );

        // Sauvegarder dans Firestore
        $this->savePaymentToFirestore($transaction);
    }

    /**
     * Sauvegarder une commande dans Firestore
     */
    public function saveOrderToFirestore(Order $order)
    {
        try {
            $orderData = [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'restaurant_id' => $order->restaurant_id,
                'restaurant_name' => $order->restaurant->name,
                'customer_name' => $order->customer_name,
                'customer_phone' => $order->customer_phone,
                'total_amount' => $order->total_amount,
                'status' => $order->status,
                'delivery_type' => $order->delivery_type,
                'created_at' => $order->created_at->toISOString(),
                'updated_at' => $order->updated_at->toISOString(),
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post(
                "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/orders",
                [
                    'fields' => $this->arrayToFirestoreFields($orderData)
                ]
            );

            if ($response->successful()) {
                Log::info('Order saved to Firestore', ['order_id' => $order->id]);
                return true;
            }

            Log::error('Failed to save order to Firestore', [
                'order_id' => $order->id,
                'response' => $response->json()
            ]);
            return false;
        } catch (\Exception $e) {
            Log::error('Firestore save order error', [
                'error' => $e->getMessage(),
                'order_id' => $order->id
            ]);
            return false;
        }
    }

    /**
     * Sauvegarder un paiement dans Firestore
     */
    public function savePaymentToFirestore(PaymentTransaction $transaction)
    {
        try {
            $paymentData = [
                'id' => $transaction->id,
                'order_id' => $transaction->order_id,
                'order_number' => $transaction->order->order_number,
                'restaurant_id' => $transaction->order->restaurant_id,
                'restaurant_name' => $transaction->order->restaurant->name,
                'amount' => $transaction->amount,
                'commission_amount' => $transaction->commission_amount ?? 0,
                'payment_method_type' => $transaction->payment_method_type,
                'status' => $transaction->status,
                'created_at' => $transaction->created_at->toISOString(),
                'paid_at' => $transaction->paid_at?->toISOString(),
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post(
                "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/payments",
                [
                    'fields' => $this->arrayToFirestoreFields($paymentData)
                ]
            );

            if ($response->successful()) {
                Log::info('Payment saved to Firestore', ['transaction_id' => $transaction->id]);
                return true;
            }

            Log::error('Failed to save payment to Firestore', [
                'transaction_id' => $transaction->id,
                'response' => $response->json()
            ]);
            return false;
        } catch (\Exception $e) {
            Log::error('Firestore save payment error', [
                'error' => $e->getMessage(),
                'transaction_id' => $transaction->id
            ]);
            return false;
        }
    }

    /**
     * Obtenir les statistiques temps réel
     */
    public function getRealTimeStats($restaurantId = null)
    {
        try {
            $cacheKey = "firebase_stats_{$restaurantId}";
            
            // Vérifier le cache d'abord
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }

            $path = $restaurantId ? "stats/restaurants/{$restaurantId}" : "stats/global";
            
            $response = Http::get("{$this->databaseUrl}/{$path}.json");

            if ($response->successful()) {
                $stats = $response->json();
                Cache::put($cacheKey, $stats, 60); // Cache 1 minute
                return $stats;
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Firebase get stats error', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Mettre à jour les statistiques temps réel
     */
    public function updateRealTimeStats($data, $restaurantId = null)
    {
        try {
            $path = $restaurantId ? "stats/restaurants/{$restaurantId}" : "stats/global";
            
            $response = Http::put("{$this->databaseUrl}/{$path}.json", $data);

            if ($response->successful()) {
                // Vider le cache
                $cacheKey = "firebase_stats_{$restaurantId}";
                Cache::forget($cacheKey);
                
                Log::info('Firebase stats updated', [
                    'restaurant_id' => $restaurantId,
                    'data' => $data
                ]);
                return true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Firebase update stats error', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Envoyer une notification système
     */
    public function sendSystemNotification($title, $body, $data = [])
    {
        return $this->sendNotification('system_alerts', $title, $body, $data);
    }

    /**
     * Convertir un tableau PHP en format Firestore
     */
    private function arrayToFirestoreFields($array)
    {
        $fields = [];
        
        foreach ($array as $key => $value) {
            if (is_string($value)) {
                $fields[$key] = ['stringValue' => $value];
            } elseif (is_numeric($value)) {
                if (is_float($value)) {
                    $fields[$key] = ['doubleValue' => $value];
                } else {
                    $fields[$key] = ['integerValue' => $value];
                }
            } elseif (is_bool($value)) {
                $fields[$key] = ['booleanValue' => $value];
            } elseif (is_array($value)) {
                $fields[$key] = ['arrayValue' => ['values' => $this->arrayToFirestoreValues($value)]];
            } elseif ($value === null) {
                $fields[$key] = ['nullValue' => null];
            }
        }
        
        return $fields;
    }

    /**
     * Convertir un tableau en valeurs Firestore
     */
    private function arrayToFirestoreValues($array)
    {
        $values = [];
        
        foreach ($array as $value) {
            if (is_string($value)) {
                $values[] = ['stringValue' => $value];
            } elseif (is_numeric($value)) {
                if (is_float($value)) {
                    $values[] = ['doubleValue' => $value];
                } else {
                    $values[] = ['integerValue' => $value];
                }
            } elseif (is_bool($value)) {
                $values[] = ['booleanValue' => $value];
            } elseif (is_array($value)) {
                $values[] = ['arrayValue' => ['values' => $this->arrayToFirestoreValues($value)]];
            } elseif ($value === null) {
                $values[] = ['nullValue' => null];
            }
        }
        
        return $values;
    }

    /**
     * Vérifier la connectivité Firebase
     */
    public function checkConnectivity()
    {
        try {
            $response = Http::timeout(10)->get("{$this->databaseUrl}/.json");
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Firebase connectivity check failed', ['error' => $e->getMessage()]);
            return false;
        }
    }
} 