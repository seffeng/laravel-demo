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
    protected $baseCasts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return array
     */
    public function getCasts()
    {
        return array_merge($this->baseCasts, parent::getCasts());
    }
}
