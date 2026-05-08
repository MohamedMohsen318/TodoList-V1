<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AdminAndRoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view-users,admin', only: ['adminsIndex']),
            new Middleware('permission:create-admin,admin', only: ['adminsCreate', 'adminsStore']),
            new Middleware('permission:edit-admin,admin', only: ['adminsEdit', 'adminsUpdate']),
            new Middleware('permission:delete-admin,admin', only: ['adminsDestroy']),
            new Middleware('permission:manage-roles,admin', only: [
                'rolesIndex',
                'rolesCreate',
                'rolesStore',
                'rolesEdit',
                'rolesUpdate',
                'rolesDestroy',
            ]),
        ];
    }

    public function adminsIndex(): View
    {
        $admins = Admin::with('roles')->latest()->paginate(10);
        $roles = Role::where('guard_name', 'admin')->orderBy('name')->get();

        return view('admin.admins.index', compact('admins', 'roles'));
    }

    public function adminsCreate(): View
    {
        $roles = Role::where('guard_name', 'admin')->orderBy('name')->get();

        return view('admin.admins.create', compact('roles'));
    }

    public function adminsStore(AdminRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $admin = Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        $admin->syncRoles($data['roles']);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin created successfully.');
    }

    public function adminsEdit(Admin $admin): View
    {
        $roles = Role::where('guard_name', 'admin')->orderBy('name')->get();
        $adminRoles = $admin->roles->pluck('name')->all();

        return view('admin.admins.edit', compact('admin', 'roles', 'adminRoles'));
    }

    public function adminsUpdate(AdminRequest $request, Admin $admin): RedirectResponse
    {
        $data = $request->validated();

        $admin->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => filled($data['password'] ?? null) ? Hash::make($data['password']) : $admin->password,
        ]);

        $admin->syncRoles($data['roles']);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin updated successfully.');
    }

    public function adminsDestroy(Admin $admin): RedirectResponse
    {
        if ($admin->hasRole('super-admin') && auth('admin')->id() !== $admin->id) {
            return redirect()->route('admin.admins.index')
                ->withErrors('Super admin accounts can only be removed by themselves.');
        }

        if (auth('admin')->id() === $admin->id) {
            return redirect()->route('admin.admins.index')
                ->withErrors('You cannot delete your current signed-in admin account.');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin deleted successfully.');
    }

    public function rolesIndex(): View
    {
        $roles = Role::where('guard_name', 'admin')
            ->with('permissions')
            ->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function rolesCreate(): View
    {
        $permissions = Permission::where('guard_name', 'admin')->get();

        return view('admin.roles.create', compact('permissions'));
    }

    public function rolesStore(RoleRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $role = Role::create([
            'name' => $data['name'],
            'guard_name' => 'admin',
        ]);

        $role->syncPermissions($data['permissions'] ?? []);
        $this->clearPermissionCache();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully');
    }

    public function rolesEdit(Role $role): View
    {
        $permissions = Permission::where('guard_name', 'admin')->get();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function rolesUpdate(RoleRequest $request, Role $role): RedirectResponse
    {
        $data = $request->validated();

        $role->update([
            'name' => $data['name'],
        ]);

        $role->syncPermissions($data['permissions'] ?? []);
        $this->clearPermissionCache();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully');
    }

    public function rolesDestroy(Role $role): RedirectResponse
    {
        $role->delete();
        $this->clearPermissionCache();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully');
    }

    private function clearPermissionCache(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
