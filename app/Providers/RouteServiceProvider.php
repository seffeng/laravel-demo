<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Arr;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->namespace = Arr::get(config('packet'), config('app.name') .'.namespace', $this->namespace);
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $appName = config('app.name');
        $middleware = config('packet.'. $appName .'.middleware');
        if ($middleware === 'api') {
            $this->mapApiRoutes($appName);
        } else {
            $this->mapWebRoutes($appName);
        }
    }

    /**
     * Define the "Web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes(string $appName)
    {
        Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/'. $appName .'.php'));
    }

    /**
     * Define the "Api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes(string $appName)
    {
        Route::middleware('api')
        ->namespace($this->namespace)
        ->group(base_path('routes/'. $appName .'.php'));
    }
}
