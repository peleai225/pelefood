<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'video_url',
        'video_file',
        'thumbnail',
        'duration',
        'quality',
        'language',
        'is_active',
        'is_featured',
        'sort_order',
        'metadata',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'metadata' => 'array',
    ];

    /**
     * Scope pour les vidéos actives
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour les vidéos mises en avant
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope pour trier par ordre
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    /**
     * Obtenir la durée formatée
     */
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration) {
            return null;
        }

        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;

        return sprintf('%d:%02d', $minutes, $seconds);
    }

    /**
     * Obtenir l'URL de la vidéo (priorité à l'URL externe)
     */
    public function getVideoSourceAttribute()
    {
        return $this->video_url ?: $this->video_file;
    }

    /**
     * Vérifier si c'est une vidéo YouTube
     */
    public function isYouTube()
    {
        return $this->video_url && str_contains($this->video_url, 'youtube.com');
    }

    /**
     * Vérifier si c'est une vidéo Vimeo
     */
    public function isVimeo()
    {
        return $this->video_url && str_contains($this->video_url, 'vimeo.com');
    }

    /**
     * Obtenir l'ID YouTube
     */
    public function getYouTubeId()
    {
        if (!$this->isYouTube()) {
            return null;
        }

        // Support pour différents formats d'URL YouTube
        $patterns = [
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/',
            '/youtube\.com\/embed\/([^&\n?#]+)/',
            '/youtube\.com\/v\/([^&\n?#]+)/'
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $this->video_url, $matches)) {
                return $matches[1];
            }
        }
        
        return null;
    }

    /**
     * Obtenir l'URL d'embed YouTube sécurisée
     */
    public function getYouTubeEmbedUrl()
    {
        $videoId = $this->getYouTubeId();
        if (!$videoId) {
            return null;
        }

        // Paramètres optimisés pour l'embed
        $params = [
            'autoplay' => 0,
            'rel' => 0,
            'modestbranding' => 1,
            'showinfo' => 0,
            'controls' => 1,
            'enablejsapi' => 1,
            'origin' => request()->getSchemeAndHttpHost(),
            'widget_referrer' => request()->getSchemeAndHttpHost()
        ];

        return 'https://www.youtube.com/embed/' . $videoId . '?' . http_build_query($params);
    }

    /**
     * Obtenir l'ID Vimeo
     */
    public function getVimeoId()
    {
        if (!$this->isVimeo()) {
            return null;
        }

        preg_match('/vimeo\.com\/(\d+)/', $this->video_url, $matches);
        return $matches[1] ?? null;
    }
}
