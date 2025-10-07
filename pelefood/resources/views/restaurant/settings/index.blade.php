@extends('layouts.restaurant')

@section('content')
<!-- Token CSRF pour les requêtes AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="space-y-6">
    <!-- En-tête de la page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Paramètres du Restaurant</h1>
            <p class="mt-1 text-sm text-gray-600">Configurez votre restaurant et vos préférences</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <button onclick="saveSettings()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                <i class="fas fa-save mr-2"></i>
                Sauvegarder
            </button>
        </div>
    </div>

    <!-- Onglets de navigation -->
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <a href="#general" class="border-orange-500 text-orange-600 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                Général
            </a>
            <a href="#business" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                Informations Business
            </a>
            <a href="#theme" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                Thème & Couleurs
            </a>
            <a href="#delivery" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                Livraison
            </a>
            <a href="#notifications" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                Notifications
            </a>
        </nav>
    </div>

    <!-- Contenu des onglets -->
    <div class="space-y-6">
        <!-- Onglet Général -->
        <div id="general" class="space-y-6">
            <!-- Informations de base -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-info-circle text-orange-500 mr-2"></i>
                    Informations de base
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom du restaurant *</label>
                        <input type="text" id="restaurant-name" name="name" value="{{ $restaurant->name ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Nom de votre restaurant" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Slogan</label>
                        <input type="text" id="restaurant-slogan" name="slogan" value="{{ $restaurant->slogan ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Votre slogan">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea id="restaurant-description" name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Description de votre restaurant">{{ $restaurant->description ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site web</label>
                        <input type="url" id="restaurant-website" name="website" value="{{ $restaurant->website ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="https://votre-site.com">
                    </div>
                    
                    <!-- URL personnalisée du restaurant -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">URL personnalisée *</label>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500 bg-gray-100 px-3 py-2 rounded-l-lg border border-r-0 border-gray-300">pelefood.com/restaurant/</span>
                            <input type="text" id="restaurant-slug" value="{{ $restaurant->slug ?? 'mon-restaurant' }}" 
                                   class="flex-1 border border-gray-300 rounded-r-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" 
                                   placeholder="mon-restaurant">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            Cette URL sera : <span class="font-medium">pelefood.com/restaurant/<span id="slug-preview">{{ $restaurant->slug ?? 'mon-restaurant' }}</span></span>
                        </p>
                        <p class="text-xs text-gray-500">
                            Utilisez uniquement des lettres, chiffres et tirets. Ex: mon-restaurant, cuisine-africaine, etc.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Images du restaurant -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-images text-orange-500 mr-2"></i>
                    Images du restaurant
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Logo du restaurant -->
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-700">Logo du restaurant</label>
                        <div class="relative">
                            @if($restaurant->logo)
                                <img src="{{ asset('storage/' . $restaurant->logo) }}" alt="Logo" class="w-32 h-32 mx-auto border-2 border-gray-300 rounded-lg object-cover">
                            @else
                                <div class="w-32 h-32 mx-auto border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="text-center">
                                        <i class="fas fa-camera text-gray-400 text-2xl mb-2"></i>
                                        <p class="text-xs text-gray-500">Cliquez pour ajouter</p>
                                    </div>
                                </div>
                            @endif
                            <input type="file" id="logo-upload" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="uploadLogo(this)">
                        </div>
                        <p class="text-xs text-gray-500 text-center">Format: PNG, JPG. Max: 2MB</p>
                    </div>

                    <!-- Image de couverture -->
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-700">Image de couverture</label>
                        <div class="relative">
                            @if($restaurant->cover_image)
                                <img src="{{ asset('storage/' . $restaurant->cover_image) }}" alt="Couverture" class="w-32 h-32 mx-auto border-2 border-gray-300 rounded-lg object-cover">
                            @else
                                <div class="w-32 h-32 mx-auto border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="text-center">
                                        <i class="fas fa-image text-gray-400 text-2xl mb-2"></i>
                                        <p class="text-xs text-gray-500">Cliquez pour ajouter</p>
                                    </div>
                                </div>
                            @endif
                            <input type="file" id="cover-upload" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="uploadCover(this)">
                        </div>
                        <p class="text-xs text-gray-500 text-center">Format: PNG, JPG. Max: 5MB</p>
                    </div>

                    <!-- Galerie d'images -->
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-700">Galerie d'images</label>
                        <div class="relative">
                            <div class="w-32 h-32 mx-auto border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                <div class="text-center">
                                    <i class="fas fa-images text-gray-400 text-2xl mb-2"></i>
                                    <p class="text-xs text-gray-500">Cliquez pour ajouter</p>
                                </div>
                            </div>
                            <input type="file" id="gallery-upload" accept="image/*" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="uploadGallery(this)">
                        </div>
                        <p class="text-xs text-gray-500 text-center">Jusqu'à 10 images</p>
                        
                        <!-- Aperçu de la galerie -->
                        @if($restaurant->gallery_images && count($restaurant->gallery_images) > 0)
                            <div class="mt-3">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($restaurant->gallery_images as $index => $image)
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $image) }}" alt="Galerie" class="w-16 h-16 rounded object-cover">
                                            <button onclick="deleteGalleryImage({{ $index }})" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full text-xs hover:bg-red-600">×</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Onglet Informations Business -->
        <div id="business" class="space-y-6 hidden">
            <!-- Horaires d'ouverture -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-clock text-orange-500 mr-2"></i>
                    Horaires d'ouverture
                </h3>

                <div class="space-y-4">
                    @php
                        $days = [
                            'monday' => 'Lundi',
                            'tuesday' => 'Mardi', 
                            'wednesday' => 'Mercredi',
                            'thursday' => 'Jeudi',
                            'friday' => 'Vendredi',
                            'saturday' => 'Samedi',
                            'sunday' => 'Dimanche'
                        ];
                        $defaultHours = [
                            'monday' => ['open' => '08:00', 'close' => '22:00', 'is_open' => true],
                            'tuesday' => ['open' => '08:00', 'close' => '22:00', 'is_open' => true],
                            'wednesday' => ['open' => '08:00', 'close' => '22:00', 'is_open' => true],
                            'thursday' => ['open' => '08:00', 'close' => '22:00', 'is_open' => true],
                            'friday' => ['open' => '08:00', 'close' => '22:00', 'is_open' => true],
                            'saturday' => ['open' => '08:00', 'close' => '22:00', 'is_open' => true],
                            'sunday' => ['open' => '08:00', 'close' => '22:00', 'is_open' => false]
                        ];
                        $openingHours = $restaurant->opening_hours ?? $defaultHours;
                    @endphp
                    
                    @foreach($days as $dayKey => $dayName)
                    <div class="flex items-center space-x-4">
                        <div class="w-24">
                            <span class="text-sm font-medium text-gray-700">{{ $dayName }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <input type="time" 
                                   name="opening_hours[{{ $dayKey }}][open]"
                                   value="{{ $openingHours[$dayKey]['open'] ?? '08:00' }}" 
                                   class="border border-gray-300 rounded px-2 py-1 text-sm opening-hours-time">
                            <span class="text-gray-500">à</span>
                            <input type="time" 
                                   name="opening_hours[{{ $dayKey }}][close]"
                                   value="{{ $openingHours[$dayKey]['close'] ?? '22:00' }}" 
                                   class="border border-gray-300 rounded px-2 py-1 text-sm opening-hours-time">
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="open-{{ $dayKey }}" 
                                   name="opening_hours[{{ $dayKey }}][is_open]"
                                   value="1"
                                   {{ ($openingHours[$dayKey]['is_open'] ?? false) ? 'checked' : '' }}
                                   class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded opening-hours-checkbox"
                                   onchange="toggleDayHours('{{ $dayKey }}')">
                            <label for="open-{{ $dayKey }}" class="ml-2 text-sm text-gray-700">Ouvert</label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Informations de contact -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-phone text-orange-500 mr-2"></i>
                    Informations de contact
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone principal *</label>
                        <input type="tel" value="+225 07 12 34 56 78" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="+225 07 12 34 56 78">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone secondaire</label>
                        <input type="tel" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="+225 08 98 76 54 32">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" value="contact@pelefood.com" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="contact@restaurant.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp</label>
                        <input type="tel" value="+225 07 12 34 56 78" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Numéro WhatsApp">
                    </div>
                </div>
            </div>

            <!-- Adresse -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-map-marker-alt text-orange-500 mr-2"></i>
                    Adresse
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Adresse *</label>
                        <input type="text" value="{{ $restaurant->address ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Adresse complète">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ville *</label>
                        <input type="text" value="{{ $restaurant->city ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Votre ville">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Code postal</label>
                        <input type="text" value="{{ $restaurant->postal_code ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Code postal">
                    </div>
                </div>
            </div>
        </div>

        <!-- Onglet Livraison -->
        <div id="delivery" class="space-y-6 hidden">
            <!-- Zones de livraison -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-truck text-orange-500 mr-2"></i>
                    Zones de livraison
                </h3>

                <div class="space-y-4">
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <input type="text" value="Cocody" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Nom de la zone">
                        </div>
                        <div class="w-32">
                            <input type="number" value="500" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Frais">
                        </div>
                        <div class="w-32">
                            <input type="number" value="30" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Délai (min)">
                        </div>
                        <button type="button" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    
                    <button type="button" onclick="addDeliveryZone()" class="w-full flex items-center justify-center px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:text-gray-800 hover:border-gray-400 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Ajouter une zone de livraison
                    </button>
                </div>
            </div>

            <!-- Paramètres de livraison -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-cog text-orange-500 mr-2"></i>
                    Paramètres de livraison
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Délai de préparation moyen</label>
                        <div class="relative">
                            <input type="number" 
                                   id="preparation_time" 
                                   name="preparation_time"
                                   value="{{ $restaurant->preparation_time ?? 30 }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-12 focus:outline-none focus:ring-2 focus:ring-orange-500" 
                                   placeholder="30">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">min</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Commande minimum</label>
                        <div class="relative">
                            <input type="number" 
                                   id="minimum_order" 
                                   name="minimum_order"
                                   value="{{ $restaurant->minimum_order ?? 0 }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-16 focus:outline-none focus:ring-2 focus:ring-orange-500" 
                                   placeholder="0">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">{{ $restaurant->currency ?? 'FCFA' }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rayon de livraison max</label>
                        <div class="relative">
                            <input type="number" 
                                   id="delivery_radius" 
                                   name="delivery_radius"
                                   value="{{ $restaurant->delivery_radius ?? 10 }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-12 focus:outline-none focus:ring-2 focus:ring-orange-500" 
                                   placeholder="10">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">km</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Frais de livraison par défaut</label>
                        <div class="relative">
                            <input type="number" 
                                   id="delivery_fee" 
                                   name="delivery_fee"
                                   value="{{ $restaurant->delivery_fee ?? 0 }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-16 focus:outline-none focus:ring-2 focus:ring-orange-500" 
                                   placeholder="0">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">{{ $restaurant->currency ?? 'FCFA' }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Délai de livraison moyen</label>
                        <div class="relative">
                            <input type="number" 
                                   id="delivery_time" 
                                   name="delivery_time"
                                   value="{{ $restaurant->delivery_time ?? 30 }}" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-12 focus:outline-none focus:ring-2 focus:ring-orange-500" 
                                   placeholder="30">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">min</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Onglet Notifications -->
        <div id="notifications" class="space-y-6 hidden">
            <!-- Préférences de notifications -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-bell text-orange-500 mr-2"></i>
                    Préférences de notifications
                </h3>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Nouvelles commandes</h4>
                            <p class="text-sm text-gray-500">Recevoir une notification pour chaque nouvelle commande</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <input type="checkbox" id="notif-orders" checked class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <label for="notif-orders" class="text-sm text-gray-700">Activé</label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Commandes annulées</h4>
                            <p class="text-sm text-gray-500">Être informé des annulations de commandes</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <input type="checkbox" id="notif-cancellations" checked class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <label for="notif-cancellations" class="text-sm text-gray-700">Activé</label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Nouveaux avis</h4>
                            <p class="text-sm text-gray-500">Recevoir les nouveaux avis clients</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <input type="checkbox" id="notif-reviews" checked class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <label for="notif-reviews" class="text-sm text-gray-700">Activé</label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Alertes de stock</h4>
                            <p class="text-sm text-gray-500">Être alerté quand les produits sont en rupture</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <input type="checkbox" id="notif-stock" checked class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <label for="notif-stock" class="text-sm text-gray-700">Activé</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Méthodes de notification -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-mobile-alt text-orange-500 mr-2"></i>
                    Méthodes de notification
                </h3>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Notifications push</h4>
                            <p class="text-sm text-gray-500">Recevoir des notifications sur votre navigateur</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <input type="checkbox" id="push-notif" checked class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <label for="push-notif" class="text-sm text-gray-700">Activé</label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">SMS</h4>
                            <p class="text-sm text-gray-500">Recevoir des notifications par SMS</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <input type="checkbox" id="sms-notif" class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <label for="sms-notif" class="text-sm text-gray-700">Activé</label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Email</h4>
                            <p class="text-sm text-gray-500">Recevoir des notifications par email</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <input type="checkbox" id="email-notif" checked class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <label for="email-notif" class="text-sm text-gray-700">Activé</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Onglet Thème & Couleurs -->
        <div id="theme" class="space-y-6 hidden">
            <!-- Personnalisation des couleurs -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-palette text-orange-500 mr-2"></i>
                    Personnalisation des couleurs
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Couleur primaire -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Couleur primaire *</label>
                        <div class="flex items-center space-x-3">
                            <input type="color" id="primary-color" value="{{ $restaurant->theme_colors['primary'] ?? '#f97316' }}" class="w-16 h-12 border border-gray-300 rounded-lg cursor-pointer">
                            <div class="flex-1">
                                <input type="text" id="primary-color-hex" value="{{ $restaurant->theme_colors['primary'] ?? '#f97316' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="#f97316">
                                <p class="text-xs text-gray-500 mt-1">Couleur principale du site</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Couleur secondaire -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Couleur secondaire</label>
                        <div class="flex items-center space-x-3">
                            <input type="color" id="secondary-color" value="{{ $restaurant->theme_colors['secondary'] ?? '#ea580c' }}" class="w-16 h-12 border border-gray-300 rounded-lg cursor-pointer">
                            <div class="flex-1">
                                <input type="text" id="secondary-color-hex" value="{{ $restaurant->theme_colors['secondary'] ?? '#ea580c' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="#ea580c">
                                <p class="text-xs text-gray-500 mt-1">Couleur d'accent et hover</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Couleur d'accent -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Couleur d'accent</label>
                        <div class="flex items-center space-x-3">
                            <input type="color" id="accent-color" value="{{ $restaurant->theme_colors['accent'] ?? '#c2410c' }}" class="w-16 h-12 border border-gray-300 rounded-lg cursor-pointer">
                            <div class="flex-1">
                                <input type="text" id="accent-color-hex" value="{{ $restaurant->theme_colors['accent'] ?? '#c2410c' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="#c2410c">
                                <p class="text-xs text-gray-500 mt-1">Couleur pour les éléments spéciaux</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Couleur de texte -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Couleur de texte</label>
                        <div class="flex items-center space-x-3">
                            <input type="color" id="text-color" value="{{ $restaurant->theme_colors['text'] ?? '#1f2937' }}" class="w-16 h-12 border border-gray-300 rounded-lg cursor-pointer">
                            <div class="flex-1">
                                <input type="text" id="text-color-hex" value="{{ $restaurant->theme_colors['text'] ?? '#1f2937' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="#1f2937">
                                <p class="text-xs text-gray-500 mt-1">Couleur principale du texte</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Aperçu du thème -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Aperçu de votre thème</h4>
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 rounded-full" id="preview-primary"></div>
                        <div class="w-8 h-8 rounded-full" id="preview-secondary"></div>
                        <div class="w-8 h-8 rounded-full" id="preview-accent"></div>
                        <div class="w-8 h-8 rounded-full" id="preview-text"></div>
                        <span class="text-sm text-gray-500">Vos couleurs personnalisées</span>
                    </div>
                </div>
            </div>
            
            <!-- Thèmes prédéfinis -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-magic text-orange-500 mr-2"></i>
                    Thèmes prédéfinis
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <button onclick="applyTheme('orange')" class="theme-option p-4 border-2 border-gray-200 rounded-lg hover:border-orange-500 transition-colors text-left">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-6 h-6 bg-orange-500 rounded-full"></div>
                            <div class="w-6 h-6 bg-orange-600 rounded-full"></div>
                            <div class="w-6 h-6 bg-orange-700 rounded-full"></div>
                        </div>
                        <h4 class="font-medium text-gray-900">Orange Classique</h4>
                        <p class="text-sm text-gray-500">Thème par défaut chaleureux</p>
                    </button>
                    
                    <button onclick="applyTheme('blue')" class="theme-option p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 transition-colors text-left">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-6 h-6 bg-blue-500 rounded-full"></div>
                            <div class="w-6 h-6 bg-blue-600 rounded-full"></div>
                            <div class="w-6 h-6 bg-blue-700 rounded-full"></div>
                        </div>
                        <h4 class="font-medium text-gray-900">Bleu Professionnel</h4>
                        <p class="text-sm text-gray-500">Thème moderne et élégant</p>
                    </button>
                    
                    <button onclick="applyTheme('green')" class="theme-option p-4 border-2 border-gray-200 rounded-lg hover:border-green-500 transition-colors text-left">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-6 h-6 bg-green-500 rounded-full"></div>
                            <div class="w-6 h-6 bg-green-600 rounded-full"></div>
                            <div class="w-6 h-6 bg-green-700 rounded-full"></div>
                        </div>
                        <h4 class="font-medium text-gray-900">Vert Naturel</h4>
                        <p class="text-sm text-gray-500">Thème frais et organique</p>
                    </button>
                    
                    <button onclick="applyTheme('purple')" class="theme-option p-4 border-2 border-gray-200 rounded-lg hover:border-purple-500 transition-colors text-left">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-6 h-6 bg-purple-500 rounded-full"></div>
                            <div class="w-6 h-6 bg-purple-600 rounded-full"></div>
                            <div class="w-6 h-6 bg-purple-700 rounded-full"></div>
                        </div>
                        <h4 class="font-medium text-gray-900">Violet Créatif</h4>
                        <p class="text-sm text-gray-500">Thème artistique et unique</p>
                    </button>
                    
                    <button onclick="applyTheme('red')" class="theme-option p-4 border-2 border-gray-200 rounded-lg hover:border-red-500 transition-colors text-left">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-6 h-6 bg-red-500 rounded-full"></div>
                            <div class="w-6 h-6 bg-red-600 rounded-full"></div>
                            <div class="w-6 h-6 bg-red-700 rounded-full"></div>
                        </div>
                        <h4 class="font-medium text-gray-900">Rouge Énergique</h4>
                        <p class="text-sm text-gray-500">Thème dynamique et passionné</p>
                    </button>
                    
                    <button onclick="applyTheme('custom')" class="theme-option p-4 border-2 border-gray-200 rounded-lg hover:border-gray-500 transition-colors text-left">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-6 h-6 bg-gradient-to-r from-pink-500 to-yellow-500 rounded-full"></div>
                            <div class="w-6 h-6 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full"></div>
                            <div class="w-6 h-6 bg-gradient-to-r from-green-500 to-blue-500 rounded-full"></div>
                        </div>
                        <h4 class="font-medium text-gray-900">Personnalisé</h4>
                        <p class="text-sm text-gray-500">Utilisez vos propres couleurs</p>
                    </button>
                </div>
            </div>
            
            <!-- Aperçu en temps réel -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-eye text-orange-500 mr-2"></i>
                    Aperçu en temps réel
                </h3>
                
                <div class="p-6 rounded-lg" id="theme-preview" style="background: linear-gradient(135deg, var(--primary-color, #f97316) 0%, var(--secondary-color, #ea580c) 100%);">
                    <div class="text-center text-white">
                        <h4 class="text-xl font-bold mb-2">Votre Restaurant</h4>
                        <p class="mb-4">Aperçu de votre thème personnalisé</p>
                        <div class="flex justify-center space-x-3">
                            <button class="px-4 py-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition-all">
                                Commander
                            </button>
                            <button class="px-4 py-2 bg-white text-orange-600 rounded-lg hover:bg-gray-100 transition-all">
                                Menu
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Navigation des onglets
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('nav a');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Retirer la classe active de tous les onglets
            tabs.forEach(t => {
                t.classList.remove('border-orange-500', 'text-orange-600');
                t.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Ajouter la classe active à l'onglet cliqué
            this.classList.remove('border-transparent', 'text-gray-500');
            this.classList.add('border-orange-500', 'text-orange-600');
            
            // Masquer tous les contenus
            const allContents = document.querySelectorAll('[id="general"], [id="business"], [id="theme"], [id="delivery"], [id="notifications"]');
            allContents.forEach(content => content.classList.add('hidden'));
            
            // Afficher le contenu correspondant
            const targetId = this.getAttribute('href').substring(1);
            const targetContent = document.getElementById(targetId);
            if (targetContent) {
                targetContent.classList.remove('hidden');
            }
        });
    });
});

