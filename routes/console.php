<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\Test;
use Seffeng\LaravelHelpers\Commands\Crypt;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('command-test', function() {
    var_dump('command-test: '. date('Y-m-d H:i:s') . ' 测试结束。');
})->describe('测试控制台路由。');

Artisan::addCommands([Crypt::class]);

// 定时任务注册、需要配置 cron 定时执行：
// * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
Schedule::command(Test::class, ['user' => '张三', 'age' => 99, 'sex' => '男', '--debug', '--check=no'])->everyMinute()->runInBackground()->withoutOverlapping();
