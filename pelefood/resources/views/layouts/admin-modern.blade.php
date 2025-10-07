<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'PeleFood Admin')</title>
    
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
    
    <!-- Custom CSS -->
    <style>
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
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .animate-slide-in-right {
            animation: slideInRight 0.4s ease-out;
        }
        
        /* Scrollbar personnalisée */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Gradient de fond */
        .bg-gradient-admin {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        /* Effet de glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
    </style>
    
    @stack('styles')
</head>

<body class="h-full bg-slate-50">
    <div class="flex h-full">
        <!-- Sidebar -->
        @include('admin.components.modern-sidebar')
        
        <!-- Contenu principal -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-64">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-slate-200 lg:hidden">
                <div class="flex items-center justify-between h-16 px-4">
                    <button onclick="toggleSidebar()" class="p-2 rounded-lg hover:bg-slate-100 transition-colors duration-200">
                        <i class="fas fa-bars text-slate-600"></i>
                    </button>
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div class="relative">
                            <button class="p-2 rounded-lg hover:bg-slate-100 transition-colors duration-200">
                                <i class="fas fa-bell text-slate-600"></i>
                                @if(auth()->user()->unreadNotifications()->count() > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-2 py-1 min-w-[20px] text-center">
                                        {{ auth()->user()->unreadNotifications()->count() }}
                                    </span>
                                @endif
                            </button>
                        </div>
                        
                        <!-- Profil utilisateur -->
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <span class="text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
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
    
    <!-- Toast de notification -->
    @include('admin.components.notification-toast')
    
    <!-- Scripts -->
    <script>
        // Configuration globale
        window.PeleFood = {
            csrfToken: '{{ csrf_token() }}',
            baseUrl: '{{ url("/") }}',
            user: @json(auth()->user())
        };
        
        // Fonction pour afficher les notifications
        function showNotification(title, message, type = 'success') {
            if (typeof showToast === 'function') {
                showToast(title, message, type);
            }
        }
        
        // Auto-refresh des notifications
        setInterval(function() {
            fetch('{{ route("admin.notifications.unread") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.count > 0) {
                        // Mettre à jour le compteur de notifications
                        const notificationBadges = document.querySelectorAll('.notification-count');
                        notificationBadges.forEach(badge => {
                            badge.textContent = data.count;
                            badge.classList.remove('hidden');
                        });
                    }
                })
                .catch(error => console.log('Erreur lors du rafraîchissement des notifications'));
        }, 30000); // Toutes les 30 secondes
        
        // Gestion des messages flash
        @if(session('success'))
            showNotification('Succès', '{{ session("success") }}', 'success');
        @endif
        
        @if(session('error'))
            showNotification('Erreur', '{{ session("error") }}', 'error');
        @endif
        
        @if(session('warning'))
            showNotification('Attention', '{{ session("warning") }}', 'warning');
        @endif
        
        @if(session('info'))
            showNotification('Information', '{{ session("info") }}', 'info');
        @endif
    </script>
    
    @stack('scripts')
</body>
</html>