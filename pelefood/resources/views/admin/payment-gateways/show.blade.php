@extends('layouts.super-admin-new-design')

@section('page-title', 'Détails de la Passerelle de Paiement')
@section('page-description', 'Informations détaillées de la passerelle')

@section('content')
<div class="space-y-6">
    <!-- En-tête avec actions -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white">{{ $gateway->name }}</h1>
            <p class="text-gray-400 mt-2">Détails de la passerelle de paiement</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.payment-gateways.edit', $gateway) }}" 
               class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-200 hover-lift">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('admin.payment-gateways.index') }}" 
               class="px-6 py-3 bg-white/10 text-white font-medium rounded-xl hover:bg-white/20 transition-all duration-200 hover-lift">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <!-- Informations principales -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Carte principale -->
        <div class="lg:col-span-2">
            <div class="bg-slate-800/50 backdrop-blur-xl border border-white/10 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center">
                            @switch($gateway->provider)
                                @case('stripe')
                                    <i class="fab fa-stripe text-white text-2xl"></i>
                                    @break
                                @case('paypal')
                                    <i class="fab fa-paypal text-white text-2xl"></i>
                                    @break
                                @case('wave')
                                    <i class="fas fa-wave-square text-white text-2xl"></i>
                                    @break
                                @case('orange_money')
                                    <i class="fas fa-mobile-alt text-white text-2xl"></i>
                                    @break
                                @case('moov_money')
                                    <i class="fas fa-mobile-alt text-white text-2xl"></i>
                                    @break
                                @case('mtn_momo')
                                    <i class="fas fa-mobile-alt text-white text-2xl"></i>
                                    @break
                                @case('airtel_money')
                                    <i class="fas fa-mobile-alt text-white text-2xl"></i>
                                    @break
                                @default
                                    <i class="fas fa-credit-card text-white text-2xl"></i>
                            @endswitch
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ $gateway->name }}</h2>
                            <p class="text-gray-400 capitalize">{{ $gateway->provider }} - {{ $gateway->type }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-semibold text-white">{{ $gateway->currency }}</div>
                        <div class="text-gray-400">Devise supportée</div>
                    </div>
                </div>
                
                <!-- Statut et badges -->
                <div class="flex flex-wrap gap-2 mb-6">
                    @if($gateway->is_active)
                        <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm border border-green-500/30">
                            <i class="fas fa-check-circle mr-1"></i>Active
                        </span>
                    @else
                        <span class="px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-sm border border-red-500/30">
                            <i class="fas fa-times-circle mr-1"></i>Inactive
                        </span>
                    @endif
                    
                    <span class="px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-sm border border-blue-500/30">
                        <i class="fas fa-circle mr-1"></i>{{ ucfirst($gateway->mode) }}
                    </span>
                    
                    @if($gateway->supports_refunds)
                        <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm border border-green-500/30">
                            <i class="fas fa-undo mr-1"></i>Remboursements
                        </span>
                    @endif
                    
                    @if($gateway->supports_subscriptions)
                        <span class="px-3 py-1 bg-purple-500/20 text-purple-400 rounded-full text-sm border border-purple-500/30">
                            <i class="fas fa-sync mr-1"></i>Abonnements
                        </span>
                    @endif
                </div>
                
                <!-- Configuration -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-4">Configuration</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Fournisseur</span>
                                <span class="text-white font-medium capitalize">{{ $gateway->provider }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Type</span>
                                <span class="text-white font-medium capitalize">{{ $gateway->type }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Devise</span>
                                <span class="text-white font-medium">{{ $gateway->currency }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Mode</span>
                                <span class="text-white font-medium capitalize">{{ $gateway->mode }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-4">Frais</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-400">Frais fixes</span>
                                <span class="text-white font-medium">€{{ number_format($gateway->fixed_fee ?? 0, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Frais variables</span>
                                <span class="text-white font-medium">{{ $gateway->percentage_fee ?? 0 }}%</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Frais minimum</span>
                                <span class="text-white font-medium">€{{ number_format($gateway->minimum_fee ?? 0, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Créé le</span>
                                <span class="text-white font-medium">{{ $gateway->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Statistiques -->
            <div class="bg-slate-800/50 backdrop-blur-xl border border-white/10 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-white mb-4">Statistiques</h3>
                <div class="space-y-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">{{ $gateway->transactions_count ?? 0 }}</div>
                        <div class="text-gray-400 text-sm">Transactions</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">{{ $gateway->total_volume ?? '€0' }}</div>
                        <div class="text-gray-400 text-sm">Volume Total</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">{{ $gateway->success_rate ?? '0%' }}</div>
                        <div class="text-gray-400 text-sm">Taux de Succès</div>
                    </div>
                </div>
            </div>
            
            <!-- Actions rapides -->
            <div class="bg-slate-800/50 backdrop-blur-xl border border-white/10 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-white mb-4">Actions</h3>
                <div class="space-y-3">
                    <form action="{{ route('admin.payment-gateways.test', $gateway) }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-green-500/20 text-green-400 rounded-lg border border-green-500/30 hover:bg-green-500/30 transition-colors">
                            <i class="fas fa-play mr-2"></i>Tester la Connexion
                        </button>
                    </form>
                    <button class="w-full px-4 py-2 bg-blue-500/20 text-blue-400 rounded-lg border border-blue-500/30 hover:bg-blue-500/30 transition-colors">
                        <i class="fas fa-chart-line mr-2"></i>Analytics
                    </button>
                    <button class="w-full px-4 py-2 bg-purple-500/20 text-purple-400 rounded-lg border border-purple-500/30 hover:bg-purple-500/30 transition-colors">
                        <i class="fas fa-cog mr-2"></i>Configuration
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Fonctionnalités supportées -->
    <div class="bg-slate-800/50 backdrop-blur-xl border border-white/10 rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-white mb-4">Fonctionnalités Supportées</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="flex items-center space-x-3 p-3 {{ $gateway->supports_refunds ? 'bg-green-500/20' : 'bg-red-500/20' }} rounded-lg">
                @if($gateway->supports_refunds)
                    <i class="fas fa-check text-green-400"></i>
                    <span class="text-white">Remboursements</span>
                @else
                    <i class="fas fa-times text-red-400"></i>
                    <span class="text-white">Remboursements</span>
                @endif
            </div>
            
            <div class="flex items-center space-x-3 p-3 {{ $gateway->supports_subscriptions ? 'bg-green-500/20' : 'bg-red-500/20' }} rounded-lg">
                @if($gateway->supports_subscriptions)
                    <i class="fas fa-check text-green-400"></i>
                    <span class="text-white">Abonnements</span>
                @else
                    <i class="fas fa-times text-red-400"></i>
                    <span class="text-white">Abonnements</span>
                @endif
            </div>
            
            <div class="flex items-center space-x-3 p-3 {{ $gateway->supports_partial_capture ? 'bg-green-500/20' : 'bg-red-500/20' }} rounded-lg">
                @if($gateway->supports_partial_capture)
                    <i class="fas fa-check text-green-400"></i>
                    <span class="text-white">Capture Partielle</span>
                @else
                    <i class="fas fa-times text-red-400"></i>
                    <span class="text-white">Capture Partielle</span>
                @endif
            </div>
            
            <div class="flex items-center space-x-3 p-3 {{ $gateway->supports_3d_secure ? 'bg-green-500/20' : 'bg-red-500/20' }} rounded-lg">
                @if($gateway->supports_3d_secure)
                    <i class="fas fa-check text-green-400"></i>
                    <span class="text-white">3D Secure</span>
                @else
                    <i class="fas fa-times text-red-400"></i>
                    <span class="text-white">3D Secure</span>
                @endif
            </div>
            
            <div class="flex items-center space-x-3 p-3 {{ $gateway->auto_capture ? 'bg-green-500/20' : 'bg-red-500/20' }} rounded-lg">
                @if($gateway->auto_capture)
                    <i class="fas fa-check text-green-400"></i>
                    <span class="text-white">Capture Automatique</span>
                @else
                    <i class="fas fa-times text-red-400"></i>
                    <span class="text-white">Capture Automatique</span>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Historique des modifications -->
    <div class="bg-slate-800/50 backdrop-blur-xl border border-white/10 rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-white mb-4">Historique</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-white/5 rounded-lg">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-edit text-blue-400"></i>
                    <span class="text-white">Passerelle modifiée</span>
                </div>
                <span class="text-gray-400 text-sm">{{ $gateway->updated_at->diffForHumans() }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-white/5 rounded-lg">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-plus text-green-400"></i>
                    <span class="text-white">Passerelle créée</span>
                </div>
                <span class="text-gray-400 text-sm">{{ $gateway->created_at->diffForHumans() }}</span>
            </div>
        </div>
    </div>
</div>
@endsection 