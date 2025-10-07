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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_method_id')->constrained()->onDelete('cascade');
            $table->string('transaction_id')->unique(); // ID unique de la transaction
            $table->string('external_id')->nullable(); // ID externe (Stripe, PayPal, etc.)
            $table->decimal('amount', 10, 2);
            $table->decimal('fee_amount', 10, 2)->default(0);
            $table->string('currency', 3)->default('XOF');
            $table->string('status'); // pending, processing, completed, failed, cancelled, refunded
            $table->string('payment_method_type'); // card, mobile_money, cash, etc.
            $table->string('provider'); // stripe, paypal, orange, mtn, etc.
            $table->json('payment_details')->nullable(); // Détails du paiement
            $table->json('metadata')->nullable(); // Métadonnées supplémentaires
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamps();
            
            // Index pour les performances
            $table->index(['restaurant_id', 'status']);
            $table->index(['order_id']);
            $table->index(['transaction_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
