<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Group extends Model
{
    protected $appends = ['joined_by_current_user', 'current_user_is_admin'];

    protected $fillable = [
        'name',
        'description',
        'website',
        'private',
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_users', 'group_id', 'user_id')->withTimestamps()->orderByDesc('group_users.created_at');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'group_id')->orderByDesc('created_at');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'group_id')->orderByDesc('created_at');
    }

    public function groupCategory(): BelongsTo
    {
        return $this->belongsTo(GroupCategory::class);
    }

    public function getJoinedByCurrentUserAttribute(): bool
    {
        $user = auth()->id();
        return $this->members()
            ->where('user_id', $user)
            ->exists();
    }

    public function getCurrentUserIsAdminAttribute(): bool
    {
        $user = auth()->id();
        return $this->members()
            ->where('user_id', $user)
            ->where('is_admin', 1)
            ->exists();
    }
}
