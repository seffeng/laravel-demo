<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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
        $this->namespace = Arr::get(config('webpacket'), config('app.name') .'.namespace', $this->namespace);
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $appName = Arr::has(config('webpacket'), config('app.name'));
        if ($appName) {
            $funName = 'map'. Str::studly(config('app.name')) .'Routes';
            $this->$funName();
        } else {
            $this->mapApiRoutes();
        }
    }

    /**
     * Define the "Frontend" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapFrontendRoutes()
    {
        Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/frontend.php'));
    }

    /**
     * Define the "Backend" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapBackendRoutes()
    {
        Route::middleware('web')
        ->namespace($this->namespace)
        ->group(base_path('routes/backend.php'));
    }

    /**
     * Define the "Api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::middleware('api')
        ->namespace($this->namespace)
        ->group(base_path('routes/api.php'));
    }
}
