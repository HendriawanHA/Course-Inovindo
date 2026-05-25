<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'thumbnail',
        'is_published',
        'user_id',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function lessons()
    {
        return $this->hasManyThrough(
            Lesson::class,
            Module::class
        );
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments');
    }

    public function modules()
    {
        return $this->hasMany(Module::class)
            ->orderBy('order');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function discussions()
    {
        return $this->hasMany(\App\Models\Discussion::class);
    }
    public function firstLesson()
    {
        return Lesson::whereHas('module', function ($q) {
            $q->where('course_id', $this->id);
        })->first();
    }

    public function getNextLessonForUser($user)
    {
        $completedLessonIds = $user->completedLessons
            ->pluck('id');

        return $this->lessons()
            ->whereNotIn('lessons.id', $completedLessonIds)
            ->orderBy('order')
            ->first();
    }

    public function bookmarkedBy()
    {
        return $this->belongsToMany(
            User::class,
            'bookmarks'
        );
    }
}
