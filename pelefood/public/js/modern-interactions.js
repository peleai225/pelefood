/**
 * PeleFood - Interactions Modernes et Animations Avancées
 * Améliore l'expérience utilisateur avec des micro-interactions et animations fluides
 */

class ModernInteractions {
    constructor() {
        this.init();
    }

    init() {
        this.setupScrollAnimations();
        this.setupParallaxEffects();
        this.setupInteractiveCards();
        this.setupButtonRipples();
        this.setupFloatingElements();
        this.setupProgressBars();
        this.setupCounterAnimations();
        this.setupStarAnimations();
        this.setupMobileOptimizations();
    }

    /**
     * Configuration des animations au scroll
     */
    setupScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    
                    // Animation des compteurs
                    if (entry.target.querySelector('[x-data*="count"]')) {
                        this.animateCounters(entry.target);
                    }
                }
            });
        }, observerOptions);

        // Observer tous les éléments avec la classe 'reveal'
        document.querySelectorAll('.reveal').forEach(el => {
            observer.observe(el);
        });
    }

    /**
     * Effet parallax pour les éléments de fond
     */
    setupParallaxEffects() {
        let ticking = false;
        
        const updateParallax = () => {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.floating-animation');
            
            parallaxElements.forEach((el, index) => {
                const speed = 0.3 + (index * 0.1);
                const yPos = -(scrolled * speed);
                el.style.transform = `translateY(${yPos}px)`;
            });
            
            ticking = false;
        };

        const requestTick = () => {
            if (!ticking) {
                requestAnimationFrame(updateParallax);
                ticking = true;
            }
        };

        window.addEventListener('scroll', requestTick, { passive: true });
    }

    /**
     * Cartes interactives avec effets 3D
     */
    setupInteractiveCards() {
        const cards = document.querySelectorAll('.card-interactive');
        
        cards.forEach(card => {
            card.addEventListener('mouseenter', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const rotateX = (y - centerY) / 10;
                const rotateY = (centerX - x) / 10;
                
                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(20px)`;
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateZ(0px)';
            });
            
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const rotateX = (y - centerY) / 10;
                const rotateY = (centerX - x) / 10;
                
                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(20px)`;
            });
        });
    }

    /**
     * Effet de ripple pour les boutons
     */
    setupButtonRipples() {
        const buttons = document.querySelectorAll('.btn-modern, a[href*="register"], a[href*="contact"]');
        
        buttons.forEach(button => {
            button.addEventListener('click', (e) => {
                const ripple = document.createElement('span');
                const rect = button.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(255, 255, 255, 0.3);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                    z-index: 1;
                `;
                
                button.style.position = 'relative';
                button.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    }

    /**
     * Animation des éléments flottants
     */
    setupFloatingElements() {
        const floatingElements = document.querySelectorAll('.floating-animation');
        
        floatingElements.forEach((el, index) => {
            const delay = index * 0.5;
            const duration = 3 + (index * 0.5);
            
            el.style.animation = `float ${duration}s ease-in-out infinite`;
            el.style.animationDelay = `${delay}s`;
        });
    }

    /**
     * Animation des barres de progression
     */
    setupProgressBars() {
        const progressBars = document.querySelectorAll('[x-data*="width"]');
        
        progressBars.forEach((bar, index) => {
            const progress = bar.querySelector('div');
            if (progress) {
                setTimeout(() => {
                    const targetWidth = bar.getAttribute('style')?.match(/width:\s*(\d+)%/)?.[1] || 0;
                    progress.style.width = targetWidth + '%';
                    progress.style.transition = 'width 1s ease-out';
                }, index * 200 + 500);
            }
        });
    }

    /**
     * Animation des compteurs
     */
    setupCounterAnimations() {
        const counters = document.querySelectorAll('[x-data*="count"]');
        
        counters.forEach((counter, index) => {
            setTimeout(() => {
                counter.classList.add('counter-animate');
            }, index * 200);
        });
    }

    /**
     * Animation des étoiles de notation
     */
    setupStarAnimations() {
        const starContainers = document.querySelectorAll('.flex.text-yellow-400');
        
        starContainers.forEach(container => {
            const stars = container.querySelectorAll('svg');
            stars.forEach((star, index) => {
                star.style.animationDelay = `${index * 0.1}s`;
                star.classList.add('animate-pulse');
            });
        });
    }

    /**
     * Optimisations pour mobile
     */
    setupMobileOptimizations() {
        // Réduire les animations sur mobile pour la performance
        if (window.innerWidth <= 768) {
            document.documentElement.style.setProperty('--animation-duration', '0.3s');
            
            // Désactiver les effets 3D sur mobile
            const cards = document.querySelectorAll('.card-interactive');
            cards.forEach(card => {
                card.style.transform = 'none';
            });
        }

        // Détecter les préférences de réduction de mouvement
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.documentElement.style.setProperty('--animation-duration', '0.01s');
        }
    }

    /**
     * Animation des compteurs avec Alpine.js
     */
    animateCounters(container) {
        const counters = container.querySelectorAll('[x-data*="count"]');
        counters.forEach((counter, index) => {
            setTimeout(() => {
                counter.classList.add('counter-animate');
            }, index * 200);
        });
    }
}

// Initialisation quand le DOM est prêt
document.addEventListener('DOMContentLoaded', () => {
    new ModernInteractions();
});

// Initialisation pour les pages avec chargement dynamique
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new ModernInteractions();
    });
} else {
    new ModernInteractions();
}

// Export pour utilisation dans d'autres modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ModernInteractions;
} 