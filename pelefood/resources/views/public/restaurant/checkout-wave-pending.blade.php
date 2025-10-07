@extends('layouts.public-restaurant', ['restaurant' => $restaurant])

@section('title', 'Paiement en cours - ' . $restaurant->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête avec animation -->
        <div class="text-center mb-12">
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 mb-8 animate-pulse">
                <i class="fas fa-link text-white text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Paiement Wave en cours
            </h1>
            <p class="text-xl text-gray-600 mb-2">Votre commande a été créée avec succès</p>
            <p class="text-lg text-blue-600 font-semibold">En attente de confirmation du paiement</p>
        </div>

        <!-- Informations de la commande -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Détails de la commande -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-receipt text-blue-600"></i>
                        </div>
                        Détails de votre commande
                    </h2>
                    
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 gap-4">
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-6 rounded-xl border border-blue-200">
                                <div class="text-sm text-blue-600 mb-2 font-medium">Numéro de commande</div>
                                <div class="font-bold text-2xl text-blue-800">#{{ $order->order_number ?? 'N/A' }}</div>
                            </div>
                            <div class="bg-gradient-to-r from-green-50 to-green-100 p-6 rounded-xl border border-green-200">
                                <div class="text-sm text-green-600 mb-2 font-medium">Montant total</div>
                                <div class="font-bold text-2xl text-green-800">{{ number_format($order->total_amount ?? 0, 0, ',', ' ') }} XOF</div>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200 p-6 rounded-xl">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-clock text-white text-lg"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-yellow-800 text-lg">Statut du paiement</div>
                                    <div class="text-yellow-700">En attente de confirmation Wave</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instructions Wave -->
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-info-circle text-blue-600"></i>
                        </div>
                        Instructions Wave
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-mobile-alt text-blue-400 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-blue-800">1. Ouvrez l'application Wave</h4>
                                    <p class="text-sm text-blue-700 mt-1">Assurez-vous d'avoir l'application Wave installée sur votre téléphone</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-link text-blue-400 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-blue-800">2. Utilisez le lien de paiement</h4>
                                    <p class="text-sm text-blue-700 mt-1">Cliquez sur le lien de paiement qui vous a été envoyé</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-blue-400 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-blue-800">3. Confirmez le paiement</h4>
                                    <p class="text-sm text-blue-700 mt-1">Validez le montant et confirmez votre paiement</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-bell text-blue-400 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-blue-800">4. Attendez la confirmation</h4>
                                    <p class="text-sm text-blue-700 mt-1">Vous recevrez une notification une fois le paiement confirmé</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Actions disponibles</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @if($order)
                <a href="{{ route('restaurant.public.track.order', ['slug' => $restaurant->slug, 'order_number' => $order->order_number]) }}"
                   class="flex items-center justify-center bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-eye mr-2"></i>
                    Suivre ma commande
                </a>
                @endif
                
                <a href="{{ route('restaurant.public.menu', $restaurant->slug) }}"
                   class="flex items-center justify-center bg-gray-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-utensils mr-2"></i>
                    Retour au menu
                </a>
                
                <a href="{{ route('restaurant.public.home', $restaurant->slug) }}"
                   class="flex items-center justify-center bg-orange-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-orange-700 transition-colors duration-200">
                    <i class="fas fa-home mr-2"></i>
                    Accueil
                </a>
            </div>
        </div>

        <!-- Informations supplémentaires -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-200 p-6">
            <div class="text-center">
                <h4 class="text-lg font-semibold text-blue-800 mb-2">Besoin d'aide ?</h4>
                <p class="text-blue-700 mb-4">Si vous rencontrez des difficultés avec le paiement Wave, contactez le restaurant</p>
                <div class="flex justify-center space-x-4">
                    <div class="flex items-center text-blue-600">
                        <i class="fas fa-phone mr-2"></i>
                        <span>{{ $restaurant->phone ?? 'Non disponible' }}</span>
                    </div>
                    @if($restaurant->email)
                    <div class="flex items-center text-blue-600">
                        <i class="fas fa-envelope mr-2"></i>
                        <span>{{ $restaurant->email }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>

<script>
// Actualisation automatique du statut toutes les 30 secondes
setInterval(function() {
    @if($order)
    fetch('{{ route("restaurant.public.order.status", ["slug" => $restaurant->slug, "order_number" => $order->order_number]) }}')
        .then(response => response.json())
        .then(data => {
            if (data.payment_status === 'completed') {
                // Rediriger vers la page de succès
                window.location.href = '{{ route("restaurant.public.checkout.success", $restaurant->slug) }}';
            }
        })
        .catch(error => console.log('Erreur lors de la vérification du statut:', error));
    @endif
}, 30000);
</script>
@endsection 