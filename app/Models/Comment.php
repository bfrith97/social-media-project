<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

class Comment extends Model
{
    protected $appends = ['liked_by_current_user'];

    protected $fillable = [
        'content',
        'user_id',
        'post_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function commentLikes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'comment_likes', 'comment_id', 'user_id')
            ->withTimestamps();
    }

    public function getLikedByCurrentUserAttribute(): bool
    {
        $user = auth()->id();
        return $this->commentLikes()->where('user_id', $user)->exists();
    }
}
