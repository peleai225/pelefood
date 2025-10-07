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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('video_url')->nullable(); // URL de la vidéo (YouTube, Vimeo, etc.)
            $table->string('video_file')->nullable(); // Fichier vidéo uploadé
            $table->string('thumbnail')->nullable(); // Image de prévisualisation
            $table->integer('duration')->nullable(); // Durée en secondes
            $table->string('quality')->default('HD'); // Qualité (HD, 4K, etc.)
            $table->string('language')->default('fr'); // Langue
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false); // Vidéo mise en avant
            $table->integer('sort_order')->default(0); // Ordre d'affichage
            $table->json('metadata')->nullable(); // Métadonnées supplémentaires
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
};
