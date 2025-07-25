<?php

use Livewire\Volt\Component;
use Spatie\Permission\Models\Role;
use App\Livewire\Forms\RoleForm;
use App\Traits\LivewireAlert;

new class extends Component {

    use LivewireAlert;

    public string $modalID = 'editRoleModal', $modalTitle = 'Role Details';

    public array $selectedPermissions;

    public RoleForm $form;

    public Role $role;

    public function resetForm()
    {
        $this->form->name = $this->role->name;
        $this->form->selectedPermissions = $this->role->permissions->pluck('id')->toArray();
        $this->form->permissions = $this->form->getAllPermissions();
    }

    public function mount()
    {
        $this->form->setRole($this->role);
        $this->form->name = $this->role->name;
        $this->form->selectedPermissions = $this->role->permissions->pluck('id')->toArray();
        $this->form->permissions = $this->form->getAllPermissions();
    }


    public function update(): void
    {

        $validatedData = $this->form->validate();

        try {

            $this->form->updateRole(
                $validatedData,
                $this->role
            );

            $this->dispatch('refreshDatatable');
            $this->dispatch('roleUpdated');

            $this->alertSuccess(
                __('Role has been updated successfully.'),
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
    <x-modal :id="$modalID" :title="$modalTitle" action="update">

        <div class="fv-row mb-6">
            <x-label :name="__('Role Name')" :required="true" class="fw-bold mb-2" />
            <x-input wire:model="form.name" class="form-control-lg form-control-solid mb-3 mb-lg-0"
                placeholder="Role Name" />
            <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
        </div>

        <div class="fv-row mb-6">
            <x-label :name="__('Role Permissions')" :required="false" class="fw-bold mb-2" />
            @foreach($form->permissions as $id => $name)
                <x-checkbox label="{!! $name !!}" value="{{ (int) $id }}" name="selectedPermissions[]"
                    model="form.selectedPermissions"></x-checkbox><br>
            @endforeach
            <x-input-error :messages="$errors->get('form.selectedPermissions')" class="mt-2" />
        </div>

        <x-slot:button>
            <x-button type="submit" class="btn-primary">
                <x-button-indicator :label="__('Update Role')" target="update" />
            </x-button>
        </x-slot:button>
    </x-modal>
</div>
