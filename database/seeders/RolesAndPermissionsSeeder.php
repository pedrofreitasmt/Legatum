<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $actions = [
            'listar',
            'criar',
            'editar',
            'detalhar',
            'apagar',
            'trocar status',
            'relatorio',
        ];

        $permissions = [
           'usuario',
           'testamento'
        ];

        $arrayOfPermissionNames = ['default'];

        foreach ($permissions as $permission) {
            foreach ($actions as $action) {
                $arrayOfPermissionNames[] = sprintf('%s %s', $permission, $action);
            }
        }

        $permissions = collect($arrayOfPermissionNames)->map(function ($permission): array {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        $permissionsCreated = Permission::pluck('name');

        $permissions = $permissions->filter(function ($permission) use ($permissionsCreated) {
            return !$permissionsCreated->contains($permission['name']);
        });

        if ($permissions->isEmpty()) {
            return;
        }

        $permissions = $permissions->map(function ($permission) {
            return Permission::create($permission);
        });

        $roles = Role::pluck('name');

        if ($roles->contains('Super Admin')) {
            return;
        }

        Role::create(['name' => 'Super Admin']);
    }
}
