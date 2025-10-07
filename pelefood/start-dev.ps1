# Script pour démarrer Vite avec Node.js dans le PATH
$env:PATH += ";C:\Program Files\nodejs"

Write-Host "🚀 Démarrage de Vite pour PeleFood..." -ForegroundColor Green
Write-Host "📁 Dossier: $(Get-Location)" -ForegroundColor Yellow
Write-Host "🔧 Node.js version: $(node --version)" -ForegroundColor Cyan
Write-Host "📦 npm version: $(npm --version)" -ForegroundColor Cyan

npm run dev 