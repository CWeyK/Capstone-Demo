<?php

use Livewire\Volt\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Collection;

new class extends Component {

    public Collection $roles;

    public function mount()
    {
        $this->roles = Role::withCount('users')->get();
    }


}; ?>

<div>
    @section('title', 'Roles')
    @section('breadcrumbs')
    {{ Breadcrumbs::render('role') }}
    @endsection

    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
        @foreach($roles as $role)
            <div class="col-md-4">
                <div class="card card-flush h-md-100">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>{{ $role->name }}</h2>
                        </div>
                    </div>
                    <div class="card-body pt-1">
                        <div class="fw-bold text-gray-600 mb-5">Total users with this role: {{ $role->users_count }}</div>
                        <div class="d-flex flex-column text-gray-600">
                            @foreach($role->getPermissionNames()->take(5) as $permissionName)
                                <div class="d-flex align-items-center py-2">
                                    <span class="bullet bg-primary me-3"></span>{{ $permissionName }}
                                </div>
                            @endforeach

                            @if($role->getPermissionNames()->count() > 5)
                                <div class="d-flex align-items-center py-2">
                                    <span class="bullet bg-primary me-3"></span>
                                    and {{ $role->getPermissionNames()->count() - 5 }} more...
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer flex-wrap pt-0">
                        <a href="{{ route('admin.roles.show', $role->id) }}"
                            class="btn btn-light btn-active-primary my-1 me-2" wire:navigate>View Role</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
