<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    /**
     * Traiter une nouvelle commande
     */
    public function store(Request $request, $restaurantSlug)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'order_type' => 'required|in:on_site,delivery,takeaway',
            'delivery_address' => 'required_if:order_type,delivery|nullable|string|max:500',
            'special_instructions' => 'nullable|string|max:1000',
            'cart_items' => 'required|array|min:1',
            'cart_items.*.id' => 'required|integer',
            'cart_items.*.name' => 'required|string',
            'cart_items.*.price' => 'required|numeric|min:0',
            'cart_items.*.quantity' => 'required|integer|min:1',
        ]);

        // Récupérer le restaurant
        $restaurant = Restaurant::where('slug', $restaurantSlug)->firstOrFail();

        // Calculer les totaux
        $subtotal = 0;
        $deliveryFee = 0;
        
        foreach ($request->cart_items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Ajouter les frais de livraison si applicable
        if ($request->order_type === 'delivery') {
            $deliveryFee = $restaurant->delivery_fee ?? 500;
        }

        $totalAmount = $subtotal + $deliveryFee;

        // Créer la commande
        $order = Order::create([
            'order_number' => 'CMD-' . strtoupper(Str::random(8)),
            'restaurant_id' => $restaurant->id,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'type' => $request->order_type,
            'delivery_address' => $request->delivery_address,
            'special_instructions' => $request->special_instructions,
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'estimated_delivery_time' => $this->calculateEstimatedTime($request->order_type, $restaurant),
        ]);

        // Créer les éléments de la commande
        foreach ($request->cart_items as $item) {
            $order->items()->create([
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'total_price' => $item['price'] * $item['quantity'],
            ]);
        }

        // Envoyer les notifications
        $this->sendOrderNotifications($order);

        // Vider le panier du localStorage (sera fait côté client)
        
        return response()->json([
            'success' => true,
            'order' => $order,
            'message' => 'Commande confirmée avec succès !',
            'redirect_url' => route('order.tracking', $order->order_number)
        ]);
    }

    /**
     * Envoyer les notifications pour une nouvelle commande
     */
    private function sendOrderNotifications($order)
    {
        // Notifier les admins et super admins
        $admins = User::whereIn('role', ['super_admin', 'admin'])->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewOrderNotification($order, 'new_order'));
        }

        // Notifier le restaurant propriétaire
        if ($order->restaurant && $order->restaurant->user) {
            $order->restaurant->user->notify(new NewOrderNotification($order, 'new_order'));
        }

        // Si un utilisateur est connecté, le notifier aussi
        if (auth()->check()) {
            auth()->user()->notify(new NewOrderNotification($order, 'new_order'));
        }
    }

    /**
     * Calculer le temps de livraison estimé
     */
    private function calculateEstimatedTime($orderType, $restaurant)
    {
        $baseTime = $restaurant->preparation_time ?? 30;
        
        switch ($orderType) {
            case 'on_site':
                return $baseTime . ' minutes';
            case 'takeaway':
                return ($baseTime + 5) . ' minutes';
            case 'delivery':
                return ($baseTime + 20) . ' minutes';
            default:
                return $baseTime . ' minutes';
        }
    }

    /**
     * Afficher la page de confirmation
     */
    public function confirmation($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        
        return view('restaurant.public.confirmation', compact('order'));
    }
}
