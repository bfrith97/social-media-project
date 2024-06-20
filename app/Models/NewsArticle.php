<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'item_id')->where('item_type', NewsArticle::class)->orderByDesc('created_at');
    }
}
