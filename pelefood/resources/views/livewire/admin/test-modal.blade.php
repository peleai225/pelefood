<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Test Modal Livewire</h1>
    
    <button wire:click="openModal" class="bg-blue-500 text-white px-4 py-2 rounded">
        Ouvrir Modal
    </button>

    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50" wire:click="closeModal">
        <div class="relative top-20 mx-auto p-5 border w-1/2 shadow-lg rounded-md bg-white" wire:click.stop>
            <h3 class="text-lg font-medium mb-4">Modal de Test</h3>
            <p class="mb-4">Ce modal fonctionne !</p>
            <button wire:click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded">
                Fermer
            </button>
        </div>
    </div>
    @endif

    <div class="mt-4">
        <p>État du modal : {{ $showModal ? 'Ouvert' : 'Fermé' }}</p>
    </div>
</div>