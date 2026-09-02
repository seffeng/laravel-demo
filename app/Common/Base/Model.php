<?php

namespace App\Common\Base;

/**
 *
 * @author zxf
 * @date   2026-08-27
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
