@extends('layouts.saas-modern')

@section('title', 'Connexion - PeleFood SaaS')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-blue-600 rounded-full flex items-center justify-center mb-4">
                <i data-lucide="utensils" class="w-8 h-8 text-white"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">
                Connexion à votre compte
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Accédez à votre tableau de bord PeleFood SaaS
            </p>
        </div>

        <!-- Login Form -->
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            Adresse email
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="email" 
                            autofocus
                            class="form-input @error('email') border-red-500 @enderror"
                            placeholder="votre@email.com"
                        >
                        @error('email')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            Mot de passe
                        </label>
                        <div class="relative">
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                required 
                                autocomplete="current-password"
                                class="form-input @error('password') border-red-500 @enderror pr-10"
                                placeholder="Votre mot de passe"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center"
                            >
                                <i data-lucide="eye" id="eye-icon" class="w-5 h-5 text-gray-400"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input 
                                id="remember" 
                                name="remember" 
                                type="checkbox" 
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                            >
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Se souvenir de moi
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-500">
                                    Mot de passe oublié ?
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="btn btn-primary w-full">
                            <i data-lucide="log-in" class="w-5 h-5 mr-2"></i>
                            Se connecter
                        </button>
                    </div>

                    <!-- Demo Credentials -->
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-900 mb-2">Comptes de démonstration :</h4>
                        <div class="space-y-1 text-xs text-blue-700">
                            <p><strong>Super Admin :</strong> admin@pelefood.ci</p>
                            <p><strong>Client :</strong> client@test.com</p>
                            <p class="text-blue-600">Mot de passe : password</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Register Link -->
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-500 font-medium">
                    Créer un compte
                </a>
            </p>
        </div>

        <!-- Features Preview -->
        <div class="mt-8">
            <div class="text-center mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Pourquoi choisir PeleFood SaaS ?</h3>
            </div>
            
            <div class="grid grid-cols-1 gap-4">
                <div class="flex items-center space-x-3 p-3 bg-white rounded-lg shadow-sm">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                    </div>
                    <span class="text-sm text-gray-700">Gestion complète des commandes</span>
                </div>
                
                <div class="flex items-center space-x-3 p-3 bg-white rounded-lg shadow-sm">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                    </div>
                    <span class="text-sm text-gray-700">Menu digital interactif</span>
                </div>
                
                <div class="flex items-center space-x-3 p-3 bg-white rounded-lg shadow-sm">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                    </div>
                    <span class="text-sm text-gray-700">Analytics en temps réel</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        
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
        form.style.opacity = '0';
        form.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            form.style.transition = 'all 0.5s ease-out';
            form.style.opacity = '1';
            form.style.transform = 'translateY(0)';
        }, 100);
    });
</script>
@endpush
