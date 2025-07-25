<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\ClassGroup;
use App\DataTransferObjects\ClassGroupDto;
use App\Actions\ClassGroup\UpdateClassGroupAction;

class ClassGroupForm extends Form
{
    public ?ClassGroup $group;
    public array $lecturerOptions = [];
    public string $lecturer;
    public int $capacity;

    public function mount(){
        
    }

    protected function rules()
    {
        return [
            'lecturer'      => ['required', 'string'],
            'capacity'      => ['required', 'integer', 'min:0'],
        ];
    }

    public function editClassGroup($validatedData, ClassGroup $group)
    {
        return app(UpdateClassGroupAction::class)->handle(
            $validatedData,
            $group
        );
    }

    public function initFields()
    {
        $this->lecturerOptions = $this->group->subjectClass->subject->lecturers->pluck('name', 'id')->toArray();
        $this->lecturer = $this->group->lecturer_id ?? '';
        $this->capacity = $this->group->capacity;
    }

}
