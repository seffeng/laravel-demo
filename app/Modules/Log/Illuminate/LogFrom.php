<?php
namespace App\Modules\Log\Illuminate;

use App\Common\Illuminate\TypeIlluminate;
use App\Common\Constants\FromConst;
use App\Modules\User\Models\User;
use App\Modules\Admin\Models\Admin;
use App\Modules\User\Models\UserForApi;

class LogFrom extends TypeIlluminate
{
    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return string[]
     */
    public static function fetchNameItems()
    {
        return [
            FromConst::FRONTEND => '前台',
            FromConst::API => 'API',
            FromConst::BACKEND => '后台',
        ];
    }

    /**
     *
     * @author zxf
     * @date   2026-08-27
     * @return array
     */
    public static function fetchOperatorClassItems()
    {
        return [
            FromConst::FRONTEND => User::class,
            FromConst::API => UserForApi::class,
            FromConst::BACKEND => Admin::class,
        ];
    }
}