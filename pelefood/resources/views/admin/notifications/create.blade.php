@extends('layouts.super-admin-new-design')

@section('title', 'Créer une Notification')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- En-tête de la page -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Créer une Notification</h1>
                <p class="mt-2 text-gray-600">Envoyez une nouvelle notification à un utilisateur ou un tenant</p>
            </div>
            <div>
                <a href="{{ route('admin.notifications.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour aux Notifications
                </a>
            </div>
        </div>
    </div>

    <!-- Formulaire de création -->
    <div class="bg-white rounded-lg shadow">
        <form method="POST" action="{{ route('admin.notifications.store') }}" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Destinataire -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Destinataire</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Utilisateur (optionnel)
                            </label>
                            <select name="user_id" id="user_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Sélectionner un utilisateur</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="tenant_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Tenant (optionnel)
                            </label>
                            <select name="tenant_id" id="tenant_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Sélectionner un tenant</option>
                                @foreach($tenants as $tenant)
                                <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                    {{ $tenant->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('tenant_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Laissez vide pour envoyer une notification globale à tous les utilisateurs
                    </p>
                </div>

                <!-- Titre -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Titre *
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="Titre de la notification">
                    @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message -->
                <div class="md:col-span-2">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                        Message *
                    </label>
                    <textarea name="message" id="message" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                              placeholder="Message de la notification">{{ old('message') }}</textarea>
                    @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type et Priorité -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        Type *
                    </label>
                    <select name="type" id="type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="info" {{ old('type') == 'info' ? 'selected' : '' }}>Information</option>
                        <option value="warning" {{ old('type') == 'warning' ? 'selected' : '' }}>Avertissement</option>
                        <option value="error" {{ old('type') == 'error' ? 'selected' : '' }}>Erreur</option>
                        <option value="success" {{ old('type') == 'success' ? 'selected' : '' }}>Succès</option>
                    </select>
                    @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                        Priorité *
                    </label>
                    <select name="priority" id="priority" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Faible</option>
                        <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }}>Normale</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Élevée</option>
                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgente</option>
                    </select>
                    @error('priority')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Action (optionnel)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="action_url" class="block text-sm font-medium text-gray-700 mb-2">
                                URL de l'action
                            </label>
                            <input type="url" name="action_url" id="action_url" value="{{ old('action_url') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="https://example.com/action">
                            @error('action_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="action_text" class="block text-sm font-medium text-gray-700 mb-2">
                                Texte de l'action
                            </label>
                            <input type="text" name="action_text" id="action_text" value="{{ old('action_text') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Voir les détails">
                            @error('action_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Si rempli, un bouton d'action sera affiché dans la notification
                    </p>
                </div>

                <!-- Options -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_read" id="is_read" value="1" {{ old('is_read') ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_read" class="ml-2 block text-sm text-gray-900">
                                Marquer comme lue
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" name="is_urgent" id="is_urgent" value="1" {{ old('is_urgent') ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_urgent" class="ml-2 block text-sm text-gray-900">
                                Marquer comme urgente
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="mt-8 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.notifications.index') }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-bell mr-2"></i>
                    Envoyer la Notification
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Mise à jour automatique de la priorité urgente
document.getElementById('priority').addEventListener('change', function() {
    const isUrgentCheckbox = document.getElementById('is_urgent');
    if (this.value === 'urgent') {
        isUrgentCheckbox.checked = true;
    }
});

// Validation du formulaire
document.querySelector('form').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const content = document.getElementById('content').value.trim();
    
    if (!title || !content) {
        e.preventDefault();
        alert('Veuillez remplir tous les champs obligatoires.');
        return false;
    }
    
    // Vérifier qu'au moins un destinataire est sélectionné
    const userId = document.getElementById('user_id').value;
    const tenantId = document.getElementById('tenant_id').value;
    
    if (!userId && !tenantId) {
        if (!confirm('Aucun destinataire spécifique sélectionné. Cette notification sera envoyée à tous les utilisateurs. Continuer ?')) {
            e.preventDefault();
            return false;
        }
    }
    
    // Vérifier que l'action est complète si une partie est remplie
    const actionUrl = document.getElementById('action_url').value.trim();
    const actionText = document.getElementById('action_text').value.trim();
    
    if ((actionUrl && !actionText) || (!actionUrl && actionText)) {
        e.preventDefault();
        alert('Si vous spécifiez une action, veuillez remplir à la fois l\'URL et le texte.');
        return false;
    }
});
</script>
@endsection 