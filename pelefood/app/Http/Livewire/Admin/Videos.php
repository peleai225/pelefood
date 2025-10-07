<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Video;
use Livewire\WithFileUploads;

class Videos extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $filter = 'all'; // all, active, inactive
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 12;
    
    // Modal pour créer/éditer une vidéo
    public $showModal = false;
    public $modalTitle = '';
    public $editingVideo = null;
    
    // Champs du formulaire
    public $title = '';
    public $description = '';
    public $video_url = '';
    public $video_file;
    public $thumbnail;
    public $duration = 0;
    public $quality = 'HD';
    public $language = 'fr';
    public $is_active = true;
    public $is_featured = false;
    public $sort_order = 0;

    // Statistiques
    public $stats = [];

    protected $listeners = ['videoCreated' => 'loadStats', 'videoUpdated' => 'loadStats', 'videoDeleted' => 'loadStats'];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'video_url' => 'nullable|url',
        'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:102400', // 100MB max
        'thumbnail' => 'nullable|image|max:2048',
        'duration' => 'nullable|integer|min:0',
        'quality' => 'required|in:SD,HD,FHD,4K',
        'language' => 'required|string|max:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'nullable|integer|min:0'
    ];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->stats = [
            'total_videos' => Video::count(),
            'published_videos' => Video::where('is_active', true)->count(),
            'draft_videos' => Video::where('is_active', false)->count(),
            'total_views' => Video::get()->sum(function($video) {
                return $video->metadata['views'] ?? 0;
            }),
            'total_likes' => Video::get()->sum(function($video) {
                return $video->metadata['likes'] ?? 0;
            }),
            'avg_duration' => Video::avg('duration') ?? 0,
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function updatingSortDirection()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function createVideo()
    {
        $this->resetForm();
        $this->modalTitle = 'Créer une nouvelle vidéo';
        $this->showModal = true;
    }

    public function editVideo($videoId)
    {
        $video = Video::findOrFail($videoId);
        $this->editingVideo = $video;
        $this->title = $video->title;
        $this->description = $video->description;
        $this->video_url = $video->video_url;
        $this->duration = $video->duration;
        $this->quality = $video->quality;
        $this->language = $video->language;
        $this->is_active = $video->is_active;
        $this->is_featured = $video->is_featured;
        $this->sort_order = $video->sort_order;
        
        $this->modalTitle = 'Modifier la vidéo';
        $this->showModal = true;
    }

    public function saveVideo()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'video_url' => $this->video_url,
            'duration' => $this->duration,
            'quality' => $this->quality,
            'language' => $this->language,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'sort_order' => $this->sort_order,
        ];

        // Gestion du fichier vidéo
        if ($this->video_file) {
            $data['video_file'] = $this->video_file->store('videos', 'public');
        }

        // Gestion de la miniature
        if ($this->thumbnail) {
            $data['thumbnail'] = $this->thumbnail->store('video-thumbnails', 'public');
        }

        if ($this->editingVideo) {
            $this->editingVideo->update($data);
            $this->emit('videoUpdated');
            $this->emit('showNotification', 'Vidéo mise à jour avec succès', 'success');
        } else {
            Video::create($data);
            $this->emit('videoCreated');
            $this->emit('showNotification', 'Vidéo créée avec succès', 'success');
        }

        $this->closeModal();
        $this->loadStats();
    }

    public function deleteVideo($videoId)
    {
        $video = Video::findOrFail($videoId);
        $video->delete();
        
        $this->emit('videoDeleted');
        $this->emit('showNotification', 'Vidéo supprimée avec succès', 'success');
        $this->loadStats();
    }

    public function toggleActive($videoId)
    {
        $video = Video::findOrFail($videoId);
        $video->update(['is_active' => !$video->is_active]);
        
        $this->emit('showNotification', 'Statut de la vidéo mis à jour', 'success');
        $this->loadStats();
    }

    public function toggleFeatured($videoId)
    {
        $video = Video::findOrFail($videoId);
        $video->update(['is_featured' => !$video->is_featured]);
        
        $this->emit('showNotification', 'Vidéo mise en vedette mise à jour', 'success');
        $this->loadStats();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingVideo = null;
        $this->title = '';
        $this->description = '';
        $this->video_url = '';
        $this->video_file = null;
        $this->thumbnail = null;
        $this->duration = 0;
        $this->quality = 'HD';
        $this->language = 'fr';
        $this->is_active = true;
        $this->is_featured = false;
        $this->sort_order = 0;
        $this->resetErrorBag();
    }

    public function getVideosProperty()
    {
        $query = Video::query();

        // Filtre par recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Filtre par statut
        if ($this->filter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filter === 'inactive') {
            $query->where('is_active', false);
        }

        // Tri
        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.videos', [
            'videos' => $this->videos
        ])->layout('layouts.super-admin-new-design');
    }
}