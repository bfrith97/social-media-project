<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Login extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'ip_address',
        'login_at',
        'logout_at',
        'minutes_logged_in',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
