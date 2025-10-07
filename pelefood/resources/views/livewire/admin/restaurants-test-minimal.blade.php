<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Test Restaurants Minimal</h1>
    
    <div class="mb-4">
        <button wire:click="createRestaurant" class="bg-blue-500 text-white px-4 py-2 rounded">
            Créer Restaurant
        </button>
    </div>

    <div class="bg-white p-4 rounded shadow mb-4">
        <p>Modal ouvert: {{ $showModal ? 'OUI' : 'NON' }}</p>
        <p>Titre: {{ $modalTitle }}</p>
    </div>

    <div class="space-y-2">
        @foreach($restaurants as $restaurant)
        <div class="bg-gray-100 p-2 rounded">
            {{ $restaurant->name }} - {{ $restaurant->email }}
        </div>
        @endforeach
    </div>

    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50" wire:click="closeModal">
        <div class="bg-white p-6 m-4 rounded shadow" wire:click.stop>
            <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Nom</label>
                <input type="text" wire:model="name" class="w-full border rounded px-3 py-2">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Email</label>
                <input type="email" wire:model="email" class="w-full border rounded px-3 py-2">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div class="flex space-x-2">
                <button wire:click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded">
                    Annuler
                </button>
                <button wire:click="saveRestaurant" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Sauvegarder
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
