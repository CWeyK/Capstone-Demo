<?php

use Livewire\Volt\Component;
use App\Traits\LivewireAlert;
use Livewire\Attributes\On;
use App\Livewire\Forms\SubjectGroupingForm;
use App\Models\Subject;

new class extends Component {

    use LivewireAlert;

    public string $modalID = 'updateGroupingModal', $modalTitle = 'Grouping Details';

    public SubjectGroupingForm $form;

    public ?Subject $subject;

    public function mount()
    {
        $this->form->subject = $this->subject;
    }

    public function resetForm(){

    }

    public function store(): void
    {

        $validatedData = $this->form->validate();

        try {

            $this->form->updateGrouping(
                $validatedData,
                $this->form->user,
                $this->form->subject
            );

            $this->dispatch('refreshDatatable');

            $this->alertSuccess(
                __('Grouping has been updated successfully.'),
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

    #[On('editGrouping')]
    public function initGrouping($id){
        $this->form->setUser($id);

        foreach ($this->form->subject->classes as $class){
            $this->dispatch('select2-options-updated', selectId: 'formGroup' . $class->id, data: $this->form->groupOptions[$class->id]);
        }
        
    }

}; ?>

<div>
    <x-modal :id="$modalID" :title="$modalTitle" action="store">

        @forelse ($form->subject->classes as $class)
        <div class="fv-row mb-6">
            <x-label :name="ucfirst($class->class_type) . ' Group'" class="fw-bold mb-2" />

            <x-select id="formGroup{{ $class->id }}" wire:model="form.group.{{ $class->id }}"
                class="form-select-solid" :search="false" :options="$form->groupOptions[$class->id] ?? []"
                placeholder="Select Grouping" :search="false"/>

            <x-input-error :messages="$errors->get('form.group.' . $class->id)" class="mt-2" />
        </div>
        @empty
        <div class="text-muted">No classes available for this subject.</div>
        @endforelse

        <x-slot:button>
            <x-button type="submit" class="btn-primary">
                <x-button-indicator :label="__('Update Grouping')" target="store" />
            </x-button>
        </x-slot:button>
    </x-modal>
</div>
