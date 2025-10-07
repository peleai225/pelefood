<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Events\NewOrderReceived;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->restaurant->orders()->latest()->paginate(20);
        return view('restaurant.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('restaurant.orders.show', compact('order'));
    }

    public function create()
    {
        return view('restaurant.orders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'delivery_address' => 'required|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000'
        ]);

        $order = auth()->user()->restaurant->orders()->create([
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'],
            'delivery_address' => $validated['delivery_address'],
            'total_amount' => $validated['total_amount'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending'
        ]);

        // Ajouter les articles de la commande
        foreach ($validated['items'] as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        // Déclencher l'événement de nouvelle commande
        event(new NewOrderReceived($order, auth()->user()->restaurant));

        return redirect()->route('restaurant.orders.show', $order)
            ->with('success', 'Commande créée avec succès');
    }

    public function edit(Order $order)
    {
        return view('restaurant.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'delivery_address' => 'required|string|max:500',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled'
        ]);

        $order->update($validated);

        return redirect()->route('restaurant.orders.show', $order)
            ->with('success', 'Commande mise à jour avec succès');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('restaurant.orders.index')
            ->with('success', 'Commande supprimée avec succès');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Statut de la commande mis à jour');
    }
}
