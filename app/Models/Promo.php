<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'code',
        'discount_percentage',
        'discount_amount',
        'start_date',
        'end_date'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
