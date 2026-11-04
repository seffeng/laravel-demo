<?php

namespace App\Modules\Application\Requests;

use App\Common\Base\FormRequest;
use Illuminate\Validation\Rule;
use App\Modules\Application\Models\Application;

class ApplicationStatusRequest extends FormRequest
{
    /**
     *
     * @var array
     */
    protected $fillable = ['id'];

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
            'id' => 'ID'
        ];
    }
}
