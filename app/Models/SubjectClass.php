<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubjectClass extends Model
{
    protected $fillable = [
        'subject_id',
        'class_type',
        'duration',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function classGroups(): HasMany
    {
        return $this->hasMany(ClassGroup::class, 'subject_class_id', 'id');
    }
}
