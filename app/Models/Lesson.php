<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'title',
        'description',
        'video_url',
        'duration',
        'is_preview',
        'order',
    ];
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function completions()
    {
        return $this->hasMany(LessonCompletion::class);
    }

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
}
