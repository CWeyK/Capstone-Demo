<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Subject;
use App\Models\Programme;
use App\Models\enrollmentToggle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\DataTransferObjects\SubjectClassDto;
use App\Actions\SubjectClass\CreateSubjectClassAction;

class ProgrammesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        enrollmentToggle::create([
            'enrollment' => 'Pre-Enrollment',
        ]);

        //Sep 2023 intake direct entry sem 6 (april 2024)
        // Programme::factory()->count(10)->create();
        $bcs = Programme::factory()->create(['name' => 'Bachelor of Computer Science']);
        $bcns = Programme::factory()->create(['name' => 'Bachelor of Computer Networking and Security']);
        $bse = Programme::factory()->create(['name' => 'Bachelor of Software Engineering']);
        $bsda = Programme::factory()->create(['name' => 'Bachelor of Information Systems & Data Analytics']);
        $bit = Programme::factory()->create(['name' => 'Bachelor of Information Technology']);

        $subjects = Subject::factory()->createMany([
            ['name' => 'Data Structures and Algorithms'],
            ['name' => 'Communication Skills'],
            ['name' => 'Software Engineering'],
            ['name' => 'Artificial Intelligence'],
            ['name' => 'Operating System Fundamentals'],
            ['name' => 'Network and System Administration'],
            ['name' => 'Computer Ethical Hacking and Coutnermeasures'],
            ['name' => 'Software Processes'],
            ['name' => 'Object-Oriented Programming'],
            ['name' => 'Social Media Analytics'],
            ['name' => 'Information Systems Analysis & Designs'],
            ['name' => 'Database Management Systems'],
            ['name' => 'Applied Statistics'],
            ['name' => 'Project Management'],
        ]);

        // Assign subjects to the programme
        $bcs->subjects()->attach([
            $subjects[0]->id, // Data Structures and Algorithms
            $subjects[1]->id, // Communication Skills
            $subjects[2]->id, // Software Engineering
            $subjects[3]->id, // Artificial Intelligence
            $subjects[4]->id, // Operating System Fundamentals
        ]);
        $bcns->subjects()->attach([
            $subjects[1]->id, // Communication Skills
            $subjects[5]->id, // Network and System Administration
            $subjects[6]->id, // Computer Ethical Hacking and Countermeasures
            $subjects[11]->id, // Database Management Systems
        ]);
        $bse->subjects()->attach([
            $subjects[0]->id, // Data Structures and Algorithms
            $subjects[13]->id, // Project Management
            $subjects[7]->id, // Software Processes
            $subjects[8]->id, // Object-Oriented Programming
        ]);
        $bsda->subjects()->attach([
            $subjects[9]->id, // Social Media Analytics
            $subjects[10]->id, // Information Systems Analysis & Designs
            $subjects[11]->id, // Database Management Systems
            $subjects[12]->id, // Applied Statistics
        ]);
        $bit->subjects()->attach([
            $subjects[13]->id, // Project Management
            $subjects[0]->id, // Data Structures and Algorithms
            $subjects[4]->id, // Operating System Fundamentals
            $subjects[8]->id, // Object-Oriented Programming
        ]);

        //Create classes for all subjects
        $lectureData = [
            'type' => 'Lecture',
            'group' => 1, // Default group count, can be adjusted as needed
            'duration' => rand(1, 2), // Default duration in hours, can be adjusted as needed
        ];
        $tutorialData = [
            'type' => 'Tutorial',
            'group' => 3, // Default group count, can be adjusted as needed
            'duration' => 2, // Default duration in hours, can be adjusted as needed
        ];
        foreach ($subjects as $subject) {
            app(CreateSubjectClassAction::class)->handle(
                SubjectClassDto::fromAppRequest($lectureData),
                $subject
            );
            app(CreateSubjectClassAction::class)->handle(
                SubjectClassDto::fromAppRequest($tutorialData),
                $subject
            );
        }

        //Assign lecturers
        foreach ($subjects as $subject) {
            // Assign lecturers to the subject
            $lecturers = User::role('Lecturer')->inRandomOrder()->take(rand(2, 3))->get();
            $subject->lecturers()->sync($lecturers->pluck('id'));
            foreach ($subject->classes as $class) {
                if ($class->class_type === 'Lecture') {
                    foreach ($class->classGroups as $group) {
                        $group->update([
                            'capacity' => 250,
                            'lecturer' => $lecturers->random()->id,
                        ]);
                    }
                } elseif ($class->class_type === 'Tutorial') {
                    foreach ($class->classGroups as $group) {
                        $group->update([
                            'capacity' => 75,
                            'lecturer' => $lecturers->random()->id,
                        ]);
                    }
                }
            }
        }

        // Assign students to each programme
        $programmes = Programme::all();
        $students = User::role('Student')->get();

        $studentChunks = $students->chunk(80);
        foreach ($programmes as $index => $programme) {
            if (isset($studentChunks[$index])) {
                foreach ($studentChunks[$index] as $student) {
                    $student->update([
                        'programme_id' => $programme->id,
                    ]);
                }
            }
        }
    }
}
