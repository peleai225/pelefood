@extends('layouts.app')

@section('title', 'Démonstration Design Moderne - PeleFood')
@section('description', 'Découvrez le nouveau design des pages d\'authentification')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-3xl shadow-2xl mb-6">
                <i class="fas fa-palette text-white text-3xl"></i>
            </div>
            <h1 class="text-5xl font-black bg-gradient-to-r from-orange-400 via-yellow-400 to-orange-500 bg-clip-text text-transparent mb-4">
                Design Moderne
            </h1>
            <p class="text-slate-300 text-xl">
                Pages d'authentification avec design inspiré des meilleures pratiques
            </p>
        </div>

        <!-- Grille des démonstrations -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Connexion Moderne -->
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-6 border border-orange-200/20 hover:shadow-3xl transition-all duration-300 transform hover:scale-105">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-sign-in-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Connexion Moderne</h3>
                    <p class="text-gray-600 text-sm mb-4">Design inspiré des meilleures pratiques UX</p>
                    
                    <div class="space-y-2 text-xs text-gray-500 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Layout en deux panneaux
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Panneau visuel avec gradient
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Formulaire sur fond sombre
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Connexion sociale intégrée
                        </div>
                    </div>
                    
                    <a href="{{ route('login') }}" class="w-full bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm">
                        Voir la connexion moderne
                    </a>
                </div>
            </div>

            <!-- Inscription Moderne -->
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-6 border border-orange-200/20 hover:shadow-3xl transition-all duration-300 transform hover:scale-105">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-teal-500 to-green-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-plus text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Inscription Moderne</h3>
                    <p class="text-gray-600 text-sm mb-4">Formulaire complet avec design premium</p>
                    
                    <div class="space-y-2 text-xs text-gray-500 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Champs organisés logiquement
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Validation en temps réel
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Toggle de mot de passe
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Design cohérent
                        </div>
                    </div>
                    
                    <a href="{{ route('register') }}" class="w-full bg-gradient-to-r from-teal-500 to-green-500 hover:from-teal-600 hover:to-green-600 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm">
                        Voir l'inscription moderne
                    </a>
                </div>
            </div>
        </div>

        <!-- Caractéristiques du Design -->
        <div class="mt-16 bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-orange-200/20">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">🎨 Caractéristiques du Design</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Layout -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-3xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-th-large text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Layout Moderne</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p>• Panneau visuel avec gradient</p>
                        <p>• Formulaire sur fond sombre</p>
                        <p>• Design responsive</p>
                        <p>• Navigation intuitive</p>
                    </div>
                </div>

                <!-- Couleurs -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-r from-orange-500 to-red-500 rounded-3xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-palette text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Palette de Couleurs</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p>• Orange/Rouge comme couleurs principales</p>
                        <p>• Fond sombre pour le contraste</p>
                        <p>• Accents orange pour les interactions</p>
                        <p>• Texte blanc pour la lisibilité</p>
                    </div>
                </div>

                <!-- UX -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-emerald-500 rounded-3xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Expérience Utilisateur</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p>• Validation en temps réel</p>
                        <p>• Animations fluides</p>
                        <p>• Feedback visuel immédiat</p>
                        <p>• Navigation intuitive</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comparaison des Designs -->
        <div class="mt-16 bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-orange-200/20">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">🔄 Comparaison des Designs</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Ancien Design -->
                <div class="bg-slate-100 rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Ancien Design</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p>• Layout simple en une colonne</p>
                        <p>• Fond dégradé simple</p>
                        <p>• Formulaire basique</p>
                        <p>• Moins d'éléments visuels</p>
                    </div>
                </div>

                <!-- Nouveau Design -->
                <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-2xl p-6 border border-orange-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Nouveau Design</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p>• Layout en deux panneaux</p>
                        <p>• Panneau visuel avec gradient</p>
                        <p>• Formulaire sur fond sombre</p>
                        <p>• Connexion sociale intégrée</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-16 text-center">
            <div class="bg-gradient-to-r from-orange-500 to-yellow-500 rounded-3xl p-8 shadow-2xl">
                <h2 class="text-3xl font-bold text-white mb-4">Prêt à découvrir ?</h2>
                <p class="text-orange-100 text-lg mb-6">Testez les nouvelles pages d'authentification</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('login') }}" class="bg-white text-orange-600 font-bold py-4 px-8 rounded-xl hover:bg-orange-50 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Voir la connexion
                    </a>
                    <a href="{{ route('register') }}" class="bg-orange-600 text-white font-bold py-4 px-8 rounded-xl hover:bg-orange-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i>
                        Voir l'inscription
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