function saveSettings() {
    // Récupérer toutes les valeurs des formulaires
    const formData = {
        // Informations générales
        name: document.getElementById('restaurant-name').value,
        slogan: document.getElementById('restaurant-slogan').value,
        description: document.getElementById('restaurant-description').value,
        website: document.getElementById('restaurant-website').value,
        slug: document.getElementById('restaurant-slug').value,
        
        // Informations de contact (récupérées depuis l'onglet Business)
        phone: document.getElementById('phone-primary')?.value || '',
        email: document.getElementById('email-primary')?.value || '',
        address: document.getElementById('address')?.value || '',
        city: document.getElementById('city')?.value || '',
        postal_code: document.getElementById('postal_code')?.value || '',
        country: document.getElementById('country')?.value || 'Côte d\'Ivoire',
        
        // Paramètres de livraison
        minimum_order: document.getElementById('minimum_order')?.value || 0,
        delivery_fee: document.getElementById('delivery_fee')?.value || 0,
        delivery_radius: document.getElementById('delivery_radius')?.value || 10,
        preparation_time: document.getElementById('preparation_time')?.value || 30,
        delivery_time: document.getElementById('delivery_time')?.value || 30,
        
        // Zones de livraison
        delivery_zones: getDeliveryZones(),
        
        // Horaires d'ouverture
        opening_hours: getOpeningHours(),
        
        // Couleurs de thème
        theme_colors: {
            primary: document.getElementById('primary-color').value,
            secondary: document.getElementById('secondary-color').value,
            accent: document.getElementById('accent-color').value,
            text: document.getElementById('text-color').value
        },
        
        // Paramètres de notifications
        settings: {
            notifications: {
                orders: document.getElementById('notif-orders')?.checked || false,
                cancellations: document.getElementById('notif-cancellations')?.checked || false,
                reviews: document.getElementById('notif-reviews')?.checked || false,
                stock: document.getElementById('notif-stock')?.checked || false
            },
            notification_methods: {
                push: document.getElementById('push-notif')?.checked || false,
                sms: document.getElementById('sms-notif')?.checked || false,
                email: document.getElementById('email-notif')?.checked || false
            }
        }
    };
    
    // Envoyer les données
    fetch('{{ route("restaurant.settings.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => {
        // Vérifier si la réponse est du JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('La réponse du serveur n\'est pas du JSON');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            // Recharger la page pour afficher les nouvelles données
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification(data.message || 'Erreur lors de la sauvegarde', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur de connexion: ' + error.message, 'error');
    });
}

