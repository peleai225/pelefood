<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('payment_transactions', 'restaurant_id')) {
                $table->foreignId('restaurant_id')->nullable()->constrained()->onDelete('set null')->after('id');
            }
            if (!Schema::hasColumn('payment_transactions', 'subscription_id')) {
                $table->foreignId('subscription_id')->nullable()->constrained('restaurant_subscriptions')->onDelete('set null')->after('restaurant_id');
            }
            if (!Schema::hasColumn('payment_transactions', 'gateway_name')) {
                $table->string('gateway_name')->nullable()->after('subscription_id'); // 'wave', 'paystack', 'cash'
            }
            if (!Schema::hasColumn('payment_transactions', 'gateway_transaction_id')) {
                $table->string('gateway_transaction_id')->nullable()->after('gateway_name');
            }
            if (!Schema::hasColumn('payment_transactions', 'amount_before_fees')) {
                $table->decimal('amount_before_fees', 10, 2)->nullable()->after('amount');
            }
            if (!Schema::hasColumn('payment_transactions', 'fees_amount')) {
                $table->decimal('fees_amount', 10, 2)->nullable()->after('amount_before_fees');
            }
            if (!Schema::hasColumn('payment_transactions', 'restaurant_received_amount')) {
                $table->decimal('restaurant_received_amount', 10, 2)->nullable()->after('fees_amount');
            }
            if (!Schema::hasColumn('payment_transactions', 'webhook_data')) {
                $table->json('webhook_data')->nullable()->after('restaurant_received_amount');
            }
            if (!Schema::hasColumn('payment_transactions', 'is_subscription_payment')) {
                $table->boolean('is_subscription_payment')->default(false)->after('webhook_data');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_transactions', function (Blueprint $table) {
            $table->dropForeign(['restaurant_id', 'subscription_id']);
            $table->dropColumn([
                'restaurant_id', 'subscription_id', 'gateway_name', 'gateway_transaction_id',
                'amount_before_fees', 'fees_amount', 'restaurant_received_amount',
                'webhook_data', 'is_subscription_payment'
            ]);
        });
    }
};
