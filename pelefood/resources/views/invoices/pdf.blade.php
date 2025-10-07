<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture {{ $invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: #fff;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e74c3c;
        }
        
        .restaurant-info h1 {
            color: #e74c3c;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .restaurant-info p {
            margin-bottom: 5px;
            color: #666;
        }
        
        .invoice-details {
            text-align: right;
        }
        
        .invoice-details h2 {
            color: #e74c3c;
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .invoice-details p {
            margin-bottom: 3px;
        }
        
        .billing-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .billing-info {
            width: 48%;
        }
        
        .billing-info h3 {
            color: #e74c3c;
            font-size: 14px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        
        .billing-info p {
            margin-bottom: 3px;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .items-table th {
            background-color: #e74c3c;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
        }
        
        .items-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #eee;
        }
        
        .items-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .totals-section {
            margin-left: auto;
            width: 300px;
        }
        
        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .totals-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #eee;
        }
        
        .totals-table .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .totals-table .grand-total {
            background-color: #e74c3c;
            color: white;
            font-size: 14px;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-confirmed {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .status-delivered {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- En-tête -->
        <div class="header">
            <div class="restaurant-info">
                <h1>{{ $restaurant->name ?? 'Restaurant' }}</h1>
                <p>{{ $restaurant->address ?? '' }}</p>
                <p>{{ $restaurant->city ?? '' }}, {{ $restaurant->country ?? '' }}</p>
                <p>Tél: {{ $restaurant->phone ?? '' }}</p>
                <p>Email: {{ $restaurant->email ?? '' }}</p>
            </div>
            
            <div class="invoice-details">
                <h2>FACTURE</h2>
                <p><strong>N° Facture:</strong> {{ $invoice_number }}</p>
                <p><strong>Date:</strong> {{ $invoice_date }}</p>
                <p><strong>Échéance:</strong> {{ $due_date }}</p>
                <p><strong>Commande:</strong> #{{ $order->order_number ?? $order->id }}</p>
                <p><strong>Statut:</strong> 
                    <span class="status-badge status-{{ $order->status ?? 'pending' }}">
                        {{ ucfirst($order->status ?? 'En attente') }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Informations de facturation -->
        <div class="billing-section">
            <div class="billing-info">
                <h3>Facturé à:</h3>
                <p><strong>{{ $customer->name ?? $order->customer_name ?? 'Client' }}</strong></p>
                <p>{{ $order->customer_phone ?? '' }}</p>
                <p>{{ $order->customer_email ?? '' }}</p>
                @if($order->delivery_address)
                    <p>{{ $order->delivery_address['address'] ?? '' }}</p>
                    <p>{{ $order->delivery_address['city'] ?? '' }}</p>
                @endif
            </div>
            
            <div class="billing-info">
                <h3>Informations de livraison:</h3>
                <p><strong>Méthode:</strong> {{ ucfirst($order->delivery_method ?? 'Livraison') }}</p>
                <p><strong>Date commande:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                @if($order->estimated_delivery_time)
                    <p><strong>Livraison prévue:</strong> {{ Carbon\Carbon::parse($order->estimated_delivery_time)->format('d/m/Y H:i') }}</p>
                @endif
                @if($order->special_instructions)
                    <p><strong>Instructions:</strong> {{ $order->special_instructions }}</p>
                @endif
            </div>
        </div>

        <!-- Tableau des articles -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Description</th>
                    <th class="text-center">Qté</th>
                    <th class="text-right">Prix unitaire</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item->product_name ?? $item->product->name ?? 'Produit' }}</td>
                    <td>{{ Str::limit($item->product->description ?? '', 50) }}</td>
                    <td class="text-center">{{ $item->quantity ?? 0 }}</td>
                    <td class="text-right">{{ number_format($item->unit_price ?? 0, 0, ',', ' ') }} FCFA</td>
                    <td class="text-right">{{ number_format($item->total_price ?? 0, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totaux -->
        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td>Sous-total:</td>
                    <td class="text-right">{{ number_format($order->subtotal ?? 0, 0, ',', ' ') }} FCFA</td>
                </tr>
                @if($order->tax_amount && $order->tax_amount > 0)
                <tr>
                    <td>Taxes:</td>
                    <td class="text-right">{{ number_format($order->tax_amount, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endif
                @if($order->delivery_fee && $order->delivery_fee > 0)
                <tr>
                    <td>Frais de livraison:</td>
                    <td class="text-right">{{ number_format($order->delivery_fee, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td><strong>Total:</strong></td>
                    <td class="text-right"><strong>{{ number_format($order->total_amount ?? 0, 0, ',', ' ') }} FCFA</strong></td>
                </tr>
            </table>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <p>Merci pour votre commande !</p>
            <p>Cette facture a été générée automatiquement le {{ Carbon\Carbon::now()->format('d/m/Y à H:i') }}</p>
            <p>Pour toute question, contactez-nous au {{ $restaurant->phone ?? '' }}</p>
        </div>
    </div>
</body>
</html>
