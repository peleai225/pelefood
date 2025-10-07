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
                <i class="fas fa-lock text-white text-2xl"></i>
            </div>
            <h2 class="text-4xl font-black bg-gradient-to-r from-orange-400 via-yellow-400 to-orange-500 bg-clip-text text-transparent mb-2">
                Nouveau mot de passe
            </h2>
            <p class="text-slate-300 text-lg">
                Créez un nouveau mot de passe sécurisé
            </p>
        </div>

        <!-- Message de succès -->
        @if($showSuccessMessage)
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4 animate-fade-in">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                Mot de passe réinitialisé avec succès ! Redirection en cours...
            </div>
        </div>
        @endif

        <!-- Formulaire de réinitialisation -->
        <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 border border-orange-200/20 transition-all duration-300 hover:shadow-3xl">
            <h3 class="text-xl font-bold text-gray-900 mb-6 text-center">Créer un nouveau mot de passe</h3>
            
            <form wire:submit.prevent="resetPassword" class="space-y-6">
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

                <!-- Nouveau mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nouveau mot de passe
                    </label>
                    <div class="relative">
                        <input 
                            id="password" 
                            wire:model.defer="password" 
                            type="{{ $showPassword ? 'text' : 'password' }}" 
                            class="block w-full px-4 py-3 pr-12 border rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @else border-gray-300 @enderror"
                            placeholder="Nouveau mot de passe sécurisé"
                            autocomplete="new-password">
                        
                        <button 
                            type="button" 
                            wire:click="togglePasswordVisibility"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                            @if($showPassword)
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            @else
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            @endif
                        </button>
                    </div>
                    
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 animate-fade-in">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmation du mot de passe -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        Confirmer le nouveau mot de passe
                    </label>
                    <div class="relative">
                        <input 
                            id="password_confirmation" 
                            wire:model.defer="password_confirmation" 
                            type="{{ $showPasswordConfirmation ? 'text' : 'password' }}" 
                            class="block w-full px-4 py-3 pr-12 border rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('password_confirmation') border-red-500 @else border-gray-300 @enderror"
                            placeholder="Confirmez votre nouveau mot de passe"
                            autocomplete="new-password">
                        
                        <button 
                            type="button" 
                            wire:click="togglePasswordConfirmationVisibility"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                            @if($showPasswordConfirmation)
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            @else
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            @endif
                        </button>
                    </div>
                </div>

                <!-- Bouton de réinitialisation -->
                <div>
                    <button 
                        type="submit" 
                        wire:loading.attr="disabled"
                        class="w-full bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 disabled:from-gray-400 disabled:to-gray-500 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-lg disabled:cursor-not-allowed disabled:transform-none">
                        
                        <span wire:loading.remove wire:target="resetPassword">
                            <i class="fas fa-save mr-2"></i>
                            Réinitialiser le mot de passe
                        </span>
                        
                        <span wire:loading wire:target="resetPassword" class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Réinitialisation en cours...
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
            </div>
        </div>

        <!-- Informations de sécurité -->
        <div class="bg-gradient-to-r from-green-50 to-teal-50 border border-green-200 rounded-xl p-4 backdrop-blur-sm">
            <p class="text-sm text-green-800 font-medium mb-2 text-center">🔒 Conseils de sécurité</p>
            <div class="text-xs text-green-700 space-y-1 text-center">
                <p>• Utilisez au moins 8 caractères avec des chiffres et symboles</p>
                <p>• Évitez les mots de passe courants ou personnels</p>
                <p>• Changez régulièrement votre mot de passe</p>
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

<!-- JavaScript pour les événements Livewire -->
<script>
document.addEventListener('livewire:load', function () {
    Livewire.on('password-reset-success', () => {
        // Animation de succès
        setTimeout(() => {
            window.location.href = '{{ route("restaurant.dashboard") }}';
        }, 1500);
    });
});
</script>
