<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Programme extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
    ];

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'programme_subject', 'programme_id', 'subject_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(User::class, 'programme_id', 'id');
    }

}
