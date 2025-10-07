<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Test Simple Livewire</h1>
    
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Test de base</h2>
        <p class="text-gray-600 mb-4">{{ $message }}</p>
        <p class="text-gray-600 mb-4">Compteur : {{ $count }}</p>
        
        <button wire:click="increment" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Incrémenter (+1)
        </button>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Instructions</h2>
        <ol class="list-decimal list-inside space-y-2 text-gray-600">
            <li>Si vous voyez ce texte, la page se charge</li>
            <li>Si vous voyez "Livewire fonctionne !", le composant Livewire se charge</li>
            <li>Si le bouton "Incrémenter" fonctionne, Livewire est opérationnel</li>
            <li>Le compteur devrait augmenter à chaque clic</li>
        </ol>
        
        <div class="mt-4 p-4 bg-gray-100 rounded">
            <p class="text-sm text-gray-700">
                <strong>État actuel :</strong><br>
                - Message : {{ $message }}<br>
                - Compteur : {{ $count }}<br>
                - Timestamp : {{ now() }}
            </p>
        </div>
    </div>
</div>
