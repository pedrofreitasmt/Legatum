<?php

namespace Tests;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        // Limpa cache de permissões e cria as permissões necessárias
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        Permission::findOrCreate('usuario listar');
        Permission::findOrCreate('usuario detalhar');

        // Cria usuário admin com permissões
        $this->adminUser = User::factory()->create();
        $this->adminUser->givePermissionTo(['usuario listar', 'usuario detalhar']);

        $this->user = User::factory()->create();
    }
}
