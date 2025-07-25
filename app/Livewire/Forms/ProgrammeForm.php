<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Programme;
use Illuminate\Validation\Rule;
use App\DataTransferObjects\ProgrammeDto;
use App\Actions\Programme\CreateProgrammeAction;

class ProgrammeForm extends Form
{
    public string $name = '';
    public ?Programme $programme = null;

    protected function rules()
    {
        return [
            'name'   => ['required', 'string', Rule::unique('programmes', 'name')->ignore($this->programme?->id)],
        ];
    }
    public function storeProgramme($validatedData)
    {
        app(CreateProgrammeAction::class)->handle(ProgrammeDto::fromAppRequest($validatedData));
    }

}
