<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Enroll students
        $students = User::role('Student')->whereNotNull('programme_id')->get();

        foreach ($students as $student) {
            $subjects = $student->programme?->subjects ?? [];

            foreach ($subjects as $subject) {
                foreach ($subject->classes as $subjectClass) {
                    // Only select groups with remaining capacity
                    $availableGroups = $subjectClass->classGroups->filter(function ($group) {
                        return $group->students()->count() < $group->capacity;
                    });

                    if ($availableGroups->isEmpty()) {
                        continue; // Skip if no group has space
                    }

                    $group = $availableGroups->random();

                    // Enroll the student
                    $student->studentGroups()->syncWithoutDetaching([$group->id]);
                }
            }
        }
        
    }
}
