/**
 * PeleFood Admin - JavaScript Moderne
 * Améliorations des interactions et animations
 */

class PeleFoodAdmin {
    constructor() {
        this.init();
    }

    init() {
        this.setupAnimations();
        this.setupInteractions();
        this.setupCharts();
        this.setupNotifications();
        this.setupSearch();
        this.setupSidebar();
    }

    /**
     * Configuration des animations
     */
    setupAnimations() {
        // Animation des cartes au scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);

        // Observer les éléments animables
        document.querySelectorAll('.stat-card, .card-shadcn, .animate-on-scroll').forEach(el => {
            el.classList.add('animate-ready');
            observer.observe(el);
        });

        // Animation des statistiques
        this.animateCounters();
    }

    /**
     * Animation des compteurs
     */
    animateCounters() {
        const counters = document.querySelectorAll('.stat-value');
        
        counters.forEach(counter => {
            const target = parseInt(counter.textContent.replace(/[^\d]/g, ''));
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;

            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                
                // Formater le nombre
                const formatted = this.formatNumber(current);
                counter.textContent = formatted;
            }, 16);
        });
    }

    /**
     * Formatage des nombres
     */
    formatNumber(num) {
        if (num >= 1000000) {
            return (num / 1000000).toFixed(1) + 'M';
        } else if (num >= 1000) {
            return (num / 1000).toFixed(1) + 'K';
        }
        return Math.floor(num).toLocaleString();
    }

    /**
     * Configuration des interactions
     */
    setupInteractions() {
        // Effet de hover sur les cartes
        document.querySelectorAll('.stat-card, .card-shadcn').forEach(card => {
            card.addEventListener('mouseenter', (e) => {
                this.addHoverEffect(e.target);
            });

            card.addEventListener('mouseleave', (e) => {
                this.removeHoverEffect(e.target);
            });
        });

        // Effet de ripple sur les boutons
        document.querySelectorAll('.btn-shadcn').forEach(button => {
            button.addEventListener('click', (e) => {
                this.createRippleEffect(e);
            });
        });

        // Tooltips personnalisés
        this.setupTooltips();
    }

    /**
     * Effet de hover
     */
    addHoverEffect(element) {
        element.style.transform = 'translateY(-8px) scale(1.02)';
        element.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 20px rgba(14, 165, 233, 0.15)';
    }

    /**
     * Suppression de l'effet de hover
     */
    removeHoverEffect(element) {
        element.style.transform = '';
        element.style.boxShadow = '';
    }

    /**
     * Effet de ripple
     */
    createRippleEffect(event) {
        const button = event.currentTarget;
        const ripple = document.createElement('span');
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;

        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');

        button.appendChild(ripple);

        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    /**
     * Configuration des tooltips
     */
    setupTooltips() {
        document.querySelectorAll('[data-tooltip]').forEach(element => {
            element.addEventListener('mouseenter', (e) => {
                this.showTooltip(e.target);
            });

            element.addEventListener('mouseleave', (e) => {
                this.hideTooltip(e.target);
            });
        });
    }

    /**
     * Affichage du tooltip
     */
    showTooltip(element) {
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip-popup';
        tooltip.textContent = element.getAttribute('data-tooltip');
        
        document.body.appendChild(tooltip);
        
        const rect = element.getBoundingClientRect();
        tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + 'px';
        
        element.tooltip = tooltip;
    }

    /**
     * Masquage du tooltip
     */
    hideTooltip(element) {
        if (element.tooltip) {
            element.tooltip.remove();
            element.tooltip = null;
        }
    }

    /**
     * Configuration des graphiques
     */
    setupCharts() {
        // Graphique des revenus amélioré
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            const gradient = revenueCtx.getContext('2d').createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(14, 165, 233, 0.3)');
            gradient.addColorStop(1, 'rgba(14, 165, 233, 0.05)');

            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                    datasets: [{
                        label: 'Revenus (XOF)',
                        data: [120000, 190000, 150000, 250000, 220000, 300000, 280000],
                        borderColor: '#0ea5e9',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#0ea5e9',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 10,
                        pointHoverBackgroundColor: '#0ea5e9',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
                            titleColor: '#1e293b',
                            bodyColor: '#475569',
                            borderColor: '#e2e8f0',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y.toLocaleString() + ' XOF';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString() + ' XOF';
                                },
                                color: '#64748b',
                                font: {
                                    size: 12
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#64748b',
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                }
            });
        }
    }

    /**
     * Configuration des notifications
     */
    setupNotifications() {
        // Auto-fermeture des alertes
        document.querySelectorAll('[role="alert"]').forEach(alert => {
            setTimeout(() => {
                this.fadeOut(alert);
            }, 5000);
        });

        // Boutons de fermeture des alertes
        document.querySelectorAll('[role="alert"] button').forEach(button => {
            button.addEventListener('click', (e) => {
                this.fadeOut(e.target.closest('[role="alert"]'));
            });
        });
    }

    /**
     * Animation de fade out
     */
    fadeOut(element) {
        element.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
        element.style.opacity = '0';
        element.style.transform = 'translateY(-10px)';
        
        setTimeout(() => {
            element.remove();
        }, 300);
    }

    /**
     * Configuration de la recherche
     */
    setupSearch() {
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            let searchTimeout;

            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.performSearch(e.target.value);
                }, 300);
            });

            // Animation de focus
            searchInput.addEventListener('focus', (e) => {
                e.target.parentElement.classList.add('search-focused');
            });

            searchInput.addEventListener('blur', (e) => {
                e.target.parentElement.classList.remove('search-focused');
            });
        }
    }

    /**
     * Exécution de la recherche
     */
    performSearch(query) {
        // Simulation de recherche
        console.log('Recherche:', query);
        
        // Ici vous pouvez implémenter la logique de recherche réelle
        // Par exemple, faire un appel AJAX vers votre API
    }

    /**
     * Configuration de la sidebar
     */
    setupSidebar() {
        const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.sidebar-overlay');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('sidebar-open');
                document.body.classList.toggle('sidebar-open');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('sidebar-open');
                document.body.classList.remove('sidebar-open');
            });
        }

        // Fermeture automatique sur mobile
        const mediaQuery = window.matchMedia('(max-width: 768px)');
        const handleResize = (e) => {
            if (e.matches) {
                sidebar.classList.remove('sidebar-open');
                document.body.classList.remove('sidebar-open');
            }
        };

        mediaQuery.addListener(handleResize);
    }

    /**
     * Notification toast
     */
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${this.getNotificationIcon(type)}"></i>
                <span>${message}</span>
            </div>
            <button class="notification-close">
                <i class="fas fa-times"></i>
            </button>
        `;

        document.body.appendChild(notification);

        // Animation d'entrée
        setTimeout(() => {
            notification.classList.add('notification-show');
        }, 100);

        // Auto-fermeture
        setTimeout(() => {
            this.hideNotification(notification);
        }, 5000);

        // Fermeture manuelle
        notification.querySelector('.notification-close').addEventListener('click', () => {
            this.hideNotification(notification);
        });
    }

    /**
     * Masquage de notification
     */
    hideNotification(notification) {
        notification.classList.remove('notification-show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }

    /**
     * Icône de notification
     */
    getNotificationIcon(type) {
        const icons = {
            success: 'check-circle',
            error: 'times-circle',
            warning: 'exclamation-triangle',
            info: 'info-circle'
        };
        return icons[type] || 'info-circle';
    }
}

// Initialisation quand le DOM est prêt
document.addEventListener('DOMContentLoaded', () => {
    window.peleFoodAdmin = new PeleFoodAdmin();
});

// Styles CSS pour les animations
const styles = `
    .animate-ready {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .animate-in {
        opacity: 1;
        transform: translateY(0);
    }

    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }

    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    .tooltip-popup {
        position: fixed;
        background: #1e293b;
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        z-index: 1000;
        pointer-events: none;
        opacity: 0;
        transform: translateY(-4px);
        transition: opacity 0.2s ease-out, transform 0.2s ease-out;
    }

    .tooltip-popup::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 4px solid transparent;
        border-top-color: #1e293b;
    }

    .search-focused .search-input {
        transform: scale(1.02);
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
    }

    .notification {
        position: fixed;
        top: 2rem;
        right: 2rem;
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
        z-index: 1000;
        transform: translateX(100%);
        transition: transform 0.3s ease-out;
        max-width: 400px;
    }

    .notification-show {
        transform: translateX(0);
    }

    .notification-content {
        display: flex;
        align-items: center;
        padding: 1rem 1.5rem;
        gap: 0.75rem;
    }

    .notification-close {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: none;
        border: none;
        color: #64748b;
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 0.25rem;
        transition: color 0.2s ease-out;
    }

    .notification-close:hover {
        color: #1e293b;
    }

    .notification-success {
        border-left: 4px solid #10b981;
    }

    .notification-error {
        border-left: 4px solid #ef4444;
    }

    .notification-warning {
        border-left: 4px solid #f59e0b;
    }

    .notification-info {
        border-left: 4px solid #0ea5e9;
    }
`;

// Injection des styles
const styleSheet = document.createElement('style');
styleSheet.textContent = styles;
document.head.appendChild(styleSheet); 