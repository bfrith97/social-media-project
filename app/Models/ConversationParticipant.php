<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConversationParticipant extends Model
{
    protected $fillable = [
        'conversation_id',
        'user_id',
    ];

    public function participant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
