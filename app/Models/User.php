<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\Enrollment;
use App\Models\Certificate;
use App\Models\LessonCompletion;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture'
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

    // === Relasi ===

    // User sebagai instruktur
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    // User sebagai murid
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // === Relasi tambahan ===
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function lessonCompletions()
    {
        return $this->hasMany(LessonCompletion::class);
    }
}