// Upload du logo
function uploadLogo(input) {
    if (input.files && input.files[0]) {
        const formData = new FormData();
        formData.append('logo', input.files[0]);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        fetch('{{ route("restaurant.settings.upload-logo") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                // Mettre à jour l'affichage
                const logoContainer = input.parentElement;
                logoContainer.innerHTML = `
                    <img src="${data.logo_url}" alt="Logo" class="w-32 h-32 mx-auto border-2 border-gray-300 rounded-lg object-cover">
                    <input type="file" id="logo-upload" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="uploadLogo(this)">
                `;
            } else {
                showNotification('Erreur lors de l\'upload du logo', 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur lors de l\'upload du logo', 'error');
        });
    }
}

// Upload de l'image de couverture
function uploadCover(input) {
    if (input.files && input.files[0]) {
        const formData = new FormData();
        formData.append('cover_image', input.files[0]);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        fetch('{{ route("restaurant.settings.upload-cover") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                // Mettre à jour l'affichage
                const coverContainer = input.parentElement;
                coverContainer.innerHTML = `
                    <img src="${data.cover_url}" alt="Couverture" class="w-32 h-32 mx-auto border-2 border-gray-300 rounded-lg object-cover">
                    <input type="file" id="cover-upload" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="uploadCover(this)">
                `;
            } else {
                showNotification('Erreur lors de l\'upload de l\'image de couverture', 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur lors de l\'upload de l\'image de couverture', 'error');
        });
    }
}

