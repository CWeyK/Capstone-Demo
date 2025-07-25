<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Subject;
use Illuminate\Validation\Rule;
use App\DataTransferObjects\EnrollmentDto;
use App\Actions\Enrollment\StoreEnrollmentAction;
use App\Actions\Enrollment\CreateEnrollmentAction;

class EnrollmentForm extends Form
{
    public string $name = '';
    public $groupOptions = [];
    public $group = [];
    public $subjects;

    protected function rules()
    {
        $rules = [
        'group' => ['required', 'array'],
        ];

        // Loop through each class and require its specific key
        foreach ($this->expectedClassIds() as $classId) {
            $rules["group.$classId"] = ['required'];
        }
        // dd($rules);
        return $rules;
    }
    public function storeEnrollment($validatedData, $user)
    {
        app(StoreEnrollmentAction::class)->handle(
            $validatedData,
            $user
        );
    }

    public function initGroupOptions($subjects)
    {
        foreach ($subjects as $subject) {
            foreach ($subject->classes as $class) {
                $this->groupOptions[$class->id] = $class->classGroups
                    ->mapWithKeys(fn ($group) => [$group->id => 'Group ' . $group->group . ' - ' . $group->lecturerUser->name])
                    ->toArray();
            }
        }
    }

    protected function expectedClassIds(): array
    {
        $this->subjects =  auth()->user()->programme->subjects ?? collect();
        return collect($this->subjects)
            ->flatMap(fn($subject) => $subject->classes)
            ->pluck('id')
            ->toArray();
    }



}
