<?php

namespace App\Modules\User\Requests;

use App\Common\Base\FormRequest;
/**
 *
 * @author zxf
 * @date   2026-08-27
 * @property int $id
 * @property string $phone
 */
class UserSearchRequest extends FormRequest
{
    /**
     *
     * @var array
     */
    protected  $fillable = ['id', 'username', 'startAt', 'endAt', 'statusId', 'orderBy'];

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
