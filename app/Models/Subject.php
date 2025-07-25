<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];


    public function lecturers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subject_lecturers', 'subject_id', 'user_id');
    }

    public function classes(): HasMany
    {
        return $this->hasMany(SubjectClass::class, 'subject_id', 'id');
    }

    public function programmes(): BelongsToMany
    {
        return $this->belongsToMany(Programme::class, 'programme_subject', 'subject_id', 'programme_id');
    }
}
