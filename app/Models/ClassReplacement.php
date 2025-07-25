<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassReplacement extends Model
{
    protected $fillable = [
        'class_group_id',
        'status',
        'date',
        'time',
        'room_id',
    ];

    public function classGroup()
    {
        return $this->belongsTo(ClassGroup::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
