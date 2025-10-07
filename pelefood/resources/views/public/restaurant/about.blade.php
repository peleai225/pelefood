@extends('layouts.public-restaurant')

@section('title', 'À propos - ' . $restaurant->name)
@section('description', 'Découvrez l\'histoire de ' . $restaurant->name)

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 overflow-hidden">
    @if($restaurant->cover_image)
        <div class="absolute inset-0">
            <img src="{{ $restaurant->cover_image_url }}" alt="{{ $restaurant->name }}" class="w-full h-full object-cover opacity-30">
        </div>
    @endif
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">À propos de nous</h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Découvrez l'histoire et la passion derrière {{ $restaurant->name }}
            </p>
        </div>
    </div>
</section>

<!-- Informations du restaurant -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Image -->
            <div>
                @if($restaurant->cover_image)
                    <img src="{{ $restaurant->cover_image_url }}" alt="{{ $restaurant->name }}" class="w-full h-96 object-cover rounded-2xl shadow-lg">
                @else
                    <div class="w-full h-96 bg-gray-200 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-utensils text-gray-400 text-6xl"></i>
                    </div>
                @endif
            </div>
            
            <!-- Contenu -->
            <div class="space-y-6">
                <h2 class="text-3xl font-bold text-gray-900">{{ $restaurant->name }}</h2>
                
                <p class="text-gray-600 text-lg leading-relaxed">
                    {{ $restaurant->description ?: 'Nous sommes passionnés par la cuisine et nous nous efforçons de vous offrir une expérience culinaire exceptionnelle. Chaque plat est préparé avec soin en utilisant les meilleurs ingrédients frais et locaux.' }}
                </p>
                
                <!-- Statistiques -->
                <div class="grid grid-cols-3 gap-6 pt-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-primary">{{ $stats['total_products'] }}</div>
                        <div class="text-sm text-gray-600">Plats</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-primary">{{ $stats['total_reviews'] }}</div>
                        <div class="text-sm text-gray-600">Avis clients</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-primary">{{ number_format($stats['average_rating'] ?? 0, 1) }}</div>
                        <div class="text-sm text-gray-600">Note moyenne</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Nos valeurs -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Nos valeurs</h2>
            <p class="text-gray-600">Ce qui nous guide au quotidien</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-leaf text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Ingrédients frais</h3>
                <p class="text-gray-600">Nous sélectionnons avec soin les meilleurs ingrédients locaux et de saison pour garantir la qualité de nos plats.</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Passion culinaire</h3>
                <p class="text-gray-600">Chaque plat est préparé avec passion et amour, en respectant les traditions culinaires et en innovant constamment.</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Service client</h3>
                <p class="text-gray-600">Votre satisfaction est notre priorité. Nous nous efforçons de vous offrir un service exceptionnel à chaque visite.</p>
            </div>
        </div>
    </div>
</section>

<!-- Horaires et contact -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Horaires -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Nos horaires</h2>
                <div class="space-y-4">
                    @if($restaurant->opening_time && $restaurant->closing_time)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <span class="font-medium text-gray-900">Ouvert</span>
                            <span class="text-gray-600">{{ $restaurant->opening_time }} - {{ $restaurant->closing_time }}</span>
                        </div>
                    @else
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <span class="font-medium text-gray-900">Horaires</span>
                            <span class="text-gray-600">Non définis</span>
                        </div>
                    @endif
                    
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <span class="font-medium text-gray-900">Statut</span>
                        @if($restaurant->is_open)
                            <span class="text-green-600 font-medium">Ouvert maintenant</span>
                        @else
                            <span class="text-red-600 font-medium">Fermé</span>
                        @endif
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <span class="font-medium text-gray-900">Livraison</span>
                        @if($restaurant->accepts_delivery)
                            <span class="text-green-600 font-medium">Disponible</span>
                        @else
                            <span class="text-gray-600">Non disponible</span>
                        @endif
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <span class="font-medium text-gray-900">À emporter</span>
                        @if($restaurant->accepts_takeaway)
                            <span class="text-green-600 font-medium">Disponible</span>
                        @else
                            <span class="text-gray-600">Non disponible</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Contact -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Nous contacter</h2>
                <div class="space-y-4">
                    @if($restaurant->phone)
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <div class="w-12 h-12 bg-gradient-primary rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Téléphone</p>
                                <a href="tel:{{ $restaurant->phone }}" class="text-primary hover:underline">{{ $restaurant->phone }}</a>
                            </div>
                        </div>
                    @endif
                    
                    @if($restaurant->email)
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <div class="w-12 h-12 bg-gradient-primary rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Email</p>
                                <a href="mailto:{{ $restaurant->email }}" class="text-primary hover:underline">{{ $restaurant->email }}</a>
                            </div>
                        </div>
                    @endif
                    
                    @if($restaurant->address)
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <div class="w-12 h-12 bg-gradient-primary rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Adresse</p>
                                <p class="text-gray-600">{{ $restaurant->address }}, {{ $restaurant->city }}</p>
                            </div>
                        </div>
                    @endif
                    
                    @if($restaurant->website_url)
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <div class="w-12 h-12 bg-gradient-primary rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-globe text-white"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Site web</p>
                                <a href="{{ $restaurant->website_url }}" target="_blank" class="text-primary hover:underline">Visiter le site</a>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Réseaux sociaux -->
                @if($restaurant->facebook_url || $restaurant->instagram_url)
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Suivez-nous</h3>
                        <div class="flex space-x-4">
                            @if($restaurant->facebook_url)
                                <a href="{{ $restaurant->facebook_url }}" target="_blank" 
                                   class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-white hover:bg-blue-700 transition-colors duration-200">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            @endif
                            @if($restaurant->instagram_url)
                                <a href="{{ $restaurant->instagram_url }}" target="_blank" 
                                   class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-white hover:opacity-90 transition-opacity duration-200">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-primary">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-white mb-6">Prêt à nous découvrir ?</h2>
        <p class="text-xl text-orange-100 mb-8">Commandez maintenant et découvrez notre cuisine</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('restaurant.public.menu', $restaurant->slug) }}" 
               class="bg-white text-primary px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg">
                <i class="fas fa-utensils mr-2"></i>
                Voir notre menu
            </a>
            
            <a href="{{ route('restaurant.public.contact', $restaurant->slug) }}" 
               class="border-2 border-white text-white px-8 py-4 rounded-xl font-semibold hover:bg-white hover:text-primary transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-envelope mr-2"></i>
                Nous contacter
            </a>
        </div>
    </div>
</section>
@endsection 