<?php

namespace App\Actions\Subject;

use App\Models\Subject;


class UpdateSubjectLecturerAction
{
    public function handle($validatedData, Subject $subject)
    {
        $subject->lecturers()->syncWithoutDetaching($validatedData['lecturers'] ?? []);
        return $subject;
    }
}
