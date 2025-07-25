<?php

use Livewire\Volt\Component;
use App\Models\Programme;
use App\Livewire\Forms\ProgrammeStudentForm;
use App\Traits\LivewireAlert;

new class extends Component {

    use LivewireAlert;

    public string $modalID = 'assignStudentModal', $modalTitle = 'Assign Students';

    public ProgrammeStudentForm $form;

    public ?Programme $programme;

    public function resetForm()
    {
        $this->form->initStudentsOptions();
        $this->dispatch('select2-options-updated', 'formStudent', $this->form->studentsOptions);
        
    }

    public function mount()
    {
        $this->form->programme = $this->programme;
        $this->form->initStudentsOptions();
    }

    public function store(): void
    {

        $validatedData = $this->form->validate();

        try {
            $this->form->updateProgrammeStudent(
                $validatedData,
                $this->programme
            );

            $this->dispatch('refreshDatatable');

            $this->alertSuccess(
                __('Students have been assigned successfully.'),
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
            <x-label name='Students' :required="true" class="fw-bold mb-2" />
            <x-select id="formStudent" wire:model="form.students" class="form-select-solid" :options="$this->form->studentsOptions"
                placeholder="Select Students" />
            <x-input-error :messages="$errors->get('form.students')" class="mt-2" />
        </div>

        <x-slot:button>
            <x-button type="submit" class="btn-primary">
                <x-button-indicator label='Save' target="store" />
            </x-button>
        </x-slot:button>
    </x-modal>
</div>
