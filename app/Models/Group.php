<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Group extends Model
{
    protected $fillable = [
        'name',
        'description',
        'website',
        'private',
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_users', 'group_id', 'user_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'group_id')->orderByDesc('created_at');
    }
}
