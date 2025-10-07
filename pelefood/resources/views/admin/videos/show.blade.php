@extends('layouts.super-admin-new-design')

@section('title', 'Lecture de la Vidéo - ' . $video->title)

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
                <h1 class="text-2xl font-bold text-gray-900">{{ $video->title }}</h1>
                <p class="text-gray-600">{{ $video->created_at ? $video->created_at->format('d/m/Y à H:i') : 'Date inconnue' }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.videos.edit', $video->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-edit mr-2"></i> Modifier
            </a>
            <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette vidéo ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <i class="fas fa-trash mr-2"></i> Supprimer
                </button>
            </form>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Lecteur vidéo principal -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Lecteur vidéo</h3>
                
                @if($video->video_url)
                    @if($video->isYouTube())
                        <!-- YouTube Embed -->
                        <div class="aspect-video bg-black rounded-lg overflow-hidden">
                            <iframe 
                                class="w-full h-full"
                                src="{{ $video->getYouTubeEmbedUrl() }}"
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                            </iframe>
                        </div>
                    @elseif($video->isVimeo())
                        <!-- Vimeo Embed -->
                        <div class="aspect-video bg-black rounded-lg overflow-hidden">
                            <iframe 
                                class="w-full h-full"
                                src="https://player.vimeo.com/video/{{ $video->getVimeoId() }}?autoplay=0&title=0&byline=0&portrait=0"
                                frameborder="0" 
                                allow="autoplay; fullscreen; picture-in-picture" 
                                allowfullscreen>
                            </iframe>
                        </div>
                    @else
                        <!-- URL générique -->
                        <div class="aspect-video bg-gradient-to-br from-gray-900 to-gray-800 rounded-lg flex items-center justify-center">
                            <a href="{{ $video->video_url }}" target="_blank" 
                               class="group relative w-24 h-24 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110 shadow-2xl">
                                <i class="fas fa-play text-white text-2xl ml-1 group-hover:scale-110 transition-transform duration-300"></i>
                            </a>
                        </div>
                    @endif
                @elseif($video->video_file)
                    <!-- Fichier vidéo local -->
                    <div class="aspect-video bg-black rounded-lg overflow-hidden">
                        <video 
                            class="w-full h-full object-cover" 
                            controls 
                            preload="metadata"
                            poster="{{ $video->thumbnail ? Storage::url($video->thumbnail) : '' }}">
                            <source src="{{ Storage::url($video->video_file) }}" type="video/mp4">
                            <source src="{{ Storage::url($video->video_file) }}" type="video/webm">
                            <source src="{{ Storage::url($video->video_file) }}" type="video/ogg">
                            <p class="text-white p-4">Votre navigateur ne supporte pas la lecture vidéo. 
                                <a href="{{ Storage::url($video->video_file) }}" class="text-blue-400 hover:text-blue-300 underline" download>Télécharger la vidéo</a>
                            </p>
                        </video>
                    </div>
                @else
                    <!-- Aucune vidéo -->
                    <div class="aspect-video bg-gray-200 rounded-lg flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-video-slash text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">Aucune vidéo disponible</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Informations détaillées -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations détaillées</h3>
                
                <div class="space-y-4">
                    @if($video->description)
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">Description</h4>
                        <p class="text-gray-600">{{ $video->description }}</p>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Durée</h4>
                            <p class="text-gray-600">{{ $video->formatted_duration ?? 'Non spécifiée' }}</p>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Qualité</h4>
                            <p class="text-gray-600">{{ $video->quality ?? 'Non spécifiée' }}</p>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Langue</h4>
                            <p class="text-gray-600">{{ strtoupper($video->language ?? 'Non spécifiée') }}</p>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Ordre d'affichage</h4>
                            <p class="text-gray-600">{{ $video->sort_order ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Statut et actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statut</h3>
                
                <div class="space-y-4">
                    <!-- Statut actif -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="font-medium text-gray-900">Vidéo active</h4>
                            <p class="text-sm text-gray-500">Visible sur la plateforme</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($video->is_active) bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            @if($video->is_active) Actif @else Inactif @endif
                        </span>
                    </div>

                    <!-- Mise en avant -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h4 class="font-medium text-gray-900">Mise en avant</h4>
                            <p class="text-sm text-gray-500">Affichage prioritaire</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($video->is_featured) bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            @if($video->is_featured) En avant @else Normal @endif
                        </span>
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="mt-6 space-y-3">
                    <form action="{{ route('admin.videos.toggle-active', $video->id) }}" method="POST" class="inline w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-toggle-{{ $video->is_active ? 'off' : 'on' }} mr-2"></i>
                            {{ $video->is_active ? 'Désactiver' : 'Activer' }}
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.videos.toggle-featured', $video->id) }}" method="POST" class="inline w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                            <i class="fas fa-star mr-2"></i>
                            {{ $video->is_featured ? 'Retirer de l\'avant' : 'Mettre en avant' }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Métadonnées -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Métadonnées</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID:</span>
                        <span class="font-mono text-sm">{{ $video->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Créé le:</span>
                        <span class="text-sm">{{ $video->created_at ? $video->created_at->format('d/m/Y') : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Modifié le:</span>
                        <span class="text-sm">{{ $video->updated_at ? $video->updated_at->format('d/m/Y') : 'N/A' }}</span>
                    </div>
                    @if($video->metadata)
                    <div class="pt-3 border-t border-gray-200">
                        <h4 class="font-medium text-gray-900 mb-2">Données supplémentaires</h4>
                        <pre class="text-xs text-gray-600 bg-gray-50 p-2 rounded overflow-auto">{{ json_encode($video->metadata, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Liens de téléchargement -->
            @if($video->video_file)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Téléchargement</h3>
                
                <a href="{{ Storage::url($video->video_file) }}" 
                   download 
                   class="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-download mr-2"></i>
                    Télécharger la vidéo
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Script pour améliorer l'expérience utilisateur -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des erreurs de lecture vidéo
    const video = document.querySelector('video');
    if (video) {
        video.addEventListener('error', function(e) {
            console.error('Erreur de lecture vidéo:', e);
            const errorDiv = document.createElement('div');
            errorDiv.className = 'absolute inset-0 bg-red-900 bg-opacity-75 flex items-center justify-center text-white';
            errorDiv.innerHTML = `
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle text-4xl mb-4"></i>
                    <p class="text-lg font-medium">Erreur de lecture</p>
                    <p class="text-sm">Impossible de lire cette vidéo</p>
                </div>
            `;
            video.parentElement.style.position = 'relative';
            video.parentElement.appendChild(errorDiv);
        });

        // Afficher les contrôles de lecture
        video.addEventListener('loadedmetadata', function() {
            console.log('Métadonnées vidéo chargées:', {
                duration: video.duration,
                videoWidth: video.videoWidth,
                videoHeight: video.videoHeight
            });
        });
    }
});
</script>
@endsection
