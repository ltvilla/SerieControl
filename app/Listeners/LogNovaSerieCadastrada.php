<?php

namespace App\Listeners;

use App\Events\NovaSerieMail;
use App\Events\NovaSerieMailDois;
use Illuminate\Cache\Lock;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class LogNovaSerieCadastrada implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NovaSerieMailDois  $event
     * @return void
     */
    public function handle(NovaSerieMail $event)
    {
        Log::info('Série nova cadastrada' .$event->nomeSerie);
    }
}
