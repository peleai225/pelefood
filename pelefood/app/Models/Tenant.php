<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'domain',
        'subdomain',
        'company_name',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'timezone',
        'currency',
        'language',
        'is_active',
        'is_verified',
        'trial_ends_at',
        'subscription_ends_at',
        'settings',
        'status',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
        'settings' => 'array',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
    ];

    // Relations
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function restaurants(): HasMany
    {
        return $this->hasMany(Restaurant::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Accessors
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([$this->address, $this->city, $this->postal_code, $this->country]);
        return implode(', ', $parts);
    }

    public function getSubscriptionStatusAttribute(): string
    {
        if (!$this->subscription_end_date) {
            return 'No subscription';
        }

        if ($this->subscription_end_date->isPast()) {
            return 'Expired';
        }

        if ($this->subscription_end_date->diffInDays(now()) <= 7) {
            return 'Expiring soon';
        }

        return 'Active';
    }

    // Methods
    public function isSubscriptionActive(): bool
    {
        return $this->subscription_end_date && $this->subscription_end_date->isFuture();
    }

    public function daysUntilExpiration(): int
    {
        if (!$this->subscription_end_date) {
            return 0;
        }

        return max(0, $this->subscription_end_date->diffInDays(now()));
    }
}
