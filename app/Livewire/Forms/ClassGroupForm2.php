<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Room;
use App\Models\ClassGroup;
use App\Actions\ClassGroup\UpdateClassGroup2Action;

class ClassGroupForm2 extends Form
{
    public ?ClassGroup $group;
    public array $locationOptions = [];
    public array $dayOptions = [];
    public string $location;
    public string $day;
    public int $time;

    public function mount(){
        
    }

    protected function rules()
    {
        return [
            'location'      => ['required', 'string'],
            'day'           => ['required', 'string'],
            'time'          => ['required', 'integer','min:8','max:24'],
        ];
    }

    public function editClassGroup($validatedData, ClassGroup $group)
    {
        return app(UpdateClassGroup2Action::class)->handle(
            $validatedData,
            $group
        );
    }

    public function initFields()
    {
        $this->locationOptions = Room::all()->pluck('location', 'id')->toArray();
        $this->dayOptions = [
            'Mon' => 'Monday',
            'Tue' => 'Tuesday',
            'Wed' => 'Wednesday',
            'Thu' => 'Thursday',
            'Fri' => 'Friday',
        ];
    }

}
