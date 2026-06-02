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

    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, ['admin']);
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
}
