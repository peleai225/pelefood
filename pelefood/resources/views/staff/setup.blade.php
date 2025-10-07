@extends('layouts.staff')

@section('title', 'Configuration requise')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center">
                <!-- Icône -->
                <div class="mx-auto w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-2xl"></i>
                </div>
                
                <!-- Titre -->
                <h1 class="text-2xl font-bold text-gray-900 mb-4">Configuration requise</h1>
                
                <!-- Message -->
                <p class="text-gray-600 mb-6">
                    Votre compte n'est pas encore configuré pour accéder à l'interface staff. 
                    Veuillez contacter votre administrateur pour configurer votre restaurant.
                </p>
                
                <!-- Informations du compte -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h3 class="text-sm font-medium text-gray-900 mb-2">Informations de votre compte</h3>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p><span class="font-medium">Nom:</span> {{ auth()->user()->name }}</p>
                        <p><span class="font-medium">Email:</span> {{ auth()->user()->email }}</p>
                        <p><span class="font-medium">Rôle:</span> {{ ucfirst(auth()->user()->role) }}</p>
                        <p><span class="font-medium">Tenant:</span> {{ auth()->user()->tenant ? auth()->user()->tenant->name : 'Aucun' }}</p>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="space-y-3">
                    <a href="{{ route('profile.edit') }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-300 inline-block">
                        <i class="fas fa-user-edit mr-2"></i>Modifier mon profil
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline-block w-full">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-300">
                            <i class="fas fa-sign-out-alt mr-2"></i>Se déconnecter
                        </button>
                    </form>
                </div>
                
                <!-- Contact -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <p class="text-xs text-gray-500">
                        Besoin d'aide ? Contactez votre administrateur ou 
                        <a href="mailto:support@pelefood.ci" class="text-blue-600 hover:text-blue-800">notre équipe support</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 