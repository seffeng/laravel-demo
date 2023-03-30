<?php

namespace App\Modules\Admin\Listeners;

use App\Modules\Admin\Events\LoginEvent;
use Seffeng\LaravelHelpers\Helpers\Arr;

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
        $user = $event->getModel();
        $data = $event->getData();
        $user->updateLoginValues(Arr::get($data, 'clientIp', ''));
        $user->save();
    }
}
