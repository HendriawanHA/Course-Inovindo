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
        return $this->hasMany(Lesson::class);
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

    public function firstLesson()
    {
        return Lesson::whereHas('module', function ($q) {
            $q->where('course_id', $this->id);
        })->first();
    }
}
