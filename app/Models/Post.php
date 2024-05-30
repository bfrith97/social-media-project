<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $appends = ['liked_by_current_user', 'has_more_than_five_comments'];

    protected $likedByCurrentUserCache = null;
    protected $hasMoreThanFiveCommentsCache = null;

    protected $fillable = [
        'content',
        'user_id',
        'profile_id',
        'group_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'item_id')->where('item_type', Post::class)->orderByDesc('created_at');
    }

    public function commentCount(): HasMany
    {
        return $this->hasMany(Comment::class, 'item_id')->where('item_type', Post::class)->orderByDesc('created_at');
    }

    public function postLikes(): HasMany
    {
        return $this->hasMany(PostLike::class)->with('user')->orderByDesc('created_at');
    }

    public function getLikedByCurrentUserAttribute(): bool
    {
        if ($this->likedByCurrentUserCache === null) {
            $user = auth()->id();
            $this->likedByCurrentUserCache = $this->postLikes()->where('user_id', $user)->exists();
        }

        return $this->likedByCurrentUserCache;
    }

    public function getHasMoreThanFiveCommentsAttribute(): bool
    {
        if ($this->hasMoreThanFiveCommentsCache === null) {
            $this->hasMoreThanFiveCommentsCache = $this->commentCount->count() > 5;
        }

        return $this->hasMoreThanFiveCommentsCache;
    }
}
