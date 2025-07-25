<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'location',
        'capacity',
    ];

    public function classGroups()
    {
        return $this->hasMany(ClassGroup::class, 'room_id', 'id');
    }

    public function replacements()
    {
        return $this->hasMany(ClassReplacement::class, 'room_id', 'id');
    }
}
