<?php

namespace App\Common\Exceptions;

use App\Common\Constants\ErrorConst;

/**
 *
 * @author zxf
 * @date    2026-08-27
 */
class Handler extends \Seffeng\Basics\Exceptions\Handler
{
    /**
     * 以 json 方式输出
     * @var string
     */
    protected $asJson = true;

    /**
     *
     * @var ErrorConst
     */
    protected $errorClass = ErrorConst::class;
}
