<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class OptimizeAdminPerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimise les performances du backoffice administrateur';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🚀 Optimisation des performances du backoffice administrateur...');

        // Nettoyer le cache
        $this->info('🧹 Nettoyage du cache...');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        // Optimiser la configuration
        $this->info('⚙️ Optimisation de la configuration...');
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');

        // Précharger les données fréquemment utilisées
        $this->info('📊 Préchargement des données...');
        $this->preloadAdminData();

        // Optimiser la base de données
        $this->info('🗄️ Optimisation de la base de données...');
        $this->optimizeDatabase();

        $this->info('✅ Optimisation terminée !');
        $this->info('Le backoffice administrateur devrait maintenant être plus rapide.');

        return 0;
    }

    private function preloadAdminData()
    {
        // Précharger les statistiques du dashboard
        Cache::remember('admin_dashboard_stats', 300, function () {
            return [
                'total_restaurants' => \App\Models\Restaurant::count(),
                'active_restaurants' => \App\Models\Restaurant::where('is_active', true)->count(),
                'total_orders' => \App\Models\Order::count(),
                'total_revenue' => \App\Models\Order::where('payment_status', 'paid')->sum('total_amount') ?? 0,
                'total_users' => \App\Models\User::count(),
                'total_tenants' => \App\Models\Tenant::count(),
                'pending_orders' => \App\Models\Order::where('status', 'pending')->count(),
                'completed_orders' => \App\Models\Order::where('status', 'completed')->count(),
            ];
        });

        // Précharger les plans d'abonnement
        Cache::remember('subscription_plans_all', 300, function () {
            return \App\Models\SubscriptionPlan::all();
        });

        // Précharger les restaurants pour les filtres
        Cache::remember('restaurants_for_orders', 300, function () {
            return \App\Models\Restaurant::select('id', 'name')->get();
        });

        $this->info('   - Données préchargées dans le cache');
    }

    private function optimizeDatabase()
    {
        // Analyser les tables pour optimiser les requêtes
        $tables = ['restaurants', 'orders', 'users', 'tenants', 'subscription_plans'];
        
        foreach ($tables as $table) {
            try {
                DB::statement("ANALYZE TABLE {$table}");
                $this->info("   - Table {$table} analysée");
            } catch (\Exception $e) {
                $this->warn("   - Impossible d'analyser la table {$table}: " . $e->getMessage());
            }
        }
    }
}
