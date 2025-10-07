@extends('layouts.super-admin-new-design')

@section('title', 'Modifier mon Profil - Super Admin')
@section('description', 'Modifiez vos informations personnelles et paramètres de compte')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Modifier mon Profil</h1>
            <p class="mt-2 text-lg text-gray-600">Mettez à jour vos informations personnelles</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.profile.show') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Retour au profil
            </a>
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

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-600 mr-3"></i>
            <div>
                <p class="text-red-800 font-medium">Erreurs dans le formulaire :</p>
                <ul class="text-red-700 text-sm mt-1">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Informations personnelles -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6" id="personal">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Informations Personnelles</h3>
                <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Photo de profil" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                            <span class="text-white text-2xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom complet *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="space-y-2">
                    <label for="job_title" class="block text-sm font-medium text-gray-700">Poste</label>
                    <input type="text" name="job_title" id="job_title" value="{{ old('job_title', $user->job_title) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="space-y-2">
                    <label for="department" class="block text-sm font-medium text-gray-700">Département</label>
                    <input type="text" name="department" id="department" value="{{ old('department', $user->department) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="space-y-2">
                    <label for="website" class="block text-sm font-medium text-gray-700">Site web</label>
                    <input type="url" name="website" id="website" value="{{ old('website', $user->website) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="mt-6">
                <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                <textarea name="address" id="address" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('address', $user->address) }}</textarea>
            </div>

            <div class="mt-6">
                <label for="bio" class="block text-sm font-medium text-gray-700">Biographie</label>
                <textarea name="bio" id="bio" rows="4" placeholder="Décrivez-vous en quelques mots..."
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('bio', $user->bio) }}</textarea>
            </div>
        </div>

        <!-- Réseaux sociaux -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6" id="social">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Réseaux Sociaux</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="linkedin" class="block text-sm font-medium text-gray-700">
                        <i class="fab fa-linkedin text-blue-600 mr-2"></i>LinkedIn
                    </label>
                    <input type="url" name="linkedin" id="linkedin" value="{{ old('linkedin', $user->linkedin) }}"
                           placeholder="https://linkedin.com/in/votre-profil"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="space-y-2">
                    <label for="twitter" class="block text-sm font-medium text-gray-700">
                        <i class="fab fa-twitter text-blue-400 mr-2"></i>Twitter
                    </label>
                    <input type="text" name="twitter" id="twitter" value="{{ old('twitter', $user->twitter) }}"
                           placeholder="votre_nom_utilisateur"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="space-y-2">
                    <label for="facebook" class="block text-sm font-medium text-gray-700">
                        <i class="fab fa-facebook text-blue-600 mr-2"></i>Facebook
                    </label>
                    <input type="url" name="facebook" id="facebook" value="{{ old('facebook', $user->facebook) }}"
                           placeholder="https://facebook.com/votre-profil"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="space-y-2">
                    <label for="instagram" class="block text-sm font-medium text-gray-700">
                        <i class="fab fa-instagram text-pink-600 mr-2"></i>Instagram
                    </label>
                    <input type="text" name="instagram" id="instagram" value="{{ old('instagram', $user->instagram) }}"
                           placeholder="votre_nom_utilisateur"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>

        <!-- Informations du compte -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Informations du Compte</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Rôle</label>
                    <div class="mt-1 p-3 bg-gray-50 rounded-lg">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Statut du compte</label>
                    <div class="mt-1 p-3 bg-gray-50 rounded-lg">
                        @if($user->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                Actif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                Inactif
                            </span>
                        @endif
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Membre depuis</label>
                    <div class="mt-1 p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-900">{{ $user->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Dernière connexion</label>
                    <div class="mt-1 p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-900">
                            {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y à H:i') : 'Jamais' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.profile.show') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                Annuler
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                <i class="fas fa-save w-4 h-4 mr-2"></i>
                Sauvegarder les modifications
            </button>
        </div>
    </form>
</div>

<script>
// Scroll vers la section si elle est spécifiée dans l'URL
document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash;
    if (hash) {
        const element = document.querySelector(hash);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
            // Ajouter un effet de surbrillance
            element.classList.add('ring-2', 'ring-blue-500', 'ring-opacity-50');
            setTimeout(() => {
                element.classList.remove('ring-2', 'ring-blue-500', 'ring-opacity-50');
            }, 3000);
        }
    }
});

// Validation en temps réel
document.getElementById('email').addEventListener('blur', function() {
    const email = this.value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (email && !emailRegex.test(email)) {
        this.classList.add('border-red-500');
        this.classList.remove('border-gray-300');
    } else {
        this.classList.remove('border-red-500');
        this.classList.add('border-gray-300');
    }
});

document.getElementById('website').addEventListener('blur', function() {
    const website = this.value;
    const urlRegex = /^https?:\/\/.+\..+/;
    
    if (website && !urlRegex.test(website)) {
        this.classList.add('border-red-500');
        this.classList.remove('border-gray-300');
    } else {
        this.classList.remove('border-red-500');
        this.classList.add('border-gray-300');
    }
});

// Auto-formatage des réseaux sociaux
document.getElementById('linkedin').addEventListener('blur', function() {
    let value = this.value.trim();
    if (value && !value.startsWith('http')) {
        this.value = 'https://linkedin.com/in/' + value;
    }
});

document.getElementById('facebook').addEventListener('blur', function() {
    let value = this.value.trim();
    if (value && !value.startsWith('http')) {
        this.value = 'https://facebook.com/' + value;
    }
});
</script>
@endsection