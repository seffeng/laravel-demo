<?php

namespace App\Modules\Admin\Requests;

use App\Common\Base\FormRequest;
/**
 *
 * @author zxf
 * @date    2026-08-27
 * @property int $id
 * @property string $username
 * @property int $statusId
 * @property string $startAt
 * @property string $endAt
 * @property string $orderBy
 */
class AdminSearchRequest extends FormRequest
{
    /**
     *
     * @var array
     */
    protected  $fillable = ['id', 'username', 'statusId', 'startAt', 'endAt', 'orderBy'];

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
