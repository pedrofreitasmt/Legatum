<?php

namespace Tests\App\Http\Controllers;

use App\Models\User;
use App\Models\Testament;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Testa se a página de listagem de usuários é renderizada corretamente
     * com os usuários paginados.
     */
    public function test_exibe_usuarios_paginados(): void
    {
        User::factory()->count(10)->create();

        // 2. Use actingAs() para simular um usuário admin logado
        $this->actingAs($this->adminUser)
            ->get(route('users.index'))
            ->assertOk()
            ->assertInertia(function (Assert $page) {
                $page->component('Users/Index')
                    ->has('users')
                    ->has('users.data', 5)
                    ->has('users.links')
                    // O total será 12 (o usuário admin + os 11 que criamos)
                    ->where('users.total', 12);
            });
    }

    /**
     * Testa se a página de um usuário específico é renderizada corretamente.
     */
    public function test_exibe_usuario_especifico_com_testamentos(): void
    {
        $userToShow = User::factory()->create();

        Testament::factory()->count(3)->create(['user_id' => $userToShow->id]);

        $this->actingAs($this->adminUser)
            ->get(route('users.show', $userToShow))
            ->assertOk()
            ->assertInertia(function (Assert $page) use ($userToShow) {
                $page->component('Users/Show')
                    ->where('user.id', $userToShow->id)
                    ->where('user.name', $userToShow->name)
                    ->where('user.testaments_count', 3)
                    ->has('user.testaments', 3);
            });
    }

    /**
     * Testa se um erro 404 é retornado ao tentar acessar um usuário inexistente.
     */
    public function test_retorna_nao_encontrado_para_usuario_invalido(): void
    {
        $adminUser = User::factory()->create([
            'is_admin' => true
        ]);

        $this->actingAs($adminUser)
            ->get(route('users.show', 999))
            ->assertNotFound();
    }

    /**
     * Testa se usuários não-admin são impedidos de acessar a listagem de usuários.
     */
    public function test_nega_acesso_listagem_para_usuarios_nao_admin(): void
    {
        // Cria um usuário comum (não admin)
        $regularUser = User::factory()->create([
            'is_admin' => false
        ]);

        $this->actingAs($regularUser)
            ->get(route('users.index'))
            ->assertForbidden(); // Verifica se a resposta é 403 Forbidden
    }

    /**
     * Testa se usuários não-admin são impedidos de ver detalhes de outros usuários.
     */
    public function test_nega_acesso_detalhes_para_usuarios_nao_admin(): void
    {
        // Cria outro usuário para tentar visualizar
        $userToShow = User::factory()->create();

        $this->actingAs($this->user)
            ->get(route('users.show', $userToShow))
            ->assertForbidden();
    }

    /**
     * Testa se usuários não autenticados são redirecionados.
     */
    public function test_redireciona_usuarios_nao_autenticados(): void
    {
        $this->get(route('users.index'))
            ->assertRedirect('/login');
    }
}
