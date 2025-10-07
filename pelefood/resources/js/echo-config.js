// Configuration Laravel Echo pour les notifications temps réel
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
    },
});

// Écouter les notifications pour l'utilisateur connecté
window.Echo.private(`App.Models.User.${window.Laravel.user.id}`)
    .notification((notification) => {
        // Mettre à jour le compteur de notifications
        updateNotificationCount();
        
        // Afficher une notification toast
        showNotificationToast(notification);
        
        // Jouer un son de notification
        playNotificationSound();
    });

// Fonction pour mettre à jour le compteur
function updateNotificationCount() {
    // Mettre à jour le badge dans la sidebar
    const badges = document.querySelectorAll('.notification-badge');
    badges.forEach(badge => {
        const currentCount = parseInt(badge.textContent) || 0;
        badge.textContent = currentCount + 1;
        badge.classList.remove('hidden');
    });
    
    // Mettre à jour le dropdown si ouvert
    if (window.notificationDropdown) {
        window.notificationDropdown.loadNotifications();
    }
}

// Fonction pour afficher un toast
function showNotificationToast(notification) {
    // Créer un toast de notification
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg p-4 max-w-sm z-50 transform translate-x-full transition-transform duration-300';
    
    const icon = getNotificationIcon(notification.data.type);
    const bgColor = getNotificationBgColor(notification.data.type);
    
    toast.innerHTML = `
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 rounded-full flex items-center justify-center ${bgColor}">
                    ${icon}
                </div>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                    ${notification.data.title}
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                    ${notification.data.message}
                </p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Animation d'entrée
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Auto-suppression après 5 secondes
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

// Fonction pour jouer un son
function playNotificationSound() {
    const audio = new Audio('/sounds/notification.mp3');
    audio.volume = 0.3;
    audio.play().catch(() => {
        // Ignorer les erreurs si l'audio ne peut pas être joué
    });
}

// Fonctions utilitaires
function getNotificationIcon(type) {
    switch(type) {
        case 'success': return '✅';
        case 'error': return '❌';
        case 'warning': return '⚠️';
        default: return '🔔';
    }
}

function getNotificationBgColor(type) {
    switch(type) {
        case 'success': return 'bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400';
        case 'error': return 'bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-400';
        case 'warning': return 'bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400';
        default: return 'bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400';
    }
}

// Export pour utilisation globale
window.updateNotificationCount = updateNotificationCount;
window.showNotificationToast = showNotificationToast;
