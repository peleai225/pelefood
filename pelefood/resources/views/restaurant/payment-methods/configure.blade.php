@extends('layouts.restaurant')

@section('title', 'Configurer ' . $paymentMethod->name . ' - ' . $restaurant->name)
@section('page-title', 'Configurer ' . $paymentMethod->name)

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Configurer {{ $paymentMethod->name }}</h1>
                <p class="text-gray-600 mt-1">Configurez les paramètres de connexion pour {{ $paymentMethod->provider }}</p>
            </div>
            <a href="{{ route('restaurant.payment-methods.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <!-- Configuration -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <form method="POST" action="{{ route('restaurant.payment-methods.save-configuration', $paymentMethod) }}" class="p-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Informations sur la méthode -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Informations sur la méthode</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p><strong>Type:</strong> {{ ucfirst($paymentMethod->type) }}</p>
                                <p><strong>Provider:</strong> {{ $paymentMethod->provider }}</p>
                                <p><strong>Frais:</strong> 
                                    @if($paymentMethod->transaction_fee > 0)
                                        {{ $paymentMethod->transaction_fee }}%
                                    @endif
                                    @if($paymentMethod->fixed_fee > 0)
                                        +{{ number_format($paymentMethod->fixed_fee, 0, ',', ' ') }} FCFA
                                    @endif
                                    @if($paymentMethod->transaction_fee == 0 && $paymentMethod->fixed_fee == 0)
                                        Aucun frais
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configuration selon le provider -->
                @if($paymentMethod->provider === 'stripe')
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">Configuration Stripe</h3>
                        
                        <div>
                            <label for="credential_publishable_key" class="block text-sm font-medium text-gray-700 mb-2">
                                Clé publique (Publishable Key) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="credential_publishable_key" name="credential_publishable_key" 
                                   value="{{ old('credential_publishable_key', $paymentMethod->getCredential('publishable_key')) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('credential_publishable_key') border-red-500 @enderror"
                                   placeholder="pk_test_...">
                            <p class="text-sm text-gray-500 mt-1">Trouvez cette clé dans votre dashboard Stripe</p>
                            @error('credential_publishable_key')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="credential_secret_key" class="block text-sm font-medium text-gray-700 mb-2">
                                Clé secrète (Secret Key) <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="credential_secret_key" name="credential_secret_key" 
                                   value="{{ old('credential_secret_key', $paymentMethod->getCredential('secret_key')) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('credential_secret_key') border-red-500 @enderror"
                                   placeholder="sk_test_...">
                            <p class="text-sm text-gray-500 mt-1">Trouvez cette clé dans votre dashboard Stripe</p>
                            @error('credential_secret_key')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                @elseif($paymentMethod->provider === 'paypal')
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">Configuration PayPal</h3>
                        
                        <div>
                            <label for="credential_client_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Client ID <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="credential_client_id" name="credential_client_id" 
                                   value="{{ old('credential_client_id', $paymentMethod->getCredential('client_id')) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('credential_client_id') border-red-500 @enderror"
                                   placeholder="Client ID PayPal">
                            @error('credential_client_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="credential_client_secret" class="block text-sm font-medium text-gray-700 mb-2">
                                Client Secret <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="credential_client_secret" name="credential_client_secret" 
                                   value="{{ old('credential_client_secret', $paymentMethod->getCredential('client_secret')) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('credential_client_secret') border-red-500 @enderror"
                                   placeholder="Client Secret PayPal">
                            @error('credential_client_secret')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="credential_mode" class="block text-sm font-medium text-gray-700 mb-2">
                                Mode <span class="text-red-500">*</span>
                            </label>
                            <select id="credential_mode" name="credential_mode" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('credential_mode') border-red-500 @enderror">
                                <option value="sandbox" {{ old('credential_mode', $paymentMethod->getCredential('mode')) === 'sandbox' ? 'selected' : '' }}>Sandbox (Test)</option>
                                <option value="live" {{ old('credential_mode', $paymentMethod->getCredential('mode')) === 'live' ? 'selected' : '' }}>Live (Production)</option>
                            </select>
                            @error('credential_mode')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                @elseif($paymentMethod->provider === 'wave')
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">Configuration Wave (Lien de paiement)</h3>
                        
                        <!-- Information sur Wave -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-400 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Lien de paiement Wave</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p>Entrez votre lien de paiement Wave. Vos clients seront redirigés vers ce lien pour effectuer leur paiement via l'application Wave.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label for="credential_payment_link" class="block text-sm font-medium text-gray-700 mb-2">
                                Lien de paiement Wave <span class="text-red-500">*</span>
                            </label>
                            <input type="url" id="credential_payment_link" name="credential_payment_link" 
                                   value="{{ old('credential_payment_link', $paymentMethod->getCredential('payment_link')) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('credential_payment_link') border-red-500 @enderror"
                                   placeholder="https://pay.wave.com/...">
                            <p class="text-sm text-gray-500 mt-1">Exemple: https://pay.wave.com/votre-lien-de-paiement</p>
                            @error('credential_payment_link')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                @elseif(in_array($paymentMethod->provider, ['orange', 'mtn', 'moov']))
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">Configuration {{ ucfirst($paymentMethod->provider) }}</h3>
                        
                        <div>
                            <label for="credential_api_key" class="block text-sm font-medium text-gray-700 mb-2">
                                Clé API <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="credential_api_key" name="credential_api_key" 
                                   value="{{ old('credential_api_key', $paymentMethod->getCredential('api_key')) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('credential_api_key') border-red-500 @enderror"
                                   placeholder="Clé API {{ ucfirst($paymentMethod->provider) }}">
                            @error('credential_api_key')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="credential_merchant_id" class="block text-sm font-medium text-gray-700 mb-2">
                                ID Marchand <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="credential_merchant_id" name="credential_merchant_id" 
                                   value="{{ old('credential_merchant_id', $paymentMethod->getCredential('merchant_id')) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('credential_merchant_id') border-red-500 @enderror"
                                   placeholder="ID Marchand {{ ucfirst($paymentMethod->provider) }}">
                            @error('credential_merchant_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="credential_phone_number" class="block text-sm font-medium text-gray-700 mb-2">
                                Numéro de téléphone
                            </label>
                            <input type="text" id="credential_phone_number" name="credential_phone_number" 
                                   value="{{ old('credential_phone_number', $paymentMethod->getCredential('phone_number')) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('credential_phone_number') border-red-500 @enderror"
                                   placeholder="+2250700000000">
                            @error('credential_phone_number')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                @elseif($paymentMethod->provider === 'bank_transfer')
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">Configuration Virement Bancaire</h3>
                        
                        <div>
                            <label for="credential_bank_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom de la banque <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="credential_bank_name" name="credential_bank_name" 
                                   value="{{ old('credential_bank_name', $paymentMethod->getCredential('bank_name')) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('credential_bank_name') border-red-500 @enderror"
                                   placeholder="Nom de votre banque">
                            @error('credential_bank_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="credential_account_number" class="block text-sm font-medium text-gray-700 mb-2">
                                Numéro de compte <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="credential_account_number" name="credential_account_number" 
                                   value="{{ old('credential_account_number', $paymentMethod->getCredential('account_number')) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('credential_account_number') border-red-500 @enderror"
                                   placeholder="Numéro de compte bancaire">
                            @error('credential_account_number')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="credential_account_holder" class="block text-sm font-medium text-gray-700 mb-2">
                                Titulaire du compte <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="credential_account_holder" name="credential_account_holder" 
                                   value="{{ old('credential_account_holder', $paymentMethod->getCredential('account_holder')) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('credential_account_holder') border-red-500 @enderror"
                                   placeholder="Nom du titulaire du compte">
                            @error('credential_account_holder')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="credential_swift_code" class="block text-sm font-medium text-gray-700 mb-2">
                                Code SWIFT/BIC
                            </label>
                            <input type="text" id="credential_swift_code" name="credential_swift_code" 
                                   value="{{ old('credential_swift_code', $paymentMethod->getCredential('swift_code')) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('credential_swift_code') border-red-500 @enderror"
                                   placeholder="Code SWIFT/BIC de la banque">
                            @error('credential_swift_code')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Configuration non disponible</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>La configuration pour ce provider n'est pas encore implémentée.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Conseils de sécurité -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-shield-alt text-red-400 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Sécurité</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Ne partagez jamais vos clés API avec qui que ce soit</li>
                                    <li>Utilisez toujours le mode sandbox pour les tests</li>
                                    <li>Vérifiez que vous êtes sur le bon site avant de saisir vos credentials</li>
                                    <li>Changez régulièrement vos clés API</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-4">
                <a href="{{ route('restaurant.payment-methods.index') }}" 
                   class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    Annuler
                </a>
                <button type="submit" 
                        class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Sauvegarder la configuration
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 