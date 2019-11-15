<?php

namespace App\Modules\User\Listeners;

use App\Modules\User\Events\LoginEvent;

class LoginListener
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
     * @param  LoginEvent  $event
     * @return void
     */
    public function handle(LoginEvent $event)
    {
        $user = $event->getUser();
        $user->updateLoginValues();
        $user->save();
    }
}
