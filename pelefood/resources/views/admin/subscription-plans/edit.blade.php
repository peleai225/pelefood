@extends('layouts.super-admin-new-design')

@section('title', 'Modifier le Plan d\'Abonnement')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- En-tête de la page -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Modifier le Plan d'Abonnement</h1>
                <p class="mt-2 text-gray-600">Modifiez les détails de l'offre</p>
            </div>
            <div>
                <a href="{{ route('admin.subscription-plans.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour aux Plans
                </a>
            </div>
        </div>
    </div>

    <!-- Formulaire d'édition -->
    <div class="bg-white rounded-lg shadow">
        <form method="POST" action="{{ route('admin.subscription-plans.update', $subscriptionPlan) }}" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations de base -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informations de base</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom du plan *
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $subscriptionPlan->name) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Ex: Starter, Professional, Enterprise">
                            @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                Type de plan *
                            </label>
                            <select name="type" id="type" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="basic" {{ old('type', $subscriptionPlan->type) == 'basic' ? 'selected' : '' }}>Basique</option>
                                <option value="standard" {{ old('type', $subscriptionPlan->type) == 'standard' ? 'selected' : '' }}>Standard</option>
                                <option value="premium" {{ old('type', $subscriptionPlan->type) == 'premium' ? 'selected' : '' }}>Premium</option>
                                <option value="enterprise" {{ old('type', $subscriptionPlan->type) == 'enterprise' ? 'selected' : '' }}>Entreprise</option>
                            </select>
                            @error('type')
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
                              placeholder="Description détaillée du plan">{{ old('description', $subscriptionPlan->description) }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prix et facturation -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Prix et facturation</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                Prix *
                            </label>
                            <div class="relative">
                                <input type="number" name="price" id="price" value="{{ old('price', $subscriptionPlan->price) }}" required step="0.01" min="0"
                                       class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="0.00">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">€</span>
                                </div>
                            </div>
                            @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="billing_cycle" class="block text-sm font-medium text-gray-700 mb-2">
                                Cycle de facturation *
                            </label>
                            <select name="billing_cycle" id="billing_cycle" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="monthly" {{ old('billing_cycle', $subscriptionPlan->billing_cycle) == 'monthly' ? 'selected' : '' }}>Mensuel</option>
                                <option value="quarterly" {{ old('billing_cycle', $subscriptionPlan->billing_cycle) == 'quarterly' ? 'selected' : '' }}>Trimestriel</option>
                                <option value="yearly" {{ old('billing_cycle', $subscriptionPlan->billing_cycle) == 'yearly' ? 'selected' : '' }}>Annuel</option>
                                <option value="one-time" {{ old('billing_cycle', $subscriptionPlan->billing_cycle) == 'one-time' ? 'selected' : '' }}>Unique</option>
                            </select>
                            @error('billing_cycle')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="duration_days" class="block text-sm font-medium text-gray-700 mb-2">
                                Durée (jours)
                            </label>
                            <input type="number" name="duration_days" id="duration_days" value="{{ old('duration_days', $subscriptionPlan->duration_days) }}" min="1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="30">
                            @error('duration_days')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Limites -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Limites du plan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="max_restaurants" class="block text-sm font-medium text-gray-700 mb-2">
                                Restaurants maximum
                            </label>
                            <input type="number" name="max_restaurants" id="max_restaurants" value="{{ old('max_restaurants', $subscriptionPlan->max_restaurants) }}" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Illimité">
                            @error('max_restaurants')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="max_products" class="block text-sm font-medium text-gray-700 mb-2">
                                Produits maximum
                            </label>
                            <input type="number" name="max_products" id="max_products" value="{{ old('max_products', $subscriptionPlan->max_products) }}" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Illimité">
                            @error('max_products')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="max_users" class="block text-sm font-medium text-gray-700 mb-2">
                                Utilisateurs maximum
                            </label>
                            <input type="number" name="max_users" id="max_users" value="{{ old('max_users', $subscriptionPlan->max_users) }}" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Illimité">
                            @error('max_users')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Fonctionnalités -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Fonctionnalités</h3>
                    <div class="space-y-3">
                        @php
                            $features = old('features', $subscriptionPlan->features ?? []);
                            if (is_string($features)) {
                                $features = json_decode($features, true) ?? [];
                            }
                        @endphp
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="features[]" value="analytics" 
                                           {{ in_array('analytics', $features) ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-900">Analytics avancés</span>
                                </label>
                            </div>
                            
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="features[]" value="marketing" 
                                           {{ in_array('marketing', $features) ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-900">Outils marketing</span>
                                </label>
                            </div>
                            
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="features[]" value="support" 
                                           {{ in_array('support', $features) ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-900">Support prioritaire</span>
                                </label>
                            </div>
                            
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="features[]" value="customization" 
                                           {{ in_array('customization', $features) ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-900">Personnalisation avancée</span>
                                </label>
                            </div>
                            
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="features[]" value="api" 
                                           {{ in_array('api', $features) ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-900">Accès API</span>
                                </label>
                            </div>
                            
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="features[]" value="white_label" 
                                           {{ in_array('white_label', $features) ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-900">White label</span>
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <label for="custom_features" class="block text-sm font-medium text-gray-700 mb-2">
                                Fonctionnalités personnalisées
                            </label>
                            <textarea name="custom_features" id="custom_features" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="Ajoutez des fonctionnalités spécifiques, une par ligne">{{ old('custom_features', $subscriptionPlan->custom_features) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Options -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Options</h3>
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" 
                                   {{ old('is_active', $subscriptionPlan->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                Plan actif
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" name="is_popular" id="is_popular" value="1" 
                                   {{ old('is_popular', $subscriptionPlan->is_popular ?? false) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_popular" class="ml-2 block text-sm text-gray-900">
                                Plan populaire
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" 
                                   {{ old('is_featured', $subscriptionPlan->is_featured ?? false) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                                Plan en vedette
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="mt-8 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.subscription-plans.index') }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i>
                    Mettre à jour le Plan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Validation du formulaire
document.querySelector('form').addEventListener('submit', function(e) {
    const price = parseFloat(document.getElementById('price').value);
    const durationDays = document.getElementById('duration_days').value;
    
    if (price < 0) {
        e.preventDefault();
        alert('Le prix ne peut pas être négatif.');
        return false;
    }
    
    if (durationDays && parseInt(durationDays) < 1) {
        e.preventDefault();
        alert('La durée doit être d\'au moins 1 jour.');
        return false;
    }
    
    // Vérifier qu'au moins une fonctionnalité est sélectionnée
    const features = document.querySelectorAll('input[name="features[]"]:checked');
    if (features.length === 0) {
        if (!confirm('Aucune fonctionnalité sélectionnée. Voulez-vous continuer ?')) {
            e.preventDefault();
            return false;
        }
    }
});

// Mise à jour automatique des fonctionnalités personnalisées
document.getElementById('custom_features').addEventListener('input', function() {
    const lines = this.value.split('\n').filter(line => line.trim() !== '');
    if (lines.length > 0) {
        // Ajouter automatiquement les fonctionnalités personnalisées aux checkboxes
        lines.forEach(line => {
            const feature = line.trim().toLowerCase().replace(/\s+/g, '_');
            const checkbox = document.querySelector(`input[value="${feature}"]`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });
    }
});
</script>
@endsection 