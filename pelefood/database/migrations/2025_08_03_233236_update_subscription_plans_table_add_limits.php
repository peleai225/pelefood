<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            // Limites par plan (ajouter seulement si elles n'existent pas)
            if (!Schema::hasColumn('subscription_plans', 'max_categories')) {
                $table->integer('max_categories')->nullable()->after('max_products');
            }
            if (!Schema::hasColumn('subscription_plans', 'max_restaurants')) {
                $table->integer('max_restaurants')->nullable()->after('max_categories');
            }
            
            // Fonctionnalités disponibles (ajouter seulement si elles n'existent pas)
            if (!Schema::hasColumn('subscription_plans', 'allows_customization')) {
                $table->boolean('allows_customization')->default(false)->after('max_restaurants');
            }
            if (!Schema::hasColumn('subscription_plans', 'allows_analytics')) {
                $table->boolean('allows_analytics')->default(false)->after('allows_customization');
            }
            if (!Schema::hasColumn('subscription_plans', 'allows_api')) {
                $table->boolean('allows_api')->default(false)->after('allows_analytics');
            }
            if (!Schema::hasColumn('subscription_plans', 'allows_export')) {
                $table->boolean('allows_export')->default(false)->after('allows_api');
            }
            if (!Schema::hasColumn('subscription_plans', 'allows_integrations')) {
                $table->boolean('allows_integrations')->default(false)->after('allows_export');
            }
            
            // Support (ajouter seulement si elle n'existe pas)
            if (!Schema::hasColumn('subscription_plans', 'support_level')) {
                $table->string('support_level')->default('email')->after('allows_integrations');
            }
            
            // Description détaillée (ajouter seulement si elle n'existe pas)
            if (!Schema::hasColumn('subscription_plans', 'description')) {
                $table->text('description')->nullable()->after('trial_days');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn([
                'max_products',
                'max_categories', 
                'max_restaurants',
                'allows_customization',
                'allows_analytics',
                'allows_api',
                'allows_export',
                'allows_integrations',
                'support_level',
                'trial_days',
                'description',
                'features'
            ]);
        });
    }
};
