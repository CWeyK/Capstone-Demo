<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Validation\Rule;
use App\Actions\Enrollment\UpdateGroupingAction;

class SubjectGroupingForm extends Form
{
    public string $name = '';
    public string $currency = '';
    public Subject  $subject;
    public User $user;
    public $groupOptions = [];
    public $group = [];

    protected function rules()
    {
        $rules = [
        'group' => ['required', 'array'],
        ];

        // Loop through each class and require its specific key
        foreach ($this->subject->classes as $class) {
            $rules["group.$class->id"] = ['required'];
        }
        // dd($rules);
        return $rules;
    }
    public function updateGrouping($validatedData, User $user, Subject $subject)
    {
        app(UpdateGroupingAction::class)->handle(
            $validatedData,
            $user,
            $subject
        );
    }

    public function setUser($id){
        $this->user = User::find($id);
        $this->initGroupOptions($this->subject);
    }

    public function initGroupOptions($subject)
    {
        foreach ($subject->classes as $class) {
            $this->groupOptions[$class->id] = $class->classGroups
                ->mapWithKeys(fn ($group) => [$group->id => 'Group ' . $group->group . ' - ' . $group->lecturerUser->name])
                ->toArray();
        }
        // dd($this->groupOptions);
    }

}
