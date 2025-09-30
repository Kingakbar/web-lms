<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'slug',
        'content',
        'video_url',
        'order',
        'duration'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
