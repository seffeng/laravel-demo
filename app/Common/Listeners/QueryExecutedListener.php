<?php

namespace App\Common\Listeners;

class QueryExecutedListener extends \Seffeng\LaravelHelpers\Listeners\QueryExecutedListener
{
    /**
     * SQL日志channel
     * config/logging.php [Channels]
     * @var string
     */
    protected $channel = 'sqllog';
}
