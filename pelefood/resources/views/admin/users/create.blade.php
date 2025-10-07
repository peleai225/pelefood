@extends('layouts.super-admin-new-design')

@section('title', 'Créer un Utilisateur')
@section('description', 'Ajouter un nouvel utilisateur à la plateforme')

@section('breadcrumb')
<li>
    <div class="flex items-center">
        <i class="fas fa-chevron-right h-4 w-4 text-gray-400 mx-2"></i>
        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Utilisateurs</a>
    </div>
</li>
<li>
    <div class="flex items-center">
        <i class="fas fa-chevron-right h-4 w-4 text-gray-400 mx-2"></i>
        <span class="text-sm font-medium text-gray-900">Créer</span>
    </div>
</li>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Créer un Utilisateur</h1>
            <p class="mt-2 text-lg text-gray-600">Ajouter un nouvel utilisateur à la plateforme</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
            <i class="fas fa-arrow-left w-4 h-4 mr-2"></i>
            Retour à la liste
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Informations du nouvel utilisateur</h3>
            <p class="text-sm text-gray-600">Remplissez les informations requises pour créer le compte</p>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Informations de base -->
                    <div class="space-y-4">
                        <h4 class="text-md font-medium text-gray-900">Informations de Base</h4>
                        
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom complet *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Jean Dupont" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                            @error('name')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Adresse email *</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="Adresse email" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                            @error('email')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" placeholder="+237 6XX XX XX XX" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                            @error('phone')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Rôle et permissions -->
                    <div class="space-y-4">
                        <h4 class="text-md font-medium text-gray-900">Rôle et Permissions</h4>
                        
                        <div class="space-y-2">
                            <label for="role" class="block text-sm font-medium text-gray-700">Rôle *</label>
                            <select name="role" id="role" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Sélectionner un rôle</option>
                                @php
                                    $roles = [
                                        'user' => 'Utilisateur',
                                        'restaurant_owner' => 'Propriétaire de Restaurant',
                                        'admin' => 'Administrateur',
                                        'super_admin' => 'Super Administrateur'
                                    ];
                                @endphp
                                @foreach($roles as $key => $label)
                                    <option value="{{ $key }}" {{ old('role') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe *</label>
                            <input type="password" name="password" id="password" required placeholder="Mot de passe sécurisé" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                            @error('password')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe *</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Confirmer le mot de passe" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        </div>
                    </div>
                </div>

                <!-- Informations supplémentaires -->
                <div class="space-y-4">
                    <h4 class="text-md font-medium text-gray-900">Informations Supplémentaires</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                            <textarea name="address" id="address" placeholder="Adresse complète de l'utilisateur" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" placeholder="Notes internes sur cet utilisateur" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Options -->
                <div class="space-y-4">
                    <h4 class="text-md font-medium text-gray-900">Options</h4>
                    
                    <div class="space-y-3">
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name="send_welcome_email" id="send_welcome_email" value="1" {{ old('send_welcome_email') ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                            <label for="send_welcome_email" class="text-sm text-gray-700">Envoyer un email de bienvenue</label>
                        </div>

                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                            <label for="is_active" class="text-sm text-gray-700">Compte actif</label>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        <i class="fas fa-user-plus w-4 h-4 mr-2"></i>
                        Créer l'utilisateur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection