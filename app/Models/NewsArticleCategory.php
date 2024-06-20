<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsArticleCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public function newsArticles(): HasMany
    {
        return $this->hasMany(NewsArticle::class, 'category_id');
    }
}
