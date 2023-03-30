<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Database\Events\QueryExecuted;
use App\Common\Listeners\QueryExecutedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        QueryExecuted::class => [
            QueryExecutedListener::class
        ],
        'App\Modules\User\Events\LoginEvent' => [
            'App\Modules\User\Listeners\LoginListener'
        ],
        'App\Modules\User\Events\LogoutEvent' => [
            'App\Modules\User\Listeners\LogoutListener'
        ],

        'App\Modules\Admin\Events\LoginEvent' => [
            'App\Modules\Admin\Listeners\LoginListener'
        ],
        'App\Modules\Admin\Events\LogoutEvent' => [
            'App\Modules\Admin\Listeners\LogoutListener'
        ],

        'App\Modules\Log\Events\OperateLogCreateEvent' => [
            'App\Modules\Log\Listeners\OperateLogCreateListener'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
