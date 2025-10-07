@extends('layouts.marketing')

@section('title', 'Félicitations !')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-100">
    <!-- Header -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-32 h-32 bg-green-200 rounded-full opacity-20 animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-24 h-24 bg-green-300 rounded-full opacity-30 animate-bounce"></div>
            <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-green-400 rounded-full opacity-25 animate-ping"></div>
        </div>
        
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <!-- Logo avec animation -->
                <div class="mx-auto h-24 w-24 bg-gradient-to-r from-green-500 to-green-600 rounded-3xl flex items-center justify-center mb-8 shadow-2xl animate-bounce">
                    <i class="fas fa-check text-white text-4xl"></i>
                </div>
                
                <!-- Titre principal -->
                <h1 class="text-5xl font-bold text-gray-900 mb-6">
                    Félicitations ! 🎉
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Votre restaurant <strong>{{ $restaurant->name }}</strong> est maintenant opérationnel sur PeleFood !
                </p>
                
                <!-- Badge de succès -->
                <div class="inline-flex items-center px-6 py-3 bg-green-100 text-green-800 rounded-full text-sm font-medium mb-8">
                    <i class="fas fa-rocket mr-2"></i>
                    Onboarding terminé avec succès
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">
                Votre restaurant est prêt !
            </h2>
            
            <!-- Informations du restaurant -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="bg-gradient-to-r from-orange-50 to-red-50 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-store mr-3 text-orange-600"></i>
                        Informations du restaurant
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <span class="text-gray-600 w-24">Nom :</span>
                            <span class="font-medium">{{ $restaurant->name }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-600 w-24">Adresse :</span>
                            <span class="font-medium">{{ $restaurant->address }}, {{ $restaurant->city }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-600 w-24">Téléphone :</span>
                            <span class="font-medium">{{ $restaurant->phone }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-600 w-24">Email :</span>
                            <span class="font-medium">{{ $restaurant->email }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-credit-card mr-3 text-blue-600"></i>
                        Plan d'abonnement
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <span class="text-gray-600 w-24">Plan :</span>
                            <span class="font-medium">{{ $restaurant->subscriptionPlan->name ?? 'Non défini' }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-600 w-24">Statut :</span>
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                Actif
                            </span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-600 w-24">Expire le :</span>
                            <span class="font-medium">
                                {{ $restaurant->subscription_expires_at ? $restaurant->subscription_expires_at->format('d/m/Y') : 'Non défini' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prochaines étapes -->
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-list-check mr-3 text-purple-600"></i>
                    Prochaines étapes recommandées
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-sm font-bold mt-1">
                            1
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Ajouter des catégories</h4>
                            <p class="text-sm text-gray-600">Organisez votre menu avec des catégories</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-sm font-bold mt-1">
                            2
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Créer vos produits</h4>
                            <p class="text-sm text-gray-600">Ajoutez vos plats avec photos et prix</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-sm font-bold mt-1">
                            3
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Configurer la livraison</h4>
                            <p class="text-sm text-gray-600">Définissez vos zones et frais de livraison</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-sm font-bold mt-1">
                            4
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Personnaliser l'apparence</h4>
                            <p class="text-sm text-gray-600">Adaptez les couleurs et le logo</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="text-center space-y-4">
                <form method="POST" action="{{ route('onboarding.complete') }}" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-arrow-right mr-3"></i>
                        Accéder à mon tableau de bord
                    </button>
                </form>
                
                <div class="text-sm text-gray-500">
                    <p>Vous pouvez aussi <a href="{{ route('restaurant.categories.create') }}" class="text-green-600 hover:text-green-500 font-medium">commencer par ajouter vos catégories</a></p>
                </div>
            </div>
        </div>

        <!-- Conseils -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lightbulb text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Conseil</h3>
                <p class="text-gray-600">Ajoutez des photos de qualité pour vos produits. Cela augmente les ventes de 30% !</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-chart-line text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Analytics</h3>
                <p class="text-gray-600">Suivez vos performances avec nos outils d'analyse intégrés.</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-headset text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Support</h3>
                <p class="text-gray-600">Notre équipe est disponible 24/7 pour vous accompagner.</p>
            </div>
        </div>
    </div>
</div>
@endsection 