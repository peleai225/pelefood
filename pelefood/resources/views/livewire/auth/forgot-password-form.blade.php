<div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-orange-400/20 to-yellow-400/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-br from-teal-400/20 to-green-400/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-orange-300/10 to-red-300/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="max-w-md w-full space-y-8 relative z-10">
        <!-- Header -->
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-2xl shadow-2xl mb-4 transition-all duration-300 hover:scale-110">
                <i class="fas fa-key text-white text-2xl"></i>
            </div>
            <h2 class="text-4xl font-black bg-gradient-to-r from-orange-400 via-yellow-400 to-orange-500 bg-clip-text text-transparent mb-2">
                Mot de passe oublié
            </h2>
            <p class="text-slate-300 text-lg">
                Entrez votre adresse email pour recevoir un lien de réinitialisation
            </p>
        </div>

        <!-- Message de succès -->
        @if($showSuccessMessage)
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4 animate-fade-in">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ $successMessage }}
            </div>
        </div>
        @endif

        <!-- Formulaire de récupération -->
        <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-orange-200/20 transition-all duration-300 hover:shadow-3xl">
            <h3 class="text-xl font-bold text-gray-900 mb-6 text-center">Réinitialiser votre mot de passe</h3>
            
            <form wire:submit.prevent="sendResetLink" class="space-y-6">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Adresse email
                    </label>
                    <input 
                        id="email" 
                        wire:model.defer="email" 
                        type="email" 
                        class="block w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 @else border-gray-300 @enderror"
                        placeholder="votre@email.com"
                        autocomplete="email">
                    
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 animate-fade-in">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bouton d'envoi -->
                <div>
                    <button 
                        type="submit" 
                        wire:loading.attr="disabled"
                        class="w-full bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 disabled:from-gray-400 disabled:to-gray-500 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-lg disabled:cursor-not-allowed disabled:transform-none">
                        
                        <span wire:loading.remove wire:target="sendResetLink">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Envoyer le lien
                        </span>
                        
                        <span wire:loading wire:target="sendResetLink" class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Envoi en cours...
                        </span>
                    </button>
                </div>
            </form>

            <!-- Séparateur -->
            <div class="my-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Ou</span>
                    </div>
                </div>
            </div>

            <!-- Liens de navigation -->
            <div class="text-center space-y-2">
                <p class="text-sm text-gray-600">
                    Vous vous souvenez de votre mot de passe ? 
                    <a href="{{ route('login') }}" class="font-semibold text-orange-600 hover:text-orange-500 transition-colors">
                        Se connecter
                    </a>
                </p>
                <p class="text-sm text-gray-600">
                    Pas encore de compte ? 
                    <a href="{{ route('register') }}" class="font-semibold text-orange-600 hover:text-orange-500 transition-colors">
                        Créer un compte
                    </a>
                </p>
            </div>
        </div>

        <!-- Informations de sécurité -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4 backdrop-blur-sm">
            <p class="text-sm text-blue-800 font-medium mb-2 text-center">💡 Conseils de sécurité</p>
            <div class="text-xs text-blue-700 space-y-1 text-center">
                <p>• Vérifiez votre dossier spam si vous ne recevez pas l'email</p>
                <p>• Le lien de réinitialisation expire dans 1 heure</p>
                <p>• Contactez le support si vous rencontrez des difficultés</p>
            </div>
        </div>
    </div>
</div>

<!-- Styles CSS pour les animations -->
<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-in-out;
}

/* Animation de pulsation pour les éléments décoratifs */
@keyframes pulse-slow {
    0%, 100% { opacity: 0.3; }
    50% { opacity: 0.6; }
}

.animate-pulse {
    animation: pulse-slow 4s ease-in-out infinite;
}
</style>
