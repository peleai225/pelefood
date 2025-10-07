@extends('layouts.public-restaurant')

@section('title', 'Contact - ' . $restaurant->name)
@section('description', 'Contactez ' . $restaurant->name . ' - Nous sommes là pour vous aider')

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
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Contactez-nous</h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Nous sommes là pour répondre à toutes vos questions
            </p>
        </div>
    </div>
</section>

<!-- Informations de contact -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Informations -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Nos coordonnées</h2>
                    <p class="text-gray-600 text-lg">
                        N'hésitez pas à nous contacter pour toute question, réservation ou suggestion. Nous serons ravis de vous aider !
                    </p>
                </div>
                
                <!-- Contact details -->
                <div class="space-y-6">
                    @if($restaurant->phone)
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-gradient-primary rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Téléphone</h3>
                                <a href="tel:{{ $restaurant->phone }}" class="text-primary hover:underline text-lg">{{ $restaurant->phone }}</a>
                                <p class="text-gray-600 text-sm mt-1">Appelez-nous pour commander ou poser vos questions</p>
                            </div>
                        </div>
                    @endif
                    
                    @if($restaurant->email)
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-gradient-primary rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Email</h3>
                                <a href="mailto:{{ $restaurant->email }}" class="text-primary hover:underline text-lg">{{ $restaurant->email }}</a>
                                <p class="text-gray-600 text-sm mt-1">Envoyez-nous un email pour toute demande</p>
                            </div>
                        </div>
                    @endif
                    
                    @if($restaurant->address)
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-gradient-primary rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Adresse</h3>
                                <p class="text-gray-900 text-lg">{{ $restaurant->address }}</p>
                                <p class="text-gray-600 text-lg">{{ $restaurant->city }}</p>
                                @if($restaurant->postal_code)
                                    <p class="text-gray-600 text-lg">{{ $restaurant->postal_code }}</p>
                                @endif
                                <p class="text-gray-600 text-sm mt-1">Venez nous rendre visite</p>
                            </div>
                        </div>
                    @endif
                    
                    @if($restaurant->opening_time && $restaurant->closing_time)
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-gradient-primary rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Horaires d'ouverture</h3>
                                <p class="text-gray-900 text-lg">{{ $restaurant->opening_time }} - {{ $restaurant->closing_time }}</p>
                                <p class="text-gray-600 text-sm mt-1">Ouvert tous les jours</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Réseaux sociaux -->
                @if($restaurant->facebook_url || $restaurant->instagram_url)
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-4">Suivez-nous</h3>
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
            
            <!-- Formulaire de contact -->
            <div class="bg-gray-50 rounded-2xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Envoyez-nous un message</h2>
                
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                            <input type="text" name="first_name" id="first_name" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                            <input type="text" name="last_name" id="last_name" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" id="email" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                        <input type="tel" name="phone" id="phone"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Sujet *</label>
                        <select name="subject" id="subject" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                            <option value="">Sélectionnez un sujet</option>
                            <option value="commande">Question sur une commande</option>
                            <option value="menu">Question sur le menu</option>
                            <option value="reservation">Réservation</option>
                            <option value="suggestion">Suggestion</option>
                            <option value="reclamation">Réclamation</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                        <textarea name="message" id="message" rows="5" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary"
                                  placeholder="Décrivez votre demande..."></textarea>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" name="newsletter" id="newsletter" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="newsletter" class="ml-2 text-sm text-gray-700">
                            Je souhaite recevoir les actualités et offres spéciales
                        </label>
                    </div>
                    
                    <button type="submit" class="w-full bg-gradient-primary text-white py-4 rounded-xl font-semibold hover:opacity-90 transition-opacity duration-200">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Envoyer le message
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Questions fréquentes</h2>
            <p class="text-gray-600">Trouvez rapidement les réponses à vos questions</p>
        </div>
        
        <div class="space-y-6" x-data="{ open: null }">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <button @click="open = open === 1 ? null : 1" class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors duration-200">
                    <span class="font-semibold text-gray-900">Comment puis-je commander ?</span>
                    <i class="fas fa-chevron-down text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': open === 1 }"></i>
                </button>
                <div x-show="open === 1" x-transition class="px-6 pb-4">
                    <p class="text-gray-600">Vous pouvez commander directement depuis notre menu en ligne, par téléphone au {{ $restaurant->phone ?? 'notre numéro' }}, ou venir nous rendre visite sur place.</p>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <button @click="open = open === 2 ? null : 2" class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors duration-200">
                    <span class="font-semibold text-gray-900">Quels sont vos horaires d'ouverture ?</span>
                    <i class="fas fa-chevron-down text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': open === 2 }"></i>
                </button>
                <div x-show="open === 2" x-transition class="px-6 pb-4">
                    <p class="text-gray-600">Nous sommes ouverts de {{ $restaurant->opening_time ?? 'l\'ouverture' }} à {{ $restaurant->closing_time ?? 'la fermeture' }} tous les jours.</p>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <button @click="open = open === 3 ? null : 3" class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors duration-200">
                    <span class="font-semibold text-gray-900">Proposez-vous la livraison ?</span>
                    <i class="fas fa-chevron-down text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': open === 3 }"></i>
                </button>
                <div x-show="open === 3" x-transition class="px-6 pb-4">
                    <p class="text-gray-600">@if($restaurant->accepts_delivery)Oui, nous proposons la livraison à domicile.@else Non, nous proposons uniquement la vente à emporter.@endif</p>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <button @click="open = open === 4 ? null : 4" class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors duration-200">
                    <span class="font-semibold text-gray-900">Puis-je faire une réservation ?</span>
                    <i class="fas fa-chevron-down text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': open === 4 }"></i>
                </button>
                <div x-show="open === 4" x-transition class="px-6 pb-4">
                    <p class="text-gray-600">Oui, vous pouvez faire une réservation en nous contactant par téléphone ou en utilisant le formulaire de contact ci-dessus.</p>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <button @click="open = open === 5 ? null : 5" class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors duration-200">
                    <span class="font-semibold text-gray-900">Quels moyens de paiement acceptez-vous ?</span>
                    <i class="fas fa-chevron-down text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': open === 5 }"></i>
                </button>
                <div x-show="open === 5" x-transition class="px-6 pb-4">
                    <p class="text-gray-600">Nous acceptons les paiements en espèces, par carte bancaire, et les paiements mobiles (Moov Money, Orange Money, MTN Mobile Money).</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-primary">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-white mb-6">Besoin d'aide ?</h2>
        <p class="text-xl text-orange-100 mb-8">Nous sommes là pour vous aider et répondre à toutes vos questions</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if($restaurant->phone)
                <a href="tel:{{ $restaurant->phone }}" 
                   class="bg-white text-primary px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-phone mr-2"></i>
                    Appelez-nous
                </a>
            @endif
            
            <a href="{{ route('restaurant.public.menu', $restaurant->slug) }}" 
               class="border-2 border-white text-white px-8 py-4 rounded-xl font-semibold hover:bg-white hover:text-primary transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-utensils mr-2"></i>
                Voir notre menu
            </a>
        </div>
    </div>
</section>
@endsection 