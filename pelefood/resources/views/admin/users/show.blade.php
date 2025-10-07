@extends('layouts.super-admin-new-design')

@section('title', 'Détails de l\'Utilisateur - PeleFood')
@section('description', 'Détails de l\'utilisateur {{ $user->name }}')
@section('page-title', 'Détails de l\'Utilisateur')

@section('content')
<div class="space-y-8">
    <!-- En-tête -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                <p class="text-gray-600 mt-2">Détails et informations de l'utilisateur</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('admin.users.edit', $user) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Modifier
                </a>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                        <p class="text-gray-900">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <p class="text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <p class="text-gray-900">{{ $user->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
                        @switch($user->role)
                            @case('super_admin')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Super Admin
                                </span>
                                @break
                            @case('admin')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    Admin
                                </span>
                                @break
                            @case('restaurant_owner')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Restaurateur
                                </span>
                                @break
                            @case('customer')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Client
                                </span>
                                @break
                            @default
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $user->role }}
                                </span>
                        @endswitch
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut email</label>
                        @if($user->email_verified_at)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Vérifié
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Non vérifié
                            </span>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut compte</label>
                        @if($user->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Actif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Inactif
                            </span>
                        @endif
                    </div>
                </div>
                
                @if($user->address || $user->city)
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                    <p class="text-gray-900">
                        {{ $user->address }}
                        @if($user->city)
                            , {{ $user->city }}
                        @endif
                        @if($user->postal_code)
                            , {{ $user->postal_code }}
                        @endif
                        @if($user->country)
                            , {{ $user->country }}
                        @endif
                    </p>
                </div>
                @endif
            </div>

            <!-- Restaurant associé -->
            @if($user->restaurant)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Restaurant Associé</h2>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                        @if($user->restaurant->logo_url)
                            <img src="{{ $user->restaurant->logo_url }}" alt="{{ $user->restaurant->name }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-store text-gray-600"></i>
                        @endif
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">{{ $user->restaurant->name }}</div>
                        <div class="text-sm text-gray-500">{{ $user->restaurant->slug }}</div>
                        <div class="text-sm text-gray-500">{{ $user->restaurant->city }}, {{ $user->restaurant->country }}</div>
                    </div>
                    <div class="ml-auto">
                        <a href="{{ route('admin.restaurants.show', $user->restaurant) }}" class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Statistiques des commandes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Statistiques des Commandes</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $user->orders->count() }}</div>
                        <div class="text-sm text-gray-500">Total commandes</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $user->orders->where('status', 'delivered')->count() }}</div>
                        <div class="text-sm text-gray-500">Commandes livrées</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ number_format($user->orders->sum('total_amount'), 0, ',', ' ') }} FCFA</div>
                        <div class="text-sm text-gray-500">Montant total</div>
                    </div>
                </div>
            </div>

            <!-- Dernières commandes -->
            @if($user->orders->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Dernières Commandes</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commande</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restaurant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($user->orders->take(5) as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $order->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->restaurant->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($order->total_amount, 0, ',', ' ') }} FCFA
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @switch($order->status)
                                        @case('pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                En attente
                                            </span>
                                            @break
                                        @case('confirmed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Confirmée
                                            </span>
                                            @break
                                        @case('preparing')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                En préparation
                                            </span>
                                            @break
                                        @case('delivered')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Livrée
                                            </span>
                                            @break
                                        @case('cancelled')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Annulée
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('d/m/Y') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Photo de profil -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Photo de Profil</h3>
                <div class="flex justify-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center overflow-hidden">
                        @if($user->profile_photo_path)
                            <img src="{{ $user->profile_photo_path }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-user text-gray-400 text-2xl"></i>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Métadonnées -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Métadonnées</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Créé le</label>
                        <p class="text-gray-900">{{ $user->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dernière modification</label>
                        <p class="text-gray-900">{{ $user->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    @if($user->email_verified_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email vérifié le</label>
                        <p class="text-gray-900">{{ $user->email_verified_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    @endif
                    @if($user->last_login_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dernière connexion</label>
                        <p class="text-gray-900">{{ $user->last_login_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Tenant -->
            @if($user->tenant)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tenant</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom</label>
                        <p class="text-gray-900">{{ $user->tenant->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Domaine</label>
                        <p class="text-gray-900">{{ $user->tenant->domain }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Actions rapides -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions Rapides</h3>
                <div class="space-y-3">
                    @if(!$user->email_verified_at)
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="email_verified_at" value="{{ now() }}">
                        <button type="submit" class="w-full text-left px-3 py-2 text-sm text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                            <i class="fas fa-check mr-2"></i>
                            Vérifier l'email
                        </button>
                    </form>
                    @endif
                    
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="is_active" value="{{ $user->is_active ? '0' : '1' }}">
                        <button type="submit" class="w-full text-left px-3 py-2 text-sm {{ $user->is_active ? 'text-red-600 hover:bg-red-50' : 'text-green-600 hover:bg-green-50' }} rounded-lg transition-colors">
                            <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }} mr-2"></i>
                            {{ $user->is_active ? 'Désactiver le compte' : 'Activer le compte' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection