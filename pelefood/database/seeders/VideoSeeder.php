<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Video;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Video::create([
            'title' => 'Découvrez PeleFood en action',
            'description' => 'Regardez notre vidéo de démonstration pour voir comment PeleFood peut transformer votre restaurant et augmenter vos revenus',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // URL d'exemple
            'thumbnail' => null,
            'duration' => 204, // 3:24 en secondes
            'quality' => 'HD',
            'language' => 'fr',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 1,
            'metadata' => [
                'platform' => 'youtube',
                'views' => 0,
                'likes' => 0
            ]
        ]);

        Video::create([
            'title' => 'Tutoriel PeleFood - Gestion des commandes',
            'description' => 'Apprenez à gérer efficacement vos commandes avec PeleFood',
            'video_url' => null,
            'video_file' => null,
            'thumbnail' => null,
            'duration' => 180, // 3:00 en secondes
            'quality' => 'Full HD',
            'language' => 'fr',
            'is_active' => true,
            'is_featured' => false,
            'sort_order' => 2,
            'metadata' => [
                'category' => 'tutorial',
                'difficulty' => 'beginner'
            ]
        ]);
    }
}
