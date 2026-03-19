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

    protected $primaryKey = 'id_product';

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'sku',
        'description',
        'cost_price',
        'price',
        'weight',
        'color',
        'main_image_url',
        'images',
        'meta',
        'is_active',
        'sort_order',
        'views_count',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'price' => 'decimal:2',
        'images' => 'array',
        'meta' => 'array',
        'is_active' => 'integer',
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
        return $this->belongsTo(Category::class, 'category_id', 'id_category');
    }

    /**
     * Get the brand for the product.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id_brand');
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
        return $query->where('is_active', 1);
    }

    /**
     * Increment views count.
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}