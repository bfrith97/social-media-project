<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Comment extends Model
{
    protected $appends = ['liked_by_current_user'];

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

    public function commentLikes(): HasMany
    {
        return $this->hasMany(CommentLike::class)->with('user')->orderByDesc('created_at');
    }

    public function getLikedByCurrentUserAttribute(): bool
    {
        $user = auth()->id();
        return $this->commentLikes()->where('user_id', $user)->exists();
    }
}
