<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
{
    /**
     * Display the settings index page.
     */
    public function index()
    {
        $settings = $this->getAllSettings();
        
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Display general settings.
     */
    public function general()
    {
        $settings = [
            'app_name' => config('app.name'),
            'app_url' => config('app.url'),
            'app_locale' => config('app.locale'),
            'app_timezone' => config('app.timezone'),
            'app_debug' => config('app.debug'),
            'maintenance_mode' => app()->isDownForMaintenance(),
        ];

        return view('admin.settings.general', compact('settings'));
    }

    /**
     * Update general settings.
     */
    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_url' => 'required|url',
            'app_locale' => 'required|string|max:10',
            'app_timezone' => 'required|string|max:50',
            'app_debug' => 'boolean',
            'maintenance_mode' => 'boolean',
        ]);

        // Mettre à jour les paramètres
        $this->updateConfigValue('app.name', $validated['app_name']);
        $this->updateConfigValue('app.url', $validated['app_url']);
        $this->updateConfigValue('app.locale', $validated['app_locale']);
        $this->updateConfigValue('app.timezone', $validated['timezone']);

        // Mode maintenance
        if ($validated['maintenance_mode']) {
            Artisan::call('down');
        } else {
            Artisan::call('up');
        }

        // Vider le cache
        Cache::flush();
        Artisan::call('config:clear');

        return redirect()->back()->with('success', 'Paramètres généraux mis à jour avec succès.');
    }

    /**
     * Display email settings.
     */
    public function email()
    {
        $settings = [
            'mail_driver' => config('mail.default'),
            'mail_host' => config('mail.mailers.smtp.host'),
            'mail_port' => config('mail.mailers.smtp.port'),
            'mail_username' => config('mail.mailers.smtp.username'),
            'mail_encryption' => config('mail.mailers.smtp.encryption'),
            'mail_from_address' => config('mail.from.address'),
            'mail_from_name' => config('mail.from.name'),
        ];

        return view('admin.settings.email', compact('settings'));
    }

    /**
     * Update email settings.
     */
    public function updateEmail(Request $request)
    {
        $validated = $request->validate([
            'mail_driver' => 'required|in:smtp,mailgun,ses,postmark,log,array',
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|integer|min:1|max:65535',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'required|in:tls,ssl',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string|max:255',
        ]);

        // Mettre à jour les paramètres
        $this->updateConfigValue('mail.default', $validated['mail_driver']);
        $this->updateConfigValue('mail.mailers.smtp.host', $validated['mail_host']);
        $this->updateConfigValue('mail.mailers.smtp.port', $validated['mail_port']);
        $this->updateConfigValue('mail.mailers.smtp.username', $validated['mail_username']);
        $this->updateConfigValue('mail.mailers.smtp.encryption', $validated['mail_encryption']);
        $this->updateConfigValue('mail.from.address', $validated['mail_from_address']);
        $this->updateConfigValue('mail.from.name', $validated['mail_from_name']);

        // Vider le cache
        Cache::flush();
        Artisan::call('config:clear');

        return redirect()->back()->with('success', 'Paramètres email mis à jour avec succès.');
    }

    /**
     * Display payment settings.
     */
    public function payment()
    {
        $settings = [
            'stripe_key' => config('services.stripe.key'),
            'stripe_secret' => config('services.stripe.secret'),
            'stripe_webhook_secret' => config('services.stripe.webhook_secret'),
            'paypal_client_id' => config('services.paypal.client_id'),
            'paypal_secret' => config('services.paypal.secret'),
            'paypal_mode' => config('services.paypal.mode'),
            'commission_rate' => config('pelefood.commission_rate', 5),
            'minimum_payout' => config('pelefood.minimum_payout', 50),
        ];

        return view('admin.settings.payment', compact('settings'));
    }

    /**
     * Update payment settings.
     */
    public function updatePayment(Request $request)
    {
        $validated = $request->validate([
            'stripe_key' => 'nullable|string|max:255',
            'stripe_secret' => 'nullable|string|max:255',
            'stripe_webhook_secret' => 'nullable|string|max:255',
            'paypal_client_id' => 'nullable|string|max:255',
            'paypal_secret' => 'nullable|string|max:255',
            'paypal_mode' => 'required|in:sandbox,live',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'minimum_payout' => 'required|numeric|min:0',
        ]);

        // Mettre à jour les paramètres
        $this->updateConfigValue('services.stripe.key', $validated['stripe_key']);
        $this->updateConfigValue('services.stripe.secret', $validated['stripe_secret']);
        $this->updateConfigValue('services.stripe.webhook_secret', $validated['stripe_webhook_secret']);
        $this->updateConfigValue('services.paypal.client_id', $validated['paypal_client_id']);
        $this->updateConfigValue('services.paypal.secret', $validated['paypal_secret']);
        $this->updateConfigValue('services.paypal.mode', $validated['paypal_mode']);
        $this->updateConfigValue('pelefood.commission_rate', $validated['commission_rate']);
        $this->updateConfigValue('pelefood.minimum_payout', $validated['minimum_payout']);

        // Vider le cache
        Cache::flush();
        Artisan::call('config:clear');

        return redirect()->back()->with('success', 'Paramètres de paiement mis à jour avec succès.');
    }

    /**
     * Display notification settings.
     */
    public function notifications()
    {
        $settings = [
            'email_notifications' => config('pelefood.notifications.email', true),
            'sms_notifications' => config('pelefood.notifications.sms', false),
            'push_notifications' => config('pelefood.notifications.push', true),
            'order_notifications' => config('pelefood.notifications.order', true),
            'payment_notifications' => config('pelefood.notifications.payment', true),
            'support_notifications' => config('pelefood.notifications.support', true),
        ];

        return view('admin.settings.notifications', compact('settings'));
    }

    /**
     * Update notification settings.
     */
    public function updateNotifications(Request $request)
    {
        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'order_notifications' => 'boolean',
            'payment_notifications' => 'boolean',
            'support_notifications' => 'boolean',
        ]);

        // Mettre à jour les paramètres
        $this->updateConfigValue('pelefood.notifications.email', $validated['email_notifications']);
        $this->updateConfigValue('pelefood.notifications.sms', $validated['sms_notifications']);
        $this->updateConfigValue('pelefood.notifications.push', $validated['push_notifications']);
        $this->updateConfigValue('pelefood.notifications.order', $validated['order_notifications']);
        $this->updateConfigValue('pelefood.notifications.payment', $validated['payment_notifications']);
        $this->updateConfigValue('pelefood.notifications.support', $validated['support_notifications']);

        // Vider le cache
        Cache::flush();
        Artisan::call('config:clear');

        return redirect()->back()->with('success', 'Paramètres de notification mis à jour avec succès.');
    }

    /**
     * Display security settings.
     */
    public function security()
    {
        $settings = [
            'session_lifetime' => config('session.lifetime', 120),
            'password_timeout' => config('auth.password_timeout', 10800),
            'max_login_attempts' => config('auth.max_login_attempts', 5),
            'lockout_duration' => config('auth.lockout_duration', 300),
            'two_factor_auth' => config('auth.two_factor', false),
            'api_rate_limit' => config('auth.api_rate_limit', 60),
        ];

        return view('admin.settings.security', compact('settings'));
    }

    /**
     * Update security settings.
     */
    public function updateSecurity(Request $request)
    {
        $validated = $request->validate([
            'session_lifetime' => 'required|integer|min:1|max:1440',
            'password_timeout' => 'required|integer|min:0|max:86400',
            'max_login_attempts' => 'required|integer|min:1|max:10',
            'lockout_duration' => 'required|integer|min:60|max:3600',
            'two_factor_auth' => 'boolean',
            'api_rate_limit' => 'required|integer|min:10|max:1000',
        ]);

        // Mettre à jour les paramètres
        $this->updateConfigValue('session.lifetime', $validated['session_lifetime']);
        $this->updateConfigValue('auth.password_timeout', $validated['password_timeout']);
        $this->updateConfigValue('auth.max_login_attempts', $validated['max_login_attempts']);
        $this->updateConfigValue('auth.lockout_duration', $validated['lockout_duration']);
        $this->updateConfigValue('auth.two_factor', $validated['two_factor_auth']);
        $this->updateConfigValue('auth.api_rate_limit', $validated['api_rate_limit']);

        // Vider le cache
        Cache::flush();
        Artisan::call('config:clear');

        return redirect()->back()->with('success', 'Paramètres de sécurité mis à jour avec succès.');
    }

    /**
     * Display backup settings.
     */
    public function backup()
    {
        $settings = [
            'auto_backup' => config('pelefood.backup.auto', true),
            'backup_frequency' => config('pelefood.backup.frequency', 'daily'),
            'backup_retention' => config('pelefood.backup.retention', 30),
            'backup_storage' => config('pelefood.backup.storage', 'local'),
            'backup_compression' => config('pelefood.backup.compression', true),
        ];

        $backups = $this->getBackupFiles();

        return view('admin.settings.backup', compact('settings', 'backups'));
    }

    /**
     * Update backup settings.
     */
    public function updateBackup(Request $request)
    {
        $validated = $request->validate([
            'auto_backup' => 'boolean',
            'backup_frequency' => 'required|in:hourly,daily,weekly,monthly',
            'backup_retention' => 'required|integer|min:1|max:365',
            'backup_storage' => 'required|in:local,s3,dropbox',
            'backup_compression' => 'boolean',
        ]);

        // Mettre à jour les paramètres
        $this->updateConfigValue('pelefood.backup.auto', $validated['auto_backup']);
        $this->updateConfigValue('pelefood.backup.frequency', $validated['backup_frequency']);
        $this->updateConfigValue('pelefood.backup.retention', $validated['backup_retention']);
        $this->updateConfigValue('pelefood.backup.storage', $validated['backup_storage']);
        $this->updateConfigValue('pelefood.backup.compression', $validated['backup_compression']);

        // Vider le cache
        Cache::flush();
        Artisan::call('config:clear');

        return redirect()->back()->with('success', 'Paramètres de sauvegarde mis à jour avec succès.');
    }

    /**
     * Create a new backup.
     */
    public function createBackup()
    {
        try {
            Artisan::call('backup:run');
            return redirect()->back()->with('success', 'Sauvegarde créée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création de la sauvegarde: ' . $e->getMessage());
        }
    }

    /**
     * Download a backup file.
     */
    public function downloadBackup($filename)
    {
        $path = storage_path('app/backup-temp/' . $filename);
        
        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'Fichier de sauvegarde introuvable.');
        }

        return response()->download($path);
    }

    /**
     * Delete a backup file.
     */
    public function deleteBackup($filename)
    {
        $path = storage_path('app/backup-temp/' . $filename);
        
        if (file_exists($path)) {
            unlink($path);
        }

        return redirect()->back()->with('success', 'Sauvegarde supprimée avec succès.');
    }

    /**
     * Display system information.
     */
    public function system()
    {
        $system = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database_driver' => config('database.default'),
            'cache_driver' => config('cache.default'),
            'queue_driver' => config('queue.default'),
            'session_driver' => config('session.driver'),
            'disk_free_space' => $this->formatBytes(disk_free_space('/')),
            'disk_total_space' => $this->formatBytes(disk_total_space('/')),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
        ];

        return view('admin.settings.system', compact('system'));
    }

    /**
     * Clear application cache.
     */
    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            
            return redirect()->back()->with('success', 'Cache vidé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du vidage du cache: ' . $e->getMessage());
        }
    }

    /**
     * Optimize application.
     */
    public function optimize()
    {
        try {
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');
            
            return redirect()->back()->with('success', 'Application optimisée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'optimisation: ' . $e->getMessage());
        }
    }

    /**
     * Get all settings.
     */
    private function getAllSettings()
    {
        return [
            'general' => [
                'app_name' => config('app.name'),
                'app_url' => config('app.url'),
                'app_locale' => config('app.locale'),
                'app_timezone' => config('app.timezone'),
            ],
            'email' => [
                'mail_driver' => config('mail.default'),
                'mail_host' => config('mail.mailers.smtp.host'),
                'mail_from_address' => config('mail.from.address'),
            ],
            'payment' => [
                'stripe_key' => config('services.stripe.key'),
                'paypal_mode' => config('services.paypal.mode'),
                'commission_rate' => config('pelefood.commission_rate', 5),
            ],
            'notifications' => [
                'email_notifications' => config('pelefood.notifications.email', true),
                'push_notifications' => config('pelefood.notifications.push', true),
            ],
            'security' => [
                'session_lifetime' => config('session.lifetime', 120),
                'two_factor_auth' => config('auth.two_factor', false),
            ],
            'backup' => [
                'auto_backup' => config('pelefood.backup.auto', true),
                'backup_frequency' => config('pelefood.backup.frequency', 'daily'),
            ],
        ];
    }

    /**
     * Update config value.
     */
    private function updateConfigValue($key, $value)
    {
        // Cette méthode devrait mettre à jour le fichier de configuration
        // Pour l'instant, on utilise le cache
        Cache::put('config.' . $key, $value, 86400);
    }

    /**
     * Get backup files.
     */
    private function getBackupFiles()
    {
        $path = storage_path('app/backup-temp');
        
        if (!is_dir($path)) {
            return [];
        }

        $files = glob($path . '/*.zip');
        $backups = [];

        foreach ($files as $file) {
            $backups[] = [
                'filename' => basename($file),
                'size' => $this->formatBytes(filesize($file)),
                'created_at' => date('d/m/Y H:i', filemtime($file)),
            ];
        }

        return $backups;
    }

    /**
     * Format bytes to human readable format.
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
} 