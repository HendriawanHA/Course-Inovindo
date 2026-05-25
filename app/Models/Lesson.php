<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
    'module_id',
    'title',
    'description',
    'video_url',
    'duration',
    'is_preview',
    'order',
];

    public function getYoutubeEmbedUrlAttribute()
    {
        if (!$this->video_url) {
            return null;
        }

        preg_match(
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^\&\?\/]+)/',
            $this->video_url,
            $matches
        );

        return isset($matches[1])
            ? 'https://www.youtube.com/embed/' . $matches[1]
            : null;
    }

    public function getYoutubeThumbnailUrlAttribute()
    {
        if (! $this->video_url) {
            return null;
        }

        preg_match(
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^\&\?\/]+)/',
            $this->video_url,
            $matches
        );

        return isset($matches[1])
            ? 'https://img.youtube.com/vi/' . $matches[1] . '/hqdefault.jpg'
            : null;
    }
}
