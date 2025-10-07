<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class RestaurantOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'user.role:restaurant,admin,super_admin']);
    }

    /**
     * Afficher la liste des commandes du restaurant
     */
    public function index()
    {
        $restaurant = Auth::user()->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('restaurant.dashboard')->with('error', 'Restaurant non trouvé');
        }

        $orders = Order::where('restaurant_id', $restaurant->id)
            ->with(['items'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Statistiques des commandes
        $stats = [
            'total' => Order::where('restaurant_id', $restaurant->id)->count(),
            'pending' => Order::where('restaurant_id', $restaurant->id)->where('status', 'pending')->count(),
            'preparing' => Order::where('restaurant_id', $restaurant->id)->where('status', 'preparing')->count(),
            'ready' => Order::where('restaurant_id', $restaurant->id)->where('status', 'ready')->count(),
            'delivered' => Order::where('restaurant_id', $restaurant->id)->where('status', 'delivered')->count(),
            'today' => Order::where('restaurant_id', $restaurant->id)->whereDate('created_at', today())->count(),
        ];

        return view('restaurant.orders.index', compact('orders', 'stats', 'restaurant'));
    }

    /**
     * Afficher le formulaire de création d'une commande
     */
    public function create()
    {
        $restaurant = Auth::user()->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('restaurant.dashboard')->with('error', 'Restaurant non trouvé');
        }

        return view('restaurant.orders.create', compact('restaurant'));
    }

    /**
     * Créer une nouvelle commande
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'customer_address' => 'nullable|string|max:500',
            'order_type' => 'required|in:on_site,takeaway,delivery',
            'products' => 'required|array|min:1',
            'products.*' => 'required|exists:products,id',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'required|integer|min:1',
            'prices' => 'required|array|min:1',
            'prices.*' => 'required|numeric|min:0',
            'special_instructions' => 'nullable|string|max:1000',
        ]);

        $restaurant = Auth::user()->restaurant;
        
        if (!$restaurant) {
            return redirect()->back()->with('error', 'Restaurant non trouvé');
        }

        try {
            // Calculer le total
            $subtotal = 0;
            $deliveryFee = 0;
            
            foreach ($request->products as $index => $productId) {
                if ($productId && isset($request->quantities[$index]) && isset($request->prices[$index])) {
                    $subtotal += $request->prices[$index] * $request->quantities[$index];
                }
            }
            
            if ($request->order_type === 'delivery') {
                $deliveryFee = 2.50; // Frais de livraison standard
            }
            
            $total = $subtotal + $deliveryFee;

            // Créer la commande
            $order = Order::create([
                'restaurant_id' => $restaurant->id,
                'order_number' => 'CMD-' . time() . '-' . rand(1000, 9999),
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'customer_address' => $request->customer_address,
                'type' => $request->order_type,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'status' => 'pending',
                'special_instructions' => $request->special_instructions,
                'estimated_delivery_time' => now()->addMinutes(30),
            ]);

            // Créer les éléments de la commande
            foreach ($request->products as $index => $productId) {
                if ($productId && isset($request->quantities[$index]) && isset($request->prices[$index])) {
                    $product = \App\Models\Product::find($productId);
                    if ($product) {
                        $order->items()->create([
                            'product_id' => $productId,
                            'product_name' => $product->name,
                            'quantity' => $request->quantities[$index],
                            'unit_price' => $request->prices[$index],
                            'total_price' => $request->prices[$index] * $request->quantities[$index],
                        ]);
                    }
                }
            }

            return redirect()->route('restaurant.orders.show', $order->id)
                ->with('success', 'Commande créée avec succès !');

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création de la commande: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de la commande. Veuillez réessayer.')
                ->withInput();
        }
    }

    /**
     * Afficher les détails d'une commande
     */
    public function show($id)
    {
        $restaurant = Auth::user()->restaurant;
        $order = Order::where('restaurant_id', $restaurant->id)
            ->with(['items'])
            ->findOrFail($id);

        return view('restaurant.orders.show', compact('order', 'restaurant'));
    }

    /**
     * Mettre à jour le statut d'une commande
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,out_for_delivery,delivered,cancelled'
        ]);

        $restaurant = Auth::user()->restaurant;
        $order = Order::where('restaurant_id', $restaurant->id)->findOrFail($id);

        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();

        // Log de la modification
        \Log::info("Commande {$order->order_number} : statut changé de {$oldStatus} à {$request->status}");

        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour avec succès',
            'new_status' => $request->status,
            'status_text' => $order->status_text
        ]);
    }

    /**
     * Annuler une commande
     */
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'cancellation_reason' => 'required|string|max:500'
        ]);

        $restaurant = Auth::user()->restaurant;
        $order = Order::where('restaurant_id', $restaurant->id)->findOrFail($id);

        if (!$order->canBeCancelled()) {
            return response()->json([
                'success' => false,
                'message' => 'Cette commande ne peut plus être annulée'
            ], 400);
        }

        $order->status = 'cancelled';
        $order->cancellation_reason = $request->cancellation_reason;
        $order->cancelled_at = now();
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Commande annulée avec succès'
        ]);
    }

    /**
     * Marquer une commande comme prête
     */
    public function markAsReady($id)
    {
        $restaurant = Auth::user()->restaurant;
        $order = Order::where('restaurant_id', $restaurant->id)->findOrFail($id);

        if ($order->status !== 'preparing') {
            return response()->json([
                'success' => false,
                'message' => 'La commande doit être en préparation'
            ], 400);
        }

        $order->status = 'ready';
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Commande marquée comme prête'
        ]);
    }

    /**
     * Obtenir les commandes en temps réel (pour AJAX)
     */
    public function getOrders()
    {
        $restaurant = Auth::user()->restaurant;
        
        $orders = Order::where('restaurant_id', $restaurant->id)
            ->with(['items'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json($orders);
    }

    /**
     * Obtenir les statistiques des commandes
     */
    public function getStats()
    {
        $restaurant = Auth::user()->restaurant;
        
        $stats = [
            'total' => Order::where('restaurant_id', $restaurant->id)->count(),
            'pending' => Order::where('restaurant_id', $restaurant->id)->where('status', 'pending')->count(),
            'preparing' => Order::where('restaurant_id', $restaurant->id)->where('status', 'preparing')->count(),
            'ready' => Order::where('restaurant_id', $restaurant->id)->where('status', 'ready')->count(),
            'delivered' => Order::where('restaurant_id', $restaurant->id)->where('status', 'delivered')->count(),
            'today' => Order::where('restaurant_id', $restaurant->id)->whereDate('created_at', today())->count(),
        ];

        return response()->json($stats);
    }
} 