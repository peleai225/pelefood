<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Restaurant;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    /**
     * Afficher la facture d'une commande
     */
    public function show(Order $order)
    {
        $order->load(['restaurant', 'user', 'orderItems.product']);
        
        return view('invoices.show', compact('order'));
    }

    /**
     * Imprimer la facture en PDF
     */
    public function print(Order $order)
    {
        $order->load(['restaurant', 'user', 'orderItems.product']);
        
        // Données pour la facture
        $invoiceData = [
            'order' => $order,
            'restaurant' => $order->restaurant,
            'customer' => $order->user,
            'items' => $order->orderItems,
            'invoice_number' => 'INV-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
            'invoice_date' => Carbon::now()->format('d/m/Y'),
            'due_date' => Carbon::now()->addDays(7)->format('d/m/Y'),
        ];

        // Générer le PDF
        $pdf = Pdf::loadView('invoices.pdf', $invoiceData);
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'facture_' . $order->order_number ?? $order->id . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Aperçu de la facture (sans téléchargement)
     */
    public function preview(Order $order)
    {
        $order->load(['restaurant', 'user', 'orderItems.product']);
        
        $invoiceData = [
            'order' => $order,
            'restaurant' => $order->restaurant,
            'customer' => $order->user,
            'items' => $order->orderItems,
            'invoice_number' => 'INV-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
            'invoice_date' => Carbon::now()->format('d/m/Y'),
            'due_date' => Carbon::now()->addDays(7)->format('d/m/Y'),
        ];

        $pdf = Pdf::loadView('invoices.pdf', $invoiceData);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream('facture_' . $order->order_number ?? $order->id . '.pdf');
    }

    /**
     * Imprimer le reçu de commande
     */
    public function receipt(Order $order)
    {
        $order->load(['restaurant', 'user', 'orderItems.product']);
        
        $receiptData = [
            'order' => $order,
            'restaurant' => $order->restaurant,
            'customer' => $order->user,
            'items' => $order->orderItems,
            'receipt_number' => 'REC-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
            'receipt_date' => Carbon::now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('invoices.receipt', $receiptData);
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'recu_' . $order->order_number ?? $order->id . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Imprimer le ticket de caisse
     */
    public function ticket(Order $order)
    {
        $order->load(['restaurant', 'user', 'orderItems.product']);
        
        $ticketData = [
            'order' => $order,
            'restaurant' => $order->restaurant,
            'customer' => $order->user,
            'items' => $order->orderItems,
            'ticket_number' => 'TKT-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
            'ticket_date' => Carbon::now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('invoices.ticket', $ticketData);
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'ticket_' . $order->order_number ?? $order->id . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Liste des factures pour un restaurant
     */
    public function index(Request $request)
    {
        $restaurant = Restaurant::findOrFail($request->restaurant_id);
        
        $orders = Order::where('restaurant_id', $restaurant->id)
            ->with(['user', 'orderItems'])
            ->latest()
            ->paginate(20);

        return view('invoices.index', compact('orders', 'restaurant'));
    }
}