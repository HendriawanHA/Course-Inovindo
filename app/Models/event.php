<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'event_type',
        'delivery_type',
        'meeting_url',
        'location',
        'city',
        'recording_url',
        'start_time',
        'end_time',
        'timezone',
        'instructor_id',
        'capacity',
        'is_paid',
        'price',
        'status',
        'is_active',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_paid' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    // RELATION
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function getLiveStatusAttribute()
    {
        if (now()->lt($this->start_time)) {
            return 'upcoming';
        }

        if (
            now()->between(
                $this->start_time,
                $this->end_time
            )
        ) {
            return 'live';
        }

        return 'ended';
    }
}
