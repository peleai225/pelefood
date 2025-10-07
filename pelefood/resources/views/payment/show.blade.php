@extends('layouts.app')

@section('title', 'Paiement - ' . $plan->name . ' - PeleFood')
@section('description', 'Finalisez votre abonnement au plan ' . $plan->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-yellow-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('home') }}" class="hover:text-orange-600">Accueil</a></li>
                <li><i data-lucide="chevron-right" class="w-4 h-4"></i></li>
                <li><a href="{{ route('restaurant.subscription.select') }}" class="hover:text-orange-600">Plans d'abonnement</a></li>
                <li><i data-lucide="chevron-right" class="w-4 h-4"></i></li>
                <li><a href="{{ route('restaurant.subscription.show', $plan->id) }}" class="hover:text-orange-600">{{ $plan->name }}</a></li>
                <li><i data-lucide="chevron-right" class="w-4 h-4"></i></li>
                <li class="text-gray-900 font-medium">Paiement</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Formulaire de paiement -->
            <div class="bg-white rounded-3xl p-8 shadow-lg border border-gray-100">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">
                    <i data-lucide="credit-card" class="w-8 h-8 inline mr-3 text-orange-500"></i>
                    Finaliser votre paiement
                </h1>

                <form action="{{ route('payment.process', $plan->id) }}" method="POST" id="payment-form">
                    @csrf
                    
                    <!-- Récapitulatif de la commande -->
                    <div class="bg-gray-50 rounded-2xl p-6 mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Récapitulatif de la commande</h3>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Plan sélectionné</span>
                                <span class="font-semibold text-gray-900">{{ $plan->name }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Prix</span>
                                <span class="font-bold text-orange-600 text-lg">
                                    {{ \App\Helpers\SettingsHelper::formatAmount($plan->price) }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Facturation</span>
                                <span class="text-gray-900">{{ $plan->billing_cycle === 'monthly' ? 'Mensuelle' : ($plan->billing_cycle === 'yearly' ? 'Annuelle' : 'Personnalisée') }}</span>
                            </div>

                            @if($plan->trial_days > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Essai gratuit</span>
                                <span class="text-green-600 font-semibold">{{ $plan->trial_days }} jours</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Méthodes de paiement -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Méthode de paiement</h3>
                        
                        <div class="space-y-4">
                            <!-- Carte bancaire -->
                            <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-orange-300 transition-colors">
                                <input type="radio" name="payment_method" value="card" class="sr-only" checked>
                                <div class="flex items-center w-full">
                                    <div class="w-6 h-6 border-2 border-gray-300 rounded-full mr-4 flex items-center justify-center payment-radio">
                                        <div class="w-3 h-3 bg-orange-500 rounded-full hidden"></div>
                                    </div>
                                    <i data-lucide="credit-card" class="w-6 h-6 text-gray-600 mr-3"></i>
                                    <div>
                                        <div class="font-semibold text-gray-900">Carte bancaire</div>
                                        <div class="text-sm text-gray-500">Visa, Mastercard, American Express</div>
                                    </div>
                                </div>
                            </label>

                            <!-- Mobile Money -->
                            <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-orange-300 transition-colors">
                                <input type="radio" name="payment_method" value="mobile_money" class="sr-only">
                                <div class="flex items-center w-full">
                                    <div class="w-6 h-6 border-2 border-gray-300 rounded-full mr-4 flex items-center justify-center payment-radio">
                                        <div class="w-3 h-3 bg-orange-500 rounded-full hidden"></div>
                                    </div>
                                    <i data-lucide="smartphone" class="w-6 h-6 text-gray-600 mr-3"></i>
                                    <div>
                                        <div class="font-semibold text-gray-900">Mobile Money</div>
                                        <div class="text-sm text-gray-500">Orange Money, MTN Mobile Money, Moov Money</div>
                                    </div>
                                </div>
                            </label>

                            <!-- Virement bancaire -->
                            <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-orange-300 transition-colors">
                                <input type="radio" name="payment_method" value="bank_transfer" class="sr-only">
                                <div class="flex items-center w-full">
                                    <div class="w-6 h-6 border-2 border-gray-300 rounded-full mr-4 flex items-center justify-center payment-radio">
                                        <div class="w-3 h-3 bg-orange-500 rounded-full hidden"></div>
                                    </div>
                                    <i data-lucide="building-2" class="w-6 h-6 text-gray-600 mr-3"></i>
                                    <div>
                                        <div class="font-semibold text-gray-900">Virement bancaire</div>
                                        <div class="text-sm text-gray-500">Transfert direct depuis votre compte bancaire</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Informations de facturation -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations de facturation</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                                <input type="text" value="{{ $restaurant->user->name }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" value="{{ $restaurant->user->email }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Conditions -->
                    <div class="mb-8">
                        <label class="flex items-start">
                            <input type="checkbox" name="terms_accepted" required class="mt-1 mr-3 text-orange-600 focus:ring-orange-500">
                            <span class="text-sm text-gray-600">
                                J'accepte les <a href="#" class="text-orange-600 hover:underline">conditions générales</a> et la <a href="#" class="text-orange-600 hover:underline">politique de confidentialité</a> de PeleFood.
                            </span>
                        </label>
                    </div>

                    <!-- Bouton de paiement -->
                    <button type="submit" id="pay-button" class="w-full bg-gradient-to-r from-orange-500 to-yellow-500 text-white font-bold py-4 px-6 rounded-2xl hover:from-orange-600 hover:to-yellow-600 transition-all duration-300 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                        <i data-lucide="credit-card" class="w-5 h-5 inline mr-2"></i>
                        @if($plan->trial_days > 0)
                            Commencer l'essai gratuit
                        @else
                            Payer {{ \App\Helpers\SettingsHelper::formatAmount($plan->price) }}
                        @endif
                    </button>
                </form>
            </div>

            <!-- Sidebar - Sécurité -->
            <div class="lg:col-span-1">
                <div class="sticky top-8">
                    <!-- Sécurité -->
                    <div class="bg-green-50 border border-green-200 rounded-2xl p-6 mb-6">
                        <h3 class="text-lg font-semibold text-green-900 mb-4">
                            <i data-lucide="shield-check" class="w-6 h-6 inline mr-2"></i>
                            Paiement sécurisé
                        </h3>
                        <ul class="space-y-2 text-sm text-green-800">
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-4 h-4 mr-2"></i>
                                Chiffrement SSL 256 bits
                            </li>
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-4 h-4 mr-2"></i>
                                Conformité PCI DSS
                            </li>
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-4 h-4 mr-2"></i>
                                Aucune donnée bancaire stockée
                            </li>
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-4 h-4 mr-2"></i>
                                Garantie satisfait ou remboursé
                            </li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-4">
                            <i data-lucide="headphones" class="w-6 h-6 inline mr-2"></i>
                            Besoin d'aide ?
                        </h3>
                        <p class="text-sm text-blue-800 mb-4">
                            Notre équipe est disponible pour vous accompagner dans votre paiement.
                        </p>
                        <div class="space-y-2">
                            <a href="mailto:support@pelefood.ci" class="flex items-center text-sm text-blue-600 hover:text-blue-800">
                                <i data-lucide="mail" class="w-4 h-4 mr-2"></i>
                                support@pelefood.ci
                            </a>
                            <a href="tel:+225123456789" class="flex items-center text-sm text-blue-600 hover:text-blue-800">
                                <i data-lucide="phone" class="w-4 h-4 mr-2"></i>
                                +225 12 34 56 789
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des boutons radio de paiement
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    const paymentLabels = document.querySelectorAll('label[for*="payment_method"]');
    
    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Réinitialiser tous les styles
            paymentLabels.forEach(label => {
                const radioDiv = label.querySelector('.payment-radio');
                const checkDiv = radioDiv.querySelector('div');
                radioDiv.classList.remove('border-orange-500');
                radioDiv.classList.add('border-gray-300');
                checkDiv.classList.add('hidden');
            });
            
            // Appliquer le style au label sélectionné
            const selectedLabel = this.closest('label');
            const radioDiv = selectedLabel.querySelector('.payment-radio');
            const checkDiv = radioDiv.querySelector('div');
            radioDiv.classList.remove('border-gray-300');
            radioDiv.classList.add('border-orange-500');
            checkDiv.classList.remove('hidden');
        });
    });

    // Gestion du formulaire de paiement
    const paymentForm = document.getElementById('payment-form');
    const payButton = document.getElementById('pay-button');
    
    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Désactiver le bouton pendant le traitement
        payButton.disabled = true;
        payButton.innerHTML = '<i data-lucide="loader-2" class="w-5 h-5 inline mr-2 animate-spin"></i>Traitement en cours...';
        
        // Simuler un délai de traitement
        setTimeout(() => {
            paymentForm.submit();
        }, 2000);
    });
});
</script>
@endpush
@endsection
