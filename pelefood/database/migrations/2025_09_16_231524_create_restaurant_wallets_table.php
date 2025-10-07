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
        Schema::create('restaurant_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->decimal('balance', 15, 2)->default(0)->comment('Solde disponible');
            $table->decimal('pending_balance', 15, 2)->default(0)->comment('Solde en attente');
            $table->decimal('total_earnings', 15, 2)->default(0)->comment('Total des gains');
            $table->decimal('total_withdrawals', 15, 2)->default(0)->comment('Total des retraits');
            $table->decimal('total_commission', 15, 2)->default(0)->comment('Total des commissions');
            $table->string('currency', 3)->default('XOF');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_transaction_at')->nullable();
            $table->timestamps();

            $table->unique('restaurant_id');
            $table->index(['restaurant_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_wallets');
    }
};