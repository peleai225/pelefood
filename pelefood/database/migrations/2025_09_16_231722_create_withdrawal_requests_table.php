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
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('request_number')->unique()->comment('Numéro de demande');
            $table->decimal('amount', 15, 2)->comment('Montant demandé');
            $table->decimal('fees', 15, 2)->default(500)->comment('Frais de retrait');
            $table->decimal('net_amount', 15, 2)->comment('Montant net après frais');
            $table->enum('status', ['pending', 'approved', 'rejected', 'processed', 'cancelled'])->default('pending');
            $table->string('payment_method')->default('bank_transfer')->comment('Méthode de paiement');
            $table->json('bank_details')->nullable()->comment('Détails bancaires');
            $table->text('rejection_reason')->nullable()->comment('Raison du rejet');
            $table->text('admin_notes')->nullable()->comment('Notes de l\'admin');
            $table->timestamp('processed_at')->nullable()->comment('Date de traitement');
            $table->timestamp('approved_at')->nullable()->comment('Date d\'approbation');
            $table->foreignId('processed_by')->nullable()->constrained('users')->comment('Admin qui a traité');
            $table->timestamps();

            $table->index(['restaurant_id', 'status']);
            $table->index(['status', 'created_at']);
            $table->index('request_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
    }
};