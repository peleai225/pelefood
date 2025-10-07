<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu {{ $receipt_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.3;
            color: #333;
            background: #fff;
        }
        
        .receipt-container {
            max-width: 300px;
            margin: 0 auto;
            padding: 10px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #333;
        }
        
        .restaurant-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .restaurant-info {
            font-size: 9px;
            color: #666;
            margin-bottom: 3px;
        }
        
        .receipt-title {
            font-size: 14px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .receipt-details {
            margin-bottom: 15px;
        }
        
        .receipt-details p {
            margin-bottom: 2px;
            font-size: 10px;
        }
        
        .items-section {
            margin-bottom: 15px;
        }
        
        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
            font-size: 10px;
        }
        
        .item-name {
            flex: 1;
        }
        
        .item-qty {
            margin: 0 5px;
            text-align: center;
            min-width: 20px;
        }
        
        .item-price {
            text-align: right;
            min-width: 50px;
        }
        
        .divider {
            border-top: 1px dashed #333;
            margin: 10px 0;
        }
        
        .totals {
            margin-bottom: 15px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
            font-size: 10px;
        }
        
        .grand-total {
            font-weight: bold;
            font-size: 12px;
            border-top: 1px solid #333;
            padding-top: 5px;
            margin-top: 5px;
        }
        
        .footer {
            text-align: center;
            font-size: 9px;
            color: #666;
            margin-top: 20px;
        }
        
        .status {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-delivered {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- En-tête -->
        <div class="header">
            <div class="restaurant-name">{{ $restaurant->name ?? 'Restaurant' }}</div>
            <div class="restaurant-info">{{ $restaurant->address ?? '' }}</div>
            <div class="restaurant-info">{{ $restaurant->city ?? '' }}, {{ $restaurant->country ?? '' }}</div>
            <div class="restaurant-info">Tél: {{ $restaurant->phone ?? '' }}</div>
        </div>

        <div class="receipt-title">REÇU DE COMMANDE</div>

        <!-- Détails du reçu -->
        <div class="receipt-details">
            <p><strong>N° Reçu:</strong> {{ $receipt_number }}</p>
            <p><strong>Date:</strong> {{ $receipt_date }}</p>
            <p><strong>Commande:</strong> #{{ $order->order_number ?? $order->id }}</p>
            <p><strong>Client:</strong> {{ $customer->name ?? $order->customer_name ?? 'Client' }}</p>
            <p><strong>Statut:</strong> 
                <span class="status status-{{ $order->status ?? 'pending' }}">
                    {{ ucfirst($order->status ?? 'En attente') }}
                </span>
            </p>
        </div>

        <div class="divider"></div>

        <!-- Articles -->
        <div class="items-section">
            @foreach($items as $item)
            <div class="item-row">
                <div class="item-name">{{ $item->product_name ?? $item->product->name ?? 'Produit' }}</div>
                <div class="item-qty">{{ $item->quantity ?? 0 }}</div>
                <div class="item-price">{{ number_format($item->total_price ?? 0, 0, ',', ' ') }} F</div>
            </div>
            @endforeach
        </div>

        <div class="divider"></div>

        <!-- Totaux -->
        <div class="totals">
            <div class="total-row">
                <span>Sous-total:</span>
                <span>{{ number_format($order->subtotal ?? 0, 0, ',', ' ') }} FCFA</span>
            </div>
            @if($order->tax_amount && $order->tax_amount > 0)
            <div class="total-row">
                <span>Taxes:</span>
                <span>{{ number_format($order->tax_amount, 0, ',', ' ') }} FCFA</span>
            </div>
            @endif
            @if($order->delivery_fee && $order->delivery_fee > 0)
            <div class="total-row">
                <span>Livraison:</span>
                <span>{{ number_format($order->delivery_fee, 0, ',', ' ') }} FCFA</span>
            </div>
            @endif
            <div class="total-row grand-total">
                <span>TOTAL:</span>
                <span>{{ number_format($order->total_amount ?? 0, 0, ',', ' ') }} FCFA</span>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Pied de page -->
        <div class="footer">
            <p>Merci pour votre commande !</p>
            <p>Reçu généré le {{ Carbon\Carbon::now()->format('d/m/Y à H:i') }}</p>
            <p>Pour toute question: {{ $restaurant->phone ?? '' }}</p>
        </div>
    </div>
</body>
</html>
