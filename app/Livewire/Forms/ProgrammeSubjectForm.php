<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Programme;
use App\Models\Subject;
use App\Actions\Programme\UpdateProgrammeSubjectAction;


class ProgrammeSubjectForm extends Form
{
    public ?Programme $programme;
    public string $subject;
    public ?array $programmeSubjects;
    public ?array $subjectsOptions;

    protected function rules()
    {
        return [
            'subject'    => ['required', 'string'],
        ];
    }

    public function updateProgrammeSubject($validatedData, Programme $programme)
    {
        app(UpdateProgrammeSubjectAction::class)->handle(
            $validatedData,
            $programme
        );
    }

    public function initSubjectsOptions()
    {
        $this->programmeSubjects = $this->programme->subjects->pluck('id')->toArray();
        $this->subjectsOptions = Subject::all()->whereNotIn('id', $this->programmeSubjects)->pluck('name','id')->toArray();
    }

}
