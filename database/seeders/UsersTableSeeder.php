<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // === 1. Create fixed users (Admin, Lecturer, Student)
        $fixedUsers = [
            [
                'name' => 'Admin',
                'email' => 'test@mail.com',
                'password' => Hash::make('test'),
            ],
            [
                'name' => 'Lecturer',
                'email' => 'test2@mail.com',
                'password' => Hash::make('test'),
            ],
            [
                'name' => 'Student',
                'email' => 'test3@mail.com',
                'password' => Hash::make('test'),
            ],
        ];

        DB::table('users')->insert($fixedUsers);

        $adminId = 1;
        $lecturerId = 2;
        $studentId = 3;

        // === 2. Create 20 Lecturers
        $lecturers = [];
        for ($i = 1; $i <= 10; $i++) {
            $lecturers[] = [
                'name' => "Lecturer {$i}",
                'email' => "lecturer{$i}@mail.com",
                'password' => 'test',
            ];
        }

        DB::table('users')->insert($lecturers);
        $lecturerIds = range(4, 13); // 20 lecturers after the first 3 users
        
        // === 3. Create 500 Students
        $students = [];
        for ($i = 1; $i <= 500; $i++) {
            $students[] = [
                'name' => "Student {$i}",
                'email' => "student{$i}@mail.com",
                'password' => 'test',
            ];
        }

        DB::table('users')->insert($students);
        $studentIds = range(14, 523); // Next 500 IDs

        // === 4. Assign Roles
        $roles = Role::pluck('id', 'name');
        $roleAssignments = [
            ['role_id' => $roles['Super-Admin'], 'model_type' => User::class, 'model_id' => $adminId],
            ['role_id' => $roles['Lecturer'], 'model_type' => User::class, 'model_id' => $lecturerId],
            ['role_id' => $roles['Student'], 'model_type' => User::class, 'model_id' => $studentId],
        ];

        foreach ($lecturerIds as $id) {
            $roleAssignments[] = ['role_id' => $roles['Lecturer'], 'model_type' => User::class, 'model_id' => $id];
        }

        foreach ($studentIds as $id) {
            $roleAssignments[] = ['role_id' => $roles['Student'], 'model_type' => User::class, 'model_id' => $id];
        }

        DB::table('model_has_roles')->insert($roleAssignments);
    }
}
?>
