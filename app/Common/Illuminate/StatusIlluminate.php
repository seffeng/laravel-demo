<?php

namespace App\Common\Illuminate;

use App\Common\Constants\StatusConst;

/**
 * 状态说明
 *
 * @author zxf
 * @date   2026-08-27
 */
class StatusIlluminate extends BaseIlluminate
{
    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return bool
     */
    public function getIsNormal()
    {
        return $this->getValue() == StatusConst::NORMAL;
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return bool
     */
    public function getIsLock()
    {
        return $this->getValue() == StatusConst::LOCK;
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return bool
     */
    public function getIsOn()
    {
        return $this->getValue() == StatusConst::ON;
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return bool
     */
    public function getIsOff()
    {
        return $this->getValue() == StatusConst::OFF;
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return bool
     */
    public function getIsSuccess()
    {
        return $this->getValue() == StatusConst::SUCCESS;
    }

    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return bool
     */
    public function getIsFaild()
    {
        return $this->getValue() == StatusConst::FAILD;
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
            StatusConst::NORMAL => '正常',
            StatusConst::LOCK => '锁定',
        ];
    }
}
