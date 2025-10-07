<div>
    <!-- Bouton de déconnexion -->
    <button 
        wire:click="confirmLogout"
        class="text-gray-700 hover:text-red-600 px-4 py-2 rounded-lg font-medium transition-all duration-300 hover:bg-red-50 flex items-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
        </svg>
        <span>Déconnexion</span>
    </button>

    <!-- Modal de confirmation -->
    @if($showConfirmModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="cancelLogout">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4" wire:click.stop>
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Confirmer la déconnexion</h3>
                        <p class="text-sm text-gray-500">Êtes-vous sûr de vouloir vous déconnecter ?</p>
                    </div>
                </div>
                
                <div class="flex space-x-3">
                    <button 
                        wire:click="cancelLogout"
                        class="flex-1 px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors duration-200">
                        Annuler
                    </button>
                    <button 
                        wire:click="logout"
                        class="flex-1 px-4 py-2 text-white bg-red-600 hover:bg-red-700 rounded-lg font-medium transition-colors duration-200">
                        Se déconnecter
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>