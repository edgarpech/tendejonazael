<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $primaryKey = 'id_review';

    protected $fillable = [
        'author_name',
        'rating',
        'comment',
        'source',
        'is_visible',
        'reviewed_at',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }
}
