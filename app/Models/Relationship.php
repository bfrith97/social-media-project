<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Relationship extends Model
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
