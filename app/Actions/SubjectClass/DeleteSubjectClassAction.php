<?php

namespace App\Actions\SubjectClass;

use App\Models\SubjectClass;
use Illuminate\Support\Facades\DB;

class DeleteSubjectClassAction
{
    public function handle($subjectClass)
    {
        return DB::transaction(static function () use ($subjectClass) {
            $class = SubjectClass::findOrFail($subjectClass);

            $class->classGroups()->delete();

            $class->delete();
            
        });
    }

}
