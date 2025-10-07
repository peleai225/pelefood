@extends('layouts.super-admin-new-design')

@section('title', 'Créer un Restaurant')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-plus-circle text-purple-600 mr-3"></i>
                Créer un Nouveau Restaurant
            </h1>
            <p class="text-gray-600">Ajoutez un nouveau restaurant à la plateforme PeleFood</p>
        </div>

        <!-- Formulaire -->
        <form action="{{ route('admin.restaurants.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Section Type de Compte -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user-cog text-purple-600 mr-2"></i>
                    Type de Compte
                </h2>
                
                <div class="space-y-4">
                    <!-- Option 1: Utilisateur existant -->
                    <div class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 cursor-pointer" onclick="selectUserType('existing')">
                        <input type="radio" name="create_new_user" id="existing_user" value="0" class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300" {{ old('create_new_user', '0') == '0' ? 'checked' : '' }}>
                        <label for="existing_user" class="ml-3 text-sm font-medium text-gray-900 cursor-pointer flex-1">
                            <div class="flex items-center">
                                <i class="fas fa-user-tie mr-2 text-gray-500"></i>
                                Utiliser un utilisateur existant
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Sélectionner un utilisateur déjà enregistré</p>
                        </label>
                    </div>

                    <!-- Option 2: Nouvel utilisateur -->
                    <div class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 cursor-pointer" onclick="selectUserType('new')">
                        <input type="radio" name="create_new_user" id="new_user" value="1" class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300" {{ old('create_new_user') == '1' ? 'checked' : '' }}>
                        <label for="new_user" class="ml-3 text-sm font-medium text-gray-900 cursor-pointer flex-1">
                            <div class="flex items-center">
                                <i class="fas fa-user-plus mr-2 text-gray-500"></i>
                                Créer un nouveau compte utilisateur
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Créer un nouveau compte avec identifiants</p>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Section Utilisateur Existant -->
            <div id="existing-user-section" class="bg-white rounded-xl shadow-lg p-6 border border-gray-200" style="display: {{ old('create_new_user') == '1' ? 'none' : 'block' }}">
                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-users text-purple-600 mr-2"></i>
                    Sélectionner un Utilisateur
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Utilisateur</label>
                        <select name="user_id" id="user_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                            <option value="">Sélectionner un utilisateur</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section Nouvel Utilisateur -->
            <div id="new-user-section" class="bg-white rounded-xl shadow-lg p-6 border border-gray-200" style="display: {{ old('create_new_user') == '1' ? 'block' : 'none' }}">
                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user-plus text-purple-600 mr-2"></i>
                    Informations du Nouvel Utilisateur
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="user_name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                        <input type="text" name="user_name" id="user_name" value="{{ old('user_name') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                    </div>
                    
                    <div>
                        <label for="user_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="user_email" id="user_email" value="{{ old('user_email') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                    </div>
                    
                    <div>
                        <label for="user_phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                        <input type="text" name="user_phone" id="user_phone" value="{{ old('user_phone') }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                    </div>
                    
                    <div>
                        <label for="user_password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe temporaire</label>
                        <div class="relative">
                            <input type="password" name="user_password" id="user_password" value="{{ old('user_password') }}" 
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                            <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-eye" id="password-icon"></i>
                            </button>
                        </div>
                        <button type="button" onclick="generatePassword()" class="mt-2 text-sm text-purple-600 hover:text-purple-700 font-medium">
                            <i class="fas fa-key mr-1"></i>Générer un mot de passe sécurisé
                        </button>
                    </div>
                </div>
            </div>

            <!-- Section Informations Restaurant -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-store text-purple-600 mr-2"></i>
                    Informations du Restaurant
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom du restaurant *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email du restaurant *</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                    </div>
                    
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Ville *</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                    </div>
                    
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Pays *</label>
                        <select name="country" id="country" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                            <option value="">Sélectionner un pays</option>
                            <option value="CI" {{ old('country') == 'CI' ? 'selected' : '' }}>Côte d'Ivoire</option>
                            <option value="FR" {{ old('country') == 'FR' ? 'selected' : '' }}>France</option>
                            <option value="SN" {{ old('country') == 'SN' ? 'selected' : '' }}>Sénégal</option>
                            <option value="ML" {{ old('country') == 'ML' ? 'selected' : '' }}>Mali</option>
                            <option value="BF" {{ old('country') == 'BF' ? 'selected' : '' }}>Burkina Faso</option>
                            <option value="NE" {{ old('country') == 'NE' ? 'selected' : '' }}>Niger</option>
                            <option value="TG" {{ old('country') == 'TG' ? 'selected' : '' }}>Togo</option>
                            <option value="BJ" {{ old('country') == 'BJ' ? 'selected' : '' }}>Bénin</option>
                            <option value="GH" {{ old('country') == 'GH' ? 'selected' : '' }}>Ghana</option>
                            <option value="NG" {{ old('country') == 'NG' ? 'selected' : '' }}>Nigeria</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Adresse *</label>
                        <textarea name="address" id="address" rows="3" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">{{ old('address') }}</textarea>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section Plan d'Abonnement -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-crown text-purple-600 mr-2"></i>
                    Plan d'Abonnement
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($subscriptionPlans as $plan)
                        <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 cursor-pointer" onclick="selectPlan('{{ $plan->id }}')">
                            <input type="radio" name="subscription_plan_id" id="plan_{{ $plan->id }}" value="{{ $plan->id }}" 
                                   class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300" 
                                   {{ old('subscription_plan_id') == $plan->id ? 'checked' : '' }}>
                            <label for="plan_{{ $plan->id }}" class="ml-3 text-sm font-medium text-gray-900 cursor-pointer flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold">{{ $plan->name }}</span>
                                    <span class="text-purple-600 font-bold">{{ currency($plan->price) }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ $plan->description }}</p>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Section Options Avancées -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-cog text-purple-600 mr-2"></i>
                    Options Avancées
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 cursor-pointer" onclick="toggleCheckbox('is_active')">
                            <input type="checkbox" name="is_active" id="is_active" value="1" 
                                   class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" 
                                   {{ old('is_active') ? 'checked' : '' }}>
                            <label for="is_active" class="ml-3 text-sm font-medium text-gray-900 cursor-pointer flex-1">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle mr-2 text-gray-500"></i>
                                    Restaurant actif
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Le restaurant sera visible sur la plateforme</p>
                            </label>
                        </div>
                        
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 cursor-pointer" onclick="toggleCheckbox('delivery_available')">
                            <input type="checkbox" name="delivery_available" id="delivery_available" value="1" 
                                   class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" 
                                   {{ old('delivery_available') ? 'checked' : '' }}>
                            <label for="delivery_available" class="ml-3 text-sm font-medium text-gray-900 cursor-pointer flex-1">
                                <div class="flex items-center">
                                    <i class="fas fa-truck mr-2 text-gray-500"></i>
                                    Livraison disponible
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Le restaurant propose la livraison</p>
                            </label>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 cursor-pointer" onclick="toggleCheckbox('takeaway_available')">
                            <input type="checkbox" name="takeaway_available" id="takeaway_available" value="1" 
                                   class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" 
                                   {{ old('takeaway_available') ? 'checked' : '' }}>
                            <label for="takeaway_available" class="ml-3 text-sm font-medium text-gray-900 cursor-pointer flex-1">
                                <div class="flex items-center">
                                    <i class="fas fa-shopping-bag mr-2 text-gray-500"></i>
                                    À emporter disponible
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Le restaurant propose le service à emporter</p>
                            </label>
                        </div>
                        
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 cursor-pointer" onclick="toggleCheckbox('auto_approve_orders')">
                            <input type="checkbox" name="auto_approve_orders" id="auto_approve_orders" value="1" 
                                   class="h-5 w-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded" 
                                   {{ old('auto_approve_orders') ? 'checked' : '' }}>
                            <label for="auto_approve_orders" class="ml-3 text-sm font-medium text-gray-900 cursor-pointer flex-1">
                                <div class="flex items-center">
                                    <i class="fas fa-magic mr-2 text-gray-500"></i>
                                    Approbation automatique
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Les commandes sont approuvées automatiquement</p>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.restaurants.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Annuler
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium">
                    <i class="fas fa-plus mr-2"></i>Créer le Restaurant
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Fonction pour sélectionner le type d'utilisateur
function selectUserType(type) {
    const existingSection = document.getElementById('existing-user-section');
    const newSection = document.getElementById('new-user-section');
    const existingRadio = document.getElementById('existing_user');
    const newRadio = document.getElementById('new_user');
    
    if (type === 'existing') {
        existingRadio.checked = true;
        newRadio.checked = false;
        existingSection.style.display = 'block';
        newSection.style.display = 'none';
    } else {
        newRadio.checked = true;
        existingRadio.checked = false;
        existingSection.style.display = 'none';
        newSection.style.display = 'block';
    }
}

// Fonction pour sélectionner un plan
function selectPlan(planId) {
    // Décocher tous les autres plans
    document.querySelectorAll('input[name="subscription_plan_id"]').forEach(radio => {
        radio.checked = false;
    });
    
    // Cocher le plan sélectionné
    document.getElementById('plan_' + planId).checked = true;
}

// Fonction pour basculer les checkboxes
function toggleCheckbox(checkboxId) {
    const checkbox = document.getElementById(checkboxId);
    checkbox.checked = !checkbox.checked;
}

// Fonction pour basculer la visibilité du mot de passe
function togglePassword() {
    const passwordField = document.getElementById('user_password');
    const passwordIcon = document.getElementById('password-icon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordIcon.classList.remove('fa-eye');
        passwordIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        passwordIcon.classList.remove('fa-eye-slash');
        passwordIcon.classList.add('fa-eye');
    }
}

// Fonction pour générer un mot de passe
function generatePassword() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
    let password = '';
    for (let i = 0; i < 12; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    
    document.getElementById('user_password').value = password;
    
    // Afficher le mot de passe généré
    document.getElementById('user_password').type = 'text';
    document.getElementById('password-icon').classList.remove('fa-eye');
    document.getElementById('password-icon').classList.add('fa-eye-slash');
}
</script>
@endsection