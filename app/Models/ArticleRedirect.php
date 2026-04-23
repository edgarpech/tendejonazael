<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Redirecciones 301 para slugs antiguos de artículos.
 *
 * Cuando el slug de un artículo cambia, el slug anterior se guarda aquí
 * para poder redirigir a la nueva URL y no perder posicionamiento SEO.
 */
class ArticleRedirect extends Model
{
	protected $primaryKey = 'id_article_redirect';

	protected $fillable = [
		'old_slug',
		'article_id',
	];

	public function article()
	{
		return $this->belongsTo(Article::class, 'article_id', 'id_article');
	}
}
