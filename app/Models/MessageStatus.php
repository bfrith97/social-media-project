<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MessageStatus extends Model
{
    protected $table = 'message_status';

    protected $fillable = [
        'message_id',
        'user_id',
        'status',
    ];
}
