<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class NewsArticle extends Model
{
    protected $fillable = [
        'author',
        'category_id',
        'title',
        'description',
        'url',
        'published_at',
    ];

    public function newsArticleCategory(): BelongsTo
    {
        return $this->belongsTo(NewsArticleCategory::class, 'category_id');
    }
}
