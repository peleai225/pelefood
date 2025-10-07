@extends('layouts.super-admin-new-design')

@section('title', 'Modifier l\'Utilisateur')
@section('description', 'Modifier les informations de l\'utilisateur')
@section('page-title', 'Modifier l\'Utilisateur')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
                    ← Retour à la liste
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations de base -->
                <div class="space-y-4">
                    <h4 class="text-md font-medium text-gray-900">Informations de Base</h4>
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nom complet *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                        <input type="password" name="password" id="password"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="Laisser vide pour ne pas changer">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                               placeholder="Confirmer le nouveau mot de passe">
                    </div>
                </div>

                <!-- Rôles et permissions -->
                <div class="space-y-4">
                    <h4 class="text-md font-medium text-gray-900">Rôles et Permissions</h4>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Rôles *</label>
                    <select name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                        @foreach($roles as $key => $label)
                            <option value="{{ $key }}" {{ old('role', $user->role) == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    </div>

                    <div class="pt-4">
                        <h5 class="text-sm font-medium text-gray-700 mb-2">Description des rôles :</h5>
                        <div class="text-xs text-gray-600 space-y-1">
                            <p><strong>super_admin :</strong> Accès complet à toute la plateforme</p>
                            <p><strong>admin :</strong> Gestion des restaurants et utilisateurs</p>
                            <p><strong>restaurant :</strong> Gestion de son propre restaurant</p>
                            <p><strong>customer :</strong> Client pouvant passer des commandes</p>
                        </div>
                    </div>

                    <div class="pt-4 p-3 bg-gray-50 rounded-lg">
                        <h5 class="text-sm font-medium text-gray-700 mb-2">Rôle actuel :</h5>
                        <div class="text-xs text-gray-600">
                            @if($user->role)
                                <span class="inline-block bg-purple-100 text-purple-800 px-2 py-1 rounded-full mr-2 mb-1">
                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                </span>
                            @else
                                <span class="text-gray-500">Aucun rôle assigné</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.users.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Annuler
                </a>
                <button type="submit" 
                        class="bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 