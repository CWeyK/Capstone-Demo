<?php

use Livewire\Volt\Component;
use App\Models\ClassGroup;
use App\Livewire\Forms\ClassGroupForm2;
use App\Traits\LivewireAlert;
use Livewire\Attributes\On;

new class extends Component {

    use LivewireAlert;

    public string $modalID = 'editGroupModal2', $modalTitle = 'Edit Group';

    public ClassGroupForm2 $form;

    public ?ClassGroup $group;

    public function resetForm()
    {
    }

    public function mount()
    {
       
    }

    #[On('editGroup')]
    public function loadGroup(int $id)
    {
        $this->group = ClassGroup::findOrFail($id);
        $this->form->group = $this->group;
        $this->form->initFields();
        $this->dispatch('select2-options-updated', selectId: 'formGroupLocation', data: $this->form->locationOptions);
        $this->dispatch('select2-options-updated', selectId: 'formGroupDay', data: $this->form->dayOptions);
    }

    public function store(): void
    {

        $validatedData = $this->form->validate();

        try {
            $this->form->editClassGroup(
                $validatedData,
                $this->form->group
            );

            $this->dispatch('subjectUpdated');

            $this->alertSuccess(
                __('Group has been updated successfully.'),
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
            <x-label name='Location' :required="true" class="fw-bold mb-2" />
            <x-select id="formGroupLocation" wire:model="form.location" class="form-select-solid" :options="$this->form->locationOptions"
                placeholder="Select Location" />
            <x-input-error :messages="$errors->get('form.location')" class="mt-2" />
        </div>

        <div class="fv-row mb-6">
            <x-label name='Day' :required="true" class="fw-bold mb-2" />
            <x-select id="formGroupDay" wire:model="form.day" class="form-select-solid" :options="$this->form->dayOptions"
                placeholder="Select Day" />
            <x-input-error :messages="$errors->get('form.day')" class="mt-2" />
        </div>



        <div class="fv-row mb-6">
            <x-label name='Start time (24 Hour format)' :required="true" class="fw-bold mb-2" />
            <x-input type="number" wire:model="form.time" class="form-control-lg form-control-solid mb-3 mb-lg-0"
                placeholder="Eg: '14' (2:00 P.M.)" />
            <x-input-error :messages="$errors->get('form.time')" class="mt-2" />
        </div>

        <x-slot:button>
            <x-button type="submit" class="btn-primary">
                <x-button-indicator label='Save' target="store" />
            </x-button>
        </x-slot:button>
    </x-modal>
</div>
