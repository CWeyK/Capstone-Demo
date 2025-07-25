<?php

use Livewire\Volt\Component;
use App\Livewire\Forms\UserForm;
use App\Traits\LivewireAlert;
use Livewire\WithFileUploads;

new class extends Component {

    use LivewireAlert, WithFileUploads;

    public string $modalID = 'createUserModal', $modalTitle = 'Add a User';

    public UserForm $form;

    public function resetForm()
    {
        $this->form->reset('name', 'email', 'mobile_number', 'parent', 'avatar', 'agent', 'rank', 'type', 'role', 'avatar');
    }

    public function mount()
    {
        $this->form->roles = $this->form->initRoles();
    }

    public function store(): void
    {

        $validatedData = $this->form->validate();

        try {

            $this->form->storeUser(
                $validatedData
            );

            $this->dispatch('refreshDatatable');

            $this->alertSuccess(
                __('User has been created successfully.'),
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
            <x-label :name="__('Full Name')" :required="true" class="fw-bold mb-2" />
            <x-input wire:model="form.name" class="form-control-lg form-control-solid mb-3 mb-lg-0"
                placeholder="Full name" />
            <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
        </div>

        <div class="row mb-6">
            <div class="col-12 mb-6 mb-lg-0 col-lg-7">
                <x-label :name="__('Email')" :required="true" class="fw-bold mb-2" />
                <span class="ms-1" data-bs-toggle="tooltip"
                    title="Password will be auto-generated and sent to the user's email.">
                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                </span>
                <x-input type="email" wire:model="form.email" class="form-control-lg form-control-solid mb-3 mb-lg-0"
                    placeholder="example@domain.com" />
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>
        </div>

        <div class="fv-row mb-6">
            <x-label :name="__('Role')" :required="true" class="fw-bold mb-2" />
            <x-radio name="form.role" :options='$form->roles' model="form.role" />
            <x-input-error :messages="$errors->get('form.role')" class="mt-2" />
        </div>

        <x-slot:button>
            <x-button type="submit" class="btn-primary">
                <x-button-indicator :label="__('Create User')" target="store" />
            </x-button>
        </x-slot:button>
    </x-modal>
</div>
