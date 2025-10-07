<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\Promotion;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\PaymentTransaction;
use App\Mail\NewOrderNotification;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RestaurantPublicController extends Controller
{
    public function home($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)
            ->where('is_active', true)
            ->with(['categories.products' => function($query) {
                $query->where('is_available', true);
            }])
            ->firstOrFail();

        // Statistiques pour la section "À propos"
        $stats = [
            'total_products' => Product::where('restaurant_id', $restaurant->id)->count() ?? 0,
            'total_reviews' => Review::where('restaurant_id', $restaurant->id)->where('is_approved', true)->count() ?? 0,
            'average_rating' => Review::where('restaurant_id', $restaurant->id)->where('is_approved', true)->avg('rating') ?? 0,
        ];

        return view('public.restaurant.home', compact('restaurant', 'stats'));
    }

    public function menu($slug, Request $request)
    {
        $restaurant = Restaurant::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $query = Product::where('restaurant_id', $restaurant->id)
            ->where('is_available', true)
            ->with('category');

        // Filtres
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'popular':
                    $query->orderBy('is_popular', 'desc')->orderBy('name', 'asc');
                    break;
                default:
                    $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
            }
        } else {
            $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
        }

        $products = $query->paginate(12);
        $categories = Category::where('restaurant_id', $restaurant->id)
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('public.restaurant.menu', compact('restaurant', 'products', 'categories'));
    }

    public function product($slug, $productId)
    {
        $restaurant = Restaurant::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $product = Product::where('id', $productId)
            ->where('restaurant_id', $restaurant->id)
            ->where('is_available', true)
            ->with(['category'])
            ->firstOrFail();

        // Produits similaires
        $similarProducts = Product::where('restaurant_id', $restaurant->id)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_available', true)
            ->limit(4)
            ->get();

        return view('public.restaurant.product', compact('restaurant', 'product', 'similarProducts'));
    }

    public function about($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Statistiques
        $stats = [
            'total_products' => Product::where('restaurant_id', $restaurant->id)->count() ?? 0,
            'total_reviews' => Review::where('restaurant_id', $restaurant->id)->where('is_approved', true)->count() ?? 0,
            'average_rating' => Review::where('restaurant_id', $restaurant->id)->where('is_approved', true)->avg('rating') ?? 0,
        ];

        return view('public.restaurant.about', compact('restaurant', 'stats'));
    }

    public function contact($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.restaurant.contact', compact('restaurant'));
    }

    public function reviews($slug, Request $request)
    {
        $restaurant = Restaurant::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $query = Review::where('restaurant_id', $restaurant->id)
            ->where('is_approved', true)
            ->with('user');

        // Filtres
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'rating_high':
                    $query->orderBy('rating', 'desc');
                    break;
                case 'rating_low':
                    $query->orderBy('rating', 'asc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $reviews = $query->paginate(10);

        // Statistiques des avis
        $reviewStats = [
            'total' => Review::where('restaurant_id', $restaurant->id)->where('is_approved', true)->count() ?? 0,
            'average' => Review::where('restaurant_id', $restaurant->id)->where('is_approved', true)->avg('rating') ?? 0,
            'by_rating' => [
                5 => Review::where('restaurant_id', $restaurant->id)->where('is_approved', true)->where('rating', 5)->count() ?? 0,
                4 => Review::where('restaurant_id', $restaurant->id)->where('is_approved', true)->where('rating', 4)->count() ?? 0,
                3 => Review::where('restaurant_id', $restaurant->id)->where('is_approved', true)->where('rating', 3)->count() ?? 0,
                2 => Review::where('restaurant_id', $restaurant->id)->where('is_approved', true)->where('rating', 2)->count() ?? 0,
                1 => Review::where('restaurant_id', $restaurant->id)->where('is_approved', true)->where('rating', 1)->count() ?? 0,
            ]
        ];

        return view('public.restaurant.reviews', compact('restaurant', 'reviews', 'reviewStats'));
    }

    public function checkout($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Récupérer les méthodes de paiement configurées pour ce restaurant
        $paymentMethods = PaymentMethod::where('restaurant_id', $restaurant->id)
            ->where('is_active', true)
            ->get();

        return view('public.restaurant.checkout', compact('restaurant', 'paymentMethods'));
    }

    public function processCheckout($slug, Request $request)
    {
        $restaurant = Restaurant::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Validation des données
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'delivery_address' => 'required_if:delivery_type,delivery|nullable|string',
            'delivery_type' => 'required|in:delivery,pickup,dine_in',
            'payment_method' => 'required|string',
            'special_instructions' => 'nullable|string|max:500',
            'table_number' => 'nullable|string|max:50',
            'number_of_guests' => 'nullable|integer|min:1|max:20',
            'cart_items' => 'required|string', // Validation du panier
            'subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        try {
            // Nettoyer et valider les données de base
            $customerName = trim(substr($request->customer_name, 0, 100));
            $customerPhone = trim(substr($request->customer_phone, 0, 20));
            $customerEmail = $request->customer_email ? trim(substr($request->customer_email, 0, 100)) : null;
            $specialInstructions = $request->special_instructions ? trim(substr($request->special_instructions, 0, 1000)) : null;
            $paymentMethod = trim(substr($request->payment_method, 0, 50));
            
            // Générer un numéro de commande unique
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 8));
            
            // Préparer les informations client
            $customerInfo = [
                'name' => $customerName,
                'phone' => $customerPhone,
                'email' => $customerEmail,
                'table_number' => $request->table_number ? trim(substr($request->table_number, 0, 20)) : null,
                'number_of_guests' => $request->number_of_guests ? (int)$request->number_of_guests : null,
            ];
            
            // Préparer l'adresse de livraison
            $deliveryAddress = null;
            if ($request->delivery_type === 'delivery' && $request->delivery_address) {
                $deliveryAddress = [
                    'address' => trim(substr($request->delivery_address, 0, 200)),
                    'type' => 'delivery'
                ];
            } elseif ($request->delivery_type === 'dine_in') {
                $deliveryAddress = [
                    'type' => 'dine_in',
                    'table_number' => $request->table_number ? trim(substr($request->table_number, 0, 20)) : null,
                    'number_of_guests' => $request->number_of_guests ? (int)$request->number_of_guests : null,
                ];
            } elseif ($request->delivery_type === 'pickup') {
                $deliveryAddress = [
                    'type' => 'pickup'
                ];
            }
            
            // Vérifier la taille des données JSON
            $customerInfoJson = json_encode($customerInfo);
            $deliveryAddressJson = json_encode($deliveryAddress);
            
            if (strlen($customerInfoJson) > 1000) {
                throw new \Exception('Les informations client sont trop volumineuses');
            }
            
            if (strlen($deliveryAddressJson) > 1000) {
                throw new \Exception('L\'adresse de livraison est trop volumineuse');
            }
            
            // Créer la commande
            $order = Order::create([
                'restaurant_id' => $restaurant->id,
                'user_id' => null, // Commande publique sans utilisateur connecté
                'order_number' => $orderNumber,
                'type' => $request->delivery_type,
                'subtotal' => (float)($request->subtotal ?? 0),
                'delivery_fee' => (float)($request->delivery_fee ?? 0),
                'tax_amount' => 0,
                'discount_amount' => 0,
                'total_amount' => (float)($request->total ?? 0),
                'currency' => $restaurant->currency ?? 'XOF',
                'customer_info' => $customerInfoJson,
                'delivery_address' => $deliveryAddressJson,
                'customer_name' => $customerName,
                'customer_phone' => $customerPhone,
                'customer_email' => $customerEmail,
                'special_instructions' => $specialInstructions,
                'payment_method' => $paymentMethod,
                'payment_status' => 'pending',
                'status' => 'pending',
            ]);

            // Log pour déboguer
            \Log::info('Commande créée avec succès', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'restaurant_id' => $restaurant->id,
                'customer_name' => $customerName,
                'total_amount' => $order->total_amount,
                'status' => $order->status,
                'customer_info' => $customerInfo,
                'delivery_address' => $deliveryAddress
            ]);

            // Ajouter les articles de la commande et gérer les stocks
            if ($request->has('cart_items')) {
                $cartItems = json_decode($request->cart_items, true);
                
                // Valider que les données du panier sont valides
                if (!is_array($cartItems) || empty($cartItems)) {
                    throw new \Exception('Le panier est vide ou invalide');
                }
                
                foreach ($cartItems as $item) {
                    // Valider les données de l'article
                    if (!isset($item['id']) || !isset($item['name']) || !isset($item['quantity']) || !isset($item['price'])) {
                        throw new \Exception('Données d\'article invalides dans le panier');
                    }
                    
                    // Nettoyer et valider les options
                    $options = [];
                    if (isset($item['options']) && is_array($item['options'])) {
                        foreach ($item['options'] as $key => $value) {
                            $cleanKey = trim(substr($key, 0, 30));
                            $cleanValue = is_string($value) ? trim(substr($value, 0, 50)) : $value;
                            $options[$cleanKey] = $cleanValue;
                        }
                    }
                    
                    // Nettoyer le nom du produit
                    $productName = trim(substr($item['name'], 0, 100));
                    
                    // Vérifier la taille des options JSON
                    $optionsJson = json_encode($options);
                    if (strlen($optionsJson) > 500) {
                        throw new \Exception('Les options du produit sont trop volumineuses');
                    }
                    
                    // Créer l'article de commande
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['id'],
                        'product_name' => $productName,
                        'quantity' => (int)($item['quantity']),
                        'unit_price' => (float)($item['price']),
                        'total_price' => (float)($item['price']) * (int)($item['quantity']),
                        'options' => $optionsJson,
                        'special_instructions' => isset($item['specialInstructions']) ? trim(substr($item['specialInstructions'], 0, 500)) : null,
                    ]);
                    
                    // Mettre à jour le stock du produit
                    $product = Product::find($item['id']);
                    if ($product && $product->stock_management_enabled) {
                        $newStock = max(0, $product->stock_quantity - (int)($item['quantity']));
                        $product->update(['stock_quantity' => $newStock]);
                        
                        // Log de la mise à jour du stock
                        \Log::info('Stock mis à jour', [
                            'product_id' => $product->id,
                            'product_name' => $product->name,
                            'old_stock' => $product->stock_quantity + (int)($item['quantity']),
                            'new_stock' => $newStock,
                            'quantity_ordered' => (int)($item['quantity'])
                        ]);
                    }
                }
                
                // Log pour déboguer
                \Log::info('Articles de commande créés', [
                    'order_id' => $order->id,
                    'items_count' => count($cartItems),
                    'cart_items' => $cartItems
                ]);
            }

            // Traitement du paiement si ce n'est pas un paiement en espèces
            $paymentResult = null;
            if ($request->payment_method !== 'cash') {
                try {
                    // Récupérer la méthode de paiement configurée
                    $paymentMethod = PaymentMethod::where('restaurant_id', $restaurant->id)
                        ->where('provider', $request->payment_method)
                        ->where('is_active', true)
                        ->first();

                    if (!$paymentMethod) {
                        throw new \Exception('Méthode de paiement non configurée');
                    }

                    // Créer une transaction de paiement
                    $transaction = PaymentTransaction::create([
                        'restaurant_id' => $restaurant->id,
                        'order_id' => $order->id,
                        'payment_method_id' => $paymentMethod->id,
                        'transaction_id' => 'TXN-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 8)),
                        'amount' => $order->total_amount,
                        'currency' => $order->currency,
                        'status' => 'pending',
                        'payment_details' => [
                            'customer_name' => $request->customer_name,
                            'customer_phone' => $request->customer_phone,
                            'customer_email' => $request->customer_email,
                            'order_number' => $order->order_number,
                        ],
                    ]);

                    // Traiter le paiement via le service
                    $paymentService = new PaymentService();
                    $paymentResult = $paymentService->processPayment($transaction, [
                        'amount' => $order->total_amount,
                        'currency' => $order->currency,
                        'customer_name' => $request->customer_name,
                        'customer_phone' => $request->customer_phone,
                        'customer_email' => $request->customer_email,
                        'order_number' => $order->order_number,
                        'description' => "Commande {$order->order_number} - {$restaurant->name}",
                    ]);

                    \Log::info('Paiement traité', [
                        'transaction_id' => $transaction->transaction_id,
                        'payment_result' => $paymentResult
                    ]);

                } catch (\Exception $e) {
                    \Log::error('Erreur lors du traitement du paiement', [
                        'error' => $e->getMessage(),
                        'order_id' => $order->id,
                        'payment_method' => $request->payment_method
                    ]);
                    
                    // Marquer la commande comme échouée
                    $order->update(['status' => 'payment_failed']);
                    
                    if ($request->expectsJson() || $request->header('Accept') === 'application/json') {
                        return response()->json([
                            'success' => false,
                            'error' => 'Erreur lors du traitement du paiement: ' . $e->getMessage()
                        ], 500);
                    }
                    
                    return back()->withInput()->withErrors(['error' => 'Erreur lors du traitement du paiement: ' . $e->getMessage()]);
                }
            }

            // Envoyer une notification par email au restaurant
            try {
                if ($restaurant->email) {
                    Mail::to($restaurant->email)->send(new NewOrderNotification($order));
                    \Log::info('Email de notification envoyé', [
                        'restaurant_email' => $restaurant->email,
                        'order_id' => $order->id
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error('Erreur lors de l\'envoi de l\'email de notification', [
                    'error' => $e->getMessage(),
                    'order_id' => $order->id
                ]);
            }

            // Retourner une réponse JSON pour les requêtes AJAX
            if ($request->expectsJson() || $request->header('Accept') === 'application/json') {
                $response = [
                    'success' => true,
                    'message' => 'Votre commande a été enregistrée avec succès !',
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                ];

                // Si c'est un paiement Wave avec redirection requise
                if ($paymentResult && isset($paymentResult['redirect_required']) && $paymentResult['redirect_required']) {
                    $response['payment_redirect'] = true;
                    $response['payment_link_url'] = $paymentResult['payment_link_url'];
                    $response['message'] = 'Redirection vers le paiement Wave...';
                } else {
                    $response['redirect_url'] = route('restaurant.public.checkout.success', $slug);
                }

                return response()->json($response);
            }

            // Sauvegarder les données du panier en session pour la page de succès
            if ($request->has('cart_items')) {
                $cartItems = json_decode($request->cart_items, true);
                session([
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'cart_items' => $cartItems,
                    'subtotal' => $request->subtotal ?? 0,
                    'delivery_fee' => $request->delivery_fee ?? 0,
                    'total' => $request->total ?? 0,
                    'delivery_type' => $request->delivery_type ?? 'pickup',
                    'payment_method' => $request->payment_method ?? 'cash',
                    'special_instructions' => $request->special_instructions ?? null,
                    'table_number' => $request->table_number ?? null,
                    'number_of_guests' => $request->number_of_guests ?? null,
                ]);
                
                // Log pour déboguer
                \Log::info('Session sauvegardée', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'session_data' => session()->all()
                ]);
            }

            // Rediriger vers la page de confirmation pour les requêtes normales
            return redirect()->route('restaurant.public.checkout.success', $slug)
                ->with('success', 'Votre commande a été enregistrée avec succès !')
                ->with('order_id', $order->id)
                ->with('order_number', $order->order_number);

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création de la commande', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            // Retourner une réponse JSON pour les requêtes AJAX
            if ($request->expectsJson() || $request->header('Accept') === 'application/json') {
                // Retourner une réponse plus détaillée en mode debug
                if (config('app.debug')) {
                    return response()->json([
                        'success' => false,
                        'error' => 'Une erreur est survenue lors de la création de la commande. Veuillez réessayer.',
                        'details' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine()
                    ], 500);
                }

                return response()->json([
                    'success' => false,
                    'error' => 'Une erreur est survenue lors de la création de la commande. Veuillez réessayer.',
                    'details' => $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'Une erreur est survenue lors de la création de la commande.']);
        }
    }

    public function checkoutSuccess($slug, Request $request)
    {
        $restaurant = Restaurant::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Vérifier si c'est un retour de paiement Wave
        if ($request->has('wave_payment_id') || $request->has('transaction_id')) {
            $transactionId = $request->get('wave_payment_id') ?? $request->get('transaction_id');
            
            // Récupérer la transaction
            $transaction = PaymentTransaction::where('external_id', $transactionId)
                ->orWhere('transaction_id', $transactionId)
                ->first();

            if ($transaction) {
                // Mettre à jour le statut de la commande
                $order = $transaction->order;
                if ($order) {
                    $order->update([
                        'payment_status' => 'completed',
                        'status' => 'confirmed'
                    ]);
                    
                    // Mettre à jour la session avec les données de la commande
                    session([
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'cart_items' => $order->items->map(function($item) {
                            return [
                                'id' => $item->product_id,
                                'name' => $item->product_name,
                                'quantity' => $item->quantity,
                                'price' => $item->unit_price,
                                'options' => json_decode($item->options, true) ?? [],
                                'specialInstructions' => $item->special_instructions
                            ];
                        })->toArray(),
                        'subtotal' => $order->subtotal,
                        'delivery_fee' => $order->delivery_fee,
                        'total' => $order->total_amount,
                        'delivery_type' => $order->type,
                        'payment_method' => $order->payment_method,
                        'special_instructions' => $order->special_instructions,
                        'table_number' => json_decode($order->delivery_address, true)['table_number'] ?? null,
                        'number_of_guests' => json_decode($order->delivery_address, true)['number_of_guests'] ?? null,
                    ]);
                }

                return view('public.restaurant.checkout-success', compact('restaurant', 'transaction'));
            }
        }

        // Vérifier si on a des données de session pour afficher la page
        if (!session('order_number') && !session('order_id')) {
            // Log pour déboguer
            \Log::info('Aucune commande en session', [
                'session_data' => session()->all(),
                'order_number' => session('order_number'),
                'order_id' => session('order_id')
            ]);
            
            // Rediriger vers la page d'accueil si pas de commande en session
            return redirect()->route('restaurant.public.home', $slug)
                ->with('error', 'Aucune commande trouvée. Veuillez passer une nouvelle commande.');
        }

        // Log pour déboguer
        \Log::info('Données de session trouvées', [
            'order_number' => session('order_number'),
            'order_id' => session('order_id'),
            'cart_items' => session('cart_items'),
            'total' => session('total')
        ]);

        return view('public.restaurant.checkout-success', compact('restaurant'));
    }

    public function checkoutCancel($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.restaurant.checkout-cancel', compact('restaurant'));
    }

    public function checkoutWavePending($slug, Request $request)
    {
        $restaurant = Restaurant::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Récupérer la commande si un order_number est fourni
        $order = null;
        if ($request->has('order_number')) {
            $order = Order::where('order_number', $request->order_number)
                ->where('restaurant_id', $restaurant->id)
                ->first();
        }

        return view('public.restaurant.checkout-wave-pending', compact('restaurant', 'order'));
    }

    public function trackOrder($slug, $orderNumber)
    {
        $restaurant = Restaurant::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
            
        $order = Order::where('order_number', $orderNumber)
            ->where('restaurant_id', $restaurant->id)
            ->with(['items.product'])
            ->first();
            
        if (!$order) {
            abort(404, 'Commande non trouvée');
        }
        
        return view('public.restaurant.track-order', compact('restaurant', 'order'));
    }

    public function getOrderStatus($slug, $orderNumber)
    {
        $restaurant = Restaurant::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $order = Order::where('order_number', $orderNumber)
            ->where('restaurant_id', $restaurant->id)
            ->firstOrFail();

        // Calculer le temps estimé basé sur le statut
        $estimatedTime = $this->calculateEstimatedTime($order);

        return response()->json([
            'status' => $order->status,
            'estimated_time' => $estimatedTime,
            'updated_at' => $order->updated_at->toISOString()
        ]);
    }

    private function calculateEstimatedTime($order)
    {
        switch ($order->status) {
            case 'pending':
                return 'En attente de confirmation';
            case 'confirmed':
                return 'Préparation dans 15-20 minutes';
            case 'preparing':
                return 'Prêt dans 10-15 minutes';
            case 'ready':
                return 'Prêt pour récupération/livraison';
            case 'delivered':
                return 'Livré';
            case 'completed':
                return 'Terminé';
            default:
                return 'En cours de traitement';
        }
    }

    public function storeReview($slug, Request $request)
    {
        $restaurant = Restaurant::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Validation des données
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'order_number' => 'nullable|string|max:255'
        ]);

        // Vérifier si l'utilisateur a déjà laissé un avis pour cette commande
        if ($request->filled('order_number')) {
            $existingReview = Review::where('restaurant_id', $restaurant->id)
                ->where('order_number', $request->order_number)
                ->first();

            if ($existingReview) {
                return back()->withErrors(['error' => 'Vous avez déjà laissé un avis pour cette commande.']);
            }
        }

        // Créer l'avis
        $review = Review::create([
            'restaurant_id' => $restaurant->id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'order_number' => $request->order_number,
            'is_approved' => false, // Nécessite approbation par défaut
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Log de l'avis
        \Log::info('Nouvel avis créé', [
            'review_id' => $review->id,
            'restaurant_id' => $restaurant->id,
            'rating' => $review->rating,
            'order_number' => $review->order_number
        ]);

        return back()->with('success', 'Votre avis a été soumis avec succès ! Il sera publié après modération.');
    }
} 