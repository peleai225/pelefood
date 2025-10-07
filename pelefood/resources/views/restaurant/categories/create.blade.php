@extends('layouts.restaurant')

@section('title', 'Nouvelle catégorie')
@section('page-title', 'Ajouter une catégorie')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Nouvelle catégorie</h2>
                <p class="text-gray-600 mt-1">Organisez vos produits avec des catégories</p>
            </div>
            <a href="{{ route('restaurant.categories.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour aux catégories
            </a>
        </div>
    </div>

    <!-- Formulaire -->
    <form action="{{ route('restaurant.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informations principales -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informations de base -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-info-circle text-orange-500 mr-2"></i>
                        Informations de base
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom de la catégorie *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('name') border-red-500 @enderror"
                                   placeholder="Ex: Pizzas, Boissons, Desserts">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('description') border-red-500 @enderror"
                                      placeholder="Décrivez cette catégorie...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Ordre d'affichage</label>
                                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('sort_order') border-red-500 @enderror"
                                       placeholder="0">
                                <p class="mt-1 text-xs text-gray-500">Plus le nombre est petit, plus la catégorie apparaîtra en premier</p>
                                @error('sort_order')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Couleur de la catégorie</label>
                                <div class="flex items-center space-x-2">
                                    <input type="color" name="color" id="color" value="{{ old('color', '#f97316') }}"
                                           class="h-10 w-16 border border-gray-300 rounded-lg cursor-pointer">
                                    <input type="text" value="{{ old('color', '#f97316') }}" id="color-text"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                           placeholder="#f97316">
                                </div>
                                @error('color')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paramètres d'affichage -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-eye text-orange-500 mr-2"></i>
                        Paramètres d'affichage
                    </h3>
                    
                    <div class="space-y-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Catégorie active</span>
                        </label>

                        <label class="flex items-center">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                   class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Catégorie en vedette</span>
                        </label>

                        <label class="flex items-center">
                            <input type="checkbox" name="show_on_menu" value="1" {{ old('show_on_menu', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Afficher sur le menu public</span>
                        </label>
                    </div>
                </div>

                <!-- SEO et métadonnées -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-search text-orange-500 mr-2"></i>
                        SEO et métadonnées
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">Titre SEO</label>
                            <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('meta_title') border-red-500 @enderror"
                                   placeholder="Titre pour les moteurs de recherche">
                            <p class="mt-1 text-xs text-gray-500">Laissez vide pour utiliser le nom de la catégorie</p>
                            @error('meta_title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Description SEO</label>
                            <textarea name="meta_description" id="meta_description" rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('meta_description') border-red-500 @enderror"
                                      placeholder="Description pour les moteurs de recherche">{{ old('meta_description') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Laissez vide pour utiliser la description de la catégorie</p>
                            @error('meta_description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">Mots-clés SEO</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('meta_keywords') border-red-500 @enderror"
                                   placeholder="mot-clé1, mot-clé2, mot-clé3">
                            <p class="mt-1 text-xs text-gray-500">Séparez les mots-clés par des virgules</p>
                            @error('meta_keywords')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image et aperçu -->
            <div class="space-y-6">
                <!-- Image de la catégorie -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-image text-orange-500 mr-2"></i>
                        Image de la catégorie
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center" id="image-upload-area">
                            <div id="image-preview" class="hidden mb-4">
                                <img id="preview-img" src="" alt="Aperçu" class="mx-auto h-32 w-32 object-cover rounded-lg">
                            </div>
                            <div id="upload-placeholder">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                                <p class="text-sm text-gray-600">Glissez-déposez une image ou cliquez pour sélectionner</p>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG jusqu'à 2MB</p>
                            </div>
                            <input type="file" name="image" id="image" accept="image/*" class="hidden">
                        </div>
                        @error('image')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Aperçu de la catégorie -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-eye text-orange-500 mr-2"></i>
                        Aperçu
                    </h3>
                    
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <div class="flex items-center space-x-3 mb-3">
                            <div id="preview-color" class="w-4 h-4 rounded-full" style="background-color: #f97316;"></div>
                            <h4 id="preview-name" class="font-medium text-gray-900">Nom de la catégorie</h4>
                        </div>
                        <p id="preview-description" class="text-sm text-gray-600">Description de la catégorie...</p>
                        <div class="mt-3 flex items-center space-x-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i> Active
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                <i class="fas fa-star mr-1"></i> Vedette
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-chart-bar text-orange-500 mr-2"></i>
                        Statistiques
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Produits dans cette catégorie</span>
                            <span class="text-sm font-medium text-gray-900">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Ordre d'affichage</span>
                            <span id="preview-sort" class="text-sm font-medium text-gray-900">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="flex justify-end space-x-4">
            <button type="button" onclick="window.history.back()" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">
                Annuler
            </button>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white font-medium rounded-lg hover:from-orange-600 hover:to-red-600 transition-all duration-200 transform hover:scale-105 shadow-lg">
                <i class="fas fa-save mr-2"></i>
                Créer la catégorie
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de l'upload d'image
    const imageUploadArea = document.getElementById('image-upload-area');
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const uploadPlaceholder = document.getElementById('upload-placeholder');

    imageUploadArea.addEventListener('click', () => imageInput.click());
    
    imageUploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        imageUploadArea.classList.add('border-orange-500', 'bg-orange-50');
    });
    
    imageUploadArea.addEventListener('dragleave', (e) => {
        e.preventDefault();
        imageUploadArea.classList.remove('border-orange-500', 'bg-orange-50');
    });
    
    imageUploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        imageUploadArea.classList.remove('border-orange-500', 'bg-orange-50');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            handleImagePreview(files[0]);
        }
    });
    
    imageInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleImagePreview(e.target.files[0]);
        }
    });
    
    function handleImagePreview(file) {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                imagePreview.classList.remove('hidden');
                uploadPlaceholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    // Gestion de la couleur
    const colorInput = document.getElementById('color');
    const colorText = document.getElementById('color-text');
    const previewColor = document.getElementById('preview-color');

    function updateColor() {
        const color = colorInput.value;
        colorText.value = color;
        previewColor.style.backgroundColor = color;
    }

    colorInput.addEventListener('input', updateColor);
    colorText.addEventListener('input', function() {
        colorInput.value = this.value;
        updateColor();
    });

    // Aperçu en temps réel
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const sortOrderInput = document.getElementById('sort_order');
    const previewName = document.getElementById('preview-name');
    const previewDescription = document.getElementById('preview-description');
    const previewSort = document.getElementById('preview-sort');

    nameInput.addEventListener('input', function() {
        previewName.textContent = this.value || 'Nom de la catégorie';
    });

    descriptionInput.addEventListener('input', function() {
        previewDescription.textContent = this.value || 'Description de la catégorie...';
    });

    sortOrderInput.addEventListener('input', function() {
        previewSort.textContent = this.value || '0';
    });

    // Initialiser l'aperçu
    updateColor();
});
</script>
@endpush
@endsection 