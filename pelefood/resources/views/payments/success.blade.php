@extends('layouts.app')

@section('title', 'Paiement Réussi - PeleFood')
@section('description', 'Votre paiement a été traité avec succès')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-3xl shadow-2xl p-8 text-center">
            <!-- Icône de succès -->
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <!-- Titre -->
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Paiement Réussi !</h1>
            
            <!-- Message -->
            <p class="text-gray-600 mb-6">
                Votre paiement a été traité avec succès. Vous recevrez un email de confirmation sous peu.
            </p>

            <!-- Détails du paiement -->
            <div class="bg-gray-50 rounded-xl p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Détails du paiement</h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID de transaction:</span>
                        <span class="font-medium text-gray-900">{{ $transaction_id ?? 'N/A' }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Montant:</span>
                        <span class="font-medium text-gray-900">{{ number_format($amount ?? 0, 0, ',', ' ') }} {{ $currency ?? 'FCFA' }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Statut:</span>
                        <span class="font-medium text-green-600">{{ $status ?? 'Réussi' }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-4">
                <a href="{{ route('home') }}" class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl inline-block">
                    <i class="fas fa-home mr-2"></i>
                    Retour à l'accueil
                </a>
                
                <a href="{{ route('payment.cinetpay') }}" class="w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 inline-block">
                    <i class="fas fa-credit-card mr-2"></i>
                    Nouveau paiement
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
