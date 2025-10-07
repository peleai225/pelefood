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
        Schema::table('restaurants', function (Blueprint $table) {
            // Champs d'abonnement
            $table->foreignId('subscription_plan_id')->nullable()->after('tenant_id')->constrained('subscription_plans');
            $table->timestamp('subscription_started_at')->nullable()->after('subscription_plan_id');
            $table->timestamp('subscription_expires_at')->nullable()->after('subscription_started_at');
            $table->string('subscription_status')->default('inactive')->after('subscription_expires_at'); // inactive, active, expired, cancelled
            $table->string('payment_method')->nullable()->after('subscription_status'); // stripe, paypal, etc.
            $table->string('payment_status')->default('pending')->after('payment_method'); // pending, completed, failed
            $table->decimal('subscription_amount', 10, 2)->nullable()->after('payment_status');
            $table->string('subscription_currency')->default('EUR')->after('subscription_amount');
            
            // Informations de facturation
            $table->string('billing_email')->nullable()->after('subscription_currency');
            $table->string('billing_name')->nullable()->after('billing_email');
            $table->text('billing_address')->nullable()->after('billing_name');
            
            // Métadonnées
            $table->json('subscription_metadata')->nullable()->after('billing_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropForeign(['subscription_plan_id']);
            $table->dropColumn([
                'subscription_plan_id',
                'subscription_started_at',
                'subscription_expires_at',
                'subscription_status',
                'payment_method',
                'payment_status',
                'subscription_amount',
                'subscription_currency',
                'billing_email',
                'billing_name',
                'billing_address',
                'subscription_metadata'
            ]);
        });
    }
};
