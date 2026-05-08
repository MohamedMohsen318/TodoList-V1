<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $userPermissions = [
            'create-task',
            'edit-task',
            'delete-task',
        ];

        $adminPermissions = [
            'view-users',
            'create-admin',
            'edit-admin',
            'delete-admin',
            'manage-roles',
            'manage-permissions',
        ];

        $createdUserPermissions = collect($userPermissions)->map(fn ($permission) => Permission::firstOrCreate([
            'name' => $permission,
            'guard_name' => 'web',
        ]));

        $createdAdminPermissions = collect($adminPermissions)->map(fn ($permission) => Permission::firstOrCreate([
            'name' => $permission,
            'guard_name' => 'admin',
        ]));

        $userRole = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web',
        ]);
        $userRole->syncPermissions($createdUserPermissions);

        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'admin',
        ]);
        $adminRole->syncPermissions($createdAdminPermissions->whereIn('name', [
            'view-users',
            'create-admin',
            'edit-admin',
            'delete-admin',
        ]));

        $superAdminRole = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'admin',
        ]);
        $superAdminRole->syncPermissions($createdAdminPermissions);
    }
}
