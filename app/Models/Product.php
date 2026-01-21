<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'description',
        'price',
        'weight',
        'color',
        'in_stock',
        'main_image_url',
        'images',
        'meta',
        'is_active',
        'is_featured',
        'sort_order',
        'views_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'in_stock' => 'boolean',
        'images' => 'array',
        'meta' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'views_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the category for the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand for the product.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Set the name and auto-generate slug.
     */
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = $value;
        if (!isset($this->attributes['slug']) || empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include products in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('in_stock', true);
    }

    /**
     * Increment views count.
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}