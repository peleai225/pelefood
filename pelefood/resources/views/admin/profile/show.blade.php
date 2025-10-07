@extends('layouts.super-admin-new-design')

@section('title', 'Mon Profil - Super Admin')
@section('description', 'Gérez votre profil et vos informations personnelles')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Mon Profil</h1>
            <p class="mt-2 text-lg text-gray-600">Gérez vos informations personnelles et paramètres de compte</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.profile.edit') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-edit mr-2"></i> Modifier le profil
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Carte de profil -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="text-center">
                    <!-- Photo de profil -->
                    <div class="relative inline-block">
                        <div class="w-32 h-32 mx-auto rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" alt="Photo de profil" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center" style="display: none;">
                                    <span class="text-white text-4xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                    <span class="text-white text-4xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <button onclick="openAvatarModal()" class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-2 hover:bg-blue-700 transition-colors">
                            <i class="fas fa-camera w-4 h-4"></i>
                        </button>
                    </div>

                    <!-- Informations principales -->
                    <h2 class="mt-4 text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->job_title ?? 'Super Administrateur' }}</p>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    
                    @if($user->phone)
                    <p class="text-sm text-gray-500 mt-1">
                        <i class="fas fa-phone mr-2"></i>{{ $user->phone }}
                    </p>
                    @endif

                    <!-- Statut -->
                    <div class="mt-4 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                        Compte actif
                    </div>

                    <!-- Bio -->
                    @if($user->bio)
                    <div class="mt-4 text-center">
                        <p class="text-gray-700 text-sm">{{ $user->bio }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Statistiques du profil -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistiques</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Restaurants gérés</span>
                        <span class="font-semibold text-gray-900">{{ $stats['total_restaurants_managed'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Commandes gérées</span>
                        <span class="font-semibold text-gray-900">{{ $stats['total_orders_managed'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Permissions</span>
                        <span class="font-semibold text-gray-900">{{ $stats['role_permissions'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Dernière connexion</span>
                        <span class="font-semibold text-gray-900">
                            {{ $stats['last_login'] ? $stats['last_login']->format('d/m/Y') : 'Jamais' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Membre depuis</span>
                        <span class="font-semibold text-gray-900">{{ $stats['account_created']->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Détails du profil -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informations personnelles -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Informations Personnelles</h3>
                    <button onclick="toggleEdit('personal')" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        <i class="fas fa-edit mr-1"></i> Modifier
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                        <p class="mt-1 text-gray-900">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <p class="mt-1 text-gray-900">{{ $user->phone ?? 'Non renseigné' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Poste</label>
                        <p class="mt-1 text-gray-900">{{ $user->job_title ?? 'Non renseigné' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Département</label>
                        <p class="mt-1 text-gray-900">{{ $user->department ?? 'Non renseigné' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Site web</label>
                        <p class="mt-1 text-gray-900">
                            @if($user->website)
                                <a href="{{ $user->website }}" target="_blank" class="text-blue-600 hover:text-blue-700">{{ $user->website }}</a>
                            @else
                                Non renseigné
                            @endif
                        </p>
                    </div>
                </div>
                @if($user->address)
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Adresse</label>
                    <p class="mt-1 text-gray-900">{{ $user->address }}</p>
                </div>
                @endif
            </div>

            <!-- Réseaux sociaux -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Réseaux Sociaux</h3>
                    <button onclick="toggleEdit('social')" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        <i class="fas fa-edit mr-1"></i> Modifier
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <i class="fab fa-linkedin text-blue-600 w-5 mr-3"></i>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">LinkedIn</label>
                            <p class="text-gray-900">
                                @if($user->linkedin)
                                    <a href="{{ $user->linkedin }}" target="_blank" class="text-blue-600 hover:text-blue-700">{{ $user->linkedin }}</a>
                                @else
                                    Non renseigné
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fab fa-twitter text-blue-400 w-5 mr-3"></i>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Twitter</label>
                            <p class="text-gray-900">
                                @if($user->twitter)
                                    <a href="https://twitter.com/{{ $user->twitter }}" target="_blank" class="text-blue-600 hover:text-blue-700">@{{ $user->twitter }}</a>
                                @else
                                    Non renseigné
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fab fa-facebook text-blue-600 w-5 mr-3"></i>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Facebook</label>
                            <p class="text-gray-900">
                                @if($user->facebook)
                                    <a href="{{ $user->facebook }}" target="_blank" class="text-blue-600 hover:text-blue-700">{{ $user->facebook }}</a>
                                @else
                                    Non renseigné
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fab fa-instagram text-pink-600 w-5 mr-3"></i>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Instagram</label>
                            <p class="text-gray-900">
                                @if($user->instagram)
                                    <a href="https://instagram.com/{{ $user->instagram }}" target="_blank" class="text-blue-600 hover:text-blue-700">@{{ $user->instagram }}</a>
                                @else
                                    Non renseigné
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sécurité -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Sécurité</h3>
                    <button onclick="openPasswordModal()" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        <i class="fas fa-key mr-1"></i> Changer le mot de passe
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rôle</label>
                        <p class="mt-1 text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Statut du compte</label>
                        <p class="mt-1 text-gray-900">
                            @if($user->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Actif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Inactif
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour changer la photo de profil -->
<div id="avatarModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Changer la photo de profil</h3>
                <button onclick="closeAvatarModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="avatarForm" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <input type="file" id="avatarInput" name="avatar" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Formats acceptés: JPEG, PNG, JPG, GIF (max 2MB)</p>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeAvatarModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-upload mr-2"></i> Télécharger
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal pour changer le mot de passe -->
<div id="passwordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Changer le mot de passe</h3>
                <button onclick="closePasswordModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.profile.password') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                        <input type="password" name="current_password" id="current_password" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                        <input type="password" name="password" id="password" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closePasswordModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i> Sauvegarder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openAvatarModal() {
    document.getElementById('avatarModal').classList.remove('hidden');
}

function closeAvatarModal() {
    document.getElementById('avatarModal').classList.add('hidden');
}

function openPasswordModal() {
    document.getElementById('passwordModal').classList.remove('hidden');
}

function closePasswordModal() {
    document.getElementById('passwordModal').classList.add('hidden');
}

function toggleEdit(section) {
    window.location.href = "{{ route('admin.profile.edit') }}#" + section;
}

// Gestion du formulaire d'avatar
document.getElementById('avatarForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch("{{ route('admin.profile.avatar') }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mettre à jour l'image dans la page
            const avatarImg = document.querySelector('.w-32.h-32 img');
            if (avatarImg) {
                avatarImg.src = data.avatar_url;
            } else {
                location.reload();
            }
            closeAvatarModal();
            // Afficher un message de succès
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erreur lors du téléchargement de la photo');
    });
});

// Fermer les modals en cliquant à l'extérieur
window.onclick = function(event) {
    const avatarModal = document.getElementById('avatarModal');
    const passwordModal = document.getElementById('passwordModal');
    
    if (event.target == avatarModal) {
        closeAvatarModal();
    }
    if (event.target == passwordModal) {
        closePasswordModal();
    }
}
</script>
@endsection