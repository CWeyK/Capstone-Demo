<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Subject;
use App\Models\User;
use App\Actions\Subject\UpdateSubjectLecturerAction;


class SubjectLecturerForm extends Form
{
    public ?Subject $subject;
    public ?User $user = null;
    public string $lecturers;
    public array $subjectLecturers;
    public ?array $lecturersOptions;

    protected function rules()
    {
        return [
            'lecturers'    => ['required', 'string'],
        ];
    }

    public function updateSubjectLecturer($validatedData, Subject $subject)
    {
        app(UpdateSubjectLecturerAction::class)->handle(
            $validatedData,
            $subject
        );
    }

    public function initLecturersOptions()
    {
        $this->subjectLecturers = $this->subject->lecturers->pluck('id')->toArray();
        $this->lecturersOptions = User::role('Lecturer')->whereNotIn('id', $this->subjectLecturers)->pluck('name','id')->toArray();
    }

}
