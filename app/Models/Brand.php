<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Modelo de Marca.
 *
 * Representa una marca de productos en el catálogo.
 * Soporta soft deletes y generación automática de slug.
 *
 * @property int $id_brand
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $logo_url
 * @property string|null $website_url
 * @property int $is_active
 * @property int $show_in_home
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_brand';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo_url',
        'website_url',
        'is_active',
        'show_in_home',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'integer',
        'show_in_home' => 'integer',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Obtiene los productos de esta marca.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Product>
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brand_id', 'id_brand');
    }

    /**
     * Obtiene solo los productos activos de esta marca.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Product>
     */
    public function activeProducts(): HasMany
    {
        return $this->products()->where('is_active', 1);
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
     * Scope: filtra solo marcas activas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Scope: ordena por sort_order y luego por nombre.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}