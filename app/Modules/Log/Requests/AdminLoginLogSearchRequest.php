<?php
namespace App\Modules\Log\Requests;

use App\Common\Base\FormRequest;
/**
 *
 * @author zxf
 * @date   2026-08-27
 * @property int $adminId
 * @property string $username
 * @property int $statusId
 * @property int $typeId
 * @property int $fromId
 */
class AdminLoginLogSearchRequest extends FormRequest
{
    /**
     *
     * @var array
     */
    protected  $fillable = ['id', 'adminId', 'username', 'statusId', 'typeId', 'fromId', 'startDate', 'endDate', 'orderBy'];

    /**
     *
     * {@inheritDoc}
     * @see \Seffeng\Basics\Base\FormRequest::fetchSortKeyItems()
     */
    protected function fetchSortKeyItems()
    {
        return [
            'id' => 'id',
            'createDate' => 'created_at'
        ];
    }
}
