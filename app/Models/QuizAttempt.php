<?php

namespace App\Models;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $fillable = ['quiz_id', 'user_id', 'score', 'passed'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
