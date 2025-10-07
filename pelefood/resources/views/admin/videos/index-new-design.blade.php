@extends('layouts.super-admin-new-design')

@section('title', 'Gestion des Vidéos - PeleFood')
@section('description', 'Gérez les vidéos de vos restaurants')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Vidéos</h1>
            <p class="mt-2 text-lg text-gray-600">Gérez les vidéos de vos restaurants et analysez leurs performances</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="uploadVideo()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-upload mr-2"></i> Nouvelle Vidéo
            </button>
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

    <!-- Actions rapides -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions Rapides</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <button onclick="uploadVideo()" class="flex items-center justify-center p-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-upload mr-2"></i>
                Uploader Vidéo
            </button>
            <button onclick="bulkEdit()" class="flex items-center justify-center p-4 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-edit mr-2"></i>
                Édition en Lot
            </button>
            <button onclick="videoAnalytics()" class="flex items-center justify-center p-4 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-chart-bar mr-2"></i>
                Analytics Vidéo
            </button>
            <button onclick="videoSettings()" class="flex items-center justify-center p-4 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                <i class="fas fa-cog mr-2"></i>
                Paramètres
            </button>
        </div>
    </div>

    <!-- Vidéos récentes -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Vidéos Récentes</h3>
            <a href="{{ route('admin.videos.all') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                Voir toutes →
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($recentVideos ?? [] as $video)
            <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="aspect-video bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                    @if($video->thumbnail_url)
                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover rounded-lg">
                    @else
                        <i class="fas fa-play-circle text-gray-400 text-4xl"></i>
                    @endif
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 mb-1">{{ $video->title ?? 'Titre de la vidéo' }}</h4>
                    <p class="text-sm text-gray-500 mb-2">
                        {{ $video->restaurant->name ?? 'Restaurant' }} - 
                        {{ $video->created_at ? $video->created_at->diffForHumans() : 'Récemment' }}
                    </p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>{{ number_format($video->views_count ?? 0, 0, ',', ' ') }} vues</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            @if(($video->status ?? 'draft') === 'published') bg-green-100 text-green-800
                            @elseif(($video->status ?? 'draft') === 'draft') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($video->status ?? 'draft') }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-8">
                <i class="fas fa-video text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500">Aucune vidéo récente</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Vidéos populaires -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Vidéos Populaires</h3>
            <a href="{{ route('admin.videos.popular') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                Voir toutes →
            </a>
        </div>
        
        <div class="space-y-4">
            @forelse($popularVideos ?? [] as $index => $video)
            <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg hover:border-gray-300 transition-colors">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                        @if($video->thumbnail_url)
                            <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover rounded-lg">
                        @else
                            <i class="fas fa-play text-gray-400"></i>
                        @endif
                    </div>
                </div>
                <div class="flex-1">
                    <h4 class="font-medium text-gray-900">{{ $video->title ?? 'Titre de la vidéo' }}</h4>
                    <p class="text-sm text-gray-500">
                        {{ $video->restaurant->name ?? 'Restaurant' }} - 
                        {{ number_format($video->views_count ?? 0, 0, ',', ' ') }} vues - 
                        {{ $video->created_at ? $video->created_at->format('d/m/Y') : 'Date inconnue' }}
                    </p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-center">
                        <div class="text-lg font-bold text-gray-900">{{ number_format($video->views_count ?? 0, 0, ',', ' ') }}</div>
                        <div class="text-xs text-gray-500">vues</div>
                    </div>
                    <div class="text-center">
                        <div class="text-lg font-bold text-red-600">{{ number_format($video->likes_count ?? 0, 0, ',', ' ') }}</div>
                        <div class="text-xs text-gray-500">likes</div>
                    </div>
                    <button onclick="viewVideo({{ $video->id ?? 0 }})" class="text-blue-600 hover:text-blue-700">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <i class="fas fa-fire text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500">Aucune vidéo populaire</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Répartition par catégorie -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Répartition par Catégorie</h3>
            <div class="space-y-3">
                @forelse($videosByCategory ?? [] as $category => $count)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">{{ ucfirst($category) }}</span>
                    <span class="font-semibold text-gray-900">{{ $count }}</span>
                </div>
                @empty
                <p class="text-gray-500 text-sm">Aucune donnée de catégorie disponible</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Métriques de Performance</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Taux d'engagement</span>
                    <span class="font-semibold text-gray-900">{{ number_format($performanceStats['avg_engagement_rate'] ?? 0, 1) }}%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Uploads (30j)</span>
                    <span class="font-semibold text-gray-900">{{ $performanceStats['upload_rate'] ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Taux de publication</span>
                    <span class="font-semibold text-gray-900">{{ number_format($performanceStats['completion_rate'] ?? 0, 1) }}%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function uploadVideo() {
    // Logique pour uploader une nouvelle vidéo
    window.location.href = "{{ route('admin.videos.create') }}";
}

function bulkEdit() {
    // Logique pour l'édition en lot
    alert('Fonctionnalité d\'édition en lot à implémenter');
}

function videoAnalytics() {
    // Logique pour les analytics vidéo
    window.location.href = "{{ route('admin.videos.analytics') }}";
}

function videoSettings() {
    // Logique pour les paramètres vidéo
    window.location.href = "{{ route('admin.videos.settings') }}";
}

function viewVideo(videoId) {
    // Logique pour voir une vidéo
    window.location.href = "/admin/videos/" + videoId;
}

function exportVideoData() {
    // Logique pour exporter les données vidéo
    window.location.href = "{{ route('admin.videos.export') }}";
}
</script>
@endsection
