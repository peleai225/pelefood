@extends('layouts.app')

@section('title', 'Paiement - ' . $plan->name)

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Paiement de votre abonnement</h1>
            <p class="text-gray-600">Plan {{ $plan->name }} - {{ number_format($plan->price, 0, ',', ' ') }} {{ $plan->currency }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Résumé de la commande -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-receipt text-blue-600 mr-3"></i>
                    Résumé de votre commande
                </h2>

                <div class="space-y-4">
                    <!-- Plan sélectionné -->
                    <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-crown text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $plan->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $plan->description }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-blue-600">
                                {{ number_format($plan->price, 0, ',', ' ') }} {{ $plan->currency }}
                            </div>
                            <div class="text-sm text-gray-600">
                                @if($plan->billing_cycle === 'yearly')
                                    par an
                                @else
                                    par mois
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Économie pour le plan annuel -->
                    @if($plan->billing_cycle === 'yearly')
                    <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-piggy-bank text-green-600 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-green-800">Économie réalisée</h4>
                                <p class="text-sm text-green-700">Vous économisez 30.000 FCFA avec l'abonnement annuel</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Fonctionnalités incluses -->
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-semibold text-blue-800 mb-3">Fonctionnalités incluses :</h4>
                        <ul class="space-y-2 text-sm text-blue-700">
                            <li class="flex items-center">
                                <i class="fas fa-check mr-2"></i>
                                Produits illimités
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check mr-2"></i>
                                Catégories illimitées
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check mr-2"></i>
                                Gestion des commandes
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check mr-2"></i>
                                Site web personnalisé
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check mr-2"></i>
                                Analytics et rapports
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check mr-2"></i>
                                Export de données
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check mr-2"></i>
                                Support prioritaire
                            </li>
                        </ul>
                    </div>

                    <!-- Informations de facturation -->
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-semibold text-gray-800 mb-2">Informations de facturation</h4>
                        <div class="text-sm text-gray-600">
                            <div class="flex justify-between mb-1">
                                <span>Plan :</span>
                                <span>{{ $plan->name }}</span>
                            </div>
                            <div class="flex justify-between mb-1">
                                <span>Période :</span>
                                <span>
                                    @if($plan->billing_cycle === 'yearly')
                                        Facturation annuelle
                                    @else
                                        Facturation mensuelle
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between font-semibold text-gray-900 border-t pt-2">
                                <span>Total :</span>
                                <span>{{ number_format($plan->price, 0, ',', ' ') }} {{ $plan->currency }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paiement Wave -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-mobile-alt text-green-600 mr-3"></i>
                    Paiement via Wave
                </h2>

                <div class="text-center">
                    <!-- Logo Wave -->
                    <div class="mb-6">
                        <div class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-wave text-white text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Paiement sécurisé</h3>
                        <p class="text-gray-600">Payez en toute sécurité avec Wave</p>
                    </div>

                    <!-- Instructions importantes -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-yellow-600 mr-3 mt-1"></i>
                            <div class="text-left">
                                <h4 class="font-semibold text-yellow-800 mb-2">Instructions importantes</h4>
                                <ul class="text-sm text-yellow-700 space-y-1">
                                    <li>• Assurez-vous d'avoir suffisamment de fonds sur votre compte Wave</li>
                                    <li>• Le paiement sera traité immédiatement</li>
                                    <li>• Votre abonnement sera activé après confirmation du paiement</li>
                                    <li>• Après le paiement, revenez sur cette page pour confirmer</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton de paiement -->
                    <div class="space-y-4">
                        <a href="{{ config('app.wave_payment_link') }}" 
                           target="_blank"
                           class="w-full inline-flex justify-center items-center px-8 py-4 bg-green-600 text-white rounded-xl font-semibold text-lg hover:bg-green-700 transition-colors duration-300 transform hover:scale-105">
                            <i class="fas fa-external-link-alt mr-3"></i>
                            Payer avec Wave
                        </a>

                        <p class="text-sm text-gray-600">
                            Vous serez redirigé vers la page de paiement Wave
                        </p>

                        <!-- Bouton de confirmation après paiement -->
                        <form method="POST" action="{{ route('restaurant.subscription.process-payment', $plan) }}" class="mt-6">
                            @csrf
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                <i class="fas fa-check mr-2"></i>
                                J'ai effectué le paiement - Activer mon abonnement
                            </button>
                        </form>

                        <!-- Bouton de retour -->
                        <a href="{{ route('restaurant.subscription.select') }}" 
                           class="block w-full py-3 px-6 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retour aux plans
                        </a>
                    </div>

                    <!-- Support -->
                    <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                        <h4 class="font-semibold text-blue-900 mb-2">Besoin d'aide ?</h4>
                        <p class="text-sm text-blue-700 mb-3">Notre équipe est là pour vous accompagner</p>
                        <a href="mailto:support@pelefood.com" 
                           class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700">
                            <i class="fas fa-envelope mr-2"></i>
                            Contactez-nous
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Rediriger automatiquement vers Wave après 3 secondes
setTimeout(function() {
    if (confirm('Voulez-vous être redirigé vers la page de paiement Wave ?')) {
        window.open('{{ config("app.wave_payment_link") }}', '_blank');
    }
}, 3000);

// Afficher un message d'aide
document.addEventListener('DOMContentLoaded', function() {
    // Message d'aide après 10 secondes
    setTimeout(function() {
        const helpMessage = document.createElement('div');
        helpMessage.className = 'fixed bottom-4 right-4 bg-blue-600 text-white p-4 rounded-lg shadow-lg max-w-sm';
        helpMessage.innerHTML = `
            <div class="flex items-start">
                <i class="fas fa-lightbulb mr-3 mt-1"></i>
                <div>
                    <h4 class="font-semibold mb-1">Conseil</h4>
                    <p class="text-sm">Après avoir effectué le paiement sur Wave, cliquez sur le bouton "J'ai effectué le paiement" pour activer votre abonnement.</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        document.body.appendChild(helpMessage);
        
        // Supprimer automatiquement après 15 secondes
        setTimeout(() => {
            if (helpMessage.parentElement) {
                helpMessage.remove();
            }
        }, 15000);
    }, 10000);
});
</script>
@endsection 