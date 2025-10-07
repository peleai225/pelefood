<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'name',
        'description',
        'type',
        'discount_value',
        'minimum_order_amount',
        'code',
        'usage_limit',
        'used_count',
        'starts_at',
        'ends_at',
        'is_active',
        'applicable_products',
        'applicable_categories',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'minimum_order_amount' => 'decimal:2',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
        'applicable_products' => 'array',
        'applicable_categories' => 'array',
    ];

    // Relations
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('starts_at', '<=', now())
                    ->where('ends_at', '>=', now());
    }

    public function scopeValid($query)
    {
        return $query->where('ends_at', '>=', now());
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    // Méthodes
    public function isActive()
    {
        return $this->is_active && 
               $this->starts_at <= now() && 
               $this->ends_at >= now();
    }

    public function isExpired()
    {
        return $this->ends_at < now();
    }

    public function hasReachedUsageLimit()
    {
        return $this->usage_limit && $this->used_count >= $this->usage_limit;
    }

    public function canBeUsed()
    {
        return $this->isActive() && !$this->hasReachedUsageLimit();
    }

    public function incrementUsage()
    {
        $this->increment('used_count');
    }

    public function calculateDiscount($orderAmount)
    {
        if ($orderAmount < $this->minimum_order_amount) {
            return 0;
        }

        switch ($this->type) {
            case 'percentage':
                return ($orderAmount * $this->discount_value) / 100;
            case 'fixed_amount':
                return min($this->discount_value, $orderAmount);
            case 'free_delivery':
                return 0; // Géré séparément
            default:
                return 0;
        }
    }

    public function getTypeTextAttribute()
    {
        $types = [
            'percentage' => 'Pourcentage',
            'fixed_amount' => 'Montant fixe',
            'free_delivery' => 'Livraison gratuite',
            'buy_one_get_one' => 'Achetez 1, obtenez 1 gratuit',
        ];

        return $types[$this->type] ?? $this->type;
    }

    public function getFormattedDiscountValueAttribute()
    {
        switch ($this->type) {
            case 'percentage':
                return $this->discount_value . '%';
            case 'fixed_amount':
                return number_format($this->discount_value, 0, ',', ' ') . ' FCFA';
            case 'free_delivery':
                return 'Livraison gratuite';
            default:
                return $this->discount_value;
        }
    }

    public function getFormattedMinimumOrderAttribute()
    {
        return number_format($this->minimum_order_amount, 0, ',', ' ') . ' FCFA';
    }

    public function getRemainingUsesAttribute()
    {
        if (!$this->usage_limit) {
            return null;
        }

        return max(0, $this->usage_limit - $this->used_count);
    }

    public function isApplicableToProduct($productId)
    {
        if (!$this->applicable_products) {
            return true;
        }

        return in_array($productId, $this->applicable_products);
    }

    public function isApplicableToCategory($categoryId)
    {
        if (!$this->applicable_categories) {
            return true;
        }

        return in_array($categoryId, $this->applicable_categories);
    }
}
