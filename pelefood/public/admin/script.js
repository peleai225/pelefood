// Configuration globale
const CONFIG = {
    animations: {
        duration: 300,
        easing: 'ease-in-out'
    },
    charts: {
        colors: {
            primary: '#3b82f6',
            secondary: '#8b5cf6',
            success: '#10b981',
            warning: '#f59e0b',
            error: '#ef4444'
        }
    }
};

// Classe principale de l'application
class PeleFoodAdmin {
    constructor() {
        this.currentSection = 'dashboard';
        this.charts = {};
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.initializeCharts();
        this.setupAnimations();
        this.setupNotifications();
        this.setupMobileMenu();
        this.setupUserMenu();
        this.setupNavigation();
    }

    // Configuration des événements
    setupEventListeners() {
        // Navigation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const section = link.getAttribute('data-section');
                this.navigateToSection(section);
            });
        });

        // Boutons de menu mobile
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileOverlay = document.getElementById('mobileOverlay');

        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', () => {
                this.toggleMobileMenu();
            });
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                this.toggleSidebar();
            });
        }

        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', () => {
                this.closeMobileMenu();
            });
        }

        // Fermeture des menus au clic extérieur
        document.addEventListener('click', (e) => {
            this.handleOutsideClick(e);
        });

        // Gestion des touches clavier
        document.addEventListener('keydown', (e) => {
            this.handleKeyboard(e);
        });

        // Redimensionnement de la fenêtre
        window.addEventListener('resize', () => {
            this.handleResize();
        });
    }

    // Navigation entre les sections
    navigateToSection(section) {
        if (section === this.currentSection) return;

        // Mise à jour de la navigation active
        document.querySelectorAll('.nav-item').forEach(item => {
            item.classList.remove('active');
        });

        const activeLink = document.querySelector(`[data-section="${section}"]`);
        if (activeLink) {
            activeLink.parentElement.classList.add('active');
        }

        // Masquer toutes les sections
        document.querySelectorAll('.content-section').forEach(sectionEl => {
            sectionEl.classList.remove('active');
        });

        // Afficher la section sélectionnée
        const targetSection = document.getElementById(section);
        if (targetSection) {
            targetSection.classList.add('active');
            this.currentSection = section;
            this.updatePageTitle(section);
            this.animateSectionTransition(targetSection);
        }

        // Fermer le menu mobile si ouvert
        this.closeMobileMenu();
    }

    // Mise à jour du titre de la page
    updatePageTitle(section) {
        const titles = {
            dashboard: { title: 'Dashboard', description: 'Vue d\'ensemble de votre plateforme SaaS' },
            tenants: { title: 'Gestion des Tenants', description: 'Gérez tous les tenants de votre plateforme SaaS' },
            restaurants: { title: 'Gestion des Restaurants', description: 'Gérez tous les restaurants de votre plateforme' },
            users: { title: 'Gestion des Utilisateurs', description: 'Gérez tous les utilisateurs de votre plateforme' },
            orders: { title: 'Gestion des Commandes', description: 'Gérez toutes les commandes de votre plateforme' },
            subscriptions: { title: 'Gestion des Abonnements', description: 'Gérez tous les abonnements de votre plateforme' },
            payments: { title: 'Gestion des Paiements', description: 'Gérez tous les paiements de votre plateforme' },
            analytics: { title: 'Analytics', description: 'Analysez les performances de votre plateforme' },
            reports: { title: 'Rapports', description: 'Générez et consultez vos rapports' },
            support: { title: 'Support', description: 'Gérez le support client' },
            settings: { title: 'Paramètres', description: 'Configurez votre plateforme' }
        };

        const pageTitle = document.getElementById('pageTitle');
        const pageDescription = document.getElementById('pageDescription');

        if (titles[section] && pageTitle && pageDescription) {
            pageTitle.textContent = titles[section].title;
            pageDescription.textContent = titles[section].description;
        }
    }

    // Animation de transition des sections
    animateSectionTransition(section) {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';

        setTimeout(() => {
            section.style.transition = 'all 0.5s ease-in-out';
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }, 50);
    }

    // Menu mobile
    toggleMobileMenu() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobileOverlay');
        
        if (sidebar && overlay) {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
        }
    }

    closeMobileMenu() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobileOverlay');
        
        if (sidebar && overlay) {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            sidebar.classList.toggle('active');
        }
    }

    // Gestion des clics extérieurs
    handleOutsideClick(e) {
        // Fermer les dropdowns si on clique à l'extérieur
        const dropdowns = document.querySelectorAll('.notification-dropdown, .user-dropdown, .user-dropdown-header');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(e.target) && !e.target.closest('.notification-toggle, .user-menu-toggle, .user-menu-toggle-header')) {
                dropdown.style.opacity = '0';
                dropdown.style.visibility = 'hidden';
                dropdown.style.transform = 'translateY(10px)';
            }
        });
    }

    // Gestion du clavier
    handleKeyboard(e) {
        // Échap pour fermer les menus
        if (e.key === 'Escape') {
            this.closeMobileMenu();
        }

        // Raccourcis clavier pour la navigation
        if (e.ctrlKey || e.metaKey) {
            switch (e.key) {
                case '1':
                    e.preventDefault();
                    this.navigateToSection('dashboard');
                    break;
                case '2':
                    e.preventDefault();
                    this.navigateToSection('tenants');
                    break;
                case '3':
                    e.preventDefault();
                    this.navigateToSection('restaurants');
                    break;
                case '4':
                    e.preventDefault();
                    this.navigateToSection('users');
                    break;
            }
        }
    }

    // Gestion du redimensionnement
    handleResize() {
        if (window.innerWidth > 1024) {
            this.closeMobileMenu();
        }
    }

    // Configuration des notifications
    setupNotifications() {
        const notificationToggle = document.getElementById('notificationToggle');
        const notificationDropdown = document.getElementById('notificationDropdown');
        const markAllRead = document.querySelector('.mark-all-read');

        if (notificationToggle && notificationDropdown) {
            notificationToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggleNotificationDropdown();
            });
        }

        if (markAllRead) {
            markAllRead.addEventListener('click', (e) => {
                e.preventDefault();
                this.markAllNotificationsAsRead();
            });
        }

        // Marquer comme lu au clic
        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', () => {
                this.markNotificationAsRead(item);
            });
        });
    }

    toggleNotificationDropdown() {
        const dropdown = document.getElementById('notificationDropdown');
        if (dropdown) {
            const isVisible = dropdown.style.opacity === '1';
            
            if (isVisible) {
                dropdown.style.opacity = '0';
                dropdown.style.visibility = 'hidden';
                dropdown.style.transform = 'translateY(10px)';
            } else {
                dropdown.style.opacity = '1';
                dropdown.style.visibility = 'visible';
                dropdown.style.transform = 'translateY(0)';
            }
        }
    }

    markAllNotificationsAsRead() {
        document.querySelectorAll('.notification-item.unread').forEach(item => {
            item.classList.remove('unread');
        });

        const badge = document.querySelector('.notification-badge');
        if (badge) {
            badge.style.display = 'none';
        }

        this.showToast('Toutes les notifications ont été marquées comme lues', 'success');
    }

    markNotificationAsRead(item) {
        if (item.classList.contains('unread')) {
            item.classList.remove('unread');
            
            const unreadCount = document.querySelectorAll('.notification-item.unread').length;
            const badge = document.querySelector('.notification-badge');
            
            if (badge) {
                if (unreadCount === 0) {
                    badge.style.display = 'none';
                } else {
                    badge.textContent = unreadCount;
                }
            }
        }
    }

    // Configuration du menu utilisateur
    setupUserMenu() {
        const userMenuToggle = document.getElementById('userMenuToggle');
        const userDropdown = document.getElementById('userDropdown');

        if (userMenuToggle && userDropdown) {
            userMenuToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggleUserDropdown();
            });
        }

        // Gestion de la déconnexion
        document.querySelectorAll('.logout').forEach(logoutBtn => {
            logoutBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleLogout();
            });
        });
    }

    toggleUserDropdown() {
        const dropdown = document.getElementById('userDropdown');
        if (dropdown) {
            const isVisible = dropdown.style.opacity === '1';
            
            if (isVisible) {
                dropdown.style.opacity = '0';
                dropdown.style.visibility = 'hidden';
                dropdown.style.transform = 'translateY(10px)';
            } else {
                dropdown.style.opacity = '1';
                dropdown.style.visibility = 'visible';
                dropdown.style.transform = 'translateY(0)';
            }
        }
    }

    handleLogout() {
        if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
            this.showToast('Déconnexion en cours...', 'info');
            // Ici vous pouvez ajouter la logique de déconnexion
            setTimeout(() => {
                window.location.href = '/login';
            }, 1000);
        }
    }

    // Configuration de la navigation
    setupNavigation() {
        // Animation des liens de navigation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('mouseenter', () => {
                this.animateNavLink(link, 'enter');
            });

            link.addEventListener('mouseleave', () => {
                this.animateNavLink(link, 'leave');
            });
        });
    }

    animateNavLink(link, action) {
        const icon = link.querySelector('.nav-icon');
        if (icon) {
            if (action === 'enter') {
                icon.style.transform = 'scale(1.1) rotate(5deg)';
            } else {
                icon.style.transform = 'scale(1) rotate(0deg)';
            }
        }
    }

    // Configuration des animations
    setupAnimations() {
        // Animation des cartes de statistiques
        this.animateStatCards();
        
        // Animation des cartes de graphiques
        this.animateChartCards();
        
        // Animation des éléments d'activité
        this.animateActivityItems();
    }

    animateStatCards() {
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate-float');
        });
    }

    animateChartCards() {
        const chartCards = document.querySelectorAll('.chart-card');
        chartCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.2}s`;
            card.classList.add('animate-fade-in');
        });
    }

    animateActivityItems() {
        const activityItems = document.querySelectorAll('.activity-item');
        activityItems.forEach((item, index) => {
            item.style.animationDelay = `${index * 0.1}s`;
            item.classList.add('animate-slide-in');
        });
    }

    // Initialisation des graphiques
    initializeCharts() {
        this.createRevenueChart();
        this.createOrdersChart();
    }

    createRevenueChart() {
        const ctx = document.getElementById('revenueChart');
        if (!ctx) return;

        this.charts.revenue = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
                datasets: [{
                    label: 'Revenus (€)',
                    data: [18500, 19200, 20100, 21500, 22400, 23100, 23800, 24200, 24800, 25200, 25800, 24750],
                    borderColor: CONFIG.charts.colors.primary,
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: CONFIG.charts.colors.primary,
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
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
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: CONFIG.charts.colors.primary,
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false
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
                            color: '#6b7280',
                            font: {
                                size: 12
                            },
                            callback: function(value) {
                                return '€' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6b7280',
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    }

    createOrdersChart() {
        const ctx = document.getElementById('ordersChart');
        if (!ctx) return;

        this.charts.orders = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Livrées', 'En cours', 'Annulées', 'En attente'],
                datasets: [{
                    data: [65, 20, 10, 5],
                    backgroundColor: [
                        CONFIG.charts.colors.success,
                        CONFIG.charts.colors.primary,
                        CONFIG.charts.colors.error,
                        CONFIG.charts.colors.warning
                    ],
                    borderWidth: 0,
                    hoverBorderWidth: 2,
                    hoverBorderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            color: '#6b7280',
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: CONFIG.charts.colors.primary,
                        borderWidth: 1,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });
    }

    // Système de notifications toast
    showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="toast-icon fas ${this.getToastIcon(type)}"></i>
                <span class="toast-message">${message}</span>
            </div>
            <button class="toast-close">
                <i class="fas fa-times"></i>
            </button>
        `;

        // Styles du toast
        Object.assign(toast.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            background: this.getToastColor(type),
            color: '#ffffff',
            padding: '1rem 1.5rem',
            borderRadius: '12px',
            boxShadow: '0 10px 25px rgba(0, 0, 0, 0.2)',
            zIndex: '1000',
            transform: 'translateX(100%)',
            transition: 'transform 0.3s ease-in-out',
            display: 'flex',
            alignItems: 'center',
            gap: '0.75rem',
            minWidth: '300px'
        });

        document.body.appendChild(toast);

        // Animation d'entrée
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 100);

        // Fermeture automatique
        setTimeout(() => {
            this.hideToast(toast);
        }, 5000);

        // Fermeture manuelle
        const closeBtn = toast.querySelector('.toast-close');
        closeBtn.addEventListener('click', () => {
            this.hideToast(toast);
        });
    }

    hideToast(toast) {
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }

    getToastIcon(type) {
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };
        return icons[type] || icons.info;
    }

    getToastColor(type) {
        const colors = {
            success: 'linear-gradient(135deg, #10b981, #059669)',
            error: 'linear-gradient(135deg, #ef4444, #dc2626)',
            warning: 'linear-gradient(135deg, #f59e0b, #d97706)',
            info: 'linear-gradient(135deg, #3b82f6, #2563eb)'
        };
        return colors[type] || colors.info;
    }

    // Méthodes utilitaires
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }
}

// Initialisation de l'application
document.addEventListener('DOMContentLoaded', () => {
    const app = new PeleFoodAdmin();
    
    // Exposer l'application globalement pour le débogage
    window.PeleFoodAdmin = app;
    
    // Message de bienvenue
    setTimeout(() => {
        app.showToast('Bienvenue dans votre tableau de bord PeleFood !', 'success');
    }, 1000);
});

// Gestion des erreurs globales
window.addEventListener('error', (e) => {
    console.error('Erreur JavaScript:', e.error);
    // Ici vous pouvez envoyer l'erreur à un service de monitoring
});

// Gestion des promesses rejetées
window.addEventListener('unhandledrejection', (e) => {
    console.error('Promesse rejetée:', e.reason);
    // Ici vous pouvez envoyer l'erreur à un service de monitoring
}); 