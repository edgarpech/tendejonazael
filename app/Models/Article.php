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

	/**
	 * Hook: cuando el slug cambia, guarda el slug anterior como redirect 301
	 * para no romper URLs ya indexadas en buscadores.
	 */
	protected static function booted(): void
	{
		static::updating(function (Article $article) {
			if ($article->isDirty('slug')) {
				$oldSlug = $article->getOriginal('slug');
				if ($oldSlug && $oldSlug !== $article->slug) {
					ArticleRedirect::updateOrCreate(
						['old_slug' => $oldSlug],
						['article_id' => $article->id_article]
					);
					// Si el nuevo slug existía como redirect, eliminarlo para evitar bucles.
					ArticleRedirect::where('old_slug', $article->slug)->delete();
				}
			}
		});
	}
}
