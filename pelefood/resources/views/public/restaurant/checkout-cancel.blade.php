@extends('layouts.public-restaurant', ['restaurant' => $restaurant])

@section('title', 'Paiement annulé - ' . $restaurant->name)

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-red-50 to-orange-50 py-20">
    <div class="absolute inset-0 bg-black/5"></div>
    <div class="relative max-w-4xl mx-auto px-4 text-center">
        <div class="mb-8">
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-times-circle text-red-500 text-3xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Paiement annulé</h1>
            <p class="text-xl text-gray-600">Votre paiement a été annulé. Aucun montant n'a été débité de votre compte.</p>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<section class="py-16">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- En-tête -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 px-8 py-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Paiement non effectué</h2>
                        <p class="text-red-100 mt-1">Votre commande n'a pas pu être finalisée</p>
                    </div>
                </div>
            </div>

            <!-- Contenu -->
            <div class="p-8">
                <div class="space-y-6">
                    <!-- Message principal -->
                    <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-red-400 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-red-800">Que s'est-il passé ?</h3>
                                <div class="mt-2 text-red-700">
                                    <p>Votre paiement a été annulé avant d'être finalisé. Cela peut être dû à :</p>
                                    <ul class="list-disc list-inside mt-2 space-y-1">
                                        <li>Une annulation volontaire de votre part</li>
                                        <li>Un problème technique temporaire</li>
                                        <li>Une interruption de la connexion</li>
                                        <li>Un problème avec le moyen de paiement sélectionné</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations importantes -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-shield-alt text-blue-400 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-blue-800">Aucun débit effectué</h3>
                                <div class="mt-2 text-blue-700">
                                    <p>Rassurez-vous, aucun montant n'a été débité de votre compte. Votre commande n'a pas été créée.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Que souhaitez-vous faire ?</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('restaurant.public.checkout', $restaurant->slug) }}" 
                               class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 transition-colors text-center">
                                <i class="fas fa-redo mr-2"></i>
                                Réessayer le paiement
                            </a>
                            <a href="{{ route('restaurant.public.menu', $restaurant->slug) }}" 
                               class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors text-center">
                                <i class="fas fa-utensils mr-2"></i>
                                Retourner au menu
                            </a>
                        </div>
                    </div>

                    <!-- Support -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-headset text-green-400 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-green-800">Besoin d'aide ?</h3>
                                <div class="mt-2 text-green-700">
                                    <p>Si vous rencontrez des difficultés avec le paiement, n'hésitez pas à nous contacter :</p>
                                    <div class="mt-3 space-y-2">
                                        <div class="flex items-center">
                                            <i class="fas fa-phone text-green-500 mr-2"></i>
                                            <span>{{ $restaurant->phone }}</span>
                                        </div>
                                        @if($restaurant->email)
                                        <div class="flex items-center">
                                            <i class="fas fa-envelope text-green-500 mr-2"></i>
                                            <span>{{ $restaurant->email }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-primary">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Prêt à commander ?</h2>
        <p class="text-xl text-white/90 mb-8">Découvrez notre délicieux menu et réessayez votre commande</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('restaurant.public.menu', $restaurant->slug) }}" 
               class="bg-white text-orange-600 px-8 py-3 rounded-lg hover:bg-gray-100 transition-colors font-semibold">
                <i class="fas fa-utensils mr-2"></i>
                Voir le menu
            </a>
            <a href="{{ route('restaurant.public.contact', $restaurant->slug) }}" 
               class="bg-orange-600 text-white px-8 py-3 rounded-lg hover:bg-orange-700 transition-colors font-semibold">
                <i class="fas fa-phone mr-2"></i>
                Nous contacter
            </a>
        </div>
    </div>
</section>
@endsection 