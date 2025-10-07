<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande confirmée - {{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .confirmation-card {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }
        
        .confirmation-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .success-animation {
            animation: successPulse 2s ease-in-out infinite;
        }
        
        @keyframes successPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .action-button {
            transition: all 0.3s ease;
        }
        
        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-4">
                    <a href="/restaurant/{{ $order->restaurant->slug }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour au restaurant
                    </a>
                </div>
                <div class="text-center">
                    <h1 class="text-xl font-bold text-gray-900">Commande confirmée</h1>
                    <p class="text-sm text-green-600 font-medium">Numéro: {{ $order->order_number }}</p>
                </div>
                <div class="w-24"></div>
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Message de succès principal -->
        <div class="text-center mb-12">
            <div class="success-animation inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-6">
                <i class="fas fa-check text-5xl text-green-600"></i>
            </div>
            
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Commande confirmée !</h1>
            <p class="text-xl text-gray-600 mb-2">Votre commande a été reçue avec succès</p>
            <p class="text-lg text-green-600 font-semibold">Numéro de commande: {{ $order->order_number }}</p>
        </div>

        <!-- Carte de confirmation principale -->
        <div class="confirmation-card bg-white rounded-2xl p-8 mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Informations de la commande -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                        <i class="fas fa-receipt text-blue-600 mr-3"></i>
                        Détails de la commande
                    </h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Restaurant:</span>
                            <span class="font-semibold">{{ $order->restaurant->name }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Date:</span>
                            <span class="font-semibold">{{ $order->created_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Type:</span>
                            <span class="font-semibold">
                                @switch($order->type)
                                    @case('on_site')
                                        <i class="fas fa-utensils mr-2"></i>Sur place
                                        @break
                                    @case('delivery')
                                        <i class="fas fa-truck mr-2"></i>Livraison
                                        @break
                                    @case('takeaway')
                                        <i class="fas fa-shopping-bag mr-2"></i>À emporter
                                        @break
                                @endswitch
                            </span>
                        </div>
                        
                        @if($order->estimated_delivery_time)
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Temps estimé:</span>
                            <span class="font-semibold text-blue-600">{{ $order->estimated_delivery_time }}</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between text-xl font-bold border-t border-gray-200 pt-4">
                            <span>Total:</span>
                            <span class="text-green-600">{{ number_format($order->total_amount) }} FCFA</span>
                        </div>
                    </div>
                </div>
                
                <!-- Informations client -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                        <i class="fas fa-user text-green-600 mr-3"></i>
                        Vos informations
                    </h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Nom:</span>
                            <span class="font-semibold">{{ $order->customer_name }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Téléphone:</span>
                            <span class="font-semibold">{{ $order->customer_phone }}</span>
                        </div>
                        
                        @if($order->customer_email)
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Email:</span>
                            <span class="font-semibold">{{ $order->customer_email }}</span>
                        </div>
                        @endif
                        
                        @if($order->delivery_address)
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Adresse:</span>
                            <span class="font-semibold">
                                @if(is_array($order->delivery_address))
                                    {{ $order->delivery_address['address'] ?? 'Adresse non renseignée' }}
                                    @if(isset($order->delivery_address['city']))
                                        <br><span class="text-xs text-gray-500">{{ $order->delivery_address['city'] }}</span>
                                    @endif
                                @else
                                    {{ $order->delivery_address }}
                                @endif
                            </span>
                        </div>
                        @endif
                        
                        @if($order->special_instructions)
                        <div class="flex justify-between">
                            <span class="text-gray-600 font-medium">Instructions:</span>
                            <span class="font-semibold">{{ $order->special_instructions }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions principales -->
        <div class="confirmation-card bg-white rounded-2xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">
                <i class="fas fa-tasks text-purple-600 mr-3"></i>
                Que souhaitez-vous faire maintenant ?
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Suivre ma commande -->
                <a href="{{ route('order.tracking', $order->order_number) }}" 
                   class="action-button bg-blue-600 text-white p-6 rounded-xl text-center hover:bg-blue-700 transition-all">
                    <div class="text-3xl mb-3">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Suivre ma commande</h3>
                    <p class="text-sm opacity-90">Voir le statut en temps réel</p>
                </a>
                
                <!-- Imprimer le reçu -->
                <a href="{{ route('order.receipt', $order->order_number) }}" 
                   class="action-button bg-green-600 text-white p-6 rounded-xl text-center hover:bg-green-700 transition-all">
                    <div class="text-3xl mb-3">
                        <i class="fas fa-print"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Imprimer le reçu</h3>
                    <p class="text-sm opacity-90">Télécharger en PDF</p>
                </a>
                
                <!-- Retour au restaurant -->
                <a href="/restaurant/{{ $order->restaurant->slug }}" 
                   class="action-button bg-orange-600 text-white p-6 rounded-xl text-center hover:bg-orange-700 transition-all">
                    <div class="text-3xl mb-3">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Commander plus</h3>
                    <p class="text-sm opacity-90">Retour au menu</p>
                </a>
                
                <!-- Donner un avis -->
                <a href="{{ route('order.review', $order->order_number) }}" 
                   class="action-button bg-yellow-600 text-white p-6 rounded-xl text-center hover:bg-yellow-700 transition-all">
                    <div class="text-3xl mb-3">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Donner un avis</h3>
                    <p class="text-sm opacity-90">Partager votre expérience</p>
                </a>
            </div>
        </div>

        <!-- Résumé de la commande -->
        <div class="confirmation-card bg-white rounded-2xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                <i class="fas fa-list text-indigo-600 mr-3"></i>
                Résumé de votre commande
            </h2>
            
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-utensils text-gray-400"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $item->product_name }}</h3>
                            <p class="text-sm text-gray-600">Quantité: {{ $item->quantity }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-green-600">{{ number_format($item->total_price) }} FCFA</div>
                        <div class="text-sm text-gray-500">{{ number_format($item->unit_price) }} FCFA l'unité</div>
                    </div>
                </div>
                @endforeach
                
                <!-- Totaux -->
                <div class="border-t border-gray-200 pt-4 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Sous-total:</span>
                        <span class="font-semibold">{{ number_format($order->subtotal) }} FCFA</span>
                    </div>
                    
                    @if($order->delivery_fee > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Frais de livraison:</span>
                        <span class="font-semibold">{{ number_format($order->delivery_fee) }} FCFA</span>
                    </div>
                    @endif
                    
                    <div class="flex justify-between text-xl font-bold border-t border-gray-200 pt-2">
                        <span>Total:</span>
                        <span class="text-green-600">{{ number_format($order->total_amount) }} FCFA</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations importantes -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Informations importantes</h3>
                    <ul class="space-y-2 text-blue-800">
                        <li class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            Votre commande sera préparée dans les plus brefs délais
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2"></i>
                            Nous vous contacterons au {{ $order->customer_phone }} si nécessaire
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            @if($order->type === 'delivery')
                                Livraison estimée: {{ $order->estimated_delivery_time }}
                            @elseif($order->type === 'takeaway')
                                Prêt dans: {{ $order->estimated_delivery_time }}
                            @else
                                Prêt dans: {{ $order->estimated_delivery_time }}
                            @endif
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-star mr-2"></i>
                            N'oubliez pas de donner votre avis après avoir reçu votre commande !
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bouton principal de suivi -->
        <div class="text-center mt-12">
            <a href="{{ route('order.tracking', $order->order_number) }}" 
               class="inline-flex items-center px-8 py-4 bg-blue-600 text-white text-xl font-bold rounded-xl hover:bg-blue-700 transition-all action-button">
                <i class="fas fa-map-marker-alt mr-3"></i>
                Suivre ma commande maintenant
            </a>
            
            <p class="text-gray-600 mt-4">
                Vous recevrez des mises à jour en temps réel sur l'état de votre commande
            </p>
        </div>
    </div>

    <script>
        // Animation d'entrée
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.confirmation-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.6s ease';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 200);
            });
        });

        // Copier le numéro de commande
        function copyOrderNumber() {
            navigator.clipboard.writeText('{{ $order->order_number }}').then(function() {
                alert('Numéro de commande copié !');
            });
        }

        // Partager sur les réseaux sociaux
        function shareOrder() {
            if (navigator.share) {
                navigator.share({
                    title: 'Ma commande {{ $order->order_number }}',
                    text: 'J\'ai commandé chez {{ $order->restaurant->name }} !',
                    url: window.location.href
                });
            } else {
                // Fallback pour les navigateurs qui ne supportent pas l'API de partage
                const url = encodeURIComponent(window.location.href);
                const text = encodeURIComponent(`J'ai commandé chez ${'{{ $order->restaurant->name }}'} !`);
                window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`);
            }
        }
    </script>
</body>
</html> 