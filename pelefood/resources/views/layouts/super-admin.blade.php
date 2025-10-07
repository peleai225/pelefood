<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Super Admin - PeleFood')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom CSS avec couleurs PeleFood -->
    <style>
        /* Variables PeleFood */
        :root {
            --pelefood-primary: #F77F00;      /* Orange PeleFood */
            --pelefood-secondary: #264653;    /* Bleu foncé PeleFood */
            --pelefood-success: #2A9D8F;      /* Vert PeleFood */
            --pelefood-danger: #E63946;       /* Rouge PeleFood */
            --pelefood-warning: #F4A261;      /* Orange clair */
            --pelefood-dark: #1A1A1A;         /* Noir PeleFood */
            --pelefood-light: #F8F9FA;        /* Gris clair */
            --pelefood-text: #212529;         /* Texte principal */
            --pelefood-text-muted: #6C757D;   /* Texte secondaire */
        }
        
        /* Animations personnalisées */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }
        
        @keyframes glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(247, 127, 0, 0.3);
            }
            50% {
                box-shadow: 0 0 30px rgba(247, 127, 0, 0.6);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .animate-slide-in-right {
            animation: slideInRight 0.4s ease-out;
        }
        
        .animate-pulse-slow {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        .animate-glow {
            animation: glow 2s ease-in-out infinite;
        }
        
        /* Scrollbar personnalisée PeleFood */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(247, 127, 0, 0.1);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--pelefood-primary);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #E55A00;
        }
        
        /* Gradient de fond Super Admin PeleFood */
        .bg-gradient-pelefood {
            background: linear-gradient(135deg, var(--pelefood-dark) 0%, var(--pelefood-secondary) 50%, var(--pelefood-dark) 100%);
        }
        
        .bg-gradient-pelefood-header {
            background: linear-gradient(135deg, var(--pelefood-primary) 0%, #E55A00 100%);
        }
        
        /* Effet de glassmorphism PeleFood */
        .glass-pelefood {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(247, 127, 0, 0.2);
        }
        
        .glass-pelefood-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(247, 127, 0, 0.3);
        }
        
        /* Effet de glow PeleFood */
        .glow-pelefood {
            box-shadow: 0 0 20px rgba(247, 127, 0, 0.3);
        }
        
        .glow-pelefood-strong {
            box-shadow: 0 0 30px rgba(247, 127, 0, 0.5);
        }
        
        /* Animation de particules PeleFood */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }
        
        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: var(--pelefood-primary);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
            opacity: 0.7;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
                opacity: 0;
            }
            50% {
                transform: translateY(-100px) rotate(180deg);
                opacity: 0.7;
            }
        }
        
        /* Boutons PeleFood */
        .btn-pelefood {
            background: linear-gradient(135deg, var(--pelefood-primary) 0%, #E55A00 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(247, 127, 0, 0.3);
        }
        
        .btn-pelefood:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(247, 127, 0, 0.4);
        }
        
        /* Cartes PeleFood */
        .card-pelefood {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(247, 127, 0, 0.2);
            border-radius: 16px;
            transition: all 0.3s ease;
        }
        
        .card-pelefood:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(247, 127, 0, 0.4);
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(247, 127, 0, 0.2);
        }
        
        /* Texte PeleFood */
        .text-pelefood-primary {
            color: var(--pelefood-primary);
        }
        
        .text-pelefood-secondary {
            color: var(--pelefood-secondary);
        }
        
        .text-pelefood-success {
            color: var(--pelefood-success);
        }
        
        .text-pelefood-danger {
            color: var(--pelefood-danger);
        }
        
        /* Backgrounds PeleFood */
        .bg-pelefood-primary {
            background-color: var(--pelefood-primary);
        }
        
        .bg-pelefood-secondary {
            background-color: var(--pelefood-secondary);
        }
        
        .bg-pelefood-success {
            background-color: var(--pelefood-success);
        }
        
        .bg-pelefood-danger {
            background-color: var(--pelefood-danger);
        }
        
        /* Gradients PeleFood */
        .bg-gradient-pelefood-primary {
            background: linear-gradient(135deg, var(--pelefood-primary) 0%, #E55A00 100%);
        }
        
        .bg-gradient-pelefood-secondary {
            background: linear-gradient(135deg, var(--pelefood-secondary) 0%, #2A9D8F 100%);
        }
        
        .bg-gradient-pelefood-success {
            background: linear-gradient(135deg, var(--pelefood-success) 0%, #2A9D8F 100%);
        }
    </style>
    
    @stack('styles')
</head>

<body class="h-full bg-gradient-pelefood">
    <!-- Particules de fond -->
    <div class="particles" id="particles"></div>
    
    <div class="flex h-full">
        <!-- Sidebar Super Admin -->
        @include('admin.components.super-admin-sidebar')
        
        <!-- Contenu principal -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-72">
            <!-- Header mobile -->
            <header class="bg-gradient-pelefood-header shadow-2xl border-b border-orange-500/20 lg:hidden">
                <div class="flex items-center justify-between h-16 px-4">
                    <button onclick="toggleSuperAdminSidebar()" class="p-2 rounded-xl hover:bg-white/10 transition-colors duration-200">
                        <i class="fas fa-bars text-white"></i>
                    </button>
                    <div class="flex items-center space-x-4">
                        <!-- Indicateur de statut -->
                        <div class="flex items-center space-x-2 bg-white/10 backdrop-blur-sm rounded-xl px-3 py-1">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-white text-xs font-medium">En ligne</span>
                        </div>
                        
                        <!-- Profil Super Admin -->
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-crown text-white text-sm"></i>
                            </div>
                            <span class="text-white font-medium text-sm">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Contenu de la page -->
            <main class="flex-1 overflow-y-auto">
                <div class="py-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    <!-- Toast de notification Super Admin -->
    <div id="superAdminNotificationToast" class="fixed top-4 right-4 z-50 transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-2xl shadow-2xl border border-purple-500/20 p-4 max-w-sm">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <div id="superAdminToastIcon" class="w-8 h-8 rounded-full flex items-center justify-center">
                        <i class="fas fa-crown text-white text-sm"></i>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p id="superAdminToastTitle" class="text-sm font-semibold text-white">Notification Super Admin</p>
                    <p id="superAdminToastMessage" class="text-sm text-purple-100 mt-1">Message de notification</p>
                </div>
                <button onclick="hideSuperAdminToast()" class="flex-shrink-0 text-purple-200 hover:text-white transition-colors duration-200">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
            <div class="mt-3">
                <div id="superAdminToastProgress" class="h-1 bg-white/20 rounded-full overflow-hidden">
                    <div class="h-full bg-white rounded-full transition-all duration-100 ease-linear"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script>
        // Configuration globale Super Admin
        window.PeleFoodSuperAdmin = {
            csrfToken: '{{ csrf_token() }}',
            baseUrl: '{{ url("/") }}',
            user: @json(auth()->user()),
            isSuperAdmin: true
        };
        
        // Fonction pour afficher les notifications Super Admin
        function showSuperAdminNotification(title, message, type = 'info', duration = 5000) {
            const toast = document.getElementById('superAdminNotificationToast');
            const icon = document.getElementById('superAdminToastIcon');
            const titleEl = document.getElementById('superAdminToastTitle');
            const messageEl = document.getElementById('superAdminToastMessage');
            const progress = document.getElementById('superAdminToastProgress').querySelector('div');
            
            // Configuration selon le type
            const configs = {
                success: {
                    icon: 'fas fa-check',
                    bgColor: 'bg-gradient-to-r from-green-500 to-emerald-500'
                },
                error: {
                    icon: 'fas fa-times',
                    bgColor: 'bg-gradient-to-r from-red-500 to-pink-500'
                },
                warning: {
                    icon: 'fas fa-exclamation',
                    bgColor: 'bg-gradient-to-r from-yellow-500 to-orange-500'
                },
                info: {
                    icon: 'fas fa-crown',
                    bgColor: 'bg-gradient-to-r from-purple-500 to-blue-500'
                }
            };
            
            const config = configs[type] || configs.info;
            
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
                hideSuperAdminToast();
            }, duration);
        }
        
        function hideSuperAdminToast() {
            const toast = document.getElementById('superAdminNotificationToast');
            toast.classList.remove('translate-x-0');
            toast.classList.add('translate-x-full');
        }
        
        // Génération de particules
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 50;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 6 + 's';
                particle.style.animationDuration = (Math.random() * 3 + 3) + 's';
                particlesContainer.appendChild(particle);
            }
        }
        
        // Auto-refresh des métriques
        setInterval(function() {
            // Mise à jour des métriques en temps réel
            fetch('{{ route("admin.super-admin.dashboard") }}')
                .then(response => response.json())
                .then(data => {
                    // Mettre à jour les métriques
                    console.log('Métriques mises à jour');
                })
                .catch(error => console.log('Erreur lors de la mise à jour des métriques'));
        }, 30000); // Toutes les 30 secondes
        
        // Gestion des messages flash
        @if(session('success'))
            showSuperAdminNotification('Succès', '{{ session("success") }}', 'success');
        @endif
        
        @if(session('error'))
            showSuperAdminNotification('Erreur', '{{ session("error") }}', 'error');
        @endif
        
        @if(session('warning'))
            showSuperAdminNotification('Attention', '{{ session("warning") }}', 'warning');
        @endif
        
        @if(session('info'))
            showSuperAdminNotification('Information', '{{ session("info") }}', 'info');
        @endif
        
        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            
            // Animations d'entrée
            const cards = document.querySelectorAll('.bg-white\\/10, .bg-white\\/5');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
