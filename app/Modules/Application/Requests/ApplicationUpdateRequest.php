<?php

namespace App\Modules\Application\Requests;

use App\Common\Base\FormRequest;
use App\Common\Constants\DeleteConst;
use Illuminate\Validation\Rule;
use App\Modules\Application\Models\Application;

class ApplicationUpdateRequest extends FormRequest
{
    /**
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'domain', 'allowIp', 'denyIp', 'description'];

    /**
     *
     * {@inheritDoc}
     * @see \App\Common\Base\FormRequest::rules()
     */
    public function rules()
    {
        return [
            'id' => [
                'required',
                Rule::exists((new Application())->getTable())
            ],
            'name' => [
                'required',
                Rule::unique((new Application())->getTable())->where(function ($query) {
                    return $query->where('id', '<>', $this->getFillItems('id'))->where((new Application())->getDeletedAtColumn(), DeleteConst::NOT);
                })
            ],
            'domain' => [
                'nullable',
                'string'
            ],
            'allowIp' => [
                'nullable',
                'string'
            ],
            'denyIp' => [
                'nullable',
                'string'
            ],
            'description' => [
                'nullable',
                'string'
            ]
        ];
    }

    /**
     *
     * {@inheritDoc}
     * @see \App\Common\Base\FormRequest::messages()
     */
    public function messages()
    {
        return array_merge(parent::messages(), [
        ]);
    }

    /**
     *
     * {@inheritDoc}
     * @see \App\Common\Base\FormRequest::attributes()
     */
    public function attributes()
    {
        return [
            'id' => 'ID',
            'name' => '应用名称',
            'domain' => '域名',
            'allowIp' => '允许IP',
            'denyIp' => '禁止IP',
            'description' => '描述'
        ];
    }
}
