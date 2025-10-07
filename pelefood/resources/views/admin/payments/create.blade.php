@extends('layouts.super-admin-new-design')

@section('title', 'Créer un Paiement')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- En-tête de la page -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Créer un Paiement</h1>
                <p class="mt-2 text-gray-600">Enregistrez un nouveau paiement dans le système</p>
            </div>
            <div>
                <a href="{{ route('admin.payments.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour aux Paiements
                </a>
            </div>
        </div>
    </div>

    <!-- Formulaire de création -->
    <div class="bg-white rounded-lg shadow">
        <form method="POST" action="{{ route('admin.payments.store') }}" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations de base -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informations de base</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Utilisateur *
                            </label>
                            <select name="user_id" id="user_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Sélectionner un utilisateur</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="tenant_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Tenant *
                            </label>
                            <select name="tenant_id" id="tenant_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Sélectionner un tenant</option>
                                @foreach($tenants as $tenant)
                                <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                    {{ $tenant->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('tenant_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Montant et devise -->
                <div class="md:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                                Montant *
                            </label>
                            <div class="relative">
                                <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required step="0.01" min="0"
                                       class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="0.00">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">€</span>
                                </div>
                            </div>
                            @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">
                                Devise *
                            </label>
                            <select name="currency" id="currency" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                <option value="XOF" {{ old('currency') == 'XOF' ? 'selected' : '' }}>XOF (CFA)</option>
                                <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                            </select>
                            @error('currency')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Méthode de paiement et statut -->
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                        Méthode de paiement *
                    </label>
                    <select name="payment_method" id="payment_method" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Sélectionner une méthode</option>
                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Carte bancaire</option>
                        <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                        <option value="stripe" {{ old('payment_method') == 'stripe' ? 'selected' : '' }}>Stripe</option>
                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Virement bancaire</option>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Espèces</option>
                    </select>
                    @error('payment_method')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Statut *
                    </label>
                    <select name="status" id="status" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Sélectionner un statut</option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>En cours</option>
                        <option value="successful" {{ old('status') == 'successful' ? 'selected' : '' }}>Réussi</option>
                        <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Échoué</option>
                        <option value="refunded" {{ old('status') == 'refunded' ? 'selected' : '' }}>Remboursé</option>
                    </select>
                    @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Identifiants de transaction -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Identifiants de transaction</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="transaction_id" class="block text-sm font-medium text-gray-700 mb-2">
                                ID de transaction *
                            </label>
                            <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="TXN-123456789">
                            @error('transaction_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="gateway_transaction_id" class="block text-sm font-medium text-gray-700 mb-2">
                                ID de la passerelle
                            </label>
                            <input type="text" name="gateway_transaction_id" id="gateway_transaction_id" value="{{ old('gateway_transaction_id') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Gateway transaction ID">
                            @error('gateway_transaction_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                              placeholder="Description du paiement">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Commission -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Commission</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="commission_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                Taux de commission (%)
                            </label>
                            <input type="number" name="commission_rate" id="commission_rate" value="{{ old('commission_rate', 2.9) }}" step="0.01" min="0" max="100"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="2.9">
                            @error('commission_rate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="commission" class="block text-sm font-medium text-gray-700 mb-2">
                                Montant de la commission
                            </label>
                            <input type="number" name="commission" id="commission" value="{{ old('commission') }}" step="0.01" min="0" readonly
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50"
                                   placeholder="Calculé automatiquement">
                            @error('commission')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Dates -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Dates</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="processed_at" class="block text-sm font-medium text-gray-700 mb-2">
                                Date de traitement
                            </label>
                            <input type="datetime-local" name="processed_at" id="processed_at" value="{{ old('processed_at') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('processed_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="refunded_at" class="block text-sm font-medium text-gray-700 mb-2">
                                Date de remboursement
                            </label>
                            <input type="datetime-local" name="refunded_at" id="refunded_at" value="{{ old('refunded_at') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('refunded_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="mt-8 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.payments.index') }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-credit-card mr-2"></i>
                    Créer le Paiement
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Calcul automatique de la commission
document.getElementById('amount').addEventListener('input', calculateCommission);
document.getElementById('commission_rate').addEventListener('input', calculateCommission);

function calculateCommission() {
    const amount = parseFloat(document.getElementById('amount').value) || 0;
    const rate = parseFloat(document.getElementById('commission_rate').value) || 0;
    const commission = (amount * rate) / 100;
    document.getElementById('commission').value = commission.toFixed(2);
}

// Validation du formulaire
document.querySelector('form').addEventListener('submit', function(e) {
    const amount = parseFloat(document.getElementById('amount').value);
    const userId = document.getElementById('user_id').value;
    const tenantId = document.getElementById('tenant_id').value;
    const transactionId = document.getElementById('transaction_id').value.trim();
    
    if (!amount || amount <= 0) {
        e.preventDefault();
        alert('Le montant doit être supérieur à 0.');
        return false;
    }
    
    if (!userId || !tenantId) {
        e.preventDefault();
        alert('Veuillez sélectionner un utilisateur et un tenant.');
        return false;
    }
    
    if (!transactionId) {
        e.preventDefault();
        alert('Veuillez saisir un ID de transaction.');
        return false;
    }
    
    // Vérifier que l'ID de transaction est unique
    if (transactionId.length < 5) {
        e.preventDefault();
        alert('L\'ID de transaction doit contenir au moins 5 caractères.');
        return false;
    }
});

// Initialisation
calculateCommission();
</script>
@endsection 