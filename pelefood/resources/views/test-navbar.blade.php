<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Navbar - PeleFood</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Test de la navbar -->
        <div class="bg-white p-8 rounded-lg shadow-lg m-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Test de la Navbar</h1>
            
            <!-- Informations de connexion -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <h2 class="text-lg font-semibold text-blue-900 mb-2">État de Connexion :</h2>
                @auth
                    <p class="text-green-600">✅ Connecté en tant que : {{ auth()->user()->name }} ({{ auth()->user()->email }})</p>
                    <p class="text-sm text-gray-600">Rôle : {{ auth()->user()->role }}</p>
                @else
                    <p class="text-red-600">❌ Non connecté</p>
                    <p class="text-sm text-gray-600">Le bouton de déconnexion n'apparaît que pour les utilisateurs connectés</p>
                @endauth
            </div>
            
            <!-- Instructions -->
            <div class="mb-6 p-4 bg-yellow-50 rounded-lg">
                <h2 class="text-lg font-semibold text-yellow-900 mb-2">Instructions :</h2>
                <ol class="list-decimal list-inside text-yellow-800 space-y-1">
                    <li>Si vous n'êtes pas connecté, allez sur <a href="{{ route('login') }}" class="text-blue-600 hover:underline">http://127.0.0.1:8000/login</a></li>
                    <li>Connectez-vous avec : admin@pelefood.ci / admin123</li>
                    <li>Retournez sur cette page pour voir le bouton de déconnexion</li>
                    <li>Le bouton apparaît dans la navbar en haut de la page</li>
                </ol>
            </div>
            
            <!-- Liens de test -->
            <div class="space-y-2">
                <a href="{{ route('home') }}" class="block text-blue-600 hover:underline">← Retour à l'accueil</a>
                <a href="{{ route('login') }}" class="block text-blue-600 hover:underline">🔐 Page de connexion</a>
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:underline">🚪 Se déconnecter</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
    
    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
