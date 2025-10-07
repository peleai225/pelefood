@extends('layouts.restaurant')

@section('title', 'Mon Restaurant')
@section('page-title', 'Mon Restaurant')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- En-tête du restaurant -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Image de couverture -->
        @if($restaurant->cover_image)
            <div class="h-48 bg-cover bg-center" style="background-image: url('{{ Storage::url($restaurant->cover_image) }}')"></div>
        @else
            <div class="h-48 bg-gradient-to-r from-orange-400 to-orange-600"></div>
        @endif
        
        <!-- Informations du restaurant -->
        <div class="p-6">
            <div class="flex items-start space-x-4">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    @if($restaurant->logo)
                        <img src="{{ Storage::url($restaurant->logo) }}" alt="Logo" class="w-20 h-20 rounded-lg object-cover border-4 border-white shadow-lg">
                    @else
                        <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-utensils text-2xl text-gray-400"></i>
                        </div>
                    @endif
                </div>
                
                <!-- Informations principales -->
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $restaurant->name }}</h1>
                    @if($restaurant->slogan)
                        <p class="text-lg text-gray-600 mb-3">{{ $restaurant->slogan }}</p>
                    @endif
                    @if($restaurant->description)
                        <p class="text-gray-700 mb-4">{{ $restaurant->description }}</p>
                    @endif
                    
                    <!-- Statut -->
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $restaurant->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            <i class="fas fa-circle text-xs mr-2"></i>
                            {{ $restaurant->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                        @if($restaurant->is_verified)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-check-circle text-xs mr-2"></i>
                                Vérifié
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex space-x-3">
                    <a href="{{ route('restaurant.restaurants.edit', $restaurant) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <i class="fas fa-edit mr-2"></i>
                        Modifier
                    </a>
                    <a href="{{ route('restaurant.dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Informations détaillées -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <!-- Informations de contact -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations de contact</h3>
            <div class="space-y-3">
                <div class="flex items-center">
                    <i class="fas fa-phone text-gray-400 w-5 mr-3"></i>
                    <span class="text-gray-700">{{ $restaurant->phone }}</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-envelope text-gray-400 w-5 mr-3"></i>
                    <span class="text-gray-700">{{ $restaurant->email }}</span>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-map-marker-alt text-gray-400 w-5 mr-3 mt-1"></i>
                    <div>
                        <p class="text-gray-700">{{ $restaurant->address }}</p>
                        <p class="text-gray-500">{{ $restaurant->city }}, {{ $restaurant->country }}</p>
                        @if($restaurant->postal_code)
                            <p class="text-gray-500">{{ $restaurant->postal_code }}</p>
                        @endif
                    </div>
                </div>
                @if($restaurant->website)
                    <div class="flex items-center">
                        <i class="fas fa-globe text-gray-400 w-5 mr-3"></i>
                        <a href="{{ $restaurant->website }}" target="_blank" class="text-orange-600 hover:text-orange-700">
                            {{ $restaurant->website }}
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Services -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Services</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-gray-700">Livraison</span>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $restaurant->accepts_delivery ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $restaurant->accepts_delivery ? 'Disponible' : 'Non disponible' }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-700">À emporter</span>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $restaurant->accepts_takeaway ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $restaurant->accepts_takeaway ? 'Disponible' : 'Non disponible' }}
                    </span>
                </div>
                @if($restaurant->delivery_fee)
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Frais de livraison</span>
                        <span class="text-gray-900 font-medium">{{ number_format($restaurant->delivery_fee, 0, ',', ' ') }} {{ $restaurant->currency ?? 'XOF' }}</span>
                    </div>
                @endif
                @if($restaurant->minimum_order)
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Commande minimum</span>
                        <span class="text-gray-900 font-medium">{{ number_format($restaurant->minimum_order, 0, ',', ' ') }} {{ $restaurant->currency ?? 'XOF' }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Horaires d'ouverture -->
        @if($restaurant->opening_hours)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Horaires d'ouverture</h3>
                <div class="space-y-2">
                    @foreach($restaurant->opening_hours as $day => $hours)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700 capitalize">{{ ucfirst($day) }}</span>
                            <span class="text-gray-900">
                                @if($hours['is_open'])
                                    {{ $hours['open'] }} - {{ $hours['close'] }}
                                @else
                                    <span class="text-red-600">Fermé</span>
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Statistiques -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistiques</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-orange-600">{{ $restaurant->total_orders ?? 0 }}</div>
                    <div class="text-sm text-gray-500">Commandes</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-orange-600">{{ $restaurant->total_reviews ?? 0 }}</div>
                    <div class="text-sm text-gray-500">Avis</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-orange-600">{{ number_format($restaurant->rating ?? 0, 1) }}</div>
                    <div class="text-sm text-gray-500">Note moyenne</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-orange-600">{{ number_format($restaurant->total_revenue ?? 0, 0, ',', ' ') }}</div>
                    <div class="text-sm text-gray-500">Chiffre d'affaires</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
