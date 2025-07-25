<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ClassGroup extends Model
{
    protected $fillable = [
        'subject_class_id',
        'group',
        'capacity',
        'lecturer',
        'time',
        'room_id',
    ];

    public function subjectClass()
    {
        return $this->belongsTo(SubjectClass::class, 'subject_class_id', 'id');
    }

    public function lecturerUser()
    {
        return $this->belongsTo(User::class, 'lecturer', 'id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function replacement()
    {
        return $this->hasMany(ClassReplacement::class,'class_group_id', 'id');
    }

    public function getStartTimeAttribute()
    {
        if(!isset($this->time)) {
            return null; // Handle case where time is not set
        }
        return Carbon::createFromFormat('H:i', explode('_', $this->time)[1])->format('g:i A');
    }

    public function getEndTimeAttribute()
    {
        if(!isset($this->time) || !isset($this->subjectClass)) {
            return null; // Handle case where time or subjectClass is not set
        }
        $startTime = Carbon::createFromFormat('H:i', explode('_', $this->time)[1]);

        // Add duration (make sure subjectClass relationship is loaded)
        $duration = $this->subjectClass->duration ?? 1; // default to 1 hour if not set
        $endTime = $startTime->copy()->addHours($duration);

        return $endTime->format('g:i A');
    }

    public function getDayAttribute()
    {
        if(!isset($this->time)) {
            return null; // Handle case where time is not set
        }
        return explode('_', $this->time)[0];
    }
}
