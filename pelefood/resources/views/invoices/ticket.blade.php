<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket {{ $ticket_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            line-height: 1.2;
            color: #000;
            background: #fff;
        }
        
        .ticket-container {
            max-width: 250px;
            margin: 0 auto;
            padding: 5px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
        }
        
        .restaurant-name {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .restaurant-info {
            font-size: 8px;
            margin-bottom: 2px;
        }
        
        .ticket-title {
            font-size: 11px;
            font-weight: bold;
            margin: 8px 0;
            text-align: center;
        }
        
        .ticket-details {
            margin-bottom: 10px;
            font-size: 9px;
        }
        
        .ticket-details p {
            margin-bottom: 1px;
        }
        
        .items-section {
            margin-bottom: 10px;
        }
        
        .item-row {
            margin-bottom: 2px;
            font-size: 9px;
        }
        
        .item-name {
            font-weight: bold;
        }
        
        .item-details {
            margin-left: 10px;
            font-size: 8px;
        }
        
        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }
        
        .totals {
            margin-bottom: 10px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1px;
            font-size: 9px;
        }
        
        .grand-total {
            font-weight: bold;
            font-size: 10px;
            border-top: 1px solid #000;
            padding-top: 3px;
            margin-top: 3px;
        }
        
        .footer {
            text-align: center;
            font-size: 8px;
            margin-top: 15px;
            border-top: 1px dashed #000;
            padding-top: 8px;
        }
        
        .barcode {
            text-align: center;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
            font-size: 8px;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <!-- En-tête -->
        <div class="header">
            <div class="restaurant-name">{{ $restaurant->name ?? 'RESTAURANT' }}</div>
            <div class="restaurant-info">{{ $restaurant->address ?? '' }}</div>
            <div class="restaurant-info">{{ $restaurant->city ?? '' }}, {{ $restaurant->country ?? '' }}</div>
            <div class="restaurant-info">TEL: {{ $restaurant->phone ?? '' }}</div>
        </div>

        <div class="ticket-title">TICKET DE COMMANDE</div>

        <!-- Détails du ticket -->
        <div class="ticket-details">
            <p>N°: {{ $ticket_number }}</p>
            <p>Date: {{ $ticket_date }}</p>
            <p>Commande: #{{ $order->order_number ?? $order->id }}</p>
            <p>Client: {{ $customer->name ?? $order->customer_name ?? 'CLIENT' }}</p>
            <p>Statut: {{ strtoupper($order->status ?? 'EN ATTENTE') }}</p>
        </div>

        <div class="divider"></div>

        <!-- Articles -->
        <div class="items-section">
            @foreach($items as $item)
            <div class="item-row">
                <div class="item-name">{{ $item->product_name ?? $item->product->name ?? 'PRODUIT' }}</div>
                <div class="item-details">
                    {{ $item->quantity ?? 0 }} x {{ number_format($item->unit_price ?? 0, 0, ',', ' ') }} F
                    = {{ number_format($item->total_price ?? 0, 0, ',', ' ') }} F
                </div>
            </div>
            @endforeach
        </div>

        <div class="divider"></div>

        <!-- Totaux -->
        <div class="totals">
            <div class="total-row">
                <span>SOUS-TOTAL:</span>
                <span>{{ number_format($order->subtotal ?? 0, 0, ',', ' ') }} F</span>
            </div>
            @if($order->tax_amount && $order->tax_amount > 0)
            <div class="total-row">
                <span>TAXES:</span>
                <span>{{ number_format($order->tax_amount, 0, ',', ' ') }} F</span>
            </div>
            @endif
            @if($order->delivery_fee && $order->delivery_fee > 0)
            <div class="total-row">
                <span>LIVRAISON:</span>
                <span>{{ number_format($order->delivery_fee, 0, ',', ' ') }} F</span>
            </div>
            @endif
            <div class="total-row grand-total">
                <span>TOTAL:</span>
                <span>{{ number_format($order->total_amount ?? 0, 0, ',', ' ') }} F</span>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Code-barres simulé -->
        <div class="barcode">
            <p>||||| {{ $order->id }} |||||</p>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <p>MERCI POUR VOTRE COMMANDE</p>
            <p>Ticket généré le {{ Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
            <p>Pour toute question: {{ $restaurant->phone ?? '' }}</p>
        </div>
    </div>
</body>
</html>
