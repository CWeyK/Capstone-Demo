<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class enrollmentToggle extends Model
{
    protected $table = 'enrollment_toggle';

    protected $fillable = [
        'enrollment',
    ];

}
