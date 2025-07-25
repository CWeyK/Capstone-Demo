<?php

use Livewire\Volt\Component;
use App\Models\Subject;
use App\Livewire\Forms\RescheduleClassForm;
use App\Traits\LivewireAlert;
new class extends Component {

    use LivewireAlert;

    public string $modalID = 'scheduleClassModal', $modalTitle = 'Schedule Class';

    public RescheduleClassForm $form;

    public ?Subject $subject;

    public function resetForm()
    {
    }

    public function mount()
    {
        $this->form->subject = $this->subject;
        $this->form->initFields();
    }

    public function store(): void
    {
        $validatedData = $this->form->validate();

        try {
            $this->form->scheduleClass(
                $validatedData,
            );

            $this->dispatch('subjectUpdated');

            $this->alertSuccess(
                __('Class has been scheduled successfully.'),
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
    <x-modal :id="$modalID" :title="$modalTitle" action="store">

        <div class="fv-row mb-6">
            <x-label name='Class' :required="true" class="fw-bold mb-2" />
            <x-select id="formClassType" wire:model="form.class" class="form-select-solid" :options="$this->form->classOptions"
                placeholder="Select Class" />
            <x-input-error :messages="$errors->get('form.class')" class="mt-2" />
        </div>

        <div class="fv-row mb-6">
            <x-label name='Location' :required="true" class="fw-bold mb-2" />
            <x-select id="formGroupLocation" wire:model="form.location" class="form-select-solid" :options="$this->form->locationOptions"
                placeholder="Select Location" />
            <x-input-error :messages="$errors->get('form.location')" class="mt-2" />
        </div>

        <div class="fv-row mb-6">
            <x-label name='Date and Time' :required="true" class="fw-bold mb-2" />
            <x-input type="datetime-local" wire:model="form.date" class="form-control-lg form-control-solid mb-3 mb-lg-0"/>
            <x-input-error :messages="$errors->get('form.date')" class="mt-2" />
        </div>

        <x-slot:button>
            <x-button type="submit" class="btn-primary">
                <x-button-indicator label='Save' target="store" />
            </x-button>
        </x-slot:button>
    </x-modal>
</div>
