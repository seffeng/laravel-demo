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
