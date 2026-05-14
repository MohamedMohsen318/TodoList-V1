<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        User::firstOrCreate(
            ['email' => 'user@user.com'],
            [
                'name' => 'User',
                'phone'=> '01221570337',
                'password' => Hash::make('12345678'),
            ]
        )->assignRole('user');

        User::firstOrCreate(
            ['email' => 'test@user.com'],
            [
                'name' => 'Test User',
                'phone'=> '01221570335',
                'password' => Hash::make('12345678'),
            ]
        )->assignRole('user');

        $defaultAdmin = Admin::firstOrCreate(
            ['email' => 'manager@admin.com'],
            [
                'name' => 'Admin Manager',
                'phone'=> '01221570334',
                'password' => Hash::make('12345678'),
            ]
        );

        $defaultAdmin->syncRoles(['admin']);

        $admin = Admin::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'phone'=> '01221570336',
                'password' => Hash::make('12345678'),
            ]
        );

        $admin->syncRoles(['super_admin']);
    }
}
