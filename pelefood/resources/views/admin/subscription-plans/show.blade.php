@extends('layouts.super-admin-new-design')

@section('title', 'Détails du Plan d\'Abonnement')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- En-tête de la page -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $subscriptionPlan->name }}</h1>
                <p class="mt-2 text-gray-600">Détails complets du plan d'abonnement</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.subscription-plans.edit', $subscriptionPlan) }}" 
                   class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-edit mr-2"></i>
                    Modifier
                </a>
                <a href="{{ route('admin.subscription-plans.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour aux Plans
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Informations principales -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Carte d'information -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-900">Informations du Plan</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        @if($subscriptionPlan->is_active) bg-green-100 text-green-800
                        @else bg-red-100 text-red-800
                        @endif">
                        @if($subscriptionPlan->is_active)
                            <i class="fas fa-check-circle mr-2"></i>Actif
                        @else
                            <i class="fas fa-times-circle mr-2"></i>Inactif
                        @endif
                    </span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Détails de base</h3>
                        <dl class="space-y-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nom</dt>
                                <dd class="text-sm text-gray-900">{{ $subscriptionPlan->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Type</dt>
                                <dd class="text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($subscriptionPlan->type === 'premium') bg-purple-100 text-purple-800
                                        @elseif($subscriptionPlan->type === 'enterprise') bg-indigo-100 text-indigo-800
                                        @elseif($subscriptionPlan->type === 'standard') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($subscriptionPlan->type) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Description</dt>
                                <dd class="text-sm text-gray-900">{{ $subscriptionPlan->description ?: 'Aucune description' }}</dd>
                            </div>
                        </dl>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Prix et facturation</h3>
                        <dl class="space-y-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Prix</dt>
                                <dd class="text-2xl font-bold text-green-600">{{ number_format($subscriptionPlan->price, 2) }}€</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Cycle de facturation</dt>
                                <dd class="text-sm text-gray-900">{{ ucfirst($subscriptionPlan->billing_cycle) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Durée</dt>
                                <dd class="text-sm text-gray-900">{{ $subscriptionPlan->duration_days ?? 'Illimitée' }} jours</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Limites du plan -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Limites du Plan</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-3 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-store text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Restaurants</h3>
                        <p class="text-3xl font-bold text-blue-600">
                            {{ $subscriptionPlan->max_restaurants ?: '∞' }}
                        </p>
                        <p class="text-sm text-gray-500">maximum</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-3 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-utensils text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Produits</h3>
                        <p class="text-3xl font-bold text-green-600">
                            {{ $subscriptionPlan->max_products ?: '∞' }}
                        </p>
                        <p class="text-sm text-gray-500">maximum</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-3 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-purple-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Utilisateurs</h3>
                        <p class="text-3xl font-bold text-purple-600">
                            {{ $subscriptionPlan->max_users ?: '∞' }}
                        </p>
                        <p class="text-sm text-gray-500">maximum</p>
                    </div>
                </div>
            </div>

            <!-- Fonctionnalités -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Fonctionnalités Incluses</h2>
                @php
                    $features = $subscriptionPlan->features ?? [];
                    if (is_string($features)) {
                        $features = json_decode($features, true) ?? [];
                    }
                @endphp
                
                @if(count($features) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($features as $feature)
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-3"></i>
                            <span class="text-gray-900">{{ ucfirst(str_replace('_', ' ', $feature)) }}</span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Aucune fonctionnalité spécifique définie</p>
                @endif
                
                @if($subscriptionPlan->custom_features)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Fonctionnalités personnalisées</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700 whitespace-pre-line">{{ $subscriptionPlan->custom_features }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Options et statuts -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Options et Statuts</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto mb-2 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-star text-blue-600"></i>
                        </div>
                        <h3 class="text-sm font-medium text-gray-900">Plan Populaire</h3>
                        <p class="text-lg font-semibold {{ $subscriptionPlan->is_popular ? 'text-green-600' : 'text-gray-400' }}">
                            {{ $subscriptionPlan->is_popular ? 'Oui' : 'Non' }}
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto mb-2 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-crown text-purple-600"></i>
                        </div>
                        <h3 class="text-sm font-medium text-gray-900">Plan en Vedette</h3>
                        <p class="text-lg font-semibold {{ $subscriptionPlan->is_featured ? 'text-green-600' : 'text-gray-400' }}">
                            {{ $subscriptionPlan->is_featured ? 'Oui' : 'Non' }}
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto mb-2 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-green-600"></i>
                        </div>
                        <h3 class="text-sm font-medium text-gray-900">Créé le</h3>
                        <p class="text-sm text-gray-600">{{ $subscriptionPlan->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar avec actions et statistiques -->
        <div class="space-y-6">
            <!-- Actions rapides -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Actions Rapides</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.subscription-plans.edit', $subscriptionPlan) }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 transition-colors">
                        <i class="fas fa-edit mr-2"></i>
                        Modifier le Plan
                    </a>
                    
                    <form method="POST" action="{{ route('admin.subscription-plans.destroy', $subscriptionPlan) }}" 
                          class="w-full" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce plan ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Supprimer le Plan
                        </button>
                    </form>
                    
                    <a href="{{ route('admin.subscription-plans.index') }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors">
                        <i class="fas fa-list mr-2"></i>
                        Voir Tous les Plans
                    </a>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Statistiques</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">ID du plan</span>
                        <span class="text-sm font-medium text-gray-900">#{{ $subscriptionPlan->id }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Dernière modification</span>
                        <span class="text-sm font-medium text-gray-900">{{ $subscriptionPlan->updated_at->format('d/m/Y') }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Statut</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            @if($subscriptionPlan->is_active) bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $subscriptionPlan->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Informations techniques -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informations Techniques</h3>
                <div class="space-y-3">
                    <div class="text-sm">
                        <span class="text-gray-500">Modèle:</span>
                        <span class="font-medium text-gray-900">{{ get_class($subscriptionPlan) }}</span>
                    </div>
                    <div class="text-sm">
                        <span class="text-gray-500">Table:</span>
                        <span class="font-medium text-gray-900">{{ $subscriptionPlan->getTable() }}</span>
                    </div>
                    <div class="text-sm">
                        <span class="text-gray-500">Clé primaire:</span>
                        <span class="font-medium text-gray-900">{{ $subscriptionPlan->getKeyName() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Confirmation de suppression
document.querySelector('form[method="POST"]').addEventListener('submit', function(e) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce plan d\'abonnement ? Cette action est irréversible.')) {
        e.preventDefault();
        return false;
    }
});

// Animation des cartes
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.bg-white');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endsection 