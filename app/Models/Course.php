<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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

    protected $appends = [
        'progress',
        'can_access',
        'is_bookmarked',
        'has_purchased',
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

    public function discussionReplies()
    {
        return $this->hasManyThrough(DiscussionReply::class, Discussion::class);
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

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function isFree()
    {
        return $this->price <= 0;
    }
    public function getThumbnailUrlAttribute()
    {
        return asset('storage/' . $this->thumbnail);
    }

    public function isPurchasedBy($user): bool
    {
        if (!$user) {
            return false;
        }

        return $this->transactions()
            ->where('user_id', $user->id)
            ->where('status', 'paid')
            ->exists();
    }

    public function progressForUser($user): int
    {
        if (!$user) {
            return 0;
        }

        $enrollment = $this->enrollments
            ->where('user_id', $user->id)
            ->first();

        return $enrollment?->progress ?? 0;
    }

    public function canAccess($user): bool
    {
        return $this->isFree()
            || $this->isPurchasedBy($user);
    }

    public function isBookmarkedBy($user): bool
    {
        if (!$user) {
            return false;
        }

        return $user->bookmarkedCourses
            ->contains($this->id);
    }

    public function getHasPurchasedAttribute()
    {
        return $this->isPurchasedBy(Auth::user());
    }

    public function scopePopular($query)
    {
        return $query
            ->withCount('enrollments')
            ->orderByDesc('enrollments_count');
    }

    public function getProgressAttribute()
    {
        return $this->progressForUser(Auth::user());
    }

    public function getCanAccessAttribute()
    {
        return $this->canAccess(Auth::user());
    }

    public function getIsBookmarkedAttribute()
    {
        return $this->isBookmarkedBy(Auth::user());
    }
}
