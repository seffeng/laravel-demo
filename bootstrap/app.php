<?php

use Illuminate\Foundation\Application;

return Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(function (): void {
        //
    })
    ->withExceptions(function (): void {
        // 异常处理逻辑已在 AppServiceProvider 注册
    })->create();
