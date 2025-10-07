@extends('layouts.app')

@section('title', 'Erreur de Paiement - PeleFood')
@section('description', 'Une erreur est survenue lors du paiement')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 to-pink-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-3xl shadow-2xl p-8 text-center">
            <!-- Icône d'erreur -->
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-red-500 to-pink-500 rounded-full mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>

            <!-- Titre -->
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Erreur de Paiement</h1>
            
            <!-- Message -->
            <p class="text-gray-600 mb-6">
                {{ $message ?? 'Une erreur est survenue lors du traitement de votre paiement. Veuillez réessayer.' }}
            </p>

            <!-- Informations d'aide -->
            <div class="bg-gray-50 rounded-xl p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Que faire maintenant ?</h3>
                
                <div class="space-y-3 text-sm text-left">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <span class="text-gray-600">Vérifiez vos informations de paiement</span>
                    </div>
                    
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <span class="text-gray-600">Assurez-vous d'avoir suffisamment de fonds</span>
                    </div>
                    
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <span class="text-gray-600">Essayez une autre méthode de paiement</span>
                    </div>
                    
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <span class="text-gray-600">Contactez le support si le problème persiste</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-4">
                <a href="{{ route('payment.cinetpay') }}" class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl inline-block">
                    <i class="fas fa-redo mr-2"></i>
                    Réessayer le paiement
                </a>
                
                <a href="{{ route('home') }}" class="w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 inline-block">
                    <i class="fas fa-home mr-2"></i>
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
