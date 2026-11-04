<?php

namespace App\Modules\Application\Illuminate;

use App\Common\Constants\StatusConst;
use App\Common\Illuminate\StatusIlluminate;

class ApplicationStatus extends StatusIlluminate
{
    /**
     *
     * @author zxf
     * @date   2026-10-15
     * @return array
     */
    public static function fetchNameItems()
    {
        return [
            StatusConst::ON => '启用',
            StatusConst::OFF => '停用',
        ];
    }
}
