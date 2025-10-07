<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'name',
        'type',
        'provider',
        'credentials',
        'is_active',
        'is_default',
        'transaction_fee',
        'fixed_fee',
        'settings',
        'description',
    ];

    protected $casts = [
        'credentials' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'transaction_fee' => 'decimal:2',
        'fixed_fee' => 'decimal:2',
    ];

    // Relations
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function transactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByProvider($query, $provider)
    {
        return $query->where('provider', $provider);
    }

    // Méthodes
    public function calculateFee($amount)
    {
        $percentageFee = ($amount * $this->transaction_fee) / 100;
        return $percentageFee + $this->fixed_fee;
    }

    public function getFormattedNameAttribute()
    {
        return "{$this->name} ({$this->provider})";
    }

    public function isMobileMoney()
    {
        return in_array($this->provider, ['orange', 'mtn', 'moov', 'mtn_momo', 'orange_money']);
    }

    public function isCardPayment()
    {
        return in_array($this->provider, ['stripe', 'paypal', 'visa', 'mastercard']);
    }

    public function isWavePayment()
    {
        return $this->provider === 'wave';
    }

    public function isCashPayment()
    {
        return $this->provider === 'cash';
    }

    // Méthodes pour les credentials sécurisés
    public function getCredential($key, $default = null)
    {
        return data_get($this->credentials, $key, $default);
    }

    public function setCredential($key, $value)
    {
        $credentials = $this->credentials ?? [];
        $credentials[$key] = $value;
        $this->update(['credentials' => $credentials]);
    }

    public function getSetting($key, $default = null)
    {
        return data_get($this->settings, $key, $default);
    }

    public function setSetting($key, $value)
    {
        $settings = $this->settings ?? [];
        $settings[$key] = $value;
        $this->update(['settings' => $settings]);
    }
} 