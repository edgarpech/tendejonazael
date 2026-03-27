<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modelo de Galería.
 *
 * Representa una imagen en la galería del sitio.
 * Soporta soft deletes, imágenes destacadas y ordenamiento personalizado.
 *
 * @property int $id_gallery
 * @property string $title
 * @property string|null $description
 * @property string $image_url
 * @property string|null $thumbnail_url
 * @property string|null $alt_text
 * @property string|null $category
 * @property int $is_active
 * @property int $is_featured
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gallery';
    protected $primaryKey = 'id_gallery';

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'thumbnail_url',
        'alt_text',
        'category',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'integer',
        'is_featured' => 'integer',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Scope: filtra solo elementos activos de la galería.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Scope: filtra solo elementos destacados de la galería.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1);
    }

    /**
     * Scope: ordena por sort_order y luego por fecha de creación descendente.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }
}