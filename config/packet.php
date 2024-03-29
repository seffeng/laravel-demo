<?php

return [
    /**
     * 应用配置
     */
    'api' => [  // API
        'namespace' => 'App\Web\Api\Controllers',
        'guard' => 'api',
        'middleware' => 'api'
    ],
    'backend' => [  // 后台
        'namespace' => 'App\Web\Backend\Controllers',
        'viewPath' => 'views/backend',
        'guard' => 'backend',
        'middleware' => 'api'
    ],
    'frontend' => [ // 前台
        'namespace' => 'App\Web\Frontend\Controllers',
        'viewPath' => 'views/frontend',
        'guard' => 'frontend',
        'middleware' => 'api'
    ],
];
