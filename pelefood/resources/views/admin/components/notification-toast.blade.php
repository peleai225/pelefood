<!-- Toast de notification moderne -->
<div id="notification-toast" class="fixed top-4 right-4 z-50 transform translate-x-full transition-transform duration-300 ease-in-out">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 p-4 max-w-sm">
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <div id="toast-icon" class="w-8 h-8 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-white text-sm"></i>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p id="toast-title" class="text-sm font-semibold text-slate-800">Notification</p>
                <p id="toast-message" class="text-sm text-slate-600 mt-1">Message de notification</p>
            </div>
            <button onclick="hideToast()" class="flex-shrink-0 text-slate-400 hover:text-slate-600 transition-colors duration-200">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
        <div class="mt-3">
            <div id="toast-progress" class="h-1 bg-slate-200 rounded-full overflow-hidden">
                <div class="h-full bg-blue-500 rounded-full transition-all duration-100 ease-linear"></div>
            </div>
        </div>
    </div>
</div>

<script>
function showToast(title, message, type = 'success', duration = 5000) {
    const toast = document.getElementById('notification-toast');
    const icon = document.getElementById('toast-icon');
    const titleEl = document.getElementById('toast-title');
    const messageEl = document.getElementById('toast-message');
    const progress = document.getElementById('toast-progress').querySelector('div');
    
    // Configuration selon le type
    const configs = {
        success: {
            icon: 'fas fa-check',
            bgColor: 'bg-green-500',
            textColor: 'text-green-600'
        },
        error: {
            icon: 'fas fa-times',
            bgColor: 'bg-red-500',
            textColor: 'text-red-600'
        },
        warning: {
            icon: 'fas fa-exclamation',
            bgColor: 'bg-yellow-500',
            textColor: 'text-yellow-600'
        },
        info: {
            icon: 'fas fa-info',
            bgColor: 'bg-blue-500',
            textColor: 'text-blue-600'
        }
    };
    
    const config = configs[type] || configs.success;
    
    // Mise à jour du contenu
    icon.className = `w-8 h-8 rounded-full flex items-center justify-center ${config.bgColor}`;
    icon.querySelector('i').className = `${config.icon} text-white text-sm`;
    titleEl.textContent = title;
    messageEl.textContent = message;
    
    // Affichage avec animation
    toast.classList.remove('translate-x-full');
    toast.classList.add('translate-x-0');
    
    // Animation de la barre de progression
    progress.style.width = '100%';
    progress.style.transition = `width ${duration}ms linear`;
    
    // Auto-hide
    setTimeout(() => {
        hideToast();
    }, duration);
}

function hideToast() {
    const toast = document.getElementById('notification-toast');
    toast.classList.remove('translate-x-0');
    toast.classList.add('translate-x-full');
}

// Auto-hide au clic sur la croix
document.addEventListener('click', function(e) {
    if (e.target.closest('[onclick="hideToast()"]')) {
        hideToast();
    }
});
</script>
