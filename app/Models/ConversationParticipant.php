<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

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
