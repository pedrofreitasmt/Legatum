<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestamentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_renderizar_view_testaments_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route("testaments.index"));

        $response->assertStatus(200);
    }

    public function test_renderizar_view_testaments_create(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('testaments.create'));

        $response->assertStatus(200);
    }

    public function test_criar_testamento()
    {
        $user = User::factory()->create();

        // Dados para o POST
        $testamentData = [
            'title' => 'Meu Testamento',
            'content' => 'Este é o conteúdo do meu testamento.',
            'recipient_email' => 'teste@gmail.com',
            'send_at' => now()->addDay()->format('Y-m-d'),
        ];

        // Faz o POST corretamente
        $response = $this->actingAs($user)->post(route('testaments.store'), $testamentData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('testaments', [
            'title' => 'Meu Testamento',
            'recipient_email' => 'teste@gmail.com',
            'user_id' => $user->id,
            // Não verificar content se estiver sendo criptografado
        ]);
    }
}
