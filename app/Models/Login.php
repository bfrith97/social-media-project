<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
