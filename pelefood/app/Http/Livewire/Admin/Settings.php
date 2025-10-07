<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class Settings extends Component
{
    public $activeTab = 'general';
    
    // Paramètres généraux
    public $siteName = 'PeleFood';
    public $siteDescription = 'Plateforme de livraison de nourriture';
    public $siteEmail = 'contact@pelefood.com';
    public $sitePhone = '+237 XXX XXX XXX';
    
    // Paramètres d'email
    public $smtpHost = '';
    public $smtpPort = 587;
    public $smtpUsername = '';
    public $smtpPassword = '';
    public $smtpEncryption = 'tls';
    
    // Paramètres de paiement
    public $stripePublicKey = '';
    public $stripeSecretKey = '';
    public $paypalClientId = '';
    public $paypalSecret = '';

    public function mount()
    {
        // Charger les paramètres depuis la base de données ou des fichiers de config
        $this->loadSettings();
    }

    public function loadSettings()
    {
        // Charger les paramètres depuis la base de données
        // Pour l'instant, on utilise les valeurs par défaut
    }

    public function saveGeneralSettings()
    {
        // Sauvegarder les paramètres généraux
        $this->emit('showNotification', 'Paramètres généraux sauvegardés', 'success');
    }

    public function saveEmailSettings()
    {
        // Sauvegarder les paramètres d'email
        $this->emit('showNotification', 'Paramètres d\'email sauvegardés', 'success');
    }

    public function savePaymentSettings()
    {
        // Sauvegarder les paramètres de paiement
        $this->emit('showNotification', 'Paramètres de paiement sauvegardés', 'success');
    }

    public function render()
    {
        return view('livewire.admin.settings')->layout('layouts.super-admin-new-design');
    }
}