// Upload de la galerie
function uploadGallery(input) {
    if (input.files && input.files.length > 0) {
        const formData = new FormData();
        for (let i = 0; i < input.files.length; i++) {
            formData.append('gallery_images[]', input.files[i]);
        }
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        fetch('{{ route("restaurant.settings.upload-gallery") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                // Recharger la page pour afficher les nouvelles images
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification('Erreur lors de l\'upload de la galerie', 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur lors de l\'upload de la galerie', 'error');
        });
    }
}

// Supprimer une image de la galerie
function deleteGalleryImage(imageIndex) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
        fetch(`{{ route("restaurant.settings.delete-gallery-image", ":index") }}`.replace(':index', imageIndex), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                // Recharger la page pour afficher les changements
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification('Erreur lors de la suppression', 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur lors de la suppression', 'error');
        });
    }
}

// Fonction pour récupérer les zones de livraison
function getDeliveryZones() {
    const zones = [];
    const zoneItems = document.querySelectorAll('.delivery-zone-item');
    
    zoneItems.forEach(item => {
        const name = item.querySelector('input[placeholder="Nom de la zone"]')?.value;
        const fee = item.querySelector('input[placeholder="Frais"]')?.value;
        const deliveryTime = item.querySelector('input[placeholder="Délai (min)"]')?.value;
        
        if (name && name.trim() !== '') {
            zones.push({
                name: name.trim(),
                fee: parseFloat(fee) || 0,
                delivery_time: parseInt(deliveryTime) || 30
            });
        }
    });
    
    return zones;
}

