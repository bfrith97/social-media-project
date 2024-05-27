<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $appends = ['liked_by_current_user'];

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

    public function postLikes(): HasMany
    {
        return $this->hasMany(PostLike::class)->with('user')->orderByDesc('created_at');
    }

    public function getLikedByCurrentUserAttribute(): bool
    {
        $user = auth()->id();
        return $this->postLikes()->where('user_id', $user)->exists();
    }
}
