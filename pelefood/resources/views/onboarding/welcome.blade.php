@extends('layouts.marketing')

@section('title', 'Bienvenue sur PeleFood')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-red-100">
    <!-- Header -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-32 h-32 bg-orange-200 rounded-full opacity-20 animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-24 h-24 bg-red-300 rounded-full opacity-30 animate-bounce"></div>
            <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-orange-400 rounded-full opacity-25 animate-ping"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <!-- Logo -->
                <div class="mx-auto h-20 w-20 bg-gradient-to-r from-orange-500 to-red-500 rounded-3xl flex items-center justify-center mb-8 shadow-2xl">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                
                <!-- Titre principal -->
                <h1 class="text-5xl font-bold text-gray-900 mb-6">
                    Bienvenue sur PeleFood ! 🎉
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Félicitations {{ Auth::user()->name }} ! Votre compte a été créé avec succès. 
                    Commençons maintenant à digitaliser votre restaurant en quelques étapes simples.
                </p>
                
                <!-- Badge de succès -->
                <div class="inline-flex items-center px-6 py-3 bg-green-100 text-green-800 rounded-full text-sm font-medium mb-8">
                    <i class="fas fa-check-circle mr-2"></i>
                    Compte créé avec succès
                </div>
            </div>
        </div>
    </div>

    <!-- Étapes d'onboarding -->
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">
                Votre parcours vers le succès
            </h2>
            
            <!-- Étapes -->
            <div class="space-y-8">
                <!-- Étape 1 -->
                <div class="flex items-start space-x-6">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            1
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Choisissez votre plan</h3>
                        <p class="text-gray-600 mb-4">
                            Sélectionnez le plan d'abonnement qui correspond le mieux à vos besoins. 
                            Commencez gratuitement ou optez pour des fonctionnalités avancées.
                        </p>
                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                            <div class="flex items-center text-sm text-orange-800">
                                <i class="fas fa-info-circle mr-2"></i>
                                <span>Recommandé : Commencez par le plan Starter (gratuit) pour tester PeleFood</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Étape 2 -->
                <div class="flex items-start space-x-6">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold text-lg">
                            2
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Configurez votre restaurant</h3>
                        <p class="text-gray-600 mb-4">
                            Ajoutez les informations de base de votre restaurant : nom, adresse, 
                            horaires d'ouverture et paramètres de livraison.
                        </p>
                    </div>
                </div>

                <!-- Étape 3 -->
                <div class="flex items-start space-x-6">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold text-lg">
                            3
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Ajoutez vos produits</h3>
                        <p class="text-gray-600 mb-4">
                            Créez vos catégories et ajoutez vos produits avec photos, descriptions 
                            et prix. Votre menu sera automatiquement mis en ligne.
                        </p>
                    </div>
                </div>

                <!-- Étape 4 -->
                <div class="flex items-start space-x-6">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold text-lg">
                            4
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Recevez vos premières commandes</h3>
                        <p class="text-gray-600 mb-4">
                            Votre restaurant sera visible en ligne et vous commencerez à recevoir 
                            des commandes de vos clients. Nous vous notifierons instantanément.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="mt-12 text-center space-y-4">
                <a href="{{ route('restaurant.subscription.select') }}" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold rounded-xl hover:from-orange-600 hover:to-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-rocket mr-3"></i>
                    Commencer maintenant
                </a>
                
                <div class="text-sm text-gray-500">
                    <p>Vous pouvez aussi <a href="{{ route('home') }}" class="text-orange-600 hover:text-orange-500 font-medium">explorer notre site</a> pour en savoir plus</p>
                </div>
            </div>
        </div>

        <!-- Avantages -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Configuration rapide</h3>
                <p class="text-gray-600">Votre restaurant sera opérationnel en moins de 5 minutes</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Sécurisé et fiable</h3>
                <p class="text-gray-600">Vos données sont protégées et sauvegardées automatiquement</p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-headset text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Support dédié</h3>
                <p class="text-gray-600">Notre équipe est là pour vous accompagner à chaque étape</p>
            </div>
        </div>
    </div>
</div>
@endsection 