<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CinetPayController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| CinetPay Routes
|--------------------------------------------------------------------------
|
| Routes pour l'intégration CinetPay
|
*/

Route::prefix('cinetpay')->group(function () {
    // Initialiser un paiement
    Route::post('/initialize', [CinetPayController::class, 'initializePayment'])->name('cinetpay.initialize');
    
    // Vérifier le statut d'un paiement
    Route::post('/check', [CinetPayController::class, 'checkPaymentStatus'])->name('cinetpay.check');
    
    // Traiter la notification de paiement (Webhook)
    Route::post('/notify', [CinetPayController::class, 'handlePaymentNotification'])->name('cinetpay.notify');
    
    // Page de retour après paiement
    Route::get('/return', [CinetPayController::class, 'paymentReturn'])->name('cinetpay.return');
    
    // Page d'annulation de paiement
    Route::get('/cancel', [CinetPayController::class, 'paymentCancel'])->name('cinetpay.cancel');
    
    // Obtenir les méthodes de paiement disponibles
    Route::get('/methods', [CinetPayController::class, 'getPaymentMethods'])->name('cinetpay.methods');
});