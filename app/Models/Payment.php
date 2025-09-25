<?php

namespace App\Models;

use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'enrollment_id',
        'amount',
        'method',
        'status',
        'paid_at'
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
