<?php

namespace App\Actions\Role;

use RuntimeException;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;


class UpdateRoleAction
{
    public function handle(Role $role,  $validatedData): void
    {
        if (!Auth::user()->can('Create & Edit Role')) {
            throw new RuntimeException('You do not have permission to edit roles');
        }

        $role->update($validatedData);   

        $permissionNames = Permission::whereIn('id', $validatedData['selectedPermissions'])
        ->pluck('name')
        ->toArray();

        $role->syncPermissions($permissionNames);     

    }
}
