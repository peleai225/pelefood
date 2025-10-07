<!-- Tableau moderne et interactif -->
<div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
    <!-- Header du tableau -->
    <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-slate-800">{{ $title ?? 'Données' }}</h3>
                <p class="text-sm text-slate-600">{{ $subtitle ?? 'Liste des éléments' }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <!-- Recherche -->
                <div class="relative">
                    <input type="text" 
                           placeholder="Rechercher..." 
                           class="pl-10 pr-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                           id="searchInput">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                </div>
                
                <!-- Filtres -->
                <button class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors duration-200">
                    <i class="fas fa-filter mr-2"></i>
                    Filtres
                </button>
                
                <!-- Actions -->
                <div class="relative">
                    <button onclick="toggleActionsMenu()" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors duration-200">
                        <i class="fas fa-ellipsis-v mr-2"></i>
                        Actions
                    </button>
                    <!-- Menu des actions (à implémenter) -->
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu du tableau -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    @foreach($headers as $header)
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <span>{{ $header['label'] }}</span>
                            @if(isset($header['sortable']) && $header['sortable'])
                                <button class="text-slate-400 hover:text-slate-600 transition-colors duration-200">
                                    <i class="fas fa-sort text-xs"></i>
                                </button>
                            @endif
                        </div>
                    </th>
                    @endforeach
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($data as $item)
                <tr class="hover:bg-slate-50 transition-colors duration-200">
                    @foreach($headers as $header)
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if(isset($header['type']))
                            @switch($header['type'])
                                @case('badge')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item[$header['key']]['class'] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $item[$header['key']]['text'] ?? $item[$header['key']] }}
                                    </span>
                                    @break
                                @case('avatar')
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                            <span class="text-white text-sm font-semibold">
                                                {{ substr($item[$header['key']], 0, 1) }}
                                            </span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-slate-900">{{ $item[$header['key']] }}</div>
                                        </div>
                                    </div>
                                    @break
                                @case('currency')
                                    <div class="text-sm font-medium text-slate-900">
                                        {{ number_format($item[$header['key']], 0, ',', ' ') }} FCFA
                                    </div>
                                    @break
                                @case('date')
                                    <div class="text-sm text-slate-900">
                                        {{ \Carbon\Carbon::parse($item[$header['key']])->format('d/m/Y') }}
                                    </div>
                                    <div class="text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($item[$header['key']])->format('H:i') }}
                                    </div>
                                    @break
                                @default
                                    <div class="text-sm text-slate-900">{{ $item[$header['key']] ?? 'N/A' }}</div>
                            @endswitch
                        @else
                            <div class="text-sm text-slate-900">{{ $item[$header['key']] ?? 'N/A' }}</div>
                        @endif
                    </td>
                    @endforeach
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            <button class="text-blue-600 hover:text-blue-900 transition-colors duration-200" title="Voir">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-green-600 hover:text-green-900 transition-colors duration-200" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-900 transition-colors duration-200" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($headers) + 1 }}" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-inbox text-slate-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-slate-900 mb-2">Aucune donnée</h3>
                            <p class="text-slate-500">Il n'y a actuellement aucune donnée à afficher.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(isset($pagination) && $pagination)
    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
        <div class="flex items-center justify-between">
            <div class="text-sm text-slate-700">
                Affichage de <span class="font-medium">1</span> à <span class="font-medium">10</span> sur <span class="font-medium">100</span> résultats
            </div>
            <div class="flex items-center space-x-2">
                <button class="px-3 py-2 text-sm font-medium text-slate-500 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-200">
                    Précédent
                </button>
                <button class="px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    1
                </button>
                <button class="px-3 py-2 text-sm font-medium text-slate-500 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-200">
                    2
                </button>
                <button class="px-3 py-2 text-sm font-medium text-slate-500 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-200">
                    3
                </button>
                <button class="px-3 py-2 text-sm font-medium text-slate-500 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-200">
                    Suivant
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
function toggleActionsMenu() {
    // Implémentation du menu des actions
    console.log('Toggle actions menu');
}

// Fonction de recherche
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Animation d'entrée pour les lignes
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(10px)';
        setTimeout(() => {
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 50);
    });
});
</script>
