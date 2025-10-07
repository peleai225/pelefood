@extends('layouts.marketing')
@section('title', 'Vérification Email')
@section('content')

<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-orange-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-32 h-32 bg-orange-200 rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-24 h-24 bg-orange-300 rounded-full opacity-30 animate-bounce"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-orange-400 rounded-full opacity-25 animate-ping"></div>
    </div>
    
    <div class="max-w-md w-full space-y-8 relative z-10">
        <!-- Logo et titre -->
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Vérifiez votre email</h2>
            <p class="text-gray-600">Nous avons envoyé un lien de vérification à votre adresse email</p>
        </div>

        <!-- Contenu de vérification -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Email envoyé !</h3>
                <p class="text-gray-600 text-sm">
                    Nous avons envoyé un lien de vérification à <strong>{{ auth()->user()->email }}</strong>
                </p>
            </div>

            <div class="space-y-4">
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-blue-800">Instructions</h4>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Vérifiez votre boîte de réception</li>
                                    <li>Cliquez sur le lien de vérification</li>
                                    <li>Vérifiez aussi vos spams si nécessaire</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                @if (session('resent'))
                    <div class="alert alert-restaurant-success alert-dismissible fade show mb-6" role="alert">
                        <i class="fas fa-check-circle me-2"></i>Un nouveau lien de vérification a été envoyé à votre adresse email.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Boutons d'action -->
                <div class="space-y-3">
                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white py-3 px-4 rounded-xl font-semibold text-center transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Renvoyer l'email de vérification
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 px-4 rounded-xl font-semibold text-center transition-all duration-300 transform hover:scale-105">
                            Se déconnecter
                        </button>
                    </form>
                </div>
            </div>

            <!-- Aide -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    Problème avec la vérification ? 
                    <a href="{{ route('contact') }}" class="font-medium text-orange-600 hover:text-orange-500 transition-colors duration-200">
                        Contactez-nous
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection 