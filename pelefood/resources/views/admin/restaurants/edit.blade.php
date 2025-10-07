@extends('layouts.super-admin-new-design')

@section('title', 'Modifier le Restaurant')
@section('description', 'Modifier les informations du restaurant')
@section('page-title', 'Modifier le Restaurant')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- En-tête avec navigation -->
    <div class="card-glass-enhanced p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-utensils text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $restaurant->name }}</h1>
                    <p class="text-gray-600">Modifier les informations du restaurant</p>
                </div>
            </div>
            <a href="{{ route('admin.restaurants.index') }}" class="btn-modern-enhanced">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour à la liste
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.restaurants.update', $restaurant) }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Section 1: Informations de base -->
        <div class="card-glass-enhanced p-6">
            <div class="flex items-center mb-6">
                <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-info text-white text-sm"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Informations de Base</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="form-group-modern">
                    <label for="name" class="form-label-modern">
                        <i class="fas fa-store mr-2"></i>
                        Nom du restaurant *
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $restaurant->name) }}" required
                           class="form-input-ultra" placeholder="Ex: Restaurant Le Délicieux">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="form-group-modern">
                    <label for="email" class="form-label-modern">
                        <i class="fas fa-envelope mr-2"></i>
                        Email *
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $restaurant->email) }}" required
                           class="form-input-ultra" placeholder="contact@restaurant.com">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="form-group-modern">
                    <label for="phone" class="form-label-modern">
                        <i class="fas fa-phone mr-2"></i>
                        Téléphone *
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $restaurant->phone) }}" required
                           class="form-input-ultra" placeholder="+225 XX XX XX XX">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="form-group-modern">
                    <label for="website" class="form-label-modern">
                        <i class="fas fa-globe mr-2"></i>
                        Site web
                    </label>
                    <input type="url" name="website" id="website" value="{{ old('website', $restaurant->website ?? '') }}"
                           class="form-input-ultra" placeholder="https://www.restaurant.com">
                    @error('website')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="form-group-modern">
                <label for="description" class="form-label-modern">
                    <i class="fas fa-align-left mr-2"></i>
                    Description
                </label>
                <textarea name="description" id="description" rows="4"
                          class="form-input-ultra" placeholder="Décrivez votre restaurant, sa spécialité, son ambiance...">{{ old('description', $restaurant->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Section 2: Localisation -->
        <div class="card-glass-enhanced p-6">
            <div class="flex items-center mb-6">
                <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-map-marker-alt text-white text-sm"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Localisation</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="form-group-modern">
                    <label for="address" class="form-label-modern">
                        <i class="fas fa-map mr-2"></i>
                        Adresse complète *
                    </label>
                    <input type="text" name="address" id="address" value="{{ old('address', $restaurant->address) }}" required
                           class="form-input-ultra" placeholder="Ex: Rue des Cocotiers, Cocody">
                    @error('address')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="form-group-modern">
                    <label for="city" class="form-label-modern">
                        <i class="fas fa-city mr-2"></i>
                        Ville *
                    </label>
                    <select name="city" id="city" required class="form-input-ultra">
                        <option value="">Sélectionner une ville</option>
                        <option value="Abidjan" {{ old('city', $restaurant->city) == 'Abidjan' ? 'selected' : '' }}>Abidjan</option>
                        <option value="Bouaké" {{ old('city', $restaurant->city) == 'Bouaké' ? 'selected' : '' }}>Bouaké</option>
                        <option value="Daloa" {{ old('city', $restaurant->city) == 'Daloa' ? 'selected' : '' }}>Daloa</option>
                        <option value="San-Pédro" {{ old('city', $restaurant->city) == 'San-Pédro' ? 'selected' : '' }}>San-Pédro</option>
                        <option value="Korhogo" {{ old('city', $restaurant->city) == 'Korhogo' ? 'selected' : '' }}>Korhogo</option>
                        <option value="Man" {{ old('city', $restaurant->city) == 'Man' ? 'selected' : '' }}>Man</option>
                        <option value="Yamoussoukro" {{ old('city', $restaurant->city) == 'Yamoussoukro' ? 'selected' : '' }}>Yamoussoukro</option>
                        <option value="Autre" {{ old('city', $restaurant->city) == 'Autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                    @error('city')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Section 3: Configuration -->
        <div class="card-glass-enhanced p-6">
            <div class="flex items-center mb-6">
                <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-cog text-white text-sm"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Configuration</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="form-group-modern">
                    <label for="user_id" class="form-label-modern">
                        <i class="fas fa-user-tie mr-2"></i>
                        Propriétaire/Gérant *
                    </label>
                    <select name="user_id" id="user_id" required class="form-input-ultra">
                        <option value="">Sélectionner un utilisateur</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $restaurant->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="form-group-modern">
                    <label for="subscription_plan_id" class="form-label-modern">
                        <i class="fas fa-crown mr-2"></i>
                        Plan d'abonnement *
                    </label>
                    <select name="subscription_plan_id" id="subscription_plan_id" required class="form-input-ultra">
                        <option value="">Sélectionner un plan</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{ old('subscription_plan_id', $restaurant->subscription_plan_id) == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }} - {{ currency($plan->price) }}
                            </option>
                        @endforeach
                    </select>
                    @error('subscription_plan_id')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Options avancées -->
            <div class="mt-6 space-y-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Options Avancées</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $restaurant->is_active) ? 'checked' : '' }}
                                   class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-3 text-sm font-medium text-gray-900">
                                Restaurant actif
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="delivery_available" id="delivery_available" value="1" {{ old('delivery_available', $restaurant->getSetting('delivery_enabled', true)) ? 'checked' : '' }}
                                   class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <label for="delivery_available" class="ml-3 text-sm font-medium text-gray-900">
                                Livraison disponible
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="takeaway_available" id="takeaway_available" value="1" {{ old('takeaway_available', $restaurant->getSetting('takeaway_enabled', true)) ? 'checked' : '' }}
                                   class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <label for="takeaway_available" class="ml-3 text-sm font-medium text-gray-900">
                                À emporter disponible
                            </label>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="form-group-modern">
                            <label for="delivery_fee" class="form-label-modern">
                                <i class="fas fa-truck mr-2"></i>
                                Frais de livraison ({{ config('app.currency') }})
                            </label>
                            <input type="number" name="delivery_fee" id="delivery_fee" value="{{ old('delivery_fee', $restaurant->delivery_fee ?? 0) }}"
                                   class="form-input-ultra" placeholder="0" min="0">
                        </div>

                        <div class="form-group-modern">
                            <label for="minimum_order" class="form-label-modern">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Montant minimum de commande ({{ config('app.currency') }})
                            </label>
                            <input type="number" name="minimum_order" id="minimum_order" value="{{ old('minimum_order', $restaurant->minimum_order ?? 0) }}"
                                   class="form-input-ultra" placeholder="0" min="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: Zones de livraison -->
        <div class="card-glass-enhanced p-6">
            <div class="flex items-center mb-6">
                <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-truck text-white text-sm"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Zones de Livraison</h2>
            </div>

            <div id="delivery-zones-container">
                @if($restaurant->delivery_zones && count($restaurant->delivery_zones) > 0)
                    @foreach($restaurant->delivery_zones as $index => $zone)
                        <div class="delivery-zone-item flex items-center space-x-4 p-4 bg-gray-50 rounded-lg mb-4">
                            <div class="flex-1">
                                <input type="text" name="delivery_zones[{{ $index }}][name]" value="{{ $zone['name'] ?? '' }}" 
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" 
                                       placeholder="Nom de la zone">
                            </div>
                            <div class="w-32">
                                <input type="number" name="delivery_zones[{{ $index }}][fee]" value="{{ $zone['fee'] ?? 0 }}" 
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" 
                                       placeholder="Frais">
                            </div>
                            <div class="w-32">
                                <input type="number" name="delivery_zones[{{ $index }}][delivery_time]" value="{{ $zone['delivery_time'] ?? 30 }}" 
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" 
                                       placeholder="Délai (min)">
                            </div>
                            <button type="button" onclick="removeDeliveryZone(this)" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="delivery-zone-item flex items-center space-x-4 p-4 bg-gray-50 rounded-lg mb-4">
                        <div class="flex-1">
                            <input type="text" name="delivery_zones[0][name]" value="" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" 
                                   placeholder="Nom de la zone">
                        </div>
                        <div class="w-32">
                            <input type="number" name="delivery_zones[0][fee]" value="0" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" 
                                   placeholder="Frais">
                        </div>
                        <div class="w-32">
                            <input type="number" name="delivery_zones[0][delivery_time]" value="30" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" 
                                   placeholder="Délai (min)">
                        </div>
                        <button type="button" onclick="removeDeliveryZone(this)" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                @endif
            </div>
            
            <button type="button" onclick="addDeliveryZone()" class="w-full flex items-center justify-center px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:text-gray-800 hover:border-gray-400 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Ajouter une zone de livraison
            </button>
        </div>

        <!-- Section 5: Horaires -->
        <div class="card-glass-enhanced p-6">
            <div class="flex items-center mb-6">
                <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-clock text-white text-sm"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Horaires d'Ouverture</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="form-group-modern">
                    <label for="preparation_time" class="form-label-modern">
                        <i class="fas fa-clock mr-2"></i>
                        Temps de préparation (minutes)
                    </label>
                    <input type="number" name="preparation_time" id="preparation_time" value="{{ old('preparation_time', $restaurant->preparation_time ?? 30) }}"
                           class="form-input-ultra" min="0" placeholder="30">
                </div>

                <div class="form-group-modern">
                    <label for="delivery_time" class="form-label-modern">
                        <i class="fas fa-truck mr-2"></i>
                        Temps de livraison (minutes)
                    </label>
                    <input type="number" name="delivery_time" id="delivery_time" value="{{ old('delivery_time', $restaurant->delivery_time ?? 45) }}"
                           class="form-input-ultra" min="0" placeholder="45">
                </div>

                <div class="form-group-modern">
                    <label for="delivery_radius" class="form-label-modern">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        Rayon de livraison (km)
                    </label>
                    <input type="number" name="delivery_radius" id="delivery_radius" value="{{ old('delivery_radius', $restaurant->delivery_radius ?? 10) }}"
                           class="form-input-ultra" min="0" placeholder="10">
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-6">
            <a href="{{ route('admin.restaurants.index') }}" class="btn-modern-secondary">
                <i class="fas fa-times mr-2"></i>
                Annuler
            </a>
            <button type="submit" class="btn-modern-primary">
                <i class="fas fa-save mr-2"></i>
                Mettre à jour
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
let deliveryZoneIndex = {{ $restaurant->delivery_zones ? count($restaurant->delivery_zones) : 1 }};

function addDeliveryZone() {
    const container = document.getElementById('delivery-zones-container');
    const zoneHtml = `
        <div class="delivery-zone-item flex items-center space-x-4 p-4 bg-gray-50 rounded-lg mb-4">
            <div class="flex-1">
                <input type="text" name="delivery_zones[${deliveryZoneIndex}][name]" value="" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" 
                       placeholder="Nom de la zone">
            </div>
            <div class="w-32">
                <input type="number" name="delivery_zones[${deliveryZoneIndex}][fee]" value="0" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" 
                       placeholder="Frais">
            </div>
            <div class="w-32">
                <input type="number" name="delivery_zones[${deliveryZoneIndex}][delivery_time]" value="30" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" 
                       placeholder="Délai (min)">
            </div>
            <button type="button" onclick="removeDeliveryZone(this)" class="text-red-600 hover:text-red-800">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', zoneHtml);
    deliveryZoneIndex++;
}

function removeDeliveryZone(button) {
    const zoneItem = button.closest('.delivery-zone-item');
    zoneItem.remove();
}

document.addEventListener('DOMContentLoaded', function() {
    // Animation des cartes au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.card-glass-enhanced').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s ease-out';
        observer.observe(card);
    });

    // Validation en temps réel
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.add('border-red-500');
                this.classList.remove('border-green-500');
            } else {
                this.classList.remove('border-red-500');
                this.classList.add('border-green-500');
            }
        });
    });
});
</script>
@endpush
@endsection 