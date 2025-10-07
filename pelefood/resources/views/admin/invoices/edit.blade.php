@extends('layouts.super-admin-new-design')

@section('page-title', 'Modifier la Facture')
@section('page-description', 'Modifier les informations de la facture')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- En-tête -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-white">Modifier la Facture</h2>
            <p class="text-gray-400">Modifiez les informations de la facture #{{ $invoice->id }}</p>
        </div>
        <a href="{{ route('admin.invoices.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour
        </a>
    </div>

    <!-- Formulaire -->
    <form action="{{ route('admin.invoices.update', $invoice->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700 rounded-xl p-6">
            <h3 class="text-lg font-medium text-white mb-4">Informations de base</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="restaurant_id" class="block text-sm font-medium text-gray-300 mb-2">Restaurant *</label>
                    <select id="restaurant_id" name="restaurant_id" required class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Sélectionner un restaurant</option>
                        @foreach($restaurants as $restaurant)
                            <option value="{{ $restaurant->id }}" {{ old('restaurant_id', $invoice->restaurant_id) == $restaurant->id ? 'selected' : '' }}>
                                {{ $restaurant->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('restaurant_id')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-300 mb-2">Client *</label>
                    <select id="user_id" name="user_id" required class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Sélectionner un client</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $invoice->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subscription_plan_id" class="block text-sm font-medium text-gray-300 mb-2">Plan d'abonnement</label>
                    <select id="subscription_plan_id" name="subscription_plan_id" class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Aucun plan</option>
                        @foreach($subscriptionPlans as $plan)
                            <option value="{{ $plan->id }}" {{ old('subscription_plan_id', $invoice->subscription_plan_id) == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }} - {{ number_format($plan->price) }} FCFA
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="invoice_number" class="block text-sm font-medium text-gray-300 mb-2">Numéro de facture</label>
                    <input type="text" id="invoice_number" name="invoice_number" value="{{ old('invoice_number', $invoice->invoice_number) }}" class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="FACT-2024-001">
                </div>
            </div>
        </div>

        <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700 rounded-xl p-6">
            <h3 class="text-lg font-medium text-white mb-4">Détails de la facture</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="total_amount" class="block text-sm font-medium text-gray-300 mb-2">Montant total *</label>
                    <div class="relative">
                        <input type="number" id="total_amount" name="total_amount" step="0.01" min="0" required value="{{ old('total_amount', $invoice->total_amount) }}" class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 pl-10 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="0.00">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-400">FCFA</span>
                        </div>
                    </div>
                    @error('total_amount')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Statut *</label>
                    <select id="status" name="status" required class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="pending" {{ old('status', $invoice->status) == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="paid" {{ old('status', $invoice->status) == 'paid' ? 'selected' : '' }}>Payée</option>
                        <option value="overdue" {{ old('status', $invoice->status) == 'overdue' ? 'selected' : '' }}>En retard</option>
                        <option value="cancelled" {{ old('status', $invoice->status) == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-300 mb-2">Date d'échéance</label>
                    <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '') }}" class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-300 mb-2">Méthode de paiement</label>
                    <select id="payment_method" name="payment_method" class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Non spécifié</option>
                        <option value="card" {{ old('payment_method', $invoice->payment_method) == 'card' ? 'selected' : '' }}>Carte bancaire</option>
                        <option value="mobile_money" {{ old('payment_method', $invoice->payment_method) == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                        <option value="bank_transfer" {{ old('payment_method', $invoice->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Virement bancaire</option>
                        <option value="cash" {{ old('payment_method', $invoice->payment_method) == 'cash' ? 'selected' : '' }}>Espèces</option>
                    </select>
                </div>
            </div>

            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                <textarea id="description" name="description" rows="3" class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Description de la facture...">{{ old('description', $invoice->description) }}</textarea>
            </div>
        </div>

        <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700 rounded-xl p-6">
            <h3 class="text-lg font-medium text-white mb-4">Notes et métadonnées</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-300 mb-2">Notes internes</label>
                    <textarea id="notes" name="notes" rows="3" class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Notes internes...">{{ old('notes', $invoice->notes) }}</textarea>
                </div>

                <div>
                    <label for="terms_conditions" class="block text-sm font-medium text-gray-300 mb-2">Conditions</label>
                    <textarea id="terms_conditions" name="terms_conditions" rows="3" class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Conditions de paiement...">{{ old('terms_conditions', $invoice->terms_conditions) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.invoices.index') }}" class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                Annuler
            </a>
            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-lg transition-all duration-200 hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection 