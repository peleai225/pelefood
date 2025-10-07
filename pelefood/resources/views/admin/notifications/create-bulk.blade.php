@extends('layouts.super-admin-new-design')

@section('title', 'Notification en masse')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-4">
                <a href="{{ route('admin.notifications.index') }}" 
                   class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Notification en masse</h1>
            </div>
            <p class="text-gray-600 dark:text-gray-400">
                Envoyez une notification à plusieurs utilisateurs en même temps
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <form action="{{ route('admin.notifications.send-bulk') }}" method="POST" class="p-6">
                    @csrf
                    
                    <!-- Type de notification -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Type de notification
                        </label>
                        <select name="type" required 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Sélectionner un type</option>
                            <option value="announcement">📢 Annonce</option>
                            <option value="promotion">🎉 Promotion</option>
                            <option value="maintenance">🔧 Maintenance</option>
                            <option value="update">🆕 Mise à jour</option>
                        </select>
                    </div>

                    <!-- Titre -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Titre de la notification
                        </label>
                        <input type="text" name="title" required maxlength="255"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="Ex: Nouvelle promotion disponible !">
                    </div>

                    <!-- Message -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Message
                        </label>
                        <textarea name="message" required rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                  placeholder="Décrivez votre message..."></textarea>
                    </div>

                    <!-- Canaux de diffusion -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Canaux de diffusion
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="channels[]" value="database" checked
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700 dark:text-gray-300">📱 Base de données</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="channels[]" value="mail"
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700 dark:text-gray-300">📧 Email</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="channels[]" value="slack"
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700 dark:text-gray-300">💬 Slack</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="channels[]" value="nexmo"
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700 dark:text-gray-300">📱 SMS</span>
                            </label>
                        </div>
                    </div>

                    <!-- Rôles cibles -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Rôles cibles
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="target_roles[]" value="super_admin"
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700 dark:text-gray-300">👑 Super Admin</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="target_roles[]" value="admin"
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700 dark:text-gray-300">⚙️ Admin</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="target_roles[]" value="restaurant"
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700 dark:text-gray-300">🍽️ Restaurant</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="target_roles[]" value="customer" checked
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700 dark:text-gray-300">👤 Client</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="target_roles[]" value="driver"
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700 dark:text-gray-300">🚚 Livreur</span>
                            </label>
                        </div>
                    </div>

                    <!-- Aperçu -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Aperçu de la notification
                        </label>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-lg">
                                    🔔
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white" id="preview-title">
                                        Titre de la notification
                                    </h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1" id="preview-message">
                                        Message de la notification
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.notifications.index') }}" 
                           class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                            Annuler
                        </a>
                        <div class="flex space-x-3">
                            <button type="button" onclick="testNotification()" 
                                    class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                                Tester
                            </button>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                Envoyer la notification
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Mise à jour de l'aperçu en temps réel
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.querySelector('input[name="title"]');
    const messageInput = document.querySelector('textarea[name="message"]');
    const typeSelect = document.querySelector('select[name="type"]');
    const previewTitle = document.getElementById('preview-title');
    const previewMessage = document.getElementById('preview-message');
    const previewIcon = document.querySelector('#preview-icon');

    function updatePreview() {
        const title = titleInput.value || 'Titre de la notification';
        const message = messageInput.value || 'Message de la notification';
        const type = typeSelect.value;
        
        previewTitle.textContent = title;
        previewMessage.textContent = message;
        
        // Mettre à jour l'icône selon le type
        const iconMap = {
            'announcement': '📢',
            'promotion': '🎉',
            'maintenance': '🔧',
            'update': '🆕'
        };
        
        const icon = iconMap[type] || '🔔';
        const iconElement = document.querySelector('.w-10.h-10');
        if (iconElement) {
            iconElement.textContent = icon;
        }
    }

    titleInput.addEventListener('input', updatePreview);
    messageInput.addEventListener('input', updatePreview);
    typeSelect.addEventListener('change', updatePreview);
    
    // Initialiser l'aperçu
    updatePreview();
});

function testNotification() {
    const form = document.querySelector('form');
    const formData = new FormData(form);
    
    // Créer un formulaire de test
    const testForm = document.createElement('form');
    testForm.method = 'POST';
    testForm.action = '{{ route("admin.notifications.test") }}';
    
    // Ajouter le token CSRF
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    testForm.appendChild(csrfToken);
    
    // Ajouter le type
    const typeInput = document.createElement('input');
    typeInput.type = 'hidden';
    typeInput.name = 'type';
    typeInput.value = 'announcement';
    testForm.appendChild(typeInput);
    
    // Ajouter les canaux sélectionnés
    const selectedChannels = Array.from(document.querySelectorAll('input[name="channels[]"]:checked'))
        .map(cb => cb.value);
    
    selectedChannels.forEach(channel => {
        const channelInput = document.createElement('input');
        channelInput.type = 'hidden';
        channelInput.name = 'channels[]';
        channelInput.value = channel;
        testForm.appendChild(channelInput);
    });
    
    document.body.appendChild(testForm);
    testForm.submit();
}
</script>
@endsection
