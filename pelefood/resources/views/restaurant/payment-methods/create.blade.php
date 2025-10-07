@extends('layouts.restaurant')

@section('title', 'Ajouter une méthode de paiement - ' . $restaurant->name)
@section('page-title', 'Ajouter une méthode de paiement')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Ajouter une méthode de paiement</h1>
                <p class="text-gray-600 mt-1">Configurez un nouveau moyen de paiement pour votre restaurant</p>
            </div>
            <a href="{{ route('restaurant.payment-methods.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <form method="POST" action="{{ route('restaurant.payment-methods.store') }}" class="p-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Informations de base -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900">Informations de base</h3>
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nom de la méthode <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('name') border-red-500 @enderror"
                               placeholder="Ex: Carte bancaire, Orange Money, etc.">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            Type de paiement <span class="text-red-500">*</span>
                        </label>
                        <select id="type" name="type" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('type') border-red-500 @enderror">
                            <option value="">Sélectionner un type</option>
                            @foreach($types as $value => $label)
                                <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="provider" class="block text-sm font-medium text-gray-700 mb-2">
                            Fournisseur <span class="text-red-500">*</span>
                        </label>
                        <select id="provider" name="provider" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('provider') border-red-500 @enderror">
                            <option value="">Sélectionner un fournisseur</option>
                            @foreach($providers as $value => $label)
                                <option value="{{ $value }}" {{ old('provider') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('provider')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea id="description" name="description" rows="3" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('description') border-red-500 @enderror"
                                  placeholder="Description optionnelle de cette méthode de paiement">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Configuration des frais -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900">Configuration des frais</h3>
                    
                    <div>
                        <label for="transaction_fee" class="block text-sm font-medium text-gray-700 mb-2">
                            Frais en pourcentage (%)
                        </label>
                        <input type="number" id="transaction_fee" name="transaction_fee" value="{{ old('transaction_fee', 0) }}" 
                               step="0.01" min="0" max="100"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('transaction_fee') border-red-500 @enderror"
                               placeholder="0.00">
                        <p class="text-sm text-gray-500 mt-1">Pourcentage appliqué sur le montant de la transaction</p>
                        @error('transaction_fee')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="fixed_fee" class="block text-sm font-medium text-gray-700 mb-2">
                            Frais fixes (FCFA)
                        </label>
                        <input type="number" id="fixed_fee" name="fixed_fee" value="{{ old('fixed_fee', 0) }}" 
                               step="1" min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('fixed_fee') border-red-500 @enderror"
                               placeholder="0">
                        <p class="text-sm text-gray-500 mt-1">Montant fixe ajouté à chaque transaction</p>
                        @error('fixed_fee')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Options -->
                    <div class="space-y-4">
                        <h4 class="text-md font-medium text-gray-900">Options</h4>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                Activer cette méthode de paiement
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="is_default" name="is_default" value="1" 
                                   {{ old('is_default') ? 'checked' : '' }}
                                   class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <label for="is_default" class="ml-2 block text-sm text-gray-900">
                                Définir comme méthode par défaut
                            </label>
                        </div>
                    </div>

                    <!-- Aperçu des frais -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Aperçu des frais</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Transaction de 10 000 FCFA :</span>
                                <span class="font-medium" id="fee-preview">0 FCFA</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Transaction de 50 000 FCFA :</span>
                                <span class="font-medium" id="fee-preview-2">0 FCFA</span>
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
                    Créer la méthode
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Calcul en temps réel des frais
function updateFeePreview() {
    const percentageFee = parseFloat(document.getElementById('transaction_fee').value) || 0;
    const fixedFee = parseFloat(document.getElementById('fixed_fee').value) || 0;
    
    const amount1 = 10000;
    const amount2 = 50000;
    
    const fee1 = (amount1 * percentageFee / 100) + fixedFee;
    const fee2 = (amount2 * percentageFee / 100) + fixedFee;
    
    document.getElementById('fee-preview').textContent = Math.round(fee1).toLocaleString() + ' FCFA';
    document.getElementById('fee-preview-2').textContent = Math.round(fee2).toLocaleString() + ' FCFA';
}

document.getElementById('transaction_fee').addEventListener('input', updateFeePreview);
document.getElementById('fixed_fee').addEventListener('input', updateFeePreview);

// Initialiser l'aperçu
updateFeePreview();
</script>
@endsection 