<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [
        'name',
    ];

    public static function findByParticipants($userId1, $userId2)
    {
        return Conversation::whereHas('conversationParticipants', function ($query) use ($userId1) {
            $query->where('user_id', $userId1);
        })->whereHas('conversationParticipants', function ($query) use ($userId2) {
            $query->where('user_id', $userId2);
        })->first();
    }

    public function conversationParticipants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversation_participants', 'conversation_id', 'user_id')
            ->withTimestamps();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }
}
