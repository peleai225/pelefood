<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Réussi - PeleFood</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .success-animation {
            animation: successPulse 2s ease-in-out;
        }
        
        @keyframes successPulse {
            0% { transform: scale(0.8); opacity: 0; }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
        
        .checkmark {
            animation: checkmarkDraw 1s ease-in-out 0.5s both;
        }
        
        @keyframes checkmarkDraw {
            0% { stroke-dashoffset: 100; }
            100% { stroke-dashoffset: 0; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto">
            <!-- Carte de succès -->
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center success-animation">
                <!-- Icône de succès -->
                <div class="w-20 h-20 mx-auto mb-6 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-green-600 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                
                <!-- Titre -->
                <h1 class="text-3xl font-bold text-gray-900 mb-4">
                    Paiement Réussi !
                </h1>
                
                <!-- Message -->
                <p class="text-gray-600 mb-6">
                    Votre paiement a été traité avec succès. Vous recevrez bientôt une confirmation par email.
                </p>
                
                @if(isset($transaction))
                <!-- Détails de la transaction -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Référence:</span>
                            <span class="font-mono text-gray-900">{{ $transaction->transaction_id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Montant:</span>
                            <span class="font-semibold text-green-600">
                                {{ number_format($transaction->amount, 0, ',', ' ') }} {{ $transaction->currency }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Méthode:</span>
                            <span class="capitalize">{{ $transaction->payment_method }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date:</span>
                            <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Boutons d'action -->
                <div class="space-y-3">
                    <a href="{{ route('home') }}" 
                       class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center">
                        <i class="fas fa-home mr-2"></i>
                        Retour à l'accueil
                    </a>
                    
                    @if(isset($transaction) && $transaction->order)
                    <a href="{{ route('order.tracking', $transaction->order->order_number) }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center">
                        <i class="fas fa-truck mr-2"></i>
                        Suivre ma commande
                    </a>
                    @endif
                    
                    <a href="#" onclick="window.print()" 
                       class="w-full bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center">
                        <i class="fas fa-print mr-2"></i>
                        Imprimer le reçu
                    </a>
                </div>
            </div>
            
            <!-- Informations supplémentaires -->
            <div class="mt-8 text-center text-sm text-gray-500">
                <p class="mb-2">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Paiement sécurisé par {{ ucfirst($transaction->gateway_name ?? 'nos partenaires') }}
                </p>
                <p>
                    Besoin d'aide ? <a href="{{ route('contact') }}" class="text-blue-600 hover:underline">Contactez-nous</a>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Script pour redirection automatique après 10 secondes -->
    <script>
        setTimeout(function() {
            window.location.href = '{{ route("home") }}';
        }, 10000);
    </script>
</body>
</html>
