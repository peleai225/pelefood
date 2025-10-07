<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'PeleFood SaaS') - Gestion de Restaurants</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.css">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/saas-modern.css') }}">
    @stack('styles')
    
    <!-- Meta -->
    <meta name="description" content="@yield('description', 'PeleFood SaaS - Plateforme de gestion complète pour restaurants')">
    <meta name="keywords" content="restaurant, gestion, commandes, menu, facturation, saas">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>
<body class="h-full bg-gray-50">
    <div id="app" class="min-h-full">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        // Initialiser les icônes Lucide
        lucide.createIcons();
        
        // Configuration globale
        window.PeleFood = {
            csrfToken: '{{ csrf_token() }}',
            baseUrl: '{{ url("/") }}',
            user: @json(auth()->user()),
            locale: '{{ app()->getLocale() }}'
        };
    </script>
    
    @stack('scripts')
</body>
</html>
