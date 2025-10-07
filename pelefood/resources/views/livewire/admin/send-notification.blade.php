<div class="space-y-6">
    <!-- Header avec statistiques -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Envoyer des Messages</h1>
            <p class="text-gray-600 mt-2">Envoyez des notifications et messages à vos utilisateurs</p>
        </div>
        
        <!-- Bouton d'envoi -->
        <button wire:click="openModal" 
                class="btn-modern flex items-center space-x-2">
            <i class="fas fa-paper-plane"></i>
            <span>Nouveau Message</span>
        </button>
    </div>

    <!-- Messages flash -->
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Utilisateurs</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $users->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-envelope text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Messages Envoyés</p>
                    <p class="text-2xl font-bold text-gray-900">{{ Illuminate\Notifications\DatabaseNotification::count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-bell text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Notifications Actives</p>
                    <p class="text-2xl font-bold text-gray-900">{{ Illuminate\Notifications\DatabaseNotification::whereNull('read_at')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Guide d'utilisation -->
    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
            Comment envoyer des messages ?
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-gray-900 mb-2">📧 Types de Messages</h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• <strong>Annonce</strong> : Informations importantes</li>
                    <li>• <strong>Promotion</strong> : Offres spéciales</li>
                    <li>• <strong>Maintenance</strong> : Interruptions de service</li>
                    <li>• <strong>Mise à jour</strong> : Nouvelles fonctionnalités</li>
                </ul>
            </div>
            <div>
                <h4 class="font-medium text-gray-900 mb-2">🎯 Canaux Disponibles</h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• <strong>Base de données</strong> : Notifications internes</li>
                    <li>• <strong>Email</strong> : Messages par email</li>
                    <li>• <strong>Temps réel</strong> : Notifications instantanées</li>
                    <li>• <strong>SMS</strong> : Messages texte (optionnel)</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal d'envoi de notification -->
    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4" wire:click="closeModal">
        <div class="modal-modern relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl transform transition-all duration-300 scale-100" wire:click.stop>
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">{{ $modalTitle }}</h3>
                    <button wire:click="closeModal" class="modal-close-btn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form wire:submit.prevent="sendNotification">
                    <div class="space-y-6">
                        <!-- Titre -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Titre du message</label>
                            <input wire:model="title" 
                                   type="text" 
                                   class="input-modern block w-full"
                                   placeholder="Entrez le titre de votre message">
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Message -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea wire:model="message" 
                                      rows="4" 
                                      class="input-modern block w-full"
                                      placeholder="Entrez votre message ici..."></textarea>
                            @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Type et Canaux -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Type de message</label>
                                <select wire:model="type" class="input-modern block w-full">
                                    @foreach($availableTypes as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Canaux -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Canaux d'envoi</label>
                                <div class="space-y-2">
                                    @foreach($availableChannels as $value => $label)
                                        <label class="flex items-center">
                                            <input wire:model="channels" 
                                                   type="checkbox" 
                                                   value="{{ $value }}"
                                                   class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('channels') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Destinataires -->
                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">Destinataires</label>
                            
                            <!-- Envoyer à tous -->
                            <label class="flex items-center">
                                <input wire:model="send_to_all" 
                                       type="checkbox"
                                       class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700 font-medium">Envoyer à tous les utilisateurs</span>
                            </label>

                            @if(!$send_to_all)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Par rôle -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Par rôle</label>
                                    <div class="space-y-2 max-h-40 overflow-y-auto border border-gray-200 rounded-lg p-3">
                                        @foreach($availableRoles as $value => $label)
                                            <label class="flex items-center">
                                                <input wire:model="target_roles" 
                                                       type="checkbox" 
                                                       value="{{ $value }}"
                                                       class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Par utilisateur -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Utilisateurs spécifiques</label>
                                    <div class="space-y-2 max-h-40 overflow-y-auto border border-gray-200 rounded-lg p-3">
                                        @foreach($users as $user)
                                            <label class="flex items-center">
                                                <input wire:model="target_users" 
                                                       type="checkbox" 
                                                       value="{{ $user->id }}"
                                                       class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-700">{{ $user->name }} ({{ $user->role }})</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                        <button type="button" 
                                wire:click="closeModal"
                                class="modal-cancel-btn">
                            Annuler
                        </button>
                        <button type="submit"
                                class="btn-modern">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Envoyer le Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
