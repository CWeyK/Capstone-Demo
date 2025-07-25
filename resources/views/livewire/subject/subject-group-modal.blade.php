<?php

use Livewire\Volt\Component;
use App\Models\ClassGroup;
use App\Livewire\Forms\ClassGroupForm;
use App\Traits\LivewireAlert;
use Livewire\Attributes\On;

new class extends Component {

    use LivewireAlert;

    public string $modalID = 'editGroupModal', $modalTitle = 'Edit Group';

    public ClassGroupForm $form;

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
        $this->dispatch('select2-options-updated', selectId: 'formGroupLecturer', data: $this->form->lecturerOptions);
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
            <x-label name='Group Lecturer' :required="true" class="fw-bold mb-2" />
            <x-select id="formGroupLecturer" wire:model="form.lecturer" class="form-select-solid" :options="$this->form->lecturerOptions"
                placeholder="Select Lecturer" />
            <x-input-error :messages="$errors->get('form.lecturer')" class="mt-2" />
        </div>

        <div class="fv-row mb-6">
            <x-label name='Capacity' :required="true" class="fw-bold mb-2" />
            <x-input type="number" wire:model="form.capacity" class="form-control-lg form-control-solid mb-3 mb-lg-0"
                placeholder="Capacity" />
            <x-input-error :messages="$errors->get('form.capacity')" class="mt-2" />
        </div>

        <x-slot:button>
            <x-button type="submit" class="btn-primary">
                <x-button-indicator label='Save' target="store" />
            </x-button>
        </x-slot:button>
    </x-modal>
</div>
