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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Stripe, PayPal, Orange Money, MTN Money, etc.
            $table->string('type'); // card, mobile_money, bank_transfer, cash
            $table->string('provider'); // stripe, paypal, orange, mtn, moov, etc.
            $table->json('credentials')->nullable(); // Clés API, configurations
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->decimal('transaction_fee', 5, 2)->default(0); // Pourcentage de frais
            $table->decimal('fixed_fee', 10, 2)->default(0); // Frais fixes
            $table->json('settings')->nullable(); // Paramètres spécifiques
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Un restaurant ne peut avoir qu'une méthode par type active
            $table->unique(['restaurant_id', 'type', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
