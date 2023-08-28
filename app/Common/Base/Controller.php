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

    /**
     *
     * {@inheritDoc}
     * @see \Seffeng\Basics\Base\Controller::responseSuccess()
     */
    public function responseSuccess($data = [], string $message = 'success', array $headers = [], int $code = null)
    {
        return parent::responseSuccess($data, $message, $this->errorClass::mergeHeaders($headers), $code);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Seffeng\Basics\Base\Controller::responseError()
     */
    public function responseError(string $message, $data = [], int $code = null, array $headers = [])
    {
        return parent::responseError($message, $data, $code, $this->errorClass::mergeHeaders($headers));
    }

    /**
     *
     * {@inheritDoc}
     * @see \Seffeng\Basics\Base\Controller::responseException()
     */
    public function responseException($e, array $headers = [])
    {
        return parent::responseException($e, $this->errorClass::mergeHeaders($headers));
    }
}
