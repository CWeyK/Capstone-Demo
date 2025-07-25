<?php

use Livewire\Volt\Component;
use App\Models\Subject;
use App\Livewire\Forms\SubjectClassForm;
use App\Traits\LivewireAlert;
use App\Enum\ClassEnum;

new class extends Component {

    use LivewireAlert;

    public string $modalID = 'createClassModal', $modalTitle = 'Create Class';

    public SubjectClassForm $form;

    public ?Subject $subject;

    public function resetForm()
    {
    }

    public function mount()
    {
        $this->form->subject = $this->subject;
        $this->form->classOptions = collect(ClassEnum::cases())->mapWithKeys(function ($case) {
            return [$case->value => ucfirst($case->name)];
        })->toArray();
    }

    public function store(): void
    {

        $validatedData = $this->form->validate();

        try {
            $this->form->storeSubjectClass(
                $validatedData,
                $this->subject
            );

            $this->dispatch('subjectUpdated');

            $this->alertSuccess(
                __('Class has been added successfully.'),
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
            <x-label name='Class Type' :required="true" class="fw-bold mb-2" />
            <x-select id="formClassType" wire:model="form.type" class="form-select-solid" :options="$this->form->classOptions"
                placeholder="Select Class Type" />
            <x-input-error :messages="$errors->get('form.type')" class="mt-2" />
        </div>

        <div class="fv-row mb-6">
            <x-label name='Number of Groups' :required="true" class="fw-bold mb-2" />
            <x-input type="number" wire:model="form.group" class="form-control-lg form-control-solid mb-3 mb-lg-0"
                placeholder="Number of Groups" />
            <x-input-error :messages="$errors->get('form.group')" class="mt-2" />
        </div>

        <div class="fv-row mb-6">
            <x-label name='Duration (Hours)' :required="true" class="fw-bold mb-2" />
            <x-input type="number" wire:model="form.duration" class="form-control-lg form-control-solid mb-3 mb-lg-0"
                placeholder="Hours" />
            <x-input-error :messages="$errors->get('form.duration')" class="mt-2" />
        </div>

        <x-slot:button>
            <x-button type="submit" class="btn-primary">
                <x-button-indicator label='Save' target="store" />
            </x-button>
        </x-slot:button>
    </x-modal>
</div>
