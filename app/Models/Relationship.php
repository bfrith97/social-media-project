<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Relationship extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
