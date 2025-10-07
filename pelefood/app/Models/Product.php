<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'sale_ends_at',
        'images',
        'thumbnail',
        'is_available',
        'is_featured',
        'is_popular',
        'stock_quantity',
        'has_stock_management',
        'options',
        'allergens',
        'nutritional_info',
        'preparation_time',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'sale_ends_at' => 'datetime',
        'images' => 'array',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
        'is_popular' => 'boolean',
        'has_stock_management' => 'boolean',
        'options' => 'array',
        'allergens' => 'array',
        'nutritional_info' => 'array',
    ];

    // Relations
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }



    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    public function scopeInStock($query)
    {
        return $query->where(function ($q) {
            $q->where('has_stock_management', false)
              ->orWhere('stock_quantity', '>', 0);
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // Méthodes
    public function getCurrentPriceAttribute()
    {
        if ($this->sale_price && $this->sale_ends_at && $this->sale_ends_at->isFuture()) {
            return $this->sale_price;
        }
        return $this->price;
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->current_price, 0, ',', ' ') . ' FCFA';
    }

    public function getFormattedOriginalPriceAttribute()
    {
        return number_format($this->price, 0, ',', ' ') . ' FCFA';
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : asset('images/default-product.png');
    }

    public function getImagesUrlsAttribute()
    {
        if (!$this->images) {
            return [asset('images/default-product.png')];
        }

        return collect($this->images)->map(function ($image) {
            return asset('storage/' . $image);
        })->toArray();
    }

    public function getMainImageUrlAttribute()
    {
        $images = $this->images_urls;
        return $images[0] ?? asset('images/default-product.png');
    }

    public function isOnSale()
    {
        return $this->sale_price && $this->sale_ends_at && $this->sale_ends_at->isFuture();
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->isOnSale()) {
            return 0;
        }

        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    public function isInStock()
    {
        if (!$this->has_stock_management) {
            return true;
        }

        return $this->stock_quantity > 0;
    }

    public function getPreparationTimeTextAttribute()
    {
        if (!$this->preparation_time) {
            return 'Non spécifié';
        }

        $hours = floor($this->preparation_time / 60);
        $minutes = $this->preparation_time % 60;

        if ($hours > 0) {
            return $hours . 'h' . ($minutes > 0 ? ' ' . $minutes . 'min' : '');
        }

        return $minutes . 'min';
    }

    public function hasOptions()
    {
        return !empty($this->options);
    }

    public function getOptionGroups()
    {
        return collect($this->options ?? [])->keys();
    }
}
