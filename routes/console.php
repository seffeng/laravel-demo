<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('command-test', function() {
    var_dump('command-test: '. date('Y-m-d H:i:s') . ' 测试结束。');
})->describe('测试控制台路由。');
