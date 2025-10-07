@extends('layouts.super-admin-new-design')

@section('title', 'Modifier la Vidéo - ' . $video->title)

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- En-tête avec navigation -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.videos.index') }}" class="flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour à la liste
            </a>
            <div class="h-6 w-px bg-gray-300"></div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Modifier la vidéo</h1>
                <p class="text-gray-600">{{ $video->title }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.videos.show', $video->id) }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-eye mr-2"></i> Voir
            </a>
        </div>
    </div>

    <!-- Messages d'alerte -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-600 mr-3"></i>
            <p class="text-green-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center mb-3">
            <i class="fas fa-exclamation-triangle text-red-600 mr-3"></i>
            <h3 class="text-red-800 font-medium">Erreurs de validation</h3>
        </div>
        <ul class="list-disc list-inside text-red-700 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Formulaire d'édition -->
    <form action="{{ route('admin.videos.update', $video->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne principale - Informations générales -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Carte Informations de base -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-info-circle text-blue-600"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Informations de base</h2>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Titre -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Titre de la vidéo <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $video->title) }}" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('title') border-red-300 focus:ring-red-500 @enderror"
                                   placeholder="Entrez le titre de votre vidéo">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('description') border-red-300 focus:ring-red-500 @enderror"
                                      placeholder="Décrivez le contenu de votre vidéo...">{{ old('description', $video->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Carte Contenu vidéo -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-play-circle text-green-600"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Contenu vidéo</h2>
                    </div>
                    
                    <!-- Vidéo actuelle -->
                    @if($video->video_url || $video->video_file)
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-medium text-gray-900 mb-3">Vidéo actuelle</h4>
                        @if($video->video_url)
                            <p class="text-sm text-gray-600 mb-2">URL: <a href="{{ $video->video_url }}" target="_blank" class="text-blue-600 hover:text-blue-700">{{ $video->video_url }}</a></p>
                        @endif
                        @if($video->video_file)
                            <p class="text-sm text-gray-600 mb-2">Fichier: <a href="{{ Storage::url($video->video_file) }}" target="_blank" class="text-blue-600 hover:text-blue-700">{{ basename($video->video_file) }}</a></p>
                        @endif
                    </div>
                    @endif
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- URL de la vidéo -->
                        <div>
                            <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">
                                Nouvelle URL de vidéo
                            </label>
                            <input type="url" 
                                   id="video_url" 
                                   name="video_url" 
                                   value="{{ old('video_url') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('video_url') border-red-300 focus:ring-red-500 @enderror"
                                   placeholder="https://www.youtube.com/watch?v=...">
                            @error('video_url')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">Laissez vide si vous uploadez un fichier</p>
                        </div>

                        <!-- Fichier vidéo -->
                        <div>
                            <label for="video_file" class="block text-sm font-medium text-gray-700 mb-2">
                                Nouveau fichier vidéo
                            </label>
                            <div class="relative">
                                <input type="file" 
                                       id="video_file" 
                                       name="video_file" 
                                       accept="video/*"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('video_file') border-red-300 focus:ring-red-500 @enderror">
                            </div>
                            @error('video_file')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">Max 100MB. Formats: MP4, AVI, MOV, WMV, FLV, WebM</p>
                        </div>
                    </div>

                    <!-- Miniature -->
                    <div class="mt-6">
                        <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">
                            Nouvelle miniature
                        </label>
                        @if($video->thumbnail)
                        <div class="mb-3">
                            <p class="text-sm text-gray-600 mb-2">Miniature actuelle:</p>
                            <img src="{{ Storage::url($video->thumbnail) }}" alt="Miniature actuelle" class="w-32 h-20 object-cover rounded-lg">
                        </div>
                        @endif
                        <div class="relative">
                            <input type="file" 
                                   id="thumbnail" 
                                   name="thumbnail" 
                                   accept="image/*"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('thumbnail') border-red-300 focus:ring-red-500 @enderror">
                        </div>
                        @error('thumbnail')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">Max 2MB. Formats: JPEG, PNG, JPG, GIF</p>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar - Paramètres -->
            <div class="space-y-6">
                <!-- Carte Paramètres de publication -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-cog text-orange-600"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Paramètres</h2>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Durée -->
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                                Durée (secondes)
                            </label>
                            <input type="number" 
                                   id="duration" 
                                   name="duration" 
                                   value="{{ old('duration', $video->duration) }}" 
                                   min="1"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('duration') border-red-300 focus:ring-red-500 @enderror"
                                   placeholder="120">
                            @error('duration')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Qualité -->
                        <div>
                            <label for="quality" class="block text-sm font-medium text-gray-700 mb-2">
                                Qualité <span class="text-red-500">*</span>
                            </label>
                            <select id="quality" 
                                    name="quality" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('quality') border-red-300 focus:ring-red-500 @enderror">
                                <option value="">Sélectionner une qualité...</option>
                                <option value="SD" {{ old('quality', $video->quality) == 'SD' ? 'selected' : '' }}>SD (480p)</option>
                                <option value="HD" {{ old('quality', $video->quality) == 'HD' ? 'selected' : '' }}>HD (720p)</option>
                                <option value="Full HD" {{ old('quality', $video->quality) == 'Full HD' ? 'selected' : '' }}>Full HD (1080p)</option>
                                <option value="4K" {{ old('quality', $video->quality) == '4K' ? 'selected' : '' }}>4K (2160p)</option>
                            </select>
                            @error('quality')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Langue -->
                        <div>
                            <label for="language" class="block text-sm font-medium text-gray-700 mb-2">
                                Langue <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="language" 
                                   name="language" 
                                   value="{{ old('language', $video->language) }}" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('language') border-red-300 focus:ring-red-500 @enderror"
                                   placeholder="fr">
                            @error('language')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ordre d'affichage -->
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                                Ordre d'affichage
                            </label>
                            <input type="number" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', $video->sort_order) }}" 
                                   min="0"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('sort_order') border-red-300 focus:ring-red-500 @enderror"
                                   placeholder="0">
                            @error('sort_order')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Carte Statut -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-toggle-on text-purple-600"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Statut</h2>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Vidéo active -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <h3 class="font-medium text-gray-900">Vidéo active</h3>
                                <p class="text-sm text-gray-500">La vidéo sera visible sur la plateforme</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       {{ old('is_active', $video->is_active) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <!-- Mise en avant -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <h3 class="font-medium text-gray-900">Mise en avant</h3>
                                <p class="text-sm text-gray-500">Afficher cette vidéo en priorité</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       id="is_featured" 
                                       name="is_featured" 
                                       {{ old('is_featured', $video->is_featured) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="space-y-4">
                        <button type="submit" class="w-full flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save mr-2"></i>
                            Mettre à jour la vidéo
                        </button>
                        
                        <a href="{{ route('admin.videos.show', $video->id) }}" class="w-full flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                            <i class="fas fa-eye mr-2"></i>
                            Voir la vidéo
                        </a>
                        
                        <a href="{{ route('admin.videos.index') }}" class="w-full flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Script pour améliorer l'expérience utilisateur -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Aperçu des fichiers sélectionnés
    const videoFileInput = document.getElementById('video_file');
    const thumbnailInput = document.getElementById('thumbnail');
    
    // Aperçu de la miniature
    thumbnailInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Créer ou mettre à jour l'aperçu
                let preview = document.getElementById('thumbnail-preview');
                if (!preview) {
                    preview = document.createElement('div');
                    preview.id = 'thumbnail-preview';
                    preview.className = 'mt-4 p-4 border-2 border-dashed border-gray-300 rounded-lg text-center';
                    thumbnailInput.parentNode.appendChild(preview);
                }
                preview.innerHTML = `
                    <img src="${e.target.result}" class="max-w-full h-32 object-cover rounded-lg mx-auto mb-2" alt="Aperçu de la miniature">
                    <p class="text-sm text-gray-600">Aperçu de la nouvelle miniature</p>
                `;
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Validation en temps réel
    const form = document.querySelector('form');
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.add('border-red-300');
                this.classList.remove('border-gray-300');
            } else {
                this.classList.remove('border-red-300');
                this.classList.add('border-gray-300');
            }
        });
    });
});
</script>
@endsection
