@extends('layouts.restaurant')

@section('title', 'Historique d\'activité - ' . $user->name)
@section('page-title', 'Historique d\'activité')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Historique d'activité</h1>
                <p class="text-gray-600 mt-1">Consultez l'historique de vos connexions et activités</p>
            </div>
            <a href="{{ route('profile.show') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <!-- Navigation -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6">
                <a href="{{ route('profile.show') }}" 
                   class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <i class="fas fa-user mr-2"></i>
                    Informations
                </a>
                <a href="{{ route('profile.edit') }}" 
                   class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <i class="fas fa-edit mr-2"></i>
                    Modifier
                </a>
                <a href="{{ route('profile.change-password') }}" 
                   class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <i class="fas fa-lock mr-2"></i>
                    Mot de passe
                </a>
                <a href="{{ route('profile.security') }}" 
                   class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    <i class="fas fa-shield-alt mr-2"></i>
                    Sécurité
                </a>
                <a href="{{ route('profile.activity') }}" 
                   class="border-b-2 border-orange-500 py-4 px-1 text-sm font-medium text-orange-600">
                    <i class="fas fa-history mr-2"></i>
                    Activité
                </a>
            </nav>
        </div>

        <div class="p-6">
            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-sign-in-alt text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-blue-600">Connexions totales</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $activities->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-calendar-day text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-green-600">Aujourd'hui</p>
                            <p class="text-2xl font-bold text-green-900">{{ $activities->where('created_at', '>=', now()->startOfDay())->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-calendar-week text-yellow-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-yellow-600">Cette semaine</p>
                            <p class="text-2xl font-bold text-yellow-900">{{ $activities->where('created_at', '>=', now()->startOfWeek())->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-clock text-purple-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-purple-600">Dernière activité</p>
                            <p class="text-sm font-bold text-purple-900">{{ $user->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtres -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="flex flex-wrap items-center space-x-4">
                    <div>
                        <label for="activity_type" class="block text-sm font-medium text-gray-700 mb-1">Type d'activité</label>
                        <select id="activity_type" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Tous les types</option>
                            <option value="login">Connexions</option>
                            <option value="profile_update">Modifications de profil</option>
                            <option value="password_change">Changements de mot de passe</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="date_range" class="block text-sm font-medium text-gray-700 mb-1">Période</label>
                        <select id="date_range" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="7">7 derniers jours</option>
                            <option value="30" selected>30 derniers jours</option>
                            <option value="90">3 derniers mois</option>
                            <option value="365">1 an</option>
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <button class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors">
                            <i class="fas fa-filter mr-2"></i>
                            Filtrer
                        </button>
                    </div>
                </div>
            </div>

            <!-- Liste des activités -->
            <div class="space-y-4">
                @if($activities->count() > 0)
                    @foreach($activities as $activity)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-sign-in-alt text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Connexion réussie</h4>
                                    <p class="text-sm text-gray-600">{{ $activity->ip_address ?? 'IP inconnue' }} - {{ $activity->user_agent ?? 'Appareil inconnu' }}</p>
                                    <p class="text-xs text-gray-500">{{ $activity->created_at->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Réussi
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Activité de connexion actuelle -->
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-sign-in-alt text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Session actuelle</h4>
                                    <p class="text-sm text-gray-600">{{ request()->ip() }} - {{ request()->userAgent() }}</p>
                                    <p class="text-xs text-gray-500">{{ now()->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-circle mr-1"></i>
                                    Actuelle
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Message d'information -->
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-history text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune activité récente</h3>
                        <p class="text-gray-600">Votre historique d'activité apparaîtra ici une fois que vous commencerez à utiliser l'application.</p>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            @if($activities->count() > 0)
            <div class="mt-8 flex justify-center">
                <nav class="flex items-center space-x-2">
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Précédent
                    </a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-white bg-orange-600 border border-orange-600 rounded-lg">
                        1
                    </a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Suivant
                    </a>
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
// Filtrage des activités
document.getElementById('activity_type').addEventListener('change', function() {
    // Logique de filtrage à implémenter
    console.log('Filtrage par type:', this.value);
});

document.getElementById('date_range').addEventListener('change', function() {
    // Logique de filtrage à implémenter
    console.log('Filtrage par période:', this.value);
});
</script>
@endsection 