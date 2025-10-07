@extends('layouts.marketing')

@section('title', 'Mon Profil - PeleFood')

@section('content')
<div class="section bg-gray-50">
    <div class="container">
        <div class="max-w-4xl mx-auto">
            <!-- Header du profil -->
            <div class="text-center mb-8 animate-on-scroll">
                <div class="w-24 h-24 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-3xl font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </span>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ auth()->user()->name }}</h1>
                <p class="text-gray-600">{{ auth()->user()->email }}</p>
                <div class="flex items-center justify-center gap-2 mt-3">
                    @foreach(auth()->user()->roles as $role)
                        <span class="px-3 py-1 bg-orange-100 text-orange-700 text-sm font-medium rounded-full">
                            {{ ucfirst($role->name) }}
                        </span>
                    @endforeach
                </div>
            </div>

            <!-- Navigation du profil -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-8 animate-on-scroll">
                <div class="flex flex-wrap border-b border-gray-200">
                    <a href="{{ route('profile.show') }}" class="px-6 py-4 text-orange-600 border-b-2 border-orange-500 font-medium">
                        <i class="fas fa-user mr-2"></i>Vue d'ensemble
                    </a>
                    <a href="{{ route('profile.edit') }}" class="px-6 py-4 text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </a>
                    <a href="{{ route('profile.security') }}" class="px-6 py-4 text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-shield-alt mr-2"></i>Sécurité
                    </a>
                    <a href="{{ route('profile.activity') }}" class="px-6 py-4 text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-history mr-2"></i>Activité
                    </a>
                </div>
            </div>

            <!-- Informations du profil -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Informations personnelles -->
                <div class="card animate-on-scroll">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">
                            <i class="fas fa-user-circle text-orange-500 mr-2"></i>
                            Informations personnelles
                        </h3>
                        <a href="{{ route('profile.edit') }}" class="text-orange-500 hover:text-orange-600 text-sm font-medium">
                            Modifier
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">Nom complet</span>
                            <span class="font-medium text-gray-900">{{ auth()->user()->name }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">Email</span>
                            <span class="font-medium text-gray-900">{{ auth()->user()->email }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">Membre depuis</span>
                            <span class="font-medium text-gray-900">{{ auth()->user()->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <span class="text-gray-600">Dernière connexion</span>
                            <span class="font-medium text-gray-900">{{ auth()->user()->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Statistiques du compte -->
                <div class="card animate-on-scroll">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">
                        <i class="fas fa-chart-bar text-blue-500 mr-2"></i>
                        Statistiques du compte
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-calendar-check text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Jours actif</p>
                                    <p class="text-sm text-gray-600">Depuis l'inscription</p>
                                </div>
                            </div>
                            <span class="text-2xl font-bold text-blue-600">
                                {{ auth()->user()->created_at->diffInDays(now()) }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Statut</p>
                                    <p class="text-sm text-gray-600">Compte vérifié</p>
                                </div>
                            </div>
                            <span class="text-green-600">
                                <i class="fas fa-check text-xl"></i>
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 bg-purple-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-star text-purple-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Niveau</p>
                                    <p class="text-sm text-gray-600">Utilisateur premium</p>
                                </div>
                            </div>
                            <span class="text-purple-600">
                                <i class="fas fa-crown text-xl"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="mt-8">
                <div class="card animate-on-scroll">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">
                        <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                        Actions rapides
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('profile.edit') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-orange-300 hover:bg-orange-50 transition-all group">
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-orange-200 transition-colors">
                                <i class="fas fa-edit text-orange-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Modifier le profil</p>
                                <p class="text-sm text-gray-600">Mettre à jour vos informations</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('profile.security') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all group">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-blue-200 transition-colors">
                                <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Sécurité</p>
                                <p class="text-sm text-gray-600">Changer le mot de passe</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('profile.activity') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition-all group">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4 group-hover:bg-green-200 transition-colors">
                                <i class="fas fa-history text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Activité</p>
                                <p class="text-sm text-gray-600">Voir l'historique</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Retour à l'accueil -->
            <div class="text-center mt-8 animate-on-scroll">
                <a href="{{ route('home') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 