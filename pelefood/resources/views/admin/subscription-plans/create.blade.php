@extends('layouts.super-admin-new-design')

@section('title', 'Créer un Plan d\'Abonnement')
@section('description', 'Ajouter un nouveau plan d\'abonnement à la plateforme')
@section('page-title', 'Créer un Plan d\'Abonnement')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Nouveau Plan d'Abonnement</h3>
                <a href="{{ route('admin.subscription-plans.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
                    ← Retour à la liste
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.subscription-plans.store') }}" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations de base -->
                <div class="space-y-4">
                    <h4 class="text-md font-medium text-gray-900">Informations de Base</h4>
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nom du plan *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="ex: Plan Premium">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                  placeholder="Description détaillée du plan">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Prix (FCFA) *</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0" step="100"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="5000">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="duration_days" class="block text-sm font-medium text-gray-700">Durée (jours) *</label>
                        <input type="number" name="duration_days" id="duration_days" value="{{ old('duration_days') }}" required min="1"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="30">
                        @error('duration_days')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Limites et fonctionnalités -->
                <div class="space-y-4">
                    <h4 class="text-md font-medium text-gray-900">Limites et Fonctionnalités</h4>
                    
                    <div>
                        <label for="max_restaurants" class="block text-sm font-medium text-gray-700">Nombre max de restaurants</label>
                        <input type="number" name="max_restaurants" id="max_restaurants" value="{{ old('max_restaurants') }}" min="1"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="1">
                        @error('max_restaurants')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="max_products" class="block text-sm font-medium text-gray-700">Nombre max de produits</label>
                        <input type="number" name="max_products" id="max_products" value="{{ old('max_products') }}" min="1"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="100">
                        @error('max_products')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="max_orders_per_month" class="block text-sm font-medium text-gray-700">Commandes max par mois</label>
                        <input type="number" name="max_orders_per_month" id="max_orders_per_month" value="{{ old('max_orders_per_month') }}" min="1"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="1000">
                        @error('max_orders_per_month')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Plan actif
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.subscription-plans.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Annuler
                </a>
                <button type="submit" 
                        class="bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Créer le Plan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 