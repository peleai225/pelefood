# 🎨 Intégration du Logo PeleFood

## ✅ **Espace Logo Ajouté**

J'ai ajouté un espace dédié pour le logo PeleFood dans les formulaires de connexion et d'inscription.

### 🎯 **Design du Logo :**

#### **Structure :**
```html
<!-- Logo PeleFood -->
<div class="text-center mb-8">
    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl shadow-lg mb-4">
        <!-- Placeholder pour le logo - remplacez par votre image -->
        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
        </svg>
    </div>
    <h2 class="text-2xl font-bold text-gray-800 mb-2">PeleFood</h2>
    <p class="text-sm text-gray-600">Connectez-vous à votre compte</p>
</div>
```

### 🔧 **Comment Remplacer le Logo :**

#### **Option 1 : Image PNG/JPG/SVG**
```html
<div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl shadow-lg mb-4">
    <img src="{{ asset('images/logo-pelefood.png') }}" alt="PeleFood Logo" class="w-12 h-12 object-contain">
</div>
```

#### **Option 2 : SVG Inline**
```html
<div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl shadow-lg mb-4">
    <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
        <!-- Votre SVG personnalisé ici -->
        <path d="VOTRE_SVG_ICI"/>
    </svg>
</div>
```

#### **Option 3 : Logo avec Background Transparent**
```html
<div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-lg mb-4 border-2 border-orange-200">
    <img src="{{ asset('images/logo-pelefood.png') }}" alt="PeleFood Logo" class="w-12 h-12 object-contain">
</div>
```

### 📁 **Fichiers à Modifier :**

1. **`resources/views/livewire/auth/login-form-working.blade.php`**
   - Ligne 16-24 : Logo de connexion

2. **`resources/views/livewire/auth/register-form-modern.blade.php`**
   - Ligne 16-24 : Logo d'inscription

### 🎨 **Styles du Logo :**

#### **Container :**
- **Taille** : `w-20 h-20` (80px × 80px)
- **Background** : Gradient orange-rouge
- **Border radius** : `rounded-2xl`
- **Ombre** : `shadow-lg`

#### **Logo Image :**
- **Taille** : `w-12 h-12` (48px × 48px)
- **Position** : Centré dans le container
- **Object fit** : `object-contain` (pour préserver les proportions)

### 🚀 **Recommandations :**

#### **Format d'Image :**
- **PNG** : Avec transparence (recommandé)
- **SVG** : Vectoriel, scalable
- **JPG** : Si pas de transparence nécessaire

#### **Taille Recommandée :**
- **Minimum** : 200px × 200px
- **Optimal** : 400px × 400px
- **Format** : Carré (1:1)

#### **Couleurs :**
- **Background** : Blanc ou transparent
- **Logo** : Couleurs contrastées avec le gradient orange-rouge
- **Alternative** : Logo blanc sur fond coloré

### 📱 **Responsive :**

Le logo s'adapte automatiquement :
- **Mobile** : Taille optimale
- **Desktop** : Même taille, centré
- **Tablet** : Adaptation fluide

### 🎯 **Personnalisation Avancée :**

#### **Logo Animé :**
```html
<div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl shadow-lg mb-4 hover:scale-105 transition-transform duration-300">
    <img src="{{ asset('images/logo-pelefood.png') }}" alt="PeleFood Logo" class="w-12 h-12 object-contain">
</div>
```

#### **Logo avec Hover Effect :**
```html
<div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl shadow-lg mb-4 hover:shadow-xl hover:shadow-orange-500/25 transition-all duration-300">
    <img src="{{ asset('images/logo-pelefood.png') }}" alt="PeleFood Logo" class="w-12 h-12 object-contain">
</div>
```

## 🔧 **Étapes d'Intégration :**

1. **Préparez votre logo** au format PNG/SVG
2. **Placez-le** dans `public/images/logo-pelefood.png`
3. **Remplacez** le SVG placeholder par votre image
4. **Testez** sur mobile et desktop
5. **Ajustez** la taille si nécessaire

---

**🎨 Votre logo PeleFood est maintenant prêt à être intégré !**
