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

        if (!$roles->contains('Super Admin')) {
            Role::create(['name' => 'Super Admin']);
        }

        // Garantir que o Super Admin sempre tenha todas as permissões
        $superAdmin = Role::where('name', 'Super Admin')->first();
        $superAdmin->syncPermissions(Permission::all());

        echo "Papel 'Super Admin' criado/atualizado com todas as permissões.\n";
    }
}
