<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaaS\HomeController;
use App\Http\Controllers\SaaS\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| SaaS Routes
|--------------------------------------------------------------------------
|
| Routes pour l'interface SaaS moderne de PeleFood
|
*/

// Page d'accueil publique - Déjà définie dans web.php
// Route::get('/', [HomeController::class, 'index'])->name('saas.home');

// Authentification
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Dashboard protégé
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Routes de démonstration
Route::get('/demo', function () {
    return view('saas.demo');
})->name('demo');

Route::get('/features', function () {
    return view('saas.features');
})->name('features');

Route::get('/pricing', function () {
    return view('saas.pricing');
})->name('pricing');

Route::get('/contact', function () {
    return view('saas.contact');
})->name('contact');
