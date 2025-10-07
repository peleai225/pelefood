<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - PeleFood</title>
    <meta name="description" content="Connectez-vous à votre compte PeleFood pour gérer votre restaurant.">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <!-- Custom PeleFood Styles -->
    <style>
        :root {
            --pelefood-primary: #F77F00;
            --pelefood-secondary: #E63946;
            --pelefood-blue: #264653;
            --pelefood-green: #2A9D8F;
            --pelefood-warning: #F4A261;
            --pelefood-dark: #1A1A1A;
            --pelefood-light: #F8F9FA;
        }
        
        .pelefood-gradient {
            background: linear-gradient(135deg, var(--pelefood-primary) 0%, var(--pelefood-secondary) 100%);
        }
        
        .pelefood-gradient-soft {
            background: linear-gradient(135deg, rgba(247, 127, 0, 0.1) 0%, rgba(230, 57, 70, 0.1) 100%);
        }
        
        .pelefood-shadow {
            box-shadow: 0 20px 25px -5px rgba(247, 127, 0, 0.1), 0 10px 10px -5px rgba(247, 127, 0, 0.04);
        }
        
        .pelefood-shadow-lg {
            box-shadow: 0 25px 50px -12px rgba(247, 127, 0, 0.25);
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .animate-pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="h-full bg-gray-50 font-inter">
    <!-- Layout en deux colonnes -->
    <div class="min-h-screen flex">
        <!-- Panneau de gauche - Visuel/Marketing -->
        <div class="hidden lg:flex lg:w-1/2 pelefood-gradient relative overflow-hidden">
            <!-- Motifs décoratifs -->
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -translate-y-48 translate-x-48 animate-pulse-slow"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full translate-y-32 -translate-x-32 animate-float"></div>
            
            <!-- Contenu du panneau gauche -->
            <div class="relative z-10 flex flex-col justify-between p-12 text-white">
                <!-- Header -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold">PeleFood</span>
                    </div>
                    <a href="/" class="text-white/80 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                </div>
                
                <!-- Contenu principal -->
                <div class="max-w-md">
                    <h1 class="text-4xl font-bold mb-6 leading-tight">
                        Bienvenue sur 
                        <span class="text-yellow-300">PeleFood</span>
                    </h1>
                    <p class="text-xl text-white/90 mb-8 leading-relaxed">
                        La plateforme de livraison qui révolutionne l'expérience culinaire en Côte d'Ivoire. 
                        Rejoignez des milliers de restaurants qui font confiance à PeleFood.
                    </p>
                    
                    <!-- Statistiques -->
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-yellow-300">500+</div>
                            <div class="text-white/80 text-sm">Restaurants</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-yellow-300">50K+</div>
                            <div class="text-white/80 text-sm">Commandes</div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="flex items-center space-x-6 text-white/60">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm">Sécurisé</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm">Rapide</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm">Fiable</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Panneau de droite - Formulaire -->
        <div class="flex-1 flex flex-col justify-center px-4 sm:px-6 lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-md lg:w-[28rem] xl:w-[32rem]">
                <!-- Header mobile -->
                <div class="lg:hidden text-center mb-8">
                    <div class="flex items-center justify-center space-x-3 mb-4">
                        <div class="w-10 h-10 pelefood-gradient rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-gray-900">PeleFood</span>
                    </div>
                </div>
                
                <!-- Titre -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Connexion</h2>
                    <p class="mt-2 text-gray-600">Accédez à votre tableau de bord restaurant</p>
                </div>
                
                <!-- Formulaire -->
                <div class="bg-white py-8 px-6 shadow-2xl rounded-2xl border border-gray-100">
                    @livewire('auth.login-form-working')
                    
                    <!-- Lien vers l'inscription -->
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Vous n'avez pas de compte ? 
                            <a href="{{ route('register') }}" class="font-semibold text-orange-600 hover:text-orange-500 transition-colors">
                                Créer un compte
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @livewireScripts
</body>
</html>
