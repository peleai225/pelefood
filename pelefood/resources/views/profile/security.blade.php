@extends('layouts.restaurant')

@section('title', 'Paramètres de sécurité - ' . $user->name)
@section('page-title', 'Paramètres de sécurité')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Paramètres de sécurité</h1>
                <p class="text-gray-600 mt-1">Gérez la sécurité de votre compte</p>
            </div>
            <a href="{{ route('profile.show') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <!-- Navigation -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6">
                <a href="{{ route('profile.show') }}" 
                   class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <i class="fas fa-user mr-2"></i>
                    Informations
                </a>
                <a href="{{ route('profile.edit') }}" 
                   class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <i class="fas fa-edit mr-2"></i>
                    Modifier
                </a>
                <a href="{{ route('profile.change-password') }}" 
                   class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <i class="fas fa-lock mr-2"></i>
                    Mot de passe
                </a>
                <a href="{{ route('profile.security') }}" 
                   class="border-b-2 border-orange-500 py-4 px-1 text-sm font-medium text-orange-600">
                    <i class="fas fa-shield-alt mr-2"></i>
                    Sécurité
                </a>
                <a href="{{ route('profile.activity') }}" 
                   class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <i class="fas fa-history mr-2"></i>
                    Activité
                </a>
            </nav>
        </div>

        <div class="p-6 space-y-8">
            <!-- Authentification à deux facteurs -->
            <div class="border border-gray-200 rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-mobile-alt text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Authentification à deux facteurs</h3>
                            <p class="text-gray-600">Ajoutez une couche de sécurité supplémentaire à votre compte</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-1"></i>
                            Non activée
                        </span>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Activer
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sessions actives -->
            <div class="border border-gray-200 rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Sessions actives</h3>
                    <button class="text-red-600 hover:text-red-700 text-sm font-medium">
                        <i class="fas fa-sign-out-alt mr-1"></i>
                        Déconnecter toutes les sessions
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-desktop text-green-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Session actuelle</h4>
                                <p class="text-sm text-gray-600">{{ request()->ip() }} - {{ request()->userAgent() }}</p>
                                <p class="text-xs text-gray-500">Connecté depuis {{ now()->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Actuelle
                        </span>
                    </div>
                </div>
            </div>

            <!-- Notifications de sécurité -->
            <div class="border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Notifications de sécurité</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-gray-900">Connexions depuis de nouveaux appareils</h4>
                            <p class="text-sm text-gray-600">Recevez une notification par email lors d'une nouvelle connexion</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600"></div>
                        </label>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-gray-900">Changements de mot de passe</h4>
                            <p class="text-sm text-gray-600">Soyez informé lorsque votre mot de passe est modifié</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600"></div>
                        </label>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-gray-900">Modifications du profil</h4>
                            <p class="text-sm text-gray-600">Recevez une confirmation des changements de vos informations</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Suppression du compte -->
            <div class="border border-red-200 rounded-lg p-6 bg-red-50">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">Zone de danger</h3>
                        <p class="text-gray-600">Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.</p>
                    </div>
                    <button onclick="openDeleteModal()" 
                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash mr-2"></i>
                        Supprimer le compte
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression du compte -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Supprimer le compte</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Cette action est irréversible. Toutes vos données seront définitivement supprimées.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form method="POST" action="{{ route('profile.delete-account') }}" class="space-y-4">
                    @csrf
                    @method('DELETE')
                    <div>
                        <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmez votre mot de passe
                        </label>
                        <input type="password" id="delete_password" name="password" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                               placeholder="Votre mot de passe">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeDeleteModal()"
                                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                            Annuler
                        </button>
                        <button type="submit"
                                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Supprimer définitivement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openDeleteModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Fermer le modal en cliquant à l'extérieur
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endsection 