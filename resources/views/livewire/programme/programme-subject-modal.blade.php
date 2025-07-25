<?php

use Livewire\Volt\Component;
use App\Models\Programme;
use App\Livewire\Forms\ProgrammeSubjectForm;
use App\Traits\LivewireAlert;

new class extends Component {

    use LivewireAlert;

    public string $modalID = 'assignSubjectModal', $modalTitle = 'Assign Subjects';

    public ProgrammeSubjectForm $form;

    public ?Programme $programme;

    public function resetForm()
    {
        $this->form->initSubjectsOptions();
        $this->dispatch('select2-options-updated', 'formSubject', $this->form->subjectsOptions);
    }

    public function mount()
    {
        $this->form->programme = $this->programme;
        $this->form->initSubjectsOptions();
    }

    public function store(): void
    {

        $validatedData = $this->form->validate();

        try {
            $this->form->updateProgrammeSubject(
                $validatedData,
                $this->programme
            );

            $this->dispatch('refreshDatatable');
            $this->dispatch('programmeRefresh');

            $this->alertSuccess(
                __('Subject has been assigned successfully.'),
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
            <x-label name='Subjects' :required="true" class="fw-bold mb-2" />
            <x-select id="formSubject" wire:model="form.subject" class="form-select-solid" :options="$this->form->subjectsOptions"
                placeholder="Select Subject" />
            <x-input-error :messages="$errors->get('form.subject')" class="mt-2" />
        </div>

        <x-slot:button>
            <x-button type="submit" class="btn-primary">
                <x-button-indicator label='Save' target="store" />
            </x-button>
        </x-slot:button>
    </x-modal>
</div>
