<?php

namespace App\Models;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Review;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\Enrollment;
use App\Models\Certificate;
use App\Models\LessonCompletion;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'description',
        'thumbnail',
        'price',
        'status'
    ];

    // === Relasi Lama ===
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // === Relasi Baru ===
    // Wishlist (kursus difavoritkan user)
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // Certificates (sertifikat dari course ini, lewat enrollment)
    public function certificates()
    {
        return $this->hasManyThrough(Certificate::class, Enrollment::class);
    }

    // LessonCompletions (progress lesson di course ini, lewat enrollment)
    public function lessonCompletions()
    {
        return $this->hasManyThrough(LessonCompletion::class, Enrollment::class);
    }
    public function quiz()
    {
        return $this->hasOne(Quiz::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
