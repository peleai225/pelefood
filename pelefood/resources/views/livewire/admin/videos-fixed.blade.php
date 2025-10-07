<div class="max-w-7xl mx-auto space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Vidéos</h1>
            <p class="text-gray-600 mt-2">Gérez toutes les vidéos de votre plateforme SaaS</p>
        </div>
        <button wire:click="createVideo" 
                class="btn-modern flex items-center space-x-2">
            <i class="fas fa-plus"></i>
            <span>Nouvelle vidéo</span>
        </button>
    </div>

    <!-- Messages -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filtres et recherche -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <!-- Barre de recherche -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text" 
                           wire:model.debounce.300ms="search"
                           placeholder="Rechercher une vidéo..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <!-- Filtres -->
            <div class="flex items-center space-x-4">
                <select wire:model="filter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="all">Toutes</option>
                    <option value="active">Actives</option>
                    <option value="inactive">Inactives</option>
                    <option value="featured">En vedette</option>
                </select>
                
                <select wire:model="perPage" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="12">12 par page</option>
                    <option value="24">24 par page</option>
                    <option value="48">48 par page</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Liste des vidéos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($videos as $video)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <!-- En-tête de la carte -->
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $video->title }}</h3>
                    <p class="text-sm text-gray-600">{{ $video->quality }} - {{ $video->language }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    @if($video->is_featured)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-star mr-1"></i>
                            Vedette
                        </span>
                    @endif
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $video->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $video->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>

            <!-- Informations de la vidéo -->
            <div class="space-y-2 mb-4">
                @if($video->description)
                <div class="text-sm text-gray-600">
                    <p>{{ Str::limit($video->description, 100) }}</p>
                </div>
                @endif
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-clock mr-2 text-gray-400"></i>
                    <span>{{ $video->duration }} minutes</span>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-calendar mr-2 text-gray-400"></i>
                    <span>Créée le {{ $video->created_at->format('d/m/Y') }}</span>
                </div>
                @if($video->video_url)
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-link mr-2 text-gray-400"></i>
                    <span>URL externe</span>
                </div>
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
        @empty
        <div class="col-span-full bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <i class="fas fa-video text-gray-400 text-4xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune vidéo trouvée</h3>
            <p class="text-gray-600 mb-4">Commencez par créer votre première vidéo.</p>
            <button wire:click="createVideo" 
                    class="btn-modern px-4 py-2 rounded-lg">
                <i class="fas fa-plus mr-2"></i>
                Créer une vidéo
            </button>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $videos->links() }}
    </div>

    <!-- Modal pour créer/éditer une vidéo -->
    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4" wire:click="closeModal">
        <div class="modal-modern relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl transform transition-all duration-300 scale-100" wire:click.stop>
            <!-- En-tête du modal -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">{{ $modalTitle }}</h3>
                <button wire:click="closeModal" class="modal-close-btn">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Formulaire -->
            <form wire:submit.prevent="saveVideo">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Titre -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Titre de la vidéo *</label>
                        <input type="text" 
                               id="title"
                               wire:model="title"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea id="description"
                                  wire:model="description"
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- URL vidéo -->
                    <div class="md:col-span-2">
                        <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">URL de la vidéo (YouTube, Vimeo, etc.)</label>
                        <input type="url" 
                               id="video_url"
                               wire:model="video_url"
                               placeholder="https://www.youtube.com/watch?v=..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('video_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Fichier vidéo -->
                    <div class="md:col-span-2">
                        <label for="video_file" class="block text-sm font-medium text-gray-700 mb-2">Ou télécharger un fichier vidéo</label>
                        <input type="file" 
                               id="video_file"
                               wire:model="video_file"
                               accept="video/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('video_file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Miniature -->
                    <div>
                        <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">Miniature</label>
                        <input type="file" 
                               id="thumbnail"
                               wire:model="thumbnail"
                               accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('thumbnail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Durée -->
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">Durée (minutes)</label>
                        <input type="number" 
                               id="duration"
                               wire:model="duration"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('duration') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Qualité -->
                    <div>
                        <label for="quality" class="block text-sm font-medium text-gray-700 mb-2">Qualité *</label>
                        <select id="quality"
                                wire:model="quality"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="SD">SD (480p)</option>
                            <option value="HD">HD (720p)</option>
                            <option value="FHD">FHD (1080p)</option>
                            <option value="4K">4K (2160p)</option>
                        </select>
                        @error('quality') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Langue -->
                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700 mb-2">Langue *</label>
                        <select id="language"
                                wire:model="language"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="fr">Français</option>
                            <option value="en">English</option>
                            <option value="es">Español</option>
                            <option value="de">Deutsch</option>
                        </select>
                        @error('language') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Ordre de tri -->
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Ordre de tri</label>
                        <input type="number" 
                               id="sort_order"
                               wire:model="sort_order"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('sort_order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Options -->
                    <div class="md:col-span-2">
                        <div class="flex items-center space-x-6">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       wire:model="is_active"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Vidéo active</span>
                            </label>
                            
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       wire:model="is_featured"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Mettre en vedette</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            wire:click="closeModal"
                            class="modal-cancel-btn">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="btn-modern font-bold py-2 px-4 rounded">
                        {{ $editingVideo ? 'Modifier' : 'Créer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
