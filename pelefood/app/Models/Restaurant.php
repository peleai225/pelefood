<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Restaurant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'slogan',
        'address',
        'city',
        'postal_code',
        'country',
        'phone',
        'email',
        'website',
        'logo',
        'cover_image',
        'banner_image',
        'gallery_images',
        'theme_colors',
        'opening_hours',
        'delivery_radius',
        'delivery_time',
        'minimum_order',
        'delivery_fee',
        'preparation_time',
        'delivery_zones',
        'is_active',
        'is_verified',
        'is_featured',
        'rating',
        'total_reviews',
        'total_orders',
        'total_revenue',
        'subscription_plan_id',
        'subscription_status',
        'subscription_expires_at',
        'trial_ends_at',
        'settings',
        'user_id',
        'tenant_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'is_featured' => 'boolean',
        'rating' => 'decimal:2',
        'total_reviews' => 'integer',
        'total_orders' => 'integer',
        'total_revenue' => 'decimal:2',
        'subscription_expires_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'theme_colors' => 'array',
        'opening_hours' => 'array',
        'settings' => 'array',
        'delivery_zones' => 'array',
        'gallery_images' => 'array',
        'delivery_radius' => 'integer',
        'minimum_order' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'preparation_time' => 'integer',
    ];

    protected $dates = [
        'subscription_expires_at',
        'trial_ends_at',
        'deleted_at',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    public function deliveryZones()
    {
        return $this->hasMany(DeliveryZone::class);
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', 'like', "%{$city}%");
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('id', $categoryId);
        });
    }

    // Accesseurs
    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->city} {$this->postal_code}, {$this->country}";
    }

    public function getAverageRatingAttribute()
    {
        return $this->rating ?? 0;
    }

    public function getTotalOrdersCountAttribute()
    {
        return $this->total_orders ?? 0;
    }

    public function getTotalRevenueFormattedAttribute()
    {
        return number_format($this->total_revenue ?? 0, 0, ',', ' ') . ' FCFA';
    }

    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return asset('images/default-restaurant-logo.png');
    }

    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        return asset('images/default-restaurant-cover.jpg');
    }

    public function getBannerImageUrlAttribute()
    {
        if ($this->banner_image) {
            return asset('storage/' . $this->banner_image);
        }
        return asset('images/default-restaurant-banner.jpg');
    }

    // Méthodes
    public function isCurrentlyOpen()
    {
        if (empty($this->opening_hours)) {
            return true; // Toujours ouvert si pas d'horaires définis
        }

        $now = now();
        $dayOfWeek = strtolower($now->format('l'));
        $currentTime = $now->format('H:i');

        if (isset($this->opening_hours[$dayOfWeek])) {
            $hours = $this->opening_hours[$dayOfWeek];
            if ($hours['is_open']) {
                return $currentTime >= $hours['open'] && $currentTime <= $hours['close'];
            }
        }

        return false;
    }

    public function getSubscriptionDaysLeft()
    {
        if (!$this->subscription_expires_at) {
            return null;
        }

        return max(0, now()->diffInDays($this->subscription_expires_at, false));
    }

    public function isSubscriptionActive()
    {
        if ($this->subscription_status === 'active') {
            return true;
        }

        if ($this->subscription_status === 'trial' && $this->trial_ends_at) {
            return now()->lt($this->trial_ends_at);
        }

        return false;
    }

    public function canAcceptOrders()
    {
        return $this->is_active && $this->is_verified && $this->isSubscriptionActive();
    }

    public function getDeliveryFeeForOrder($orderTotal)
    {
        if ($orderTotal >= $this->minimum_order) {
            return $this->delivery_fee;
        }
        return $this->delivery_fee + 500; // Frais supplémentaires si commande trop petite
    }

    public function getEstimatedPreparationTime()
    {
        return $this->preparation_time ?? 30; // 30 minutes par défaut
    }

    public function getThemeColor($key, $default = null)
    {
        if (isset($this->theme_colors[$key])) {
            return $this->theme_colors[$key];
        }
        return $default;
    }

    public function getSetting($key, $default = null)
    {
        if (isset($this->settings[$key])) {
            return $this->settings[$key];
        }
        return $default;
    }

    public function setSetting($key, $value)
    {
        $settings = $this->settings ?? [];
        $settings[$key] = $value;
        $this->settings = $settings;
        $this->save();
    }

    // Événements
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($restaurant) {
            if (empty($restaurant->slug)) {
                $restaurant->slug = Str::slug($restaurant->name);
            }
        });

        static::updating(function ($restaurant) {
            if ($restaurant->isDirty('name') && empty($restaurant->slug)) {
                $restaurant->slug = Str::slug($restaurant->name);
            }
        });
    }

    // URL de la plateforme individuelle
    public function getPlatformUrlAttribute()
    {
        return url("/restaurant/{$this->slug}");
    }

    public function getMenuUrlAttribute()
    {
        return url("/restaurant/{$this->slug}/menu");
    }

    public function getOrdersUrlAttribute()
    {
        return url("/restaurant/{$this->slug}/orders");
    }
}
