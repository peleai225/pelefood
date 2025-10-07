<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentGateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'provider',
        'is_active',
        'api_key',
        'secret_key',
        'test_mode',
        'credentials',
        'settings',
        'description',
        'webhook_url',
        'fees_percentage',
        'fees_fixed',
        'supported_currencies',
        'config',
        'webhook_secret',
    ];

    protected $casts = [
        'credentials' => 'array',
        'settings' => 'array',
        'config' => 'array',
        'supported_currencies' => 'array',
        'fees_percentage' => 'decimal:4',
        'fees_fixed' => 'decimal:2',
        'is_active' => 'boolean',
        'test_mode' => 'boolean',
    ];

    // Relations
    public function transactions(): HasMany
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('gateway_type', $type);
    }

    // Accessors
    public function getFormattedTransactionFeeAttribute(): string
    {
        $fee = '';
        
        if ($this->transaction_fee_percentage > 0) {
            $fee .= number_format($this->transaction_fee_percentage * 100, 2) . '%';
        }
        
        if ($this->transaction_fee_fixed > 0) {
            if ($fee) $fee .= ' + ';
            $fee .= '€' . number_format($this->transaction_fee_fixed, 2);
        }
        
        return $fee ?: 'Gratuit';
    }

    public function getLogoUrlAttribute($value): string
    {
        if ($value) {
            return $value;
        }

        // Logo par défaut basé sur le nom
        $logos = [
            'stripe' => 'https://cdn.worldvectorlogo.com/logos/stripe-2.svg',
            'paypal' => 'https://cdn.worldvectorlogo.com/logos/paypal-3.svg',
            'mollie' => 'https://cdn.worldvectorlogo.com/logos/mollie-1.svg',
            'adyen' => 'https://cdn.worldvectorlogo.com/logos/adyen-1.svg',
        ];

        return $logos[strtolower($this->name)] ?? '/images/default-gateway.svg';
    }

    // Methods
    public function calculateTransactionFee(float $amount): float
    {
        $percentageFee = $amount * $this->transaction_fee_percentage;
        $fixedFee = $this->transaction_fee_fixed;
        
        return $percentageFee + $fixedFee;
    }

    public function isSupportedForCurrency(string $currency): bool
    {
        if (empty($this->supported_currencies)) {
            return true; // Si aucune devise spécifiée, on suppose que toutes sont supportées
        }

        return in_array(strtoupper($currency), array_map('strtoupper', $this->supported_currencies));
    }

    public function isSupportedForCountry(string $country): bool
    {
        if (empty($this->supported_countries)) {
            return true; // Si aucun pays spécifié, on suppose que tous sont supportés
        }

        return in_array(strtoupper($country), array_map('strtoupper', $this->supported_countries));
    }

    public function getConfigurationValue(string $key, $default = null)
    {
        return data_get($this->configuration, $key, $default);
    }

    public function setConfigurationValue(string $key, $value): void
    {
        $config = $this->configuration ?? [];
        $config[$key] = $value;
        $this->update(['configuration' => $config]);
    }

    public function getApiKey(): ?string
    {
        return $this->getConfigurationValue('api_key');
    }

    public function getWebhookUrl(): ?string
    {
        return $this->getConfigurationValue('webhook_url');
    }

    public function getSecretKey(): ?string
    {
        return $this->getConfigurationValue('secret_key');
    }
} 