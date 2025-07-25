<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Programme;
use App\Models\User;
use App\Actions\Programme\UpdateProgrammeStudentAction;


class ProgrammeStudentForm extends Form
{
    public ?Programme $programme;
    public string $students;
    public ?array $programmeSubjects;
    public ?array $studentsOptions;

    protected function rules()
    {
        return [
            'students'    => ['required', 'string'],
        ];
    }

    public function updateProgrammeStudent($validatedData, Programme $programme)
    {
        app(UpdateProgrammeStudentAction::class)->handle(
            $validatedData,
            $programme
        );
    }

    public function initStudentsOptions()
    {
        $this->studentsOptions = User::whereNull('programme_id')
            ->whereHas('roles', function ($q) {
                $q->where('name', 'Student');
            })
            ->pluck('name', 'id')
            ->toArray();

    }

}
