<?php

namespace App\Models;

use App\Models\User;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Certificate;
use App\Models\LessonCompletion;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = ['user_id', 'course_id', 'enrolled_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // === Relasi baru ===
    public function lessonCompletions()
    {
        return $this->hasMany(LessonCompletion::class);
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }
}
