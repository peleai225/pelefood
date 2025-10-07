@extends('layouts.super-admin-new-design')

@section('title', 'Créer une Promotion')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- En-tête de la page -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Créer une Promotion</h1>
                <p class="mt-2 text-gray-600">Ajoutez une nouvelle promotion ou offre spéciale</p>
            </div>
            <div>
                <a href="{{ route('admin.promotions.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour aux Promotions
                </a>
            </div>
        </div>
    </div>

    <!-- Formulaire de création -->
    <div class="bg-white rounded-lg shadow">
        <form method="POST" action="{{ route('admin.promotions.store') }}" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations de base -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informations de base</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom de la promotion *
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Ex: Offre spéciale été">
                            @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="restaurant_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Restaurant *
                            </label>
                            <select name="restaurant_id" id="restaurant_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Sélectionner un restaurant</option>
                                @foreach($restaurants as $restaurant)
                                <option value="{{ $restaurant->id }}" {{ old('restaurant_id') == $restaurant->id ? 'selected' : '' }}>
                                    {{ $restaurant->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('restaurant_id')
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
                    <textarea name="description" id="description" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                              placeholder="Description détaillée de la promotion">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Réduction et conditions -->
                <div>
                    <label for="discount_percentage" class="block text-sm font-medium text-gray-700 mb-2">
                        Pourcentage de réduction *
                    </label>
                    <div class="relative">
                        <input type="number" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage') }}" required step="0.01" min="0" max="100"
                               class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="0.00">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">%</span>
                        </div>
                    </div>
                    @error('discount_percentage')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="minimum_order_amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Montant minimum de commande
                    </label>
                    <div class="relative">
                        <input type="number" name="minimum_order_amount" id="minimum_order_amount" value="{{ old('minimum_order_amount') }}" step="0.01" min="0"
                               class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="0.00">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">€</span>
                        </div>
                    </div>
                    @error('minimum_order_amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Période de validité -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Période de validité</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Date de début *
                            </label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Date de fin *
                            </label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Conditions d'utilisation -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Conditions d'utilisation</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="max_uses" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre maximum d'utilisations
                            </label>
                            <input type="number" name="max_uses" id="max_uses" value="{{ old('max_uses') }}" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Illimité">
                            @error('max_uses')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="max_uses_per_user" class="block text-sm font-medium text-gray-700 mb-2">
                                Utilisations max par utilisateur
                            </label>
                            <input type="number" name="max_uses_per_user" id="max_uses_per_user" value="{{ old('max_uses_per_user', 1) }}" min="1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="1">
                            @error('max_uses_per_user')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Code promo -->
                <div class="md:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="promo_code" class="block text-sm font-medium text-gray-700 mb-2">
                                Code promo
                            </label>
                            <input type="text" name="promo_code" id="promo_code" value="{{ old('promo_code') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Ex: ETE2024">
                            @error('promo_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="discount_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Type de réduction
                            </label>
                            <select name="discount_type" id="discount_type"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Pourcentage (%)</option>
                                <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Montant fixe (€)</option>
                            </select>
                            @error('discount_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Options -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Options</h3>
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                Promotion active
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" name="is_first_time_only" id="is_first_time_only" value="1" {{ old('is_first_time_only') ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_first_time_only" class="ml-2 block text-sm text-gray-900">
                                Première commande uniquement
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" name="is_public" id="is_public" value="1" {{ old('is_public', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_public" class="ml-2 block text-sm text-gray-900">
                                Visible publiquement
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="mt-8 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.promotions.index') }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-gift mr-2"></i>
                    Créer la Promotion
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Validation du formulaire
document.querySelector('form').addEventListener('submit', function(e) {
    const startDate = new Date(document.getElementById('start_date').value);
    const endDate = new Date(document.getElementById('end_date').value);
    const discountPercentage = parseFloat(document.getElementById('discount_percentage').value);
    
    if (startDate >= endDate) {
        e.preventDefault();
        alert('La date de fin doit être postérieure à la date de début.');
        return false;
    }
    
    if (discountPercentage <= 0 || discountPercentage > 100) {
        e.preventDefault();
        alert('Le pourcentage de réduction doit être compris entre 0 et 100.');
        return false;
    }
    
    // Vérifier que la date de début n'est pas dans le passé
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    if (startDate < today) {
        if (!confirm('La date de début est dans le passé. Voulez-vous continuer ?')) {
            e.preventDefault();
            return false;
        }
    }
});

// Génération automatique du code promo
document.getElementById('name').addEventListener('input', function() {
    const promoCodeInput = document.getElementById('promo_code');
    if (!promoCodeInput.value) {
        const name = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').substring(0, 6);
        const year = new Date().getFullYear();
        promoCodeInput.value = name + year;
    }
});

// Mise à jour du type de réduction
document.getElementById('discount_type').addEventListener('change', function() {
    const discountInput = document.getElementById('discount_percentage');
    const label = document.querySelector('label[for="discount_percentage"]');
    
    if (this.value === 'percentage') {
        label.textContent = 'Pourcentage de réduction *';
        discountInput.placeholder = '0.00';
        discountInput.max = '100';
    } else {
        label.textContent = 'Montant de réduction (€) *';
        discountInput.placeholder = '0.00';
        discountInput.max = '';
    }
});
</script>
@endsection 