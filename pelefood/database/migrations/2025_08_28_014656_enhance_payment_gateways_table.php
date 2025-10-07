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
        Schema::table('payment_gateways', function (Blueprint $table) {
            if (!Schema::hasColumn('payment_gateways', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('name');
            }
            if (!Schema::hasColumn('payment_gateways', 'api_key')) {
                $table->string('api_key')->nullable()->after('is_active');
            }
            if (!Schema::hasColumn('payment_gateways', 'secret_key')) {
                $table->string('secret_key')->nullable()->after('api_key');
            }
            if (!Schema::hasColumn('payment_gateways', 'webhook_url')) {
                $table->string('webhook_url')->nullable()->after('secret_key');
            }
            if (!Schema::hasColumn('payment_gateways', 'fees_percentage')) {
                $table->decimal('fees_percentage', 5, 2)->default(0)->after('webhook_url');
            }
            if (!Schema::hasColumn('payment_gateways', 'fees_fixed')) {
                $table->decimal('fees_fixed', 10, 2)->default(0)->after('fees_percentage');
            }
            if (!Schema::hasColumn('payment_gateways', 'supported_currencies')) {
                $table->json('supported_currencies')->nullable()->after('fees_fixed');
            }
            if (!Schema::hasColumn('payment_gateways', 'config')) {
                $table->json('config')->nullable()->after('supported_currencies');
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
        Schema::table('payment_gateways', function (Blueprint $table) {
            $table->dropColumn([
                'is_active', 'api_key', 'secret_key', 'webhook_url',
                'fees_percentage', 'fees_fixed', 'supported_currencies', 'config'
            ]);
        });
    }
};
