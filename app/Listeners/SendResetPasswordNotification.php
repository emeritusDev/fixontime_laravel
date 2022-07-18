<?php

namespace App\Listeners;

use App\Events\ResetPasswordProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\ResetPasswordTemplate;

class SendResetPasswordNotification implements ShouldQueue
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
     * @param  \App\Events\ResetPasswordProcessed  $event
     * @return void
     */
    public function handle(ResetPasswordProcessed $event)
    {
        error_log($event->token);
        \Mail::to($event->email)
                ->send(new ResetPasswordTemplate($event->token, $event->email));
    }
}
