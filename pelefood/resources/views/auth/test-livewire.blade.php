@extends('layouts.app')

@section('title', 'Test Livewire - PeleFood')
@section('description', 'Test des composants Livewire d\'authentification')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-3xl shadow-2xl mb-6">
                <i class="fas fa-vial text-white text-3xl"></i>
            </div>
            <h1 class="text-5xl font-black bg-gradient-to-r from-orange-400 via-yellow-400 to-orange-500 bg-clip-text text-transparent mb-4">
                Test Livewire
            </h1>
            <p class="text-slate-300 text-xl">
                Vérification des composants d'authentification
            </p>
        </div>

        <!-- Grille des tests -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Test Basic -->
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-6 border border-orange-200/20 hover:shadow-3xl transition-all duration-300 transform hover:scale-105">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Test Basic</h3>
                    <p class="text-gray-600 text-sm mb-4">Composant Livewire simple</p>
                    
                    <a href="{{ route('test.livewire') }}" class="w-full bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm">
                        Tester le composant basic
                    </a>
                </div>
            </div>

            <!-- Connexion Simple -->
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-6 border border-orange-200/20 hover:shadow-3xl transition-all duration-300 transform hover:scale-105">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-sign-in-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Connexion Simple</h3>
                    <p class="text-gray-600 text-sm mb-4">Formulaire de connexion Livewire</p>
                    
                    <a href="{{ route('simple.login') }}" class="w-full bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm">
                        Tester la connexion
                    </a>
                </div>
            </div>

            <!-- Inscription Simple -->
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-6 border border-orange-200/20 hover:shadow-3xl transition-all duration-300 transform hover:scale-105">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-teal-500 to-green-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-plus text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Inscription Simple</h3>
                    <p class="text-gray-600 text-sm mb-4">Formulaire d'inscription Livewire</p>
                    
                    <a href="{{ route('simple.register') }}" class="w-full bg-gradient-to-r from-teal-500 to-green-500 hover:from-teal-600 hover:to-green-600 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm">
                        Tester l'inscription
                    </a>
                </div>
            </div>

            <!-- Connexion Avancée -->
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-6 border border-orange-200/20 hover:shadow-3xl transition-all duration-300 transform hover:scale-105">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-lock text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Connexion Avancée</h3>
                    <p class="text-gray-600 text-sm mb-4">Avec validation temps réel</p>
                    
                    <a href="{{ route('login') }}" class="w-full bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm">
                        Tester la connexion avancée
                    </a>
                </div>
            </div>

            <!-- Inscription Avancée -->
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-6 border border-orange-200/20 hover:shadow-3xl transition-all duration-300 transform hover:scale-105">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-cog text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Inscription Avancée</h3>
                    <p class="text-gray-600 text-sm mb-4">Processus en 3 étapes</p>
                    
                    <a href="{{ route('register') }}" class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm">
                        Tester l'inscription avancée
                    </a>
                </div>
            </div>

            <!-- Démonstration -->
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-6 border border-orange-200/20 hover:shadow-3xl transition-all duration-300 transform hover:scale-105">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-red-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-rocket text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Démonstration</h3>
                    <p class="text-gray-600 text-sm mb-4">Présentation des améliorations</p>
                    
                    <a href="{{ route('auth.demo') }}" class="w-full bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm">
                        Voir la démonstration
                    </a>
                </div>
            </div>
        </div>

        <!-- Informations de débogage -->
        <div class="mt-16 bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-orange-200/20">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">🔧 Informations de Débogage</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Configuration Livewire -->
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Configuration Livewire</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p><strong>Version Livewire:</strong> {{ app('livewire')->version() ?? 'Non détectée' }}</p>
                        <p><strong>Namespace:</strong> App\Http\Livewire</p>
                        <p><strong>Layout par défaut:</strong> layouts.app</p>
                        <p><strong>Middleware:</strong> web</p>
                    </div>
                </div>

                <!-- Routes disponibles -->
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Routes de Test</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <p><strong>Test Basic:</strong> /test-livewire</p>
                        <p><strong>Connexion Simple:</strong> /simple-login</p>
                        <p><strong>Inscription Simple:</strong> /simple-register</p>
                        <p><strong>Connexion Avancée:</strong> /login</p>
                        <p><strong>Inscription Avancée:</strong> /register</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-16 text-center">
            <div class="bg-gradient-to-r from-orange-500 to-yellow-500 rounded-3xl p-8 shadow-2xl">
                <h2 class="text-3xl font-bold text-white mb-4">Prêt à tester ?</h2>
                <p class="text-orange-100 text-lg mb-6">Commencez par le test basic pour vérifier que Livewire fonctionne</p>
                <a href="{{ route('test.livewire') }}" class="bg-white text-orange-600 font-bold py-4 px-8 rounded-xl hover:bg-orange-50 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-play mr-2"></i>
                    Commencer le test
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
