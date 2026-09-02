<?php

namespace App\Common\Constants;

/**
 * 类型常量
 * @author zxf
 * @date   2026-08-27
 */
class TypeConst extends \Seffeng\Basics\Constants\TypeConst
{
    /**
     * 登录
     * @var int
     */
    const LOG_LOGIN = 100;
    /**
     * 登出
     * @var int
     */
    const LOG_LOGOUT = 101;

    /**
     * 添加
     * @var int
     */
    const LOG_CREATE = 102;
    /**
     * 修改
     * @var int
     */
    const LOG_UPDATE = 103;
    /**
     * 删除
     * @var int
     */
    const LOG_DELETE = 104;
    /**
     * 解锁
     * @var int
     */
    const LOG_UNLOCK = 105;
    /**
     * 锁定
     * @var int
     */
    const LOG_LOCK = 106;
    /**
     * 启用
     * @var int
     */
    const LOG_ON = 107;
    /**
     * 禁用
     * @var int
     */
    const LOG_OFF = 108;
}
