<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .restaurant-info {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .customer-info, .invoice-info {
            flex: 1;
        }
        .invoice-info {
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        .total-row {
            margin: 5px 0;
        }
        .total-amount {
            font-size: 18px;
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 10px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-draft { background-color: #f0f0f0; color: #666; }
        .status-sent { background-color: #e3f2fd; color: #1976d2; }
        .status-paid { background-color: #e8f5e8; color: #388e3c; }
        .status-overdue { background-color: #ffebee; color: #d32f2f; }
        .status-cancelled { background-color: #fafafa; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>FACTURE</h1>
        <div class="restaurant-info">
            <h2>{{ $restaurant->name }}</h2>
            @if($restaurant->address)
                <p>{{ $restaurant->address }}, {{ $restaurant->city }}</p>
            @endif
            @if($restaurant->phone)
                <p>Tél: {{ $restaurant->phone }}</p>
            @endif
            @if($restaurant->email)
                <p>Email: {{ $restaurant->email }}</p>
            @endif
        </div>
    </div>

    <div class="invoice-details">
        <div class="customer-info">
            <h3>Client</h3>
            <p><strong>{{ $invoice->customer_name }}</strong></p>
            @if($invoice->customer_email)
                <p>Email: {{ $invoice->customer_email }}</p>
            @endif
            @if($invoice->customer_phone)
                <p>Téléphone: {{ $invoice->customer_phone }}</p>
            @endif
            @if($invoice->customer_address)
                <p>Adresse: {{ $invoice->customer_address }}</p>
            @endif
        </div>
        <div class="invoice-info">
            <h3>Détails de la facture</h3>
            <p><strong>Numéro:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Date:</strong> {{ $invoice->created_at->format('d/m/Y') }}</p>
            @if($invoice->due_date)
                <p><strong>Échéance:</strong> {{ $invoice->due_date->format('d/m/Y') }}</p>
            @endif
            <p><strong>Statut:</strong> 
                <span class="status-badge status-{{ $invoice->status }}">
                    @switch($invoice->status)
                        @case('draft') Brouillon @break
                        @case('sent') Envoyée @break
                        @case('paid') Payée @break
                        @case('overdue') En retard @break
                        @case('cancelled') Annulée @break
                    @endswitch
                </span>
            </p>
            <p><strong>Paiement:</strong> 
                @switch($invoice->payment_status)
                    @case('unpaid') Non payé @break
                    @case('partial') Partiel @break
                    @case('paid') Payé @break
                @endswitch
            </p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>
                    <strong>{{ $item->product_name }}</strong>
                    @if($item->product_description)
                        <br><small>{{ $item->product_description }}</small>
                    @endif
                </td>
                <td>{{ $item->quantity }}</td>
                                        <td>{{ $restaurant->formatPrice($item->unit_price) }}</td>
                        <td>{{ $restaurant->formatPrice($item->total_price) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <span>Sous-total:</span>
            <span>{{ number_format($invoice->subtotal, 0, ',', ' ') }} FCFA</span>
        </div>
        @if($invoice->tax_amount > 0)
        <div class="total-row">
            <span>Taxes:</span>
            <span>{{ number_format($invoice->tax_amount, 0, ',', ' ') }} FCFA</span>
        </div>
        @endif
        @if($invoice->delivery_fee > 0)
        <div class="total-row">
            <span>Livraison:</span>
            <span>{{ number_format($invoice->delivery_fee, 0, ',', ' ') }} FCFA</span>
        </div>
        @endif
        @if($invoice->discount_amount > 0)
        <div class="total-row">
            <span>Remise:</span>
            <span>-{{ number_format($invoice->discount_amount, 0, ',', ' ') }} FCFA</span>
        </div>
        @endif
        <div class="total-row total-amount">
            <span><strong>TOTAL:</strong></span>
            <span><strong>{{ number_format($invoice->total_amount, 0, ',', ' ') }} FCFA</strong></span>
        </div>
    </div>

    @if($invoice->notes)
    <div style="margin-top: 30px;">
        <h4>Notes:</h4>
        <p>{{ $invoice->notes }}</p>
    </div>
    @endif

    @if($invoice->terms)
    <div style="margin-top: 30px;">
        <h4>Conditions:</h4>
        <p>{{ $invoice->terms }}</p>
    </div>
    @endif

    <div class="footer">
        <p>Merci pour votre confiance !</p>
        <p>{{ $restaurant->name }} - {{ $restaurant->address ?? '' }}</p>
        <p>Facture générée le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>
</body>
</html> 