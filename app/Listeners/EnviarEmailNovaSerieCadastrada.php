<?php

namespace App\Listeners;


use App\Events\NovaSerieMail;
use App\Mail\NovaSerie;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EnviarEmailNovaSerieCadastrada implements ShouldQueue
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
     * @param  NovaSerie  $event
     * @return void
     */
    public function handle(NovaSerieMail $event)
    {
        
        $users = User::all();
        foreach ($users as $indice => $user) 
        {
         $multiplicado = $indice + 1;    
            $email = new NovaSerie(
                $event->nomeSerie,
                $event->qtdTemporadas,
                $event->qtdEpisodios
            );
            $email->subject = 'Nova Série Adicionada';
            $quando = now()->addSecond($multiplicado* 10);
            Mail::to($user)->later(
                $quando, 
                $email
            );
        }

        // Mail::to($user)->later($quando, $email);

        //Mail::to($user)->send($email);
    }
}
