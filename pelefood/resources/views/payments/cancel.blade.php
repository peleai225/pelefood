@extends('layouts.app')

@section('title', 'Paiement Annulé - PeleFood')
@section('description', 'Votre paiement a été annulé')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-orange-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-3xl shadow-2xl p-8 text-center">
            <!-- Icône d'annulation -->
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>

            <!-- Titre -->
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Paiement Annulé</h1>
            
            <!-- Message -->
            <p class="text-gray-600 mb-6">
                {{ $message ?? 'Votre paiement a été annulé. Aucun montant n\'a été débité de votre compte.' }}
            </p>

            <!-- Informations -->
            <div class="bg-gray-50 rounded-xl p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Que s'est-il passé ?</h3>
                
                <div class="space-y-3 text-sm text-left">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mr-3 mt-1"></i>
                        <span class="text-gray-600">Vous avez annulé le paiement</span>
                    </div>
                    
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mr-3 mt-1"></i>
                        <span class="text-gray-600">Aucun montant n'a été débité</span>
                    </div>
                    
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mr-3 mt-1"></i>
                        <span class="text-gray-600">Vous pouvez réessayer à tout moment</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-4">
                <a href="{{ route('payment.cinetpay') }}" class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl inline-block">
                    <i class="fas fa-credit-card mr-2"></i>
                    Nouveau paiement
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
