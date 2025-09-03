<?php

namespace Tests\app\Http\Controllers;

use App\Models\Testament;
use App\Models\TestamentAttachment;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class TestamentControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_renderizar_view_testaments_index(): void
    {
        $response = $this->actingAs($this->user)->get(route('testaments.index'));

        $response->assertStatus(200);
    }

    public function test_renderizar_view_testaments_create(): void
    {
        $response = $this->actingAs($this->user)->get(route('testaments.create'));

        $response->assertStatus(200);
    }

    public function test_index_paginacao_inertia(): void
    {
        // cria 7 testamentos para o usuário logado
        Testament::factory()->count(7)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->get(route('testaments.index'))
            ->assertOk()
            ->assertInertia(function (Assert $page) {
                $page->component('Testaments/Index')
                    ->has('testaments')
                    ->has('testaments.data', 5)
                    ->where('testaments.total', 7)
                    ->has('testaments.links');
            });
    }

    public function test_criar_testamento(): void
    {
        $testamentData = [
            'title' => 'Meu Testamento',
            'content' => 'Este é o conteúdo do meu testamento.',
            'recipient_email' => 'teste@gmail.com',
            'send_at' => now()->addDay()->format('Y-m-d'),
        ];

        $response = $this->actingAs($this->user)->post(route('testaments.store'), $testamentData);

        $response->assertRedirect(route('testaments.index'));

        $this->assertDatabaseHas('testaments', [
            'title' => 'Meu Testamento',
            'recipient_email' => 'teste@gmail.com',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_store_com_anexos_salva_arquivos_e_registros(): void
    {
        Storage::fake('public');

        $file1 = UploadedFile::fake()->create('doc1.pdf', 10, 'application/pdf');
        $file2 = UploadedFile::fake()->image('foto.jpg');

        $payload = [
            'title' => 'Com anexos',
            'content' => 'Conteúdo com anexos',
            'recipient_email' => 'destinatario@example.com',
            'send_at' => now()->addDay()->format('Y-m-d'),
            'attachments' => [$file1, $file2],
        ];

        $this->actingAs($this->user)
            ->post(route('testaments.store'), $payload)
            ->assertRedirect(route('testaments.index'));

        $testament = Testament::where('user_id', $this->user->id)->latest('id')->first();

        $this->assertNotNull($testament);
        $this->assertCount(2, $testament->testamentAttachments);

        foreach ($testament->testamentAttachments as $att) {
            $this->assertTrue(Storage::disk('public')->exists($att->path));
        }
    }

    public function test_show_exibe_testamento(): void
    {
        $testament = Testament::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->get(route('testaments.show', $testament))
            ->assertOk()
            ->assertInertia(function (Assert $page) use ($testament) {
                $page->component('Testaments/Show')
                    ->where('testament.id', $testament->id);
            });
    }

    public function test_edit_autorizado_para_dono(): void
    {
        $testament = Testament::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->get(route('testaments.edit', $testament))
            ->assertOk()
            ->assertInertia(function (Assert $page) use ($testament) {
                $page->component('Testaments/Edit')
                    ->where('testament.id', $testament->id);
            });
    }

    public function test_edit_retorna_403_para_nao_dono(): void
    {
        $outroUsuario = User::factory()->create();
        $testament = Testament::factory()->create(['user_id' => $outroUsuario->id]);

        $this->actingAs($this->user)
            ->get(route('testaments.edit', $testament))
            ->assertForbidden();
    }

    public function test_update_adiciona_e_remove_anexos(): void
    {
        Storage::fake('public');

        // Cria testamento com 1 anexo existente
        $testament = Testament::factory()->create(['user_id' => $this->user->id]);
        $existing = TestamentAttachment::create([
            'testament_id' => $testament->id,
            'original_name' => 'antigo.pdf',
            'path' => 'attachments/antigo.pdf',
            'mime_type' => 'application/pdf',
            'size' => 1024,
        ]);

        // Novo arquivo para adicionar
        $novoArquivo = UploadedFile::fake()->create('novo.pdf', 5, 'application/pdf');

        $payload = [
            '_method' => 'PUT',
            'title' => 'Atualizado',
            'content' => 'Conteúdo atualizado',
            'recipient_email' => 'novo@example.com',
            'attachments_to_delete' => [$existing->id],
            'attachments' => [$novoArquivo],
        ];

        $this->actingAs($this->user)
            ->post(route('testaments.update', $testament), $payload)
            ->assertRedirect(route('testaments.index', ['page' => null]));

        $testament->refresh();

        // Verifica exclusão do anexo antigo e criação do novo
        $this->assertDatabaseMissing('testament_attachments', ['id' => $existing->id]);
        $this->assertCount(1, $testament->testamentAttachments);
        $this->assertTrue(Storage::disk('public')->exists($testament->testamentAttachments()->first()->path));

        // Verifica atualização de campos básicos
        $this->assertSame('Atualizado', $testament->title);
        $this->assertSame('novo@example.com', $testament->recipient_email);
    }

    public function test_destroy_exclui_testamento_do_dono(): void
    {
        $testament = Testament::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->delete(route('testaments.destroy', $testament))
            ->assertRedirect(route('testaments.index'));

        $this->assertDatabaseMissing('testaments', ['id' => $testament->id]);
    }
}
