<?php

namespace App\Modules\Admin\Requests;

use App\Common\Base\FormRequest;
/**
 *
 * @author zxf
 * @date    2019年10月29日
 * @property int $id
 * @property string $phone
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
