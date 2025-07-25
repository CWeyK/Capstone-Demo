<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Actions\Role\UpdateRoleAction;
use Spatie\Permission\Models\Permission;

class RoleForm extends Form
{
    public ?Role $role = null;
    public string $name = '';
    public array $permissions = [];
    public array $selectedPermissions = [];

    public function setRole(Role $role)
    {
        $this->role = $role;
    }


    protected function rules()
    {
        return [
            'name'                  => ['required', 'string', Rule::unique('roles', 'name')->ignore($this->role?->id)],
            'selectedPermissions'   => ['array'],
        ];
    }

    public function getAllPermissions()
    {
        return $this->permissions = Permission::all()->pluck('name', 'id')->toArray();
    }

    public function updateRole($validatedData, Role $role)
    {
        app(UpdateRoleAction::class)->handle(
            $role,
            $validatedData
        );
    }
}
