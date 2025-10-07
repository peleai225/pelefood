<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FirebaseController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin');
        $this->firebaseService = $firebaseService;
    }

    /**
     * Afficher le statut Firebase
     */
    public function status()
    {
        return view('admin.dashboard.firebase-status');
    }

    /**
     * Tester la connectivité Firebase
     */
    public function testConnectivity(Request $request)
    {
        try {
            $isConnected = $this->firebaseService->checkConnectivity();
            
            if ($isConnected) {
                Log::info('Firebase connectivity test successful');
                return response()->json([
                    'success' => true,
                    'message' => 'Connexion Firebase réussie'
                ]);
            } else {
                Log::error('Firebase connectivity test failed');
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de se connecter à Firebase'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Firebase connectivity test error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du test de connexion: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Tester l'envoi de notification
     */
    public function testNotification(Request $request)
    {
        try {
            $success = $this->firebaseService->sendSystemNotification(
                'Test PeleFood',
                'Ceci est un test de notification Firebase pour PeleFood',
                ['test' => true, 'timestamp' => now()->toISOString()]
            );

            if ($success) {
                Log::info('Firebase notification test successful');
                return response()->json([
                    'success' => true,
                    'message' => 'Notification Firebase envoyée avec succès'
                ]);
            } else {
                Log::error('Firebase notification test failed');
                return response()->json([
                    'success' => false,
                    'message' => 'Échec de l\'envoi de notification'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Firebase notification test error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du test de notification: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Tester la base de données
     */
    public function testDatabase(Request $request)
    {
        try {
            // Test d'écriture dans la base de données temps réel
            $testData = [
                'test' => true,
                'timestamp' => now()->toISOString(),
                'message' => 'Test PeleFood Firebase'
            ];

            $success = $this->firebaseService->updateRealTimeStats($testData);

            if ($success) {
                // Test de lecture
                $stats = $this->firebaseService->getRealTimeStats();
                
                Log::info('Firebase database test successful', ['stats' => $stats]);
                return response()->json([
                    'success' => true,
                    'message' => 'Test de base de données Firebase réussi',
                    'data' => $stats
                ]);
            } else {
                Log::error('Firebase database test failed');
                return response()->json([
                    'success' => false,
                    'message' => 'Échec du test de base de données'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Firebase database test error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du test de base de données: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Obtenir les statistiques Firebase
     */
    public function getStats(Request $request)
    {
        try {
            $restaurantId = $request->get('restaurant_id');
            $stats = $this->firebaseService->getRealTimeStats($restaurantId);

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            Log::error('Firebase get stats error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des statistiques'
            ]);
        }
    }

    /**
     * Mettre à jour les statistiques
     */
    public function updateStats(Request $request)
    {
        try {
            $data = $request->validate([
                'data' => 'required|array',
                'restaurant_id' => 'nullable|integer'
            ]);

            $success = $this->firebaseService->updateRealTimeStats(
                $data['data'],
                $data['restaurant_id'] ?? null
            );

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Statistiques mises à jour avec succès'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Échec de la mise à jour des statistiques'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Firebase update stats error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour des statistiques'
            ]);
        }
    }
} 