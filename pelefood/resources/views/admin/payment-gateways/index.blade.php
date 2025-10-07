@extends('layouts.super-admin-new-design')

@section('title', 'Passerelles de Paiement - PeleFood')
@section('description', 'Gestion des passerelles de paiement')

@section('breadcrumb')
<li>
    <div class="flex items-center">
        <i data-lucide="chevron-right" class="h-4 w-4 text-muted-foreground mx-2"></i>
        <span class="text-sm font-medium text-foreground">Passerelles de Paiement</span>
    </div>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Passerelles de Paiement</h1>
            <p class="mt-2 text-lg text-muted-foreground">Gérez les passerelles de paiement disponibles</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.payment-gateways.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 transition-colors">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Ajouter une Passerelle
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Total</p>
                        <p class="text-2xl font-bold text-foreground">{{ $gateways->total() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="credit-card" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Actives</p>
                        <p class="text-2xl font-bold text-foreground">{{ $gateways->where('is_active', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">En Test</p>
                        <p class="text-2xl font-bold text-foreground">{{ $gateways->where('test_mode', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="test-tube" class="w-6 h-6 text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Types</p>
                        <p class="text-2xl font-bold text-foreground">{{ $gateways->pluck('type')->unique()->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="layers" class="w-6 h-6 text-purple-600 dark:text-purple-400"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des passerelles -->
    <div class="rounded-xl border bg-card text-card-foreground shadow">
        <div class="p-6 border-b border-border">
            <h2 class="text-xl font-semibold text-foreground">Liste des Passerelles</h2>
        </div>
        
        @if($gateways->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-border">
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Nom</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Provider</th>
                            <th class="h-12 px-4 text-center align-middle font-medium text-muted-foreground">Statut</th>
                            <th class="h-12 px-4 text-center align-middle font-medium text-muted-foreground">Mode</th>
                            <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground">Frais</th>
                            <th class="h-12 px-4 text-center align-middle font-medium text-muted-foreground">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gateways as $gateway)
                        <tr class="border-b border-border hover:bg-muted/50">
                            <td class="p-4 align-middle">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center text-primary font-bold text-sm mr-3">
                                        {{ strtoupper(substr($gateway->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-foreground">{{ $gateway->name }}</div>
                                        <div class="text-sm text-muted-foreground">{{ $gateway->description }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 align-middle">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-secondary text-secondary-foreground">
                                    {{ ucfirst($gateway->provider) }}
                                </span>
                            </td>
                            <td class="p-4 align-middle text-center">
                                @if($gateway->is_active)
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300">
                                        <i data-lucide="check" class="w-3 h-3 mr-1"></i>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300">
                                        <i data-lucide="x" class="w-3 h-3 mr-1"></i>
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 align-middle text-center">
                                @if($gateway->test_mode)
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300">
                                        <i data-lucide="test-tube" class="w-3 h-3 mr-1"></i>
                                        Test
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300">
                                        <i data-lucide="globe" class="w-3 h-3 mr-1"></i>
                                        Production
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 align-middle text-right">
                                <div class="text-sm">
                                    <div class="font-semibold text-foreground">{{ $gateway->fees_percentage }}%</div>
                                    <div class="text-muted-foreground">+ {{ \App\Helpers\SettingsHelper::formatAmount($gateway->fees_fixed) }}</div>
                                </div>
                            </td>
                            <td class="p-4 align-middle text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.payment-gateways.edit', $gateway) }}" 
                                       class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-primary text-primary-foreground hover:bg-primary/90 h-8 w-8" title="Modifier">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.payment-gateways.destroy', $gateway) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette passerelle ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-destructive text-destructive-foreground hover:bg-destructive/90 h-8 w-8" title="Supprimer">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-6 border-t border-border">
                {{ $gateways->links() }}
            </div>
        @else
            <div class="p-8 text-center">
                <div class="flex flex-col items-center">
                    <i data-lucide="credit-card" class="w-12 h-12 text-muted-foreground mb-4"></i>
                    <h3 class="text-lg font-medium text-foreground">Aucune passerelle</h3>
                    <p class="text-muted-foreground">Commencez par ajouter une passerelle de paiement.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.payment-gateways.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 transition-colors">
                            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                            Ajouter une Passerelle
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection