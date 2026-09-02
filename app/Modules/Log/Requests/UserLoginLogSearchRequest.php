<?php
namespace App\Modules\Log\Requests;

use App\Common\Base\FormRequest;
/**
 *
 * @author zxf
 * @date   2026-08-27
 * @property int $userId
 * @property string $username
 * @property int $statusId
 * @property int $typeId
 * @property int $fromId
 */
class UserLoginLogSearchRequest extends FormRequest
{
    /**
     *
     * @var array
     */
    protected  $fillable = ['id', 'userId', 'username', 'statusId', 'typeId', 'fromId', 'startAt', 'endAt', 'orderBy'];

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
