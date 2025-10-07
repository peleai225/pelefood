<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle commande #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .order-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #f97316;
        }
        .order-number {
            font-size: 24px;
            font-weight: bold;
            color: #f97316;
            margin-bottom: 10px;
        }
        .customer-info {
            background: #f0f9ff;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
        .items-list {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 15px 0;
        }
        .item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .item:last-child {
            border-bottom: none;
        }
        .total {
            background: #f97316;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background: #f97316;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 10px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🍽️ Nouvelle commande reçue !</h1>
        <p>{{ $restaurant->name }}</p>
    </div>
    
    <div class="content">
        <div class="order-details">
            <div class="order-number">Commande #{{ $order->order_number }}</div>
            <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y à H:i') }}</p>
            <p><strong>Type :</strong> {{ ucfirst($order->type) }}</p>
            <p><strong>Statut :</strong> {{ ucfirst($order->status) }}</p>
        </div>
        
        <div class="customer-info">
            <h3>👤 Informations client</h3>
            <p><strong>Nom :</strong> {{ $order->customer_name }}</p>
            <p><strong>Téléphone :</strong> {{ $order->customer_phone }}</p>
            @if($order->customer_email)
                <p><strong>Email :</strong> {{ $order->customer_email }}</p>
            @endif
            @if($order->delivery_address)
                <p><strong>Adresse :</strong> 
                    @if(is_array($order->delivery_address))
                        {{ $order->delivery_address['address'] ?? 'Adresse non renseignée' }}
                        @if(isset($order->delivery_address['city']))
                            - {{ $order->delivery_address['city'] }}
                        @endif
                    @else
                        {{ $order->delivery_address }}
                    @endif
                </p>
            @endif
            @if($order->special_instructions)
                <p><strong>Instructions spéciales :</strong> {{ $order->special_instructions }}</p>
            @endif
        </div>
        
        <div class="items-list">
            <h3>🛒 Articles commandés</h3>
            @foreach($order->items as $item)
                <div class="item">
                    <div>
                        <strong>{{ $item->product_name }}</strong>
                        @if($item->special_instructions)
                            <br><small>{{ $item->special_instructions }}</small>
                        @endif
                        @if($item->options)
                            <br><small>
                                @foreach($item->options as $group => $selections)
                                    {{ $group }}: {{ is_array($selections) ? implode(', ', $selections) : $selections }}
                                @endforeach
                            </small>
                        @endif
                    </div>
                    <div>
                        {{ $item->quantity }} × {{ $restaurant->formatPrice($item->unit_price) }}
                        <br><strong>{{ $restaurant->formatPrice($item->total_price) }}</strong>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="total">
            <div>Total de la commande : {{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</div>
            <div style="font-size: 14px; margin-top: 5px;">
                Sous-total: {{ number_format($order->subtotal, 0, ',', ' ') }} FCFA
                @if($order->delivery_fee > 0)
                    | Livraison: {{ number_format($order->delivery_fee, 0, ',', ' ') }} FCFA
                @endif
            </div>
        </div>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/restaurant/orders/' . $order->id) }}" class="button">
                👁️ Voir les détails de la commande
            </a>
        </div>
        
        <div style="background: #f0f9ff; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <h4>📋 Actions rapides</h4>
            <p>• Confirmer la commande</p>
            <p>• Commencer la préparation</p>
            <p>• Contacter le client si nécessaire</p>
        </div>
    </div>
    
    <div class="footer">
        <p>Cet email a été envoyé automatiquement par PeleFood</p>
        <p>Restaurant : {{ $restaurant->name }}</p>
        <p>Date : {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html> 