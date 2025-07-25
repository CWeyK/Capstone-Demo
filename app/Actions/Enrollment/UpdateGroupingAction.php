<?php

namespace App\Actions\Enrollment;
use App\Models\User;
use RuntimeException;
use App\Models\Subject;


class UpdateGroupingAction
{
    public function handle(array $validatedData, User $user, Subject $subject): void
    {
        //Check if exceed group capacity
        foreach ($validatedData['group'] as $classId => $groupId) {
            $group = $user->studentGroups()->find($groupId);
            if ($group && $group->students()->count() >= $group->capacity) {
                // dd("Group capacity exceeded for subject: {$group->subjectClass->subject->name} {$group->subjectClass->class_type}, Group No: {$group->group}");
                throw new RuntimeException("Group capacity exceeded for subject: {$group->subjectClass->subject->name} {$group->subjectClass->class_type}, Group No: {$group->group}");
            }
        }

        //detach existing group for this subject
        $user->studentGroups()->where('subject_id', $subject->id)->detach();
        // Sync new groups
        foreach ($validatedData['group'] as $classId => $groupId) {
            $user->studentGroups()->syncWithoutDetaching([$groupId]);
        }

    }
}
