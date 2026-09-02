<?php

namespace App\Modules\Log\Requests;

use App\Common\Base\FormRequest;

/**
 *
 * @author zxf
 * @date   2026-09-01
 */
class OperateLogCreateRequest extends FormRequest
{
    /**
     *
     * @var array
     */
    protected  $fillable = ['resId', 'statusId', 'typeId', 'fromId', 'moduleId', 'content', 'detail', 'operatorId', 'operatorIp'];
}
