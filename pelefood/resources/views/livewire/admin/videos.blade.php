<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Vidéos</h1>
            <p class="text-gray-600 mt-2">Gérez vos vidéos avec des fonctionnalités interactives</p>
        </div>
        <button wire:click="createVideo" 
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Nouvelle vidéo
        </button>
    </div>

    <!-- Statistiques des vidéos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-video text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Vidéos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_videos'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-eye text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Vues</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_views'] ?? 0, 0, ',', ' ') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-heart text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Likes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_likes'] ?? 0, 0, ',', ' ') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-orange-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Durée moyenne</p>
                    <p class="text-2xl font-bold text-gray-900">{{ gmdate('i:s', $stats['avg_duration'] ?? 0) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <!-- Recherche -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input wire:model.debounce.300ms="search" 
                           type="text" 
                           placeholder="Rechercher des vidéos..."
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Filtres -->
            <div class="flex items-center space-x-4">
                <select wire:model="filter" 
                        class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">Tous les statuts</option>
                    <option value="active">Publiées</option>
                    <option value="inactive">Brouillons</option>
                </select>

                <select wire:model="perPage" 
                        class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="12">12 par page</option>
                    <option value="24">24 par page</option>
                    <option value="48">48 par page</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Liste des vidéos -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        @if($videos->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @foreach($videos as $video)
                <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <!-- Miniature -->
                    <div class="aspect-video bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                        @if($video->thumbnail)
                            <img src="{{ Storage::url($video->thumbnail) }}" 
                                 alt="{{ $video->title }}" 
                                 class="w-full h-full object-cover rounded-lg"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-full h-full flex items-center justify-center" style="display: none;">
                                <i class="fas fa-play-circle text-gray-400 text-4xl"></i>
                            </div>
                        @else
                            <i class="fas fa-play-circle text-gray-400 text-4xl"></i>
                        @endif
                    </div>

                    <!-- Informations -->
                    <div>
                        <h4 class="font-medium text-gray-900 mb-1">{{ $video->title }}</h4>
                        <p class="text-sm text-gray-500 mb-2">
                            {{ $video->created_at->diffForHumans() }}
                        </p>
                        
                        <!-- Statistiques -->
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                            <span>{{ number_format($video->metadata['views'] ?? 0, 0, ',', ' ') }} vues</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                @if($video->is_active) bg-green-100 text-green-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ $video->is_active ? 'Publié' : 'Brouillon' }}
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <button wire:click="toggleActive({{ $video->id }})" 
                                        class="text-blue-600 hover:text-blue-700"
                                        title="{{ $video->is_active ? 'Désactiver' : 'Activer' }}">
                                    <i class="fas fa-{{ $video->is_active ? 'pause' : 'play' }}"></i>
                                </button>
                                
                                <button wire:click="editVideo({{ $video->id }})" 
                                        class="text-green-600 hover:text-green-700"
                                        title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                <button wire:click="deleteVideo({{ $video->id }})" 
                                        wire:confirm="Êtes-vous sûr de vouloir supprimer cette vidéo ?"
                                        class="text-red-600 hover:text-red-700"
                                        title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            @if($video->is_featured)
                                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">
                                    <i class="fas fa-star mr-1"></i>Vedette
                                </span>
                            @endif
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex items-center justify-between mt-4">
                            <div class="flex items-center space-x-2">
                                <button wire:click="editVideo({{ $video->id }})" 
                                        class="text-green-600 hover:text-green-700 p-1"
                                        title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                <button wire:click="toggleActive({{ $video->id }})" 
                                        class="text-blue-600 hover:text-blue-700 p-1"
                                        title="{{ $video->is_active ? 'Désactiver' : 'Activer' }}">
                                    <i class="fas fa-{{ $video->is_active ? 'pause' : 'play' }}"></i>
                                </button>
                                
                                <button wire:click="toggleFeatured({{ $video->id }})" 
                                        class="text-yellow-600 hover:text-yellow-700 p-1"
                                        title="{{ $video->is_featured ? 'Retirer des vedettes' : 'Mettre en vedette' }}">
                                    <i class="fas fa-star"></i>
                                </button>
                                
                                <button wire:click="deleteVideo({{ $video->id }})" 
                                        wire:confirm="Êtes-vous sûr de vouloir supprimer cette vidéo ?"
                                        class="text-red-600 hover:text-red-700 p-1"
                                        title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $videos->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-video text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune vidéo trouvée</h3>
                <p class="text-gray-500 mb-6">Commencez par créer votre première vidéo</p>
                <button wire:click="createVideo" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Créer une vidéo
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Modal de création/édition -->
@if($showModal)
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeModal">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white" wire:click.stop>
        <!-- En-tête du modal -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">{{ $modalTitle }}</h3>
            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Contenu du modal -->
        <form wire:submit.prevent="saveVideo">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Titre -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Titre *</label>
                    <input wire:model="title" 
                           type="text" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Titre de la vidéo">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea wire:model="description" 
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Description de la vidéo"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- URL de la vidéo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">URL de la vidéo</label>
                    <input wire:model="video_url" 
                           type="url" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="https://youtube.com/watch?v=...">
                    @error('video_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Durée -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Durée (secondes)</label>
                    <input wire:model="duration" 
                           type="number" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="120">
                    @error('duration') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Qualité -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Qualité *</label>
                    <select wire:model="quality" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="SD">SD</option>
                        <option value="HD">HD</option>
                        <option value="FHD">FHD</option>
                        <option value="4K">4K</option>
                    </select>
                    @error('quality') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Langue -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Langue *</label>
                    <select wire:model="language" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="fr">Français</option>
                        <option value="en">Anglais</option>
                        <option value="es">Espagnol</option>
                    </select>
                    @error('language') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Fichier vidéo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fichier vidéo</label>
                    <input wire:model="video_file" 
                           type="file" 
                           accept="video/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('video_file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Miniature -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Miniature</label>
                    <input wire:model="thumbnail" 
                           type="file" 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('thumbnail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Options -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-6">
                        <label class="flex items-center">
                            <input wire:model="is_active" 
                                   type="checkbox" 
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Publié</span>
                        </label>

                        <label class="flex items-center">
                            <input wire:model="is_featured" 
                                   type="checkbox" 
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Vidéo vedette</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Boutons du modal -->
            <div class="flex items-center justify-end space-x-4 mt-6 pt-6 border-t border-gray-200">
                <button type="button" 
                        wire:click="closeModal"
                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    {{ $editingVideo ? 'Mettre à jour' : 'Créer' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@push('scripts')
<script>
// Notification système pour Livewire
window.addEventListener('showNotification', event => {
    // Créer une notification toast
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
    notification.textContent = event.detail.message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
});
</script>
@endpush