<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Paramètres</h1>
            <p class="text-gray-600 mt-2">Configurez les paramètres de votre plateforme</p>
        </div>
    </div>

    <!-- Onglets -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6">
                <button wire:click="$set('activeTab', 'general')" 
                        class="py-4 px-1 border-b-2 font-medium text-sm
                        @if($activeTab === 'general') border-blue-500 text-blue-600
                        @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300
                        @endif">
                    Général
                </button>
                <button wire:click="$set('activeTab', 'email')" 
                        class="py-4 px-1 border-b-2 font-medium text-sm
                        @if($activeTab === 'email') border-blue-500 text-blue-600
                        @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300
                        @endif">
                    Email
                </button>
                <button wire:click="$set('activeTab', 'payment')" 
                        class="py-4 px-1 border-b-2 font-medium text-sm
                        @if($activeTab === 'payment') border-blue-500 text-blue-600
                        @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300
                        @endif">
                    Paiements
                </button>
            </nav>
        </div>

        <div class="p-6">
            <!-- Onglet Général -->
            @if($activeTab === 'general')
            <form wire:submit.prevent="saveGeneralSettings">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom du site</label>
                        <input wire:model="siteName" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email du site</label>
                        <input wire:model="siteEmail" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                        <input wire:model="sitePhone" type="tel" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea wire:model="siteDescription" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Sauvegarder
                    </button>
                </div>
            </form>
            @endif

            <!-- Onglet Email -->
            @if($activeTab === 'email')
            <form wire:submit.prevent="saveEmailSettings">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Serveur SMTP</label>
                        <input wire:model="smtpHost" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Port SMTP</label>
                        <input wire:model="smtpPort" type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom d'utilisateur</label>
                        <input wire:model="smtpUsername" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                        <input wire:model="smtpPassword" type="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Chiffrement</label>
                        <select wire:model="smtpEncryption" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="tls">TLS</option>
                            <option value="ssl">SSL</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Sauvegarder
                    </button>
                </div>
            </form>
            @endif

            <!-- Onglet Paiements -->
            @if($activeTab === 'payment')
            <form wire:submit.prevent="savePaymentSettings">
                <div class="space-y-6">
                    <!-- Stripe -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Stripe</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Clé publique</label>
                                <input wire:model="stripePublicKey" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Clé secrète</label>
                                <input wire:model="stripeSecretKey" type="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- PayPal -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">PayPal</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Client ID</label>
                                <input wire:model="paypalClientId" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Secret</label>
                                <input wire:model="paypalSecret" type="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Sauvegarder
                    </button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Notification système pour Livewire
window.addEventListener('showNotification', event => {
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
    notification.textContent = event.detail.message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
});
</script>
@endpush