<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu - Commande {{ $order->order_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .receipt {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .restaurant-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        .restaurant-info {
            color: #666;
            font-size: 14px;
            line-height: 1.4;
        }
        .order-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .order-number {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .order-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            font-size: 14px;
        }
        .info-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .info-label {
            font-weight: bold;
            color: #666;
            min-width: 80px;
        }
        .info-value {
            color: #333;
        }
        .items-section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 8px;
        }
        .item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f3f4;
        }
        .item:last-child {
            border-bottom: none;
        }
        .item-details {
            flex: 1;
        }
        .item-name {
            font-weight: bold;
            color: #333;
            margin-bottom: 4px;
        }
        .item-quantity {
            color: #666;
            font-size: 14px;
        }
        .item-price {
            font-weight: bold;
            color: #333;
            text-align: right;
        }
        .total-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .total-row:last-child {
            margin-bottom: 0;
            border-top: 2px solid #e9ecef;
            padding-top: 15px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #666;
            font-size: 12px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d1ecf1; color: #0c5460; }
        .status-preparing { background: #f8d7da; color: #721c24; }
        .status-ready { background: #d4edda; color: #155724; }
        .status-delivered { background: #d1ecf1; color: #0c5460; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        
        @media print {
            body { background: white; }
            .receipt { box-shadow: none; }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <!-- En-tête du restaurant -->
        <div class="header">
            <div class="restaurant-name">{{ $order->restaurant->name }}</div>
            <div class="restaurant-info">
                {{ $order->restaurant->address }}, {{ $order->restaurant->city }}<br>
                📞 {{ $order->restaurant->phone }} | 📧 {{ $order->restaurant->email }}
            </div>
        </div>

        <!-- Détails de la commande -->
        <div class="order-details">
            <div class="order-number">Commande #{{ $order->order_number }}</div>
            <div class="order-info">
                <div class="info-item">
                    <span class="info-label">📅 Date:</span>
                    <span class="info-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">👤 Client:</span>
                    <span class="info-value">{{ $order->customer_name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">📱 Téléphone:</span>
                    <span class="info-value">{{ $order->customer_phone }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">📍 Type:</span>
                    <span class="info-value">
                        @switch($order->type)
                            @case('on_site')
                                🏪 Sur place
                                @break
                            @case('takeaway')
                                📦 À emporter
                                @break
                            @case('delivery')
                                🚚 Livraison
                                @break
                            @default
                                {{ ucfirst($order->type) }}
                        @endswitch
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">📊 Statut:</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </span>
                </div>
                @if($order->customer_address)
                <div class="info-item">
                    <span class="info-label">🏠 Adresse:</span>
                    <span class="info-value">{{ $order->customer_address }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Articles commandés -->
        <div class="items-section">
            <div class="section-title">📋 Articles commandés</div>
            @foreach($order->items as $item)
            <div class="item">
                <div class="item-details">
                    <div class="item-name">{{ $item->product_name }}</div>
                    <div class="item-quantity">Quantité: {{ $item->quantity }}</div>
                </div>
                <div class="item-price">{{ number_format($item->total_price, 2) }} €</div>
            </div>
            @endforeach
        </div>

        <!-- Instructions spéciales -->
        @if($order->special_instructions)
        <div class="items-section">
            <div class="section-title">📝 Instructions spéciales</div>
            <div style="padding: 15px; background: #f8f9fa; border-radius: 8px; color: #333;">
                {{ $order->special_instructions }}
            </div>
        </div>
        @endif

        <!-- Résumé et total -->
        <div class="total-section">
            <div class="total-row">
                <span>Sous-total:</span>
                <span>{{ number_format($order->subtotal, 2) }} €</span>
            </div>
            @if($order->delivery_fee > 0)
            <div class="total-row">
                <span>Frais de livraison:</span>
                <span>{{ number_format($order->delivery_fee, 2) }} €</span>
            </div>
            @endif
            <div class="total-row">
                <span>Total:</span>
                <span>{{ number_format($order->total, 2) }} €</span>
            </div>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <p>Merci pour votre commande ! 🎉</p>
            <p>Pour toute question, contactez-nous au {{ $order->restaurant->phone }}</p>
            <p>Reçu généré le {{ now()->format('d/m/Y à H:i') }}</p>
        </div>
    </div>

    <script>
        // Auto-impression si le paramètre print=1 est présent
        if (window.location.search.includes('print=1')) {
            window.print();
        }
    </script>
</body>
</html> 