<?php

namespace App\Console\Commands;

use App\Jobs\EnviarEmailContatoJob;
use Illuminate\Console\Command;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia um email de teste para verificar a configuração do envio de emails.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Enviando email de teste...');

        $testData = [
            'name' => 'Teste',
            'title' => 'NOME DO TESTE',
            'content' => 'Este é um email de teste para verificar a configuração do envio de emails.'
        ];

        EnviarEmailContatoJob::dispatch($testData);

        $this->info('Email de teste enviado com sucesso!');
        $this->comment('Lembre-se de executar o queue worker (`php artisan queue:work`) para processar o job.');
    }
}
