<?php

namespace App\Models;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'enrollment_id',
        'certificate_number',
        'file_path',
        'issued_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    // Relasi
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, Enrollment::class, 'id', 'id', 'enrollment_id', 'user_id');
    }

    public function course()
    {
        return $this->hasOneThrough(Course::class, Enrollment::class, 'id', 'id', 'enrollment_id', 'course_id');
    }
}
