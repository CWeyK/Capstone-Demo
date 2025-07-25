<?php

use Livewire\Volt\Component;
use App\Livewire\Forms\RoomForm;
use App\Traits\LivewireAlert;

new class extends Component {

    use LivewireAlert;

    public string $modalID = 'createRoomModal', $modalTitle = 'Create Room';

    public RoomForm $form;

    public function resetForm()
    {
        $this->form->reset('location', 'capacity');
    }

    public function mount()
    {
    }

    public function store(): void
    {

        $validatedData = $this->form->validate();

        try {

            $this->form->storeRoom(
                $validatedData
            );

            $this->dispatch('refreshDatatable');

            $this->alertSuccess(
                __('Room has been created successfully.'),
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
            <x-input wire:model="form.location" class="form-control-lg form-control-solid mb-3 mb-lg-0"
                placeholder="Location/Name" />
            <x-input-error :messages="$errors->get('form.location')" class="mt-2" />
        </div>

        <div class="row mb-6">
            <x-label name='Capacity' :required="true" class="fw-bold mb-2" />
            <x-input type="number" wire:model="form.capacity" class="form-control-lg form-control-solid mb-3 mb-lg-0"
                placeholder="Capacity" />
            <x-input-error :messages="$errors->get('form.capacity')" class="mt-2" />
        </div>

        <x-slot:button>
            <x-button type="submit" class="btn-primary">
                <x-button-indicator :label="__('Create Room')" target="store" />
            </x-button>
        </x-slot:button>
    </x-modal>
</div>
