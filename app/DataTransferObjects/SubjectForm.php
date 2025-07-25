<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Subject;
use Illuminate\Validation\Rule;
use App\DataTransferObjects\SubjectDto;
use App\Actions\Subject\CreateSubjectAction;

class SubjectForm extends Form
{
    public string $name = '';
    public ?Subject $subject = null;

    protected function rules()
    {
        return [
            'name'   => ['required', 'string', Rule::unique('subjects', 'name')->ignore($this->subject?->id)],
        ];
    }
    public function storeSubject($validatedData)
    {
        app(CreateSubjectAction::class)->handle(SubjectDto::fromAppRequest($validatedData));
    }

}
