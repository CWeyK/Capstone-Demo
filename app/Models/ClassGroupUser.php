<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassGroupUser extends Model
{
    protected $table = 'class_group_user';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classGroup()
    {
        return $this->belongsTo(ClassGroup::class);
    }
}
