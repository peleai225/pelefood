<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Créer une nouvelle commande
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'delivery_address' => 'required|string|max:500',
            'delivery_city' => 'required|string|max:100',
            'delivery_instructions' => 'nullable|string|max:500',
            'order_type' => 'required|in:delivery,pickup',
            'payment_method' => 'required|in:cash,card,mobile_money',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.special_instructions' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $restaurant = Restaurant::findOrFail($request->restaurant_id);
            
            if (!$restaurant->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce restaurant n\'est pas disponible'
                ], 400);
            }

            // Calculer le total
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }

            $deliveryFee = $request->order_type === 'delivery' ? $restaurant->delivery_fee : 0;
            $total = $subtotal + $deliveryFee;

            // Générer un numéro de commande unique
            $orderNumber = $this->generateOrderNumber();

            // Créer la commande
            $order = Order::create([
                'order_number' => $orderNumber,
                'restaurant_id' => $restaurant->id,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'delivery_address' => $request->delivery_address,
                'delivery_city' => $request->delivery_city,
                'delivery_instructions' => $request->delivery_instructions,
                'order_type' => $request->order_type,
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total_amount' => $total,
                'status' => 'pending',
                'estimated_delivery_time' => $this->calculateEstimatedDeliveryTime($restaurant, $request->items),
                'order_data' => json_encode([
                    'items' => $request->items,
                    'restaurant_info' => [
                        'name' => $restaurant->name,
                        'phone' => $restaurant->phone,
                        'address' => $restaurant->address
                    ]
                ])
            ]);

            // Créer les items de la commande
            foreach ($request->items as $itemData) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $itemData['product_id'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total_price' => $itemData['quantity'] * $itemData['unit_price'],
                    'special_instructions' => $itemData['special_instructions'] ?? null
                ]);
            }

            DB::commit();

            // Envoyer notification au restaurant
            event(new \App\Events\NewOrderReceived($order));

            return response()->json([
                'success' => true,
                'message' => 'Commande créée avec succès',
                'data' => [
                    'order_number' => $order->order_number,
                    'status' => $order->status,
                    'total_amount' => $order->total_amount,
                    'estimated_delivery_time' => $order->estimated_delivery_time,
                    'restaurant_name' => $restaurant->name,
                    'restaurant_phone' => $restaurant->phone
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la commande',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Suivre une commande
     */
    public function track(Request $request, $orderNumber): JsonResponse
    {
        $order = Order::with(['restaurant', 'orderItems.product'])
            ->where('order_number', $orderNumber)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        $orderData = [
            'order_number' => $order->order_number,
            'status' => $order->status,
            'status_label' => $this->getStatusLabel($order->status),
            'customer_name' => $order->customer_name,
            'customer_phone' => $order->customer_phone,
            'delivery_address' => $order->delivery_address,
            'delivery_city' => $order->delivery_city,
            'order_type' => $order->order_type,
            'payment_method' => $order->payment_method,
            'subtotal' => $order->subtotal,
            'delivery_fee' => $order->delivery_fee,
            'total_amount' => $order->total_amount,
            'estimated_delivery_time' => $order->estimated_delivery_time,
            'actual_delivery_time' => $order->actual_delivery_time,
            'created_at' => $order->created_at->format('d/m/Y H:i'),
            'updated_at' => $order->updated_at->format('d/m/Y H:i'),
            'restaurant' => [
                'name' => $order->restaurant->name,
                'phone' => $order->restaurant->phone,
                'address' => $order->restaurant->address,
                'logo_url' => $order->restaurant->logo_url
            ],
            'items' => $order->orderItems->map(function($item) {
                return [
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                    'special_instructions' => $item->special_instructions
                ];
            }),
            'status_history' => $this->getStatusHistory($order)
        ];

        return response()->json([
            'success' => true,
            'data' => $orderData
        ]);
    }

    /**
     * Obtenir le statut d'une commande
     */
    public function status(Request $request, $orderNumber): JsonResponse
    {
        $order = Order::where('order_number', $orderNumber)
            ->select(['order_number', 'status', 'updated_at'])
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'order_number' => $order->order_number,
                'status' => $order->status,
                'status_label' => $this->getStatusLabel($order->status),
                'updated_at' => $order->updated_at->format('d/m/Y H:i')
            ]
        ]);
    }

    /**
     * Générer un numéro de commande unique
     */
    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'PF' . date('Ymd') . rand(1000, 9999);
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    /**
     * Calculer le temps de livraison estimé
     */
    private function calculateEstimatedDeliveryTime(Restaurant $restaurant, array $items): ?Carbon
    {
        $baseTime = 30; // 30 minutes de base
        $itemCount = array_sum(array_column($items, 'quantity'));
        $additionalTime = $itemCount * 5; // 5 minutes par item
        
        return Carbon::now()->addMinutes($baseTime + $additionalTime);
    }

    /**
     * Obtenir le label du statut
     */
    private function getStatusLabel(string $status): string
    {
        $labels = [
            'pending' => 'En attente',
            'confirmed' => 'Confirmée',
            'preparing' => 'En préparation',
            'ready' => 'Prête',
            'delivered' => 'Livrée',
            'cancelled' => 'Annulée'
        ];

        return $labels[$status] ?? $status;
    }

    /**
     * Obtenir l'historique des statuts
     */
    private function getStatusHistory(Order $order): array
    {
        // Pour l'instant, on retourne juste le statut actuel
        // Dans une version plus avancée, on pourrait stocker l'historique
        return [
            [
                'status' => $order->status,
                'status_label' => $this->getStatusLabel($order->status),
                'timestamp' => $order->updated_at->format('d/m/Y H:i'),
                'description' => $this->getStatusDescription($order->status)
            ]
        ];
    }

    /**
     * Obtenir la description du statut
     */
    private function getStatusDescription(string $status): string
    {
        $descriptions = [
            'pending' => 'Votre commande a été reçue et est en attente de confirmation',
            'confirmed' => 'Votre commande a été confirmée par le restaurant',
            'preparing' => 'Votre commande est en cours de préparation',
            'ready' => 'Votre commande est prête pour la livraison',
            'delivered' => 'Votre commande a été livrée avec succès',
            'cancelled' => 'Votre commande a été annulée'
        ];

        return $descriptions[$status] ?? 'Statut inconnu';
    }
}

