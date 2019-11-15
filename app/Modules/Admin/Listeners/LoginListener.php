<?php

namespace App\Modules\Admin\Listeners;

use App\Modules\Admin\Events\LoginEvent;

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
