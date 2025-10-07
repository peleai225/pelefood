@extends('layouts.restaurant')

@section('title', 'Mon restaurant')
@section('page-title', 'Mon restaurant')

@section('content')
<div class="space-y-6">
    @if($restaurants->count() > 0)
        <!-- Restaurant existant -->
        @foreach($restaurants as $restaurant)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-start justify-between">
                <div class="flex items-center space-x-4">
                    @if($restaurant->logo)
                        <img src="{{ asset('storage/' . $restaurant->logo) }}" alt="{{ $restaurant->name }}" class="w-16 h-16 object-cover rounded-lg">
                    @else
                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-utensils text-gray-400 text-2xl"></i>
                        </div>
                    @endif
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $restaurant->name }}</h2>
                        <p class="text-gray-600">{{ $restaurant->description ?: 'Aucune description' }}</p>
                        <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                            <span><i class="fas fa-phone mr-1"></i>{{ $restaurant->phone }}</span>
                            <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $restaurant->address }}, {{ $restaurant->city }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $restaurant->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $restaurant->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                    <a href="{{ route('restaurant.restaurants.edit', $restaurant) }}"
                       class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </a>
                </div>
            </div>

            <!-- Informations supplémentaires -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="font-medium text-gray-900 mb-2">Horaires</h3>
                    <p class="text-sm text-gray-600">
                        {{ $restaurant->opening_time }} - {{ $restaurant->closing_time }}
                    </p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="font-medium text-gray-900 mb-2">Services</h3>
                    <div class="flex flex-wrap gap-2">
                        @if($restaurant->accepts_delivery)
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                <i class="fas fa-truck mr-1"></i>Livraison
                            </span>
                        @endif
                        @if($restaurant->accepts_takeaway)
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                <i class="fas fa-shopping-bag mr-1"></i>À emporter
                            </span>
                        @endif
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="font-medium text-gray-900 mb-2">Statistiques</h3>
                    <div class="text-sm text-gray-600">
                        <p>Produits: {{ $restaurant->products->count() }}</p>
                        <p>Commandes: {{ $restaurant->orders->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <!-- Aucun restaurant -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <div class="mx-auto w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-utensils text-orange-600 text-3xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Aucun restaurant configuré</h2>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                Vous devez d'abord configurer votre restaurant pour commencer à utiliser PeleFood.
            </p>
            <a href="{{ route('restaurant.restaurants.create') }}"
               class="inline-flex items-center px-6 py-3 bg-orange-500 text-white font-medium rounded-lg hover:bg-orange-600 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Créer mon restaurant
            </a>
        </div>
    @endif
</div>
@endsection 