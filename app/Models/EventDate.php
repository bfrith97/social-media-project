<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventDate extends Model
{
    protected $fillable = [
        'event_id',
        'date'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
