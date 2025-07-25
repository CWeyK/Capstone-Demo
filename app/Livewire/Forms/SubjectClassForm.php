<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Subject;
use App\DataTransferObjects\SubjectClassDto;
use App\Actions\SubjectClass\CreateSubjectClassAction;
use App\Actions\SubjectClass\DeleteSubjectClassAction;
use App\Enum\ClassEnum;

class SubjectClassForm extends Form
{
    public ?Subject $subject;
    public array $classOptions;
    public string $type;
    public int $group;
    public int $duration;

    public function mount(){
        
    }

    protected function rules()
    {
        return [
            'type'      => ['required', 'string'],
            'group'     => ['required', 'integer', 'min:1'],
            'duration'  => ['required', 'integer', 'min:1'],
        ];
    }

    public function storeSubjectClass($validatedData, Subject $subject)
    {
        return app(CreateSubjectClassAction::class)->handle(
            SubjectClassDto::fromAppRequest($validatedData),
            $subject
        );
    }

    public function deleteSubjectClass($subjectClass)
    {
        return app(DeleteSubjectClassAction::class)->handle(
            $subjectClass
        );
    }

}
