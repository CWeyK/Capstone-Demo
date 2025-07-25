<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $data = $this->data();

        foreach ($data as $value) {
            Permission::create([
                'name' => $value['name'],
            ]);
        }

        Role::create(['name' => 'Super-Admin'])
            ->givePermissionTo(Permission::all());

        Role::create(['name' => 'Administrator'])
            ->givePermissionTo(Permission::all());

        Role::create(['name' => 'Lecturer'])
        ->givePermissionTo([
            'View Order', 'Create & Edit Order',
            'View Shipping',
            'View Group', 'Create & Edit Group',
            'View User', 'View User Details', 'Edit User',
            'View Payout',
            'View Ad Spend', 'Create & Edit Ad Spend',
            'Create & Edit Bank Account',
            'View Family Tree',
            'Create & Edit Customer',
            'Suspend User',
        ]);

        Role::create(['name' => 'Student'])
            ->givePermissionTo([
                'View Order', 'Create & Edit Order',
                'View Shipping',
                'View Group', 'Create & Edit Group',
                'View User Details', 'Edit User',
                'View Withdrawal', 'Create Withdrawal',
                'View Payout',
                'View Ad Spend', 'Create & Edit Ad Spend',
                'Create & Edit Bank Account',
                'View Family Tree',
                'Create & Edit Customer',
            ]);

    }

    public function data()
    {
        return [
            ['name' => 'View Role'],
            ['name' => 'Create & Edit Role'],
            ['name' => 'View Permission'],
            ['name' => 'Create & Edit Permission'],
            ['name' => 'View System & Audit Log'],
            ['name' => 'View User'],
            ['name' => 'View User Details'],
            ['name' => 'Create User'],
            ['name' => 'Edit User'],
            ['name' => 'Suspend User'],
            ['name' => 'View Order'],
            ['name' => 'Create & Edit Order'],
            ['name' => 'Cancel Order'],
            ['name' => 'View Product'],
            ['name' => 'Create & Edit Product'],
            ['name' => 'View Category'],
            ['name' => 'Create & Edit Category'],
            ['name' => 'View Group'],
            ['name' => 'Create & Edit Group'],
            ['name' => 'View Commission Scheme'],
            ['name' => 'Create & Edit Commission Scheme'],
            ['name' => 'View Withdrawal'],
            ['name' => 'Create Withdrawal'],
            ['name' => 'View Payout'],
            ['name' => 'Create Payout'],
            ['name' => 'View Ad Spend'],
            ['name' => 'Create & Edit Ad Spend'],
            ['name' => 'Reject Ad Spend'],
            ['name' => 'View Transaction'],
            ['name' => 'Approve & Reject Transaction'],
            ['name' => 'Create & Edit Bank Account'],
            ['name' => 'Promote Rank'],
            ['name' => 'View Customer'],
            ['name' => 'Create & Edit Customer'],
            ['name' => 'View Family Tree'],
            ['name' => 'Create & Edit Order Delivery'],
            ['name' => 'View Currency'],
            ['name' => 'Edit Currency'],
            ['name' => 'View Shipping'],
            ['name' => 'View Event'],
            ['name' => 'Create & Edit Event'],
            ['name' => 'View Voucher'],
            ['name' => 'Create & Edit Voucher'],
            ['name' => 'View Provider'],
            ['name' => 'Create & Edit Provider'],
            ['name' => 'Approve Withdrawal'],
        ];
    }
}
