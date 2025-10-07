@extends('layouts.restaurant')

@section('title', 'Créer un restaurant')
@section('page-title', 'Créer un restaurant')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Configuration de votre restaurant</h2>
            <p class="text-gray-600">Remplissez les informations de base de votre restaurant pour commencer à l'utiliser.</p>
        </div>

        <form method="POST" action="{{ route('restaurant.restaurants.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Affichage des erreurs globales -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <h3 class="text-red-800 font-medium mb-2">Erreurs de validation :</h3>
                    <ul class="text-red-700 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Informations de base -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom du restaurant <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200"
                           placeholder="Ex: Le Gourmet d'Abidjan">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Téléphone <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200"
                           placeholder="+225 0700000000">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea name="description" id="description" rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200"
                          placeholder="Décrivez votre restaurant, vos spécialités...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Adresse -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200"
                           placeholder="123 Rue du Commerce">
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                        Ville <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="city" id="city" value="{{ old('city') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200"
                           placeholder="Votre ville">
                    @error('city')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                        Code postal
                    </label>
                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200"
                           placeholder="01 BP 1234">
                    @error('postal_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Images -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
                        Logo du restaurant
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-orange-400 transition-colors duration-200" id="logo-upload-area">
                        <div class="space-y-1 text-center">
                            <!-- Prévisualisation du logo -->
                            <img id="logo-preview" class="mx-auto h-20 w-20 object-cover rounded-lg hidden" alt="Prévisualisation du logo">
                            <!-- Icône par défaut -->
                            <svg id="logo-icon" class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="logo" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                    <span>Télécharger un fichier</span>
                                    <input id="logo" name="logo" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, WEBP jusqu'à 2MB</p>
                        </div>
                    </div>
                    @error('logo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Image de couverture
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-orange-400 transition-colors duration-200" id="cover-upload-area">
                        <div class="space-y-1 text-center">
                            <!-- Prévisualisation de l'image de couverture -->
                            <img id="cover-preview" class="mx-auto h-20 w-32 object-cover rounded-lg hidden" alt="Prévisualisation de l'image de couverture">
                            <!-- Icône par défaut -->
                            <svg id="cover-icon" class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="cover_image" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                    <span>Télécharger un fichier</span>
                                    <input id="cover_image" name="cover_image" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, WEBP jusqu'à 5MB</p>
                        </div>
                    </div>
                    @error('cover_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Horaires d'ouverture -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Horaires d'ouverture</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="opening_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Heure d'ouverture
                        </label>
                        <input type="time" name="opening_time" id="opening_time" value="{{ old('opening_time', '08:00') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200">
                        @error('opening_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="closing_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Heure de fermeture
                        </label>
                        <input type="time" name="closing_time" id="closing_time" value="{{ old('closing_time', '22:00') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200">
                        @error('closing_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Options -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900">Options</h3>
                
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                           class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Restaurant actif
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="accepts_delivery" id="accepts_delivery" value="1" {{ old('accepts_delivery', true) ? 'checked' : '' }}
                           class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                    <label for="accepts_delivery" class="ml-2 block text-sm text-gray-900">
                        Accepte les livraisons
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="accepts_takeaway" id="accepts_takeaway" value="1" {{ old('accepts_takeaway', true) ? 'checked' : '' }}
                           class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                    <label for="accepts_takeaway" class="ml-2 block text-sm text-gray-900">
                        Accepte les commandes à emporter
                    </label>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('restaurant.dashboard') }}"
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">
                    Annuler
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-orange-500 text-white font-medium rounded-lg hover:bg-orange-600 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Créer le restaurant
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prévisualisation des images
    function previewImage(input, previewId, iconId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById(previewId);
                const icon = document.getElementById(iconId);
                if (preview && icon) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    icon.classList.add('hidden');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Gestion des fichiers
    const logoInput = document.getElementById('logo');
    const coverInput = document.getElementById('cover_image');

    if (logoInput) {
        logoInput.addEventListener('change', function() {
            previewImage(this, 'logo-preview', 'logo-icon');
        });
    }

    if (coverInput) {
        coverInput.addEventListener('change', function() {
            previewImage(this, 'cover-preview', 'cover-icon');
        });
    }

    // Gestion du glisser-déposer
    function setupDragAndDrop(inputId, previewId, iconId) {
        const uploadArea = document.getElementById(inputId + '-upload-area');
        const input = document.getElementById(inputId);
        
        if (uploadArea && input) {
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.classList.add('border-orange-400', 'bg-orange-50');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-orange-400', 'bg-orange-50');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-orange-400', 'bg-orange-50');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    input.files = files;
                    previewImage(input, previewId, iconId);
                }
            });
        }
    }

    // Configurer le glisser-déposer pour les deux zones
    setupDragAndDrop('logo', 'logo-preview', 'logo-icon');
    setupDragAndDrop('cover_image', 'cover-preview', 'cover-icon');

    // Validation en temps réel
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input[required], textarea[required]');

    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('border-red-500');
                this.classList.remove('border-gray-300');
            } else {
                this.classList.remove('border-red-500');
                this.classList.add('border-gray-300');
            }
        });
    });

    // Validation des fichiers
    function validateFile(input, maxSize, allowedTypes) {
        const file = input.files[0];
        if (file) {
            // Vérifier la taille
            if (file.size > maxSize) {
                alert(`Le fichier est trop volumineux. Taille maximale: ${maxSize / (1024 * 1024)}MB`);
                input.value = '';
                return false;
            }
            
            // Vérifier le type
            if (!allowedTypes.includes(file.type)) {
                alert(`Type de fichier non autorisé. Types acceptés: ${allowedTypes.join(', ')}`);
                input.value = '';
                return false;
            }
        }
        return true;
    }

    // Validation du logo
    if (logoInput) {
        logoInput.addEventListener('change', function() {
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            const maxSize = 2 * 1024 * 1024; // 2MB
            if (validateFile(this, maxSize, allowedTypes)) {
                previewImage(this, 'logo-preview', 'logo-icon');
            }
        });
    }

    // Validation de l'image de couverture
    if (coverInput) {
        coverInput.addEventListener('change', function() {
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            const maxSize = 5 * 1024 * 1024; // 5MB
            if (validateFile(this, maxSize, allowedTypes)) {
                previewImage(this, 'cover-preview', 'cover-icon');
            }
        });
    }
});
</script>
@endpush
@endsection 