<?php

namespace App\Providers;

use App\Common\Exceptions\Handler;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 绑定自定义异常处理器，覆盖框架默认实现
        $this->app->singleton(\Illuminate\Foundation\Exceptions\Handler::class, Handler::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 初始化自定义异常处理器的 repor / render 回调
        $this->app->make(Handler::class)->register();
    }
}
