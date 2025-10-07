@extends('layouts.staff')

@section('title', 'Profil Staff - ' . $restaurant->name)

@section('content')
<div class="space-y-8 max-w-4xl mx-auto">
    <!-- En-tête -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-user-tie text-purple-600 mr-3"></i>
                    Profil Staff
                </h1>
                <p class="text-gray-600 mt-2">Gestion de votre compte personnel</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('profile.edit') }}" 
                   class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Modifier
                </a>
                <a href="{{ route('staff.dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour
                </a>
            </div>
        </div>
    </div>

    <!-- Informations principales -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Informations personnelles -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div class="flex items-center mb-6">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-user text-2xl text-purple-600"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-purple-600 font-medium">{{ ucfirst($user->role) }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-envelope text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium text-gray-900">{{ $user->email }}</p>
                    </div>
                </div>

                @if($user->phone)
                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-phone text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Téléphone</p>
                        <p class="font-medium text-gray-900">{{ $user->phone }}</p>
                    </div>
                </div>
                @endif

                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-calendar text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Membre depuis</p>
                        <p class="font-medium text-gray-900">{{ $user->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations du restaurant -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div class="flex items-center mb-6">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-store text-2xl text-orange-600"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ $restaurant->name }}</h2>
                    <p class="text-orange-600 font-medium">Restaurant assigné</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-map-marker-alt text-orange-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Adresse</p>
                        <p class="font-medium text-gray-900">{{ $restaurant->address ?? 'Non définie' }}</p>
                    </div>
                </div>

                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Statut du restaurant</p>
                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $restaurant->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $restaurant->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-clock text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Dernière activité</p>
                        <p class="font-medium text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-bolt text-yellow-600 mr-2"></i>
            Actions rapides
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('staff.orders') }}" 
               class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                <i class="fas fa-shopping-cart text-green-600 mr-3 text-xl"></i>
                <div>
                    <span class="text-gray-900 font-medium">Commandes</span>
                    <p class="text-sm text-gray-600">Gérer les commandes</p>
                </div>
            </a>
            
            <a href="{{ route('staff.dashboard') }}" 
               class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                <i class="fas fa-tachometer-alt text-blue-600 mr-3 text-xl"></i>
                <div>
                    <span class="text-gray-900 font-medium">Tableau de bord</span>
                    <p class="text-sm text-gray-600">Voir les statistiques</p>
                </div>
            </a>
            
            <a href="{{ route('profile.change-password') }}" 
               class="flex items-center p-4 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                <i class="fas fa-key text-red-600 mr-3 text-xl"></i>
                <div>
                    <span class="text-gray-900 font-medium">Mot de passe</span>
                    <p class="text-sm text-gray-600">Changer le mot de passe</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Sécurité -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-shield-alt text-red-600 mr-2"></i>
            Sécurité et paramètres
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('profile.security') }}" 
               class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                <i class="fas fa-lock text-yellow-600 mr-3"></i>
                <span class="text-gray-900">Paramètres de sécurité</span>
            </a>
            
            <a href="{{ route('profile.activity') }}" 
               class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                <i class="fas fa-history text-green-600 mr-3"></i>
                <span class="text-gray-900">Historique d'activité</span>
            </a>
        </div>
    </div>
</div>
@endsection 