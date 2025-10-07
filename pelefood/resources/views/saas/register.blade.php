@extends('layouts.saas-modern')

@section('title', 'Inscription - PeleFood SaaS')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="mx-auto h-16 w-16 bg-blue-600 rounded-full flex items-center justify-center mb-4">
                <i data-lucide="utensils" class="w-8 h-8 text-white"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Créez votre compte PeleFood SaaS
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Rejoignez des centaines de restaurateurs qui font confiance à notre plateforme
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 items-start">
            <!-- Registration Form -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-2xl font-bold text-gray-900">Informations du compte</h2>
                    <p class="text-gray-600">Remplissez les informations ci-dessous pour créer votre compte</p>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Name -->
                        <div class="form-group">
                            <label for="name" class="form-label">
                                Nom complet <span class="text-red-500">*</span>
                            </label>
                            <input 
                                id="name" 
                                type="text" 
                                name="name" 
                                value="{{ old('name') }}" 
                                required 
                                autocomplete="name" 
                                autofocus
                                class="form-input @error('name') border-red-500 @enderror"
                                placeholder="Votre nom complet"
                            >
                            @error('name')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email" class="form-label">
                                Adresse email <span class="text-red-500">*</span>
                            </label>
                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autocomplete="email"
                                class="form-input @error('email') border-red-500 @enderror"
                                placeholder="votre@email.com"
                            >
                            @error('email')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="form-group">
                            <label for="phone" class="form-label">
                                Numéro de téléphone
                            </label>
                            <input 
                                id="phone" 
                                type="tel" 
                                name="phone" 
                                value="{{ old('phone') }}" 
                                autocomplete="tel"
                                class="form-input @error('phone') border-red-500 @enderror"
                                placeholder="+33 6 12 34 56 78"
                            >
                            @error('phone')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password" class="form-label">
                                Mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    id="password" 
                                    type="password" 
                                    name="password" 
                                    required 
                                    autocomplete="new-password"
                                    class="form-input @error('password') border-red-500 @enderror pr-10"
                                    placeholder="Minimum 8 caractères"
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePassword('password')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                >
                                    <i data-lucide="eye" id="eye-icon-password" class="w-5 h-5 text-gray-400"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">
                                Confirmer le mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    id="password_confirmation" 
                                    type="password" 
                                    name="password_confirmation" 
                                    required 
                                    autocomplete="new-password"
                                    class="form-input @error('password_confirmation') border-red-500 @enderror pr-10"
                                    placeholder="Répétez votre mot de passe"
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePassword('password_confirmation')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                >
                                    <i data-lucide="eye" id="eye-icon-password_confirmation" class="w-5 h-5 text-gray-400"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Terms -->
                        <div class="form-group">
                            <div class="flex items-start">
                                <input 
                                    id="terms" 
                                    name="terms" 
                                    type="checkbox" 
                                    required
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1"
                                >
                                <label for="terms" class="ml-3 text-sm text-gray-700">
                                    J'accepte les 
                                    <a href="#" class="text-blue-600 hover:text-blue-500">conditions d'utilisation</a> 
                                    et la 
                                    <a href="#" class="text-blue-600 hover:text-blue-500">politique de confidentialité</a>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" class="btn btn-primary w-full btn-lg">
                                <i data-lucide="user-plus" class="w-5 h-5 mr-2"></i>
                                Créer mon compte
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Benefits Sidebar -->
            <div class="space-y-8">
                <!-- Why Choose Us -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-xl font-semibold text-gray-900">Pourquoi choisir PeleFood SaaS ?</h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-1">
                                    <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Gestion complète</h4>
                                    <p class="text-sm text-gray-600">Commandes, menu, facturation et analytics en un seul endroit</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-1">
                                    <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Interface intuitive</h4>
                                    <p class="text-sm text-gray-600">Design moderne et facile à utiliser pour toute votre équipe</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-1">
                                    <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Support 24/7</h4>
                                    <p class="text-sm text-gray-600">Notre équipe est là pour vous accompagner à tout moment</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-1">
                                    <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Sécurité garantie</h4>
                                    <p class="text-sm text-gray-600">Vos données sont protégées avec les meilleures pratiques</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing Preview -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-xl font-semibold text-gray-900">Tarifs transparents</h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Starter</span>
                                <span class="font-semibold text-gray-900">29€/mois</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Pro</span>
                                <span class="font-semibold text-gray-900">79€/mois</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Enterprise</span>
                                <span class="font-semibold text-gray-900">Sur mesure</span>
                            </div>
                        </div>
                        <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                            <p class="text-sm text-blue-800">
                                <i data-lucide="gift" class="w-4 h-4 inline mr-1"></i>
                                Essai gratuit de 14 jours
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-gray-600">
                        Déjà un compte ?
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500 font-medium">
                            Se connecter
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword(fieldId) {
        const passwordInput = document.getElementById(fieldId);
        const eyeIcon = document.getElementById('eye-icon-' + fieldId);
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.setAttribute('data-lucide', 'eye-off');
        } else {
            passwordInput.type = 'password';
            eyeIcon.setAttribute('data-lucide', 'eye');
        }
        
        // Re-initialize Lucide icons
        lucide.createIcons();
    }

    // Animation au chargement
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const sidebar = document.querySelector('.space-y-8');
        
        form.style.opacity = '0';
        form.style.transform = 'translateX(-20px)';
        sidebar.style.opacity = '0';
        sidebar.style.transform = 'translateX(20px)';
        
        setTimeout(() => {
            form.style.transition = 'all 0.5s ease-out';
            form.style.opacity = '1';
            form.style.transform = 'translateX(0)';
            
            sidebar.style.transition = 'all 0.5s ease-out';
            sidebar.style.opacity = '1';
            sidebar.style.transform = 'translateX(0)';
        }, 100);
    });
</script>
@endpush
