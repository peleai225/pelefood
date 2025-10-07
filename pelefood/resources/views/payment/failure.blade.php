<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Échoué - PeleFood</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .failure-animation {
            animation: failureShake 0.8s ease-in-out;
        }
        
        @keyframes failureShake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        .error-icon {
            animation: errorPulse 2s ease-in-out infinite;
        }
        
        @keyframes errorPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-red-50 to-pink-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto">
            <!-- Carte d'échec -->
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center failure-animation">
                <!-- Icône d'échec -->
                <div class="w-20 h-20 mx-auto mb-6 bg-red-100 rounded-full flex items-center justify-center error-icon">
                    <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                
                <!-- Titre -->
                <h1 class="text-3xl font-bold text-gray-900 mb-4">
                    Paiement Échoué
                </h1>
                
                <!-- Message d'erreur -->
                <p class="text-gray-600 mb-6">
                    {{ $error ?? 'Une erreur est survenue lors du traitement de votre paiement. Veuillez réessayer.' }}
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
                            <span class="font-semibold text-red-600">
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
                
                <!-- Solutions possibles -->
                <div class="bg-blue-50 rounded-lg p-4 mb-6 text-left">
                    <h3 class="font-semibold text-blue-900 mb-2">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Solutions possibles :
                    </h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Vérifiez que votre carte est valide et non expirée</li>
                        <li>• Assurez-vous d'avoir suffisamment de fonds</li>
                        <li>• Vérifiez les informations de paiement</li>
                        <li>• Essayez une autre méthode de paiement</li>
                    </ul>
                </div>
                
                <!-- Boutons d'action -->
                <div class="space-y-3">
                    <button onclick="history.back()" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Réessayer le paiement
                    </button>
                    
                    <a href="{{ route('home') }}" 
                       class="w-full bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center">
                        <i class="fas fa-home mr-2"></i>
                        Retour à l'accueil
                    </a>
                    
                    <a href="{{ route('contact') }}" 
                       class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center">
                        <i class="fas fa-headset mr-2"></i>
                        Besoin d'aide ?
                    </a>
                </div>
            </div>
            
            <!-- Informations de sécurité -->
            <div class="mt-8 text-center text-sm text-gray-500">
                <p class="mb-2">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Vos informations de paiement sont sécurisées
                </p>
                <p>
                    Aucun montant n'a été débité de votre compte
                </p>
            </div>
        </div>
    </div>
    
    <!-- Script pour redirection automatique après 15 secondes -->
    <script>
        setTimeout(function() {
            window.location.href = '{{ route("home") }}';
        }, 15000);
    </script>
</body>
</html>
