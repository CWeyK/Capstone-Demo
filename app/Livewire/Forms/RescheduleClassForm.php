<?php

namespace App\Livewire\Forms;

use Carbon\Carbon;
use Livewire\Form;
use App\Models\Room;
use App\Models\Subject;
use App\Actions\ClassGroup\CancelClassAction;
use App\Actions\ClassGroup\ScheduleClassAction;

class RescheduleClassForm extends Form
{
    public ?Subject $subject;
    public array $classOptions = [];
    public array $locationOptions = [];
    public array $dayOptions = [];
    public string $class;
    public string $location;
    public string $date;
    public int $time;

    public function mount() {}

    protected function rules()
    {
        return [
        'class' => ['required', 'string'],
        'location' => ['required', 'string'],
        'date' => [
            'required',
            'string',
            function ($attribute, $value, $fail) {
                try {
                    $dt = Carbon::parse($value);
                    if ((int) $dt->minute !== 0) {
                        $fail('The :attribute must be on the hour (e.g. 8:00, 10:00).');
                    }
                } catch (\Exception $e) {
                    $fail('The :attribute must be a valid date.');
                }
            },
        ],
    ];
    }

    public function cancelClass($groupId, $date)
    {
        return app(CancelClassAction::class)->handle(
            $groupId,
            $date
        );
    }

    public function scheduleClass($validatedData)
    {
        return app(ScheduleClassAction::class)->handle(
            $validatedData
        );
    }

    public function initFields()
    {
        $this->classOptions = $this->subject->classes
            ->flatMap(
                fn($class) =>
                $class->classGroups->map(fn($group) => [
                    'id' => $group->id,
                    'name' => $class->class_type . ' - Group ' . $group->group
                ])
            )
            ->pluck('name', 'id')
            ->toArray();

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
