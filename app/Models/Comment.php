<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $appends = ['liked_by_current_user'];

    protected $likedByCurrentUserCache = null;

    protected $fillable = [
        'content',
        'user_id',
        'item_id',
        'item_type',
    ];

    public function commentable()
    {
        return $this->morphTo(__FUNCTION__, 'item_type', 'item_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'item_id');
    }

    public function newsArticle(): BelongsTo
    {
        return $this->belongsTo(NewsArticle::class, 'item_id');
    }

    public function commentLikes(): HasMany
    {
        return $this->hasMany(CommentLike::class)->with('user')->orderByDesc('created_at');
    }

    public function getLikedByCurrentUserAttribute(): bool
    {
        if ($this->likedByCurrentUserCache === null) {
            $user = auth()->id();
            $this->likedByCurrentUserCache = $this->commentLikes()->where('user_id', $user)->exists();
        }

        return $this->likedByCurrentUserCache;
    }
}
