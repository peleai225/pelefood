@extends('layouts.super-admin-new-design')

@section('title', 'Détails du Restaurant - PeleFood')
@section('description', 'Détails du restaurant {{ $restaurant->name }}')
@section('page-title', 'Détails du Restaurant')

@section('content')
<div class="space-y-8">
    <!-- En-tête -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $restaurant->name }}</h1>
                <p class="text-gray-600 mt-2">Détails et informations du restaurant</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('admin.restaurants.edit', $restaurant) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Modifier
                </a>
                <a href="{{ route('admin.restaurants.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <!-- Informations générales -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Informations principales -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Carte d'information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations Générales</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom du restaurant</label>
                        <p class="text-gray-900">{{ $restaurant->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <p class="text-gray-900">{{ $restaurant->slug }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <p class="text-gray-900">{{ $restaurant->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <p class="text-gray-900">{{ $restaurant->phone }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                        <p class="text-gray-900">{{ $restaurant->address }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                        <p class="text-gray-900">{{ $restaurant->city }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pays</label>
                        <p class="text-gray-900">{{ $restaurant->country }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $restaurant->is_active ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $restaurant->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                </div>
                @if($restaurant->description)
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <p class="text-gray-900">{{ $restaurant->description }}</p>
                </div>
                @endif
            </div>

            <!-- Propriétaire -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Propriétaire</h2>
                @if($restaurant->user)
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center overflow-hidden">
                        @if($restaurant->user->profile_photo_path)
                            <img src="{{ $restaurant->user->profile_photo_path }}" alt="{{ $restaurant->user->name }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-user text-gray-600"></i>
                        @endif
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ $restaurant->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $restaurant->user->email }}</div>
                        <div class="text-sm text-gray-500">{{ $restaurant->user->phone ?? 'N/A' }}</div>
                    </div>
                </div>
                @else
                <p class="text-gray-500">Aucun propriétaire assigné</p>
                @endif
            </div>

            <!-- Statistiques -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Statistiques</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $restaurant->orders->count() }}</div>
                        <div class="text-sm text-gray-500">Commandes</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $restaurant->products->count() }}</div>
                        <div class="text-sm text-gray-500">Produits</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $restaurant->categories->count() }}</div>
                        <div class="text-sm text-gray-500">Catégories</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Image du restaurant -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Images</h3>
                
                @if($restaurant->logo)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                    <img src="{{ Storage::url($restaurant->logo) }}" alt="Logo" class="w-full h-32 object-cover rounded-lg" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center" style="display: none;">
                        <i class="fas fa-image text-gray-400 text-2xl"></i>
                    </div>
                </div>
                @endif

                @if($restaurant->cover_image)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Image de couverture</label>
                    <img src="{{ Storage::url($restaurant->cover_image) }}" alt="Image de couverture" class="w-full h-32 object-cover rounded-lg" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center" style="display: none;">
                        <i class="fas fa-image text-gray-400 text-2xl"></i>
                    </div>
                </div>
                @endif
            </div>

            <!-- Informations de livraison -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Livraison</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Type de livraison</label>
                        <p class="text-gray-900 capitalize">{{ $restaurant->delivery_type ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Frais de livraison</label>
                        <p class="text-gray-900">{{ number_format($restaurant->delivery_fee ?? 0, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Temps de livraison</label>
                        <p class="text-gray-900">{{ $restaurant->delivery_time ?? 'N/A' }} minutes</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rayon de livraison</label>
                        <p class="text-gray-900">{{ $restaurant->delivery_radius ?? 'N/A' }} km</p>
                    </div>
                </div>
            </div>

            <!-- Plan d'abonnement -->
            @if($restaurant->subscriptionPlan)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Plan d'Abonnement</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Plan</label>
                        <p class="text-gray-900">{{ $restaurant->subscriptionPlan->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prix</label>
                        <p class="text-gray-900">{{ number_format($restaurant->subscriptionPlan->price, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Statut</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ ucfirst($restaurant->subscription_status ?? 'N/A') }}
                        </span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Métadonnées -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Métadonnées</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Créé le</label>
                        <p class="text-gray-900">{{ $restaurant->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dernière modification</label>
                        <p class="text-gray-900">{{ $restaurant->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Devise</label>
                        <p class="text-gray-900">{{ $restaurant->currency ?? 'XOF' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Langue</label>
                        <p class="text-gray-900">{{ strtoupper($restaurant->language ?? 'fr') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
