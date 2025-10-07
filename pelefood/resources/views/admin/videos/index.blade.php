@extends('layouts.super-admin-new-design')

@section('title', 'Gestion des Vidéos')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Vidéos</h1>
            <p class="mt-2 text-lg text-gray-600">Gérez les vidéos de vos restaurants et analysez leurs performances</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.videos.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i> Nouvelle Vidéo
            </a>
            <button onclick="exportVideoData()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-download mr-2"></i> Exporter
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-600 mr-3"></i>
            <p class="text-green-800">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-600 mr-3"></i>
            <p class="text-red-800">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    @if(session('warning'))
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle text-yellow-600 mr-3"></i>
            <p class="text-yellow-800">{{ session('warning') }}</p>
        </div>
    </div>
    @endif

    @if(session('info'))
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-center">
            <i class="fas fa-info-circle text-blue-600 mr-3"></i>
            <p class="text-blue-800">{{ session('info') }}</p>
        </div>
    </div>
    @endif

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
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-heart text-red-600 text-xl"></i>
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
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Durée Moyenne</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['avg_duration'] ?? 0, 1) }}min</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des vidéos -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Toutes les Vidéos</h3>
            <div class="flex items-center space-x-2">
                <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Tous les statuts</option>
                    <option>Publiées</option>
                    <option>Brouillons</option>
                </select>
                <button class="px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($recentVideos ?? [] as $video)
            <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="aspect-video bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                    @if($video->thumbnail && $video->thumbnail !== '')
                        <img src="{{ Storage::url($video->thumbnail) }}" alt="{{ $video->title ?? 'Vidéo' }}" class="w-full h-full object-cover rounded-lg" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="w-full h-full flex items-center justify-center" style="display: none;">
                            <i class="fas fa-play-circle text-gray-400 text-4xl"></i>
                        </div>
                    @else
                        <i class="fas fa-play-circle text-gray-400 text-4xl"></i>
                    @endif
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 mb-1">{{ $video->title ?? 'Titre de la vidéo' }}</h4>
                    <p class="text-sm text-gray-500 mb-2">
                        {{ $video->created_at ? $video->created_at->diffForHumans() : 'Récemment' }}
                    </p>
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                        <span>{{ number_format($video->metadata['views'] ?? 0, 0, ',', ' ') }} vues</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            @if($video->is_active ?? false) bg-green-100 text-green-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ($video->is_active ?? false) ? 'Publié' : 'Brouillon' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.videos.show', $video->id ?? 0) }}" class="text-blue-600 hover:text-blue-700">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.videos.edit', $video->id ?? 0) }}" class="text-green-600 hover:text-green-700">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.videos.destroy', $video->id ?? 0) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette vidéo ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        <span class="text-xs text-gray-400">{{ $video->duration ?? '0' }}min</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="flex flex-col items-center">
                    <i class="fas fa-video text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune vidéo trouvée</h3>
                    <p class="text-gray-500 mb-4">Commencez par ajouter votre première vidéo</p>
                    <a href="{{ route('admin.videos.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i> Ajouter une vidéo
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <script>
function exportVideoData() {
    // Logique pour exporter les données vidéo
    alert('Fonctionnalité d\'export en cours de développement');
}
    </script>
</div>
@endsection
