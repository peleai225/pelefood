<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PaymentSettingsController extends Controller
{
    /**
     * Afficher la page des paramètres de paiement
     */
    public function index()
    {
        $wavePaymentLink = config('app.wave_payment_link');
        
        return view('admin.payment-settings.index', compact('wavePaymentLink'));
    }

    /**
     * Mettre à jour les paramètres de paiement
     */
    public function update(Request $request)
    {
        $request->validate([
            'wave_payment_link' => 'required|url',
        ]);

        // Mettre à jour le fichier .env
        $this->updateEnvironmentFile('WAVE_PAYMENT_LINK', $request->wave_payment_link);
        
        // Vider le cache de configuration
        Cache::forget('config');
        
        return redirect()->route('admin.payment-settings.index')
            ->with('success', 'Paramètres de paiement mis à jour avec succès !');
    }

    /**
     * Mettre à jour le fichier .env
     */
    private function updateEnvironmentFile($key, $value)
    {
        $path = base_path('.env');
        
        if (file_exists($path)) {
            $content = file_get_contents($path);
            
            // Si la clé existe déjà, la mettre à jour
            if (strpos($content, $key . '=') !== false) {
                $content = preg_replace(
                    '/^' . $key . '=.*/m',
                    $key . '=' . $value,
                    $content
                );
            } else {
                // Sinon, ajouter la clé à la fin du fichier
                $content .= "\n" . $key . '=' . $value;
            }
            
            file_put_contents($path, $content);
        }
    }
}
