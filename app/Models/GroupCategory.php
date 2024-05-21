<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class GroupCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }
}
