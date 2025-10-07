<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ShadcnServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Enregistrer tous les composants Shadcn
        $this->registerShadcnComponents();
    }

    /**
     * Enregistrer les composants Shadcn
     */
    private function registerShadcnComponents(): void
    {
        $components = [
            // Layout components
            'card' => 'admin.components.ui.card',
            'card-header' => 'admin.components.ui.card-header',
            'card-content' => 'admin.components.ui.card-content',
            'card-footer' => 'admin.components.ui.card-footer',
            
            // Form components
            'button' => 'admin.components.ui.button',
            'input' => 'admin.components.ui.input',
            'label' => 'admin.components.ui.label',
            'select' => 'admin.components.ui.select',
            'textarea' => 'admin.components.ui.textarea',
            'checkbox' => 'admin.components.ui.checkbox',
            'radio' => 'admin.components.ui.radio',
            'switch' => 'admin.components.ui.switch',
            
            // Display components
            'badge' => 'admin.components.ui.badge',
            'table' => 'admin.components.ui.table',
            'table-header' => 'admin.components.ui.table-header',
            'table-body' => 'admin.components.ui.table-body',
            'table-row' => 'admin.components.ui.table-row',
            'table-head' => 'admin.components.ui.table-head',
            'table-cell' => 'admin.components.ui.table-cell',
            
            // Layout components
            'separator' => 'admin.components.ui.separator',
            'scroll-area' => 'admin.components.ui.scroll-area',
            
            // Feedback components
            'alert' => 'admin.components.ui.alert',
            'alert-title' => 'admin.components.ui.alert-title',
            'alert-description' => 'admin.components.ui.alert-description',
            'progress' => 'admin.components.ui.progress',
            
            // Navigation components
            'tabs' => 'admin.components.ui.tabs',
            'tabs-list' => 'admin.components.ui.tabs-list',
            'tabs-trigger' => 'admin.components.ui.tabs-trigger',
            'tabs-content' => 'admin.components.ui.tabs-content',
            'breadcrumb' => 'admin.components.ui.breadcrumb',
            'breadcrumb-item' => 'admin.components.ui.breadcrumb-item',
            'breadcrumb-link' => 'admin.components.ui.breadcrumb-link',
            'breadcrumb-separator' => 'admin.components.ui.breadcrumb-separator',
            
            // Overlay components
            'dialog' => 'admin.components.ui.dialog',
            'dialog-trigger' => 'admin.components.ui.dialog-trigger',
            'dialog-content' => 'admin.components.ui.dialog-content',
            'dialog-header' => 'admin.components.ui.dialog-header',
            'dialog-title' => 'admin.components.ui.dialog-title',
            'dialog-description' => 'admin.components.ui.dialog-description',
            'dialog-footer' => 'admin.components.ui.dialog-footer',
            'dialog-close' => 'admin.components.ui.dialog-close',
            'sheet' => 'admin.components.ui.sheet',
            'sheet-trigger' => 'admin.components.ui.sheet-trigger',
            'sheet-content' => 'admin.components.ui.sheet-content',
            'sheet-header' => 'admin.components.ui.sheet-header',
            'sheet-title' => 'admin.components.ui.sheet-title',
            'sheet-description' => 'admin.components.ui.sheet-description',
            'sheet-footer' => 'admin.components.ui.sheet-footer',
            'sheet-close' => 'admin.components.ui.sheet-close',
        ];

        foreach ($components as $alias => $view) {
            Blade::component($view, "x-{$alias}");
        }
    }
}
