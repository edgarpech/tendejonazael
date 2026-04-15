<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de artículos del blog.
 *
 * Representa los artículos informativos publicados en el sitio.
 */
class Article extends Model
{
	protected $primaryKey = 'id_article';

	protected $fillable = [
		'title',
		'slug',
		'excerpt',
		'content',
		'image',
		'category',
		'is_published',
		'published_at',
	];

	protected $casts = [
		'is_published' => 'boolean',
		'published_at' => 'datetime',
	];

	/**
	 * Scope para artículos publicados.
	 */
	public function scopePublished($query)
	{
		return $query->where('is_published', true)->whereNotNull('published_at')->where('published_at', '<=', now());
	}
}