function getOpeningHours() {
    const hours = {};
    const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    
    days.forEach(day => {
        const openInput = document.querySelector(`input[name="opening_hours[${day}][open]"]`);
        const closeInput = document.querySelector(`input[name="opening_hours[${day}][close]"]`);
        const isOpenCheckbox = document.querySelector(`input[name="opening_hours[${day}][is_open]"]`);
        
        if (openInput && closeInput && isOpenCheckbox) {
            hours[day] = {
                open: openInput.value || '08:00',
                close: closeInput.value || '22:00',
                is_open: isOpenCheckbox.checked
            };
        }
    });
    
    return hours;
}

function toggleDayHours(day) {
    const checkbox = document.querySelector(`input[name="opening_hours[${day}][is_open]"]`);
    const openInput = document.querySelector(`input[name="opening_hours[${day}][open]"]`);
    const closeInput = document.querySelector(`input[name="opening_hours[${day}][close]"]`);
    
    if (openInput && closeInput) {
        openInput.disabled = !checkbox.checked;
        closeInput.disabled = !checkbox.checked;
        
        if (!checkbox.checked) {
            openInput.style.opacity = '0.5';
            closeInput.style.opacity = '0.5';
        } else {
            openInput.style.opacity = '1';
            closeInput.style.opacity = '1';
        }
    }
}

