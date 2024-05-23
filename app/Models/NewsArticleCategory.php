<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

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
