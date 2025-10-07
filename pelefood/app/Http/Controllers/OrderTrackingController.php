<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Support\Facades\View;
use PDF;

class OrderTrackingController extends Controller
{
    /**
     * Afficher la page de suivi de commande
     */
    public function track($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        
        return view('restaurant.public.tracking', compact('order'));
    }
    
    /**
     * Mettre à jour le statut de la commande (AJAX)
     */
    public function updateStatus(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        $order->status = $request->status;
        $order->save();
        
        return response()->json([
            'success' => true,
            'status' => $order->status,
            'message' => 'Statut mis à jour avec succès'
        ]);
    }
    
    /**
     * Générer et télécharger le reçu PDF
     */
    public function downloadReceipt($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        
        // Charger la vue sans Font Awesome pour éviter les problèmes de polices
        $pdf = PDF::loadView('restaurant.public.receipt', compact('order'));
        
        // Configuration PDF pour éviter les problèmes de polices
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => false,
            'defaultFont' => 'Arial',
            'chroot' => public_path(),
        ]);
        
        return $pdf->download("recu-commande-{$orderNumber}.pdf");
    }
    
    /**
     * Afficher le reçu pour impression
     */
    public function showReceipt($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        
        return view('restaurant.public.receipt', compact('order'));
    }
    
    /**
     * Vérifier le statut d'une commande
     */
    public function checkStatus(Request $request)
    {
        $orderNumber = $request->order_number;
        $order = Order::where('order_number', $orderNumber)->first();
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'order' => $order,
            'status' => $order->status,
            'estimated_time' => $order->estimated_delivery_time
        ]);
    }
}
