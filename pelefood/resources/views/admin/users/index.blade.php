@extends('layouts.super-admin-new-design')

@section('title', 'Gestion des Utilisateurs - PeleFood')
@section('description', 'Gérer tous les utilisateurs de la plateforme')

@section('breadcrumb')
<li>
    <div class="flex items-center">
        <i data-lucide="chevron-right" class="h-4 w-4 text-muted-foreground mx-2"></i>
        <span class="text-sm font-medium text-foreground">Utilisateurs</span>
    </div>
</li>
@endsection

@section('content')
<div class="space-y-8">
    <!-- En-tête -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-foreground">Gestion des Utilisateurs</h1>
            <p class="mt-2 text-lg text-muted-foreground">Gérer tous les utilisateurs de la plateforme PeleFood</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-primary-foreground rounded-lg hover:bg-primary/90 transition-colors">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Ajouter un utilisateur
            </a>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="rounded-xl border bg-card text-card-foreground shadow">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-muted-foreground">Rechercher</label>
                    <input type="text" id="search" placeholder="Nom, email..." class="mt-1 block w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" />
                </div>
                <div>
                    <label for="role" class="block text-sm font-medium text-muted-foreground">Rôle</label>
                    <select id="role" class="mt-1 block w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                        <option value="">Tous les rôles</option>
                        <option value="admin">Administrateur</option>
                        <option value="super_admin">Super Admin</option>
                        <option value="restaurant">Restaurant</option>
                        <option value="customer">Client</option>
                        <option value="driver">Livreur</option>
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-muted-foreground">Statut</label>
                    <select id="status" class="mt-1 block w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                        <option value="">Tous les statuts</option>
                        <option value="active">Actif</option>
                        <option value="inactive">Inactif</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="button" class="w-full inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                        <i data-lucide="search" class="w-4 h-4 mr-2"></i>
                        Filtrer
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Total</p>
                        <p class="text-2xl font-bold text-foreground">{{ $users->total() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="users" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Restaurants</p>
                        <p class="text-2xl font-bold text-foreground">{{ $users->where('role', 'restaurant')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="building-2" class="w-6 h-6 text-orange-600 dark:text-orange-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Clients</p>
                        <p class="text-2xl font-bold text-foreground">{{ $users->where('role', 'customer')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="user" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Livreurs</p>
                        <p class="text-2xl font-bold text-foreground">{{ $users->where('role', 'driver')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="truck" class="w-6 h-6 text-purple-600 dark:text-purple-400"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des utilisateurs -->
    <div class="rounded-xl border bg-card text-card-foreground shadow">
        <div class="flex flex-col space-y-1.5 p-6">
            <h3 class="text-lg font-semibold text-foreground">Liste des utilisateurs</h3>
            <p class="text-sm text-muted-foreground">{{ $users->total() }} utilisateur(s) au total</p>
        </div>
        <div class="p-6 pt-0">
            <div class="relative w-full overflow-auto">
                <table class="w-full caption-bottom text-sm">
                    <thead class="[&_tr]:border-b">
                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">Utilisateur</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">Rôle</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">Restaurant</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">Statut</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">Inscrit le</th>
                            <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="[&_tr:last-child]:border-0">
                    @forelse($users as $user)
                    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                        <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-white">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-foreground">{{ $user->name }}</p>
                                    <p class="text-sm text-muted-foreground">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                            @php
                                $badgeClass = match($user->role) {
                                    'super_admin' => 'inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-destructive text-destructive-foreground hover:bg-destructive/80',
                                    'admin' => 'inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80',
                                    default => 'inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-primary text-primary-foreground hover:bg-primary/80'
                                };
                            @endphp
                            <span class="{{ $badgeClass }}">
                                {{ ucfirst(str_replace('_', ' ', $user->role ?? 'customer')) }}
                            </span>
                        </td>
                        <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                            @if($user->restaurant)
                                <div class="flex items-center space-x-2">
                                    <i data-lucide="building-2" class="w-4 h-4 text-muted-foreground"></i>
                                    <span class="text-sm text-foreground">{{ $user->restaurant->name }}</span>
                                </div>
                            @else
                                <span class="text-sm text-muted-foreground">-</span>
                            @endif
                        </td>
                        <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                            <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                Actif
                            </span>
                        </td>
                        <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                            <span class="text-sm text-muted-foreground">{{ $user->created_at->format('d/m/Y') }}</span>
                        </td>
                        <td class="p-4 align-middle text-right [&:has([role=checkbox])]:pr-0">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-muted-foreground hover:text-foreground hover:bg-accent rounded-lg transition-colors">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-muted-foreground hover:text-foreground hover:bg-accent rounded-lg transition-colors" title="Voir/Modifier">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <button class="p-2 text-muted-foreground hover:text-destructive hover:bg-destructive/10 rounded-lg transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                        <td colspan="6" class="p-4 align-middle text-center py-8 [&:has([role=checkbox])]:pr-0">
                            <div class="flex flex-col items-center space-y-2">
                                <i data-lucide="users" class="w-12 h-12 text-muted-foreground"></i>
                                <p class="text-muted-foreground">Aucun utilisateur trouvé</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
            <div class="mt-6 flex items-center justify-between">
                <div class="text-sm text-muted-foreground">
                    Affichage de {{ $users->firstItem() }} à {{ $users->lastItem() }} sur {{ $users->total() }} résultats
                </div>
                <div class="flex items-center space-x-2">
                    {{ $users->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection