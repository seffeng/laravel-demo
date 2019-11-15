<?php

namespace App\Modules\User\Illuminate;

use App\Common\Constants\StatusConst;
use Illuminate\Support\Arr;

class UserStatus
{
    /**
     *
     * @var integer
     */
    private $statusId;

    /**
     *
     * @author zxf
     * @date    2019年9月25日
     * @param  int $statusId
     */
    public function __construct(int $statusId)
    {
        $this->statusId = $statusId;
    }

    /**
     *
     * @author zxf
     * @date    2019年9月25日
     * @return integer
     */
    public function getValue()
    {
        return $this->statusId;
    }

    /**
     *
     * @author zxf
     * @date    2019年9月25日
     * @return string
     */
    public function getName()
    {
        return Arr::get(self::fetchNameItems(), $this->getValue(), '');
    }

    /**
     *
     * @author zxf
     * @date    2019年9月25日
     * @return boolean
     */
    public function getIsNormal()
    {
        return $this->getValue() == StatusConst::NORMAL;
    }

    /**
     *
     * @author zxf
     * @date    2019年9月25日
     * @return array
     */
    public static function fetchItems()
    {
        return array_keys(self::fetchNameItems());
    }

    /**
     *
     * @author zxf
     * @date    2019年9月25日
     * @return string[]
     */
    public static function fetchNameItems()
    {
        return [
            StatusConst::NORMAL => '正常',
            StatusConst::LOCK => '锁定',
        ];
    }
}
