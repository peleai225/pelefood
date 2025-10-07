<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Test Ultra Simple</h1>
    
    <div class="bg-white p-4 rounded shadow mb-4">
        <p>Message: {{ $message }}</p>
        <p>Modal ouvert: {{ $showModal ? 'OUI' : 'NON' }}</p>
        
        <button wire:click="openModal" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">
            Ouvrir Modal
        </button>
    </div>

    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50" wire:click="closeModal">
        <div class="bg-white p-6 m-4 rounded shadow" wire:click.stop>
            <h2 class="text-xl font-bold mb-4">Modal de Test</h2>
            <p class="mb-4">Ce modal fonctionne !</p>
            <button wire:click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded">
                Fermer
            </button>
        </div>
    </div>
    @endif
</div>
