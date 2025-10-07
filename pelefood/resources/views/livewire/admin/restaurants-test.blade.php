<div class="max-w-7xl mx-auto space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Test Modal Restaurants</h1>
            <p class="text-gray-600 mt-2">Test simple pour vérifier le modal</p>
        </div>
        <button wire:click="createRestaurant" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Test Modal Livewire
        </button>
        <button onclick="testModal()" 
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg ml-4">
            Test Modal JavaScript
        </button>
    </div>

    <!-- Message de debug -->
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
        <p><strong>Debug Livewire:</strong> {{ $message }}</p>
        <p><strong>showModal:</strong> {{ $showModal ? 'true' : 'false' }}</p>
    </div>

    <!-- Modal Livewire -->
    @if($showModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Test Modal Livewire</h3>
            <p class="mb-4">Ce modal fonctionne avec Livewire !</p>
            <button wire:click="closeModal" 
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Fermer
            </button>
        </div>
    </div>
    @endif

    <!-- Modal JavaScript -->
    <div id="jsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Test Modal JavaScript</h3>
            <p class="mb-4">Ce modal fonctionne avec JavaScript !</p>
            <button onclick="closeModal()" 
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Fermer
            </button>
        </div>
    </div>

    <script>
        function testModal() {
            document.getElementById('jsModal').classList.remove('hidden');
        }
        
        function closeModal() {
            document.getElementById('jsModal').classList.add('hidden');
        }
    </script>
</div>