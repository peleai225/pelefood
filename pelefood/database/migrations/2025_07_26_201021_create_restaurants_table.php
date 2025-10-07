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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('slogan')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->text('address');
            $table->string('city');
            $table->string('postal_code')->nullable();
            $table->string('country');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->json('opening_hours')->nullable();
            $table->boolean('is_open')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->enum('delivery_type', ['delivery', 'pickup', 'both'])->default('both');
            $table->decimal('delivery_fee', 8, 2)->default(0);
            $table->integer('delivery_time')->nullable(); // en minutes
            $table->integer('delivery_radius')->default(10);
            $table->integer('preparation_time')->default(30);
            $table->decimal('minimum_order', 8, 2)->default(0);
            $table->json('delivery_zones')->nullable();
            $table->json('payment_methods')->nullable();
            $table->json('theme_colors')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('website_url')->nullable();
            $table->string('website')->nullable();
            $table->string('currency', 3)->default('XOF');
            $table->string('timezone')->default('Africa/Abidjan');
            $table->string('language', 2)->default('fr');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
};
