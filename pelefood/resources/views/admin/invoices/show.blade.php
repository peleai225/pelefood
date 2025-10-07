@extends('layouts.super-admin-new-design')

@section('page-title', 'Détails de la Facture')
@section('page-description', 'Afficher les détails de la facture')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-white">Facture #{{ $invoice->id }}</h2>
            <p class="text-gray-400">Détails complets de la facture</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                Modifier
            </a>
            <a href="{{ route('admin.invoices.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour
            </a>
        </div>
    </div>

    <!-- Informations principales -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Détails de la facture -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700 rounded-xl p-6">
                <h3 class="text-lg font-medium text-white mb-4">Informations de la facture</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Numéro de facture</label>
                        <p class="text-white font-medium">{{ $invoice->invoice_number ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Statut</label>
                        @php
                            $statusClasses = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'paid' => 'bg-green-100 text-green-800',
                                'overdue' => 'bg-red-100 text-red-800',
                                'cancelled' => 'bg-gray-100 text-gray-800'
                            ];
                            $status = $invoice->status ?? 'pending';
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($status) }}
                        </span>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Montant total</label>
                        <p class="text-2xl font-bold text-white">{{ number_format($invoice->total_amount ?? 0) }} FCFA</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Date de création</label>
                        <p class="text-white">{{ $invoice->created_at ? $invoice->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                    </div>
                    
                    @if($invoice->due_date)
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Date d'échéance</label>
                        <p class="text-white">{{ $invoice->due_date->format('d/m/Y') }}</p>
                    </div>
                    @endif
                    
                    @if($invoice->payment_method)
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Méthode de paiement</label>
                        <p class="text-white">{{ ucfirst(str_replace('_', ' ', $invoice->payment_method)) }}</p>
                    </div>
                    @endif
                </div>
                
                @if($invoice->description)
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Description</label>
                    <p class="text-white bg-gray-700/50 rounded-lg p-3">{{ $invoice->description }}</p>
                </div>
                @endif
            </div>

            <!-- Informations du restaurant -->
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700 rounded-xl p-6">
                <h3 class="text-lg font-medium text-white mb-4">Restaurant</h3>
                
                @if($invoice->restaurant)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Nom</label>
                        <p class="text-white font-medium">{{ $invoice->restaurant->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Email</label>
                        <p class="text-white">{{ $invoice->restaurant->email ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Téléphone</label>
                        <p class="text-white">{{ $invoice->restaurant->phone ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Adresse</label>
                        <p class="text-white">{{ $invoice->restaurant->address ?? 'N/A' }}</p>
                    </div>
                </div>
                @else
                <p class="text-gray-400">Aucun restaurant associé</p>
                @endif
            </div>

            <!-- Informations du client -->
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700 rounded-xl p-6">
                <h3 class="text-lg font-medium text-white mb-4">Client</h3>
                
                @if($invoice->user)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Nom</label>
                        <p class="text-white font-medium">{{ $invoice->user->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Email</label>
                        <p class="text-white">{{ $invoice->user->email }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Rôle</label>
                        <p class="text-white">{{ ucfirst($invoice->user->role ?? 'Utilisateur') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Date d'inscription</label>
                        <p class="text-white">{{ $invoice->user->created_at ? $invoice->user->created_at->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                </div>
                @else
                <p class="text-gray-400">Aucun client associé</p>
                @endif
            </div>

            <!-- Plan d'abonnement -->
            @if($invoice->subscription_plan_id)
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700 rounded-xl p-6">
                <h3 class="text-lg font-medium text-white mb-4">Plan d'abonnement</h3>
                
                @if($invoice->subscriptionPlan)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Nom du plan</label>
                        <p class="text-white font-medium">{{ $invoice->subscriptionPlan->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Prix</label>
                        <p class="text-white">{{ number_format($invoice->subscriptionPlan->price) }} FCFA</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Durée</label>
                        <p class="text-white">{{ $invoice->subscriptionPlan->duration }} mois</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Description</label>
                        <p class="text-white">{{ $invoice->subscriptionPlan->description ?? 'N/A' }}</p>
                    </div>
                </div>
                @else
                <p class="text-gray-400">Plan d'abonnement non trouvé</p>
                @endif
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Actions rapides -->
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700 rounded-xl p-6">
                <h3 class="text-lg font-medium text-white mb-4">Actions rapides</h3>
                
                <div class="space-y-3">
                    @if($invoice->status === 'pending')
                    <button class="w-full bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg px-4 py-2 transition-colors duration-200">
                        <i class="fas fa-check mr-2"></i>
                        Marquer comme payée
                    </button>
                    @endif
                    
                    @if($invoice->status === 'paid')
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg px-4 py-2 transition-colors duration-200">
                        <i class="fas fa-download mr-2"></i>
                        Télécharger PDF
                    </button>
                    @endif
                    
                    <button class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg px-4 py-2 transition-colors duration-200">
                        <i class="fas fa-envelope mr-2"></i>
                        Envoyer par email
                    </button>
                    
                    @if($invoice->status !== 'cancelled')
                    <button class="w-full bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg px-4 py-2 transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Annuler la facture
                    </button>
                    @endif
                </div>
            </div>

            <!-- Historique -->
            <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700 rounded-xl p-6">
                <h3 class="text-lg font-medium text-white mb-4">Historique</h3>
                
                <div class="space-y-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        <div class="flex-1">
                            <p class="text-sm text-white">Facture créée</p>
                            <p class="text-xs text-gray-400">{{ $invoice->created_at ? $invoice->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                    
                    @if($invoice->updated_at && $invoice->updated_at != $invoice->created_at)
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        <div class="flex-1">
                            <p class="text-sm text-white">Facture modifiée</p>
                            <p class="text-xs text-gray-400">{{ $invoice->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 