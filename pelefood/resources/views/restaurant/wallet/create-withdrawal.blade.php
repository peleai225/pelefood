@extends('layouts.restaurant')

@section('title', 'Demander un retrait')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- En-tête -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Demander un retrait</h1>
                <p class="text-gray-600">Retirez vos gains du portefeuille</p>
            </div>
            <a href="{{ route('restaurant.wallet.index') }}" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </a>
        </div>
    </div>

    <!-- Informations du portefeuille -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-400"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Solde disponible</h3>
                <div class="mt-1 text-sm text-blue-700">
                    <p class="text-2xl font-bold">{{ $stats['formatted_available_balance'] ?? '0 FCFA' }}</p>
                    <p class="mt-1">Montant minimum : 1,000 FCFA • Frais de retrait : 500 FCFA</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire de retrait -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('restaurant.wallet.withdrawal.store') }}" method="POST" id="withdrawalForm">
            @csrf

            <!-- Montant -->
            <div class="mb-6">
                <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                    Montant à retirer <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="number" 
                           id="amount" 
                           name="amount" 
                           min="1000" 
                           step="100"
                           value="{{ old('amount') }}"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('amount') border-red-300 @enderror"
                           placeholder="Entrez le montant (minimum 1,000 FCFA)"
                           required>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">FCFA</span>
                    </div>
                </div>
                @error('amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Montant minimum : 1,000 FCFA</p>
            </div>

            <!-- Calcul automatique des frais -->
            <div id="feeCalculation" class="mb-6 p-4 bg-gray-50 rounded-lg hidden">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Détail du calcul</h4>
                <div class="space-y-1 text-sm">
                    <div class="flex justify-between">
                        <span>Montant demandé :</span>
                        <span id="requestedAmount">0 FCFA</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Frais de retrait :</span>
                        <span id="withdrawalFees">500 FCFA</span>
                    </div>
                    <div class="flex justify-between font-medium border-t pt-1">
                        <span>Montant net reçu :</span>
                        <span id="netAmount" class="text-green-600">0 FCFA</span>
                    </div>
                </div>
            </div>

            <!-- Informations bancaires -->
            <div class="space-y-6">
                <h3 class="text-lg font-medium text-gray-900">Informations bancaires</h3>

                <!-- Nom de la banque -->
                <div>
                    <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom de la banque <span class="text-red-500">*</span>
                    </label>
                    <select id="bank_name" 
                            name="bank_name" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('bank_name') border-red-300 @enderror"
                            required>
                        <option value="">Sélectionnez votre banque</option>
                        <option value="SGBCI" {{ old('bank_name') === 'SGBCI' ? 'selected' : '' }}>SGBCI</option>
                        <option value="BNI" {{ old('bank_name') === 'BNI' ? 'selected' : '' }}>BNI</option>
                        <option value="UBA" {{ old('bank_name') === 'UBA' ? 'selected' : '' }}>UBA</option>
                        <option value="Ecobank" {{ old('bank_name') === 'Ecobank' ? 'selected' : '' }}>Ecobank</option>
                        <option value="Access Bank" {{ old('bank_name') === 'Access Bank' ? 'selected' : '' }}>Access Bank</option>
                        <option value="Coris Bank" {{ old('bank_name') === 'Coris Bank' ? 'selected' : '' }}>Coris Bank</option>
                        <option value="Autre" {{ old('bank_name') === 'Autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                    @error('bank_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Numéro de compte -->
                <div>
                    <label for="account_number" class="block text-sm font-medium text-gray-700 mb-2">
                        Numéro de compte <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="account_number" 
                           name="account_number" 
                           value="{{ old('account_number') }}"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('account_number') border-red-300 @enderror"
                           placeholder="Entrez votre numéro de compte"
                           required>
                    @error('account_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nom du titulaire -->
                <div>
                    <label for="account_holder_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom du titulaire du compte <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="account_holder_name" 
                           name="account_holder_name" 
                           value="{{ old('account_holder_name') }}"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('account_holder_name') border-red-300 @enderror"
                           placeholder="Nom complet du titulaire"
                           required>
                    @error('account_holder_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Téléphone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Numéro de téléphone <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone') }}"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('phone') border-red-300 @enderror"
                           placeholder="+225 XX XX XX XX XX"
                           required>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Informations importantes -->
            <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Informations importantes</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Le traitement de votre demande prendra <strong>24 heures</strong></li>
                                <li>Vérifiez bien vos informations bancaires avant de soumettre</li>
                                <li>Les frais de retrait de <strong>500 FCFA</strong> seront déduits du montant demandé</li>
                                <li>Vous recevrez une notification par email une fois le retrait traité</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('restaurant.wallet.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-md text-sm font-medium">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-medium">
                    <i class="fas fa-paper-plane mr-2"></i> Soumettre la demande
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('amount');
    const feeCalculation = document.getElementById('feeCalculation');
    const requestedAmount = document.getElementById('requestedAmount');
    const withdrawalFees = document.getElementById('withdrawalFees');
    const netAmount = document.getElementById('netAmount');

    function calculateFees() {
        const amount = parseFloat(amountInput.value) || 0;
        
        if (amount >= 1000) {
            const fees = 500;
            const net = amount - fees;
            
            requestedAmount.textContent = formatNumber(amount) + ' FCFA';
            withdrawalFees.textContent = formatNumber(fees) + ' FCFA';
            netAmount.textContent = formatNumber(net) + ' FCFA';
            
            feeCalculation.classList.remove('hidden');
        } else {
            feeCalculation.classList.add('hidden');
        }
    }

    function formatNumber(num) {
        return new Intl.NumberFormat('fr-FR').format(num);
    }

    amountInput.addEventListener('input', calculateFees);
    
    // Calcul initial si il y a une valeur
    calculateFees();
});
</script>
@endsection
