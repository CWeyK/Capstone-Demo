<?php

use Livewire\Volt\Component;
use App\Livewire\Forms\SubjectForm;
use App\Traits\LivewireAlert;

new class extends Component {

    use LivewireAlert;

    public string $modalID = 'createSubjectModal', $modalTitle = 'Create Subject';

    public SubjectForm $form;

    public function resetForm()
    {
        $this->form->reset();
    }

    public function mount()
    {
    }

    public function store(): void
    {

        $validatedData = $this->form->validate();

        try {

            $this->form->storeSubject(
                $validatedData
            );

            $this->dispatch('refreshDatatable');

            $this->alertSuccess(
                __('Subject has been created successfully.'),
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
            <x-label name='Subject Name' :required="true" class="fw-bold mb-2" />
            <x-input wire:model="form.name" class="form-control-lg form-control-solid mb-3 mb-lg-0"
                placeholder="Name" />
            <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
        </div>

        <x-slot:button>
            <x-button type="submit" class="btn-primary">
                <x-button-indicator label='Create Subject' target="store" />
            </x-button>
        </x-slot:button>
    </x-modal>
</div>
