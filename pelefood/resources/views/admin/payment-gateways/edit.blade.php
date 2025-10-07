@extends('layouts.super-admin-new-design')

@section('title', 'Modifier la Passerelle')
@section('description', 'Modifier la passerelle de paiement')

@section('content')
<div class="p-6 space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Modifier la Passerelle</h1>
            <p class="text-gray-600 mt-2">Modifiez la configuration de {{ $paymentGateway->name }}</p>
        </div>
        <a href="{{ route('admin.payment-gateways.index') }}" 
           class="btn-modern bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour
        </a>
    </div>

    <!-- Formulaire -->
    <div class="card-glass">
        <div class="p-6">
            <form method="POST" action="{{ route('admin.payment-gateways.update', $paymentGateway) }}" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nom -->
                    <div class="form-group-modern">
                        <label for="name" class="form-label-modern">Nom de la Passerelle *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $paymentGateway->name) }}" 
                               class="form-input-modern @error('name') border-red-500 @enderror" 
                               placeholder="Ex: Wave Côte d'Ivoire" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Provider -->
                    <div class="form-group-modern">
                        <label for="provider" class="form-label-modern">Provider *</label>
                        <select id="provider" name="provider" 
                                class="form-input-modern @error('provider') border-red-500 @enderror" required>
                            <option value="">Sélectionnez un provider</option>
                            @foreach($providers as $key => $value)
                                <option value="{{ $key }}" {{ old('provider', $paymentGateway->provider) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('provider')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group-modern">
                    <label for="description" class="form-label-modern">Description</label>
                    <textarea id="description" name="description" rows="3" 
                              class="form-input-modern @error('description') border-red-500 @enderror" 
                              placeholder="Description de la passerelle...">{{ old('description', $paymentGateway->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Configuration des frais -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group-modern">
                        <label for="fees_percentage" class="form-label-modern">Frais en Pourcentage (%) *</label>
                        <input type="number" id="fees_percentage" name="fees_percentage" 
                               value="{{ old('fees_percentage', $paymentGateway->fees_percentage) }}" step="0.01" min="0" max="100"
                               class="form-input-modern @error('fees_percentage') border-red-500 @enderror" 
                               placeholder="1.5" required>
                        @error('fees_percentage')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group-modern">
                        <label for="fees_fixed" class="form-label-modern">Frais Fixes (FCFA) *</label>
                        <input type="number" id="fees_fixed" name="fees_fixed" 
                               value="{{ old('fees_fixed', $paymentGateway->fees_fixed) }}" step="1" min="0"
                               class="form-input-modern @error('fees_fixed') border-red-500 @enderror" 
                               placeholder="50" required>
                        @error('fees_fixed')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Clés API -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group-modern">
                        <label for="api_key" class="form-label-modern">Clé API</label>
                        <input type="text" id="api_key" name="api_key" value="{{ old('api_key', $paymentGateway->credentials['api_key'] ?? '') }}" 
                               class="form-input-modern @error('api_key') border-red-500 @enderror" 
                               placeholder="Votre clé API publique">
                        @error('api_key')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group-modern">
                        <label for="secret_key" class="form-label-modern">Clé Secrète</label>
                        <input type="password" id="secret_key" name="secret_key" value="{{ old('secret_key', $paymentGateway->credentials['secret_key'] ?? '') }}" 
                               class="form-input-modern @error('secret_key') border-red-500 @enderror" 
                               placeholder="Votre clé secrète">
                        @error('secret_key')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- URL Webhook -->
                <div class="form-group-modern">
                    <label for="webhook_url" class="form-label-modern">URL Webhook</label>
                    <input type="url" id="webhook_url" name="webhook_url" value="{{ old('webhook_url', $paymentGateway->webhook_url) }}" 
                           class="form-input-modern @error('webhook_url') border-red-500 @enderror" 
                           placeholder="https://pelefood.com/payment/webhook/wave">
                    @error('webhook_url')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Options -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group-modern">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" 
                                   {{ old('is_active', $paymentGateway->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Passerelle Active</span>
                        </label>
                    </div>

                    <div class="form-group-modern">
                        <label class="flex items-center">
                            <input type="checkbox" name="test_mode" value="1" 
                                   {{ old('test_mode', $paymentGateway->test_mode) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Mode Test</span>
                        </label>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.payment-gateways.index') }}" 
                       class="btn-modern bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="btn-modern bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection