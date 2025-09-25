<?php

namespace App\Models;

use App\Models\Lesson;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Model;

class LessonCompletion extends Model
{
    protected $fillable = [
        'enrollment_id',
        'lesson_id',
        'is_completed',
        'completed_at',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    // Relasi
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
