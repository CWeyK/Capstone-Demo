<?php

use Livewire\Volt\Component;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\On;

new class extends Component {

    public Role $role;

    public function mount()
    {
        $this->role->loadCount('users');
    }

    #[On('roleUpdated')]
    public function refreshDetails()
    {
        $this->role->refresh();
    }


}; ?>

<div>
    @section('title', 'Roles')
    @section('breadcrumbs')
    {{ Breadcrumbs::render('role-show', $role) }}
    @endsection
    <div class="d-flex flex-column flex-lg-row">
        <div class="flex-column flex-lg-row-auto w-100 w-lg-200px w-xl-300px mb-10">
            <div class="card card-flush">
                <div class="card-header">
                    <div class="card-title">
                        <h2 class="mb-0">{{ $role->name }}</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex flex-column text-gray-600">
                        @foreach($role->getPermissionNames() as $permissionName)
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>{{ $permissionName }}
                            </div>
                        @endforeach
                    </div>
                </div>
                @can('Create & Edit Role')
                    <div class="card-footer pt-0">
                        <button type="button" class="btn btn-light btn-active-light-primary my-1" data-bs-toggle="modal"
                            data-bs-target="#editRoleModal">Edit Role</button>
                    </div>
                @endcan
            </div>
        </div>

        <div class="flex-lg-row-fluid ms-lg-10">
            <x-card class="card-flush mb-6 mb-xl-9">
                <x-card-header title="Users Assigned ({{ $role->users_count }})" />
                <div class="card-body pt-0">
                    <livewire:tables.userstable :role="$role->name" />
                </div>
            </x-card>
        </div>
    </div>

    @can('Create & Edit Role')
        <livewire:role.role-edit-modal :role="$role" />
    @endcan
</div>
