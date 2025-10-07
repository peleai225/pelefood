@extends('layouts.super-admin-new-design')

@section('title', 'Paramètres du Système - PeleFood')
@section('description', 'Configurez tous les paramètres de la plateforme')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Paramètres du Système</h1>
            <p class="mt-2 text-lg text-gray-600">Configurez tous les paramètres de la plateforme PeleFood</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="resetAllSettings()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-undo mr-2"></i> Réinitialiser
            </button>
            <button onclick="saveAllSettings()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-save mr-2"></i> Sauvegarder
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-600 mr-3"></i>
            <p class="text-green-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Onglets -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6">
                <button onclick="showTab('general')" id="tab-general" class="tab-button active py-4 px-1 border-b-2 border-blue-500 text-blue-600 font-medium">
                    <i class="fas fa-cog mr-2"></i> Général
                </button>
                <button onclick="showTab('email')" id="tab-email" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-envelope mr-2"></i> Email
                </button>
                <button onclick="showTab('payment')" id="tab-payment" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-credit-card mr-2"></i> Paiements
                </button>
                <button onclick="showTab('security')" id="tab-security" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-shield-alt mr-2"></i> Sécurité
                </button>
                <button onclick="showTab('notifications')" id="tab-notifications" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-bell mr-2"></i> Notifications
                </button>
            </nav>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('admin.settings.update') }}" id="settings-form">
                @csrf

                <!-- Onglet Général -->
                <div id="content-general" class="tab-content">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations de la Plateforme</h3>
                            
                            <div class="space-y-2">
                                <label for="app_name" class="block text-sm font-medium text-gray-700">Nom de l'application</label>
                                <input type="text" name="app_name" id="app_name" value="{{ $settings['app_name'] ?? 'PeleFood' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="space-y-2">
                                <label for="app_description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="app_description" id="app_description" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $settings['app_description'] ?? 'Plateforme de livraison de nourriture' }}</textarea>
                            </div>

                            <div class="space-y-2">
                                <label for="app_url" class="block text-sm font-medium text-gray-700">URL de l'application</label>
                                <input type="url" name="app_url" id="app_url" value="{{ $settings['app_url'] ?? url('/') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="space-y-2">
                                <label for="app_logo" class="block text-sm font-medium text-gray-700">Logo</label>
                                <input type="file" name="app_logo" id="app_logo" accept="image/*"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @if(isset($settings['app_logo']))
                                <img src="{{ $settings['app_logo'] }}" alt="Logo actuel" class="mt-2 h-16 w-auto">
                                @endif
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Configuration Générale</h3>
                            
                            <div class="space-y-2">
                                <label for="timezone" class="block text-sm font-medium text-gray-700">Fuseau horaire</label>
                                <select name="timezone" id="timezone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="Africa/Douala" {{ ($settings['timezone'] ?? 'Africa/Douala') == 'Africa/Douala' ? 'selected' : '' }}>Douala (GMT+1)</option>
                                    <option value="Africa/Lagos" {{ ($settings['timezone'] ?? '') == 'Africa/Lagos' ? 'selected' : '' }}>Lagos (GMT+1)</option>
                                    <option value="Europe/Paris" {{ ($settings['timezone'] ?? '') == 'Europe/Paris' ? 'selected' : '' }}>Paris (GMT+1)</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="currency" class="block text-sm font-medium text-gray-700">Devise</label>
                                <select name="currency" id="currency" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="XAF" {{ ($settings['currency'] ?? 'XAF') == 'XAF' ? 'selected' : '' }}>Franc CFA (XAF)</option>
                                    <option value="EUR" {{ ($settings['currency'] ?? '') == 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                                    <option value="USD" {{ ($settings['currency'] ?? '') == 'USD' ? 'selected' : '' }}>Dollar (USD)</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="language" class="block text-sm font-medium text-gray-700">Langue par défaut</label>
                                <select name="language" id="language" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="fr" {{ ($settings['language'] ?? 'fr') == 'fr' ? 'selected' : '' }}>Français</option>
                                    <option value="en" {{ ($settings['language'] ?? '') == 'en' ? 'selected' : '' }}>English</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="maintenance_mode" class="flex items-center">
                                    <input type="checkbox" name="maintenance_mode" id="maintenance_mode" value="1" 
                                           {{ ($settings['maintenance_mode'] ?? false) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Mode maintenance</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Onglet Email -->
                <div id="content-email" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Configuration SMTP</h3>
                            
                            <div class="space-y-2">
                                <label for="mail_host" class="block text-sm font-medium text-gray-700">Serveur SMTP</label>
                                <input type="text" name="mail_host" id="mail_host" value="{{ $settings['mail_host'] ?? 'smtp.gmail.com' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="space-y-2">
                                <label for="mail_port" class="block text-sm font-medium text-gray-700">Port</label>
                                <input type="number" name="mail_port" id="mail_port" value="{{ $settings['mail_port'] ?? '587' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="space-y-2">
                                <label for="mail_username" class="block text-sm font-medium text-gray-700">Nom d'utilisateur</label>
                                <input type="email" name="mail_username" id="mail_username" value="{{ $settings['mail_username'] ?? '' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="space-y-2">
                                <label for="mail_password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                                <input type="password" name="mail_password" id="mail_password" value="{{ $settings['mail_password'] ?? '' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Configuration Email</h3>
                            
                            <div class="space-y-2">
                                <label for="mail_from_address" class="block text-sm font-medium text-gray-700">Adresse d'expéditeur</label>
                                <input type="email" name="mail_from_address" id="mail_from_address" value="{{ $settings['mail_from_address'] ?? 'noreply@pelefood.com' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="space-y-2">
                                <label for="mail_from_name" class="block text-sm font-medium text-gray-700">Nom d'expéditeur</label>
                                <input type="text" name="mail_from_name" id="mail_from_name" value="{{ $settings['mail_from_name'] ?? 'PeleFood' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="space-y-2">
                                <label for="mail_encryption" class="block text-sm font-medium text-gray-700">Chiffrement</label>
                                <select name="mail_encryption" id="mail_encryption" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="tls" {{ ($settings['mail_encryption'] ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ ($settings['mail_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                    <option value="" {{ ($settings['mail_encryption'] ?? '') == '' ? 'selected' : '' }}>Aucun</option>
                                </select>
                            </div>

                            <button type="button" onclick="testEmailConnection()" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                <i class="fas fa-paper-plane mr-2"></i> Tester la connexion
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Onglet Paiements -->
                <div id="content-payment" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Stripe</h3>
                            
                            <div class="space-y-2">
                                <label for="stripe_public_key" class="block text-sm font-medium text-gray-700">Clé publique</label>
                                <input type="text" name="stripe_public_key" id="stripe_public_key" value="{{ $settings['stripe_public_key'] ?? '' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="space-y-2">
                                <label for="stripe_secret_key" class="block text-sm font-medium text-gray-700">Clé secrète</label>
                                <input type="password" name="stripe_secret_key" id="stripe_secret_key" value="{{ $settings['stripe_secret_key'] ?? '' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="space-y-2">
                                <label for="stripe_webhook_secret" class="block text-sm font-medium text-gray-700">Webhook secret</label>
                                <input type="password" name="stripe_webhook_secret" id="stripe_webhook_secret" value="{{ $settings['stripe_webhook_secret'] ?? '' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">PayPal</h3>
                            
                            <div class="space-y-2">
                                <label for="paypal_client_id" class="block text-sm font-medium text-gray-700">Client ID</label>
                                <input type="text" name="paypal_client_id" id="paypal_client_id" value="{{ $settings['paypal_client_id'] ?? '' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="space-y-2">
                                <label for="paypal_client_secret" class="block text-sm font-medium text-gray-700">Client Secret</label>
                                <input type="password" name="paypal_client_secret" id="paypal_client_secret" value="{{ $settings['paypal_client_secret'] ?? '' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="space-y-2">
                                <label for="paypal_mode" class="block text-sm font-medium text-gray-700">Mode</label>
                                <select name="paypal_mode" id="paypal_mode" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="sandbox" {{ ($settings['paypal_mode'] ?? 'sandbox') == 'sandbox' ? 'selected' : '' }}>Sandbox</option>
                                    <option value="live" {{ ($settings['paypal_mode'] ?? '') == 'live' ? 'selected' : '' }}>Live</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Onglet Sécurité -->
                <div id="content-security" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Sécurité de l'Application</h3>
                            
                            <div class="space-y-2">
                                <label for="session_lifetime" class="block text-sm font-medium text-gray-700">Durée de session (minutes)</label>
                                <input type="number" name="session_lifetime" id="session_lifetime" value="{{ $settings['session_lifetime'] ?? '120' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="space-y-2">
                                <label for="max_login_attempts" class="block text-sm font-medium text-gray-700">Tentatives de connexion max</label>
                                <input type="number" name="max_login_attempts" id="max_login_attempts" value="{{ $settings['max_login_attempts'] ?? '5' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="space-y-2">
                                <label for="lockout_duration" class="block text-sm font-medium text-gray-700">Durée de verrouillage (minutes)</label>
                                <input type="number" name="lockout_duration" id="lockout_duration" value="{{ $settings['lockout_duration'] ?? '15' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Politique de Mots de Passe</h3>
                            
                            <div class="space-y-2">
                                <label for="min_password_length" class="block text-sm font-medium text-gray-700">Longueur minimale</label>
                                <input type="number" name="min_password_length" id="min_password_length" value="{{ $settings['min_password_length'] ?? '8' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="space-y-2">
                                <label for="require_uppercase" class="flex items-center">
                                    <input type="checkbox" name="require_uppercase" id="require_uppercase" value="1" 
                                           {{ ($settings['require_uppercase'] ?? true) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Exiger majuscules</span>
                                </label>
                            </div>

                            <div class="space-y-2">
                                <label for="require_numbers" class="flex items-center">
                                    <input type="checkbox" name="require_numbers" id="require_numbers" value="1" 
                                           {{ ($settings['require_numbers'] ?? true) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Exiger des chiffres</span>
                                </label>
                            </div>

                            <div class="space-y-2">
                                <label for="require_symbols" class="flex items-center">
                                    <input type="checkbox" name="require_symbols" id="require_symbols" value="1" 
                                           {{ ($settings['require_symbols'] ?? false) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Exiger des symboles</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Onglet Notifications -->
                <div id="content-notifications" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Notifications Email</h3>
                            
                            <div class="space-y-2">
                                <label for="notify_new_orders" class="flex items-center">
                                    <input type="checkbox" name="notify_new_orders" id="notify_new_orders" value="1" 
                                           {{ ($settings['notify_new_orders'] ?? true) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Nouvelles commandes</span>
                                </label>
                            </div>

                            <div class="space-y-2">
                                <label for="notify_payment_updates" class="flex items-center">
                                    <input type="checkbox" name="notify_payment_updates" id="notify_payment_updates" value="1" 
                                           {{ ($settings['notify_payment_updates'] ?? true) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Mises à jour de paiement</span>
                                </label>
                            </div>

                            <div class="space-y-2">
                                <label for="notify_system_alerts" class="flex items-center">
                                    <input type="checkbox" name="notify_system_alerts" id="notify_system_alerts" value="1" 
                                           {{ ($settings['notify_system_alerts'] ?? true) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Alertes système</span>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Notifications Push</h3>
                            
                            <div class="space-y-2">
                                <label for="push_notifications_enabled" class="flex items-center">
                                    <input type="checkbox" name="push_notifications_enabled" id="push_notifications_enabled" value="1" 
                                           {{ ($settings['push_notifications_enabled'] ?? true) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Activer les notifications push</span>
                                </label>
                            </div>

                            <div class="space-y-2">
                                <label for="fcm_server_key" class="block text-sm font-medium text-gray-700">Clé serveur FCM</label>
                                <input type="password" name="fcm_server_key" id="fcm_server_key" value="{{ $settings['fcm_server_key'] ?? '' }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <button type="button" onclick="resetTab()" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        <i class="fas fa-save w-4 h-4 mr-2"></i>
                        Sauvegarder les paramètres
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Masquer tous les contenus
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Désactiver tous les onglets
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Afficher le contenu sélectionné
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Activer l'onglet sélectionné
    const activeTab = document.getElementById('tab-' + tabName);
    activeTab.classList.add('active', 'border-blue-500', 'text-blue-600');
    activeTab.classList.remove('border-transparent', 'text-gray-500');
}

function resetTab() {
    // Réinitialiser le formulaire
    document.getElementById('settings-form').reset();
}

function saveAllSettings() {
    document.getElementById('settings-form').submit();
}

function resetAllSettings() {
    if (confirm('Êtes-vous sûr de vouloir réinitialiser tous les paramètres aux valeurs par défaut ?')) {
        // Logique de réinitialisation
        location.reload();
    }
}

function testEmailConnection() {
    // Logique de test de connexion email
    alert('Test de connexion email en cours...');
}
</script>
@endsection