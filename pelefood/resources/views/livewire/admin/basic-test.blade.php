<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Livewire Basique</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-center mb-8">Test Livewire Basique</h1>
        
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Test de Base</h2>
            <p class="text-gray-600 mb-4">Message: <strong>{{ $message }}</strong></p>
            <p class="text-gray-600 mb-4">Compteur: <strong>{{ $count }}</strong></p>
            
            <button wire:click="increment" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Incrémenter (+1)
            </button>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Diagnostic</h2>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
                <li>Si vous voyez "Hello Livewire!", le composant se charge</li>
                <li>Si le bouton fonctionne, Livewire est opérationnel</li>
                <li>Le compteur devrait augmenter à chaque clic</li>
            </ul>
            
            <div class="mt-4 p-4 bg-gray-100 rounded">
                <p class="text-sm">
                    <strong>État:</strong> Message = "{{ $message }}" | Compteur = {{ $count }}
                </p>
            </div>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
