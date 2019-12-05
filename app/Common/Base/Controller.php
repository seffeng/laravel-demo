<?php

namespace App\Common\Base;

use App\Common\Constants\ErrorConst;

/**
 *
 * @author zxf
 * @date    2019年11月15日
 */
class Controller extends \Seffeng\Basics\Base\Controller
{
    /**
     * 重新定义错误常量类
     * @var ErrorConst
     */
    protected $errorClass = ErrorConst::class;
}
