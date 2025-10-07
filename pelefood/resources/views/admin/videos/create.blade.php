@extends('layouts.super-admin-new-design')

@section('title', 'Ajouter une Vidéo')

@section('content')
<div class="p-6 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <!-- En-tête avec titre et navigation -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-video text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Ajouter une Vidéo</h1>
                <p class="text-gray-600 mt-1">Créez une nouvelle vidéo pour votre plateforme</p>
            </div>
        </div>
        <a href="{{ route('admin.videos.index') }}" class="flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour à la liste
        </a>
    </div>

    <!-- Messages d'alerte modernisés -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                <i class="fas fa-check text-green-600"></i>
            </div>
            <div class="flex-1">
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div class="flex-1">
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
            <div class="flex items-center mb-3">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <h3 class="text-red-800 font-medium">Erreurs de validation</h3>
            </div>
            <ul class="list-disc list-inside text-red-700 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulaire principal -->
    <form action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne principale - Informations générales -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Section Informations de base -->
                <x-form-section 
                    title="Informations de base" 
                    icon="info-circle" 
                    icon-color="blue"
                    description="Définissez les informations principales de votre vidéo"
                    :columns="1">
                    
                    <x-form-field 
                        label="Titre de la vidéo"
                        name="title"
                        type="text"
                        :required="true"
                        placeholder="Entrez le titre de votre vidéo"
                        value="{{ old('title') }}"
                        :error="$errors->first('title')"
                    />

                    <x-form-field 
                        label="Description"
                        name="description"
                        type="textarea"
                        :rows="4"
                        placeholder="Décrivez le contenu de votre vidéo..."
                        value="{{ old('description') }}"
                        :error="$errors->first('description')"
                    />
                </x-form-section>

                <!-- Section Contenu vidéo -->
                <x-form-section 
                    title="Contenu vidéo" 
                    icon="play-circle" 
                    icon-color="green"
                    description="Ajoutez votre vidéo via URL ou upload de fichier"
                    :columns="2">
                    
                    <x-form-field 
                        label="URL de la vidéo"
                        name="video_url"
                        type="text"
                        placeholder="https://www.youtube.com/watch?v=..."
                        value="{{ old('video_url') }}"
                        :error="$errors->first('video_url')"
                        help="Laissez vide si vous uploadez un fichier"
                    />

                    <x-form-field 
                        label="Fichier vidéo"
                        name="video_file"
                        type="file"
                        accept="video/*"
                        :error="$errors->first('video_file')"
                        help="Max 100MB. Formats: MP4, AVI, MOV, WMV, FLV, WebM"
                    />

                    <x-form-field 
                        label="Miniature"
                        name="thumbnail"
                        type="file"
                        accept="image/*"
                        :error="$errors->first('thumbnail')"
                        help="Max 2MB. Formats: JPEG, PNG, JPG, GIF"
                    />
                </x-form-section>
            </div>
            
            <!-- Sidebar - Paramètres -->
            <div class="space-y-6">
                <!-- Section Paramètres techniques -->
                <x-form-section 
                    title="Paramètres techniques" 
                    icon="cog" 
                    icon-color="orange"
                    description="Configurez les paramètres de la vidéo"
                    :columns="1"
                    spacing="compact">
                    
                    <x-form-field 
                        label="Durée (secondes)"
                        name="duration"
                        type="number"
                        placeholder="120"
                        value="{{ old('duration') }}"
                        :error="$errors->first('duration')"
                    />

                    <x-form-field 
                        label="Qualité"
                        name="quality"
                        type="select"
                        :required="true"
                        :options="[
                            'SD' => 'SD (480p)',
                            'HD' => 'HD (720p)', 
                            'Full HD' => 'Full HD (1080p)',
                            '4K' => '4K (2160p)'
                        ]"
                        value="{{ old('quality') }}"
                        :error="$errors->first('quality')"
                    />

                    <x-form-field 
                        label="Langue"
                        name="language"
                        type="text"
                        :required="true"
                        placeholder="fr"
                        value="{{ old('language', 'fr') }}"
                        :error="$errors->first('language')"
                    />

                    <x-form-field 
                        label="Ordre d'affichage"
                        name="sort_order"
                        type="number"
                        placeholder="0"
                        value="{{ old('sort_order', 0) }}"
                        :error="$errors->first('sort_order')"
                    />
                </x-form-section>

                <!-- Section Statut et visibilité -->
                <x-form-section 
                    title="Statut et visibilité" 
                    icon="toggle-on" 
                    icon-color="purple"
                    description="Contrôlez la visibilité de votre vidéo"
                    :columns="1"
                    spacing="compact">
                    
                    <div class="space-y-4">
                        <!-- Vidéo active -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <h3 class="font-medium text-gray-900">Vidéo active</h3>
                                <p class="text-sm text-gray-500">La vidéo sera visible sur la plateforme</p>
                            </div>
                            <x-form-field 
                                name="is_active"
                                type="checkbox"
                                value="{{ old('is_active', true) ? '1' : '' }}"
                            />
                        </div>

                        <!-- Mise en avant -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <h3 class="font-medium text-gray-900">Mise en avant</h3>
                                <p class="text-sm text-gray-500">Afficher cette vidéo en priorité</p>
                            </div>
                            <x-form-field 
                                name="is_featured"
                                type="checkbox"
                                value="{{ old('is_featured') ? '1' : '' }}"
                            />
                        </div>
                    </div>
                </x-form-section>

                <!-- Actions -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="space-y-4">
                        <button type="submit" class="w-full flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save mr-2"></i>
                            Enregistrer la vidéo
                        </button>
                        
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
                    <p class="text-sm text-gray-600">Aperçu de la miniature</p>
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
