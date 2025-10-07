<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Afficher la liste des vidéos
     */
    public function index()
    {
        $videos = Video::ordered()->paginate(10);
        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admin.videos.create');
    }

    /**
     * Enregistrer une nouvelle vidéo
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400', // 100MB max
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duration' => 'nullable|integer|min:1',
            'quality' => 'required|string|in:SD,HD,Full HD,4K',
            'language' => 'required|string|max:10',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();

        // Gérer l'upload du fichier vidéo
        if ($request->hasFile('video_file')) {
            $data['video_file'] = $request->file('video_file')->store('videos', 'public');
        }

        // Gérer l'upload de la miniature
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('video-thumbnails', 'public');
        }

        // Convertir les checkboxes
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        Video::create($data);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Vidéo créée avec succès !');
    }

    /**
     * Afficher une vidéo
     */
    public function show(Video $video)
    {
        return view('admin.videos.show', compact('video'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    /**
     * Mettre à jour une vidéo
     */
    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duration' => 'nullable|integer|min:1',
            'quality' => 'required|string|in:SD,HD,Full HD,4K',
            'language' => 'required|string|max:10',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();

        // Gérer l'upload du nouveau fichier vidéo
        if ($request->hasFile('video_file')) {
            // Supprimer l'ancien fichier
            if ($video->video_file) {
                Storage::disk('public')->delete($video->video_file);
            }
            $data['video_file'] = $request->file('video_file')->store('videos', 'public');
        }

        // Gérer l'upload de la nouvelle miniature
        if ($request->hasFile('thumbnail')) {
            // Supprimer l'ancienne miniature
            if ($video->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('video-thumbnails', 'public');
        }

        // Convertir les checkboxes
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        $video->update($data);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Vidéo mise à jour avec succès !');
    }

    /**
     * Supprimer une vidéo
     */
    public function destroy(Video $video)
    {
        // Supprimer les fichiers associés
        if ($video->video_file) {
            Storage::disk('public')->delete($video->video_file);
        }
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }

        $video->delete();

        return redirect()->route('admin.videos.index')
            ->with('success', 'Vidéo supprimée avec succès !');
    }

    /**
     * Toggle le statut actif
     */
    public function toggleActive(Video $video)
    {
        $video->update(['is_active' => !$video->is_active]);
        
        return response()->json([
            'success' => true,
            'is_active' => $video->is_active
        ]);
    }

    /**
     * Toggle le statut featured
     */
    public function toggleFeatured(Video $video)
    {
        $video->update(['is_featured' => !$video->is_featured]);
        
        return response()->json([
            'success' => true,
            'is_featured' => $video->is_featured
        ]);
    }
}