// Initialiser l'état des champs d'horaires au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    days.forEach(day => {
        toggleDayHours(day);
    });
});

function addDeliveryZone() {
    const container = document.getElementById('delivery-zones-container');
    const zoneCount = container.querySelectorAll('.delivery-zone-item').length;
    
    const zoneHtml = `
        <div class="delivery-zone-item flex items-center space-x-4 p-4 bg-gray-50 rounded-lg mb-4">
            <div class="flex-1">
                <input type="text" placeholder="Nom de la zone" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <div class="w-32">
                <input type="number" placeholder="Frais" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <div class="w-32">
                <input type="number" placeholder="Délai (min)" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <button type="button" onclick="removeDeliveryZone(this)" class="text-red-600 hover:text-red-800">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', zoneHtml);
}

function removeDeliveryZone(button) {
    const zoneItem = button.closest('.delivery-zone-item');
    zoneItem.remove();
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        'bg-blue-500 text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Mise à jour du slug en temps réel
document.addEventListener('DOMContentLoaded', function() {
    const slugInput = document.getElementById('restaurant-slug');
    const slugPreview = document.getElementById('slug-preview');
    
    if (slugInput && slugPreview) {
        slugInput.addEventListener('input', function() {
            let value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9-]/g, '-') // Remplacer les caractères spéciaux par des tirets
                .replace(/-+/g, '-') // Éviter les tirets multiples
                .replace(/^-|-$/g, ''); // Enlever les tirets au début et à la fin
            
            this.value = value;
            slugPreview.textContent = value || 'mon-restaurant';
        });
    }
    
    // Initialisation des couleurs
    initializeColorPickers();
    updateThemePreview();
});

// Gestion des couleurs
function initializeColorPickers() {
    const colorInputs = document.querySelectorAll('input[type="color"]');
    const hexInputs = document.querySelectorAll('input[id$="-hex"]');
    
    // Synchroniser les inputs de couleur avec les inputs hex
    colorInputs.forEach((colorInput, index) => {
        colorInput.addEventListener('input', function() {
            hexInputs[index].value = this.value;
            updateThemePreview();
        });
    });
    
    hexInputs.forEach((hexInput, index) => {
        hexInput.addEventListener('input', function() {
            if (this.value.match(/^#[0-9A-F]{6}$/i)) {
                colorInputs[index].value = this.value;
                updateThemePreview();
            }
        });
    });
}

// Appliquer un thème prédéfini
function applyTheme(themeName) {
    const themes = {
        orange: {
            primary: '#f97316',
            secondary: '#ea580c',
            accent: '#c2410c',
            text: '#1f2937'
        },
        blue: {
            primary: '#3b82f6',
            secondary: '#2563eb',
            accent: '#1d4ed8',
            text: '#1f2937'
        },
        green: {
            primary: '#10b981',
            secondary: '#059669',
            accent: '#047857',
            text: '#1f2937'
        },
        purple: {
            primary: '#8b5cf6',
            secondary: '#7c3aed',
            accent: '#6d28d9',
            text: '#1f2937'
        },
        red: {
            primary: '#ef4444',
            secondary: '#dc2626',
            accent: '#b91c1c',
            text: '#1f2937'
        }
    };
    
    if (themes[themeName]) {
        const theme = themes[themeName];
        document.getElementById('primary-color').value = theme.primary;
        document.getElementById('primary-color-hex').value = theme.primary;
        document.getElementById('secondary-color').value = theme.secondary;
        document.getElementById('secondary-color-hex').value = theme.secondary;
        document.getElementById('accent-color').value = theme.accent;
        document.getElementById('accent-color-hex').value = theme.accent;
        document.getElementById('text-color').value = theme.text;
        document.getElementById('text-color-hex').value = theme.text;
        
        updateThemePreview();
        showNotification(`Thème ${themeName} appliqué !`, 'success');
    }
}

// Mettre à jour l'aperçu du thème
function updateThemePreview() {
    const primaryColor = document.getElementById('primary-color').value;
    const secondaryColor = document.getElementById('secondary-color').value;
    const accentColor = document.getElementById('accent-color').value;
    const textColor = document.getElementById('text-color').value;
    
    // Mettre à jour les aperçus de couleurs
    document.getElementById('preview-primary').style.backgroundColor = primaryColor;
    document.getElementById('preview-secondary').style.backgroundColor = secondaryColor;
    document.getElementById('preview-accent').style.backgroundColor = accentColor;
    document.getElementById('preview-text').style.backgroundColor = textColor;
    
    // Mettre à jour l'aperçu du thème
    const themePreview = document.getElementById('theme-preview');
    themePreview.style.background = `linear-gradient(135deg, ${primaryColor} 0%, ${secondaryColor} 100%)`;
    
    // Mettre à jour les variables CSS pour l'aperçu
    themePreview.style.setProperty('--primary-color', primaryColor);
    themePreview.style.setProperty('--secondary-color', secondaryColor);
    themePreview.style.setProperty('--accent-color', accentColor);
    themePreview.style.setProperty('--text-color', textColor);
}
</script>
@endpush
@endsection 