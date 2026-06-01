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

    public function getStatusBadgeAttribute()
    {
        if (now()->lt($this->start_time)) {
            return [
                'text' => 'Dimulai ' . $this->start_time->diffForHumans(),
                'color' => 'green'
            ];
        }

        if (now()->between($this->start_time, $this->end_time)) {
            return [
                'text' => '🔴 LIVE',
                'color' => 'red'
            ];
        }

        return [
            'text' => 'Berakhir',
            'color' => 'zinc'
        ];
    }

    public function getThumbnailUrlAttribute()
    {
        return asset(
            'storage/' . $this->thumbnail
        );
    }

    public function getVideoTitleAttribute()
    {
        return match ($this->live_status) {
            'draft' => 'Event Not Published',
            'upcoming' => 'Upcoming Session',
            'live' => 'Live Meeting',
            'ended' => 'Recording',
            default => 'Event Video',
        };
    }

    public function getVideoUrlAttribute()
    {
        return match ($this->live_status) {
            'live' => $this->meeting_url,
            'ended' => $this->recording_url,
            default => null,
        };
    }

    public function getYoutubeIdAttribute()
    {
        if (!$this->video_url) {
            return null;
        }

        preg_match(
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/',
            $this->video_url,
            $matches
        );

        return $matches[1] ?? null;
    }

    public function getRepeatInfoAttribute()
    {
        $title = strtolower($this->title);

        if (str_contains($title, 'daily')) {
            return [
                'title' => 'Repeats every weekday',
                'subtitle' => '(Monday to Friday)',
            ];
        }

        if (str_contains($title, 'weekly')) {
            return [
                'title' => 'Repeats every week',
                'subtitle' => '(Every week)',
            ];
        }

        if (str_contains($title, 'monthly')) {
            return [
                'title' => 'Repeats every month',
                'subtitle' => '(Once every month)',
            ];
        }

        return null;
    }
}
