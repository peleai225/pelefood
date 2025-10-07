@extends('layouts.app')

@section('title', 'Test des Formulaires - PeleFood')
@section('description', 'Test des formulaires d\'authentification avec Livewire')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-3xl shadow-2xl mb-6">
                <i class="fas fa-vial text-white text-3xl"></i>
            </div>
            <h1 class="text-5xl font-black bg-gradient-to-r from-orange-400 via-yellow-400 to-orange-500 bg-clip-text text-transparent mb-4">
                Test des Formulaires
            </h1>
            <p class="text-slate-300 text-xl">
                Vérification des formulaires d'authentification avec Livewire
            </p>
        </div>

        <!-- Grille des tests -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Test Connexion -->
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-6 border border-orange-200/20 hover:shadow-3xl transition-all duration-300 transform hover:scale-105">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-sign-in-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Connexion Livewire</h3>
                    <p class="text-gray-600 text-sm mb-4">Formulaire de connexion avec validation temps réel</p>
                    
                    <div class="space-y-2 text-xs text-gray-500 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Validation en temps réel
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Toggle mot de passe
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Rate limiting
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Animations fluides
                        </div>
                    </div>
                    
                    <a href="{{ route('login') }}" class="w-full bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm">
                        Tester la connexion
                    </a>
                </div>
            </div>

            <!-- Test Inscription -->
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-6 border border-orange-200/20 hover:shadow-3xl transition-all duration-300 transform hover:scale-105">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-teal-500 to-green-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-plus text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Inscription Livewire</h3>
                    <p class="text-gray-600 text-sm mb-4">Processus en 3 étapes avec validation progressive</p>
                    
                    <div class="space-y-2 text-xs text-gray-500 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Processus multi-étapes
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Indicateur de progression
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Validation progressive
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Création automatique
                        </div>
                    </div>
                    
                    <a href="{{ route('register') }}" class="w-full bg-gradient-to-r from-teal-500 to-green-500 hover:from-teal-600 hover:to-green-600 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm">
                        Tester l'inscription
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
                        <p><strong>Connexion:</strong> /login</p>
                        <p><strong>Inscription:</strong> /register</p>
                        <p><strong>Test Simple:</strong> /simple-login</p>
                        <p><strong>Test Basic:</strong> /test-livewire</p>
                        <p><strong>Démonstration:</strong> /auth-demo</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-16 text-center">
            <div class="bg-gradient-to-r from-orange-500 to-yellow-500 rounded-3xl p-8 shadow-2xl">
                <h2 class="text-3xl font-bold text-white mb-4">Prêt à tester ?</h2>
                <p class="text-orange-100 text-lg mb-6">Testez les formulaires d'authentification modernisés</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('login') }}" class="bg-white text-orange-600 font-bold py-4 px-8 rounded-xl hover:bg-orange-50 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Tester la connexion
                    </a>
                    <a href="{{ route('register') }}" class="bg-orange-600 text-white font-bold py-4 px-8 rounded-xl hover:bg-orange-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i>
                        Tester l'inscription
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
