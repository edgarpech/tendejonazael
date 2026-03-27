<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Modelo de Producto.
 *
 * Representa un artículo del catálogo con precio, categoría, marca e imagen.
 * Soporta soft deletes, generación automática de slug y contador de vistas.
 *
 * @property int $id_product
 * @property int|null $category_id
 * @property int|null $brand_id
 * @property string $name
 * @property string $slug
 * @property string|null $sku
 * @property string|null $description
 * @property float|null $cost_price
 * @property float $price
 * @property string|null $weight
 * @property string|null $color
 * @property string|null $main_image_url
 * @property array|null $images
 * @property array|null $meta
 * @property int $is_active
 * @property int $sort_order
 * @property int $views_count
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
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
     * Obtiene la categoría a la que pertenece este producto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Category, Product>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id_category');
    }

    /**
     * Obtiene la marca a la que pertenece este producto.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Brand, Product>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id_brand');
    }

    /**
     * Mutador: al asignar el nombre, genera el slug automáticamente si no existe.
     *
     * @param string $value
     * @return void
     */
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = $value;
        if (!isset($this->attributes['slug']) || empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    /**
     * Scope: filtra solo productos activos.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Incrementa el contador de vistas del producto en 1.
     *
     * @return void
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}