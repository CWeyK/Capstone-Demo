<?php

namespace App\Actions\Enrollment;
use RuntimeException;

use App\Models\User;


class StoreEnrollmentAction
{
    public function handle(array $validatedData, User $user): void
    {
        // dd($validatedData);
        //Check if exceed group capacity
        foreach ($validatedData['group'] as $classId => $groupId) {
            $group = $user->studentGroups()->find($groupId);
            if ($group && $group->students()->count() >= $group->capacity) {
                // dd("Group capacity exceeded for subject: {$group->subjectClass->subject->name} {$group->subjectClass->class_type}, Group No: {$group->group}");
                throw new RuntimeException("Group capacity exceeded for subject: {$group->subjectClass->subject->name} {$group->subjectClass->class_type}, Group No: {$group->group}");
            }
        }

        //detach all existing groups first
        $user->studentGroups()->detach();

        foreach ($validatedData['group'] as $classId => $groupId) {
            $user->studentGroups()->syncWithoutDetaching([$groupId]);
        }
    }
}
