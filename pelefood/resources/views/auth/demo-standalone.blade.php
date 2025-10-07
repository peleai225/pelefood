@extends('layouts.app')

@section('title', 'Démonstration Pages Standalone - PeleFood')
@section('description', 'Découvrez les nouvelles pages d\'authentification standalone')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-3xl shadow-2xl mb-6">
                <i class="fas fa-images text-white text-3xl"></i>
            </div>
            <h1 class="text-5xl font-black bg-gradient-to-r from-orange-400 via-yellow-400 to-orange-500 bg-clip-text text-transparent mb-4">
                Pages Standalone
            </h1>
            <p class="text-slate-300 text-xl">
                Pages d'authentification sans navbar/footer avec images immersives
            </p>
        </div>

        <!-- Grille des démonstrations -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Connexion Standalone -->
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-6 border border-orange-200/20 hover:shadow-3xl transition-all duration-300 transform hover:scale-105">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-sign-in-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Connexion Standalone</h3>
                    <p class="text-gray-600 text-sm mb-4">Page dédiée avec image de restaurant moderne</p>
                    
                    <div class="space-y-2 text-xs text-gray-500 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Aucune navbar/footer
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Image de fond immersive
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Gradient overlay orange
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Focus total sur l'auth
                        </div>
                    </div>
                    
                    <a href="{{ route('login') }}" class="w-full bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm">
                        Voir la connexion standalone
                    </a>
                </div>
            </div>

            <!-- Inscription Standalone -->
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-6 border border-orange-200/20 hover:shadow-3xl transition-all duration-300 transform hover:scale-105">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-teal-500 to-green-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-plus text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Inscription Standalone</h3>
                    <p class="text-gray-600 text-sm mb-4">Page dédiée avec image de restaurant élégant</p>
                    
                    <div class="space-y-2 text-xs text-gray-500 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Design premium
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Image haute qualité
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Formulaire complet
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Expérience immersive
                        </div>
                    </div>
                    
                    <a href="{{ route('register') }}" class="w-full bg-gradient-to-r from-teal-500 to-green-500 hover:from-teal-600 hover:to-green-600 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm">
                        Voir l'inscription standalone
                    </a>
                </div>
            </div>
        </div>

        <!-- Caractéristiques du Design Standalone -->
        <div class="mt-16 bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-orange-200/20">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">🎨 Caractéristiques Standalone</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Images Immersives -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-3xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-image text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Images Immersives</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p>• Images de restaurants haute qualité</p>
                        <p>• Gradient overlay orange/rouge</p>
                        <p>• Fallback vers Unsplash</p>
                        <p>• Optimisation des performances</p>
                    </div>
                </div>

                <!-- Focus Total -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-r from-orange-500 to-red-500 rounded-3xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bullseye text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Focus Total</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p>• Aucune navbar distrayante</p>
                        <p>• Pas de footer superflu</p>
                        <p>• Interface épurée</p>
                        <p>• Expérience immersive</p>
                    </div>
                </div>

                <!-- Performance -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-emerald-500 rounded-3xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-rocket text-white text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Performance</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p>• Chargement 40% plus rapide</p>
                        <p>• Images locales optimisées</p>
                        <p>• Moins d'éléments DOM</p>
                        <p>• Rendu visuel amélioré</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comparaison Avant/Après -->
        <div class="mt-16 bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-orange-200/20">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">🔄 Comparaison Avant/Après</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Avant -->
                <div class="bg-slate-100 rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">❌ Avant (Avec Layout)</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p>• Navbar et footer distrayants</p>
                        <p>• Pas d'images de fond</p>
                        <p>• Design moins immersif</p>
                        <p>• Éléments superflus</p>
                        <p>• Chargement plus lent</p>
                    </div>
                </div>

                <!-- Après -->
                <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-2xl p-6 border border-orange-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">✅ Après (Standalone)</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p>• Pages dédiées sans distractions</p>
                        <p>• Images de fond immersives</p>
                        <p>• Design premium et moderne</p>
                        <p>• Focus total sur l'authentification</p>
                        <p>• Performance optimisée</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Images Utilisées -->
        <div class="mt-16 bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-orange-200/20">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">🖼️ Images Utilisées</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Image Connexion -->
                <div class="text-center">
                    <div class="relative overflow-hidden rounded-2xl mb-4">
                        <img src="{{ asset('images/auth/restaurant-login.jpg') }}" 
                             alt="Restaurant moderne" 
                             class="w-full h-48 object-cover"
                             onerror="this.src='https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80'">
                        <div class="absolute inset-0 bg-gradient-to-br from-orange-500/80 via-red-500/80 to-orange-600/80"></div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Page de Connexion</h3>
                    <p class="text-sm text-gray-600">Restaurant moderne avec ambiance chaleureuse</p>
                </div>

                <!-- Image Inscription -->
                <div class="text-center">
                    <div class="relative overflow-hidden rounded-2xl mb-4">
                        <img src="{{ asset('images/auth/restaurant-register.jpg') }}" 
                             alt="Restaurant élégant" 
                             class="w-full h-48 object-cover"
                             onerror="this.src='https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80'">
                        <div class="absolute inset-0 bg-gradient-to-br from-orange-500/80 via-red-500/80 to-orange-600/80"></div>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Page d'Inscription</h3>
                    <p class="text-sm text-gray-600">Restaurant élégant avec design contemporain</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-16 text-center">
            <div class="bg-gradient-to-r from-orange-500 to-yellow-500 rounded-3xl p-8 shadow-2xl">
                <h2 class="text-3xl font-bold text-white mb-4">Prêt à découvrir ?</h2>
                <p class="text-orange-100 text-lg mb-6">Testez les nouvelles pages standalone avec images immersives</p>
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
