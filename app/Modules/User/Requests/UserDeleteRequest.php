<?php

namespace App\Modules\User\Requests;

use App\Common\Base\FormRequest;
use Seffeng\LaravelHelpers\Helpers\Arr;
/**
 *
 * @author zxf
 * @date    2020年12月24日
 * @property int $id
 */
class UserDeleteRequest extends FormRequest
{
    /**
     *
     * @var array
     */
    protected $fillable = ['id'];

    /**
     *
     * {@inheritDoc}
     * @see \Seffeng\Basics\Base\FormRequest::rules()
     */
    public function rules()
    {
        return [
            'id' => 'required|integer',
        ];
    }

    /**
     *
     * {@inheritDoc}
     * @see \App\Common\Base\FormRequest::messages()
     */
    public function messages()
    {
        return Arr::merge(parent::messages(), [
        ]);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Seffeng\Basics\Base\FormRequest::attributes()
     */
    public function attributes()
    {
        return [
            'id' => 'ID',
        ];
    }
}
