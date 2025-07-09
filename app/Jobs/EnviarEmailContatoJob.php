<?php

namespace App\Jobs;

use App\Mail\ContatoEnviadoMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class EnviarEmailContatoJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected array $data) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to('pedrohenrique_of@hotmail.com')->send(new ContatoEnviadoMail($this->data));
    }
}
