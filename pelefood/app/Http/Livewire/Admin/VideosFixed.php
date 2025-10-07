<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Video;

class VideosFixed extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $filter = 'all';
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

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'video_url' => 'nullable|url',
        'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:102400',
        'thumbnail' => 'nullable|image|max:2048',
        'duration' => 'nullable|integer|min:0',
        'quality' => 'required|in:SD,HD,FHD,4K',
        'language' => 'required|string|max:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'nullable|integer|min:0'
    ];

    protected $messages = [
        'title.required' => 'Le titre de la vidéo est obligatoire.',
        'quality.required' => 'La qualité est obligatoire.',
        'language.required' => 'La langue est obligatoire.',
    ];

    public function mount()
    {
        // Pas de chargement de données complexes
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
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
        try {
            $video = Video::findOrFail($videoId);
            
            $this->modalTitle = 'Modifier la vidéo';
            $this->editingVideo = $video;
            
            $this->title = $video->title ?? '';
            $this->description = $video->description ?? '';
            $this->video_url = $video->video_url ?? '';
            $this->duration = $video->duration ?? 0;
            $this->quality = $video->quality ?? 'HD';
            $this->language = $video->language ?? 'fr';
            $this->is_active = $video->is_active ?? true;
            $this->is_featured = $video->is_featured ?? false;
            $this->sort_order = $video->sort_order ?? 0;
            
            $this->showModal = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors du chargement de la vidéo.');
        }
    }

    public function saveVideo()
    {
        try {
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
                $data['thumbnail'] = $this->thumbnail->store('thumbnails', 'public');
            }

            if ($this->editingVideo) {
                $this->editingVideo->update($data);
                session()->flash('message', 'Vidéo modifiée avec succès !');
            } else {
                Video::create($data);
                session()->flash('message', 'Vidéo créée avec succès !');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la sauvegarde : ' . $e->getMessage());
        }
    }

    public function deleteVideo($videoId)
    {
        try {
            Video::findOrFail($videoId)->delete();
            session()->flash('message', 'Vidéo supprimée avec succès !');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    public function toggleActive($videoId)
    {
        try {
            $video = Video::findOrFail($videoId);
            $video->update(['is_active' => !$video->is_active]);
            session()->flash('message', 'Statut de la vidéo modifié !');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la modification : ' . $e->getMessage());
        }
    }

    public function toggleFeatured($videoId)
    {
        try {
            $video = Video::findOrFail($videoId);
            $video->update(['is_featured' => !$video->is_featured]);
            session()->flash('message', 'Statut vedette modifié !');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la modification : ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->editingVideo = null;
        $this->resetForm();
    }

    public function resetForm()
    {
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

    public function render()
    {
        // Requête simple comme dans Products
        $query = Video::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filter === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filter === 'inactive') {
            $query->where('is_active', false);
        } elseif ($this->filter === 'featured') {
            $query->where('is_featured', true);
        }

        $query->orderBy($this->sortBy, $this->sortDirection);
        $videos = $query->paginate($this->perPage);

        return view('livewire.admin.videos-fixed', [
            'videos' => $videos
        ])->layout('layouts.super-admin-new-design');
    }
}
