# 🚀 Script de démarrage PeleFood
Write-Host "🍽️ Démarrage de PeleFood..." -ForegroundColor Green

# Vérifier si PHP est installé
try {
    $phpVersion = php -v 2>$null
    if ($phpVersion) {
        Write-Host "✅ PHP détecté" -ForegroundColor Green
    } else {
        Write-Host "❌ PHP non trouvé. Installez PHP 8.1+" -ForegroundColor Red
        exit 1
    }
} catch {
    Write-Host "❌ PHP non trouvé. Installez PHP 8.1+" -ForegroundColor Red
    exit 1
}

# Vérifier si Composer est installé
try {
    $composerVersion = composer -V 2>$null
    if ($composerVersion) {
        Write-Host "✅ Composer détecté" -ForegroundColor Green
    } else {
        Write-Host "❌ Composer non trouvé. Installez Composer" -ForegroundColor Red
        exit 1
    }
} catch {
    Write-Host "❌ Composer non trouvé. Installez Composer" -ForegroundColor Red
    exit 1
}

# Installer les dépendances PHP
Write-Host "📦 Installation des dépendances PHP..." -ForegroundColor Yellow
composer install

# Installer les dépendances Node.js
Write-Host "📦 Installation des dépendances Node.js..." -ForegroundColor Yellow
npm install

# Compiler les assets
Write-Host "🎨 Compilation des assets..." -ForegroundColor Yellow
npm run dev

# Démarrer le serveur
Write-Host "🚀 Démarrage du serveur..." -ForegroundColor Green
Write-Host "🌐 Ouvrez http://localhost:8000 dans votre navigateur" -ForegroundColor Cyan
Write-Host "🔑 Admin: admin@pelefood.com / password" -ForegroundColor Cyan
Write-Host "⏹️  Appuyez sur Ctrl+C pour arrêter" -ForegroundColor Yellow

php artisan serve --host=127.0.0.1 --port=8000 