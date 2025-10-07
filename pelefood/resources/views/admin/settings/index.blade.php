@extends('layouts.super-admin-new-design')

@section('title', 'Paramètres - Administration')

@section('content')
<div class="space-y-6">
    @if(session('success'))
    <div class="rounded-md bg-green-50 dark:bg-green-900/20 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i data-lucide="check-circle" class="h-5 w-5 text-green-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800 dark:text-green-200">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    </div>
    @endif
    <!-- Header Section -->
    <div class="fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-foreground">Paramètres</h1>
                <p class="mt-2 text-muted-foreground">Configurez les paramètres de votre plateforme et personnalisez l'expérience utilisateur.</p>
            </div>
            <div class="flex items-center space-x-3">
                <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-secondary text-secondary-foreground hover:bg-secondary/80 h-10 px-4 py-2">
                    <i data-lucide="download" class="w-4 h-4 mr-2"></i> Exporter
                </button>
                <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                    <i data-lucide="settings" class="w-4 h-4 mr-2"></i> Configurer
                </button>
            </div>
        </div>
    </div>

    <!-- Settings Navigation Tabs -->
    <div class="fade-in" style="animation-delay: 0.1s;">
        <div class="border-b border-border">
            <nav class="-mb-px flex space-x-8">
                <button onclick="showTab('general')" id="tab-general" class="border-b-2 border-primary text-primary py-2 px-1 text-sm font-medium">
                    Général
                </button>
                <button onclick="showTab('security')" id="tab-security" class="border-b-2 border-transparent text-muted-foreground hover:text-foreground hover:border-muted-foreground py-2 px-1 text-sm font-medium">
                    Sécurité
                </button>
                <button onclick="showTab('notifications')" id="tab-notifications" class="border-b-2 border-transparent text-muted-foreground hover:text-foreground hover:border-muted-foreground py-2 px-1 text-sm font-medium">
                    Notifications
                </button>
                <button onclick="showTab('integrations')" id="tab-integrations" class="border-b-2 border-transparent text-muted-foreground hover:text-foreground hover:border-muted-foreground py-2 px-1 text-sm font-medium">
                    Intégrations
                </button>
                <button onclick="showTab('advanced')" id="tab-advanced" class="border-b-2 border-transparent text-muted-foreground hover:text-foreground hover:border-muted-foreground py-2 px-1 text-sm font-medium">
                    Avancé
                </button>
            </nav>
        </div>
    </div>

    <!-- Settings Content -->
    <div class="fade-in" style="animation-delay: 0.2s;">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-8">
            @csrf
            @method('PUT')
            <!-- General Settings Section -->
            <div id="content-general">
            <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
                <h2 class="text-xl font-semibold text-foreground mb-6 flex items-center">
                    <i data-lucide="settings" class="w-5 h-5 mr-3 text-primary"></i>
                    Paramètres Généraux
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-muted-foreground mb-2">Nom de la Plateforme</label>
                        <input type="text" name="platform_name" value="{{ $settings['platform_name'] ?? '' }}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-muted-foreground mb-2">URL de la Plateforme</label>
                        <input type="url" name="platform_url" value="{{ $settings['platform_url'] ?? '' }}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-sm font-medium text-muted-foreground mb-2">Email de Contact</label>
                        <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-muted-foreground mb-2">Téléphone de Contact</label>
                        <input type="tel" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-muted-foreground mb-2">Description de la Plateforme</label>
                        <textarea name="platform_description" rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">{{ $settings['platform_description'] ?? '' }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-sm font-medium text-muted-foreground mb-2">Fuseau Horaire</label>
                        <select name="timezone" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                            <option value="Europe/Paris" {{ ($settings['timezone'] ?? 'Europe/Paris') == 'Europe/Paris' ? 'selected' : '' }}>Europe/Paris (UTC+1)</option>
                            <option value="Europe/London" {{ ($settings['timezone'] ?? '') == 'Europe/London' ? 'selected' : '' }}>Europe/London (UTC+0)</option>
                            <option value="America/New_York" {{ ($settings['timezone'] ?? '') == 'America/New_York' ? 'selected' : '' }}>America/New_York (UTC-5)</option>
                            <option value="Asia/Tokyo" {{ ($settings['timezone'] ?? '') == 'Asia/Tokyo' ? 'selected' : '' }}>Asia/Tokyo (UTC+9)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-muted-foreground mb-2">Langue par Défaut</label>
                        <select name="default_language" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                            <option value="fr" {{ ($settings['default_language'] ?? 'fr') == 'fr' ? 'selected' : '' }}>Français</option>
                            <option value="en" {{ ($settings['default_language'] ?? '') == 'en' ? 'selected' : '' }}>English</option>
                            <option value="es" {{ ($settings['default_language'] ?? '') == 'es' ? 'selected' : '' }}>Español</option>
                            <option value="de" {{ ($settings['default_language'] ?? '') == 'de' ? 'selected' : '' }}>Deutsch</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-sm font-medium text-muted-foreground mb-2">Devise Principale</label>
                        <select name="currency" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                            <option value="EUR" {{ ($settings['currency'] ?? 'EUR') == 'EUR' ? 'selected' : '' }}>Euro (€)</option>
                            <option value="USD" {{ ($settings['currency'] ?? '') == 'USD' ? 'selected' : '' }}>Dollar US ($)</option>
                            <option value="GBP" {{ ($settings['currency'] ?? '') == 'GBP' ? 'selected' : '' }}>Livre Sterling (£)</option>
                            <option value="JPY" {{ ($settings['currency'] ?? '') == 'JPY' ? 'selected' : '' }}>Yen (¥)</option>
                            <option value="XOF" {{ ($settings['currency'] ?? '') == 'XOF' ? 'selected' : '' }}>Franc CFA (FCFA)</option>
                            <option value="CAD" {{ ($settings['currency'] ?? '') == 'CAD' ? 'selected' : '' }}>Dollar Canadien (C$)</option>
                            <option value="AUD" {{ ($settings['currency'] ?? '') == 'AUD' ? 'selected' : '' }}>Dollar Australien (A$)</option>
                            <option value="CHF" {{ ($settings['currency'] ?? '') == 'CHF' ? 'selected' : '' }}>Franc Suisse (CHF)</option>
                            <option value="CNY" {{ ($settings['currency'] ?? '') == 'CNY' ? 'selected' : '' }}>Yuan Chinois (¥)</option>
                            <option value="INR" {{ ($settings['currency'] ?? '') == 'INR' ? 'selected' : '' }}>Roupie Indienne (₹)</option>
                            <option value="BRL" {{ ($settings['currency'] ?? '') == 'BRL' ? 'selected' : '' }}>Real Brésilien (R$)</option>
                            <option value="MXN" {{ ($settings['currency'] ?? '') == 'MXN' ? 'selected' : '' }}>Peso Mexicain ($)</option>
                            <option value="RUB" {{ ($settings['currency'] ?? '') == 'RUB' ? 'selected' : '' }}>Rouble Russe (₽)</option>
                            <option value="ZAR" {{ ($settings['currency'] ?? '') == 'ZAR' ? 'selected' : '' }}>Rand Sud-Africain (R)</option>
                            <option value="NGN" {{ ($settings['currency'] ?? '') == 'NGN' ? 'selected' : '' }}>Naira Nigérian (₦)</option>
                            <option value="EGP" {{ ($settings['currency'] ?? '') == 'EGP' ? 'selected' : '' }}>Livre Égyptienne (E£)</option>
                            <option value="MAD" {{ ($settings['currency'] ?? '') == 'MAD' ? 'selected' : '' }}>Dirham Marocain (MAD)</option>
                            <option value="TND" {{ ($settings['currency'] ?? '') == 'TND' ? 'selected' : '' }}>Dinar Tunisien (DT)</option>
                            <option value="DZD" {{ ($settings['currency'] ?? '') == 'DZD' ? 'selected' : '' }}>Dinar Algérien (DA)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-muted-foreground mb-2">Format des Nombres</label>
                        <select name="number_format" class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                            <option value="fr" {{ ($settings['number_format'] ?? 'fr') == 'fr' ? 'selected' : '' }}>Français (1 234,56)</option>
                            <option value="en" {{ ($settings['number_format'] ?? '') == 'en' ? 'selected' : '' }}>Anglais (1,234.56)</option>
                            <option value="de" {{ ($settings['number_format'] ?? '') == 'de' ? 'selected' : '' }}>Allemand (1.234,56)</option>
                        </select>
                    </div>
                </div>
            </div>
            </div>

            <!-- Security Settings Section -->
            <div id="content-security" style="display: none;">
                <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
                    <h2 class="text-xl font-semibold text-foreground mb-6 flex items-center">
                        <i data-lucide="shield" class="w-5 h-5 mr-3 text-red-500"></i>
                        Paramètres de Sécurité
                    </h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-muted-foreground mb-2">Durée de Session (minutes)</label>
                            <input type="number" name="delivery_time" value="{{ $settings['delivery_time'] ?? 120 }}" min="5" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-foreground">Authentification à deux facteurs</h3>
                                <p class="text-sm text-muted-foreground">Exiger une vérification supplémentaire</p>
                            </div>
                            <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 bg-primary" role="switch" aria-checked="true">
                                <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications Settings Section -->
            <div id="content-notifications" style="display: none;">
                <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
                    <h2 class="text-xl font-semibold text-foreground mb-6 flex items-center">
                        <i data-lucide="bell" class="w-5 h-5 mr-3 text-blue-500"></i>
                        Paramètres de Notifications
                    </h2>
                    
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-foreground">Notifications par Email</h3>
                                <p class="text-sm text-muted-foreground">Recevoir des notifications par email</p>
                            </div>
                            <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 bg-primary" role="switch" aria-checked="true">
                                <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-foreground">Notifications Push</h3>
                                <p class="text-sm text-muted-foreground">Recevoir des notifications push</p>
                            </div>
                            <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 bg-gray-200" role="switch" aria-checked="false">
                                <span class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Integrations Settings Section -->
            <div id="content-integrations" style="display: none;">
                <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
                    <h2 class="text-xl font-semibold text-foreground mb-6 flex items-center">
                        <i data-lucide="plug" class="w-5 h-5 mr-3 text-purple-500"></i>
                        Intégrations
                    </h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-muted-foreground mb-2">API Key Stripe</label>
                            <input type="password" placeholder="Clé API Stripe" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-muted-foreground mb-2">Webhook URL</label>
                            <input type="url" placeholder="https://votre-site.com/webhook" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advanced Settings Section -->
            <div id="content-advanced" style="display: none;">
                <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
                    <h2 class="text-xl font-semibold text-foreground mb-6 flex items-center">
                        <i data-lucide="settings-2" class="w-5 h-5 mr-3 text-orange-500"></i>
                        Paramètres Avancés
                    </h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-muted-foreground mb-2">Niveau de Log</label>
                            <select class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                <option value="error">Error</option>
                                <option value="warning">Warning</option>
                                <option value="info" selected>Info</option>
                                <option value="debug">Debug</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-foreground">Mode Maintenance</h3>
                                <p class="text-sm text-muted-foreground">Mettre le site en maintenance</p>
                            </div>
                            <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 bg-gray-200" role="switch" aria-checked="false">
                                <span class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Business Settings Section -->
            <div class="rounded-xl border bg-card text-card-foreground shadow p-6">
                <h2 class="text-xl font-semibold text-foreground mb-6 flex items-center">
                    <i data-lucide="briefcase" class="w-5 h-5 mr-3 text-green-500"></i>
                    Paramètres Métier
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-muted-foreground mb-2">Commission par Défaut (%)</label>
                        <input type="number" value="15" min="0" max="100" step="0.1" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-muted-foreground mb-2">Frais de Service (%)</label>
                        <input type="number" value="5" min="0" max="100" step="0.1" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-sm font-medium text-muted-foreground mb-2">Délai de Préparation (min)</label>
                        <input type="number" value="30" min="0" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-muted-foreground mb-2">Délai de Livraison (min)</label>
                        <input type="number" value="45" min="0" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Limite de Produits par Restaurant</label>
                        <input type="number" value="100" min="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Limite de Commandes par Heure</label>
                        <input type="number" value="50" min="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300">
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="card-hover bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-toggle-on mr-3 text-purple-500"></i>
                    Fonctionnalités
                </h2>
                
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Mode Multi-Tenant</h3>
                            <p class="text-sm text-gray-500">Permettre à plusieurs restaurants d'utiliser la plateforme</p>
                        </div>
                        <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 bg-orange-500" role="switch" aria-checked="true">
                            <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Système de Notifications Push</h3>
                            <p class="text-sm text-gray-500">Envoyer des notifications en temps réel aux utilisateurs</p>
                        </div>
                        <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 bg-orange-500" role="switch" aria-checked="true">
                            <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Mode Maintenance</h3>
                            <p class="text-sm text-gray-500">Mettre la plateforme en maintenance</p>
                        </div>
                        <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 bg-gray-200" role="switch" aria-checked="false">
                            <span class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Mode Développement</h3>
                            <p class="text-sm text-gray-500">Afficher les informations de débogage</p>
                        </div>
                        <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 bg-gray-200" role="switch" aria-checked="false">
                            <span class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-8 py-2">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                    Sauvegarder les Paramètres
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showTab(tabName) {
    // Masquer tous les contenus
    const contents = ['general', 'security', 'notifications', 'integrations', 'advanced'];
    contents.forEach(content => {
        document.getElementById('content-' + content).style.display = 'none';
        document.getElementById('tab-' + content).classList.remove('border-primary', 'text-primary');
        document.getElementById('tab-' + content).classList.add('border-transparent', 'text-muted-foreground');
    });
    
    // Afficher le contenu sélectionné
    document.getElementById('content-' + tabName).style.display = 'block';
    document.getElementById('tab-' + tabName).classList.remove('border-transparent', 'text-muted-foreground');
    document.getElementById('tab-' + tabName).classList.add('border-primary', 'text-primary');
}

// Initialiser avec l'onglet Général
document.addEventListener('DOMContentLoaded', function() {
    showTab('general');
});
</script>
@endsection 