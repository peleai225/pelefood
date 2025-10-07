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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('tenant_id')->nullable()->constrained()->onDelete('set null');
            $table->string('subject');
            $table->text('content');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->enum('type', ['general', 'support', 'billing', 'technical'])->default('general');
            $table->boolean('is_read')->default(false);
            $table->boolean('is_urgent')->default(false);
            $table->foreignId('parent_id')->nullable()->constrained('messages')->onDelete('cascade');
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index(['user_id', 'is_read']);
            $table->index(['tenant_id', 'is_read']);
            $table->index(['priority', 'created_at']);
            $table->index(['type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
