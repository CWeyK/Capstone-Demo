<?php

use Livewire\Volt\Component;
use App\Models\Subject;
use App\Livewire\Forms\SubjectLecturerForm;
use App\Traits\LivewireAlert;

new class extends Component {

    use LivewireAlert;

    public string $modalID = 'assignLecturerModal', $modalTitle = 'Assign Lecturers';

    public SubjectLecturerForm $form;

    public ?Subject $subject;

    public function resetForm()
    {
        $this->form->initLecturersOptions();
        $this->dispatch('select2-options-updated', 'formLecturer', $this->form->lecturersOptions);
    }

    public function mount()
    {
        $this->form->subject = $this->subject;
        $this->form->initLecturersOptions();
    }

    public function store(): void
    {

        $validatedData = $this->form->validate();

        try {
            $this->form->updateSubjectLecturer(
                $validatedData,
                $this->subject
            );

            $this->dispatch('refreshDatatable');

            $this->alertSuccess(
                __('Lecturers has been assigned successfully.'),
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
            <x-label name='Subject Lecturers' :required="true" class="fw-bold mb-2" />
            <x-select id="formLecturer" wire:model="form.lecturers" class="form-select-solid" :options="$this->form->lecturersOptions"
                placeholder="Select Lecturers" />
            <x-input-error :messages="$errors->get('form.lecturers')" class="mt-2" />
        </div>

        <x-slot:button>
            <x-button type="submit" class="btn-primary">
                <x-button-indicator label='Save' target="store" />
            </x-button>
        </x-slot:button>
    </x-modal>
</div>
