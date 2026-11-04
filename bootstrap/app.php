<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;

return Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->remove([
            ConvertEmptyStringsToNull::class
        ]);
    })
    ->withExceptions(function (): void {
        // 异常处理逻辑已在 AppServiceProvider 注册
    })->create();
