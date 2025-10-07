<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
use Illuminate\Support\Str;

class RestaurantSettingController extends Controller
{
    public function index()
    {
        $restaurant = Auth::user()->restaurant;
        
        if (!$restaurant) {
            return redirect()->route('restaurant.dashboard')->with('error', 'Restaurant non trouvé');
        }
        
        return view('restaurant.settings.index', compact('restaurant'));
    }
    
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'nullable|string|max:255',
                'slug' => 'nullable|string|max:255|unique:restaurants,slug,' . Auth::user()->restaurant->id,
                'description' => 'nullable|string',
                'slogan' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string',
                'city' => 'nullable|string|max:255',
                'postal_code' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:255',
                'website' => 'nullable|url|max:255',
                'minimum_order' => 'nullable|numeric|min:0',
                'delivery_fee' => 'nullable|numeric|min:0',
                'delivery_radius' => 'nullable|integer|min:0',
                'preparation_time' => 'nullable|integer|min:0',
                'delivery_time' => 'nullable|integer|min:0',
                'opening_hours' => 'nullable|array',
                'delivery_zones' => 'nullable|array',
                'theme_colors' => 'nullable|array',
                'theme_colors.primary' => 'nullable|string|regex:/^#[0-9A-F]{6}$/i',
                'theme_colors.secondary' => 'nullable|string|regex:/^#[0-9A-F]{6}$/i',
                'theme_colors.accent' => 'nullable|string|regex:/^#[0-9A-F]{6}$/i',
                'theme_colors.text' => 'nullable|string|regex:/^#[0-9A-F]{6}$/i',
                'settings' => 'nullable|array',
            ]);
            
            $restaurant = Auth::user()->restaurant;
            
            if (!$restaurant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Restaurant non trouvé'
                ], 404);
            }
            
            // Préparer les données à mettre à jour
            $updateData = [];
            
            // Champs optionnels - seulement si non vides
            if ($request->has('name') && !empty($request->name)) $updateData['name'] = $request->name;
            if ($request->has('slug') && !empty($request->slug)) $updateData['slug'] = $request->slug;
            if ($request->has('description')) $updateData['description'] = $request->description;
            if ($request->has('slogan')) $updateData['slogan'] = $request->slogan;
            if ($request->has('postal_code')) $updateData['postal_code'] = $request->postal_code;
            if ($request->has('website')) $updateData['website'] = $request->website;
            
            // Champs requis - utiliser les valeurs existantes si vides
            if ($request->has('phone')) {
                $updateData['phone'] = !empty($request->phone) ? $request->phone : $restaurant->phone;
            }
            if ($request->has('email')) {
                $updateData['email'] = !empty($request->email) ? $request->email : $restaurant->email;
            }
            if ($request->has('address')) {
                $updateData['address'] = !empty($request->address) ? $request->address : $restaurant->address;
            }
            if ($request->has('city')) {
                $updateData['city'] = !empty($request->city) ? $request->city : $restaurant->city;
            }
            if ($request->has('country')) {
                $updateData['country'] = !empty($request->country) ? $request->country : $restaurant->country;
            }
            
            // Champs numériques
            if ($request->has('minimum_order') && $request->minimum_order !== null) $updateData['minimum_order'] = $request->minimum_order;
            if ($request->has('delivery_fee') && $request->delivery_fee !== null) $updateData['delivery_fee'] = $request->delivery_fee;
            if ($request->has('delivery_radius') && $request->delivery_radius !== null) $updateData['delivery_radius'] = $request->delivery_radius;
            if ($request->has('preparation_time') && $request->preparation_time !== null) $updateData['preparation_time'] = $request->preparation_time;
            if ($request->has('delivery_time') && $request->delivery_time !== null) $updateData['delivery_time'] = $request->delivery_time;
            
            // Champs JSON
            if ($request->has('opening_hours') && is_array($request->opening_hours)) $updateData['opening_hours'] = $request->opening_hours;
            if ($request->has('delivery_zones') && is_array($request->delivery_zones)) $updateData['delivery_zones'] = $request->delivery_zones;
            if ($request->has('theme_colors') && is_array($request->theme_colors)) $updateData['theme_colors'] = $request->theme_colors;
            if ($request->has('settings') && is_array($request->settings)) $updateData['settings'] = $request->settings;
            
            // Mettre à jour seulement si on a des données
            if (!empty($updateData)) {
                $restaurant->update($updateData);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Paramètres sauvegardés avec succès !',
                'restaurant' => $restaurant->fresh()
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la sauvegarde: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);
        
        $restaurant = Auth::user()->restaurant;
        
        // Supprimer l'ancien logo s'il existe
        if ($restaurant->logo && Storage::disk('public')->exists($restaurant->logo)) {
            Storage::disk('public')->delete($restaurant->logo);
        }
        
        // Sauvegarder le nouveau logo
        $logoPath = $request->file('logo')->store('restaurants/' . $restaurant->id . '/logos', 'public');
        
        $restaurant->update(['logo' => $logoPath]);
        
        return response()->json([
            'success' => true,
            'message' => 'Logo mis à jour avec succès !',
            'logo_url' => Storage::disk('public')->url($logoPath)
        ]);
    }
    
    public function uploadCover(Request $request)
    {
        $request->validate([
            'cover_image' => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ]);
        
        $restaurant = Auth::user()->restaurant;
        
        // Supprimer l'ancienne image de couverture
        if ($restaurant->cover_image && Storage::disk('public')->exists($restaurant->cover_image)) {
            Storage::disk('public')->delete($restaurant->cover_image);
        }
        
        // Sauvegarder la nouvelle image
        $coverPath = $request->file('cover_image')->store('restaurants/' . $restaurant->id . '/covers', 'public');
        
        $restaurant->update(['cover_image' => $coverPath]);
        
        return response()->json([
            'success' => true,
            'message' => 'Image de couverture mise à jour avec succès !',
            'cover_url' => Storage::disk('public')->url($coverPath)
        ]);
    }
    
    public function uploadGallery(Request $request)
    {
        $request->validate([
            'gallery_images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);
        
        $restaurant = Auth::user()->restaurant;
        $uploadedImages = [];
        
        foreach ($request->file('gallery_images') as $image) {
            $imagePath = $image->store('restaurants/' . $restaurant->id . '/gallery', 'public');
            $uploadedImages[] = $imagePath;
        }
        
        // Ajouter aux images existantes ou remplacer
        $existingGallery = $restaurant->gallery_images ?? [];
        $newGallery = array_merge($existingGallery, $uploadedImages);
        
        // Limiter à 10 images maximum
        if (count($newGallery) > 10) {
            $newGallery = array_slice($newGallery, -10);
        }
        
        $restaurant->update(['gallery_images' => $newGallery]);
        
        return response()->json([
            'success' => true,
            'message' => count($uploadedImages) . ' image(s) ajoutée(s) à la galerie !',
            'gallery_images' => $newGallery
        ]);
    }
    
    public function deleteGalleryImage(Request $request, $imageIndex)
    {
        $restaurant = Auth::user()->restaurant;
        $gallery = $restaurant->gallery_images ?? [];
        
        if (isset($gallery[$imageIndex])) {
            $imagePath = $gallery[$imageIndex];
            
            // Supprimer le fichier
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            
            // Retirer de la galerie
            unset($gallery[$imageIndex]);
            $gallery = array_values($gallery); // Réindexer
            
            $restaurant->update(['gallery_images' => $gallery]);
            
            return response()->json([
                'success' => true,
                'message' => 'Image supprimée de la galerie !',
                'gallery_images' => $gallery
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Image non trouvée !'
        ], 404);
    }
    
    public function updateTheme(Request $request)
    {
        $request->validate([
            'theme_colors' => 'required|array',
            'theme_colors.primary' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
            'theme_colors.secondary' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
            'theme_colors.accent' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
            'theme_colors.text' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
        ]);
        
        $restaurant = Auth::user()->restaurant;
        $restaurant->update(['theme_colors' => $request->theme_colors]);
        
        return response()->json([
            'success' => true,
            'message' => 'Thème mis à jour avec succès !',
            'theme_colors' => $request->theme_colors
        ]);
    }
}
