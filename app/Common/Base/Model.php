<?php

namespace App\Common\Base;

/**
 *
 * @author zxf
 * @date    2019年11月15日
 */
class Model extends \Seffeng\Basics\Base\Model
{
    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
}
