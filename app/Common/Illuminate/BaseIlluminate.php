<?php

namespace App\Common\Illuminate;

use Illuminate\Support\Arr;

/**
 * 属性基础处理
 *
 * @author zxf
 * @date   2026-08-27
 */
class BaseIlluminate
{
        /**
     *
     * @var int
     */
    protected $id;

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @param  int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return int
     */
    public function getValue()
    {
        return $this->id;
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return string
     */
    public function getName()
    {
        return Arr::get(static::fetchNameItems(), $this->getValue(), '');
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return array
     */
    public static function fetchItems()
    {
        return array_keys(static::fetchNameItems());
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return string[]
     */
    public static function fetchNameItems()
    {
        return [
            //
        ];
    }
}
