<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de commande - {{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .order-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }
        .order-info h3 {
            margin-top: 0;
            color: #ff6b35;
            font-size: 18px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #555;
        }
        .info-value {
            color: #333;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .items-table th,
        .items-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .items-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #555;
        }
        .total-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .total-row.final {
            font-size: 20px;
            font-weight: bold;
            color: #ff6b35;
            border-top: 2px solid #ff6b35;
            padding-top: 15px;
            margin-top: 15px;
        }
        .footer {
            background: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .footer a {
            color: #ff6b35;
            text-decoration: none;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d4edda; color: #155724; }
        .status-preparing { background: #cce5ff; color: #004085; }
        .status-ready { background: #d1ecf1; color: #0c5460; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🍽️ PeleFood</h1>
            <p>Votre reçu de commande</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Merci pour votre commande !</h2>
            <p>Votre commande a été reçue avec succès. Voici les détails de votre commande :</p>

            <!-- Order Information -->
            <div class="order-info">
                <h3>📋 Informations de la commande</h3>
                <div class="info-row">
                    <span class="info-label">Numéro de commande :</span>
                    <span class="info-value">{{ $order->order_number }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Restaurant :</span>
                    <span class="info-value">{{ $order->restaurant->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date :</span>
                    <span class="info-value">{{ $order->created_at->format('d/m/Y à H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Statut :</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </span>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="order-info">
                <h3>👤 Informations client</h3>
                <div class="info-row">
                    <span class="info-label">Nom :</span>
                    <span class="info-value">{{ $order->customer_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Téléphone :</span>
                    <span class="info-value">{{ $order->customer_phone }}</span>
                </div>
                @if($order->customer_email)
                <div class="info-row">
                    <span class="info-label">Email :</span>
                    <span class="info-value">{{ $order->customer_email }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Adresse de livraison :</span>
                    <span class="info-value">{{ $order->delivery_address }}</span>
                </div>
                @if($order->notes)
                <div class="info-row">
                    <span class="info-label">Notes :</span>
                    <span class="info-value">{{ $order->notes }}</span>
                </div>
                @endif
            </div>

            <!-- Order Items -->
            <h3>🍕 Articles commandés</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price, 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($item->total_price, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Total Section -->
            <div class="total-section">
                <div class="total-row">
                    <span>Sous-total :</span>
                    <span>{{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</span>
                </div>
                @if($order->tax_amount > 0)
                <div class="total-row">
                    <span>Taxes :</span>
                    <span>{{ number_format($order->tax_amount, 0, ',', ' ') }} FCFA</span>
                </div>
                @endif
                @if($order->delivery_fee > 0)
                <div class="total-row">
                    <span>Frais de livraison :</span>
                    <span>{{ number_format($order->delivery_fee, 0, ',', ' ') }} FCFA</span>
                </div>
                @endif
                <div class="total-row final">
                    <span>Total :</span>
                    <span>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>

            @if($order->status === 'pending')
            <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 15px; margin-top: 20px;">
                <h4 style="margin-top: 0; color: #856404;">⏳ En attente de confirmation</h4>
                <p style="margin-bottom: 0; color: #856404;">
                    Votre commande est en cours de traitement. Le restaurant vous contactera bientôt pour confirmer la commande.
                </p>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>PeleFood</strong> - Votre partenaire de livraison de nourriture</p>
            <p>
                <a href="{{ config('app.url') }}">Visitez notre site</a> | 
                <a href="mailto:support@pelefood.com">Support</a> | 
                <a href="tel:+225123456789">+225 12 34 56 789</a>
            </p>
        </div>
    </div>
</body>
</html>
