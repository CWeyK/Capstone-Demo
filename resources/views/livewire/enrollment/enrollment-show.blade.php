<?php

use Livewire\Volt\Component;
use App\Traits\LivewireAlert;
use App\Models\Subject;
use App\Livewire\Forms\EnrollmentForm;

new class extends Component {

    use LivewireAlert;

    public $subjects;
    public EnrollmentForm $form;

    public function mount()
    {
        //get subjects of logged in user
        $this->subjects = auth()->user()->programme->subjects ?? collect();
        $this->form->initGroupOptions($this->subjects);
        // dd($this->form->groupOptions);
    }

    public function store(): void
    {
        $validatedData = $this->form->validate();
        try {
            $this->form->storeEnrollment(
                $validatedData, 
                auth()->user()
            );

            $this->alertSuccess(
                __('Enrollment successfull.'),
                [
                    'timer' => 3000,
                    'onConfirmed' => 'close-modal',
                    'onProgressFinished' => 'close-modal',
                    'onDismissed' => 'close-modal'
                ]
            );

        } catch (Throwable $e) {

            $this->alertError($e->getMessage());
        }
    }

}; ?>

<div>
    <form id="enrollment_form"
        wire:submit='store'>
    @foreach ($subjects as $subject)
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <x-card-title>
                <h3 class="fw-bold m-0">{{ $subject->name }}</h3>
            </x-card-title>
        </div>

        <div class="card-body p-9">
            @forelse ($subject->classes as $class)
            <div class="mb-3">
                <x-label :name="ucfirst($class->class_type) . ' Group'" class="fw-bold mb-2" />

                <x-select id="formGroup{{ $class->id }}" wire:model="form.group.{{ $class->id }}"
                    class="form-select-solid" :search="false" :options="$form->groupOptions[$class->id] ?? []"
                    placeholder="Select Grouping" :search="false"/>

                <x-input-error :messages="$errors->get('form.group.' . $class->id)" class="mt-2" />
            </div>
            @empty
            <div class="text-muted">No classes available for this subject.</div>
            @endforelse
        </div>
    </div>
    @endforeach

    <x-input-error :messages="$errors->all()" class="mt-2" />
    <div class="text-end">
        <x-button type="submit" class="btn-primary">
            <x-button-indicator label='Submit Enrollment' target="store" />
        </x-button>
    </div>

    </form>
</div>
