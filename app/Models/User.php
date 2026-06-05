<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'headline',
        'bio',
        'points',
        'level',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public const RANKS = [
        ['name' => 'Newbie', 'points' => 0],
        ['name' => 'Explorer', 'points' => 50],
        ['name' => 'Contributor', 'points' => 150],
        ['name' => 'Player', 'points' => 300],
        ['name' => 'Builder', 'points' => 600],
        ['name' => 'Catalyst', 'points' => 1000],
        ['name' => 'Operator', 'points' => 1500],
        ['name' => 'Pro', 'points' => 2500],
        ['name' => 'Legend', 'points' => 4000],
    ];

    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    public function scopeTopStudents($query)
    {
        return $query
            ->students()
            ->orderByDesc('points');
    }


    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, ['admin', 'instructor']);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function completedLessons()
    {
        return $this->belongsToMany(
            Lesson::class,
            'lesson_completions'
        )->withTimestamps();
    }

    public function bookmarkedCourses()
    {
        return $this->belongsToMany(
            Course::class,
            'bookmarks'
        );
    }

    public function bookmarkItems()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isInstructor()
    {
        return $this->role === 'instructor';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments');
    }
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar
            ? Storage::url($this->avatar)
            : null;
    }

    public function hasPurchasedCourse($courseId): bool
    {
        return $this->transactions()
            ->where('course_id', $courseId)
            ->where('status', 'paid')
            ->exists();
    }

    public function getRankAttribute()
    {
        return collect(self::RANKS)
            ->where('points', '<=', $this->points)
            ->last();
    }

    public function getRankLevelAttribute()
    {
        return collect(self::RANKS)
            ->search($this->rank) + 1;
    }

    public function getNextRankAttribute()
    {
        return self::RANKS[$this->rank_level] ?? null;
    }

    public function getPointsToNextRankAttribute()
    {
        if (!$this->next_rank) {
            return 0;
        }

        return $this->next_rank['points'] - $this->points;
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
    }

    public function pointHistories()
    {
        return $this->hasMany(PointHistory::class);
    }
}
