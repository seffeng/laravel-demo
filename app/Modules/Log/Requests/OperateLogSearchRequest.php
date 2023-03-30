<?php
namespace App\Modules\Log\Requests;

use App\Common\Base\FormRequest;
/**
 *
 * @author zxf
 * @date    2020年12月10日
 * @property int $statusId
 * @property int $typeId
 * @property int $fromId
 */
class OperateLogSearchRequest extends FormRequest
{
    /**
     *
     * @var array
     */
    protected  $fillable = ['id', 'statusId', 'typeId', 'fromId', 'resId', 'moduleId', 'operatorId', 'username', 'startAt', 'endAt', 'orderBy'];

    /**
     *
     * {@inheritDoc}
     * @see \Seffeng\Basics\Base\FormRequest::fetchSortKeyItems()
     */
    protected function fetchSortKeyItems()
    {
        return [
            'id' => 'id',
            'createdAt' => 'created_at'
        ];
    }
}
