<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class State extends Model
{
    protected $table = 'states';

    protected $fillable = [
        'name', 'code', 'country_id'
    ];


    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
