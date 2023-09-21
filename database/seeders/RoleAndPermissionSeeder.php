<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        $admin = Role::create(['name' => 'Admin']);

        $b2cCustomer = Role::create(['name' => 'B2C Customer']);
        $b2bCustomer = Role::create(['name' => 'B2B Customer']);

        $manageUsers = Permission::create(['name' => 'manage users']);
        $admin->givePermissionTo($manageUsers);


    }
}
