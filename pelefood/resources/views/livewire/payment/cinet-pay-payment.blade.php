<div class="max-w-2xl mx-auto p-6">
    <!-- Messages de statut -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 animate-fade-in">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('message') }}
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 animate-fade-in">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Formulaire de paiement -->
    @if($showPaymentForm)
    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-200">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl mb-4">
                <i class="fas fa-credit-card text-white text-2xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Paiement Sécurisé</h2>
            <p class="text-gray-600">Remplissez vos informations pour procéder au paiement</p>
        </div>

        <form wire:submit.prevent="initializePayment" class="space-y-6">
            <!-- Montant -->
            <div>
                <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">
                    Montant (FCFA) <span class="text-red-500">*</span>
                </label>
                <input 
                    id="amount" 
                    wire:model.defer="amount" 
                    type="number" 
                    min="100"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('amount') border-red-500 @else border-gray-300 @enderror"
                    placeholder="1000">
                
                @error('amount')
                    <p class="mt-1 text-sm text-red-600 animate-fade-in">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <input 
                    id="description" 
                    wire:model.defer="description" 
                    type="text" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('description') border-red-500 @else border-gray-300 @enderror"
                    placeholder="Paiement pour commande #123">
                
                @error('description')
                    <p class="mt-1 text-sm text-red-600 animate-fade-in">{{ $message }}</p>
                @enderror
            </div>

            <!-- Informations client -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nom -->
                <div>
                    <label for="customer_name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nom <span class="text-red-500">*</span>
                    </label>
                    <input 
                        id="customer_name" 
                        wire:model.defer="customer_name" 
                        type="text" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('customer_name') border-red-500 @else border-gray-300 @enderror"
                        placeholder="Votre nom">
                    
                    @error('customer_name')
                        <p class="mt-1 text-sm text-red-600 animate-fade-in">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prénom -->
                <div>
                    <label for="customer_surname" class="block text-sm font-semibold text-gray-700 mb-2">
                        Prénom <span class="text-red-500">*</span>
                    </label>
                    <input 
                        id="customer_surname" 
                        wire:model.defer="customer_surname" 
                        type="text" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('customer_surname') border-red-500 @else border-gray-300 @enderror"
                        placeholder="Votre prénom">
                    
                    @error('customer_surname')
                        <p class="mt-1 text-sm text-red-600 animate-fade-in">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="customer_email" class="block text-sm font-semibold text-gray-700 mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input 
                    id="customer_email" 
                    wire:model.defer="customer_email" 
                    type="email" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('customer_email') border-red-500 @else border-gray-300 @enderror"
                    placeholder="votre@email.com">
                
                @error('customer_email')
                    <p class="mt-1 text-sm text-red-600 animate-fade-in">{{ $message }}</p>
                @enderror
            </div>

            <!-- Téléphone -->
            <div>
                <label for="customer_phone_number" class="block text-sm font-semibold text-gray-700 mb-2">
                    Téléphone <span class="text-red-500">*</span>
                </label>
                <input 
                    id="customer_phone_number" 
                    wire:model.defer="customer_phone_number" 
                    type="tel" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('customer_phone_number') border-red-500 @else border-gray-300 @enderror"
                    placeholder="+225 07 12 34 56 78">
                
                @error('customer_phone_number')
                    <p class="mt-1 text-sm text-red-600 animate-fade-in">{{ $message }}</p>
                @enderror
            </div>

            <!-- Adresse -->
            <div>
                <label for="customer_address" class="block text-sm font-semibold text-gray-700 mb-2">
                    Adresse
                </label>
                <input 
                    id="customer_address" 
                    wire:model.defer="customer_address" 
                    type="text" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('customer_address') border-red-500 @else border-gray-300 @enderror"
                    placeholder="123 Avenue de la République">
                
                @error('customer_address')
                    <p class="mt-1 text-sm text-red-600 animate-fade-in">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ville -->
            <div>
                <label for="customer_city" class="block text-sm font-semibold text-gray-700 mb-2">
                    Ville
                </label>
                <input 
                    id="customer_city" 
                    wire:model.defer="customer_city" 
                    type="text" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('customer_city') border-red-500 @else border-gray-300 @enderror"
                    placeholder="Abidjan">
                
                @error('customer_city')
                    <p class="mt-1 text-sm text-red-600 animate-fade-in">{{ $message }}</p>
                @enderror
            </div>

            <!-- Méthodes de paiement -->
            <div>
                <label for="channels" class="block text-sm font-semibold text-gray-700 mb-2">
                    Méthodes de paiement
                </label>
                <select 
                    id="channels" 
                    wire:model.defer="channels" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 @error('channels') border-red-500 @else border-gray-300 @enderror">
                    <option value="ALL">Toutes les méthodes</option>
                    <option value="MOBILE_MONEY">Mobile Money</option>
                    <option value="CARD">Carte bancaire</option>
                    <option value="BANK_TRANSFER">Virement bancaire</option>
                </select>
                
                @error('channels')
                    <p class="mt-1 text-sm text-red-600 animate-fade-in">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bouton de paiement -->
            <div>
                <button 
                    type="submit" 
                    wire:loading.attr="disabled"
                    class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 disabled:from-gray-400 disabled:to-gray-500 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl disabled:cursor-not-allowed disabled:transform-none">
                    
                    <span wire:loading.remove wire:target="initializePayment">
                        <i class="fas fa-credit-card mr-2"></i>
                        Initialiser le paiement
                    </span>
                    
                    <span wire:loading wire:target="initializePayment" class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Initialisation en cours...
                    </span>
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Bouton de redirection vers le paiement -->
    @if($showPaymentButton)
    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-200 text-center">
        <div class="mb-6">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl mb-4">
                <i class="fas fa-check text-white text-2xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Paiement Initialisé</h2>
            <p class="text-gray-600 mb-4">Votre paiement a été initialisé avec succès</p>
            <p class="text-sm text-gray-500">ID de transaction: {{ $transactionId }}</p>
        </div>

        <div class="space-y-4">
            <button 
                wire:click="proceedToPayment"
                class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                <i class="fas fa-external-link-alt mr-2"></i>
                Procéder au paiement
            </button>

            <button 
                wire:click="resetForm"
                class="w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                Nouveau paiement
            </button>
        </div>
    </div>
    @endif

    <!-- JavaScript pour la redirection -->
    <script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('redirect-to-payment', (data) => {
            window.location.href = data.url;
        });
    });
    </script>
</div>
