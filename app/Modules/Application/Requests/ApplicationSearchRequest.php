<?php

namespace App\Modules\Application\Requests;

use App\Common\Base\FormRequest;

class ApplicationSearchRequest extends FormRequest
{
    /**
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'appKey', 'statusId', 'startAt', 'endAt', 'orderBy'];

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
