<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu - Commande #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .receipt {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        .content {
            padding: 20px;
        }
        .order-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .info-row:last-child {
            margin-bottom: 0;
        }
        .label {
            font-weight: 600;
            color: #6c757d;
        }
        .value {
            color: #212529;
        }
        .items {
            margin-bottom: 20px;
        }
        .item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .item:last-child {
            border-bottom: none;
        }
        .item-name {
            font-weight: 500;
        }
        .item-price {
            color: #28a745;
            font-weight: 600;
        }
        .total {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #1976d2;
            margin: 0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            color: #6c757d;
            font-size: 12px;
        }
        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d4edda; color: #155724; }
        .status-preparing { background: #d1ecf1; color: #0c5460; }
        .status-ready { background: #f8d7da; color: #721c24; }
        .status-delivered { background: #d1ecf1; color: #0c5460; }
        .status-completed { background: #d4edda; color: #155724; }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h1>🍽️ PeleFood</h1>
            <p>Votre reçu de commande</p>
        </div>
        
        <div class="content">
            <div class="order-info">
                <div class="info-row">
                    <span class="label">Numéro de commande :</span>
                    <span class="value">#{{ $order->order_number }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Date :</span>
                    <span class="value">{{ $order->created_at->format('d/m/Y à H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Restaurant :</span>
                    <span class="value">{{ $restaurant->name ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Client :</span>
                    <span class="value">{{ $customer->name ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Statut :</span>
                    <span class="value">
                        <span class="status status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </span>
                </div>
            </div>

            @if($order->orderItems && $order->orderItems->count() > 0)
                <div class="items">
                    <h3 style="margin: 0 0 15px 0; color: #495057;">Articles commandés</h3>
                    @foreach($order->orderItems as $item)
                        <div class="item">
                            <div>
                                <div class="item-name">{{ $item->product->name ?? 'Produit' }}</div>
                                <div style="font-size: 12px; color: #6c757d;">
                                    Quantité: {{ $item->quantity }} × {{ \App\Helpers\SettingsHelper::formatAmount($item->price) }}
                                </div>
                            </div>
                            <div class="item-price">
                                {{ \App\Helpers\SettingsHelper::formatAmount($item->quantity * $item->price) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="total">
                <p style="margin: 0 0 5px 0; color: #6c757d;">Total de la commande</p>
                <p class="total-amount">{{ \App\Helpers\SettingsHelper::formatAmount($order->total_amount) }}</p>
            </div>
        </div>

        <div class="footer">
            <p>Merci pour votre commande !</p>
            <p>PeleFood - Votre partenaire de livraison de confiance</p>
            <p>Généré le {{ now()->format('d/m/Y à H:i') }}</p>
        </div>
    </div>
</body>
</html>
