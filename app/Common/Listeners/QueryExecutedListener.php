<?php

namespace App\Common\Listeners;

/**
 * SQL执行监听，日志打印
 *
 * @author zxf
 * @date   2026-08-27
 */
class QueryExecutedListener extends \Seffeng\LaravelHelpers\Listeners\QueryExecutedListener
{
    /**
     * SQL日志channel
     * config/logging.php [Channels]
     * @var string
     */
    protected $channel = 'sqllog';

    /**
     *
     * @author zxf
     * @date   2026-08-27
     */
    public function __construct()
    {
        $this->debug = config('app.sql_debug');
    }
}
